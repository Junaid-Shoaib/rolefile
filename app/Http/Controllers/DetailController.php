<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use App\Models\Detail;
use App\Models\Year;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class DetailController extends Controller
{
    public function index(Request $request)
    {
        $reader = ReaderEntityFactory::createCSVReader();
//        $reader = ReaderEntityFactory::createReaderFromFile('generic.csv');
        $reader->open('generic.csv');
//        $reader->setFieldDelimiter(',');
//        $reader->open('generic.csv');

        $col1 = [];
        $col2 = [];

        foreach ($reader->getSheetIterator() as $sheet) {
            foreach ($sheet->getRowIterator() as $rowIndex => $row) {
                $col1[$rowIndex] = (string) $row->getCellAtIndex(0);
                $col2[$rowIndex] = (string) $row->getCellAtIndex(1);
            }
        }
//        dd($col2);
        
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
            'col1' => $col1,
            'col2' => $col2,
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

    public function show(Detail $detail)
    {
        //
    }

    public function edit(Detail $detail)
    {
    }

    public function update(Detail $detail)
    {

        return Redirect::route('details')->with('success', 'Detail updated.');
    }

    public function destroy(Detail $detail)
    {
        $detail->delete();
        return Redirect::back()->with('success', 'Detail deleted.');
    }
   
}
