<?php
// ---------- SESSÂO ABERTA --------------//

// AUTENTICAÇÃO TRAY
// create by GUILHERME TAIRA  --> 10/12/2021 as 09:44

// METHOD POST

// URLBASE PARA AUTENTICAR
define("URL_BASE_AUTH_TRAY_EMBALEME", "https://www.embaleme.com.br/");

class AuthTrayEmbaleme
{

    private $consumer_key;
    private $constumer_secret;
    private $code;

    function __construct($consumer_key, $constumer_secret, $code)
    {
        $this->consumer_key = $consumer_key;
        $this->constumer_secret = $constumer_secret;
        $this->code = $code;
    }

    function resource()
    {
        return $this->get('web_api/auth');
    }
    function get($resource)
    {
        // ENDPOINT PARA REQUISICAO
        $endpoint = URL_BASE_AUTH_TRAY_EMBALEME . $resource;

        $body = array(
            'consumer_key' => $this->getConsumer_key(),
            'consumer_secret' => $this->getConstumer_secret(),
            'code' => $this->getCode(),
        );
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["follow_redirects: TRUE"]);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        $requisicao = json_decode($response,false); 
        // echo "<pre>";
        // print_r($requisicao);

        // variaveis de sessão
        $_SESSION['access_token_tray'] = $requisicao->access_token;
        $_SESSION['refresh_token_tray'] = $requisicao->refresh_token;
        $_SESSION['date_expiration_access_token_tray'] = $requisicao->date_expiration_access_token;
        $_SESSION['date_expiration_refresh_token_tray'] = $requisicao->date_expiration_refresh_token;
        
        // if($httpCode == "200"){
        //     echo "Token Gerado Com Sucesso!!";
        // }else if($httpCode == "404"){
        //     echo "Ordem Não Encontrada Verifique!";
        // }
    }
    /**
     * Get the value of consumer_key
     */
    public function getConsumer_key()
    {
        return $this->consumer_key;
    }

    /**
     * Set the value of consumer_key
     *
     * @return  self
     */
    public function setConsumer_key($consumer_key)
    {
        $this->consumer_key = $consumer_key;

        return $this;
    }

    /**
     * Get the value of constumer_secret
     */
    public function getConstumer_secret()
    {
        return $this->constumer_secret;
    }

    /**
     * Set the value of constumer_secret
     *
     * @return  self
     */
    public function setConstumer_secret($constumer_secret)
    {
        $this->constumer_secret = $constumer_secret;

        return $this;
    }

    /**
     * Get the value of code
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set the value of code
     *
     * @return  self
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }
}

$AuthTray = new AuthTrayEmbaleme('9dec7ed695dbf7eac41b56c5a3fd122a8f4ef5ea40a733b12e54ff062f76c6eb','c6b66367fc609afa2968275dff7971258b0365eceaec8b380b06fe37c9968e25','62c4367b4a7472222886403203d96edc83f7df6a9a5cdbe3011f19bd56a11bed');
$AuthTray->resource();


// echo "<label>access_token_tray : </label>";
// echo "<input type='text' value='{$Auth['access_token_tray']}' size='100' name='' id=''><br>";

// echo "<label>refresh_token_tray : </label>";
// echo "<input type='text' value='{$Auth['refresh_token_tray']}' size='100' name='' id=''><br>";

// echo "<label>date_expiration_access_token_tray : </label>";
// echo "<input type='text' value='{$Auth['date_expiration_access_token_tray']}' size='100' name='' id=''><br>";

// echo "<label>date_expiration_refresh_token_tray : </label>";
// echo "<input type='text' value='{$Auth['date_expiration_refresh_token_tray']}' size='100' name='' id=''><br>";

// echo "<label>access_token : </label>";
// echo "<input type='text' value='{$Auth['access_token']}' size='100' name='' id=''><br>";

// echo "<label>access_token_expiration : </label>";
// echo "<input type='text' value='{$Auth['access_token_expiration']}' size='100' name='' id=''><br>";
// code do Aplicativo Embaleme *** ->>>> e140024829b4ca3b284e1646863ec211466ec75e5c48a4a4d0f104fdc25d8805
