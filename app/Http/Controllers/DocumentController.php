<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use App\Models\Document;
use App\Models\Year;
use App\Models\User;
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
                'path' => asset('storage/'.$document->year_id.'/'.$document->name),
                // 'path' => asset($document->path),
                'year_id' => $document->year_id,
                'read_only' => true,

            ];
        });
//dd($data);
        return Inertia::render('Documents/Index', [
            'data' => $data,
            ]);
    }

    public function indexx(Request $request)
    {

        $request->validate([
            'direction' => ['in:asc,desc'],
            'field' => ['in:id,name,email'],
        ]);

        $query = User::query();

        if(request('search')){
            $query->where('name','LIKE','%'.request('search').'%');
        }

        if(request()->has(['field','direction'])){
            $query->orderBy(request('field'),request('direction'));
        }
        
//dd($query);
$usr = $query->paginate();
//dd($usr);
        return Inertia::render('Documents/Indexx', [
            'docs' => Document::when($request->term, function($query, $term){
                $query->where('name', 'LIKE', '%'.$term.'%');
            })->paginate(),

            'users' => $query->paginate(),
            'filters' => request()->all(['search','field','direction']), 
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
            $name = $request->file('avatar')->getClientOriginalName();
//            $extension = $request->file('avatar')->extension();
            $path = $request->file('avatar')->storeAs('public/'.$year, $name);
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

    public function clone(Request $request)
    {
            $year = Year::first()->id;
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('template.docx');
        $templateProcessor->setValue('firstname', 'Saleena');
        $templateProcessor->setValue('lastname', 'Sohail');
        $templateProcessor->saveAs('storage/'.$year.'/MyWordFile.docx');
            // $name = $request->file('avatar')->getClientOriginalName();
            // $path = $request->file('avatar')->storeAs('public/'.$year, $name);
        Document::create([
            'name' => 'MyWordFile.docx',
            'path' => 'public/'.$year.'/MyWordFile.docx',
            'year_id' => $year,
        ]);

        return Redirect::route('documents')->with('success', 'Document cloned.');
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
