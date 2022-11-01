<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;
use App\Http\Resources\UserResource;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
class NewReplieForReply extends Notification implements ShouldBroadcast
{
    use Queueable;
  
    private $replie;
    private $conversation;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($replie,$conversation)
    {
      
        $this->replie = $replie;
        $this->conversation = $conversation;
    }


    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        // return ['broadcast'];
        return ['broadcast','database'];
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
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    /**Broadcast no database  */
    // public function toBroadcast($notifiable)
    // {
    //     return new BroadcastMessage([
    //         'action'=>  'Replied your comment',
    //         'message'=> $this->conversation->title,
    //         'slug' => $this->conversation->slug,
    //         'owner' => new UserResource($this->replie->user),
    //         'readAt' => null,
    //         'time_ago' => Carbon::parse($this->replie->created_at),
    //         'replyId' => $this->replie->id,
    //     ]);
    // }

    /**Broadcast with database  */
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage(
            [
            'data'=> [
                'action'=>  'Replied your comment',
                'message'=> $this->conversation->title,
                'slug' => $this->conversation->slug,
                'owner' => new UserResource($this->replie->user),
                'readAt' => null,
                'time_ago' => Carbon::parse($this->replie->created_at),
                'replyId' => $this->replie->id,
            ],
            'read_at' => null,
            ]
        );

    }
    

    public function toDatabase($notifiable){
        return [
            'action'=>  'Replied your comment',
            'message'=> $this->conversation->title,
            'slug' => $this->conversation->slug,
            'owner' => new UserResource($this->replie->user),
            'readAt' => null,
            'time_ago' => Carbon::parse($this->replie->created_at),
            'replyId' => $this->replie->id,
        ];
    }
    

}
