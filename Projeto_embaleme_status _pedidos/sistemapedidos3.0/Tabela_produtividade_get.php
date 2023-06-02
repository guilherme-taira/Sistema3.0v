<?php
include_once 'index.php';
include_once 'produtividade.php';
$mes = $_POST['mes'];
$ano = date('Y');

$funcao = new Produtividade($ano,$mes);
$funcao->retorna_dados();

?>