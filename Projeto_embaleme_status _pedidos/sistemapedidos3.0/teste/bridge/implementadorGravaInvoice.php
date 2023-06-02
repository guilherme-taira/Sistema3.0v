<?php
include "interfaceImplementador.php";
include "CadastrarInvoiceDB.php";
include "conexao_pdo.php";

class ImplementadorType implements Implementador
{

    public Banco $conexao;

    public function returnDataForInvoice($invoice, $type, $weight, $weightDevolution, $colaborador, $id_mktplace, $observacao, $id_pedido, $peso_loja, $divergencia_peso, $restricao, $pendencia)
    {
        $data = new DateTime();
        $conexao = new Banco();
        $invoice = new SaveInvoice($invoice, $type, "15000", $data, "15500", $conexao->pdo, 1, 1, "", "159140", "14000", 0, 0, 0);
        $invoice->rules();
    }

    public function verificarcadastrado($invoice, $type)
    {
        include_once 'conexao_pdo.php'; // abre a conexao com o pdo.
        $conexao = new Banco;
        $statemente = $conexao->pdo->query("SELECT tipo from codigo where cod = $invoice and Tipo = '$type' ");
        $pedido = $statemente->fetchAll(PDO::FETCH_ASSOC);
        if (count($pedido) > 0) {
            return false;
        }
        return true;
    }

    public function redirecionar($invoice, $type)
    {
        switch ($type) {
            case 'V':
                include_once 'conexao_pdo.php'; // abre a conexao com o pdo.
                $conexao = new Banco;
                $statemente = $conexao->pdo->query("SELECT id_pedido,peso from codigo where cod = $invoice and Tipo = 'NF*' ");
                $pedido = $statemente->fetchAll(PDO::FETCH_ASSOC);
                foreach ($pedido as $value) {
                    $n_pedido =  $value['id_pedido'];    // pega valor do numero do pedido do banco de dados
                    $peso = $value['peso']; // pega o valor do peso do banco de dados
                }

                $cod = $invoice;
                $funcionario = 1;
                $data = Date('Y-m-d');
                $tipo = $type;
                echo "<script> 
                    document.location.href='teste/piking/preparaPedido.php?codigo=$cod&funcionario=$funcionario&data=$data&tipo=$tipo&n_pedido=$n_pedido&peso=$peso'; 
                </script>";
                break;
            case 'D':
                # code...
                break;

            default:
                # code...
                break;
        }
    }
}
