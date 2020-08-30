<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class InvoicePaid extends Notification
{
    use Queueable;

    protected $notification;
    protected $channel = null;




    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($ntfChannel, $msg)
    {
        $this->channel = $ntfChannel;
        $this->notification = $msg;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array)
     */
    public function via($notifiable)
    {
        if (!$this->channel){
            throw new \Exception('Sending a message failed. No channel provided.');
        }
        return is_array($this->channel) ? $this->channel : [$this->channel];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->error()
                    ->line('This message about your purchases')
                    ->line('Name - ' . $this->notification)
                    ->line('Thank you for using our application!');
    }

    public function toNexmo($notifiable){
        try {
            return (new NexmoMessage)->content('This message about your purchase. ' . 'Name - ' . $this->notification);
        } catch (\Exception $e) {
            Log::error('SMS message failed');
        }
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'data' => $this->notification
        ];
    }
}
