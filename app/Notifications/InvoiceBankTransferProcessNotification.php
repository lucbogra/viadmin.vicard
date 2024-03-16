<?php

namespace App\Notifications;

use Carbon\Carbon;
use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class InvoiceBankTransferProcessNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(private Invoice $invoice)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $period = Carbon::parse("{$this->invoice->period}-01")->format("M, Y");
        $status = $this->invoice->status == 'paid' ? 'accepted' : 'rejected';

        return [
            'invoice_id' => $this->invoice->id,
            'card_id'    => $this->invoice->card->id,
            'period'     => $period,
            'message'    => 'Payment for receipt ' . $this->invoice->card->card_number . ' of month ' . $period . ' has been ' . $status
        ];
    }
}
