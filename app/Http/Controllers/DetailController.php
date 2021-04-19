<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use App\Models\Detail;
use App\Models\Year;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class DetailController extends Controller
{
    public function index(Request $request)
    {
        $data = Detail::all()->map(function($detail){
            return [
                'id' => $detail->id,
                'date' => $detail->date,
                'voucher' => $detail->voucher,
                'particular' => $detail->particular,
                'amount' => $detail->amount,
                'cols' => $detail->cols,
                'account_id' =>$detail->account_id,
            ];
        });
//dd($data);
        return Inertia::render('Details/Index', [
            'data' => $data,
            ]);
    }

    public function create()
    {
        return Inertia::render('Details/Create');
    }

    public function store(Request $request)
    {
        if($request->all())
        {
//            $path = $request->file('avatar');
//            dd($path->path());
            $year = Year::first()->id;
            $name = $request->file('avatar')->getClientOriginalName();
//            $extension = $request->file('avatar')->extension();
            $path = $request->file('avatar')->storeAs('public/'.$year, $name);
 //           dd($path);
        Detail::create([
            'name' => $name,
            'path' => $path,
            'year_id' => $year,
        ]);

        }

            //        Post::create($request->all());
        return Redirect::route('details')->with('success', 'Document created.');
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
