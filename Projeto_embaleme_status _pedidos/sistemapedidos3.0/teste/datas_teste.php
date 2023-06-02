<?php
  include_once 'conexao_pdo.php';

  try {
      $pdo->beginTransaction();
      $statemente = $pdo->prepare("SELECT cod FROM codigo WHERE id=(SELECT max(id) FROM codigo where Tipo = 'V' and colaborador =?)");
      $statemente->bindValue(1,$funcionario,PDO::PARAM_INT);
      $statemente->execute();
      $notafiscal = $statemente->fetch();
      $numero_nota_fiscal = $notafiscal['cod'];


      $statemente = $pdo->prepare("SELECT id_pedido from codigo where cod =?");
      $statemente->bindValue(1,$numero_nota_fiscal,PDO::PARAM_INT);
      $statemente->execute();
      $n_notafiscal = $statemente->fetch();
      $numero_nota = $n_notafiscal['id_pedido'];
      
      $statemente = $pdo->query("SELECT * FROM pedidos where n_pedido = '$numero_nota'");
      $produtos = $statemente->fetchAll(PDO::FETCH_ASSOC);
      echo "<table border>";
      echo "<tr><th>Descricão</th><th>Quantidade</th><th>Código de Barra</th></tr>";
      foreach ($produtos as $value) {
          echo "<tr>";
          echo "<td>{$value['descricao']}</td>";
          echo "<td>{$value['quantidade']}</td>";
          echo "<td>{$value['EAN']}</td>";
          echo "</tr>";
      }
      echo "</table>";
      
      $pdo->commit();
  } catch (\PDOException $th) {
      $th->getMessage();
      $th->getCode();
      $pdo->rollBack();
  }



