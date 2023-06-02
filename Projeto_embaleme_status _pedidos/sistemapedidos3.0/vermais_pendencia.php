<?php
include "index.php";

$cod = $_REQUEST['codigo'];

include_once 'conexao.php';
$sql = "SELECT observacao FROM `codigo` WHERE id = $cod";
$result = $conn->query($sql);
session_start();
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
                <form action="edita_ocorrencia.php" method="POST">
                    <input type="text" name="id" value="<?php echo $_SESSION['cod_id']; ?>" style="visibility: hidden">
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Motivo da Pendência</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" disabled><?php echo $row['observacao']; ?></textarea>
                        </div>
                    <?php } ?>
            </div>
</body>

</html>