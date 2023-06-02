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
        <p class="h4">Clique no Botão para iniciar o Serviço</p>
        <input type="hidden" class="form-control" name="data_inicial" value="<?php echo date('Y-m-d');?>" required>
        <input type="hidden" class="form-control" name="page" value="1">
        

        <input type="submit" value="Ativar Serviço" class="btn btn-success">
    </form>
    </div>
</body>

</html>