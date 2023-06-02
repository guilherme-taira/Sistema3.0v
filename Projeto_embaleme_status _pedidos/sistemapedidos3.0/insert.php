<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Document</title>
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <?php

    class insert
    {
        protected $codigo;
        protected $funcionario;
        protected $data;
        protected $tipo;
        protected $market;
        protected $observacao;
        protected $n_pedido;
        protected $peso;
        protected $peso_loja;
        protected $divergencia_peso;

        function __construct($codigo, $funcionario , $data, $tipo, $market, $observacao, $n_pedido,$peso,$peso_loja,$divergencia_peso)
        {

            $this->codigo = $codigo;
            $this->funcionario = $funcionario;
            $this->data = $data;
            $this->tipo = $tipo;
            $this->market = $market;
            $this->observacao = $observacao;
            $this->n_pedido = $n_pedido;
            $this->peso = $peso;
            $this->peso_loja = $peso_loja;
            $this->divergencia_peso = $divergencia_peso;
        }

        function insert_codigo($codigo,$funcionario, $data, $tipo, $market, $observacao,$n_pedido,$peso = 0,$peso_loja,$divergencia_peso)
        {
            include "conexao.php";

            if(!$this->peso){
                $this->peso = 0;
            }
            
            if (!$this->funcionario == "" and !$this->codigo == "") {
                $sql = "INSERT INTO codigo (cod, colaborador,datas,Tipo, id_mktplace,observacao,id_pedido,peso,peso_loja,divergencia_peso,restricao,pendencia)
                   VALUES ('$this->codigo','$this->funcionario','$this->data','$this->tipo','$this->market','$this->observacao','$this->n_pedido','$this->peso','$this->peso_loja','$this->divergencia_peso','0','0')";
                if ($conn->query($sql) === TRUE) {
                   
                } else {
                    echo "Error:" . $sql . "<br>" . $conn->error;
                }
            }
        }

        function get_mktplace($codigo)
        {
            include "conexao.php";
            $sql = "SELECT id_mktplace from codigo where cod = '$codigo' and Tipo like '%NF'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {

                $_SESSION['valor'] = $row['id_mktplace'];
            } else {
                $conn->close();
                return false;
            }
            $valor = $_SESSION['valor'];
            $sql = "UPDATE codigo set id_mktplace = '$valor' where cod = '$codigo'";
            $result = $conn->query($sql);
        }
    }   




    function get_observacao($codigo)
    {
        include "conexao.php";
        $sql = "SELECT observacao,cod from codigo where cod = '$codigo' and Tipo like '%NF*'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='alert alert-success' role='alert'>
                <h4 class='alert-heading'>Well done!</h4>
                <p>Aww yeah, you successfully read this important alert message. This example text is going to run a bit longer so that you can see how spacing within an alert works with this kind of content.</p>
                <hr>
                <p class='mb-0'>Whenever you need to, be sure to use margin utilities to keep things nice and tidy.</p>
              </div>";
         }
        } else {
            $conn->close();
            return false;
        }
    }



    ?>


</body>

</html>