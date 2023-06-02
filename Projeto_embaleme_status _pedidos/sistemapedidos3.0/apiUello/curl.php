<?php


$ch = curl_init();

$header = [
    'Autorization: Bearer 123',
    'Content-Type: application/json',
];

$post = [
    'Nome' => 'Guilherme Taira',
    'Empresa' => 'Embaleme',
    'origem' => '13610230',
    'destino' => '13617635',
];

$json = json_encode($post);

curl_setopt($ch,CURLOPT_URL,'https://portaldocomputador.com.br/SistemaPedidos/teste/Uello/api.php');
$fp = fopen("temp_file.txt", "wb");
curl_setopt($ch,CURLOPT_CUSTOMREQUEST,'POST');
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch,CURLOPT_HTTPHEADER, $header);
curl_setopt($ch,CURLOPT_POSTFIELDS,$json);
$response = curl_exec($ch);
curl_close($ch);
fwrite($fp,$response);
echo $response;