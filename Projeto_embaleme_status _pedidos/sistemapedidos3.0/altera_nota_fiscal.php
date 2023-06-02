<?php
ob_start();
session_start();

$codigo = $_POST['codigo'];
$chave_nota = $_POST['numero'];

class altera_nota_fiscal
{

    private $codigo;
    private $chave_nota;

    function __construct($codigo, $chave_nota)
    {
        $this->codigo = $codigo;
        $this->chave_nota = $chave_nota;
    }

    function inverte_valor_nota()
    {
        include_once 'index.php';
        include_once 'conexao.php';

        $sql = "SELECT * from codigo where cod = '$this->codigo'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $sql = "UPDATE codigo set cod = '$this->chave_nota' where cod = '$this->codigo'";
            $conn->query($sql);
            $sql = "SELECT * from codigo where cod = '$this->chave_nota'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                echo "<div class='alert alert-success' role='alert'>
            Nota Fiscal Atualizada Com Sucesso, Aguarde..
            </div>";
            header('refresh:1;url=index.php');
            }
        } else {
            echo "<div class='alert alert-Danger' role='alert'>
            Erro ao Alterar valor da Nota, Verifique Aguarde..
            </div>";
        }
    }
}
$altera_valor = new altera_nota_fiscal($codigo, $chave_nota);
$altera_valor->inverte_valor_nota();
