<?php
//echo "Headers: <br>";
if (!function_exists('getallheaders')) {
    function getallheaders() {
        $headers = [];
        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) == 'HTTP_') {
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
            }
        }
        return $headers;
    }
}
// print_r($headers);
// print_r($_REQUEST);
$fp = fopen("file.txt", "wb");
$dados = json_encode($_GET);

// echo "<pre>";
$input = file_get_contents('php://input');
$array = json_decode($input,false);
$_GET = !empty($array) ? $array : $_GET;
fwrite($fp,$input);

$dados = $_GET;
$json = json_encode($_GET);
$dados = json_decode($json);

$origem = $dados->cep;
$destino = $dados->cep_destino;
$produtos = $dados->prods;


// Gera Valor do Preço do Frete
// create by GUILHERME TAIRA  --> 30/11/2021 as 16:38

// METHOD POST

// URLBASE PARA AUTENTICAR
define("URLBASE_API_UELLO_PRICE", "http://integration-api.uello.com.br/");


interface CalculoProduto{
    public function CalculaDimensao(array $dados);
    public function CalculaPeso(array $dados);
}

class Frete implements CalculoProduto{

    public function CalculaDimensao(array $dados){
     
        $peso = implode("/", $dados);
        $prods = explode("/",$peso);
        $jsonTransf = json_encode($prods);
        $json = json_decode($jsonTransf,false);

        $Dimensao = 0.0;
        foreach ($json as $value) {
            // gera o array com os dados até a chave 07
            $novo = explode(";", $value);
            $Dimensao += (($novo[0] * $novo[1] * $novo[2]) * 10) * $novo[4];    
        }
        return $Dimensao;
    }

    public function CalculaValorDaNota(array $dados){
     
        $peso = implode("/", $dados);
        $prods = explode("/",$peso);
        $jsonTransf = json_encode($prods);
        $json = json_decode($jsonTransf,false);

        $valor = 0.0;
        foreach ($json as $value) {
            // gera o array com os dados até a chave 07
            $novo = explode(";", $value);
            $valor += ($novo[4] * $novo[7]);    
        }
        return $valor;
    }

    public function CalculaPeso(array $dados){
        
        $peso = implode("/", $dados);
        $prods = explode("/",$peso);
        $jsonTransf = json_encode($prods);
        $json = json_decode($jsonTransf,false);

        $pesoTotal = 0.0;
        foreach ($json as $value) {
            // gera o array com os dados até a chave 07
            $novo = explode(";", $value);
            $pesoTotal += ($novo[5] * $novo[4]);    
        }
        return $pesoTotal;
    }

    public function CalculaVolumes(array $dados){
        
        $peso = implode("/", $dados);
        $prods = explode("/",$peso);
        $jsonTransf = json_encode($prods);
        $json = json_decode($jsonTransf,false);

        $pesoTotal = 0.0;
        foreach ($json as $value) {
            // gera o array com os dados até a chave 07
            $novo = explode(";", $value);
            $pesoTotal += ($novo[5] * $novo[4]);    
        }

         return $this->QuantityVolume($pesoTotal);
    }

    function QuantityVolume($peso){
        $volumes = $peso / 30;
        return ceil($volumes);
    }
}


class SearchPriceUelloFrete{
    
    private $origem;
    private $destino;
    private $produtos;
    private $peso;
    private $dimensao;
    private $ValorNf;
    private $volumes;

    function __construct($origem,$destino,$peso,$dimensao,$ValorNf,$volumes)
    {
        $this->origem = $origem;
        $this->destino = $destino;
        $this->peso = $peso;
        $this->dimensao = $dimensao;
        $this->ValorNf = $ValorNf;
        $this->volumes = $volumes;
    }


    function resource(){
        return $this->get('v1/orders/price');
    }

    function get($resource){
        // endpoint para requisicao

        $endpoint = URLBASE_API_UELLO_PRICE.$resource;
        
        /**
         * CALCULA A QUANTIDADE DE VOLUMES 
         */

        // if($this->getPeso() >= 50){
        //     echo $this->getPeso / 30;
        // }

        $data = array(
            "type" => "price",
            "operation" => "1721",
            "source" => array(
                "postcode" => $this->getOrigem(),
                "latitude" => 0,
                "longitude" => 0,
            ),
            "destination" => array(
                "postcode" => $this->getDestino(),
                "latitude" => 0,
                "longitude" => 0,
            ),
            "q_vol" => $this->getVolumes(),
            "weight" => $this->getPeso(),
            "volume" => 0.01,
            "invoice_total" => $this->getValorNf(),
        );
  
        $json = json_encode($data);
       
        try {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$endpoint);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch,CURLOPT_CUSTOMREQUEST,'POST');
        curl_setopt($ch,CURLOPT_POSTFIELDS,$json);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_HTTPHEADER,["X-API-KEY: 5d603c762cd410fe66cfa7e689006fec4f395c800eab45327d35f5002d1e0b31", "Content-Type: application/json"]);
        $response = curl_exec($ch);
        //echo 'Curl error: ' . curl_error($ch);
        curl_close($ch);
        $res = json_decode($response,false);
        //   echo "<pre>";
        //   print_r($res);

        /**
         * 
         * GERA XML PARA COTAÇÂO DE FRETE NA TRAY
         * 
         * **/

        /** 
        *<resultado>
        *<codigo>03220</codigo>
        *<transportadora></transportadora>
        *<servico>SEDEX</servico>
        *<transporte>TERRESTRE</transporte>
        *<valor>111.34</valor>
        *<peso>5.334</peso>
        *<prazo_min>2</prazo_min>
        *<prazo_max>2</prazo_max>
        *<imagem_frete>https://fretefacil.tray.com.br/images/sedex.png</imagem_frete>
        *<aviso_envio></aviso_envio>
        *<entrega_domiciliar>1</entrega_domiciliar>
        *</resultado>
        **/

        // INSTANCIA DO DOCUMENTO

        $dom = new DOMDocument('1.0','UTF-8');

        $dom->formatOutput = true;

        // NÓ CODIGO
        $codigoNodeValue = $dom->createTextNode('1111');
        $codigoNode = $dom->createElement('codigo');
        $codigoNode->appendChild($codigoNodeValue);
        
        // NÓ TRANSPORTADORA
        $transportadoraNodeValue = $dom->createTextNode('EXPRESSO');
        $transportadoraNode = $dom->createElement('transportadora');
        $transportadoraNode->appendChild($transportadoraNodeValue);

        // NÓ SERVIÇO
        $servicoNodeValue = $dom->createTextNode('');
        $servicoNode = $dom->createElement('servico');
        $servicoNode->appendChild($servicoNodeValue);

        // NÓ TRANSPORTE
        $transporteNodeValue = $dom->createTextNode('TERRESTRE');
        $transporteNode = $dom->createElement('transporte');
        $transporteNode->appendChild($transporteNodeValue);

        // NÓ VALOR
        $ValorNodeValue = $dom->createTextNode($res->data->price);
        $ValorNode = $dom->createElement('valor');
        $ValorNode->appendChild($ValorNodeValue);

        // NÓ PESO
        $PesoNodeValue = $dom->createTextNode($this->getPeso());
        $PesoNode = $dom->createElement('peso');
        $PesoNode->appendChild($PesoNodeValue);

        // NÓ PRAZO MINIMO
        $prazoMinNodeValue = $dom->createTextNode("{$this->SomaUmDia($res->data->eta)} Dia(s) Úteis");
        $prazoMinNode = $dom->createElement('prazo_min');
        $prazoMinNode->appendChild($prazoMinNodeValue);  
        
        // NÓ PRAZO MAXIMO
        $prazoMaxNodeValue = $dom->createTextNode("{$this->SomaUmDia($res->data->eta)} Dia(s) Úteis");
        $prazoMaxNode = $dom->createElement('prazo_max');
        $prazoMaxNode->appendChild($prazoMaxNodeValue);    

         // NÓ IMAGEM FRETE
         $ImagemNodeValue = $dom->createTextNode('https://www.hub.embaleme.com.br/apiUello/logo_uello.png');
         $ImagemNode = $dom->createElement('imagem_frete');
         $ImagemNode->appendChild($ImagemNodeValue);       
         
         // NÓ AVISO ENVIO
         $AvisoEnvioNodeValue = $dom->createTextNode('');
         $AvisoEnvioNode = $dom->createElement('aviso_envio');
         $AvisoEnvioNode->appendChild($AvisoEnvioNodeValue);    

         // NÓ ENTREGA DOMICILIAR
         $EntregaDomiciliarNodeValue = $dom->createTextNode($res->status);
         $EntregaDomiciarNode = $dom->createElement('entrega_domiciliar');
         $EntregaDomiciarNode->appendChild($EntregaDomiciliarNodeValue);   
         
        // NÓ VALOR NOTA FISCAL
        $CotacaoNodeValue = $dom->createTextNode($this->getValorNf());
        $CotacaoNode = $dom->createElement('ValorNf');
        $CotacaoNode->appendChild($CotacaoNodeValue); 

    
        // NÓ ROOT INSTANCIA PRINCIPAL
        $ResultNode = $dom->createElement('resultado');
        $ResultNode->appendChild($codigoNode);
        $ResultNode->appendChild($transportadoraNode);
        $ResultNode->appendChild($servicoNode);
        $ResultNode->appendChild($transporteNode);
        $ResultNode->appendChild($ValorNode);
        $ResultNode->appendChild($PesoNode);
        $ResultNode->appendChild($prazoMinNode);
        $ResultNode->appendChild($prazoMaxNode);
        $ResultNode->appendChild($ImagemNode);
        $ResultNode->appendChild($AvisoEnvioNode);
        $ResultNode->appendChild($EntregaDomiciarNode);
        $ResultNode->appendChild($CotacaoNode);

        $rootNode = $dom->createElement('cotacao');
        $rootNode->appendChild($ResultNode);
        $dom->appendChild($rootNode);
        $dom->save('xmlss/'.uniqid()."_".date('Y-m-d').'.xml');

        // VERIFICA SE ESTA DENTRO DO RANGE DAS CIDADE DO CONTRATO
        if(empty($res->data->price)){
            return "";
        }else if(floatval($res->data->price) > 0.00){
            return $dom->saveXML();
        }else{
            return "";
        }
        

        } catch (\Throwable $th) {
            echo $th->getMessage();
            echo $th->getCode();
        }
       
    }

    function SomaUmDia($dia){
        return $dia + 2;
    }

    /**
     * Get the value of origem
     */ 
    public function getOrigem()
    {
        return $this->origem;
    }

    /**
     * Set the value of origem
     *
     * @return  self
     */ 
    public function setOrigem($origem)
    {
        $this->origem = $origem;

        return $this;
    }

    /**
     * Get the value of destino
     */ 
    public function getDestino()
    {
        return $this->destino;
    }

    /**
     * Set the value of destino
     *
     * @return  self
     */ 
    public function setDestino($destino)
    {
        $this->destino = $destino;

        return $this;
    }

    /**
     * Get the value of produtos
     */ 
    public function getProdutos()
    {
        return $this->produtos;
    }

    /**
     * Set the value of produtos
     *
     * @return  self
     */ 
    public function setProdutos($produtos)
    {
        $this->produtos = $produtos;

        return $this;
    }

    /**
     * Get the value of peso
     */ 
    public function getPeso()
    {
        return $this->peso;
    }

    /**
     * Set the value of peso
     *
     * @return  self
     */ 
    public function setPeso($peso)
    {
        $this->peso = $peso;

        return $this;
    }

    /**
     * Get the value of dimensao
     */ 
    public function getDimensao()
    {
        return $this->dimensao;
    }

    /**
     * Set the value of dimensao
     *
     * @return  self
     */ 
    public function setDimensao($dimensao)
    {
        $this->dimensao = $dimensao;

        return $this;
    }

    /**
     * Get the value of ValorNf
     */ 
    public function getValorNf()
    {
        return $this->ValorNf;
    }

    /**
     * Set the value of ValorNf
     *
     * @return  self
     */ 
    public function setValorNf($ValorNf)
    {
        $this->ValorNf = $ValorNf;

        return $this;
    }

    /**
     * Get the value of volumes
     */ 
    public function getVolumes()
    {
        return $this->volumes;
    }

    /**
     * Set the value of volumes
     *
     * @return  self
     */ 
    public function setVolumes($volumes)
    {
        $this->volumes = $volumes;

        return $this;
    }
}

$Frete = new Frete;
$peso = explode("/", $produtos);
$Dimensao = $Frete->CalculaDimensao($peso);
$Peso = $Frete->CalculaPeso($peso);
$ValorNf = $Frete->CalculaValorDaNota($peso);
$volumes = $Frete->CalculaVolumes($peso);

$SearchPriceUelloFrete = new SearchPriceUelloFrete($origem,$destino,$Peso,$Dimensao,$ValorNf,$volumes);
echo $SearchPriceUelloFrete->resource();