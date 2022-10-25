<?php

namespace App\Http\Controllers;

use App\Http\Resources\ChanelResource;
use App\Models\Chanels;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class ChannelController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin_role', ['only' => ['index','store','update','delete']]);
    }
    public function index()
    {
    
            $chanels = Chanels::get();
            return Inertia::render("Forum/Chanels/Index", compact('chanels'));
      
    }


    public function store(Request $request)
    {
        
            $this->validate(
                $request,
                [
                    'title' => 'required|unique:chanels,title,',
                    'description'=> 'required',
                    'color' => 'required',
     
                ]
            );
            Chanels::create([
                'title' => $request->title,
                'description'=> $request->description,
                'slug' => Str::slug($request->title),
                'color' => $request->color
            ]);
            return back()->with('success', 'Create category tour successful');
     
    }

    public function update(Request $request, $id)
    {
      
            $chanel = Chanels::findOrFail($id);

            $this->validate(
                $request,
                [
                    'title' => 'required|unique:chanels,title,' . $chanel->id,
                    'description'=> 'required',
                    'color' => 'required'
                ]
            );
            $chanel->update([
                'title' => $request->title,
                'description'=> $request->description,
                'slug' => Str::slug($request->title),
                'color' => $request->color
            ]);
            return redirect()->back()->with('success', 'Update category tour successful');
     
    }

    public function delete(Request $request, $id)
    {
        
            $chanel = Chanels::findOrFail($id);

            $chanel->delete();
            return redirect()->back()->with('success', 'Update category tour successful');
     
    }

    public function popularChannels(Request $request){
        // 'user', 'all_replies', 'initalReplies.user', 'initalReplies.replies', 'chanel', 'lastReplie.user'
        // return Chanels::with('lastConversation.user','lastConversation.all_replies','lastConversation.initalReplies.user','lastConversation.initalReplies.replies','lastConversation.lastReplie.user'
        // )->withCount('conversations')->get();
        $channels =ChanelResource::collection(Chanels::withCount('conversations')->with('lastConversation.user','lastConversation.images','lastConversation.videos','lastConversation.chanel','lastConversation.all_replies','lastConversation.initalReplies.user','lastConversation.lastReplie.user','lastConversation.initalReplies.images','lastConversation.initalReplies.videos',
        )->orderBy('conversations_count','desc')->get());  
        return Inertia::render('Forum/Chanels/PopularChannel', compact('channels'));
    }
}
