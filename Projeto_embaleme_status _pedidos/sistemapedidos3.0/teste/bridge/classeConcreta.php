<?php

include "implementation.php";

class CadastrarInvoice extends Bridge {

    function gravar($invoice,$type,$weight,$weightDevolution,$colaborador,$id_mktplace,$observacao,$id_pedido,$peso_loja,$divergencia_peso,$restricao,$pendencia){
        parent::VerificarStatus($invoice,$type,$weight,$weightDevolution,$colaborador,$id_mktplace,$observacao,$id_pedido,$peso_loja,$divergencia_peso,$restricao,$pendencia);
    }
    

    function EncaminharUrl($invoice,$type){
        parent::Redirecionar($invoice,$type);
    }

}
