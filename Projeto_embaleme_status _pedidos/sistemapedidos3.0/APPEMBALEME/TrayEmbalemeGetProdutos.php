<?php
include_once 'AppEmbalemeAuth.php';
// ---------- SESSÂO ABERTA --------------//

// GET PRODUTOS TRAY 
// create by GUILHERME TAIRA  --> 10/12/2021 as 09:44

// METHOD GET

// URLBASE PARA AUTENTICAR
define("URL_BASE_GET_PRODUTOS_TRAY", "https://www.embaleme.com.br/web_api");

class GetProdutosGravaBanco{

    private $access_token;
    private $page;
    
    function resource($access_token,$page){
        $this->setAccess_token($access_token);
        $this->setPage($page);
        return $this->get('/products?access_token='.$this->getAccess_token().'&page='.$this->getPage().'&limit=100');
    }

    function get($resource){
        // ENDPOINT PARA REQUISCAO
        $endpoint = URL_BASE_GET_PRODUTOS_TRAY.$resource;

        //echo $endpoint;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["follow_redirects: TRUE"]);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        $requisicao = json_decode($response,false); 
        //echo $httpCode;
        // if($httpCode == "200"){
        //     echo "Token Gerado Com Sucesso!!";
        // }else if($httpCode == "404"){
        //     echo "Ordem Não Encontrada Verifique!";
        // }
        return $requisicao;
    }

    /**
     * Get the value of access_token
     */ 
    public function getAccess_token()
    {
        return $this->access_token;
    }

    /**
     * Set the value of access_token
     *
     * @return  self
     */ 
    public function setAccess_token($access_token)
    {
        $this->access_token = $access_token;

        return $this;
    }

    /**
     * Get the value of page
     */ 
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Set the value of page
     *
     * @return  self
     */ 
    public function setPage($page)
    {
        $this->page = $page;

        return $this;
    }
}


