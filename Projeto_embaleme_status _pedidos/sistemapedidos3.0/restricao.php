<?php
include "index.php";
session_start();
$_SESSION['cod_id'] = $_GET['codigo'];
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
    <div class="container-sm">

        <div class="row">
            <div class="col">
                <div class="row align-items-start">
                    <div class="col">
                        <form action="trata_dados_restricao.php" method="POST">
                            <p class="h5">Digite o Número da Nota Fiscal: </p>
                            <input type="text" name="numero" placeholder="Digite o Código da Caixa!" autofocus="true" maxlength="44" minlength="44">
                            <br>
                    </div>
                    <div class="col">
                        <label class="mr-sm-2" for="inlineFormCustomSelect">Escolha o Tipo de Coleta</label>
                        <input type="radio" class="btn-check" name="options-outlined" id="success-outlined" value="2" autocomplete="off">
                        <label class="btn btn-outline-success" for="success-outlined">Correio</label>

                        <input type="radio" class="btn-check" name="options-outlined" id="btn-check-outlined" value="3" autocomplete="off">
                        <label class="btn btn-outline-primary" for="btn-check-outlined">Mandaê</label><br>
                        <input type="submit" value="Enviar">

                        </form>
                    </div>
                </div>
            </div>
</body>

</html>