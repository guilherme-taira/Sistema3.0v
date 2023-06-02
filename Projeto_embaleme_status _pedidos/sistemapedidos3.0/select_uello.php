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
        $sql = "SELECT cod, nome, datas, Tipo, peso, peso_loja,divergencia_peso FROM `codigo` INNER JOIN colaborador on codigo.colaborador = colaborador.id where codigo.colaborador = $this->funcionario and datas like '$datanova%' and Tipo = 'U'";
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
                        <th scope='col'>Sigla</th>
                        <th scope='col'>Peso Tray</th>
                        <th scope='col'>Peso Loja</th>
                        <th scope='col'>Divergência</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>".$row["cod"].'<a href=editar_codigo.php?codigo='.$row["id"].'> Editar </a>'."</td> 
                        <td>".$row["nome"]."</td>
                        <td>".$row["datas"]."</td>
                        <td>".$row["Tipo"]."</td>
                        <td>".$row["peso"]."</td>
                        <td>".$row["peso_loja"]."</td>
                        <td>".$row["divergencia_peso"]."</td>
                      </tr>
                    </tbody>
                  </table>";
            }
          } else {
            echo "Não Há registro da Uello Digitado";
          
          }
        
          $conn->close();


        }

        }
?>