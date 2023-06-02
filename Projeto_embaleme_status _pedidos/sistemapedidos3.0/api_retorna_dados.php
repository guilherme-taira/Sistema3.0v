<?php


$cliente = new soapclient('https://apphom.correios.com.br/SigepMasterJPA/AtendeClienteService/AtendeCliente?wsdl');

$parametros = array('tipoDestinatario'=>'C',
                    'Identificador'=>'00458459000133',
                    'idServico'=>'124849',
                    'qtdEtiquetas'=>'1',
                    'Usuário'=>'19259212',
                    'senha'=>'00458459'
);

$server = $cliente->__call('solicitaEtiquetas',array($parametros));






?>