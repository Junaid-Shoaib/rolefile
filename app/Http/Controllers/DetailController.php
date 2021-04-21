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
//        dd($request->all());
        Detail::create([
            'date' => $request->input('date'),
            'voucher' => $request->input('voucher'),
            'amount' => $request->input('amount'),
            'account_id' => $request->input('account_id'),
            'particular' => $request->input('particular'),
            'cols' => $request->input('cols'),
        ]);

        return Redirect::route('details')->with('success', 'Detail created.');
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
