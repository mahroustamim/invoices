<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CreateInvoice extends Notification
{
    use Queueable;

    protected $invoice_id;

    public function __construct($invoice_id)
    {
        $this->invoice_id = $invoice_id;
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->greeting('مرحبا')
                    ->subject('إضافة فاتورة')
                    ->line('تم إضافة فاتورة جديدة')
                    ->action('عرض الفاتورة', url('InvoicesDetails/' . $this->invoice_id))
                    ->line('شكرا لاستخدامك برنامجنا');
    }

    public function toDatabase($notifiable): array
    {
        return [
            'id' => $this->invoice_id,
            'title' => 'تم إضافة فاتورة جديدة',
            'user' => auth()->user()->name,
        ];
    }
}
