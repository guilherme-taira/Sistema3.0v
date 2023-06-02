<?php
include_once '../index.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <script type="text/javascript">
        // Data Picker Initialization
        $('.datepicker').datepicker();
    </script>

    <div class="container-sm">

    <img src="../imagens/bling.png" class="img-thumbnail" alt="Logo-Bling" width="200px" height="200px">

    <form action="recebe_pedidos.php" method="POST">
    <br>
        <p class="h4">Coloque a data para filtrar os pedidos</p>

        <label> Data Inicial </label>
        <div class="input-group date" data-provide="datepicker">
            <input type="date" class="form-control" name="data_inicial" required>
            <div class="input-group-addon">
                <span class="glyphicon glyphicon-th"></span>
            </div>
        </div>

        <label> Data Final </label>
        <div class="input-group date" data-provide="datepicker">
            <input type="date" class="form-control" name="data_final" required>
            <div class="input-group-addon">
                <span class="glyphicon glyphicon-th"></span>
            </div>
        </div>
        <br>

        <label> Número da Página </label>
        <select name="pagina">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select>
        <input type="submit" value="Pesquisar" class="btn btn-success">
    </form>
    </div>
</body>

</html>