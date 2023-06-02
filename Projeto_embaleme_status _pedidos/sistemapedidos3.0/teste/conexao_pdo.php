<?php

class Banco
{   
    public PDO $pdo;
    public $dsn;
    public function __construct()
    {
        $servidor = "localhost";
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
        
        return $this->pdo = new PDO($dsn, $usuario, $senha, $option);
        //$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }
}


