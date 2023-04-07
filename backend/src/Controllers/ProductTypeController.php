<?php

namespace App\Controllers;

use App\Models\ProductTypeModel;
use App\Utils\UsefulFunctions;

class ProductTypeController extends Controller
{
    private ProductTypeModel $productTypeModel;
    private UsefulFunctions $usefulFunctions;
    public function __construct()
    {
        parent::__construct();
        $productTypeModel = new ProductTypeModel();
        $usefulFunctions = new UsefulFunctions();
        $this->productTypeModel = $productTypeModel;
        $this->usefulFunctions = $usefulFunctions;
    }

    public function index()
    {
        $productTypes = $this->productTypeModel->listAllTypesOffProducts();
        if (is_array($productTypes)) {
            $response = [];
            (empty($productTypes))
                ? $response = $this->emptyData('GET')
                : $response = $this->success($productTypes, 'GET');
            echo $response;

        }else{
            echo $this->responseFailure('GET');
        }
    }

    public function listTaxes()
    {
        $newArray = [];
        $products = $this->productTypeModel->listProductsWithTaxes();

        if (!empty($products)) {
            foreach ($products as $product) {
                $tipo = $product["produto"];
                if (!array_key_exists($tipo, $newArray)) {
                    $newArray[$tipo] = array(
                        "tributos" => array()
                    );
                }
                $taxe = array(
                    "nome" => $product["nome"],
                    "aliquota" => $product["aliquota"]
                );
                array_push($newArray[$tipo]["tributos"], $taxe);
            }
            echo $this->success($newArray, 'GET');
        }else{
            echo $this->emptyData('GET');
        }
    }

    public function show($id)
    {
        $productType = $this->productTypeModel->searchProductType($id);
        if (is_array($productType)) {
            $response = [];
            (empty($productType))
                ? $response = $this->emptyData('GET')
                : $response = $this->success($productType, 'GET');
            echo $response;
        }else{
            echo $this->responseFailure('GET');
        }
    }

    public function create()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        if (!$this->usefulFunctions->validateProductTypeRequest($data)) {
            echo $this->emptyData('POST');
        }else{
            $insert = $this->productTypeModel->insertProductType($data);
            if ($insert > 0 ) {
                echo $this->success($data, 'POST');
            }else{
                echo $this->responseFailure('POST');
            }
        }
    }
}
