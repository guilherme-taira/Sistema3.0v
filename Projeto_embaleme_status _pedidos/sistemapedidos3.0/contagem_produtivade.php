<?php
include_once 'index.php';
    class contagem{

        private $codigo;
        private $colaborador;


        function __construct($colaborador,$conexao)
        {
  
            $this->colaborador = $colaborador;
            $this->conexao = $conexao;
        }


        function cadastra_romaneio(){
            include_once 'conexao.php';


            $sql = "INSERT INTO produtividade (nome) VALUES ('$this->colaborador')";
            
            if ($this->conexao->query($sql) === TRUE) {
                echo "<div class='alert alert-sucess' role='alert'>
                Salvo!
                </div>";
           

        }else{
            echo "Error:" . $sql . "<br>" . $this->conexao->error;
        }


    }
    }

?>