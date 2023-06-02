<?php

interface Implementador {
    public function returnDataForInvoice($invoice,$type,$weight,$weightDevolution,$colaborador,$id_mktplace,$observacao,$id_pedido,$peso_loja,$divergencia_peso,$restricao,$pendencia);
    public function redirecionar($invoice,$type);
    public function verificarcadastrado($invoice,$type);
}

?>