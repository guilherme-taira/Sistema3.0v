<?php

    class Produtividade{
        private $mes;
        private $ano;

        function __construct($ano,$mes)
        {
            $this->mes = $mes;
            $this->ano = $ano;
        }

        
        function retorna_dados(){

            include 'conexao.php';
            $datanova = date('Y-m-d');
            $sql = "SELECT cod, colaborador, datas, Tipo, count(cod) as Total FROM `codigo` INNER JOIN colaborador on codigo.colaborador = colaborador.id where datas like '%$datanova%' and Tipo IN('F','NF') group by colaborador";
            echo " <form action='cadastra_produtividade.php' method='POST'>";
            $result = $conn->query($sql); 
          
                if ($result->num_rows > 0) {
                  while($row = $result->fetch_assoc()) {
                    echo" 
                   
                    <table class='table'>
                    <thead>
                      <tr>
                      <th scope='col'>Colaborador</th> 
                      <th scope='col'>Data</th>
                      <th scope='col'>Total Caixa</th> 
                      </tr>
                    </thead>

                    <tbody>
                      <tr>
                      <th scope='col'><input type='text' name='nome' value=".$row['colaborador']."></th>
                      <th scope='col'><input type='text' name='datas' value=".$row['datas']."></th>
                      <th scope='col'><input type='text' name='total' value=".$row['Total']."></th>
                      </tr>
                    </tbody>

                    <tbody>
                    
                  </tbody>
                  </table>
                
                  ";

                  }
                  
                  echo "<input type='submit' value='Cadastrar'>
                  </form>";
            } else {
              echo "Não Há Resultados para o Mês Referente a pesquisa.";
            
            }
          
            $conn->close();
  
       
        }



      
    }

?>


          