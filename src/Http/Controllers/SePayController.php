<?php

namespace SePay\SePay\Http\Controllers;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;
use SePay\SePay\Datas\SePayWebhookData;

class SePayController extends Controller
{
    /**
     * @return Response|ResponseFactory
     *
     * @throws BindingResolutionException
     */
    public function webhook(Request $request, SePayWebhookData $sePayWebhookData)
    {
        $token = $this->bearerToken($request);

        throw_if(
            config('sepay.webhook_token') && $token !== config('sepay.webhook_token'),
            ValidationException::withMessages(['message' => ['Invalid Token']])
        );

        $id = strval('SePay_'.$sePayWebhookData->id);
        $lock = Cache::lock($id, 30);

        try {
            $lock->block(5);
            // Lock acquired after waiting a maximum of 5 seconds...

            throw_if(
                BankTransaction::query()->whereId($id)->exists(),
                CommonService::throwMessage('transaction này đã thực hiện')
            );
            // Lấy ra F.... là id user
            preg_match('/\bF([0-9])+/', $sePayWebhookData->content, $matches);
            throw_if(! isset($matches[0]), CommonService::throwMessage('không tìm thấy F....'));
            // Lấy user id ex:100692
            $userId = Str::replace('F', '', $matches[0]);

            $user = User::query()->whereId($userId)->firstOrFail();

            $usdRate = VpsSettings::make()->usd_rate;

            $model = new BankTransaction();
            $model->id = $id;
            $model->user_id = $user->id;
            $model->amount = $sePayWebhookData->transferAmount;
            $model->description = $sePayWebhookData->description ?: '';
            $model->save();

            $user->debit(
                (int) round($model->amount * 100 / $usdRate),
                "Topup from {$sePayWebhookData->gateway}: ".$model->amount.', USD Rate: '.$usdRate,
                [
                    'gateway' => $sePayWebhookData->gateway,
                    'rate' => $usdRate,
                ]
            );

            $user->notify(new SePayTopUpSuccessNotification($model->amount));

            return response()->noContent();
        } catch (LockTimeoutException $e) {
            return response('', 400);
        } finally {
            $lock?->release();
        }

        return response('No lock acquired', 400);
    }

    /**
     * Get the bearer token from the request headers.
     *
     * @return string|null
     */
    private function bearerToken(Request $request)
    {
        $header = $request->header('Authorization', '');

        $position = strrpos($header, 'Apikey ');

        if ($position !== false) {
            $header = substr($header, $position + 7);

            return str_contains($header, ',') ? (strstr($header, ',', true) ?: null) : $header;
        }

        return null;
    }
}
