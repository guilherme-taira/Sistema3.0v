<?php
$action = (array_key_exists('action', $_REQUEST) ? $_REQUEST['action'] : "");

if ($action  == "" || $action == "visualizar") {

    #dados para a conexão com o banco de dados;
    // BANCO NUVEM
    // $servidor = "portaldocomputador.com.br";
    // $usuario = "fabri436";
    // $senha = "GdantasJpais@123";
    // $banco = "fabri436_sisped";
    // BANCO LOCAL
    $servidor = "localhost";
    $usuario = "root";
    $senha = "35712986";
    $banco = "fabri436_sisped";
    $porta = 3306;

    try {
        $conn = mysqli_connect($servidor, $usuario, $senha, $banco);
        mysqli_select_db($conn, $banco);
    } catch (\Exception $e) {
       echo $e->getMessage();
    }

}
