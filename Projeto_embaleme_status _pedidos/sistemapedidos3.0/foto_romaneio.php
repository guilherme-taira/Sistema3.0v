<?php
include_once 'index.php';
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
?>
<html>

<head>
    <title>Upload de imagens</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h2><strong>Envio de Romaneio</strong></h2>
        <hr>

        <form method="POST" enctype="multipart/form-data">
            <label for="conteudo">Enviar imagem:</label>
            <input type="file" name="pic" accept="image/*" class="form-control">

            <div aling="center">
                <br>
                <button type="submit" class="btn btn-success">Enviar imagem</button>
               
            </div>
        </form>
        <br>
        <a href="busca_romaneio.php"><button class="btn btn-success">Ver Imagem</button></a>
        <hr>

        <?php
        $diretorio = date("d-m-y");
       
        if(!is_dir("./imagens/".$diretorio)){
            echo " 
            <div class='alert alert-success ' role='alert'>
             Pasta de foto Data :   {$diretorio} Foi Criada com Sucesso!
            </div>";
                mkdir("./imagens/".$diretorio);
        
        }else{
            echo " 
            <div class='alert alert-info' role='alert'>
             Diretorio Na Data : {$diretorio} Já foi Criado!
            </div>";
        }


        if (isset($_FILES['pic'])) {
            $ext = strtolower(substr($_FILES['pic']['name'], -4)); //Pegando extensão do arquivo
            $new_name = date("d-m-Y-H.i.s") . $ext; //Definindo um novo nome para o arquivo
            $dir = './imagens/'.$diretorio; //Diretório para uploads

            move_uploaded_file($_FILES['pic']['tmp_name'], $dir . $new_name); //Fazer upload do arquivo
            echo '<div class="alert alert-success" role="alert" align="center">
          <img src="./imagens/' . $new_name . '" class="img img-responsive img-thumbnail" width="200px"> 
          <br>
          Imagem enviada com sucesso!
          <br>
            </div>';
        } ?>


  
    </div>

    <body>

</html>