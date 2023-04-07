<?php

namespace App\Utils;

class UsefulFunctions
{
    public function formatNumberToInsertInDatabase($value, $decimalPlaces)
    {
        $formatNumber = number_format($value, $decimalPlaces, '.');
        return str_replace(',', '', $formatNumber);
    }

    public function formatCurrency($number)
    {
        return number_format($number, 2, ',', '.');
    }

    public function convertPercentage($number)
    {
        return $this->formatNumberToInsertInDatabase($number / 100, 4);
    }

    public function removeComma($number)
    {
        return str_replace(',', '.', $number);
    }

    public function validateProductRequest(array $data): bool
    {
        if (isset($data['product_name']) && !empty($data['product_name']) 
            && isset($data['price']) && !empty($data['price'])
            && isset($data['type_id']) && !empty($data['type_id'])
        ) {
            return true;
        }

        return false;
    }

    public function validateProductTypeRequest(array $data): bool
    {
        if (isset($data['product_type_name']) && !empty($data['product_type_name']) 
            && isset($data['icms']) && !empty($data['icms'])
            && isset($data['pis']) && !empty($data['pis'])
            && isset($data['ipi']) && !empty($data['ipi'])
        ) {
            return true;
        }

        return false;
    }

    public function validateSalesRequest(array $data): bool
    {
        if (isset($data['sales'][0]['product_id']) && !empty($data['sales'][0]['product_id'])
            && isset($data['sales'][0]['unitary_value']) && !empty($data['sales'][0]['unitary_value'])
            && isset($data['sales'][0]['quantity']) && !empty($data['sales'][0]['quantity'])
            && isset($data['sales'][0]['amount']) && !empty($data['sales'][0]['amount'])
        ) {
            return true;
        }

        return false;
    }
}
