<?php
ob_start();
 include_once 'index.php';
session_start();
$_SESSION['datahora'] = $_POST['data'];
$_SESSION['colaborador'] = $_POST['funcionario'];
$_SESSION['Tipo'] = 'F';
$_SESSION['codigo'] = "";


if(isset($_SESSION['datahora']) AND isset($_SESSION['colaborador'])){
  
    header("location:lista_produtos_finalizados.php");
   
};
ob_end_flush();

?>

