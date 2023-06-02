<?php
session_start();
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
    <div class="container">
        <form action="edit.php" method="POST">
        <label for="exampleFormControlInput1" class="form-label">ID Pedido</label>
                <input type="text" class="form-control" id="exampleFormControlInput1" name="id" value="<?php echo $_REQUEST['codigo']; ?>" readonly>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Nova Chave Nota Fiscal</label>
                <input type="text" class="form-control" id="exampleFormControlInput1" name="chave">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Observação da Nota Fiscal</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="observacao"></textarea>
            </div>
            <input type="submit" value="Enviar">
        </form>
    </div>
</body>
</html>