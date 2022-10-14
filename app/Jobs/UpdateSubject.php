<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;
class UpdateSubject implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $subject;
    protected $conversation;
    protected $replie;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($subject , $conversation,$replie)
    {
       $this->subject = $subject;
       $this->conversation = $conversation;
       $this->replie = $replie;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
       
                $this->subject->title =   $this->conversation->title;
              
                if($this->subject->type ==0){
                    $this->subject->body =   $this->conversation->body;
                    $this->subject->path = '/question/'.Str::slug($this->conversation->slug);
                   
        
                }
                else if($this->subject->type ==1){
                    $this->subject->body =   $this->replie->body;
                    $this->subject->path = '/question/'.Str::slug($this->conversation->slug).'?replyId='.$this->replie->id;
                  
        
                }else if($this->subject->type ==2){
                    $this->subject->body =   $this->replie->body;
                    $this->subject->path = '/question/'.Str::slug($this->conversation->slug).'?replyId='.$this->replie->id;
                   
        
                }
                $this->subject->save();
    }
}
