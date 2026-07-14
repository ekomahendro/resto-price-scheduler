<?php

if (!defined('ABSPATH')) {
    exit;
}

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class RPS_Export
{

    public function __construct()
    {
        add_action('admin_post_rps_export_excel', [$this, 'export_excel']);
    }

    public function export_excel()
    {

        if (!current_user_can('manage_woocommerce')) {
            wp_die('Access Denied');
        }

        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setTitle('Products');

        $header = [

            'A1' => 'ID',
            'B1' => 'SKU',
            'C1' => 'Product',
            'D1' => 'Category',
            'E1' => 'Regular Price',
            'F1' => 'Sale Price',

            // ===== untuk IMPORT =====
            'G1' => 'New Price',
            'H1' => 'Adjustment Type',
            'I1' => 'Adjustment Value',

            'J1' => 'Stock'

        ];

        foreach ($header as $cell => $text) {
            $sheet->setCellValue($cell, $text);
        }

        $sheet->getStyle('A1:J1')->getFont()->setBold(true);

        $sheet->freezePane('A2');

        $products = wc_get_products([
            'status' => 'publish',
            'limit' => -1,
            'orderby' => 'title',
            'order' => 'ASC'
        ]);

        $row = 2;

        foreach ($products as $product) {

            $cats = wp_get_post_terms(
                $product->get_id(),
                'product_cat',
                ['fields' => 'names']
            );

            $sheet->setCellValue('A' . $row, $product->get_id());
            $sheet->setCellValue('B' . $row, $product->get_sku());
            $sheet->setCellValue('C' . $row, $product->get_name());
            $sheet->setCellValue('D' . $row, implode(', ', $cats));
            $sheet->setCellValue('E' . $row, $product->get_regular_price());
            $sheet->setCellValue('F' . $row, $product->get_sale_price());

            // dikosongkan untuk user isi
            $sheet->setCellValue('G' . $row, '');
            $sheet->setCellValue('H' . $row, '');
            $sheet->setCellValue('I' . $row, '');

            $sheet->setCellValue('J' . $row, $product->get_stock_status());

            $row++;

        }

        foreach (range('A', 'J') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // warna header
        $sheet->getStyle('A1:J1')
            ->getFill()
            ->setFillType(
                \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID
            )
            ->getStartColor()
            ->setARGB('1F4E78');

        $sheet->getStyle('A1:J1')
            ->getFont()
            ->getColor()
            ->setARGB('FFFFFF');

        $filename = 'RPS_Product_' . date('Ymd_His') . '.xlsx';

        while (ob_get_level()) {
            ob_end_clean();
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);

        $writer->save('php://output');

        exit;

    }

}