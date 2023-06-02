<?php
ob_start();
session_start();
include_once 'insert.php';


class Verifica_duplicidade extends insert
{

    function __construct($codigo, $funcionario, $data, $tipo, $market,$observacao,$n_pedido,$peso,$peso_loja,$divergencia_peso)
    {
        parent::__construct($codigo, $funcionario, $data, $tipo, $market,$observacao,$n_pedido,$peso,$peso_loja,$divergencia_peso);
    }

    function get_market_place()
    {
        include "conexao.php";
        $sql = "SELECT id_mktplace from codigo where cod ='$this->codigo' and Tipo = 'NF*'";
        $result = mysqli_query($conn, $sql);
        $datarow = mysqli_fetch_object($result);
        $id = $datarow->id_mktplace;
        if ($id == 1) {
            return 1;
        } else if ($id == 2) {
            return 2;
        } else if ($id == 0) {
            echo "Não foi cadastrado em nenhum market place";
        }
        $conn->close();
    }
    
    function verifica_codigo_duplicado()
    {
        include 'index.php';
        include "conexao.php";
        $sql = "SELECT * FROM codigo WHERE cod = '$this->codigo' and Tipo = 'V'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $sql = "SELECT * FROM codigo where cod = '$this->codigo' and Tipo = '$this->tipo'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                echo "
                        <div class='alert alert-danger' role='alert'>
                        Error: Código Já Cadastrado! <br>
                    </div>";
            } else {
                if (is_numeric($this->codigo)) {
                    $this->market = $this->get_market_place(); // pega o local da venda - MARKETPLACE / SITE
                
                    parent::insert_codigo($this->codigo, $this->funcionario, $this->data, $this->tipo, $this->market,$this->observacao,$this->n_pedido,$this->peso,$this->peso_loja,$this->divergencia_peso);
                    header(sprintf('location: %s', $_SERVER['HTTP_REFERER']));
                    echo "Cadastrado Com Sucesso!";
                    return $this->codigo + 0;
                } else {
                    echo "
                                <div class='alert alert-danger' role='alert'>
                                Error: Este código que você tentou cadastrar pode ser uma etiqueta, Verifique! <br>
                            </div>";
                    return false;
                }
            }
        } else {
            echo "
        <div class='alert alert-danger' role='alert'>
        O código que você esta tentando cadastrar Não Esta na Volta, Verifique! <br>
      </div>";
        }
    }
}

$codigo = $_POST['codigo'];
$funcionario = $_SESSION['colaborador'];
$data =  $_SESSION['datahora'];
$tipo = $_SESSION['tipo'];
$market = 0;
$observacao = "";
$peso_loja = 0;
$divergencia_peso = 0;

include_once 'teste/conexao_pdo.php'; // abre a conexao com o pdo.
$conexao = new Banco;
$statemente = $conexao->pdo->query("SELECT id_pedido,peso from codigo where cod = '$codigo' and Tipo = 'NF*' ");
$pedido = $statemente->fetchAll(PDO::FETCH_ASSOC);
foreach ($pedido as $value) {
    $n_pedido =  $value['id_pedido'];    // pega valor do numero do pedido do banco de dados
    $peso = $value['peso']; // pega o valor do peso do banco de dados
}

$verificador = new Verifica_duplicidade($codigo, $funcionario, $data, $tipo, $market,$observacao,$n_pedido,$peso,$peso_loja,$divergencia_peso);
$verificador->verifica_codigo_duplicado();
ob_end_flush();
