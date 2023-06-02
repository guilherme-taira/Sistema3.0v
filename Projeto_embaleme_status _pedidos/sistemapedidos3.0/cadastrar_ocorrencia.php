<?php
include_once 'index.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <script type="text/javascript" src="https://github.com/Eonasdan/bootstrap-datetimepicker/blob/master/src/js/bootstrap-datetimepicker.js"></script>
    <script type="text/javascript" src="main.js"></script>
</head>

<body>
    <div class="container-sm">
        <span class="badge bg-danger">
            <h3> Cadastrar Ocorrência </h3>
        </span>
        <br>
        <form  enctype="multipart/form-data" class="row g-3" action="insert_ocorrencia.php" method="post">
            <div class="col-md-6">
                <label for="nftxt" class="form-label">Chave da Nota</label>
                <input type="text" class="form-control" id="nftxt" name="chave_nota" maxlength="44" minlength="44" required>
            </div>
            <div class="col-md-6">
                <label for="prejuizo" class="form-label">Prejuizo</label>
                <input type="text" class="form-control" id="prejuizo" name="prejuizo">
            </div>
            <div class="col-md-4">
                <label for="inputState" class="form-label">Responsável Resolução</label>
                <select id="inputState" class="form-select" name="resp_ocorrencia" required>
                <option value="">Selecione..</option>
                <?php 
                include_once 'conexao.php';
                $result = "SELECT id,nome FROM colaborador";
                $query = mysqli_query($conn,$result);
                while($nome = mysqli_fetch_assoc($query)) {?>
                <option value="<?php echo $nome['id']; ?>"><?php echo $nome['nome']; ?></option>
                <?php } "<br>";
                ?>
                </select>

            </div>
            <div class="col-md-4">
                <label for="inputState" class="form-label">Responsável pela Ocorrência</label>
                <select id="inputState" class="form-select" name="resp_embalo" required>
                <option value="">Selecione..</option>
                <?php 
                include_once 'conexao.php';
                $result = "SELECT id,nome FROM colaborador";
                $query = mysqli_query($conn,$result);
                while($nome = mysqli_fetch_assoc($query)) {?>
                <option value="<?php echo $nome['id']; ?>"><?php echo $nome['nome']; ?></option>
                <?php } "<br>";
                ?>
                </select>
            </div>
            <div class="col-md-4">
                <label for="inputState" class="form-label">Responsável pela Ocorrência 2</label>
                <select id="inputState" class="form-select" name="resp_embalo2" >
                <option value="">Selecione..</option>
                <?php 
                include_once 'conexao.php';
                $result = "SELECT id,nome FROM colaborador";
                $query = mysqli_query($conn,$result);
                while($nome = mysqli_fetch_assoc($query)) {?>
                <option value="<?php echo $nome['id']; ?>"><?php echo $nome['nome']; ?></option>
                <?php } "<br>";
                ?>
                </select>
            </div>
            <div class="col-md-4">
                <label for="inputState" class="form-label">Responsável pela Ocorrência 3</label>
                <select id="inputState" class="form-select" name="resp_embalo3" >
                <option value="">Selecione..</option>
                <?php 
                include_once 'conexao.php';
                $result = "SELECT id,nome FROM colaborador";
                $query = mysqli_query($conn,$result);
                while($nome = mysqli_fetch_assoc($query)) {?>
                <option value="<?php echo $nome['id']; ?>"><?php echo $nome['nome']; ?></option>
                <?php } "<br>";
                ?>
                </select>
            </div>

            <div class="col-md-4">
                <label for="inputState" class="form-label">Responsável pela Ocorrência 4</label>
                <select id="inputState" class="form-select" name="resp_embalo4" >
                <option value="">Selecione..</option>
                <?php 
                include_once 'conexao.php';
                $result = "SELECT id,nome FROM colaborador";
                $query = mysqli_query($conn,$result);
                while($nome = mysqli_fetch_assoc($query)) {?>
                <option value="<?php echo $nome['id']; ?>"><?php echo $nome['nome']; ?></option>
                <?php } "<br>";
                ?>
                </select>
            </div>
            <div class="col-md-2">
                <label for="inputAddress2" class="form-label">Número do Pedido</label>
                <input type="text" class="form-control" id="inputAddress2" name="n_pedido">
            </div>
            <div class="col-md-4">
                <label for="inputState" class="form-label">Status</label>
                <select name="status" id="inputState" class="form-select">
                    <option name="status" selected>Selecione...</option>
                    <option value="1">Em Aberto</option>
                    <option value="2">Finalizado</option>

                </select>
            </div>

            <div class="col-md-4">
                <label for="datas" class="form-label">Ciente do ocorrido (Data)</label>
                <div>
                    <input type="date" class="form-control" name="data" id="datas">
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                    </span>
                </div>
            </div>
            <div class="col-md-4">
                <label for="datas" class="form-label">Origem do Erro (Data)</label>
                <div>
                    <input type="date" class="form-control" name="data_origem_erro" id="datas">
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                    </span>
                </div>
            </div>

            <div class="col-md-4">
                <label for="datas" class="form-label">Data Resolução - Não Obrigatório</label>
                <div>
                    <input type="date" class="form-control" name="data_resolucao_erro" id="datas">
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                    </span>
                </div>
            </div>


            <!--- colocar imagem das ocorrências --->
            <div class="col-md-4">
                <label for="datas" class="form-label">Fotos da Ocorrência</label>
                <div class="input-group date data_formato" data-date-format="dd/mm/yyyy HH:ii:ss">
                    <input type="file" class="form-control" name="arquivo[]" multiple="multiple" id="datas">
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                    </span>
                </div>
            </div>

            <!--- Final imagem das ocorrências --->        

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
            <script src="js/bootstrap.min.js"></script>
            <script src="js/bootstrap-datetimepicker.min.js"></script>
            <script src="js/locales/bootstrap-datetimepicker.pt-BR.js"></script>
            <script type="text/javascript">
                $('.data_formato').datetimepicker({
                    weekStart: 1,
                    todayBtn: 1,
                    autoclose: 1,
                    todayHighlight: 1,
                    startView: 2,
                    forceParse: 0,
                    showMeridian: 1,
                    language: "pt-BR",
                    //startDate: '+0d'
                });
            </script>

            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Explique ocorrido</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="observacao"></textarea>
            </div>

            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Resolução - Não Obrigatório de Imediato</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="resolucao"></textarea>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Cadastrar</button>
            </div>
        </form>
    </div>

    </div>
</body>

</html>