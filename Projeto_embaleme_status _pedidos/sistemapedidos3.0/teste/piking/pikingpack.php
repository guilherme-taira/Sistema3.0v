<?php
ob_start();
session_start();
include_once '../../estilos/bootrap.php';
include_once '../conexao_pdo.php';
ini_set('display_errors', 0);
ini_set('display_startup_erros', 0);
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="en">

<!-- ------------------ SISTEMA DE PEDIDOS PINKING PACK----------------->
<!------------------------- ATUALIZADO 2021/08/20---13:00--------------->
<!------------- AUTOR GUILHERME TAIRA TODOS DIREITOS RESERVADO---------->

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="http://code.jquery.com/jquery-latest.min.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <meta charset="UTF-8" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.0.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

    <style>
        table,
        th,
        td {
            border-collapse: collapse;
            margin: -10px;
            text-align: center;
        }

        .container-fluid {
            padding: 20px;
        }

        a {
            text-decoration: none;
            color: red;
        }
    </style>

    <script type="text/javascript">
        $(document).ready(function() {
            $("#ean").focus();
        });
    </script>

    <script>
        function update() {
            $('#atualiza').load("pikingpack.php #atualiza");
        }
        setInterval('update()', 1000);

        $(document).ready(function() {
            $('#loading').show();
        }).ajaxStop(function() {
            $('#loading').hide('slow');
        });


        function writeNumber(elementId) {
            var outputValueTo = document.getElementById('ean');

            if (outputValueTo.value == '0' || outputValueTo.value == 'Syntax error') {
                outputValueTo.value = elementId.textContent;
            } else {
                outputValueTo.value += elementId.textContent;
            }
        }

        function cleartxt() {
            document.getElementById('ean').value = '0';
            document.getElementById('dec').disabled = false;
        }

        function setOperator(elementId) {
            var outputValueTo = document.getElementById('ean');
            if (outputValueTo.value == '0' || outputValueTo.value == 'Syntax error') {
                outputValueTo.value = '0';
            } else {
                outputValueTo.value += elementId.textContent;
                document.getElementById('dec').disabled = false;
            }
        }

        function setDecimal(elementId, status) {
            var outputValueTo = document.getElementById('ean');
            outputValueTo.value += elementId.textContent;
            document.getElementById('dec').disabled = status;
        }

        function calculate() {

            try {

                var field1txt = document.getElementById('ean');
                if (field1txt.value != '') {
                    var calculateResult = eval(field1txt.value);
                    field1txt.value = calculateResult;
                }
            } catch (err) {

                field1txt.value = 'Syntax error';

            }

        }

        function removeLastNumber() {

            var field1txt = document.getElementById('ean');

            if (field1txt.value.length == 1 || field1txt.value == '0' || field1txt.value == 'Syntax error') {
                field1txt.value = '0';
                document.getElementById('dec').disabled = false;
            } else {
                field1txt.value = field1txt.value.substring(0, field1txt.value.length - 1);
            }
        }

        function writeNumber(elementId) {
            var outputValueTo = document.getElementById('ean');

            if (outputValueTo.value == '0' || outputValueTo.value == 'Syntax error') {
                outputValueTo.value = elementId.textContent;
            } else {

                outputValueTo.value += elementId.textContent;
            }
        }

        function cleartxt() {
            document.getElementById('ean').value = '0';
            document.getElementById('dec').disabled = false;
        }

        function setOperator(elementId) {
            var outputValueTo = document.getElementById('ean');
            if (outputValueTo.value == '0' || outputValueTo.value == 'Syntax error') {
                outputValueTo.value = '0';
            } else {
                outputValueTo.value += elementId.textContent;
                document.getElementById('dec').disabled = false;
            }
        }

        function setDecimal(elementId, status) {
            var outputValueTo = document.getElementById('ean');
            outputValueTo.value += elementId.textContent;
            document.getElementById('dec').disabled = status;
        }

        function removeLastNumber() {

            var field1txt = document.getElementById('ean');

            if (field1txt.value.length == 1 || field1txt.value == '0' || field1txt.value == 'Syntax error') {
                field1txt.value = '';
                document.getElementById('dec').disabled = false;
            } else {
                field1txt.value = field1txt.value.substring(0, field1txt.value.length - 1);
            }
        }
    </script>
</head>

<body>

    <?php
    if (isset($_SESSION['msg_error'])) {
        echo $_SESSION['msg_error'];
    }
    ?>

    <div class="container-fluid">

        <?php
        echo "<img src='../../imagens/loading.gif' style='width: 70px;' id='loading'>";
        ?>
        <form action="" class="formulario" method="get">
            <input type="submit" id="confirma" class="btn btn-info py-2" value="Confirmar">
            <div class="form-group">
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button class="btn btn-outline-danger me-md-2 text-danger" id="ColocarPendencia" type="button"> <a href='../../postPendencia.php'><strong>Colocar Pendência</strong></a></button>
                    <button type="button" class="btn btn-danger" onclick='removeLastNumber()' id='removeLast'><i class="bi bi-arrow-bar-left">&nbsp;Apagar</i></button>
                    <button type="button" class="btn btn-success" onclick='mostrarNumber()' id='hideNumber'><i class="bi bi-keyboard">&nbsp; Teclado</i></button>
                    <button type="button" class="btn btn-warning" onclick='EscondeNumber()' id='EscondeTeclado'><i class="bi bi-keyboard-fill">&nbsp;Fechar</i></button>
                </div>
                <label for="ean">
                    <h5> Código de Barra </h5>
                </label>
                <input type="text" class="form-control" id="ean" name="ean" aria-describedby="ean">
                <small id="emailHelp" class="form-text text-muted">Digite o codigo de barra ou use o leitor de código para ter mais agilidade </small>
            </div>
        </form>

        <div id='Teclado'>
            <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                <div class="btn-group me-2" role="group" aria-label="First group">
                    <button type="button" onclick='writeNumber(this)' id='n0' class="btn btn-primary">0</button>
                    <button type="button" onclick='writeNumber(this)' id='n1' class="btn btn-primary">1</button>
                    <button type="button" onclick='writeNumber(this)' id='n2' class="btn btn-primary">2</button>
                    <button type="button" onclick='writeNumber(this)' id='n3' class="btn btn-primary">3</button>
                </div>
                <div class="btn-group me-2" role="group" aria-label="Second group">
                    <button type="button" onclick='writeNumber(this)' id='n4' class="btn btn-primary">4</button>
                    <button type="button" onclick='writeNumber(this)' id='n5' class="btn btn-primary">5</button>
                    <button type="button" onclick='writeNumber(this)' id='n6' class="btn btn-primary">6</button>
                </div>
                <div class="btn-group me-2" role="group" aria-label="Second group">
                    <button type="button" onclick='writeNumber(this)' id='n7' class="btn btn-primary">7</button>
                    <button type="button" onclick='writeNumber(this)' id='n8' class="btn btn-primary">8</button>
                    <button type="button" onclick='writeNumber(this)' id='n9' class="btn btn-primary">9</button>
                </div>
            </div>
        </div>

        <?php

        $id = $_SESSION['dadospedido'];
        include_once 'produto.php';
        $dados = file_get_contents($id);
        $pedidos = unserialize($dados);

        // sessao dos produtos para pendencia
        $_SESSION['pendencia'] = $dados;

        echo "<h5>Produtos Internos</h5>";

        foreach ($pedidos as $pedido) {
            if (is_array($pedido) || is_object($pedido)) {
                foreach ($pedido as $produto) {
                    $cod_interno = "/^3330000/";
                    if ($produto->quantidade == 0) {
                        if (!preg_match($cod_interno, $produto->ean) == 1) {
                            // caso a quantidade seja igual a zero o produto sai da tela!
                        }
                    } else if ($produto->quantidade > 0) {
                        if (preg_match($cod_interno, $produto->ean) == 1) {

                            echo "<div class='botao-ean-produto btn-group mt-2' role='group' aria-label='Basic checkbox toggle button group'>
                            <input type='checkbox' class='btn-check' autocomplete='off'>
                            <label class='btn btn-outline-success'><div id='produto'><p class='ean-produto'>{$produto->ean}</p></div></label>
                            </div>";
                        }
                    }
                }
            }
        }
        ?>

        <!-- COMEÇO DA DIV ATUALIZA  -->
        <div id="atualiza">
            <?php
            if (isset($_SESSION['msg'])) {

                if ($_SESSION['msg'] == '1') {
                    $_SESSION['msg'] = '1';
                    echo "
                <div class='mensagem-tela alert alert-success d-flex align-items-center text-center mt-2' role='alert'>
                <svg class='bi flex-shrink-0 me-2' width='24' height='24' role='img' aria-label='Success:'><use xlink:href='#check-circle-fill'/></svg>
                <div>
                <string> SUCESSO: ENCONTRADO -> {$_SESSION['descricao']} </string> 
                </div>
                </div>";
                } else {
                    echo "<div class='mensagem-tela alert alert-danger text-center mt-2' role='alert'>
                
                <div class='row-4-md text-center'>
                <svg class='bi flex-shrink-0 me-2' width='24' height='24' role='img' aria-label='Danger:'><use xlink:href='#exclamation-triangle-fill'/></svg>
                    ERROR:  PRODUTO NÂO ENCONTRADO!
                </div>
                </div>";
                }
            }
            ?>
            <!-- VERIFCA FINALIZADOS -->
            <?php

            $id = $_SESSION['dadospedido'];
            include_once 'produto.php';
            $dados = file_get_contents($id);
            $pedidos = unserialize($dados);

            foreach ($pedidos as $pedido) {
                $verificador = 0;
                if (is_array($pedido) || is_object($pedido)) {
                    foreach ($pedido as $produto) {

                        $qtd = $produto->quantidade;

                        // VERIFICA SE JÁ FOI BAIXADO
                        if ($qtd <= 0) {
                            echo " <button type='button' class='position-relative'>
                           <img src='$produto->img' width='100px' alt='imagem'>
                            <span class='position-absolute top-0 translate-middle badge rounded-pill bg-danger'>
                                {$produto->quantidade}
                                <span class='visually-hidden'>unread messages</span>
                            </span>
                            </button>";
                        }
                    }
                }
            }

            ?>

            <?php
            $id = $_SESSION['dadospedido'];
            include_once 'produto.php';
            $dados = file_get_contents($id);
            $pedidos = unserialize($dados);

            $_SESSION['GTIN'] = isset($_REQUEST['ean']) ? $_REQUEST['ean'] : "";
            $GRAVAEAN = $_SESSION['GTIN'];

            $EANSERIALIZE = file_get_contents($_SESSION['eansessao']);
            $GTINSERIALIZE = unserialize($EANSERIALIZE);
            $GTIN = $GTINSERIALIZE;



            foreach ($pedidos as $pedido) {
                $verificador = 0;
                if (is_array($pedido) || is_object($pedido)) {
                    foreach ($pedido as $produto) {

                        $cod_barra = $produto->ean;
                        $desc = $produto->descricao;
                        $qtd = $produto->quantidade;

                        $quantidade = ['Quantidade' => $qtd];
                        foreach ($quantidade as $key => $value) {
                            if ($value == -1) {
                                $value++;
                            } else {
                                $verificador += $value;
                            }
                        }
                    }

                    if ($verificador == 0) {
                        echo "<div class='d-grid gap-2 mt-2'>
                            <span class='badge bg-info text-dark pt-2'>Todos Produtos Checados!</span>
                        </div>";
                        echo "<div class='d-grid gap-2'><a class='btn btn-success' href='../../cadastra_volta.php'><strong>Finalizar</strong></a></div>";
                    }
                }
            }

            echo "<table class='table mt-2' name='tabela'>";
            echo "<thead>
                <tr>
                <th scope='col'>Imagem</th>
                <th scope='col'>Descrição</th>
                <th scope='col'>Quantidade</th>
                <th scope='col'>EAN</th>
                </tr>
                </thead>
                <tbody>
                ";

            foreach ($pedidos as $pedido) {
                if (is_array($pedido) || is_object($pedido)) {
                    foreach ($pedido as $produto) {
                        $cod_interno = "/^3330000/";

                        /**
                         * VERIFICA SALDO NO RET
                         * 
                         **/
                        // $internoRet = VerificaQuantidadeNumber($produto->sku);
                        // $statement = $pdo->query("SELECT stock from TrayProdutos WHERE referencia = $internoRet LIMIT 1");
                        // $saldo = $statement->fetch();

                        if ($produto->quantidade <= 0) {
                            if (!preg_match($cod_interno, $produto->ean) == 1) {
                                // caso a quantidade seja igual a zero o produto sai da tela!
                            }
                        } else {
                            if (!preg_match($cod_interno, $produto->ean) == 1) {
                                echo " 
                        <tr>
                        <td><img src='{$produto->img}' width='100px'></td> 
                        <td><div class='alert alert-warning' 'role='alert'><p>{$produto->descricao}</p></div></td> 
                        <td><div class='alert alert-warning' role='alert' ><p>{$produto->quantidade}</p></div></td>
                        <td ><div class='alert alert-warning' id='produto-gtin' role='alert'><p>*************</p></div></td>
                        </tr>";
                            } else {
                                echo " 
                        <tr>
                        <td><img src='{$produto->img}' width='100px'></td> 
                        <td><div class='alert alert-warning' role='alert'><p>{$produto->descricao}</p></div></td> 
                        <td><div class='alert alert-warning' role='alert' ><p>{$produto->quantidade}</p></div></td>
                        <td><div class='ean-msg alert alert-warning' id='produto-gtin' role='alert'><p>{$produto->ean}</p></div></td>
                        </tr>";
                            }
                        }
                    }
                }
            }

            foreach ($pedidos as $pedido) {
                if (is_array($pedido) || is_object($pedido)) {
                    foreach ($pedido as $produto) {
                        $produtoList[] = $produto->ean;
                    }
                }

                if (is_array($pedido) || is_object($pedido)) {
                    foreach ($pedido as $produto) {
                        $qtd = $produto->quantidade;

                        if (in_array($GRAVAEAN, $produtoList)) {
                            // funcão que retira a quantidade a cada vez que o produto é bipadoA
                            if ($GRAVAEAN == $produto->ean) {
                                if ($qtd == -1) {
                                    $produto->colocaQuantidade($produto->getQuantidade());
                                } else {
                                    $produto->retiraQuantidade($qtd);
                                    echo "<script> play(); </script>";
                                    $_SESSION['descricao'] = $produto->descricao;
                                }
                                // Função que acrescenta + 1 no valor dos produtos default por padrão;
                                //$produto->colocaQuantidade($produto->getQuantidade());

                                $produtos = serialize($pedidos);
                                file_put_contents($id, $produtos);
                            }
                        }
                    }


                    if (in_array($GRAVAEAN, $produtoList)) {
                        $gtin_produto = serialize($GTIN);
                        file_put_contents($_SESSION['eansessao'], $gtin_produto);
                        $_SESSION['msg'] = '1';
                        unset($_SESSION['msg_error']);
                    } else if (!$GRAVAEAN == "") {
                        $gtin_produto = serialize($GTIN);
                        file_put_contents($_SESSION['eansessao'], $gtin_produto);
                        $_SESSION['msg'] = '0';
                        unset($_SESSION['msg_error']);
                    }
                }
            }

            function VerificaQuantidadeNumber($text)
            {
                if (strlen($text) == 2) {
                    return "0000" . $text;
                } else if (strlen($text) == 3) {
                    return "000" . $text;
                } else if (strlen($text) == 4) {
                    return "00" . $text;
                } else if (strlen($text) == 5) {
                    return "0" . $text;
                }
            }

            ob_end_flush();
            ?>
        </div>
        <!-- FINAL DA DIV ATUALIZA  -->
    </div>
    <div class="d-grid gap-2 mt-2">
        <a class="btn btn-danger" href="../../volta.php"><strong>Cancelar</strong></a>
    </div>

    <script>
        $(function() {

            $("#mensagem_error").fadeOut(2000);

            $("#confirma").hide();
            $("#Teclado").hide();
            $("#EscondeTeclado").hide();
            $("#removeLast").hide();

            function onGetProdutoEan() {
                var ean = $(this).parent('#produto').text();
                $("#ean").val(ean);
                $("#confirma").show();
                $(".formulario").submit();
            }

            function mostrarNumber() {
                $("#Teclado").show();
                $("#EscondeTeclado").show();
                $("#hideNumber").hide('slow');
                $("#confirma").show();
                $("#removeLast").show();
            }

            function EsconderNumber() {
                $("#Teclado").hide('slow');
                $("#EscondeTeclado").hide('slow');
                $("#hideNumber").show();
                $("#confirma").hide('slow');
                $("#removeLast").hide('slow');
            }

            $("#EscondeTeclado").click(EsconderNumber);
            $("#hideNumber").click(mostrarNumber);
            $(".ean-produto").click(onGetProdutoEan);
            $(".mensagem-tela").fadeOut('slow');
        });
    </script>

    <audio id="audio">
        <source src="certo.mp3" type="audio/mp3" />
    </audio>

    <script type="text/javascript">
        audio = document.getElementById('audio');

        function play() {
            audio.play();
        }
    </script>

</body>

</html>