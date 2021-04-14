<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use Inertia\Inertia;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $data = Document::all()->map(function($document){
            return [
                'id' => $document->id,
                'name' => $document->name,
                'path' => $document->path,
                'year_id' => $document->year_id,
                'read_only' => true,

            ];
        });
//dd($data);
        return Inertia::render('Documents/Index', [
            'data' => $data,
            ]);
    }

    public function create()
    {
        return Inertia::render('Documents/Create');
    }

    public function store()
    {
        Document::create(
            Request::validate([
            'name' => ['required', 'max:30'],
            'path' => ['required'],
            'year_id' => 1,
            ])
        );
            //        Post::create($request->all());
        return Redirect::route('users')->with('success', 'Document created.');
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
