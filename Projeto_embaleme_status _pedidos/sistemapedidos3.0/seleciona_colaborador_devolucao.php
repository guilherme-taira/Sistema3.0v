<?php

include_once 'index.php';

include_once 'conexao.php';


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
        <div class="col">


            <form method="post" action="cadastra_devolucao.php">
                <?php

                $data = date("Y-m-d H:i");
                echo " <input type='text'name='data' style='visibility: hidden' value='" . $data . "' /><br><br>";
                ?>
                <p class="h5">Selecione o Funcionario :</p>
                <select class="form-control" id="exampleFormControlSelect1" name="funcionario" required>
                    <option value="">Selecione..</option>
                    <?php

                    $result = "SELECT id,nome FROM colaborador";
                    $query = mysqli_query($conn, $result);
                    while ($nome = mysqli_fetch_assoc($query)) { ?>
                        <option value="<?php echo $nome['id']; ?>"><?php echo $nome['nome']; ?></option>
                    <?php }
                    "<br>";
                    ?>

                    <div class="col-12">
                        <input type="submit" class="btn btn-success mt-2" value="Enviar">
                    </div>
            </form>

        </div>
    </div>

</body>

</html>