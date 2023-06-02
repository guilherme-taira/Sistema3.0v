<?php
ob_start();

class editar{

    private $chave;
    private $observacao;
    private $id_mktplace;
    private $id;
    
    function __construct($chave,$observacao,$id_mktplace,$id)
    {
        $this->chave = $chave;
        $this->observacao = $observacao;
        $this->id_mktplace = $id_mktplace;
        $this->id = $id;
    }
    

    function editar_codigo(){
        include_once 'teste/conexao_pdo.php'; // instacia uma nova conexão com o PDO
        try {
            $statemente = $pdo->prepare("UPDATE codigo SET cod = ?, observacao = ?, idmktplace = ? WHERE id = ?"); // conexao com o PDO preparando a query para editar
            $statemente->bindParam(1, $this->chave, PDO::PARAM_STR);
            $statemente->bindParam(2, $this->observacao, PDO::PARAM_STR);
            $statemente->bindParam(3, $this->id_mktplace, PDO::PARAM_INT);
            $statemente->bindParam(4, $this->id, PDO::PARAM_STR);
            $statemente->execute();
            var_dump($statemente);
        } catch (\PDOException $th) {
            echo "Error". $th->getMessage();
        }
    
        echo "Nota Fiscal Alterada com sucesso! Aguarde..";
        echo " echo<script>history.go(-2);</script>";
    }
}

$chave = $_REQUEST['chave'];
$observacao = $_REQUEST['observacao'];
$id = $_REQUEST['id'];
$classe = new editar($chave,$observacao,$id_mktplace,$id);
$classe->editar_codigo();
ob_end_flush();
?>