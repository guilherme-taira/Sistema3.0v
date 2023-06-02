<?php      
    session_start();
   
     $cod = $_POST['codigo'];
     $funcionario = $_SESSION['colaborador'];
     $data =  $_SESSION['datahora'];
     include "conexao.php"; 
    if(!$funcionario == "" AND !$cod == ""){

    
    $sql = "INSERT INTO codigo (cod, colaborador,datas,Tipo)
    VALUES ('$cod','$funcionario','$data','F')";   
     ob_flush(); 
            if ($conn->query($sql) === TRUE) {
              header("Location:saida.php");
             } else {
            echo "Error:" . $sql . "<br>" . $conn->error;
             } 
        }
    ob_end_flush();
?>