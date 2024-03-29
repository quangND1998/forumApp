<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use App\Http\Resources\UserResource;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request): array
    {
        $user = $request->user();
        if($user){
            $roles[] =$user->roles;
        }
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $user ?  new UserResource($user) :  $user,
                // 'roles'=>  Auth::user()->roles,
                'can' =>$user ? collect($roles)->mapWithKeys(function ($item, $key) {
                    return [$item['name_role'] => true];
                }) : [],
                'token' =>$user && $request->session()->has('user-'.$user->id)?  $request->session()->get('user-'.$user->id):null,

                // 'roles' => $request->user() ? $request->user()->getRolesArray() : [],
                // 'owner' => $request->user() ? User::find($request->user()['created_byId']) : null
            ],
            'flash' => function () use ($request) {
                return [
                    'success' => $request->session()->get('success'),
                    'warning' => $request->session()->get('warning')

                ];
            },
            'notifications'=> $user ? $user->unreadNotifications :[]
        ]);
    }
}
