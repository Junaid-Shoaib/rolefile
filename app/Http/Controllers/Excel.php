<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use App\Models\Balance;
use App\Models\Group;
use App\Models\Account;
use App\Models\Type;

class Excel extends Controller
{
    public function __invoke(Request $request)
    {
        $reader = ReaderEntityFactory::createXLSXReader();

        $reader->open('tb2.xlsx');

        $out = new \Symfony\Component\Console\Output\ConsoleOutput();
 
        foreach ($reader->getSheetIterator() as $sheet) {
            $i=0;
            $type='';
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
                }
                
                if(strlen($col3)>1){
                    $group = Group::create([
                        'name' => $col3,
                        'type_id' => $type->id,
                        'year_id' => 1,
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

                ++$i;
                if($i==100) break;
            }
            break;
        }

        $reader->close();
	
    }
}

