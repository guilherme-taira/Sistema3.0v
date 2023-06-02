<?php
ob_start();
class delete
{
    private $chave;
    private $tipo;

    function __construct($chave,$tipo)
    {   
        $this->chave = $chave;
        $this->tipo = $tipo;
    }

    function deletar(){
        include_once 'teste/conexao_pdo.php';

        try {
            $statement = $pdo->prepare("DELETE FROM codigo WHERE id = :numero and Tipo = :tipo");
            $statement->bindParam(':numero',$this->chave, PDO::PARAM_STR);
            $statement->bindParam(':tipo',$this->tipo, PDO::PARAM_STR);
            $statement->execute();

            echo "Nota Fiscal removida com sucesso! Aguarde..";
            header('Refresh: 2; URL=https://portaldocomputador.com.br/SistemaPedidos/dashboard.php');

        } catch (\PDOException $e) {
            echo "Error: " . $e->getMessage()."<br>";
        }
    }
}

$chave = $_REQUEST['codigo'];
$tipo = $_REQUEST['Tipo'];

$deletar = new delete($chave,$tipo);
$deletar->deletar();
ob_end_flush();