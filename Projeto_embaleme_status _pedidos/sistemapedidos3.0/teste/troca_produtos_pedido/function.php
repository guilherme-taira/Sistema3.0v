<?php
include_once("conexao.php");

function retorna($cod_loja, $conn){
	$result_aluno = "SELECT *, peso FROM produto inner join pedidos on pedidos.EAN = produto.ean WHERE cod_loja = '$cod_loja' LIMIT 1";
	$resultado_aluno = mysqli_query($conn, $result_aluno);
	if($resultado_aluno->num_rows){
		$row_aluno = mysqli_fetch_assoc($resultado_aluno);
		$valores['descricao'] = $row_aluno['descricao'];
		$valores['peso'] = $row_aluno['peso'] * 1000;
		$valores['ean'] = $row_aluno['ean'];
	}else{
		$valores['descricao'] = 'Aluno não encontrado';
	}
	return json_encode($valores);
}

if(isset($_GET['pedido'])){
	echo retorna($_GET['pedido'], $conn);
}
?>