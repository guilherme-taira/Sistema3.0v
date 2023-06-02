<?php
$comando_cmd = "java -jar Balanca/dist/Balanca.jar 9600 8 1 0 COM3 ENQ"; // comunicao balanca serial porta 3
//exibe o retorno.
$peso_real =  substr(exec($comando_cmd), 1, 5); // executando o jar do java da comunicacao
$peso_calc = floatval($peso_real) * 10;
$var = (float)filter_var($peso_calc, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

$_SESSION['peso_balanca'] = $var;
echo "<textarea name='peso_loja' class='form-control' rows='1' id='exampleFormControlInput1' readonly>" . $_SESSION['peso_balanca'] . "</textarea>";
?>
