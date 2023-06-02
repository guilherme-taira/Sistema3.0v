<?php
ini_set('display_errors', 0);
error_reporting(0);
session_start();
include_once 'insert.php';
include "index.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <div class="container">

    <?php
    if ($_SESSION['message']) {
      echo "<div class='alert alert-danger' role='alert'>
        {$_SESSION['message']}
    </div>";
      unset($_SESSION['message']);
    }
    ?>

    <div class="row align-items-start">
      <div class="col">

        <form action="verificador_de_duplicidade.php" method="POST">
          <p class="h5">Insira o Código da Caixa ou da Nota: </p>
          <p>Atenção o campo aceita só aceita 44 caracteres, caso tenha menos será exibida uma mensagem.</p>
          <input type="text" name="codigo" id="cod" class="form-control" placeholder="Digite o Código da Caixa!" autofocus="true" required maxlength="44" minlength="44">

        </form>


        <?php
        $data = $_SESSION['datahora'];
        $funcionario = $_SESSION['colaborador'];
        $_SESSION['tipo'] = 'F';
        $tipo = $_SESSION['tipo'];
        include_once "select_pedidos_finalizados.php";

        $select = new Mostra_dados_php($funcionario, $data);
        $select->getDados();
        ?>

      </div>

    </div>





</body>

</html>