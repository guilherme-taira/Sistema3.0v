<?php
include_once 'index.php';
include_once 'teste/conexao_pdo.php';

$statement = $pdo->query("SELECT *, codigo.id as nota FROM codigo INNER JOIN colaborador ON colaborador.id = codigo.colaborador where Tipo = 'P' order by nome");
$pendencias = $statement->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="container mt-2">
  <div class="container-lg">
    <?php

    foreach ($pendencias as $pendencia) {
      echo "<div class='card text-center mt-4'>
    <div class='card-header alert alert-danger'>
      Pendência {$pendencia['nota']}
    </div>
    <div class='card-body'>
      <h5 class='card-title'>Cadastrada por <span>{$pendencia['nome']}</span></h5>
      <p class='card-text'>Data do Cadastro: <strong>{$pendencia['datas']}</strong></p>
      <a href='verPendencia.php?id={$pendencia['nota']}' class='btn btn-primary'>Ver Produtos</a>
      <a href='verPendencia.php?id={$pendencia['id']}' class='btn btn-danger' disabled>Apagar</a>
    </div>
    <div class='card-footer text-muted'>
       Chave da Nota Fiscal: {$pendencia['cod']}
    </div>
  </div>";
    }
    ?>
  </div>
</div>