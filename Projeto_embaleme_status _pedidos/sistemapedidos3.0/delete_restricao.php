<?php
include "index.php";
session_start();
$_SESSION['cod_id'] = $_GET['codigo'];
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

        <div class="row align-items-start">
          <div class="col">
          <form action="remover_restricao.php" method="POST">
          <p class="h5">Digite o Número da Nota Fiscal para Remover a Restrição: </p>
          <input type="text" name="numero" placeholder="Digite o Código da Caixa!" autofocus="true" maxlength="44" minlength="44">
          <input type="submit" value="Enviar">
        </form>  
    </div>
    </body>
    </html>

