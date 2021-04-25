<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use App\Models\Balance;

class Gen extends Controller
{
    public function __invoke(Request $request)
    {
        $out = new \Symfony\Component\Console\Output\ConsoleOutput();
        $out->writeln("Hello world");
        $spreadsheet = new Spreadsheet();

        $colArray = ['C:C','D:D'];
        foreach ($colArray as $key=>$col) {
            $spreadsheet->getActiveSheet()->getStyle($col)->getNumberFormat()
            ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        }

        $spreadsheet->getActiveSheet()->getStyle('A3:D3')->applyFromArray(
            array(
               'fill' => array(
                   'fillType' => Fill::FILL_SOLID,
                   'color' => array('rgb' => '484848' )
               ),
               'font'  => array(
                   'bold'  =>  true,
                   'color' => array('rgb' => 'FFFFFF')
               ),
               'alignment' => array(
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    'wrapText' => true,
               ),
            )
          );

        $rowArray = ['CODE', 'ACCOUNT NAME', 'CLOSING', 'OPENING'];
        $spreadsheet->getActiveSheet()->fromArray($rowArray, NULL, 'A3');
        
        $widthArray = ['20','50','30','30'];
        foreach (range('A','D') as $key=>$col) {
            $spreadsheet->getActiveSheet()->getColumnDimension($col)->setWidth($widthArray[$key]);  
        }

        $data = \App\Models\Balance::all()
                ->filter(function ($bal){
                    return $bal->account->group->type->name == 'Equity';
                })
                ->map(function ($bal){
                    return [
                        'code' => $bal->account->number,
                        'account' => $bal->account->name,
                        'closing' => (floatval($bal->cl_debit)>0.0)? floatval($bal->cl_debit) : floatval($bal->cl_credit),
                        'opening' => (floatval($bal->op_debit)>0.0)? floatval($bal->op_debit) : floatval($bal->op_credit),
                    ];
                }) 
              ->toArray();

        $cnt=count($data);

        $spreadsheet->getActiveSheet()->fromArray($data, NULL, 'A4');

        $spreadsheet->createSheet();

        $spreadsheet->getSheet(1)->fromArray($data, NULL, 'A4');
        
        $writer = new Xlsx($spreadsheet);
        $writer->save('storage/top.xlsx');
    }
}
