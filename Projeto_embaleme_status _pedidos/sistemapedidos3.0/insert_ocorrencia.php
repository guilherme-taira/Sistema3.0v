<?php
ob_start();
include_once 'index.php';
$diretorio = "imagens/";
$nome_pasta = "{$_REQUEST['n_pedido']}";

if(is_dir($diretorio)){

    mkdir("./imagens/".$nome_pasta);
    $arquivo = isset($_FILES['arquivo']) ? $_FILES['arquivo'] : FALSE;
	for ($controle = 0; $controle < count($arquivo['name']); $controle++){
		
		$destino = $diretorio."{$nome_pasta}/".$arquivo['name'][$controle];
		if(move_uploaded_file($arquivo['tmp_name'][$controle], $destino)){
			echo "Upload realizado com sucesso<br>"; 
		}else{
			echo "Erro ao realizar upload";
		}
		
	}
}
final class cadastra_ocorrencia
{
    private $chave_nota;
    private $prejuizo;
    private $resp_ocorrencia;
    private $resp_embalo;
    private $num_pedido;
    private $status;
    private $resp_embalo2;
    private $resp_embalo3;
    private $resp_embalo4;
    private $resolucao;
    private $data_origem_erro;
    private $data_resolucao_erro;
    private $observacao;
    private $datas;

    function __construct($chave_nota, $resp_ocorrencia, $prejuizo, $datas, $resp_embalo, $num_pedido, $status, $observacao, $resolucao, $data_origem_erro, $data_resolucao_erro, $resp_embalo2, $resp_embalo3, $resp_embalo4)
    {
        $this->chave_nota = $chave_nota;
        $this->prejuizo = $prejuizo;
        $this->datas = $datas;
        $this->resp_ocorrencia = $resp_ocorrencia;
        $this->resp_embalo = $resp_embalo;
        $this->num_pedido = $num_pedido;
        $this->status = $status;
        $this->observacao = $observacao;
        $this->resolucao = $resolucao;
        $this->resp_embalo2 = $resp_embalo2;
        $this->resp_embalo3 = $resp_embalo3;
        $this->resp_embalo4 = $resp_embalo4;
        $this->data_origem_erro = $data_origem_erro;
        $this->data_resolucao_erro = $data_resolucao_erro;
    }

    function insert_ocorrencia()
    {

        include_once 'conexao.php';

        $sql = "INSERT INTO ocorrencias (chave_nf,colaborador_id,prejuizo,datas,observacao,status_oc,n_pedido,responsavel,resolucao,data_resolucao,data_origem_erro,responsavel2,responsavel3,responsavel4) VALUES ('$this->chave_nota','$this->resp_embalo','$this->prejuizo','$this->datas','$this->observacao','$this->status','$this->num_pedido','$this->resp_ocorrencia','$this->resolucao','$this->data_resolucao_erro','$this->data_origem_erro','$this->resp_embalo2','$this->resp_embalo3','$this->resp_embalo4')";

        $result = $conn->query($sql);
        if ($result == TRUE) {
            echo "<div class='alert alert-sucess' role='alert'>
            Cadastrado com sucesso!
            </div>";
            header('refresh:2;url=painel_ocorrencia.php');
        } else {
            echo $conn->error;
        }

        $conn->close();
    }
}


// Váriaveis que irão inserir dados no banco através do método POST

$chave_nota = $_POST['chave_nota'];
$prejuizo = $_POST['prejuizo'];
$resp_ocorrencia = $_POST['resp_ocorrencia'];
$datas = $_POST['data'];
$resp_embalo = $_POST['resp_embalo'];
$num_pedido = $_POST['n_pedido'];
$status = $_POST['status'];
$observacao = $_POST['observacao'];
$data_origem_erro = $_POST['data_origem_erro'];
$data_resolucao_erro = $_POST['data_resolucao_erro'];


// função que muda o traço da data
preg_replace("/-/", '/', $data_resolucao_erro);
preg_replace("/-/", '/', $data_origem_erro);
preg_replace("/-/", '/', $datas);

// fim da função

$resp_embalo2 = $_POST['resp_embalo2'];
$resp_embalo3 = $_POST['resp_embalo3'];
$resp_embalo4 = $_POST['resp_embalo4'];
$resolucao = $_POST['resolucao'];
$cadastra_nova_ocorrencia = new cadastra_ocorrencia($chave_nota, $resp_ocorrencia, $prejuizo, $datas, $resp_embalo, $num_pedido, $status, $observacao, $resolucao, $data_origem_erro, $data_resolucao_erro, $resp_embalo2, $resp_embalo3, $resp_embalo4);
$cadastra_nova_ocorrencia->insert_ocorrencia();
ob_end_flush();
