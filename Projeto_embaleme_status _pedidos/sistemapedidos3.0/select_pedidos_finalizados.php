<?php

class Mostra_dados_php{


    function __construct($funcionario,$data)
    {
      
        $this->funcionario = $funcionario;
        $this->data = $data;
        
    }



    function getDados(){
        
        include "conexao.php"; 
        $datanova = date('Y-m-d');
        $sql = "SELECT cod, nome, datas, Tipo, local_mktplace as Plataforma FROM codigo INNER JOIN colaborador on codigo.colaborador = colaborador.id INNER JOIN codigo_mktplace on codigo_mktplace.id = codigo.id_mktplace where codigo.colaborador = $this->funcionario and datas like '$datanova%' and Tipo = 'F'";
        $result = $conn->query($sql);
          
          if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
      
               echo" <table class='table'>
                    <thead>
                      <tr>
                        <th scope='col'>Código</th>
                        <th scope='col'>Colaborador(a)</th>
                        <th scope='col'>Data</th>
                        <th scope='col'>Status</th>
                        <th scope='col'>Plataforma</th>
                        <th scope='col'>Eliminar</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                
                        <td>".$row["cod"].'<a href=editar_codigo.php?codigo='.$row["id"].'> Editar </a>'."</td> 
                        <td>".$row["nome"]."</td>
                        <td>".$row["datas"]."</td>
                        <td>".$row["Tipo"]."</td>
                        <td>".$row["Plataforma"]."</td>
                        <td><a href='delete.php?codigo={$row['id']}&Tipo=F'> <img src='imagens/bin.png' class='rounded' style='width:30px'></a></td>
                      </tr>
                    </tbody>
                  </table>";
            }
          } else {
            echo "Não Há registro de Pedidos Finalizado";
          
          }
        
          $conn->close();


        }

        }
?>