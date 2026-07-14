<?php

if (!defined('ABSPATH')) {
    exit;
}

class RPS_Validator
{

    public static function validate(array $row): array
    {

        $result = [
            'status' => 'success',
            'message' => '',
            'new_price' => null
        ];

        $id = intval($row['A']);

        $old_price = floatval($row['E']);

        $new_price = trim($row['G']);

        $type = strtolower(trim($row['H']));

        $value = trim($row['I']);

        if (!$id) {

            $result['status'] = 'error';
            $result['message'] = 'ID kosong';

            return $result;

        }

        $product = wc_get_product($id);

        if (!$product) {

            $result['status'] = 'error';
            $result['message'] = 'Product tidak ditemukan';

            return $result;

        }

        if ($new_price != '' && ($type != '' || $value != '')) {

            $result['status'] = 'error';
            $result['message'] = 'New Price dan Adjustment bersamaan';

            return $result;

        }

        if ($new_price != '') {

            if (!is_numeric($new_price)) {

                $result['status'] = 'error';
                $result['message'] = 'New Price bukan angka';

                return $result;

            }

            $result['new_price'] = $new_price;

            return $result;

        }

        if ($type == '' && $value == '') {

            $result['status'] = 'skip';
            $result['message'] = 'Tidak ada perubahan';

            return $result;

        }

        if (!is_numeric($value)) {

            $result['status'] = 'error';
            $result['message'] = 'Adjustment bukan angka';

            return $result;

        }

        switch ($type) {

            case 'percent':

                $result['new_price'] = $old_price + ($old_price * $value / 100);

                break;

            case 'amount':

                $result['new_price'] = $old_price + $value;

                break;

            default:

                $result['status'] = 'error';
                $result['message'] = 'Adjustment Type salah';

                return $result;

        }

        return $result;

    }

}