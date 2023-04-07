<?php

namespace App\Models;

use App\Utils\UsefulFunctions;
use PDOException;

class SaleModel extends ModelBase
{
    private ProductTypeModel $productTypeModel;
    private ProductModel $productModel;
    private UsefulFunctions $usefulFunctions;
    public function __construct()
    {
        parent::__construct();
        $productTypeModel = new ProductTypeModel();
        $productModel = new ProductModel();
        $usefulFunctions = new UsefulFunctions();
        $this->productTypeModel = $productTypeModel;
        $this->productModel = $productModel;
        $this->usefulFunctions = $usefulFunctions;
    }

    public function listSales()
    {
        try {
            $vendas = $this->readAll(
                'products_sales'
            );
        }catch (PDOException $exception){
            return $exception->getMessage();
        }
        return $vendas;
    }

    public function startSales()
    {
        $dados["date"] = date('Y-m-d');
        $dados['amount_sales'] = 0;
        $dados['amount_taxes'] = 0;

        return $this->insert(
            'sales',
            ":amount_sales, :amount_taxes, :date",
            $dados
        );
    }

    public function executeSale(array $dados, $saleId)
    {
        $lastInsert = 0;
        $amountSales = 0;
        $amountTaxes = 0;
        $statusExecute = 0;
        $itemsSale = [];

        try {
            foreach ($dados as $dado){
                $unitaryValue = $dado['unitary_value'];
                $quantity = $dado['quantity'];
                $amount = $dado['amount'];

                $getTax = $this->calculateProductTax(
                    $dado['product_id'],
                    $quantity, $unitaryValue
                );
                $dado['sale_id'] = $saleId;
                $dado["tax"] = $getTax;
                $inserir = $this->insert(
                    'products_sales',
                    ":sale_id, :product_id, :unitary_value, :quantity, :amount, :tax",
                    $dado
                );
                $amountSales += $amount;
                $amountTaxes += $getTax;
                $lastInsert += $inserir;
            }

            if ($lastInsert > 0) {
                $statusExecute = $this->updateSale($saleId, $amountSales, $amountTaxes);
                $itemsSale['amountSales'] = $amountSales;
                $itemsSale['amountTaxes'] = $amountTaxes;
                $itemsSale['items'] = $dados;
            }

        }catch (\Exception $e){
            return 0;
        }

        return ($statusExecute) ? $this->formatData($itemsSale) : 0;
    }

    protected function calculateProductTax($productId, $quantity, $valueProduct)
    {
        //Pega do tipo de produto
        $getTypeProduct = $this->productModel->searchProduct($productId)[0]["type_id"];
        //Pega os tributos do tipo do produto
        $taxesByProductTypes = $this->productTypeModel->searchProductType($getTypeProduct)[0];

        $calculateIcms = $valueProduct * $quantity * $taxesByProductTypes['icms'];
        $calculatePis = $valueProduct * $quantity * $taxesByProductTypes['pis'];
        $calculateIpi = $valueProduct * $quantity * $taxesByProductTypes['ipi'];

        $totalTaxes = $calculateIcms + $calculatePis + $calculateIpi;

        return $this->usefulFunctions->formatNumberToInsertInDatabase($totalTaxes, 2);

    }

    protected function updateSale($idSale, $amountSales, $amountTaxes)
    {
        try {
            return $this->update(
                'sales', ['amount_sales', 'amount_taxes'],
                [$amountSales, $amountTaxes], 'id', $idSale
            );
        }catch (PDOException $e){
            return $e->errorInfo;
        }
    }

    protected function formatData(array $data)
    {
        $newData = [];
        $list = [];
        $list['amountSales'] = $this->usefulFunctions->formatCurrency($data['amountSales']);
        $list['amountTaxes'] = $this->usefulFunctions->formatCurrency($data['amountTaxes']);

        foreach ($data['items'] as $item){
            $newData['product_id'] = $item['product_id'];
            $newData['product_name'] = $this->productModel->searchProduct($item['product_id'])[0]['product_name'];
            $newData['unitary_value'] = $this->usefulFunctions->formatCurrency($item['unitary_value']);
            $newData['quantity'] = $item['quantity'];
            $newData['amount'] = $this->usefulFunctions->formatCurrency($item['amount']);
            $tax = $this->calculateProductTax($item['product_id'], $item['quantity'], $item['unitary_value']);
            $newData['tax'] = $this->usefulFunctions->formatCurrency($tax);
            $list['items'][] = $newData;
        }

        return $list;
    }

}
