<?php
ob_start();
session_start();


class edita_ocorrencia
{
    private $id;
    private $chave_nota;
    private $status;
    private $embalo;
    private $datas;
    private $n_pedido;
    private $prejuizo;

    function __construct($id, $chave_nota,$status,$prejuizo,$embalo, $datas, $n_pedido)
    {
        $this->id = $id;
        $this->chave_nota = $chave_nota;
        $this->status = $status;
        $this->prejuizo = $prejuizo;
        $this->embalo = $embalo;
        $this->datas = $datas;
        $this->n_pedido = $n_pedido;
    }

    function edita_valores_ocorrencias()
    {
        include_once 'index.php';
        include_once 'conexao.php';

        $sql = "UPDATE ocorrencias set chave_nf = '$this->chave_nota', status_oc = '$this->status', colaborador_id = $this->embalo, datas='$this->datas', n_pedido = '$this->n_pedido', prejuizo = $this->prejuizo where id = $this->id";
        $conn->query($sql);    
        $result = $conn->query($sql);
            if ($result == TRUE) {
                echo "<div class='alert alert-success' role='alert'>
            Ocorrencia Alterada Com Sucesso, Aguarde..
            </div>";
            header('refresh:1;url=painel_ocorrencia.php');
            
        } else {
            echo $conn->error;
            echo "<div class='alert alert-Danger' role='alert'>
            Erro ao Alterar valor dos campos, Verifique Aguarde..
            </div>";
        }
    }
}

$id = $_POST['id'];
$chave_nota = $_POST['nota_nf'];
$status = $_POST['status'];
$embalo = $_POST['embalou'];
$datas = $_POST['data'];
$n_pedido = $_POST['n_pedido'];
$prejuizo = $_POST['prejuizo'];

$altera_valor = new edita_ocorrencia($id,$chave_nota,$status,$prejuizo,$embalo,$datas,$n_pedido);
$altera_valor->edita_valores_ocorrencias();
