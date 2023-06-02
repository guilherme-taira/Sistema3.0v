<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

</body>

</html>

<?php
include "index.php";
include "conexao.php";

?>

<form method="POST" action="sistema.php">
    <?php
    $data = date("Y-m-d H:i");
    echo " <input type='hidden'name='data' value='" . $data . "' />";
    ?>
    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                Selecione o Funcionário
            </div>
            <div class="card-body">
                <h5 class="card-title">Funcionário</h5>
                <p class="card-text">Selecione o funcionário para iniciar..</p>

                <select name="funcionario" class="form-control" required="required">
                    <option value="">Selecione..</option>
                    <?php
                    $result = "SELECT id,nome FROM colaborador";
                    $query = mysqli_query($conn, $result);
                    while ($nome = mysqli_fetch_assoc($query)) { ?>
                        <option value="<?php echo $nome['id']; ?>"><?php echo $nome['nome']; ?></option>
                    <?php };?>
                </select>

                <input type="submit" class="btn btn-primary mt-4" value="Começar">
            </div>
        </div>
    </div>
</form>

</form>