<?php
ob_start();
include_once 'insert.php';

    class Verifica_duplicidade extends insert{

      function __construct($codigo, $funcionario, $data, $tipo, $market, $observacao, $n_pedido, $peso, $peso_loja, $divergencia_peso)
      {
       parent::__construct($codigo, $funcionario, $data, $tipo, $market, $observacao, $n_pedido, $peso, $peso_loja, $divergencia_peso);
      }
       

      
        function verifica_codigo_duplicado(){
  
            include 'index.php';
            include "conexao.php"; 
            $sql = "SELECT * FROM codigo where cod = '$this->codigo' and Tipo = '$this->tipo'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                echo "
                <div class='alert alert-danger' role='alert'>
                Error: Código Já Cadastrado! <br>
              </div>";
            }else{
         
                if(is_numeric($this->codigo)){
                   
                  parent::insert_codigo($this->codigo, $this->funcionario, $this->data, $this->tipo, $this->market, $this->observacao, $this->n_pedido, $this->peso, $this->peso_loja,$this->divergencia_peso);
                  header("Location:pendencia.php");
                  return $this->codigo + 0; 
                    }
                    else{
                        echo "
                        <div class='alert alert-danger' role='alert'>
                        Error: Este código que você tentou cadastrar pode ser uma etiqueta, Verifique! <br>
                      </div>";
                      return false;
                    }
        }

    }
}
session_start();  
$cod = $_POST['codigo'];
$funcionario = $_SESSION['colaborador'];
$data =  $_SESSION['datahora'];
$tipo = "P";
$market = "";
$observacao = $_REQUEST['observacao'];
$peso_loja = $_REQUEST['peso_loja'];
include_once 'teste/conexao_pdo.php'; // abre a conexao com o pdo.
$statemente = $pdo->query("SELECT id_pedido,peso from codigo where cod = '$cod' and Tipo = 'F' ");
$pedido = $statemente->fetchAll(PDO::FETCH_ASSOC);
foreach ($pedido as $value) {
  $n_pedido =  $value['id_pedido'];    // pega valor do numero do pedido do banco de dados
  $peso = $value['peso']; // pega o valor do peso do banco de dados
}

$verifica = new Verifica_duplicidade($cod, $funcionario, $data, $tipo, $market,$observacao,$n_pedido,$peso,$peso_loja,$divergencia_peso);
$verifica->verifica_codigo_duplicado();
ob_end_flush();
?>