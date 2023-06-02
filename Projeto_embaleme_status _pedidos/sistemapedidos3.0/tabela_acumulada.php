<?php

include 'index.php';
include 'conexao.php';
$sql = "SELECT sum(Quantidade) as Total, nome FROM `colaborador` INNER JOIN produtividade on produtividade.Id_colaborador = colaborador.id GROUP by id_colaborador";
$sql2 = "SELECT DISTINCT nome, Quantidade,datas FROM `colaborador` INNER JOIN produtividade on produtividade.Id_colaborador = colaborador.id order by datas";

$result = $conn->query($sql2);
$result1 = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/autofill/2.3.7/css/autoFill.dataTables.min.css">
</head>

<body>

    <div class="container">
        <table class="table table-bordered table-hover" id="table_id">

            <thead>

                <tr>
                    <th>Colaborador(a)</th>
                    <th>Data</th>
                    <th>Quantidade</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td scope="row"><?php echo $row['nome']; ?></td>
                        <td scope="row"><?php echo $row['datas']; ?></td>
                        <td class='alert alert-success'> <?php echo $row['Quantidade']; ?></td>

                    <?php } ?>
                    </tr>
            </tbody>
        </table>


    </div>


    <script src="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css"></script>
    <script type="text/javascript" charset="utf8" src="/DataTables/datatables.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js">
    <script>
        $(document).ready(function() {
            $('#table_id').DataTable({
                "language": {
                    "lengthMenu": "Mostrando _MENU_ Registros por Página",
                    "zeroRecords": "Sem Resultado Retornado",
                    "info": "Páginas Encontradas _PAGE_ of _PAGES_",
                    "infoEmpty": "Nenhum Registro Encontrado",
                    "infoFiltered": "(Filtrado de  _MAX_ total no Total)"
                }
            });
        });
    </script>



</body>

</html>