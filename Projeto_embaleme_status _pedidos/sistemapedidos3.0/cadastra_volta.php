<?php
ob_start();
session_start();


try {
  $cod = $_SESSION['cod_nf'];
  $funcionario = $_SESSION['colaborador'];
  $data =  $_SESSION['datahora'];
  $tipo = $_SESSION['tipo'];
  $dadospedido = $_SESSION['dadospedido'];
  $eansessao = $_SESSION['eansessao'];
  $_SESSION['verificador'] = 1;

  include "teste/bridge/classeConcreta.php";
  include "teste/bridge/implementadorGravaInvoice.php";
  $conexao = new Banco;
  $statemente = $conexao->pdo->query("SELECT id_pedido,peso from codigo where cod = '$cod' and Tipo = 'NF*' ");
  $pedido = $statemente->fetchAll(PDO::FETCH_ASSOC);
  foreach ($pedido as $value) {
    $n_pedido =  $value['id_pedido'];    // pega valor do numero do pedido do banco de dados
    $peso = $value['peso']; // pega o valor do peso do banco de dados
  }

  $pedido = new CadastrarInvoice(new ImplementadorType);
  $pedido->gravar($cod, $tipo,$peso, 0, $funcionario, 1, "", $n_pedido, 0, 0, 0, 0);

  header("Location: volta.php");
  $url = "teste/piking/$dadospedido";
  $enasessao = "teste/piking/$eansessao";
  unlink($url); // apaga o arquivo 
  unlink($enasessao); // apaga o arquivo 

} catch (\Exception $e) {
  echo $e->getMessage();
}
ob_end_flush();
