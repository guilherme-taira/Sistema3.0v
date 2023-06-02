<?php
session_start();
$_SESSION['opcao'];
$_SESSION['datahora'] = $_POST['data'];
$_SESSION['colaborador'] = $_POST['funcionario'];
ob_start();
if (isset($_SESSION['datahora']) and isset($_SESSION['colaborador'])) {
  $op = $_SESSION['opcao'];
  switch ($op) {
    case '1':
      header("location:saida.php");
      break;
    case '2':
      header("location:volta.php");
      break;
    case '3':
      header("location:pendencia.php");
      break;
    case '4': 
      header("location:select_cadastra_nota.php");
      break;
    default:
      echo "Pagina Não Existente!";
      break;
  }
}
ob_end_flush();
