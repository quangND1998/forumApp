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
use Illuminate\Support\Facades\Auth;

class LikeReplie extends Notification implements ShouldBroadcast
{
    use Queueable;
    private $reply;
    private $conversation;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($reply, $conversation)
    {
        $this->reply = $reply;
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
        $url = url('/question/'.$this->conversation->slug.'?replyId='.$this->reply->id);
        return (new MailMessage)
                    ->subject('Like your Reply')
                    ->greeting('Hello!')
                    ->line(Auth::user()->name." Like your Reply on {$this->conversation->title}")
                    ->action('View Conversation', $url)
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */


    /**Broadcast with database  */
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage(
            [
               'data'=> [
                    'action'=>  'Like your Reply on the',
                    'message'=> $this->conversation->title,
                    'slug' => $this->conversation->slug,
                    'owner' => new UserResource(Auth::user()),
                    'readAt' => null,
                    'time_ago' => Carbon::parse(Carbon::now()),
                    'replyId' => $this->reply->id,
               ],
               'read_at' => null,
            ]
        );

    }
    /**Broadcast for no database  */
    // public function toBroadcast($notifiable)
    // {
    //     return new BroadcastMessage(
    //        [
    //                 'action'=>  'Like your Reply',
    //                 'message'=> $this->conversation->title,
    //                 'slug' => $this->conversation->slug,
    //                 'owner' => new UserResource(Auth::user()),
    //                 'readAt' => null,
    //                 'time_ago' => Carbon::parse(Carbon::now()),
    //                 'replyId' => $this->reply->id,
    //            ],
    //     );

    // }

    public function toDatabase($notifiable){
        return [
            'action'=>  'Like your Reply',
            'message'=> $this->conversation->title,
            'slug' => $this->conversation->slug,
            'owner' => new UserResource(Auth::user()),
            'readAt' => null,
            'time_ago' => Carbon::parse(Carbon::now()),
            'replyId' => $this->reply->id,
        ];
    }
}
