<?php

abstract class Bridge {
    
    private Implementador $implementador;


    public function __construct(Implementador $implementador)
    {
        $this->implementador = $implementador;
    }

    /**
     * Set the value of implementador
     */
    public function setImplementador(Implementador $implementador): self
    {
        $this->implementador = $implementador;

        return $this;
    }

    public function VerificarStatus($invoice,$type,$weight,$weightDevolution,$colaborador,$id_mktplace,$observacao,$id_pedido,$peso_loja,$divergencia_peso,$restricao,$pendencia){
        $this->implementador->returnDataForInvoice($invoice,$type,$weight,$weightDevolution,$colaborador,$id_mktplace,$observacao,$id_pedido,$peso_loja,$divergencia_peso,$restricao,$pendencia);
    }

    public function Redirecionar($invoice,$type){
        $this->implementador->redirecionar($invoice,$type);
    }

    public function VerificarCadastrado($invoice,$type){
        return $this->implementador->verificarcadastrado($invoice,$type);
    }
}