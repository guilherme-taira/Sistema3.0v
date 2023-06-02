<?php
session_start();
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);
set_time_limit(0);
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
        }, 20000);
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
            $_SESSION['page1'] += isset($_REQUEST['pagina1']) ? $_REQUEST['pagina1'] : 1;
            $pagina = $_SESSION['page1'];
            
            echo "<div class='container'><div class='row align-items-start'><h1> <span class='badge bg-danger'>Cadastro de Produto Bling / Mercadolivre -> HUB </span> <span class='badge bg-success'>PAGINA : {$pagina} </span> 
            <span class='badge bg-warning text-dark'>Período: {$pagina} </span>
            <div class='spinner-border text-success' role='status'>
            <span class='visually-hidden'>Loading...</span>
            </div>
            </h1>";
            
            echo "<div id='progressbar1' class='progress-bar progress-bar-striped bg-success' role='progressbar'></div>";
            include_once 'BlingComparativoShopee.php';
            include_once 'conexao_pdo.php';
            echo "<pre>";

            $TelaMostraDiverngencia = new TelaMostraDiverngencia('a0e92e1b13cad53953fa6b425bc6cb36bcf51d327ec8ca3c9a0c20d271edb3585cc96277',$pagina,$pdo2);
            $TelaMostraDiverngencia->atualizaProdutos();
                  
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

