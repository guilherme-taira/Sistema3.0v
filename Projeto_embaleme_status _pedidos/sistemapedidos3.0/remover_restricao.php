<?php
ob_start();
session_start();
include_once 'index.php';
$codigo = $_POST['numero'];

    class remove_restricao{

        private $numero;


        function __construct($numero)
        {
            $this->numero = $numero;
        }

        function apaga_restricao($numero){
            include_once 'conexao.php';
            $sql = "SELECT * FROM codigo where cod = '{$this->numero}'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $sql1 = "UPDATE codigo SET restricao = '0' where cod = '{$this->numero}'";
                $conn->query($sql1);
                echo "<div class='alert alert-success' role='alert'>
               Restrição Removida com Sucesso! Aguarde..
                </div>";
                header('refresh:2;url=index.php');
               } else {
                echo "<div class='alert alert-warning' role='alert'>
                    Error: Número de Nota Fiscal Não Encontrada;
                </div>";
                header('refresh:2;url=index.php');
               } 
           
           
            $conn->close();
        }

    }


$restricao = new remove_restricao($codigo);
$restricao->apaga_restricao($codigo);

?>


</script>
</body>
</html>