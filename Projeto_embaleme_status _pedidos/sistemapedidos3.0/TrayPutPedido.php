<?php
include_once 'APPEMBALEME/AppEmbalemeAuth.php';
// ---------- SESSÂO ABERTA --------------//

// PUT ATUALIZA PEDIDO TRAY 
// create by GUILHERME TAIRA  --> 14/12/2021 as 09:54

// METHOD PUT

// URLBASE PARA AUTENTICAR
define("URL_BASE_PUT_PEDIDO_TRAY", "https://www.embaleme.com.br/web_api/");

class PutOrderTray{

    private $acess_token;
    private $order;
    private $status;
    private $tracking_url;


    function __construct($acess_token,$order,$status,$tracking_url)
    {   
        $this->acess_token = $acess_token;
        $this->order = $order;
        $this->status = $status;
        $this->tracking_url = $tracking_url;
    }

    function resource(){
        return $this->get('orders/'.$this->getOrder().'?access_token='.$this->getAcess_token());
    }

    function get($resource){
        //ENDPOINT para quesição
        $endpoint = URL_BASE_PUT_PEDIDO_TRAY.$resource;

        $data = array(
                'Order' => [
                    'status_id' => $this->getStatus(),
                    'tracking_url' => $this->getTracking_url(),
                ],
        );

        // transforma array data em json
        $data_json = json_encode($data);
        // print_r($data_json);
        //echo $endpoint;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST,'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type:application/json']);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        $requisicao = json_decode($response,false); 
        // echo "<pre>";
        // print_r($requisicao);
       //echo $httpCode;
        if($httpCode == "200"){
            echo "<div class='alert alert-info text-center' role='alert'><h3>Atualizado Para Enviado!</h3></div>";
        }else if($httpCode == "400"){
           // echo "Ordem Não Encontrada Verifique!";
        }
        
    }


    /**
     * Get the value of order
     */ 
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set the value of order
     *
     * @return  self
     */ 
    public function setOrder($order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get the value of status
     */ 
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */ 
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

  
    /**
     * Get the value of acess_token
     */ 
    public function getAcess_token()
    {
        return $this->acess_token;
    }

    /**
     * Set the value of acess_token
     *
     * @return  self
     */ 
    public function setAcess_token($acess_token)
    {
        $this->acess_token = $acess_token;

        return $this;
    }

    /**
     * Get the value of tracking_url
     */ 
    public function getTracking_url()
    {
        return $this->tracking_url;
    }

    /**
     * Set the value of tracking_url
     *
     * @return  self
     */ 
    public function setTracking_url($tracking_url)
    {
        $this->tracking_url = $tracking_url;

        return $this;
    }
}


// $id_pedido = isset($_REQUEST['id_pedido']) ? $_REQUEST['id_pedido'] : 0;
// $status = 342;

// $PutOrderTray = new PutOrderTray($_SESSION['access_token_tray'],$id_pedido,$status);
// $PutOrderTray->resource();


//*****TABELA DE PEDIDOS STATUS ****//
// 124117 -> ENTREGUE
// 124113 -> AGUARDANDO PAGAMENTO
// 124009 -> EM TRANSITO
// 124141 -> ENVIADO
// 124123 -> APROVADO
// 31 -> TRAY -> AGUARDANDO ENVIO
