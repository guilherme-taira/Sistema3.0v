<?php

try {
    $soapcliente = new SoapClient('https://apphom.correios.com.br/SigepMasterJPA/AtendeClienteService/AtendeCliente?wsdl');
    $mostradados = $soapcliente->buscaCliente();
    var_dump($mostradados);

} catch (Exception $e) {
    $e->getMessage();
}

    

?>