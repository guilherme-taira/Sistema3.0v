<?php

// ---------- SESSÂO ABERTA --------------//

//  ATUALIZA PRODUTOS NO BANCO NO MULTILOJA SHOPEE 
// create by GUILHERME TAIRA  --> 19/01/2022 as 08:35

// METHOD GET

// URLBASE PARA AUTENTICAR
define("URL_BASE_GET_BLING_PRODUTO", "https://bling.com.br/");


interface Bling{
    public function resource();
    public function get($resource);
}


class Shopee implements Bling {

    private $id_produto;
    private $apikey;

    public function __construct($id_produto,$apikey)
    {
        $this->id_produto = $id_produto;
        $this->apikey = $apikey;
    }
    
    public function resource(){
        return $this->get('Api/v2/produto/'.$this->getId_produto().'/json/'.'?apikey=' . $this->getApikey().'&loja=203874743');
    }

    public function get($resource){

        // ENDPOINT PARA REQUISICAO
        $endpoint = URL_BASE_GET_BLING_PRODUTO.$resource;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST,'GET');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,  CURLOPT_HTTPHEADER, ['Content-Type:application/json']);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    /**
     * Get the value of id_produto
     */ 
    public function getId_produto()
    {
        return $this->id_produto;
    }

    /**
     * Set the value of id_produto
     *
     * @return  self
     */ 
    public function setId_produto($id_produto)
    {
        $this->id_produto = $id_produto;

        return $this;
    }

    /**
     * Get the value of apikey
     */ 
    public function getApikey()
    {
        return $this->apikey;
    }

    /**
     * Set the value of apikey
     *
     * @return  self
     */ 
    public function setApikey($apikey)
    {
        $this->apikey = $apikey;

        return $this;
    }
}

abstract class FactoryShopee {
    public abstract function CadastraBancoshopee($id_produto,$apikey, \PDO $pdo);
    public abstract function VerificaDivergencia();
}

class AnaliseDeDadosFactory extends FactoryShopee{

    public function CadastraBancoshopee($id_produto,$apikey,\PDO $pdo){
        $ShopeeProduct = new Shopee($id_produto,$apikey);
        $dadosProduto =  $ShopeeProduct->resource();

        $json = json_decode($dadosProduto,false); 
       
        foreach ($json->retorno->produtos as $produto) {
        
            $referencia = $produto->produto->codigo;
            $MercadoLivreID = isset($produto->produto->produtoLoja->idProdutoLoja)? $produto->produto->produtoLoja->idProdutoLoja : "";

            if(!empty($MercadoLivreID)){
                 // GRAVA NO BANCO SE TIVER VAZIO O ID MERCADO LIVRE
                 echo "Cadastrado! $MercadoLivreID <br>";
                 try {
                    $pdo->beginTransaction();
                    $statement = $pdo->prepare("UPDATE TrayProdutos SET MercadoLivreID = :MercadoLivreID WHERE referencia = :referencia");
                    $statement->bindValue(':MercadoLivreID',$MercadoLivreID, PDO::PARAM_STR);
                    $statement->bindValue(':referencia', $referencia, PDO::PARAM_STR);
                    $statement->execute();
                    $pdo->commit();
                 } catch (\PDOException $e) {
                     $pdo->rollBack();
                     echo $e->getMessage();
                     echo $e->getCode();
                 }
            }else{
                // GRAVA NO BANCO SE TEVE ALTERACAO
                echo "
                <tbody>
                <div class='card mt-2 alert alert-danger'>
                <ul class='list-group list-group-flush'>
                <li class='list-group-item'><strong>Número Pedido: {$produto->produto->descricao} - Pedido Já Cadastrado!</strong></li>
                </ul>
                </div>  
                ";
            }
        }
       
    }

    public function VerificaDivergencia(){

    }
}

class TelaMostraDiverngencia {
    
    private $pagina;
    private $apikey;
    private $pdo2;

    public function __construct($pagina,$apikey,\PDO $pdo2){
        $this->pagina = $pagina;
        $this->apikey = $apikey;
        $this->pdo2 = $pdo2;
    }

    public function atualizaProdutos(){
        include_once 'BlingProdutosGet.php';
        $produtos = new GetProdutosBling;
        $produtos = $produtos->resource($this->getPagina(),$this->getApikey());
        
    
        foreach ($produtos->retorno->produtos as $produto) {
            $FactoryProduto = new AnaliseDeDadosFactory();
            $FactoryProduto->CadastraBancoshopee($produto->produto->codigo,'a0e92e1b13cad53953fa6b425bc6cb36bcf51d327ec8ca3c9a0c20d271edb3585cc96277',$this->pdo2);
        }
   
    }
 
//a0e92e1b13cad53953fa6b425bc6cb36bcf51d327ec8ca3c9a0c20d271edb3585cc96277
    /**
     * Get the value of pagina
     */ 
    public function getPagina()
    {
        return $this->pagina;
    }

    /**
     * Set the value of pagina
     *
     * @return  self
     */ 
    public function setPagina($pagina)
    {
        $this->pagina = $pagina;

        return $this;
    }

    /**
     * Get the value of apikey
     */ 
    public function getApikey()
    {
        return $this->apikey;
    }

    /**
     * Set the value of apikey
     *
     * @return  self
     */ 
    public function setApikey($apikey)
    {
        $this->apikey = $apikey;

        return $this;
    }

    /**
     * Get the value of pdo2
     */ 
    public function getPdo2()
    {
        return $this->pdo2;
    }

    /**
     * Set the value of pdo2
     *
     * @return  self
     */ 
    public function setPdo2($pdo2)
    {
        $this->pdo2 = $pdo2;

        return $this;
    }
}

