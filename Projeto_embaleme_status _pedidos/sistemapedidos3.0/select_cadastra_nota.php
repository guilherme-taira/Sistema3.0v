<?php
session_start();
$funcionario = $_SESSION['colaborador'];
$data = $_SESSION['datahora'];
?>
<!DOCTYPE html>
<html lang="en">

<body>
  <?php
  include "index.php";
  $_SESSION['tipo'] = 'NF';
  ?>
  <form action="cadastra_nota_sistema.php" method="POST">

    <div class="container-sm">
      <div class="mb-3">
        <h3><span class="badge bg-warning text-dark">Insira a Chave de Acesso da Nota Fiscal:</span></h3>
        <input type="text" name="codigo" id="cod" placeholder="Digite o Código da Caixa!" autofocus="true" maxlength="44" minlength="44" class="form-control" id="exampleFormControlInput1" onblur="valida_pedido()">
      </div>
      <div>
        <label><span class="badge bg-info text-dark">
            <h4> Número do Pedido</h4>
          </span></label>

        <textarea class="form-control" name="n_pedido" id="numeropedido" value="" rows="1" placeholder="Digite o número do pedido" required></textarea>
        <div>
          <label><span class="badge bg-info text-dark">
              <h4> Observação da Nota - Digite primeiro a observação depois o número da nota </h4>
            </span></label>
        </div>
        <textarea class="form-control" name="observacao" id="exampleFormControlTextarea1" rows="3" placeholder="Digite a Observação da Nota"></textarea>
      </div>
  </form>

  <?php
  include "conexao.php";
  $data = $_SESSION['datahora'];
  $funcionario = $_SESSION['colaborador'];
  $datanova = date('Y-m-d');
  $sql = "SELECT codigo.id,cod, nome, datas, Tipo, local_mktplace FROM `codigo` 
    INNER JOIN colaborador on codigo.colaborador = colaborador.id 
    INNER JOIN codigo_mktplace on codigo_mktplace.id = codigo.id_mktplace 
    where codigo.colaborador = '$funcionario' and Tipo = 'NF'";
 
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
                            <th scope='col'>Plataforma</th>
                            <th scope='col'>Editar</th>
                            <th scope='col'>Eliminar</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>" . $row["cod"] . "</td>
                            <td>" . $row["nome"] . "</td>
                            <td>" . $row["datas"] . "</td>
                            <td>" . $row["Tipo"] . "</td>
                            <td>" . $row["local_mktplace"] . "</td>
                            <td><a href='editar_codigo.php?codigo={$row['id']}&Tipo={$_SESSION['tipo']}&Codigo={$row['cod']}'> <img src='imagens/pencil.png' class='rounded' style='width:30px'></a></td>
                            <td><a href='delete.php?codigo={$row['id']}&Tipo={$_SESSION['tipo']}'> <img src='imagens/bin.png' class='rounded' style='width:30px'></a></td>
                            </tr>
                        </tbody>
                      </table>";
    }
  } else {
    echo "
        <div class='alert alert-primary d-flex align-items-center' role='alert'>
        <svg class='bi flex-shrink-0 me-2' width='24' height='24' role='img' aria-label='Info:'><use xlink:href='#info-fill'/></svg>
        <div>
        Não há registro de nota fiscal cadastrada
        </div>
        </div>";
  }
  $conn->close();
  ?>

  <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
    <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
      <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
    </symbol>
    <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
      <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
    </symbol>
    <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
      <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
    </symbol>
  </svg>
  </div>
  </div>

  <script type="text/javascript">
    function valida_pedido() {
      var erro = false; // variavel erro inicia false;

      if (numeropedido.value === "") {
        erro = true;
      } else {
        erro = false;
      }

      if (erro === true) {
        numeropedido.style.background = "yellow";
        alert("Insira o número do pedido");
      } else {
        numeropedido.style.background = "red";
      }

      return (!erro);
    }
  </script>

</body>

</html>