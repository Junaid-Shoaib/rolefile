<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $data = User::all()->map(function($user){
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'can' => [
                    'edit_articles' => $user->can('edit articles'),
                ],
            ];
        });
//dd($data);
        return Inertia::render('Users/Index', [
            'hello' => 'world',
            'data' => $data,
            'can' => auth()->user()->can('publish articles'),
            ]);
    }

    public function create()
    {
        return Inertia::render('Users/Create');
    }

    public function store()
    {
        User::create(
            Request::validate([
            'title' => ['required', 'max:30'],
            'body' => ['required'],
            ])
        );
            //        Post::create($request->all());
        return Redirect::route('users')->with('success', 'User created.');
    }

    public function show(User $user)
    {
        //
    }

    public function edit(User $user)
    {
        return Inertia::render('Users/Edit', [
            'user' => [
                'id' => $user->id,
                'title' => $user->title,
                'body' => $user->body,
            ],
        ]);
    }

    public function update(User $user)
    {
        $user->update(
            Request::validate([
            'title' => ['required', 'max:30'],
            'body' => ['required'],
            ])
        );

        return Redirect::route('users')->with('success', 'User updated.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return Redirect::back()->with('success', 'User deleted.');
    }

}
