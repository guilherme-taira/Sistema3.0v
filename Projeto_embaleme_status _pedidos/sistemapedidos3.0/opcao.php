<?php
ob_start();
session_start();
$_SESSION['plataforma'] = $_POST['market_place'];
$_SESSION['opcao'] = $_POST['op'];
        header('location: verifica.php');
ob_end_flush();
?>