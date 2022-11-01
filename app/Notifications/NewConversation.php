<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Support\Str;
use App\Http\Resources\UserResource;
use Illuminate\Support\Carbon;
class NewConversation extends Notification implements ShouldBroadcast
{
    use Queueable;
    private $conversation;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($conversation)
    {
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
        //return ['broadcast'];
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
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
    /**Broadcast for no database  */
    // public function toBroadcast($notifiable)
    // {
    //     return new BroadcastMessage([
    //         'action'=>  'New conversation',
    //         'message'=> $this->conversation->title,
    //         'slug' => $this->conversation->slug,
    //         'owner' => new UserResource($this->conversation->user),
    //         'readAt' => null,
    //         'time_ago' => Carbon::parse($this->conversation->created_at),
    //     ]);
    // }

     /**Broadcast with database  */
     public function toBroadcast($notifiable)
     {
         return new BroadcastMessage(
             [
                'data'=> [
                    'action'=>  'New conversation',
                    'message'=> $this->conversation->title,
                    'slug' => $this->conversation->slug,
                    'owner' => new UserResource($this->conversation->user),
                    'readAt' => null,
                    'time_ago' => Carbon::parse($this->conversation->created_at),
                ],
                'read_at' => null,
             ]
         );
 
     }
    public function toDatabase($notifiable){
        return [
            'action'=>  'New conversation',
            'message'=> $this->conversation->title,
            'slug' => $this->conversation->slug,
            'owner' => new UserResource($this->conversation->user),
            'readAt' => null,
            'time_ago' => Carbon::parse($this->conversation->created_at),
        ];
    }


    
}
