<?php

namespace App\Controllers;

use App\Models\SaleModel;
use App\Utils\UsefulFunctions;

class SaleController extends Controller
{
    private SaleModel $saleModel;
    private UsefulFunctions $usefulFunctions;
    public function __construct()
    {
        parent::__construct();
        $saleModel = new SaleModel();
        $usefulFunctions = new UsefulFunctions();
        $this->saleModel = $saleModel;
        $this->usefulFunctions = $usefulFunctions;
    }

    public function index(): void
    {
        $sales = $this->saleModel->listSales();
        if (is_array($sales)) {
            $response = [];
            (empty($sales))
                ? $response = $this->emptyData('GET')
                : $response = $this->success($sales, 'GET');
            echo $response;
        }else{
            echo $this->responseFailure('GET');
        }
    }

    public function executeSale(): void
    {
        $data = json_decode(file_get_contents('php://input'), true);

        if (!$this->usefulFunctions->validateSalesRequest($data)) {
            echo $this->emptyData('POST');
        }else{
            $startSale = $this->saleModel->startSales();
            if ($startSale > 0) {
                $insert = $this->saleModel->executeSale($data['sales'], $startSale);
                if (is_array($insert)) {
                    echo $this->success($insert, 'POST');
                }else{
                    echo $this->responseFailure('POST');
                }
            }
        }
    }

}
