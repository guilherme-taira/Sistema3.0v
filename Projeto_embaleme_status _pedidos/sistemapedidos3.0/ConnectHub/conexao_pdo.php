<?php
// BANCO LOCAL
$servidor = "192.168.1.64";
$usuario = "root";
$senha = "35712986";
$banco = "fabri436_sisped";
$porta = 3306;
$dsn =  "mysql:host=$servidor;port=$porta;dbname=$banco;charset=utf8";

$option = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => FALSE
];

$pdo = new PDO($dsn, $usuario, $senha,$option);
