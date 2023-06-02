<?php
include_once 'insert.php';
class verificador extends insert
{


  function __construct($codigo, $funcionario, $data, $tipo, $market, $observacao, $n_pedido, $peso, $peso_loja, $divergencia_peso)
  {
    parent::__construct($codigo, $funcionario, $data, $tipo, $market, $observacao, $n_pedido, $peso, $peso_loja, isset($divergencia_peso) ? $divergencia_peso : 0);
  }

  function verifica_codigo()
  {
    //  // div que da loading na pagina ... 
    //  echo "<div id='loader' class='loader'></div>";
    //  echo "<div style='display:none' id='tudo_page'></div>";
    $_SESSION['codigo'] = $this->codigo;

    ob_start();
    include_once 'conexao.php';
    include "APPEMBALEME/AppEmbalemeAuth.php";
    include_once "TrayPutPedido.php";

    $sql = "SELECT * FROM codigo WHERE cod = '$this->codigo' and restricao = 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      echo "<div class='alert alert-danger d-flex align-items-center' role='alert'>
      <svg class='bi flex-shrink-0 me-2' width='24' height='24' role='img' aria-label='Danger:'><use xlink:href='#exclamation-triangle-fill'/></svg>
      <div>
        Pedido: <strong> {$this->codigo}</strong> Cancelado, Não Enviar, Constatar o Sac ou Administrativo!
      </div>
    </div>";
      echo "<script> altBackgroundError(); </script>";
    } else {
      $sql = "SELECT * FROM codigo where cod = '$this->codigo' and Tipo = '$this->tipo'";
      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
        echo "<div class='alert alert-danger mt-4 d-flex align-items-center' role='alert'>
        <svg class='bi flex-shrink-0 me-2' width='24' height='24' role='img' aria-label='Danger:'><use xlink:href='#exclamation-triangle-fill'/></svg>
        <div>
          Código <strong> {$this->codigo}</strong> Já Cadastrado!
        </div>
      </div>";
        echo "<script> altBackgroundError();ca </script>";
      } else {

        if (is_numeric($this->codigo)) {
          // VERIFICA SE O PEDIDO ESTA SAINDO COM ZERO DE PESO E BARRA O CADASTRO!
          if ($this->peso_loja == 0) {
            echo "
            <div class='alert alert-danger mt-4' role='alert' id='tudo_page'>
            <h4 class='alert-heading'>Peso da Balança Esta Zerado, Verifique!</h4>
            <hr>
            </div>";

            echo "<script> altBackgroundError(); </script>";
            return false;
          }

          /**
           * ATUALIZAR PEDIDO DENTRO DA TRAY ATRAVÉS DO NUMERO DO PEDIDO 
           * 
           */

          $sql = "select numeropedidoloja from codigo inner join pedidos on codigo.id_pedido = pedidos.n_pedido where cod = '$this->codigo' LIMIT 1";
          $result = $conn->query($sql);
          if ($result->num_rows > 0) {

            // $result->fetch_assoc()['numeropedidoloja']
             $status = 342;
            // requisicao enviada para tray loja 
            $PutOrderTray = new PutOrderTray($_SESSION['access_token_tray'],$result->fetch_assoc()['numeropedidoloja'],$status,"");
            $PutOrderTray->resource();
          }



          parent::insert_codigo($this->codigo, $this->funcionario, $this->data, $this->tipo, $this->market, $this->observacao, $this->n_pedido, $this->peso, $this->peso_loja, $this->divergencia_peso);
          echo "<script> altBackgroundSuccess(); </script>";
          echo "
          <div class='alert alert-success mt-4' role='alert' id='tudo_page'>
          <h4 class='alert-heading'>Nota Fiscal Cadastrado com Sucesso!</h4>
          <hr>
          <p class='mb-0'><strong> NOTA FISCAL [{$this->codigo}] --- PESO TRAY [{$this->peso}] --- PESO LOJA [{$this->peso_loja}]</strong>.</p>
          </div>";

          $sql = "SELECT peso,peso_loja from codigo where cod = '$this->codigo' and Tipo = '$this->tipo'";
          $result = $conn->query($sql);

          if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
              $peso_loja = $row['peso_loja'];
              $peso_tray = $row['peso'];
            }

            if ($peso_loja > $peso_tray) {
              $peso_total = $peso_loja - $peso_tray;

              echo " <div class='alert alert-danger d-flex align-items-center' role='alert'>
              <svg class='bi flex-shrink-0 me-2' width='24' height='24' role='img' aria-label='Danger:'><use xlink:href='#exclamation-triangle-fill'/></svg>
              <div>
              Divergência de Peso :  $peso_total Kg
              </div>
              </div>";
            } else if ($peso_loja < $peso_tray) {
              $peso_total = $peso_loja - $peso_tray;

              echo " <div class='alert alert-warning d-flex align-items-center' role='alert'>
              <svg class='bi flex-shrink-0 me-2' width='24' height='24' role='img' aria-label='Danger:'><use xlink:href='#exclamation-triangle-fill'/></svg>
              <div class='text-center'>
                  Peso da Loja Está Menor que o Peso na Tray Verifique : <strong> $peso_total kg </strong>
              </div>
              </div>";
            }
          }
          $sql = "UPDATE codigo SET divergencia_peso =$peso_total WHERE cod = '$this->codigo'";
          $result = $conn->query($sql);

          header(sprintf('location: %s', $_SERVER['HTTP_REFERER']));
        } else if (is_string($this->codigo)) {
          echo "<script> altBackgroundError(); </script>";
          echo "
          <div class='alert alert-danger' role='alert'>
          Error: Este código que você tentou cadastrar pode ser uma etiqueta, Verifique!  <br>
        </div>";

          return false;
        }
      }
    }


    ob_end_flush();
  }
}
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

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>

<body>

  <audio id="audio">
    <source src="som/erro.mp3" type="audio/mp3" />
  </audio>

  <script type="text/javascript">
    audio = document.getElementById('audio');

    function play() {
      audio.play();
    }

    function altBackgroundError() {
      document.body.style.backgroundColor = 'red';

    }

    function altBackgroundSuccess() {
      document.body.style.backgroundColor = '#b2ff59';
    }


    function abrirIntegracao() {
      window.open('teste/integra_pedidos_data.php', "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=600");
    }
  </script>

  <!--- SCRIPT QUE DA O LOADING NA PAGINA-->
  <!-- <script type="text/javascript">
    $(document).ready(function() {
      $(".loader").delay(1000).fadeOut("fast"); //retire o delay quando for copiar!
      $("#tudo_page").toggle("fast");
    });
  </script> -->
</body>

</html>