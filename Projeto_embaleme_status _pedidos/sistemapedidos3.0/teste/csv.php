<?php

ini_set('max_execution_time',0);


$servidor = "portaldocomputador.com.br";
$usuario = "fabri436";
$senha = "GdantasJpais@123";
$banco = "fabri436_sisped";

$conn = mysqli_connect($servidor, $usuario, $senha, $banco,3306);
mysqli_select_db($conn, $banco);

$filename = 'C:/carregamento/produtos.csv';

if(file_exists($filename)){
    if(mysqli_query($conn, "LOAD DATA INFILE '$filename' INTO TABLE produto
     FIELDS TERMINATED BY ';' 
     LINES TERMINATED BY '\n' IGNORE 1 ROWS")){
        echo 'Carregado com sucesso!';
    }else{
        echo $conn->error;
    }
}else{
echo "Arquivo não existe!";
}

