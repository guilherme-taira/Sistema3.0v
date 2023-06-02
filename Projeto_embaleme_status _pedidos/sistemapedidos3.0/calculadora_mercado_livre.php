<?php
    include_once 'index.php';
    session_start();


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

<form class="container-sm" action="calculadora_ml.php" method="POST">

   

      
  <div class="form-group">
    <label for="exampleInputEmail1">Valor do Produto</label>
    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="produto" >
    <small id="emailHelp" class="form-text text-muted">digite o valor do produto com casas decimais ex (19,45).</small>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Porcentagem do Anúncio</label>
    <input type="text" class="form-control" id="exampleInputPassword1" name="porcentagem">
    <small id="emailHelp" class="form-text text-muted">digite o valor do produto com casas decimais ex (11,00).</small>
  </div>




  <div class="form-row align-items-center">
    <div class="col-auto my-1">
      <label class="mr-sm-2" for="inlineFormCustomSelect">Tabela de Frete</label>
      <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="frete">
        <option selected>Selecione o Peso..</option>
        <option value="16.45"> 1 - Peso Até 500g = 16.45 </option>
        <option value="2"> 2 - Peso De 500g à 1kg = 17.95</option>
        <option value="3"> 3 - Peso De 1kg à 2kg = 18.45</option>
        <option value="4"> 4 - Peso De 2kg à 5kg = 22.95 </option>
        <option value="5"> 5 - Peso De 5kg à 9kg = 33.95</option>
        <option value="6"> 6 - Peso De 9kg à 13kg = 53.45</option>
        <option value="7"> 7 - Peso De 13kg à 17kg = 59.45 </option>
        <option value="8"> 8 - Peso De 17kg à 23kg = 69.45</option>
        <option value="9"> 9 - Peso De 23Kg à 29kg = 79.95</option>
        <option value="10"> 10 - Peso Maior Que 29kg = 90.95</option>
      </select>

<br>
      <label class="mr-sm-2" for="inlineFormCustomSelect">Tipo de Anúncio</label>
    <div class="custom-control custom-radio">
  <input type="radio" id="customRadio1" name="Tipo" value="1" class="custom-control-input">
  <label class="custom-control-label" for="customRadio1">Clássico</label>
</div>
<div class="custom-control custom-radio">
  <input type="radio" id="customRadio2" name="Tipo" value="2" class="custom-control-input">
  <label class="custom-control-label" for="customRadio2">Premium</label>
</div>
 
  </div>
  <button type="submit" class="btn btn-primary">Calcular</button>
 
  



  
</form>
</div>
</body>
</html>