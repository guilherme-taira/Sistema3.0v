<?php
    include_once 'index.php';
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
<div class="container-sm">
    <div class="col">
      
<form method="post" action="tabela_acumulada.php">
    <?php
    session_start();
    $data = date ("Y-m-d H:i");

    echo " <input type='text'name='data' style='visibility: hidden' value='" . $data . "' /><br><br>";
    
    
    ?>
    
    <p class="h5">Selecione o Mês : </p>
    <select name="mes" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example">
    <option selected>Selecione..</option>

    <option value="01">Janeiro</option>
    <option value="02">Fevereiro</option>
    <option value="03">Março</option>
    <option value="04">Abril</option>
    <option value="05">Maio</option>
    <option value="06">Junho</option>
    <option value="07">Julho</option>
    <option value="08">Agosto</option>
    <option value="09">Setembro</option>
    <option value="10">Outubro</option>
    <option value="11">Novembro</option>
    <option value="12">Dezembro</option>
  
     <input type="submit" value="Enviar">   
    </form>
    </div>
</div>

</body>
</html>