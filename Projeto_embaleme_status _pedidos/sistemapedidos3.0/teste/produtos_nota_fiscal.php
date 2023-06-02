<?php 

//iniciando a asessão
session_start ();
header("Content-Type: text/html; charset=utf-8",true);

?>
<html> 
<head> 
    <title> Demonstração de matriz Session usado para carrinho</title> 
</head> 
<body>
    <?php 
    include_once 'conexao_pdo.php';

    $codigo = $_REQUEST['cod_nf'];
    //Calculando o total com a função sizeof() que retorna de key's.

    if (!isset($_GET['carrinho']) && isset($_SESSION['carrinho'])) {

        $contagem = sizeof($_SESSION['carrinho']);

    }

    if (isset($_GET['carrinho'])) {

        $contagem = sizeof($_SESSION['carrinho']) + 1;

    }

    $statement = $pdo->query("SELECT descricao, quantidade, EAN FROM `codigo`
    inner JOIN pedidos on codigo.id_pedido = pedidos.n_pedido
    where cod = '$codigo' and Tipo = 'S'");

    $produtos = $statement->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<table border'>";
    echo "<tr><th>Produto</th><th>Quantidade</th><th>EAN</th></tr>";
    
    foreach ($produtos as $key => $value) {
        echo "<tr>";
        echo "<td> Produto : " . $value['descricao']."<br>";
        echo "<td> Quantidade : ". $value['quantidade'] .  "</td>";
        echo "<td> EAN : ". $value['EAN'] .  "</td>";
        echo "</tr>";
    } 
    echo "</table>";
    ?>
</body>
</html>

<?php

if (isset($_GET['carrinho'])){    

    $prod_id = $_GET['carrinho'];

    //isto evita o uso da função array push
    $_SESSION['carrinho'][] = $prod_id;


 } 

if (isset($_SESSION['carrinho'])) {
echo '<br /><br />ID dos poutos adicionados:';
foreach($_SESSION['carrinho'] as $list):?>

    <ul>
        <li><?php echo $list;?></li>
    </ul>

<?php endforeach; } 