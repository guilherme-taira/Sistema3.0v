<?php

    class colaborador{

            private $nome;
            private $sobrenome;

            function __construct($nome,$sobrenome)
            {
                $this->nome = $nome;
                $this->sobrenome = $sobrenome;
            }

            function cadastra_funcionario(){
               
                if($this->nome == "" || $this->sobrenome == ""){
  
                    echo "<div class='alert alert-danger' role='alert'>
                        Verifique se há campos Vazios!
                 </div>";
                
                }else{
                    ob_start();
                    include "conexao.php";
                    include_once 'index.php';
                    $sql = "INSERT INTO colaborador (nome, sobrenome)
                    VALUES ('$this->nome','$this->sobrenome')";
            
                    
                    if ($conn->query($sql) === TRUE) {
                        echo "<div class='alert alert-success' role='alert'>
                         Colaborador Cadastrado Com Sucesso!
                      </div>";
                      header( "refresh:2;url=index.php");
                    } else {
                    echo "Error:" . $sql . "<br>" . $conn->error;
                    }
                    ob_end_flush();
            }
    }   

}  

$nome = $_POST['nome'];
$sobrenome = $_POST['sobrenome'];

$colaborador = new colaborador($nome,$sobrenome);
$colaborador->cadastra_funcionario();

?>