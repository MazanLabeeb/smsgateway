<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    $inputFileName = 'Book1.xlsx';

    /** Load $inputFileName to a Spreadsheet Object  **/
    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName);
    $data = $spreadsheet->getActiveSheet()->toArray();
    foreach($data as $row){
        $id = $row['0'];
        echo "<br>".$id;
    }
?>