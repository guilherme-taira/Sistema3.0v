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
    <div class="container">

        <div class="row align-items-start">
            <div class="col">
                <form action="altera_nota_fiscal.php" method="POST">
                    <span class="badge bg-warning text-dark">
                        <h3>Altera Nota Cancelada</h3>
                    </span>
                    <p>Atenção o campo aceita só aceita 44 caracteres, caso tenha menos será exibida uma mensagem.</p>
               
                    <div class="mb-3">
                        <label for="txt_nota_antiga" class="form-label">Digite o Número da Nota Fiscal Cancelada</label>
                        <input type="text" name="codigo" class="form-control" id="txt_nota_antiga"placeholder="Digite o número da nota fiscal" autocomplete="off" autofocus="true" maxlength="44" minlength="44" required>
                    </div>

                    <div class="mb-3">
                        <label for="txt_nota_antiga" class="form-label">Digite o Número da Nota Fiscal Atualizada</label>
                        <input type="text" name="numero" class="form-control" id="txt_nota_antiga"placeholder="Digite o número da nota fiscal" autocomplete="off" autofocus="true" maxlength="44" minlength="44" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary mb-3" required>Alterar Nota</button>
                </form>
            </div>
</body>

</html>