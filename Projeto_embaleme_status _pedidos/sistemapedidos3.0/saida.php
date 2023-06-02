<?php
session_start();
include "index.php";
ini_set('display_errors', 0);
error_reporting(0);

$funcionario = $_SESSION['colaborador'];
$data = $_SESSION['datahora'];
$_SESSION['tipo'] = 'S';
?>

<div class="container-sm mt-4">

  <div id="resultadoQuery"></div>

  <p class="h5">Insira o Código da Caixa ou da Nota: </p>
  <p>Atenção o campo aceita só aceita 44 caracteres, caso tenha menos será exibida uma mensagem.</p>
  <input type="text" name="codigo" id="codigo" placeholder="Digite o Código da Caixa!" maxlength="44" minlength="44" class="form-control" id="exampleFormControlInput1">

  <div id="atualiza">
    <?php
    include "conexao.php";
    $data = $_SESSION['datahora'];
    $funcionario = $_SESSION['colaborador'];
    $datanova = date('Y-m-d');

    $sql = "SELECT cod, colaborador,datas, nome, Tipo, codigo.id as idCodigo FROM codigo
      INNER JOIN colaborador on colaborador.id = codigo.colaborador
      WHERE datas like '%$datanova%' and colaborador = $funcionario and Tipo = 'S'";
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
                          <td>" . $row["cod"] . '<a href=editar_codigo.php?codigo=' . $row["idCodigo"] . '>Editar</a>' . "</td> 
                          <td>" . $row["nome"] . "</td>
                          <td>" . $row["datas"] . "</td>
                          <td>" . $row["Tipo"] . "</td>
                        </tr>
                      </tbody>
                    </table>";
      }
    } else {
      echo "<br>
              <div class='alert alert-primary d-flex align-items-center' role='alert'>
              <svg class='bi flex-shrink-0 me-2' width='24' height='24' role='img' aria-label='Info:'><use xlink:href='#info-fill'/></svg>
              <div>
                Não Há registro de Saída Digitado
              </div>
              </div>";
    }
    $conn->close();
    ?>
  </div>
</div>

<script>
  $("#codigo").focus();
  $(document).ready(function() {
    $("#codigo").on("keydown", function(event) {
      if (event.which === 13) {
        InsertSaidaStatus();
        $("#codigo").val("");
      }
    });
  });

  function update() {
    $('#atualiza').load("saida.php #atualiza");
  }
  setInterval('update()', 1000);
</script>