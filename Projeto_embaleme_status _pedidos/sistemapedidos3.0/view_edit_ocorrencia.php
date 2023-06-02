<?php
include "index.php";
$_SESSION['cod_id'] = $_GET['codigo'];
$cod = $_SESSION['cod_id'];
include_once 'conexao.php';
$sql = "SELECT *, ocorrencias.id as id_oc FROM ocorrencias inner join colaborador on ocorrencias.colaborador_id = colaborador.id where ocorrencias.id=$cod";
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
                            <label for="exampleFormControlInput1" class="form-label">Nota Fiscal </label>
                            <input type="text" class="form-control" name="nota_nf" id="exampleFormControlInput1" value="<?php echo $row['chave_nf']; ?>" maxlength="44" minlength="44">
                        </div>
                        <div class="col-md-4">
                            <label for="exampleFormControlInput1" class="form-label">Prejuizo </label>
                            <input type="text" class="form-control" name="prejuizo" id="exampleFormControlInput1" value="<?php echo $row['prejuizo']; ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="exampleFormControlInput1" class="form-label">Número do Pedido </label>
                            <input type="text" class="form-control" name="n_pedido" id="exampleFormControlInput1" value="<?php echo $row['n_pedido']; ?>">
                        </div>
                        <div class="col-md-4">
                            <label for="exampleFormControlInput1" class="form-label">Ciente do Ocorrido </label>
                            <input type="date" class="form-control" name="data" id="exampleFormControlInput1" value="<?php echo $row['datas']; ?>">
                        </div>

                        <div class="col-md-4">
                            <label for="exampleFormControlInput1" class="form-label">Data de Origem da Ocorrência</label>
                            <input type="date" class="form-control" id="exampleFormControlInput1" name="data_origem_erro" value="<?php echo $row['data_origem_erro']; ?>">
                        </div>

                        <div class="col-md-4">
                            <label for="exampleFormControlInput1" class="form-label">Data da Resolução</label>
                            <input type="date" class="form-control" id="exampleFormControlInput1" name="data_resolucao" value="<?php echo $row['data_resolucao']; ?>">
                        </div>

                        <div class="col-md-4">
                            <label for="inputState" class="form-label">Responsável pelo Erro</label>
                            <select id="inputState" class="form-select" name="embalou" required>
                                <option value="">Selecione..</option>
                                <option value="<?php echo $row['colaborador_id']; ?>" selected><?php echo $row['nome']; ?></option>
                                <?php
                                include_once 'conexao.php';
                                $result = "SELECT id,nome FROM colaborador";
                                $query = mysqli_query($conn, $result);
                                while ($nome = mysqli_fetch_assoc($query)) { ?>
                                    <option value="<?php echo $nome['id']; ?>"><?php echo $nome['nome']; ?></option>
                                <?php }
                                "<br>";
                                ?>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="inputState" class="form-label">Status</label>
                            <select name="status" id="inputState" class="form-select" required>
                                <option value="" selected>Selecione...</option>
                                <option value="1">Em Aberto</option>
                                <option value="2">Finalizado</option>

                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Observação</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" disabled><?php echo $row['observacao']; ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Resolução</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" name="resolucao" rows="3"><?php echo $row['resolucao']; ?></textarea>
                        </div>

                        <input type="submit" value="Salvar">
                </form>
            <?php } ?>
            </div>
</body>

</html>