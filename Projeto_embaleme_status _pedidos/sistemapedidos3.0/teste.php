<?php

    final class Produto{

        public function __construct($descricao,$estoque,$preco_custo)
        {
            $this->descricao = $descricao;
            $this->estoque = $estoque;
            $this->preco_custo = $preco_custo;
        }

        public function getDescricao(){
            return $this->descricao;
        }
    }


    Final class Venda{
        private $id;
        private $itens;

        function __construct($id)
        {
            $this->id = $id;
        }

        function getId(){
            return $this->id;
        }

        public function addItem($quantidade, Produto $produto){
            $this->itens[] = array($quantidade,$produto);

        }

        public function getItens(){
            return $this->itens;
        }
    }

        Final class VendaMapper{

            function insert(Venda $venda){
            $id = $venda->getId();
            date_default_timezone_set('America/Sao_Paulo');
            $date = date("Y-m-d");

            $sql = "INSERT INTO venda (id,data) values ('$id','$date')";
            echo $sql . "<br>";
            foreach ($venda->getItens() as $item) {
                $quantidade = $item[0];
                $produto = $item[1];
                $descricao = $produto->getDescricao();

                $sql = "INSERT INTO venda_itens (ref_venda,produto,quantidae)".
                "values ('$id','$descricao','$quantidade')";
                echo $sql . "<br>";
            }
         }
    }


    $venda = new Venda(1000);
    $venda->addItem(3, new Produto('Vinho',10,15));
    $vendaMapper = new VendaMapper;
    $vendaMapper->insert($venda);

?>