<?php
date_default_timezone_set('America/Sao_Paulo');
include_once 'index.php';
include_once 'conexao.php';


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

    
<form method="post" action="sistema_mandae.php">
<?php

$data = date ("Y-m-d-H:i");
echo " <input type='text'name='data' style='visibility: hidden' value='" . $data . "' /><br><br>";    
?>
   <p class="h5">Selecione o Funcionario :</p>
        <select class="form-control" id="exampleFormControlSelect1" name="funcionario">
        <option selected>Selecione..</option>         
    <?php 
    
    $result = "SELECT id,nome FROM colaborador";
    $query = mysqli_query($conn,$result);
    while($nome = mysqli_fetch_assoc($query)) {?>
    <option value="<?php echo $nome['id']; ?>"><?php echo $nome['nome']; ?></option>
    <?php } "<br>";
    ?>
  
     <input type="submit" class="btn btn-success mt-2" value="Enviar">   
    </form>

    </div>
</div>

</body>
</html>