<?php
ob_start();
session_start();
include_once 'index.php';
$codigo = $_POST['numero'];
$tipo_servico = $_POST['options-outlined'];

var_dump($tipo_servico);

    class Restricao{

        private $numero;

        function __construct($numero,$tipo_servico)
        {
            $this->numero = $numero;
            $this->tipo_servico = $tipo_servico;
        }

        function cadastra_restricao($numero){
            include_once 'conexao.php';
            $sql = "SELECT * FROM codigo where cod = '{$this->numero}'";
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {

                if($this->tipo_servico == NULL)
                $sql1 = "UPDATE codigo SET restricao = '1' where cod = '{$this->numero}'";
                $conn->query($sql1);
                echo "<div class='alert alert-success' role='alert'>
               Restrição Cadastrada com Sucesso! Aguarde..
                </div>";
                header('refresh:3;url=index.php');
               } else {
                echo "<div class='alert alert-warning' role='alert'>
                    Error: Número de Nota Fiscal Não Encontrada;
                </div>";
                header('refresh:3;url=index.php');
               } 
           
           
            $conn->close();
        }

    }


$restricao = new Restricao($codigo,$tipo_servico);
$restricao->cadastra_restricao($codigo);

?>


</script>
</body>
</html>