<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request as Req;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use App\Models\Year;
use App\Models\Company;
use App\Models\Document;
use App\Models\Setting;

class YearController extends Controller
{
    public function index()
    {
        return Inertia::render('Years/Index', [
            'data' => Year::where('company_id',session('company_id'))->get(),
            'companies' => Company::all()
            ->map(function($company){
                return [
                'id' => $company->id,
                'name' => $company->name,
                ];
            }), 
        ]);
    }

    public function create()
    {
        return Inertia::render('Years/Create');
    }

    public function store(Req $request)
    {
//        dd($request->all());
        Request::validate([
            'begin' => ['required','date'],
            'end' => ['required','date'],
        ]);

        DB::transaction(function() {
            $year = Year::create([
                'begin' => Request::input('begin'),
                'end' => Request::input('end'),
                'company_id' => session('company_id'),
            ]);

            Storage::makeDirectory('public/'.$year->id);

            $root = Document::create([
                'name' => $year->id,
                'path' => $year->id,
                'year_id' => $year->id,
                'is_folder' => 1,
                'parent_id' => null,
            ]);

            $folders = [
                'Planning',
                'Execution',
                'Completion',
                'Miscellaneous',
            ];

            // $heads = [
                // 'Fixed Assets',
                // 'Long Term Deposits',
                // 'Stock in Trade',
                // 'Trade Debts',
                // 'Deposits & Prepayments',
                // 'Loans, Advances and Other Receivables',
                // 'Cash and Bank Balances',
                // 'Share Capital',
                // 'Reserves',
                // 'Long Term Loans',
                // 'Deferred Liabilities',
                // 'Trade Payables',
                // 'Short Term Borrowings',
                // 'Loans, Advances and Other Payables',
                // 'Revenue',
                // 'Direct Costs',
                // 'Administrative and Genernal Expenses',
                // 'Selling and Distribution Expenses',
                // 'Other Income',
                // 'Financial Charges',
                // 'Other Operating Charges',
                // 'Taxation',
            // ];

            for($i=0;$i<count($folders);$i++){
                Storage::makeDirectory('public/'.$year->id.'/'.$folders[$i]);
                $folder = Document::create([
                    'name' => $folders[$i],
                    'path' => $year->id.'/'.$folders[$i],
                    'year_id' => $year->id,
                    'is_folder' => 1,
                    'parent_id' => $root->id,
                    ]);
                // if($folder->name == 'Execution'){
                //     for($j=0;$j<count($heads);$j++){
                //         Storage::makeDirectory('public/'.$year->id.'/Execution/'.$heads[$j]);
                //         Document::create([
                //             'name' => $heads[$j],
                //             'path' => $year->id.'/Execution/'.$heads[$j],
                //             'year_id' => $year->id,
                //             'is_folder' => 1,
                //             'parent_id' => $folder->id,
                //             ]);
                //     }
                // }
            }

            if(!Auth::user()->settings()->where('key','active_year')->first()){
                Setting::create([
                        'key' => 'active_year',
                        'value' => $year->id,
                        'user_id' => Auth::user()->id,
                    ]);
                }
            else {
                $active_yr = Setting::where('user_id',Auth::user()->id)->where('key','active_year')->first();
                $active_yr->value = $year->id;
                $active_yr->save();
            }
            session(['parent_id'=>$root->id]);
            session(['year_id' => $year->id]);
        });

        return Redirect::route('years')->with('success', 'Year created.');
    }

    public function show($id)
    {
        //
    }

    public function edit(Year $year)
    {
        return Inertia::render('Years/Edit', [
            'year' => [
                'id' => $year->id,
                'begin' => $year->begin,
                'end' => $year->end,
                'company_id' => $year->company_id,
            ],
        ]);
    }

    public function update(Req $request, Year $year)
    {
        Request::validate([
            'begin' => ['required'],
            'end' => ['required'],
        ]);

        $year->begin = Request::input('begin');
        $year->end = Request::input('end');
        $year->save();

        return Redirect::route('years')->with('success', 'Year updated.');
    }

    public function destroy(Year $year)
    {
        $year->delete();
        return Redirect::back()->with('success', 'Year deleted.');
    }
}
