<?php
    include_once 'index.php';
?>


<?php



$date = date("d-m-y");
$diretoria = "./imagens/{$date}"; // esta linha não precisas é só um exemplo do conteudo que a variável vai ter

$listaDiretorio = array_diff(scandir($diretoria) , ['.'.'..']);
foreach ($listaDiretorio as $diretorio) {
    echo "<a href='$diretoria'>$date</a>";
}

// selecionar só .jpg
$imagens = glob($diretoria . "*.jpg");

// fazer echo de cada imagem
foreach ($imagens as $imagem) {
    $nome = $imagem;
    echo $nome . "<br>";
    echo '<a href=""><img src="' . $imagem . '" class="rounded float-left" width="200"></a>';
}
?>