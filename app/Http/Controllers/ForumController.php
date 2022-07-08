<?php

namespace App\Http\Controllers;

use App\Events\SendMessage;
use Illuminate\Http\Request;
use App\Models\Chanels;
use Inertia\Inertia;
use App\Models\Conversation;
use App\Http\Resources\ConversationResource;
use App\Http\Resources\ProfileResource;
use App\Http\Resources\ReplieResource;
use App\Models\Activities;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Http\Resources\ActivitiesResources;
use App\Models\Replies;

class ForumController extends Controller
{
    public function index(Request $request)
    {
        $category = null;
        $chanels = Chanels::get();
        $category = $request->input('category');
        $chanel = Chanels::with('conversations')->where('title', $category)->first();
        $solved = $request->input('answered');

        if ($chanel !== null && $solved !== null) {

            $conversations = Conversation::with('user', 'all_replies', 'initalReplies.user', 'initalReplies.replies', 'chanel', 'lastReplie')->where('solved', $solved)->where('chanel_id', $chanel->id)->orderBy('created_at', 'desc')->where(function ($query) use ($request) {
                $query->where('title', 'LIKE', '%' . $request->term . '%');
            })->paginate(20)->appends(['term' => $request->term, 'answered' => $request->input('answered')]);
        } elseif ($chanel == null && $solved !== null) {

            $conversations = Conversation::with('user', 'all_replies', 'initalReplies.user', 'initalReplies.replies', 'chanel', 'lastReplie')->where('solved', $solved)->orderBy('created_at', 'desc')->where(function ($query) use ($request) {
                $query->where('title', 'LIKE', '%' . $request->term . '%');
            })->paginate(20)->appends(['term' => $request->term, 'answered' => $request->input('answered')]);
        } elseif ($chanel !== null && $solved == null) {

            $conversations = Conversation::with('user', 'all_replies', 'initalReplies.user', 'initalReplies.replies', 'chanel', 'lastReplie')->where('chanel_id', $chanel->id)->orderBy('created_at', 'desc')->where(function ($query) use ($request) {
                $query->where('title', 'LIKE', '%' . $request->term . '%');
            })->paginate(20)->appends(['term' => $request->term, 'answered' => $request->input('answered')]);
        } else {

            $conversations = Conversation::with('user', 'all_replies', 'initalReplies.user', 'initalReplies.replies', 'chanel', 'lastReplie')->orderBy('created_at', 'desc')->where(function ($query) use ($request) {
                $query->where('title', 'LIKE', '%' . $request->term . '%');
            })->paginate(20)->appends(['term' => $request->term, 'answered' => $request->input('answered')]);
        }

        $conversations = ConversationResource::collection($conversations);

        return Inertia::render('Forum/Index', compact('chanels', 'conversations', 'category', 'solved'));
    }



    public function getSolved(Request $request)
    {
        $category = null;
        $chanels = Chanels::get();
        $category = $request->input('category');

        if ($category == 'all' || $category == null) {
            $conversations = Conversation::with('user', 'all_replies', 'initalReplies.user', 'initalReplies.replies', 'chanel', 'lastReplie')->where('solved', 1)->where(function ($query) use ($request) {
                $query->where('title', 'LIKE', '%' . $request->term . '%');
            })->paginate(20)->appends(['term' => $request->term]);
        } else {
            $chanel = Chanels::findOrFaiL($category);
            $conversations = Conversation::with('user', 'all_replies', 'initalReplies.user', 'initalReplies.replies', 'chanel', 'lastReplie')->where('solved', 1)->where('chanel_id', $chanel->id)->where(function ($query) use ($request) {
                $query->where('title', 'LIKE', '%' . $request->term . '%');
            })->paginate(20)->appends(['term' => $request->term]);
        }



        $conversations = ConversationResource::collection($conversations);

        return Inertia::render('Forum/Solved', compact('chanels', 'conversations', 'category'));
    }

    public function getUnsolved(Request $request)
    {
        $category = null;
        $chanels = Chanels::get();
        $category = $request->input('category');
        $answered = $request->input('answered');
        if ($category == 'all' || $category == null) {
            $conversations = Conversation::with('user', 'all_replies', 'initalReplies.user', 'initalReplies.replies', 'chanel', 'lastReplie')->where('solved', 0)->where(function ($query) use ($request) {
                $query->where('title', 'LIKE', '%' . $request->term . '%');
            })->paginate(20)->appends(['term' => $request->term]);
        } else {
            $chanel = Chanels::findOrFaiL($category);
            $conversations = Conversation::with('user', 'all_replies', 'initalReplies.user', 'initalReplies.replies', 'chanel', 'lastReplie')->where('solved', 0)->where('chanel_id', $chanel->id)->where(function ($query) use ($request) {
                $query->where('title', 'LIKE', '%' . $request->term . '%');
            })->paginate(20)->appends(['term' => $request->term]);
        }



        $conversations = ConversationResource::collection($conversations);

        return Inertia::render('Forum/Solved', compact('chanels', 'conversations', 'category'));
    }

    public function profile($name)
    {

        $user = User::with(['activities.subject', 'activities' => function ($query) {
            $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
        }])->where('name', $name)->first();

        $activities = ActivitiesResources::collection($user->activities)->groupBy('date');
        // $activities= User::with()



        if ($user) {
            $user = new ProfileResource($user);
            return Inertia::render('Profile/Index', compact('user', 'activities'));
        } else {
            $erros = "Not found user !!";
            return Inertia::render('Erros/401', ['erros' => $erros]);
        }
    }

    public function editProfile()
    {
        $user = User::with('replies.conversation', 'conversations.all_replies')->findOrFail(Auth::user()->id);
        // $activities= User::with()
        $total_replies = count(Replies::where('user_id', Auth::user()->id)->get());
        // foreach($user->conversations as $conversation){
        //         $total_replies += count($conversation->all_replies);
        // }
        $total_view = 0;
        foreach ($user->conversations as $conversation) {
            $total_view += $conversation->view;
        }
        // $replies = Replies::where('user_id', $user->id)->get();
        // foreach($replies as $replie){
        //     if($replie->is_inital ==0){
        //         $replie->replie_user = "@".$user->name;
        //         $replie->save();
        //     }
        // }
        if ($user) {
            $user = new ProfileResource($user);
            return Inertia::render('Profile/Edit', compact('user', 'total_replies', 'total_view'));
        } else {
            $erros = "Not found user !!";
            return Inertia::render('Erros/401', ['erros' => $erros]);
        }
    }

    public function saveProfile(Request $request)
    {
        $user = Auth::user();

        $this->validate(
            $request,
            [
                'email' => 'required|name|unique:users,name,' . $user->id,
                'email' => 'required|email|unique:users,email,' . $user->id,
                'country' => 'nullable',
                'address' => 'required',
                'about_you' => 'nullable',
                'avatar' =>  'nullable|mimes:png,jpg,jpeg|max:20000',
            ]
        );

        $public_setting =  'avatar/';

        if (!file_exists($public_setting)) {
            mkdir($public_setting, 0777, true);
        }

        $user = Auth::user();
        $time = time();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->country = $request->country;
        $user->address = $request->address;
        $user->about_you = $request->about_you;
        $user->avatar = $request->hasFile('avatar') ? $this->update_image($request->file('avatar'), $time, $public_setting, $user->avatar) : $user->avatar;
        $user->save();
        return back()->with('success', 'Update successfully');
    }

    public function update_image($file, $name, $middlepath, $attribute)
    {

        $destinationpath = public_path() . "/" . $middlepath;

        $user_id = Auth::user()->id;
        $name = $name . "-" . Str::slug($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();

        if ($attribute == null || file_exists($attribute) == false) {
            $file->move($destinationpath, $name);
            $path = $middlepath . $name;
        } else {
            if (Str::contains($attribute, 'default')) {

                $file->move($destinationpath, $name);
                $path = $middlepath . $name;
            } else {
                unlink($attribute);
                $file->move($destinationpath, $name);
                $path = $middlepath . $name;
            }
        }

        return $path;
    }
    public function send()
    {
        return Inertia::render('Index');
    }

    public function postMessage(Request $request)
    {

        broadcast(new SendMessage($request->message));
        return back();
    }
}
