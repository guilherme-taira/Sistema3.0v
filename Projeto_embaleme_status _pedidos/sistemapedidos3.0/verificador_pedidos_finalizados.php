<?php

class verificador extends insert
{


  function __construct($codigo, $funcionario, $data, $tipo, $market,$observacao,$n_pedido,$peso,$peso_loja,$divergencia_peso)
  {
    parent::__construct($codigo, $funcionario, $data, $tipo, $market,$observacao,$n_pedido,$peso,$peso_loja,$divergencia_peso);
  }

  function verifica_codigo()
  {
    
    ob_start();
    include_once 'index.php';
    include_once 'conexao.php';
      $sql = "SELECT * FROM codigo where cod = '$this->codigo' and Tipo = '$this->tipo'";
      
      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
        echo "
                  <div class='alert alert-danger' role='alert'>
                  Error: Código Já Cadastrado! <br>
                </div>";
      } else {
        $sql = "SELECT * FROM codigo where cod = '$this->codigo' and Tipo = '$this->tipo'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
          echo "
                   <div class='alert alert-danger' role='alert'>
                   Error: Código Já Cadastrado! <br>
                 </div>";
        } else {

          if (is_numeric($this->codigo)) {

            parent::insert_codigo($this->codigo, $this->funcionario, $this->data, $this->tipo, $this->market, $this->observacao, $this->n_pedido, $this->peso, $this->peso_loja,$this->divergencia_peso);
            //header(sprintf('location: %s', $_SERVER['HTTP_REFERER']));
            return $this->codigo + 0;
          } else if (is_string($this->codigo)) {
            echo "
                           <div class='alert alert-danger' role='alert'>
                           Error: Este código que você tentou cadastrar pode ser uma etiqueta, Verifique! <br>
                         </div>";
            return false;
          }
        }
      }
      ob_end_flush();
  }
}

session_start();
   
   $cod = $_POST['codigo'];
   $funcionario = $_SESSION['colaborador'];
   $data =  $_SESSION['datahora'];
   $tipo = 'F';
   $verifica = new verificador($codigo, $funcionario, $data, $tipo, $market,$observacao,$n_pedido,$peso,$peso_loja,$divergencia_peso);
   $verifica->verifica_codigo();
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
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
  </script>
</body>

</html>