<?php
ob_start();
session_start();
$funcionario = $_SESSION['colaborador'];
$data =  date ("Y-m-d H:i");
$tipo = $_SESSION['tipo'] = 'NF';
$codigo = $_POST['codigo'];
$observacao = $_POST['observacao'];
$market = $_SESSION['plataforma'];
$n_pedido = $_REQUEST['n_pedido'];
$peso = 2;
$peso_loja = 0;
$divergencia = 0;


include_once 'insert.php';


class cadastra_nota_fiscal extends insert
{

    function __construct($codigo, $funcionario, $data, $tipo, $market, $observacao, $n_pedido, $peso, $peso_loja, $divergencia)
    {
        parent::__construct($codigo, $funcionario, $data, $tipo, $market, $observacao, $n_pedido, $peso, $peso_loja, $divergencia);
    }

    function cadastra_nota()
    {
        include_once 'verificador_restricao_saida.php';
            $cadastra = new verificador($this->codigo, $this->funcionario, $this->data, $this->tipo, $this->market, $this->observacao, $this->n_pedido, $this->peso, $this->peso_loja, $this->divergencia_peso);
            $cadastra->verifica_codigo();
    } 
    

}

function get_peso($num)
{
    include_once 'teste/conexao_pdo.php';
    $conexao = new Banco;
    try {
        $conexao->pdo->beginTransaction();
        $statement = $conexao->pdo->query("SELECT sum(peso * quantidade) as peso_total from pedidos where n_pedido = $num");
        $peso = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($peso as $value) {
            $value['peso_total'];
        }
        $peso_total = number_format($value['peso_total'], 3, '.', ',');
        return $peso_total * 1000;
    } catch (\PDOException $th) {
        $th->getMessage();
        $conexao->pdo->rollBack();
    }
}


$cadastra = new cadastra_nota_fiscal($codigo, $funcionario, $data, $tipo, $market, $observacao, $n_pedido, get_peso($n_pedido), $peso_loja, $divergencia);
$cadastra->cadastra_nota();
ob_end_flush();
