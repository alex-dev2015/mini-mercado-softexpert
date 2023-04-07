<?php

namespace App\Models;

use App\Utils\UsefulFunctions;
use PDO;
use PDOException;

class ProductTypeModel extends ModelBase
{
    private UsefulFunctions $usefulFunctions;
    public function __construct()
    {
        parent::__construct();
        $usefulFunctions = new UsefulFunctions();
        $this->usefulFunctions = $usefulFunctions;
    }

    public function listAllTypesOffProducts()
    {
        try {
            $produtos = $this->readAll(
                'product_type'
            );
        }catch (PDOException $exception){
            return $exception->getMessage();
        }
        return $produtos;
    }

    public function listProductsWithTaxes()
    {
        $conexao = parent::getConexao();
        $sql = $conexao->prepare(
            "select tp.id,
                                         tp.nome AS produto,
                                          t.nome,
                                          t.aliquota
                                    from product_type AS tp
                              left join tributos AS t on t.tipo_id = tp.id
                              group by tp.id, tp.nome, t.nome, t.aliquota"
        );
        try{
            $sql->execute();
            return $sql->fetchAll(PDO::FETCH_ASSOC);
        }catch (PDOException $e){
            return null;
        }
    }

    public function insertProductType(array $dados)
    {
        $imcsRemoveComma = $this->usefulFunctions->removeComma($dados['icms']);
        $pisRemoveComma = $this->usefulFunctions->removeComma($dados['pis']);
        $ipiRemoveComma = $this->usefulFunctions->removeComma($dados['ipi']);
        $dados['icms'] = $this->usefulFunctions->convertPercentage($imcsRemoveComma);
        $dados['pis'] = $this->usefulFunctions->convertPercentage($pisRemoveComma);
        $dados['ipi'] = $this->usefulFunctions->convertPercentage($ipiRemoveComma);

        return $this->insert(
            'product_type',
            ":product_type_name, :icms, :pis, :ipi",
            $dados
        );
    }

    public function searchProductType($id)
    {
        return $this->findBy(
            'product_type',
            'id',
            $id
        );
    }
}
