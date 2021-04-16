<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Document;
use App\Models\Year;
use Illuminate\Support\Facades\Storage;
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

    public function store(Request $request)
    {
        if($request->all())
        {
//            $path = $request->file('avatar');
//            dd($path->path());
            $year = Year::first()->id;
            $name = 'myfile'; 
            $extension = $request->file('avatar')->extension();
            $path = $request->file('avatar')->storeAs('public/'.$year, $name.'.'.$extension);
 //           dd($path);
        Document::create([
            'name' => $name,
            'path' => $path,
            'year_id' => $year,
        ]);

        }

            //        Post::create($request->all());
        return Redirect::route('documents')->with('success', 'Document created.');
    }

    public function show(Document $document)
    {
        //
    }

    public function edit(Document $document)
    {
        return Inertia::render('Users/Edit', [
            'user' => [
                'id' => $user->id,
                'title' => $user->title,
                'body' => $user->body,
            ],
        ]);
    }

    public function update(Document $document)
    {
        $document->update(
            Request::validate([
            'title' => ['required', 'max:30'],
            'body' => ['required'],
            ])
        );

        return Redirect::route('documents')->with('success', 'User updated.');
    }

    public function destroy(Document $document)
    {
        $document->delete();
        return Redirect::back()->with('success', 'User deleted.');
    }
}
