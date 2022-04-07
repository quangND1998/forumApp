<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;
use App\Models\Subject;
class ListenUserAcivity implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $conversation;
    protected $activity;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($conversation, $activity)
    {
        $this->conversation = $conversation;
        $this->activity = $activity;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        
        $subject =Subject::create([
            'title' => $this->conversation->title,
            'body' => $this->conversation->body,
            'type' => $this->activity->type,
            
            'activities_id' => $this->activity->id
        ]);
        if($this->activity->type ==0){
            $subject->path = '/question/'.Str::slug($this->conversation->slug);
            $subject->save();

        }
        
    }
}
