<?php

    include "index.php";
    

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
    <div class="container-fluid">

        <form action="adiciona_colaborador.php" method="POST">
            <label for="opcoes" class="exampleFormControlSelect1"></label>
            <input class="form-control" type="text" placeholder="Nome" name="nome">

            <input class="form-control" type="text" placeholder="Sobrenome" name="sobrenome">
            <br>
            <button type="submit" value="Cadastrar" class="btn btn-primary">Cadastrar</button>
        </form>
    </div>
</body>

</html>