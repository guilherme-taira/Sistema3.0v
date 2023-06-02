<?php
//<!-- ------------------ SISTEMA DE PEDIDOS PINKING PACK----------------->
//<!-- ------------------------CLASS PEDIDOS------------------------------>
//<!------------------------- ATUALIZADO 2021/08/09 - 16:24--------------->
//<!------------- AUTOR GUILHERME TAIRA TODOS DIREITOS RESERVADO---------->
class pedido{

    public $produtos;
    public $n_pedido;

    public function __construct(String $n_pedido, array $produtos)
    {
        $this->produtos = $produtos;
        $this->n_pedido = $n_pedido;
    }
}