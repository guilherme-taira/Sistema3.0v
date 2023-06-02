<?php
// elimina os erros da página basta comentar para mostrar os erros
date_default_timezone_set('America/Sao_Paulo');
ini_set('display_errors', 0 );
error_reporting(0);
session_start();
//include_once 'insert.php';
include "index.php";
include_once 'teste/conexao_pdo.php';
include "verificador_finalizador_caixas.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<!-- We are using a jQuery version hosted by jQuery- But any version canbe downloaded any link to it in local deployment -->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js"></script>
<script type="text/javascript">
  var auto_refresh = setInterval(function() {
    $('#loadtweets').load('teste/get_peso_balanca.php').fadeIn("slow");
  }, 1000);
  // refreshing every 15000 milliseconds/15 seconds 
</script>
</head>

<body>
  <div class="container">
    <div class="row align-items-start">
      <div class="col">
        <form action="lista_Uello.php" method="POST">
          <?php
          // $data = date('Y-m-d');
          // $statemente = $pdo->query("SELECT count(cod) as caixa FROM `codigo` WHERE Tipo = 'U' and datas like '%$data%'");
          // $cod_saida = $statemente->fetchAll(PDO::FETCH_ASSOC);
          // foreach ($cod_saida as $value) {
          //   echo "<h1> Quantidade : [ " . $value['caixa'] . " ] </h1>";
          // }
          ?>
          <h3><span class="badge bg-warning text-dark">Peso da Caixa: </span></h3>
          <div id="loadtweets">Carregando..</div>
      </div>
      <script>
        $('#exampleFormControlInput1').maskWeight({
          integerDigits: 3,
          decimalDigits: 3,
          decimalMark: '.',
          //initVal default: generated
          //roundingZeros default: true
        });
      </script>
    </div>
    <div class="mb-3">
      <h3><span class="badge bg-warning text-dark">Insira o Código da Caixa ou da Nota:</span></h3>
      <input type="text" name="codigo" id="cod" placeholder="Digite o Código da Caixa!" autofocus="true" maxlength="44" minlength="44" class="form-control" id="exampleFormControlInput1" value="">
      <div class="row g-3 align-items-center">
        <br>

        <?php
      
        $conexao = new Banco;
        $dataHora = new Datetime();
        $data =  $dataHora->format('Y-m-d H:i:s');
        $cod = $_POST['codigo'];
        $funcionario = $_SESSION['colaborador'];
        $tipo = $_SESSION['Tipo'];
        $market = 0;
        $observacao = 0;
        $peso_loja = $_REQUEST['peso_loja'];
        include_once 'teste/conexao_pdo.php'; // abre a conexao com o pdo.
        $statemente = $conexao->pdo->query("SELECT id_pedido,peso from codigo where cod = '$cod' and Tipo = 'F' ");
        $pedido = $statemente->fetchAll(PDO::FETCH_ASSOC);
        foreach ($pedido as $value) {
          $n_pedido =  $value['id_pedido'];    // pega valor do numero do pedido do banco de dados
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
        include_once "select_uello.php";

        $select = new Mostra_dados_php($funcionario, $data);
        $select->getDados();
        ?>


      </div>

    </div>

    <script>
      jQuery('#cod').keypress(function(event) {

        var keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13') {

          var erro = false;

          if (masked.value === "0.000") {

            alert('Prencha o Peso da Caixa!');

            masked.style.background = "red";
            erro = true;
          }

          if (erro.value === true) {

            erro = true;
          }
          return (!erro);
        }

      });
    </script>
</body>

</html>