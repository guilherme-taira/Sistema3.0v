<?php

	
$apikey = "058212517f224566d99e373d2b232779d71b5d04da9843f26c523d48b73dfb934a28bd03";
$outputType = "json";
$url = 'https://bling.com.br/Api/v2/produtos/page1/' . $outputType;
$retorno = executeGetProducts($url, $apikey);
echo $retorno;
function executeGetProducts($url, $apikey){
    $curl_handle = curl_init();
    curl_setopt($curl_handle, CURLOPT_URL, $url . '&apikey=' . $apikey);
    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, TRUE);
    $response = curl_exec($curl_handle);
    curl_close($curl_handle);
    echo "<pre>";
    var_dump($response);
}

