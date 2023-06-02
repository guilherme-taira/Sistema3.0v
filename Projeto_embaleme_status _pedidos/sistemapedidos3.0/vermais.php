<?php
include "index.php";
$_SESSION['cod_id'] = $_GET['codigo'];
$cod = $_SESSION['cod_id'];
include_once 'conexao.php';
$sql = "SELECT *,ocorrencias.id as id_oc FROM ocorrencias inner join colaborador on ocorrencias.colaborador_id = colaborador.id where ocorrencias.id=$cod";
$result = $conn->query($sql);
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <div class="container">
        <div class="row align-items-start">
            <div class="col">
                <form action="edita_ocorrencia.php" method="POST">
                    <input type="text" name="id" value="<?php echo $_SESSION['cod_id']; ?>" style="visibility: hidden">
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Observação</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" disabled><?php echo $row['observacao']; ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Resolucao</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" disabled><?php echo $row['resolucao']; ?></textarea>
                        </div>
                        <?php if($row['responsavel2'] == 0){ echo "";} else{ ?>
                            <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Outros Responsáveis pela Ocorrência</label>
                            <input class="form-control" id="exampleFormControlTextarea1" rows="3" value="<?php echo $row['resp2']; ?>"disabled></input>
                        </div>
                       <?php } ?>

                       <?php if($row['responsavel3'] == 0){ echo "";} else{ ?>
                            <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Outros Responsáveis pela Ocorrência</label>
                            <input class="form-control" id="exampleFormControlTextarea1" rows="3" value="<?php echo $row['resp3']; ?>"disabled></input>
                        </div>
                       <?php } ?>

                       <?php if($row['responsavel4'] == 0){ echo "";} else{ ?>
                            <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Outros Responsáveis pela Ocorrência</label>
                            <input class="form-control" id="exampleFormControlTextarea1" rows="3" value="<?php echo $row['resp4']; ?>"disabled></input>
                        </div>
                       <?php } ?>
                    <?php } ?>
                    
         
            </div>
      
        </div>

        <?php
                $path = "imagens/01-06-21";
                $pasta = "";
                $diretorio = dir($path);
                
                echo "Lista de Arquivos da Pasta Ocorrência:  '<strong>".$path."</strong>':<br />";
                echo "<table class='table table-striped'>";
                echo "<th>Fotos da Ocorrência</th>";
                $i = 0;
                while($arquivo = $diretorio -> read()){
                    $i++;
                   if($arquivo == '.' || $arquivo == '..'){
                    $i--;
                   }else{
                
                    echo "<tr>";
                    echo " <td><a href='$path/$arquivo'>Foto $i -  $arquivo.</a></td>";
                    
                   
                   }
                }
                echo "</tr>";
                    echo "</table>";
                $diretorio -> close();
            ?>
</body>

</html>