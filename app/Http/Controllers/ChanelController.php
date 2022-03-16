<?php

namespace App\Http\Controllers;

use App\Models\Chanels;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class ChanelController extends Controller
{
    public function index()
    {
        if (Gate::allows(config('constants.USER_PERMISSION'))) {
            $chanels = Chanels::get();
            return Inertia::render("Forum/Chanels/Index", compact('chanels'));
        } else {
            $erros = "You don't have permission !!";
            return Inertia::render('Erros/401', ['erros' => $erros]);
        }
    }


    public function store(Request $request)
    {
        if (Gate::allows(config('constants.USER_PERMISSION'))) {
            $this->validate(
                $request,
                [
                    'title' => 'required|unique:chanels,title,',
                    'color' => 'required',
     
                ]
            );
            Chanels::create([
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'color' => $request->color
            ]);
            return back()->with('success', 'Create category tour successful');
        } else {
            $erros = "You don't have permission !!";
            return Inertia::render('Erros/401', ['erros' => $erros]);
        }
    }

    public function update(Request $request, $id)
    {
        if (Gate::allows(config('constants.USER_PERMISSION'))) {
            $chanel = Chanels::findOrFail($id);

            $this->validate(
                $request,
                [
                    'title' => 'required|unique:chanels,title,' . $chanel->id,
                    'color' => 'required'
                ]
            );
            $chanel->update([
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'color' => $request->color
            ]);
            return redirect()->back()->with('success', 'Update category tour successful');
        } else {
            $erros = "You don't have permission !!";
            return Inertia::render('Erros/401', ['erros' => $erros]);
        }
    }

    public function delete(Request $request, $id)
    {
        if (Gate::allows(config('constants.USER_PERMISSION'))) {
            $chanel = Chanels::findOrFail($id);

            $chanel->delete();
            return redirect()->back()->with('success', 'Update category tour successful');
        } else {
            $erros = "You don't have permission !!";
            return Inertia::render('Erros/401', ['erros' => $erros]);
        }
    }
}
