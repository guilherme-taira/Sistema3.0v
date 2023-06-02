<?php

// BANCO DE PRODUCAO
// $servidor = "sh-pro12.hostgator.com.br";
// $usuario = "fabri436_guileme";
// $senha = "[8.Z1V?WcwTs";
// $banco = "fabri436_sisped";
// $porta = 3306;
// $dsn =  "mysql:host=$servidor;port=$porta;dbname=$banco;charset=utf8";

// BANCO LOCAL
// $servidor = "localhost";
// $usuario = "root";
// $senha = "35712986";
// $banco = "fabri436_sisped";
// $porta = 3306;
// $dsn =  "mysql:host=$servidor;port=$porta;dbname=$banco;charset=utf8";

$option = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => FALSE
];

try {
    $pdo2 = new PDO($dsn, $usuario, $senha,$option);
} catch (\PDOException $th) {
    echo $th->getMessage();
    echo $th->getCode();
}

