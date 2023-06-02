<?php
include_once 'index.php';
include 'conexao.php';

$sql = "SELECT chave_nf,data_origem_erro, data_resolucao, datas,status_oc,n_pedido, prejuizo,id as id_oc,
(select nome from colaborador where ocorrencias.colaborador_id = colaborador.id) as embalou,
(select nome from colaborador where ocorrencias.responsavel = colaborador.id) as sac,
(select nome from colaborador where ocorrencias.responsavel2 = colaborador.id and responsavel2 <> '') as resp1,
(select nome from colaborador where ocorrencias.responsavel3 = colaborador.id and responsavel3 <> '') as resp2,
(select nome from colaborador where ocorrencias.responsavel4 = colaborador.id and responsavel4 <> '') as resp3
from ocorrencias";
$result = $conn->query($sql);

$sql1 = "SELECT sum(prejuizo) as Total from ocorrencias";
$result1 = $conn->query($sql1);

$x = 0;
$y = 0;

$row_chart = "SELECT * FROM ocorrencias";
$result2 = $conn->query($row_chart);
while ($row_chart = mysqli_fetch_assoc($result2)) {
    if ($row_chart['status_oc'] == 1) {
        $x++;
    } else if ($row_chart['status_oc'] == 2) {
        $y++;
    }
}
?>
<html>

<head>
    <title>Datatables Individual column searching using PHP Ajax Jquery</title>
    <script src="script_tabela_ocorrencia.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

    <!--- grafico do google ---->

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Task', 'Hours per Day'],
                ['Finalizadas', <?= $y ?>],
                ['Em Aberto', <?= $x ?>]
            ]);

            var options = {
                title: 'Gráfico de Ocorrências'
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart'));

            chart.draw(data, options);
        }
    </script>
</head>

<body>
    <!--- Filtro -->




    <br>
    <div class="accordion" id="accordionExample">
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingOne">
        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
            Filtro Avançado
          </button>
        </h2>
        <div id="collapseOne" class="accordion-collapse collapse collapsed" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
            <div class="accordion-body">

                <!--- Filtro --->


                <form action="busca_avancada.php" method="POST">
                    <label for="opcoes" class="exampleFormControlSelect1"></label>

                    <!--- Form --- Colocar filtr -->
                    <?php

                    include_once 'teste/conexao_pdo.php';
                    $statement = $pdo->query("SELECT id, nome from colaborador");
                    $nomes = $statement->fetchAll(PDO::FETCH_KEY_PAIR);
                    ?>

                    <label for="txtnome"> Pesquisar por Nome: 
                    <select name="nome" id="txtnome">
                        <?php foreach ($nomes as $key => $nome) {
                            echo "<option value='$key'>$nome</option>";
                        }  ?>
                    </select>
                    </label>
                    
                    <label for="data_inicial">Data Inicial <input type="date" name="data_inicial" id="data_inicial"></label>
                    <label for="data_final">Data Final <input type="date" name="data_final" id="data_inicial"></label>
                    <input type="button" name="pesquisar" value="Pesquisar" onclick="getDados();">

                </form>
            </div>
        </div>
    </div>
</div>


    <!--- Tabela de Ocorrencia -->

    <table class="table table-bordered table-hover" id="resultado">

        <thead>

            <tr>
                <th>Chave da Nota Fiscal</th>
                <th>Responsável Ocorrência</th>
                <th>responsável Resolução</th>
                <th>Prejuizo</th>
                <th>Origem do Erro</th>
                <th>Ciente do ocorrido</th>
                <th>Data Resolução</th>
                <th>Status</th> 
                <th>Número do Pedido</th>
                <th>Editar</th>
                <th>Ver Mais</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td scope="row"><?php echo $row['chave_nf']; ?></td>
                    <td scope="row"><?php echo $row['embalou'].",".$row['resp1'].",".$row['resp2'].",".$row['resp3'];?></td>
                    <td scope="row"><?php echo $row['sac']; ?></td>
                    <td scope="row"><span class="badge bg-warning text-dark"><?php echo $row['prejuizo']; ?></span></td>
                    <td scope="row"><?php echo $row['data_origem_erro']; ?></span></td>
                    <td scope="row"><?php echo $row['datas']; ?></span></td>
                    <td scope="row"><?php echo $row['data_resolucao']; ?></span></td>
                    <?php if ($row['status_oc'] == 1) { ?>
                        <td scope="row"><span class="badge bg-danger">em Aberto</span></td>
                    <?php } else { ?>
                        <td scope="row"><span class="badge bg-success">Finalizado</span></td>
                    <?php } ?>

                    <td scope="row"><?php echo $row['n_pedido']; ?></td>


                    <!-- Botão de Acão -->
                    <?php echo " <td class='text-center'><a href='view_edit_ocorrencia.php?codigo={$row['id_oc']}'> <img src='imagens/editar.png' class='rounded' style='width:30px'></a></td>"; ?>
                    <?php echo " <td class='text-center'><a href='vermais.php?codigo={$row['id_oc']}''> <img src='imagens/vermais.png' class='rounded' style='width:30px'></a></td>"; ?>

                <?php } ?>

                </tr>
        </tbody>
    </table>

    <div class="alert alert-danger d-flex align-items-center" role="alert">
        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
            <use xlink:href="#exclamation-triangle-fill" />
        </svg>
        <div>
            <?php while ($row = $result1->fetch_assoc()) { ?>
                <strong> Total de Prejuizos R$: <?php echo $row['Total']; ?> Reais.</strong></span>
            <?php } ?></span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>



    </button>

    <?php $conn->close(); ?>
    <div id="piechart" style="width: 900px; height: 500px;"></div>
    </div>
    <script src="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css"></script>
    <script type="text/javascript" charset="utf8" src="/DataTables/datatables.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js">
    <script>
        $(document).ready(function() {
            $('#resultado').DataTable({
                dom: 'Bfrtip',
                "language": {
                    "lengthMenu": "Mostrando _MENU_ Registros por Página",
                    "zeroRecords": "Sem Resultado Retornado",
                    "info": "Páginas Encontradas _PAGE_ of _PAGES_",
                    "infoEmpty": "Nenhum Registro Encontrado",
                    "infoFiltered": "(Filtrado de  _MAX_ total no Total)"
                },
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });

        });
    </script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>

  


</body>

</html>


''