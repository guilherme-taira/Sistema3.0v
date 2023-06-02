<?php
ob_start();
//<!-- ------------------ SISTEMA DE PEDIDOS PINKING PACK----------------->
//<!-- ---------------CLASS QUE INTEGRA E SALVA PEDIDO ------------------->
//<!------------------------- ATUALIZADO 2021/08/16 - 10:36--------------->
//<!------------- AUTOR GUILHERME TAIRA TODOS DIREITOS RESERVADO---------->
include_once 'produto.php';
include_once 'pedido.php';
include_once '../../teste/conexao_pdo.php';
session_start();

$banco = new Banco;
$cod = $_REQUEST['codigo'];
$_SESSION['cod_nf'] = $cod;
$statemente = $banco->pdo->prepare("SELECT id_pedido from codigo where cod = :id_pedido");
$statemente->bindValue(':id_pedido', $cod, PDO::PARAM_INT);
$statemente->execute(); // Query is executed successfully									
$result = $statemente->fetch();
$n_pedido = $result['id_pedido'];

$statemente = $banco->pdo->prepare("SELECT descricao, quantidade, EAN, cod_prod FROM pedidos where n_pedido = :n_pedido");
$statemente->bindValue(':n_pedido', $n_pedido, PDO::PARAM_INT);
$statemente->execute();
$result = $statemente->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<style>
		table,
		th,
		td {
			border: 1px solid black;
			border-collapse: collapse;
			padding: 5px;
		}
	</style>
</head>

<body>
	<?php
	//$filename = 'produto.txt';
	$produto = [];
	foreach ($result as $value) {
		// serealiza todo os produtos no array
		$produto[] = new produto($value['descricao'], $value['quantidade'], $value['EAN'],$value['cod_prod']);
	}
	
	$pedido = new pedido($n_pedido, $produto);
	$salva = serialize($pedido);
	$id = uniqid('pedido').'.db';
	$eansessao = uniqid('pedido').'.db';
	$_SESSION['dadospedido'] = $id;
	$_SESSION['eansessao'] = $eansessao;
	file_put_contents($id, $salva);
	header("Location: pikingpack.php");


	?>
</body>

</html>
<?php
ob_end_flush();
?>