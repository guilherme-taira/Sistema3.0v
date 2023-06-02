<?php

include_once 'teste/conexao_pdo.php';

$data_inicial = $_REQUEST['data_inicial'];
$data_final = $_REQUEST['data_final'];

if (isset($_REQUEST['nome'])) {

    $nome = $_REQUEST['nome'];
    if (empty($nome)) {
        echo "Vazio";
        $statement = $pdo->query("SELECT nome FROM colaborador");
    } else {


        $statement = $pdo->query("SELECT chave_nf,data_origem_erro, data_resolucao, datas,status_oc,n_pedido, prejuizo,ocorrencias.id as id_oc, (select nome from colaborador where ocorrencias.colaborador_id = colaborador.id) as embalou, (select nome from colaborador where ocorrencias.responsavel = colaborador.id) as sac from ocorrencias INNER JOIN colaborador on ocorrencias.responsavel = colaborador.id WHERE ocorrencias.responsavel = $nome or ocorrencias.responsavel = $nome or ocorrencias.responsavel2 = $nome OR ocorrencias.responsavel3 = $nome or ocorrencias.responsavel4 = $nome or colaborador_id = $nome");
    }

    sleep(1);
    
    $resultado = $statement->fetchAll(PDO::FETCH_ASSOC);

    echo "<table border>";
    echo "<thead>";
    echo "<tr>";
    foreach ($resultado as $nomes) {


        echo "<th>Chave da Nota Fiscal</th>";
        echo "<th>Responsável Ocorrência</th>";
        echo "<th>responsável Resolução</th>";
        echo "<th>Prejuizo</th>";
        echo "<th>Origem do Erro</th>";
        echo "<th>Ciente do ocorrido</th>";
        echo "<th>Data Resolução</th>";
        echo "<th>Status</th>";
        echo "<th>Número do Pedido</th>";
        echo "<th>Editar</th>";
        echo "<th>Ver Mais</th>";
        echo "</thead>";
        echo "<tbody>";
        echo "<tr>";
        echo "<td>" . $nomes['chave_nf'] . "</td>";
        echo "<td>" . $nomes['embalou'] . "</td>";
        echo "<td>" . $nomes['sac'] . "</td>";
        echo "<td>" . $nomes['prejuizo'] . "</td>";
        echo "<td>" . $nomes['data_origem_erro'] . "</td>";
        echo "<td>" . $nomes['datas'] . "</td>";
        echo "<td>" . $nomes['data_resolucao'] . "</td>";
        if($nomes['status_oc'] == 1){
            echo "<td> Em Aberto</td>";
        }else{
            echo "<td> Finalizado</td>";
        }
        echo "<td>" . $nomes['n_pedido'] . "</td>";
        echo " <td class='text-center'><a href='view_edit_ocorrencia.php?codigo={$nomes['id_oc']}'> <img src='imagens/editar.png' class='rounded' style='width:30px'></a></td>";
        echo " <td class='text-center'><a href='vermais.php?codigo={$nomes['id_oc']}''> <img src='imagens/vermais.png' class='rounded' style='width:30px'></a></td>";

        echo "</tr>";
        echo "</tbody>";
    }
    echo "</table>";
} else {
    echo "não foram encontrados registros";
}
