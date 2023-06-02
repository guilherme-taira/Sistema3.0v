<?php
$servidor = "portaldocomputador.com.br";
$usuario = "fabri436";
$senha = "GdantasJpais@123";
$banco = "fabri436_sisped";

$conn = mysqli_connect($servidor, $usuario, $senha, $banco);
mysqli_select_db($conn, $banco);

?>