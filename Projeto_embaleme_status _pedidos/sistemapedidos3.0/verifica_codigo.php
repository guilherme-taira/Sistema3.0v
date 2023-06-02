<?php
class verificador
{

  function __construct($codigo, $tipo)
  {
    $this->codigo = $codigo;
    $this->tipo = $tipo;
  }


  function verifica_codigo()
  {

    ob_start();
    include_once 'index.php';
    include_once 'conexao.php';
    $sql = "SELECT * FROM codigo WHERE cod = '$this->codigo' and Tipo = 'S'"; // verifica se a nota ja esta no sistema e na saída
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {


      $sql = "SELECT * FROM codigo where cod = '$this->codigo' and Tipo = '$this->tipo'";
      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
        echo "
                <div class='alert alert-danger' role='alert'>
                Error: Código Já Cadastrado! <br>
              </div>";
      } else {

        include 'update.php';
        include_once 'teste/conexao_pdo.php'; // abre a conexao com o pdo.
        $conexao = new Banco;
        $statemente = $conexao->pdo->query("SELECT id_pedido,peso from codigo where cod = '$this->codigo' and Tipo = 'NF*' ");
        $pedido = $statemente->fetchAll(PDO::FETCH_ASSOC);
        foreach ($pedido as $value) {
          $n_pedido =  $value['id_pedido'];    // pega valor do numero do pedido do banco de dados
          $peso = $value['peso']; // pega o valor do peso do banco de dados
        }
        $n1 = 0;
        $cod = $_POST['codigo'];
        $funcionario = $_SESSION['colaborador'];
        $data =  $_SESSION['datahora'];
        $tipo = $_SESSION['tipo'];
        
        echo "<script> 
              document.location.href='teste/piking/preparaPedido.php?codigo=$cod&funcionario=$funcionario&data=$data&tipo=$tipo&n_pedido=$n_pedido&peso=$peso'; 
        </script>";
      }
  
    } else {
      echo "
              <div class='alert alert-danger' role='alert'>
              O código que você esta tentando cadastrar não esta na saida, Verifique! <br>
              </div>";
      echo "<a href='volta.php' class='btn btn-primary'>Voltar</a>";
    }
    ob_end_flush();
  }
}
?>

