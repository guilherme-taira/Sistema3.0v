<?php
//<!-- ------------------ SISTEMA DE PEDIDOS PINKING PACK----------------->
//<!-- ------------------------CLASS PRODUTOS=---------------------------->
//<!------------------------- ATUALIZADO 2021/08/09 - 16:24--------------->
//<!------------- AUTOR GUILHERME TAIRA TODOS DIREITOS RESERVADO---------->
class produto{

    public $descricao;
    public $quantidade;
    public $ean;
    public $img;
    public $sku;

    function __construct($descricao, $quantidade, $ean,$sku)
    {
        $this->descricao = $descricao;
        $this->quantidade = $quantidade;
        $this->ean = $ean;
        // $this->img = $img;
        $this->sku = $sku;
    }

    /**
     * Get the value of descricao
     */
    
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * Set the value of descricao
     */
    public function setDescricao($descricao): self
    {
        $this->descricao = $descricao;

        return $this;
    }

    /**
     * Get the value of quantidade
     */
    public function getQuantidade()
    {
        return $this->quantidade;
    }

    /**
     * Set the value of quantidade
     */
    public function setQuantidade($quantidade): self
    {
        $this->quantidade = $quantidade;

        return $this;
    }

    /**
     * Get the value of ean
     */
    public function getEan()
    {
        return $this->ean;
    }

    /**
     * Set the value of ean
     */
    public function setEan($ean): self
    {
        $this->ean = $ean;

        return $this;
    }

    public function setImg($img): self
    {
        $this->img = $img;

        return $this;
    }

    public function getImg(): self
    {
        return $this->img;
    }
    


    public function retiraQuantidade($quantidade){
        $this->quantidade = $quantidade - 1;
        return $this;
    }

    
    public function colocaQuantidade($quantidade){
        $this->quantidade = $quantidade + 1;
        return $this;
    }

    /**
     * Get the value of sku
     */ 
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * Set the value of sku
     *
     * @return  self
     */ 
    public function setSku($sku)
    {
        $this->sku = $sku;

        return $this;
    }

}

?>