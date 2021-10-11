<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use App\Models\Balance;
use App\Models\Group;
use App\Models\Account;
use App\Models\Document;
use App\Models\Type;
use Illuminate\Support\Facades\Storage;

class Trial extends Controller
{
    public function __invoke(Request $request)
    {
//        $groups = Group::where('year_id',session('year_id'))->get();

        $reader = ReaderEntityFactory::createXLSXReader();

        $reader->open($request->file('avatar'));

        $out = new \Symfony\Component\Console\Output\ConsoleOutput();
 
        foreach ($reader->getSheetIterator() as $sheet) {
            $i=0;
            $type='';
            $type_doc='';
            $group='';
            foreach ($sheet->getRowIterator() as $rowIndex => $row) {
                $col1 = (string) $row->getCellAtIndex(0);
                $col2 = (string) $row->getCellAtIndex(1);
                $col3 = (string) $row->getCellAtIndex(2);
                $col4 = (string) $row->getCellAtIndex(3);
                $col5 = (string) $row->getCellAtIndex(4);
                $col6 = (string) $row->getCellAtIndex(5);
                $col7 = (string) $row->getCellAtIndex(6);
                $col8 = (string) $row->getCellAtIndex(7);
                $col9 = (string) $row->getCellAtIndex(8);
                $col10 = (string) $row->getCellAtIndex(9);

                if(strlen($col2)>1){
                    $type = Type::create([
                        'name' => $col2,
                    ]);
                    Storage::makeDirectory('public/'.session('year_id').'/Execution/'.$type->name);
                    $type_doc=Document::create([
                        'name' => $type->name,
                        'path' => session('year_id').'/Execution/'.$type->name,
                        'year_id' => session('year_id'),
                        'is_folder' => 1,
                        'parent_id' => Document::where('year_id',session('year_id'))->where('name','Execution')->first()->id,
                    ]);
                }
                
                if(strlen($col3)>1){
                    $group = Group::create([
                        'name' => $col3,
                        'type_id' => $type->id,
                        'year_id' => session('year_id'),
                    ]);
                    Storage::makeDirectory('public/'.session('year_id').'/Execution/'.$type->name.'/'.$group->name);
                    Document::create([
                        'name' => $group->name,
                        'path' => session('year_id').'/Execution/'.$type->name.'/'.$group->name,
                        'year_id' => session('year_id'),
                        'is_folder' => 1,
                        'parent_id' => $type_doc->id,
                    ]);
                }

                if(strlen($col1)>5){
                    $account = Account::create([
                        'number' => $col1,
                        'name' => $col4,
                        'group_id' => $group->id,
                    ]);
                    Balance::create([
                        'account_id' => $account->id,
                        'op_debit' => floatval($col5)? floatval($col5): 0.0, 
                        'op_credit' => floatval($col6)? floatval($col6): 0.0, 
                        't_debit' => floatval($col7)? floatval($col7): 0.0, 
                        't_credit' => floatval($col8)? floatval($col8): 0.0, 
                        'cl_debit' => floatval($col9)? floatval($col9): 0.0, 
                        'cl_credit' => floatval($col10)? floatval($col10): 0.0, 
                    ]);
                }

//                ++$i;
//                if($i==100) break;
            }
//            break;
        }

        $reader->close();
        return Redirect::route('documents')->with('success', 'Upload successful.');
    }
}

