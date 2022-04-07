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
class UpdateActivity implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $conversation;
  

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($conversation)
    {
        $this->conversation = $conversation;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        Subject::create([
            'title' => $this->conversation->title,
            'body' => $this->conversation->body,
            'type' => $this->conversation->type,
            'title' => $this->conversation->title,
            // 'path' => request()->getHost().'/question/'.Str::slug($this->conversation->title),
            'activities_id' => $this->conversation->id
        ]);
    }
}
