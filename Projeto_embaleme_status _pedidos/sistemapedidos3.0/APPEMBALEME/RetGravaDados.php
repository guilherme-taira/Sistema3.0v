<?php
// INCLUIR CONEXAO COM BANCO DO RET

interface BancoRet
{
    public function GravaBanco(\PDO $pdo2, \PDO $pdo);
    public function PesquisaBancoRet($id_produto,\PDO $pdo);
}

class UpdateProduto implements BancoRet
{
    private $codigo;
    private $pdo;

    public function __construct($codigo)
    {
        $this->codigo = $codigo;
 
    }

    public function GravaBanco(\PDO $pdo2, \PDO $pdo)
    {   
        // PDO STATEMENT
        $statement1 = $pdo2->query("SELECT referencia,preco,stock,precoPromocional,QTDBAIXARET FROM TrayProdutos WHERE referencia = '{$this->getCodigo()}'");
        $produtos = $statement1->fetchAll(PDO::FETCH_ASSOC);
        foreach ($produtos as $produto) {       
          $dados = $this->PesquisaBancoRet($produto['referencia'],$pdo); 
          if(number_format($dados->PRODVenda,2) != $produto['preco'] || intval($dados->PRODSDO) != $produto['stock'] || number_format($dados->PRODVendaPR,2) != $produto['precoPromocional']){
            // Atualiza os dados do Banco do RET
            if(empty($dados->BARUNBXA)){
                $baixa = 0;
            }else{
                $baixa = floatval($dados->BARUNBXA);
            }
            $statement2 = $pdo2->query("UPDATE TrayProdutos SET preco = '$dados->PRODVenda', stock = '$dados->PRODSDO', PrecoPromocional = '$dados->PRODVendaPR', QTDBAIXARET = '$baixa', dataInicial = '$dados->PRODPromoIN', dataFinal = '$dados->PRODPromoFM', flag_estoque = 'X', flag_preco = 'X' WHERE referencia = '{$this->getCodigo()}'");
            $statement2->execute();
          }
        }
    }

    public function PesquisaBancoRet($id_produto,\PDO $pdo)
    {
        include_once 'BancoRetAPPTRAY.php';
        // "SELECT ".'"PRODVenda"'. "," . '"PRODCod"' . "," . '"PRODPromoIN"' . "," . '"PRODPromoFM"' . "," . '"PRODVendaPR"' . "," . '"PRODSDO"' . " FROM RET051 WHERE ".'"PRODCod"'." = '{$id_produto}'"
        
        $sql = "SELECT * from ret051 INNER JOIN ret052 ON ret051.".'"PRODCod"'." = ret052.".'"PRODCod"'." WHERE ret052.".'"BARINTERNO"'." = '{$id_produto}'";
        $statement = $pdo->query($sql);
        $Produtos = $statement->fetchAll(PDO::FETCH_ASSOC);

        if(empty($Produtos)){
         /**
         *  QUANTIDADE DE BAIXA QUANDO UNITARIO
         **/
            $sql = "SELECT ".'"PRODVenda"'. "," . '"PRODCod"' . "," . '"PRODPromoIN"' . "," . '"PRODPromoFM"' . "," . '"PRODVendaPR"' . "," . '"PRODSDO"' . " FROM RET051 WHERE ".'"PRODCod"'." = '{$id_produto}'";
            $statement = $pdo->query($sql);
            $Produtos = $statement->fetchAll(PDO::FETCH_ASSOC);
            foreach ($Produtos as $produto) {
                print_r($produto);
                $obj = json_decode(json_encode($produto),false);
                return $obj;
            }

        }else{
        
        /**
         *  QUANTIDADE DE BAIXA QUANDO FOR KITS OU SECUNDARIO
        **/
        foreach ($Produtos as $produto) {
            print_r($produto);
            $obj = json_decode(json_encode($produto),false);
            return $obj;
        }
      }
    }


    /**
     * Get the value of codigo
     */ 
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set the value of codigo
     *
     * @return  self
     */ 
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get the value of pdo
     */ 
    public function getPdo()
    {
        return $this->pdo;
    }

    /**
     * Set the value of pdo
     *
     * @return  self
     */ 
    public function setPdo($pdo)
    {
        $this->pdo = $pdo;

        return $this;
    }
}



