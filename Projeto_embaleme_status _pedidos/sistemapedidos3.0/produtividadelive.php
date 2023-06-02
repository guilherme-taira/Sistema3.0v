<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <script src="http://code.jquery.com/jquery-latest.min.js"></script>
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js"></script>
  <title>Produtividade AoVivo</title>
  <script>
        function update() {
            $('#atualiza').load("produtividadelive.php #atualiza");
        }
           setInterval('update()', 1000);

 </script>

<!-- <script type="text/javascript" language="javascript">
 window.onload = function(){setInterval("trocaCor()", 1000);}

     function trocaCor()
    {
      var pisca = document.getElementById("divFase2");
       pisca.style.backgroundColor = "red";
       setTimeout("trocaCor();", 1000);
    }
 </script> -->

<style>
  div{
    text-align: center;
  }
  body{
    background-color: #000;
  }
</style>
</head>
<body>
<div class="container-fluid mt-2" id="atualiza">
<div class="row">
  <?php
  include_once 'teste/conexao_pdo.php';
  $currentData = date('Y-m-d');
  $sql = "SELECT nome, Tipo,Departamento,count(cod) as Total FROM `codigo` INNER JOIN colaborador on codigo.colaborador = colaborador.id INNER JOIN Departamento on Departamento.id = colaborador.id_departamento where datas like '%$currentData%' and Tipo IN('F','NF','NF*','V') group by colaborador ORDER BY nome";
   
  $statement = $pdo->query($sql);
  $produtitivades = $statement->fetchAll(PDO::FETCH_ASSOC);
  
  foreach($produtitivades as $produtividade){
    if(intval($produtividade['Total']) <= 50)  {
      echo " <div class='col-sm-4'>
      <div class='card mt-1' id='divFase2'>
        <div class='card-body alert alert-danger'>
          <h2 class='card-title'>{$produtividade['nome']}</h2>
          Quantidade :<h3 class='card-text'>{$produtividade['Total']} - Pedidos {$produtividade['Tipo']}</h3>
        </div>
      </div>
   </div>";
    }else{
      echo " <div class='col-sm-4'>
      <div class='card mt-1'>
      <div class='card-body alert alert-success'>
          <h2 class='card-title'>{$produtividade['nome']}</h2>
          Quantidade :<h3 class='card-text'>{$produtividade['Total']} - Pedidos {$produtividade['Tipo']}</h3>
        </div>
      </div>
   </div>";
    }
  }
  ?>
</div>  
</div>
</body>
</html>
