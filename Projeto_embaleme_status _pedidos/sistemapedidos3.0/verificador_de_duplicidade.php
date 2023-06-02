<?php
session_start();
$cod = $_POST['codigo'];
$data = $_SESSION['datahora'];
$funcionario = $_SESSION['colaborador'];
$tipo =  $_SESSION['tipo'];

if (!isset($cod)) {
  $_SESSION['message'] = "Nota Fiscal não Digitada ou campo Vazio";
  header(sprintf('location: %s', $_SERVER['HTTP_REFERER']));
}

include "teste/bridge/classeConcreta.php";
include "teste/bridge/implementadorGravaInvoice.php";
$pedido = new CadastrarInvoice(new ImplementadorType);
$verificaCadastrado = $pedido->verificarcadastrado($cod, $tipo);

if ($verificaCadastrado == true) {
  $pedido->gravar($cod, $tipo, $peso, 0, $funcionario, 1, "", $n_pedido, 0, 0, 0, 0);
}

// $_SESSION['message'] = "Já Cadastrado";
// header(sprintf('location: %s', $_SERVER['HTTP_REFERER']));

// include 'verifica_codigo.php';
// $verifica = new verificador($cod,$tipo);
// $verifica->verifica_codigo();
