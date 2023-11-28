<?php

namespace SePay\SePay\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Cache\LockTimeoutException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use SePay\SePay\Datas\SePayWebhookData;
use SePay\SePay\Models\SePayTransaction;
use SePay\SePay\Notifications\SePayTopUpSuccessNotification;

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
                SePayTransaction::query()->whereId($id)->exists(),
                ValidationException::withMessages(['message' => ['transaction này đã thực hiện']])
            );

            // Lấy ra F.... là id user
            preg_match('/\bF([0-9])+/', $sePayWebhookData->content, $matches);
            throw_if(! isset($matches[0]), ValidationException::withMessages(['message' => ['không tìm thấy F....']]));

            // Lấy user id ex:100692
            $userId = Str::replace('F', '', $matches[0]);
            $user = User::query()->where('id', $userId)->firstOrFail();

            $model = new SePayTransaction();
            $model->gateway = $sePayWebhookData->gateway;
            $model->transactionDate = $sePayWebhookData->transactionDate;
            $model->accountNumber = $sePayWebhookData->accountNumber;
            $model->subAccount = $sePayWebhookData->subAccount;
            $model->code = $sePayWebhookData->code;
            $model->content = $sePayWebhookData->content;
            $model->transferType = $sePayWebhookData->transferType;
            $model->description = $sePayWebhookData->description;
            $model->transferAmount = $sePayWebhookData->transferAmount;
            $model->referenceCode = $sePayWebhookData->referenceCode;
            $model->save();

            $user->notify(new SePayTopUpSuccessNotification($model->transferAmount));

            return response()->noContent();
        } catch (LockTimeoutException) {
            return response()->noContent(400);
        } finally {
            $lock?->release();
        }
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
