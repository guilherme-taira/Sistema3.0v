<?php
 ini_set('display_errors',1);
 ini_set('display_startup_erros',1);
 error_reporting(E_ALL);
include_once '../estilos/bootrap.php';
// função que muda o traço da data
//$data_inicial = $_REQUEST['data_inicial'];
//$data_final = $_REQUEST['data_inicial'];
//$pagina = $_REQUEST['pagina'];
$patterns = array ('/(19|20)(\d{2})-(\d{1,2})-(\d{1,2})/','/^\s*{(\w+)}\s*=/');
$replace = array ('\4/\3/\1\2', '$\1 =');

//$data1 =  preg_replace($patterns, $replace, $data_inicial);
//$data2 = preg_replace($patterns, $replace, $data_final);

echo "<div class='container'>
<div class='row align-items-start'>
        <h1> Produtos Api Bling </h1>
";

$apikey = "a0e92e1b13cad53953fa6b425bc6cb36bcf51d327ec8ca3c9a0c20d271edb3585cc96277";
//$filter = "dataEmissao[$data1 TO $data2]; idSituacao[6,9]";
$outputType = "json";
$url = "https://bling.com.br/Api/v2/produtos/page=52/json/" . $outputType;
$retorno = executeGetOrder($url, $apikey);
echo $retorno;
function executeGetOrder($url,  $apikey)
{
    $curl_handle = curl_init();
    curl_setopt($curl_handle, CURLOPT_URL, $url . '&apikey=' . $apikey);
    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, TRUE);
    $response = curl_exec($curl_handle);
    $jsonDecodificado = json_decode($response);
    curl_close($curl_handle);
    echo "<div class='col'>";
    echo "<table class='table table-striped'><tr><th>Código</th><th>Descrição</th><th>Imagem</th><th>EAN</th></tr>";
    foreach ($jsonDecodificado->retorno->produtos as $prod) {
        include_once 'conexao_pdo.php';
        foreach ($prod as $produto) {
            $n_ean = $produto->gtin;
            echo "<tr>";
            echo "<td> " . $produto->codigo . "</td>";
            echo "<td> " . $produto->descricao . "</td>";
            echo "<td> ".$produto->imageThumbnail."</td>";
            echo "<td> " . $produto->gtin . "</td>";
            echo "</tr>";
            $statement = $pdo->prepare("SELECT * from produto WHERE ean = :ean");
            $statement->bindParam(':ean', $n_ean, PDO::PARAM_STR);
            $statement->execute();
            $count = $statement->fetchAll();
            if(count($count) > 0){
                $mensagem = "<div class='alert alert-danger' role='alert'> <span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span> Não Há Pedidos para Integrar, Atualize Novamente</div>";
            }else{
                try {
                    $pdo->beginTransaction();
                    $cod_loja = $produto->codigo;
                    $descricao =  $produto->descricao;
                    $img = $produto->imageThumbnail;
                    $ean = $produto->gtin;

                    $sql = "INSERT INTO produto (cod_loja,descricao,img,ean)";
                    $sql_values = " VALUES (:cod_loja, :descricao, :img, :ean)";

                    $statement = $pdo->prepare($sql.=$sql_values);
                    $statement->bindValue('cod_loja',(string) $cod_loja, PDO::PARAM_STR);
                    $statement->bindValue('descricao', (string) $descricao, PDO::PARAM_STR);
                    $statement->bindValue('img', (string) $img, PDO::PARAM_STR);
                    $statement->bindValue('ean', (string) $ean, PDO::PARAM_STR);
                    $statement->execute();
                    $pdo->commit();
                } catch (\PDOException $th) {
                    // cancela e devolve a transação.
                    $pdo->rollBack();
                    echo $th->getMessage();
                }
            }
        }
    }

}
echo "</table>";
  echo $mensagem;

echo "
</div>
</div>";
