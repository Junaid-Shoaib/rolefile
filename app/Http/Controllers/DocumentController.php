<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use App\Models\Document;
use App\Models\Year;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $data = null;
        $rootID = Document::where('year_id',session('year_id'))->where('name',session('year_id'))->first()->id;
        $exeID = Document::where('parent_id',$rootID)->where('name','Execution')->first()->id;

        $exe = Document::where('parent_id',$exeID)->get()->map(function($document){
            return [
                'id' => $document->id,
                'label' => $document->name,
            ];
        })->toArray();

        $fold = Document::where('parent_id',$rootID)->get()->map(function($document) use ($exe) {
            return [
                'id' => $document->id,
                'label' => $document->name,
                'children' => ($document->name == 'Execution')? $exe:null,
            ];
        });

        if($request->input('fold')){
            $data = Document::where('year_id',session('year_id'))->where('parent_id',$request->input('fold'))->get()->map(function($document){
                return [
                    'id' => $document->id,
                    'label' => $document->name,
                    'name' => $document->name,
                    'path' => asset('storage/'.$document->path),
                    'year_id' => $document->year_id,
                    'is_folder' => $document->is_folder,
                    'parent_id' => $document->parent_id,
                ];
            });
            session(['parent_id'=>$request->input('fold')]);
            Inertia::share('parent_id',session('parent_id'));
        }
        else{
            $data = Document::where('parent_id',session('parent_id'))->get()->map(function($document){
                return [
                    'id' => $document->id,
                    'name' => $document->name,
                    'is_folder' => $document->is_folder,
                ];
            });
        }
        return Inertia::render('Documents/Index', [
            'data' => $data,
            'fold' => $fold,
            'show_folder' => ($exeID == $request->input('fold')) ? true : false,
            'show_upload' => (($exeID == $request->input('fold')) || (session('parent_id') == $rootID)) ? false : true,
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
            DB::transaction(function() use($request){
                $folder = Document::where('id',session('parent_id'))->first();
                $year = session('year_id');
                $name = $request->file('avatar')->getClientOriginalName();
                $path = $request->file('avatar')->storeAs('public/'.$folder->path, $name);
    //            $path = Storage::disk('google')->put($name, file_get_contents($request->file('avatar')));
    //            dd($path);
                Document::create([
                    'name' => $name,
                    'path' => $folder->path.'/'.$name,
                    'year_id' => $year,
                    'parent_id' => $folder->id
                ]);
            });
        }
        return Redirect::route('documents')->with('success', 'Document created.');
    }

    public function folder(Request $request)
    {
        if($request->all())
        {
            DB::transaction(function() use($request){
                $parent = session('parent_id');
                $year = session('year_id');
                $name = $request->name;
                Storage::makeDirectory('public/'.$year.'/Execution/'.$name);
                Document::create([
                    'name' => $name,
                    'path' => $year.'/Execution/'.$name,
                    'year_id' => $year,
                    'is_folder' => 1,
                    'parent_id' => $parent,
                ]);
            });
        }
        return Redirect::route('documents')->with('success', 'Folder created.');
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

        return Redirect::route('documents')->with('success', 'Doc updated.');
    }

    public function destroy(Document $document)
    {
        $isFolder = $document->is_folder; 
        DB::transaction(function() use($document){
            if($document->is_folder){
                Storage::deleteDirectory('public/'.$document->path);
            }
            else{
                Storage::delete('public/'.$document->path);
            }
            $document->delete();
        });
        return Redirect::back()->with('success', ($isFolder)?'Folder deleted':'Document deleted.');
    }

    // public function clone(Request $request)
    // {
    //     $year = Year::first()->id;
    //     $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('template.docx');
    //     $templateProcessor->setValue('firstname', 'Sohail');
    //     $templateProcessor->setValue('lastname', 'Saleem');
    //     $templateProcessor->saveAs('storage/'.$year.'/MyWordFile.docx');
    //         // $name = $request->file('avatar')->getClientOriginalName();
    //         // $path = $request->file('avatar')->storeAs('public/'.$year, $name);
    //     Document::create([
    //         'name' => 'MyWordFile.docx',
    //         'path' => 'public/'.$year.'/MyWordFile.docx',
    //         'year_id' => $year,
    //     ]);

    //     return Redirect::route('documents')->with('success', 'Document cloned.');
    // }

    // public function indexx(Request $request)
    // {

        // $request->validate([
        //     'direction' => ['in:asc,desc'],
        //     'field' => ['in:id,name,email'],
        // ]);

        // $query = User::query();

        // if(request('search')){
        //     $query->where('name','LIKE','%'.request('search').'%');
        // }

        // if(request()->has(['field','direction'])){
        //     $query->orderBy(request('field'),request('direction'));
        // }
        
//dd($query);
//$usr = $query->paginate();
//dd($usr);
        // return Inertia::render('Documents/Indexx', [
            // 'docs' => Document::when($request->term, function($query, $term){
            //     $query->where('name', 'LIKE', '%'.$term.'%');
            // })->paginate(),

            // 'users' => $query->paginate(),
            // 'filters' => request()->all(['search','field','direction']), 

            // 'optionss' => [
            //     ['id' => 1,  'label' => 'hello', 'isFolder' => false],
            //     ['id' => 2,  'label' => 'world', 'isFolder' => false],
            //     ['id' => 3,  'label' => 'haha', 'isFolder' => true, 'children' => [
            //         ['id' => 4, 'label' => 'child 1', 'isFolder' => false],
            //         ['id' => 5, 'label' => 'child 2', 'isFolder' => false],
            //     ]],

            // ],

    //         'docopt' => Document::all()->map(function($document){
    //             return [
    //                 'id' => $document->id,
    //                 'label' => $document->name,
    //                 'path' => asset('storage/'.$document->year_id.'/'.$document->name),
    //                 'year_id' => $document->year_id,
    //             ];
    //         }),

    //     ]);
    // }
}
