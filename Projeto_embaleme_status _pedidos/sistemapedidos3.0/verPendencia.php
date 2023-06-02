<?php
include_once 'index.php';
include_once 'teste/conexao_pdo.php';

$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;

if ($id == 0) {
  echo "
    <div class='alert alert-danger' role='alert'>
    Error: Este código que você digitou não esta na Pendência, Verifique! <br>
  </div>";
}

// PESQUISA DOS DADOS NO BANCO
$statement = $pdo->query("SELECT * FROM codigo WHERE id = $id");
$pendencias = $statement->fetch();
?>

<div class="container-lg">
  <div class="card">
    <div class="card-body alert alert-danger text-center">
      Pendência Produtos
    </div>
  </div>
  <?php
  /**
   * CLASE QUE UNSERIALIZE O PEDIDO
   * 
   **/

  include_once 'teste/piking/produto.php';
  $dados = $pendencias['pendencia'];
  $pedidos = unserialize($dados);


  echo "<div class='container'>
<div class='row'>";
  foreach ($pedidos as $produtos) {
    if (is_object($produtos) || is_array($produtos)) {
        foreach ($produtos as $produto) {
            if ($produto->quantidade > 0) {
                echo "<div class='col'>
        <div class='card'>
          <img src='{$produto->img}' style='width:150px; height:150px;' alt='FOTO'>
          <div class='card-body'>
            <p class='card-text'>{$produto->descricao}</p>
            <h5 class='card-text'>Quantidade Restante: {$produto->quantidade}</h5>
          </div>  
        </div>
        </div>";
            }
        }
    }
  }
  "</div>
  </div>";

  ?>
</div>