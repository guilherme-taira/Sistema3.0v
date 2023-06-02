<?php


class cadastra_produtivade
{

    private $nome;
    private $data;
    private $qtd;

    function __construct($nome, $data, $qtd)
    {
        $this->nome = $nome;
        $this->data = $data;
        $this->qtd =  $qtd;
    }
    public function addDados($nome, $data, $quantidade)
    {
        $this->itens[] = array($nome, $data, $quantidade);
    }

    public function getDados()
    {
        return $this->itens;
    }
    function getqtd()
    {
        return $this->qtd;
    }
    function getnome()
    {
        return $this->nome;
    }
    function getdata()
    {
        return $this->data;
    }
}

class Cadastra_tabela
{
    function cadastrar(cadastra_produtivade $lista)
    {
        $nome = $lista->getnome();
        $qtd = $lista->getqtd();
        $data = $lista->getdata();
        include_once 'conexao.php';
        include_once 'index.php';
        $datanova = date("Y-m-d");
        $sql = "SELECT cod, colaborador, datas, Tipo, count(cod) as Total FROM `codigo` INNER JOIN colaborador on codigo.colaborador = colaborador.id where datas like '%$datanova%' and Tipo = 'F' group by colaborador";
        echo " <form action='cadastra_produtividade.php' method='POST'>";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {

                $data = substr($row['datas'], 0, 10);
                $qtd = $row['Total'];
                $nome = $row['colaborador'];
                $sql = "INSERT INTO produtividade (Datas,Quantidade,Id_colaborador) values ('$data','$qtd','$nome')";
                $conn->query($sql);
            }
            if ($conn->query($sql) === TRUE) {
                echo "
                <div class='alert alert-Sucess' role='alert'>
                Dados Inserido na Tabela com Sucesso! <br>
              </div>";
                echo "<a href='index.php' class='btn btn-primary'>Voltar</a>";
            } else {
                echo "
                    <div class='alert alert-danger' role='alert'>
                    Error, Não Foi Possível cadastrar os dados na tabela, Verifique! <br>
                  </div>";
                echo "<a href='index.php' class='btn btn-primary'>Voltar</a>";
            }
        }
    }
}
$nome = $_POST['nome'];
$data = $_POST['datas'];
$qtd = $_POST['total'];
$cadastra = new cadastra_produtivade($nome, $data, $qtd);
$lista = new Cadastra_tabela;
$lista->cadastrar($cadastra);
