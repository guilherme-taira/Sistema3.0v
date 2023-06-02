<?php
session_start();
$funcionario = $_SESSION['colaborador'];
$data = $_SESSION['datahora'];
$_SESSION['tipo'] = 'P';
?>
<!DOCTYPE html>
<html lang="en">

<body>
  <?php
  include "index.php";
  ?>

  <div class="container">
    <?php
    include "conexao.php";
    $data = $_SESSION['datahora'];
    $funcionario = $_SESSION['colaborador'];
    $datanova = date('Y-m-d');
    $sql = "SELECT cod, nome, datas, Tipo FROM `codigo` INNER JOIN colaborador on codigo.colaborador = colaborador.id where codigo.colaborador = $funcionario and datas like '$datanova%' and Tipo = 'P'";
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
      echo "Não Há pendências cadastradas";
    }
    $conn->close();
    ?>
  </div>
</body>

</html>