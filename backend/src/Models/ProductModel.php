<?php

namespace App\Models;

use PDOException;

class ProductModel extends ModelBase
{

    public function __construct()
    {
        parent::__construct();

    }

    public function listAllProducts()
    {
        try {
            $products = $this->readAll(
                'products'
            );
        }catch (PDOException $exception){
            return $exception->getMessage();
        }
        return $products;
    }

    public function insertProduct(array $data)
    {
        return $this->insert(
            'products',
            ":product_name, :price, :type_id",
            $data
        );
    }

    public function searchProduct($id)
    {
        return $this->findBy(
            'products',
            'id',
            $id
        );
    }
}
