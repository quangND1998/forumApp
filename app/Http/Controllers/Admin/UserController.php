<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Roles;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\User;
use Illuminate\Http\Response;
class UserController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('permission:users_manage', ['only' => ['index', 'store', 'update', 'destroy']]);
    // }
    public function index(Request $request)
    {

        $user = Auth::user();
        $filters = $request->all('term');
        $users = $this->queryUser($user, $request);
        // if ($user->hasPermissionTo('users_manager')) {
        //     $roles = Role::get();
        // }
        $roles = Roles::get();
        return Inertia::render('Admin/User', compact('filters', 'users', 'roles'));
    }

    public function queryUser($user, $request)
    {


       
            return User::with('roles')->where(function ($query) use ($request) {
                $query->where('name', 'LIKE', '%' . $request->term . '%');
                $query->orwhere('email', 'LIKE', '%' . $request->term . '%');
                // $query->orwhere('phone', 'LIKE', '%' . $request->term . '%');
            })->paginate(20)->appends($request->term);
    
    }

    public function store(Request $request)
    {

        $this->validate(
            $request,
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'phone' => 'nullable|unique:users,phone|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
                'roles' => 'required',
            ]
        );

        $user = User::create($request->all());
        $roles = $request->input('roles') ? $request->input('roles') : [];
        $user->roles()->sync($roles);
        $user->created_byId = Auth::user()->id;
        $user->save();
        return back()->with('success', 'Create user successfully');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $this->validate(
            $request,
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'phone' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|unique:users,phone,' . $user->id,
                'roles' => 'required',
            ]
        );

        $user->update($request->all());
        $roles = $request->input('roles') ? $request->input('roles') : [];
        $user->roles()->sync($roles);
        // $user->created_byId = Auth::user()->id;
        $user->save();
        return back()->with('success', 'Update user successfully');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->back()->with('success', "Xóa tài khoản  thành công");
    }
    public function notifications(){
        $user = Auth::user();
        $user->unreadNotifications;
        return $user->unreadNotifications;
    }

    public function markAsRead(){
        $user = Auth::user();
        $user->unreadNotifications->markAsRead();
        return response()->json('successfully', Response::HTTP_OK);
    }

    public function deleteNotifiaction(){
        $user = Auth::user();
        $user->notifications()->delete();
        return back();
    }
}
