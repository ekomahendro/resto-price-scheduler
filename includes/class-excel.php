<?php

if (!defined('ABSPATH')) {
    exit;
}

use PhpOffice\PhpSpreadsheet\IOFactory;

class RPS_Excel
{

    public static function read($file)
    {

        $spreadsheet = IOFactory::load($file);

        $sheet = $spreadsheet->getActiveSheet();

        return $sheet->toArray(null, true, true, true);

    }

}