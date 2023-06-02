<?php

class update
{

    private $codigo;


    function __construct($codigo,$funcionario,$data)
    {
        $this->codigo = $codigo;
        $this->funcionario = $funcionario;
        $this->data = $data;
    }

    function atualiza_pendecia()
    {
        ini_set('display_errors', '1');
        ini_set('display_startup_errors', '1');
        error_reporting(E_ALL);
        include 'conexao.php';
        $sql = "UPDATE codigo SET Tipo = 'P*' WHERE cod = '{$this->codigo}' and Tipo = 'P'";
        $conn->query($sql);
        $sql1 = "SELECT * FROM codigo where cod = '{$this->codigo}' and Tipo = 'P*'";
        $result = $conn->query($sql1);
        if($result->num_rows > 0){
            $sql = "INSERT INTO codigo (cod, colaborador,datas,Tipo)
            VALUES ('$this->codigo','$this->funcionario','$this->data','R')";
            $result = $conn->query($sql);
            echo "pendencia retirada com sucesso!";
        }
        else {
            echo "Não Há Pendência nesse Código!";
        }
    
}
}