<?php
//elimina os erros da página basta comentar para mostrar os erros
ini_set('display_errors', 0);
date_default_timezone_set('America/Sao_Paulo');
error_reporting(0);
session_start();
include_once 'insert.php';
include "index.php";
include_once 'teste/conexao_pdo.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mercado Livre Finalização</title>
  <!-- We are using a jQuery version hosted by jQuery- But any version canbe downloaded any link to it in local deployment -->
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="jquery-3.5.1.min.js"></script>

  <!-- <style>
    .loader {
      position: fixed;
      left: 0px;
      top: 0px;
      width: 100%;
      height: 100%;
      z-index: 9999;
      background: url('http://i.imgur.com/zAD2y29.gif') 50% 50% no-repeat white;
    }
  </style> -->
  <!--- Script que chama o peso da balanca -->
  <script type="text/javascript">
    // var auto_refresh = setInterval(function() {
    //   $('#loadtweets').load('teste/get_peso_balanca.php').fadeIn("slow");
    // }, 1000);
    // refreshing every 15000 milliseconds/15 seconds 
  </script>
</head>

<body>
    <div id='loader' class='loader'></div>;
    <div style='display:none' id="tudo_page"></div>;

  <div class="container">
    <div class="row align-items-start">
      <div class="col">
        <form action="lista_mercado_livre.php" method="POST">
          <?php
          $banco = new Banco();
          $data = date('Y-m-d');
          $statemente = $banco->pdo->query("SELECT count(cod) as caixa FROM `codigo` WHERE Tipo = 'D' and datas like '%$data%'");
          $cod_saida = $statemente->fetchAll(PDO::FETCH_ASSOC);
          foreach ($cod_saida as $value) {
            echo "<h1> Quantidade : [ " . $value['caixa'] . " ] </h1>";
          }
          ?>
          <h3><span class="badge bg-warning text-dark">Peso da Caixa: </span></h3>
          <div id="loadtweets">Carregando..</div>

          <script>
            $(document).ready(function() {
              $('#loadtweets').maskWeight({
                integerDigits: 3,
                decimalDigits: 3,
                decimalMark: '.',
                //initVal: '000,000',
                //roundingZeros: true
              });
            });
          </script>
      </div>


      <div class="mb-3">
        <h3><span class="badge bg-warning text-dark">Insira o Código da Caixa ou da Nota:</span></h3>
        <input type="text" name="codigo" id="cod" placeholder="Digite o Código da Caixa!" autofocus="true" maxlength="44" minlength="44" class="form-control" id="exampleFormControlInput1" value="">
        <div class="row g-3 align-items-center">
          <br>
          <?php
          include "verificador_finalizador_caixas.php";
          $cod = isset($_POST['codigo']) ? $_POST['codigo'] : null;
          $funcionario = $_SESSION['colaborador'];
          $data =  $_SESSION['datahora'];
          $tipo = isset($_SESSION['Tipo']) ? $_SESSION['Tipo'] : null;
          $market = 0;
          $observacao = 0;
          $divergencia_peso = 0;
          $peso_loja = $_REQUEST['peso_loja'];
          include_once 'teste/conexao_pdo.php'; // abre a conexao com o pdo.
          $statemente = $banco->pdo->query("SELECT id_pedido,peso from codigo where cod = '$cod' and Tipo = 'F' ");
          $pedido = $statemente->fetchAll(PDO::FETCH_ASSOC);
          $n_pedido = isset($n_pedido) ? $n_pedido : null;
          $peso = isset($peso) ? $peso : null;
          foreach ($pedido as $value) {
            $n_pedido = $value['id_pedido'];    // pega valor do numero do pedido do banco de dados
            $peso = $value['peso']; // pega o valor do peso do banco de dados
          }
          $inserir = new verificador($cod, $funcionario, $data, $tipo, $market, $observacao, $n_pedido, $peso, $peso_loja, $divergencia_peso);
          $inserir->verifica_codigo();
          ?>
          </form>



        </div>
        <div class="col">
          <?php
          $data = $_SESSION['datahora'];
          $funcionario = $_SESSION['colaborador'];
          include_once "select_mercadolivre.php";
       
          $select = new Mostra_dados_php($funcionario, $data);
          $select->getDados();
          ?>
        </div>
      </div>

      <script>
        $('#cod').keypress(function(event) {

          var keycode = (event.keyCode ? event.keyCode : event.which);
          if (keycode == '13') {   
              $(".loader").delay(1000).fadeOut("fast"); //retire o delay quando for copiar!
              $("#tudo_page").toggle("fast");
          }
      });
      </script>
</body>

</html>