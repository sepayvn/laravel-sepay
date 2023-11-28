<?php

namespace SePay\SePay\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use SePay\SePay\Datas\SePayWebhookData;

class SePayTopUpSuccessNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public SePayWebhookData $sePayWebhookData)
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(User $user): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(User $user): MailMessage
    {
        return (new MailMessage)
            ->subject(__('Deposit successful!'))
            ->greeting(__('Deposit successful!'))
            ->line(
                view('sepay::emails.sepay-topup-success', ['amount' => $this->sePayWebhookData->transferAmount])
            )
            ->action(__('View TopUp History'), url('/user/billing'))
            ->line(__('Thank you for using our service!'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(User $user): array
    {
        return [
            //
        ];
    }
}
