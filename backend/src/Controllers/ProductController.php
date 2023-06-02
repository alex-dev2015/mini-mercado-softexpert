<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Utils\UsefulFunctions;

class ProductController extends Controller
{
    private ProductModel $productModel;
    private UsefulFunctions $usefulFunctions;
    public function __construct()
    {
        parent::__construct();
        $productModel = new ProductModel();
        $usefulFunctions = new UsefulFunctions();
        $this->productModel = $productModel;
        $this->usefulFunctions = $usefulFunctions;
    }

    public function index(): void
    {
        $products = $this->productModel->listAllProducts();
        if (is_array($products)) {
            $response = [];
            (empty($products))
                ? $response = $this->emptyData('GET')
                : $response = $this->success($products, 'GET');
            echo $response;
        }else{
            echo $this->responseFailure('GET');
        }
    }

    public function show($id): void
    {
        $product = $this->productModel->searchProduct($id);
        if (is_array($product)) {
            $response = [];
            (empty($product))
                ? $response = $this->emptyData('GET')
                : $response = $this->success($product, 'GET');
            echo $response;
        }else{
            echo $this->responseFailure('GET');
        }
    }

    public function create(): void
    {
        $data = json_decode(file_get_contents('php://input'), true);

        if (!$this->usefulFunctions->validateProductRequest($data)) {
            echo $this->emptyData('POST');
        }else{
            $insert = $this->productModel->insertProduct($data);
            if ($insert > 0 ) {
                echo $this->success($data, 'POST');
            }else{
                echo $this->responseFailure('POST');
            }
        }
    }
}
