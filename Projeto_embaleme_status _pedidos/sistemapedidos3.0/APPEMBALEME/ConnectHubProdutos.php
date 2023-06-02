<?php
include_once 'TrayEmbalemeGetProdutos.php';
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);
set_time_limit(60);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Cliente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="http://code.jquery.com/jquery-latest.min.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js"></script>
    <script>
        setTimeout(function() {
            window.location.reload(1);
        }, 10000);
    </script>

    <style>
        .logo {
            width: 80px;
            float: left;
        }

        .progressbar {
            width: 100%;
            margin: 25px auto;
            border: solid 1px #000;
        }

        .progressbar .inner {
            height: 15px;
            animation: progressbar-countdown;
            /* Placeholder, this will be updated using javascript */
            animation-duration: 30s;
            /* We stop in the end */
            animation-iteration-count: 1;
            /* Stay on pause when the animation is finished finished */
            animation-fill-mode: forwards;
            /* We start paused, we start the animation using javascript */
            animation-play-state: paused;
            /* We want a linear animation, ease-out is standard */
            animation-timing-function: linear;
        }

        @keyframes progressbar-countdown {
            0% {
                width: 70%;
                background: #0F0;
            }

            100% {
                width: 0%;
                background: #F00;
            }
        }
    </style>
</head>

<body>
    <div class="container-fluid mt-2" id="atualiza">
        <div class="row">

            <script>
                /*
                 *  Creates a progressbar.
                 *  @param id the id of the div we want to transform in a progressbar
                 *  @param duration the duration of the timer example: '10s'
                 *  @param callback, optional function which is called when the progressbar reaches 0.
                 */
                function createProgressbar(id, duration, callback) {
                    // We select the div that we want to turn into a progressbar
                    var progressbar = document.getElementById(id);
                    progressbar.className = 'progressbar';

                    // We create the div that changes width to show progress
                    var progressbarinner = document.createElement('div');
                    progressbarinner.className = 'inner';

                    // Now we set the animation parameters
                    progressbarinner.style.animationDuration = duration;

                    // Eventually couple a callback
                    if (typeof(callback) === 'function') {
                        progressbarinner.addEventListener('animationend', callback);
                    }

                    // Append the progressbar to the main progressbardiv
                    progressbar.appendChild(progressbarinner);

                    // When everything is set up we start the animation
                    progressbarinner.style.animationPlayState = 'running';
                }

                addEventListener('load', function() {
                    createProgressbar('progressbar1', '30s');
                });
            </script>
            <?php

            // Sessão pagina automatica
            $_SESSION['page'] += isset($_REQUEST['pagina']) ? $_REQUEST['pagina'] : 1;
            $pagina = $_SESSION['page'];
                
            echo "<div class='container'><div class='row align-items-start'><h1> <span class='badge bg-danger'>Cadastro de Produto Tray </span> <span class='badge bg-success'>PAGINA : {$pagina} </span> 
            <span class='badge bg-warning text-dark'>Período: {$pagina} </span>
            <div class='spinner-border text-success' role='status'>
            <span class='visually-hidden'>Loading...</span>
            </div>
            </h1>";

            echo "<div id='progressbar1' class='progress-bar progress-bar-striped bg-success' role='progressbar'></div>";
          
            // INCLUSAO DA CLASSE CADASTRA PRODUTO
           $getProdutos = new GetProdutosGravaBanco();
           $jsonDecodificado = $getProdutos->resource($_SESSION['access_token_tray'], $pagina);
        //    echo "<pre>";
        //    print_r($jsonDecodificado);

            //PAGINA RETORNA DO COMEÇO CASO NÂO ENCONTRE MAIS PEDIDOS
            $Paginacao = intval($jsonDecodificado->paging->total / $jsonDecodificado->paging->limit) + 1;
            if(intVal($Paginacao) <= intVal($_SESSION['page'])){
                $_SESSION['page'] = 0;
            }
           
            foreach ($jsonDecodificado->Products as $produtos) {
       
                include_once '../conexao_pdo.php';
                // include_once 'RetGravaDados.php';
                // include_once 'BancoRetAPPTRAY.php';
                
                foreach ($produtos as $produto) {
                    $n_pedido = $produto->id;
                    $referencia = $produto->reference;
                    $statement = $pdo2->prepare("SELECT * from TrayProdutos WHERE id_produto = :id_produto");
                    $statement->bindParam(':id_produto', $n_pedido, PDO::PARAM_STR);
                    $statement->execute();
                    $count = $statement->fetchAll();
                    if (count($count) > 0) {
                        echo "
                            <tbody>
                            <div class='card mt-2 alert alert-danger'>
                            <ul class='list-group list-group-flush'>
                            <li class='list-group-item'><strong>Produto : {$produto->name} - Já Cadastrado!</strong></li>
                            </ul>
                            </div>  
                            ";
                        // echo "<pre>";
                        // $produto = new UpdateProduto($referencia);
                        // $produto->PesquisaBancoRet($referencia,$pdo);
                        // $produto->GravaBanco($pdo2,$pdo);
                        // echo "</pre>";
                    } else {
                            echo "
                            <tbody>
                            <div class='card mt-2 alert alert-success'>
                            <ul class='list-group list-group-flush'>
                            <li class='list-group-item'><strong>Produto : {$produto->name} - Cadastrado com Sucesso</strong></li>
                            </ul>
                            </div>  
                            ";
                            // $produto = new UpdateProduto($n_pedido,$pdo);
                            // $produto->GravaBanco();

                            try {
                              $pdo2->beginTransaction();
                              $id_produto = $produto->id; // Id do produto
                              $valor_produto =  number_format($produto->price,2); // preço do produto
                              $estoque_produto = $produto->stock; // estoque do produto
                              $preco_promocional =  number_format($produto->promotional_price,2); // preço promocional
                              $dataInicial = $produto->start_promotion; // data inicial promocional
                              $dataFinal = $produto->end_promotion; // data Final promocionale    
                              $Ativo = $produto->available; // data Final promocionale
                              $referencia = $produto->reference;

                              $sql = "INSERT INTO TrayProdutos (id_produto,referencia,preco,stock,Ativo)";
                              $sql_values = " VALUES (:id_produto,:referencia,:preco,:stock,:Ativo)";
                              
                              $statement = $pdo2->prepare($sql .= $sql_values);
                              $statement->bindValue(':id_produto', (string) $id_produto, PDO::PARAM_INT);
                              $statement->bindValue(':referencia', (string) $referencia, PDO::PARAM_STR);
                              $statement->bindValue(':preco', (float) $valor_produto, PDO::PARAM_STR);
                              $statement->bindValue(':stock', (int) $estoque_produto, PDO::PARAM_STR);
                              $statement->bindValue(':Ativo', $Ativo, PDO::PARAM_STR);
                              $statement->execute();
                              $pdo2->commit();
                            } catch (\PDOException $th) {
                              // cancela e devolve a transação.
                              $pdo2->rollBack();
                              echo $th->getMessage();
                        }
                   }
               }
           }

            echo "</tr>
    </tbody>";


            // função para validação dos campos retornados

            function avancaPagina($pagina)
            {
                $pagina += 1;
                return $pagina;
            }

            function limpacpf($cpf)
            {
                $regex = "/[.-]/";
                $replecement = "";
                return preg_replace($regex, $replecement, $cpf);
            }


            function tirarAcentos($string)
            {
                return preg_replace(array("/(á|à|ã|â|ä)/", "/(Á|À|Ã|Â|Ä)/", "/(é|è|ê|ë)/", "/(É|È|Ê|Ë)/", "/(í|ì|î|ï)/", "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/", "/(')/", "/(ç|Ç)/", "/(-)/"), explode(" ", "a A e E i I o O u U n N c C"), $string);
            }

            function FiltraTelefone($numero)
            {

                $regexFone = "/^55/";
                $regexEspecial = "/[(]/";

                if (preg_match($regexFone, $numero) == TRUE) {
                    $res = substr($numero, -11);
                } elseif (preg_match($regexEspecial, $numero) == TRUE) {
                    $res = preg_replace('/[@\.\;\-\(\)\" "]+/', '', $numero);
                } else {
                    $res = $numero;
                }
                return $res;
            }

            function removecarecteresespecial($str)
            {
                $res = preg_replace(array("/(á|à|ã|â|ä)/", "/(Á|À|Ã|Â|Ä)/", "/(é|è|ê|ë)/", "/(É|È|Ê|Ë)/", "/(í|ì|î|ï)/", "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/", "/(ç|Ç)/", "/(-)/"), explode(" ", "a A e E i I o O u U n N c C"), $str);
                return $res;
            }

            ?>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        </div>
    </div>
</body>

</html>