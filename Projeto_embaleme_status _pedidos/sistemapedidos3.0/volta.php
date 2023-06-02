<?php
ini_set('display_errors', 0);
error_reporting(0);
session_start();

$funcionario = $_SESSION['colaborador'];
$data = $_SESSION['datahora'];
include "index.php";
$_SESSION['tipo'] = 'V';
?>
<!DOCTYPE html>
<html lang="en">

<body>


  <?php
  if ($_SESSION['message']) {
    echo "<div class='alert alert-danger' role='alert'>
        {$_SESSION['message']}
    </div>";
    unset($_SESSION['message']);
  }
  ?>


  <form action="tabela_volta.php" method="POST">
    <div class="container">
      <div class="card">
        <div class="card-header">
          Insira o Código da Caixa ou da Nota:
        </div>
        <div class="card-body">
          <h5 class="card-title">Digite a Chave da Nota Fiscal</h5>
          <input type="text" name="codigo" id="cod" placeholder="Digite o Código da Caixa!" autofocus="true" maxlength="44" minlength="44" class="form-control" id="exampleFormControlInput1">
          <p class="card-text">Atenção o campo aceita só aceita 44 caracteres, caso tenha menos será exibida uma mensagem.</p>
        </div>
      </div>
  </form>
  <?php
  include "conexao.php";
  $data = $_SESSION['datahora'];
  $funcionario = $_SESSION['colaborador'];
  $datanova = date('Y-m-d');
  //<!-- ------------------ SISTEMA DE PEDIDOS PINKING PACK v.1.0----------->
  //<!------------------------- ATUALIZADO 2021/08/25---07:21--------------->
  //<!------------- AUTOR GUILHERME TAIRA TODOS DIREITOS RESERVADO---------->

  // try {
  //   include_once 'teste/conexao_pdo.php';
  //   include_once 'estilos/bootrap.php';
  //   $statemente = $pdo->prepare("SELECT cod FROM codigo WHERE id=(SELECT max(id) FROM codigo where Tipo = 'V' and colaborador =?)");
  //   $statemente->bindValue(1, $funcionario, PDO::PARAM_INT);
  //   $statemente->execute();
  //   $notafiscal = $statemente->fetch();
  //   $numero_nota_fiscal = $notafiscal['cod'];

  //   $statemente = $pdo->prepare("SELECT id_pedido from codigo where cod =?");
  //   $statemente->bindValue(1, $numero_nota_fiscal, PDO::PARAM_INT);
  //   $statemente->execute();
  //   $n_notafiscal = $statemente->fetch();
  //   $numero_nota = $n_notafiscal['id_pedido'];

  //   $statemente = $pdo->query("SELECT * FROM pedidos where n_pedido = '$numero_nota'");
  //   $produtos = $statemente->fetchAll(PDO::FETCH_ASSOC);
  //   echo "<table class='table table-success table-striped'>";
  //   echo "<tr class='table-warning'><th>Descricão</th><th>Quantidade</th><th>Código de Barra</th></tr>";
  //   foreach ($produtos as $value) {
  //     echo "<tr class='table-warning'>";
  //     echo "<td>{$value['descricao']}</td>";
  //     echo "<td>{$value['quantidade']}</td>";
  //     echo "<td>{$value['EAN']}</td>";
  //     echo "</tr>";
  //   }
  //   echo "</table>";
  // } catch (\PDOException $th) {
  //   $th->getMessage();
  // }
  $sql = "SELECT cod, nome, datas, Tipo FROM `codigo` INNER JOIN colaborador on codigo.colaborador = colaborador.id where codigo.colaborador = $funcionario and datas like '$datanova%' and Tipo = 'V'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
      echo " <table class='table'>
                      <thead>
                        <tr>
                          <th scope='col'>Código</th>
                          <th scope='col'>Colaborador(a)</th>
                          <th scope='col'>Data</th>
                          <th scope='col'>Tipo</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>" . $row["cod"] . "</td>
                          <td>" . $row["nome"] . "</td>
                          <td>" . $row["datas"] . "</td>
                          <td>" . $row["Tipo"] . "</td>
                        </tr>
                      </tbody>
                    </table>";
    }
  } else {
    echo "<div class='alert alert-warning mt-4' role='alert'>
      Não Há registro de Volta Digitado
    </div>";
  }
  $conn->close();
  ?>
  </div>
</body>

</html>