<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<title>Completar proximos campos</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	</head>
	<body>
		<script type='text/javascript'>
			$(document).ready(function(){
				$("input[name='cod_loja']").blur(function(){
					var $descricao = $("input[name='descricao']");
					var $peso = $("input[name='peso']");
					var $ean = $("input[name='ean']");
					$.getJSON('function.php',{ 
						pedido: $( this ).val() 
					},function( json ){
						$descricao.val( json.descricao );
						$peso.val( json.peso );
						$ean.val( json.ean );
					});
				});
			});
		</script>
		<h1>Produto: </h1>
		<form method="POST" action="">
			<label>Codigo Interno</label>
			<input type="text" class="form-control" name="cod_loja"><br><br>
			
			<label>Descrição do Produto</label>
			<input type="text" class="form-control" name="descricao"><br><br>
			
			<label>Quantidade</label>
			<input type="text" class="form-control" name="quantidade"><br><br>

			<label>Peso</label>
			<input type="text" class="form-control" name="peso"><br><br>

			<label>EAN - Código de Barras</label>
			<input type="text" class="form-control" name="ean"><br><br>
			
			<input type="submit" value="Editar">
		</form>
	</body>
</html>