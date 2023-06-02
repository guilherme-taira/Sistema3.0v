<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
  include "index.php";
  include "conexao.php";
  ?>
<div class="container-sm">
  <form method="POST" action="opcao.php">
      <?php
      //session_start();
      $data = date("Y-m-d H:i");
      echo " <input type='text' name='op' style='visibility: hidden' value='4' /><br>";
      // echo "    <label>Data :</label>";
      echo " <input type='hidden'name='data' value='" . $data . "' /><br><br>";
      echo " <div class='col-auto my-1'>
      <label class='mr-sm-2' for='inlineFormCustomSelect'>Selecione a Plataforma da Nota Fiscal</label>
      <select class='custom-select mr-sm-2' id='inlineFormCustomSelect' name='market_place' required>
        <option value=''>Selecione o Market Place </option>
        <option value='1'>MarketPlace (Mercado Livre, B2W, Shopee)</option>
        <option value='2'>Site (Correio, Mandaê, Etiqueta Manual)</option>
      </select>
      </div>";
      ?>
      <input type="submit" class="btn btn-success" value="Enviar">
  </form>
  </div>
</body>

</html>

