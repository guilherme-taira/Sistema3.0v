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
        $sql = "SELECT codigo.id,cod, nome, datas, Tipo, peso, peso_loja,divergencia_peso FROM `codigo` INNER JOIN colaborador on codigo.colaborador = colaborador.id where codigo.colaborador = $this->funcionario and datas like '$datanova%' and Tipo = 'M'";
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
                        <th scope='col'>Eliminar</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>".$row["cod"]."</td> 
                        <td>".$row["nome"]."</td>
                        <td>".$row["datas"]."</td>
                        <td>".$row["Tipo"]."</td>
                        <td>".$row["peso"]."</td>
                        <td>".$row["peso_loja"]."</td>
                        <td>".$row["divergencia_peso"]."</td>
                        <td><a href='delete.php?codigo={$row['id']}&Tipo=M'> <img src='imagens/bin.png' class='rounded' style='width:30px'></a></td>
                      </tr>
                    </tbody>
                  </table>";
            }
          } else {
            echo "Não Há registro do Mandaê Digitado";
          }
          $conn->close();
        }
        }
?>