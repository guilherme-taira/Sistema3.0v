<?php
include_once 'index.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pesquisa emcomendas</title>
  
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    google.charts.load('current', {
      'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ['Data', 'Diário', 'Semanal', 'Mensal'],
        <?php
        $data = date('m-d');
        include_once 'conexao.php';
        $row_chart = "SELECT F.nome, F.id_departamento, (SELECT COUNT(C.cod) FROM codigo C WHERE C.colaborador = F.id and C.Tipo = 'F' and datas like '%$data%'GROUP BY C.colaborador) AS Dia, (SELECT COUNT(C.cod) FROM codigo C WHERE C.colaborador = F.id and C.Tipo = 'F' and datas LIKE '%2021-06%' GROUP BY C.colaborador ) AS Mes, (SELECT COUNT(C.cod) FROM codigo C WHERE C.colaborador = F.id and C.Tipo = 'F' and datas BETWEEN '2021-06-14 00:00' and '2021-06-21 23:59' GROUP BY C.colaborador ) AS Semana FROM colaborador F GROUP BY F.nome HAVING F.id_departamento = '3' and COALESCE(Dia,0)";
        $result2 = $conn->query($row_chart);
        while ($row_chart = mysqli_fetch_array($result2)) {
          $nome = $row_chart['nome'];
          $dia = $row_chart['Dia'];
          $semana = $row_chart['Semana'];
          $mes = $row_chart['Mes'];
        ?>['<?php echo $nome ?>', <?php echo $dia ?>, <?php echo $semana ?>, <?php echo $mes ?>],
        <?php } ?>
      ]);

      var options = {
        title: 'Performance da Expedição',
        hAxis: {
          title: 'Year',
          titleTextStyle: {
            color: '#333'
          }
        },
        vAxis: {
          minValue: 0
        }
      };

      var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
      chart.draw(data, options);
    }
  </script>



  <!---- Tabela de produtividade por plataforma --->
  <script type="text/javascript">
    google.charts.load('current', {
      'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawVisualization);

    function drawVisualization() {
      // Some raw data (not necessarily accurate)
      var data = google.visualization.arrayToDataTable([
        ['Junho', 'MarketPlace', 'Site', 'Total', 'Average'],
        <?php
        $data = date('Y-m-d');

        include_once 'conexao.php';
        $row_chart = "SELECT F.nome, F.id_departamento, (SELECT COUNT(C.id_mktplace) FROM codigo C WHERE C.colaborador = F.id and C.Tipo = 'F' and datas like '%$data%' and C.id_mktplace = 1 GROUP BY C.colaborador) AS Marketplace, (SELECT COUNT(C.id_mktplace) FROM codigo C WHERE C.colaborador = F.id and C.Tipo = 'F' and datas like '%$data%' and C.id_mktplace = 2 GROUP BY C.colaborador) AS Site, (SELECT COUNT(C.id_mktplace) FROM codigo C WHERE C.colaborador = F.id and C.Tipo = 'F' and datas like '%$data%' GROUP BY C.colaborador) AS Total FROM colaborador F GROUP BY F.nome HAVING F.id_departamento = 3 and COALESCE(Marketplace,0) and COALESCE(Site,0)";
        $result2 = $conn->query($row_chart);
        while ($row_chart = mysqli_fetch_array($result2)) {
          $nome = $row_chart['nome'];
          $mktplace = $row_chart['Marketplace'];
          $site = $row_chart['Site'];
          $total = $row_chart['Total'];
        ?>['<?php echo $nome ?>', <?php echo $mktplace ?>, <?php echo $site ?>, <?php echo $total ?>, <?php echo $total ?>],
        <?php } ?>
      ]);

      var options = {
        title: 'Produtividade Marketplaces & Site',
        vAxis: {
          title: 'Quantidade'
        },
        hAxis: {
          title: '<?php echo $data; ?>'
        },
        seriesType: 'bars',
        series: {
          3: {
            type: 'line'
          }
        }
      };

      var chart = new google.visualization.ComboChart(document.getElementById('chart_div1'));
      chart.draw(data, options);
    }
  </script>

  <!----- Final da Planilha ---->
</head>

<body>



  <div class="container-md">


      <p class="h5">Pedidos : <?php echo $data = date('Y/m/d');?></p>

      <button type="button" class="btn btn-success position-relative">
        Em Espera (Bling)
        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
          <!----- Valor de pedidos integrados ---->
    
        40+
          <span class="visually-hidden">unread messages</span>
        </span>
      </button>
      &nbsp;&nbsp;&nbsp;&nbsp;
      <!----- Espaço entre botão ---->
      <button type="button" class="btn btn-warning">
        Integrados <span class="badge bg-danger">10</span>
      </button>

    <br>
    <br>
    <p class="h5">Buscar Pendência : </p>

    <form action="busca_avancada.php" method="POST">
      <label for="opcoes" class="exampleFormControlSelect1"></label>
      <input class="form-control" type="text" placeholder="Digite o Código da Caixa" name="codigo">
      <br>

      <button type="submit" value="Pesquisar" class="btn btn-primary">Pesquisar</button>
    </form>

    <br>
    <div class="accordion" id="accordionExample">
      <div class="accordion-item">
        <h2 class="accordion-header" id="headingOne">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
            Pendências em Haver
          </button>
        </h2>
        <div id="collapseOne" class="accordion-collapse collapse collapsed" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
          <div class="accordion-body">
            <?php
            include_once 'conexao.php';

            $sql = "SELECT codigo.id,cod, nome, datas, Tipo FROM `codigo` INNER JOIN colaborador on codigo.colaborador = colaborador.id where Tipo = 'P'";

            $result = $conn->query($sql);
            $time = date('m-d');
            if ($result->num_rows > 0) {
              // output data of each row
              while ($row = $result->fetch_assoc()) {
                if (strncasecmp($row["datas"], $time, 10)) {
                  echo "
                        <div class='alert alert-danger' role='alert'>
                        <img src='imagens/atencao.png' class='rounded' style='width:25px'> Pendência Atrasada, Verifique! <br>
                      </div>";
                } else {
                  echo "<div class='alert alert-success' role='alert'>
                  <img src='imagens/correto.png' class='rounded' style='width:25px'>  Pendência em Dia 
                         </div>";
                }
                echo " <table class='table'>
                             <thead>
                               <tr>
                                 <th scope='col'>Código</th>
                                 <th scope='col'>Colaborador(a)</th>
                                 <th scope='col'>Data</th>
                                 <th scope='col'>Tipo</th>
                                 <th scope='col'>Motivo</th>
                                 <th scope='col'>Editar</th>
                               </tr>
                             </thead>
                             <tbody>
                               <tr>
                                 <td>" . $row["cod"] . "</td>
                                 <td>" . $row["nome"] . "</td>
                                 <td>" . $row["datas"] . "</td>
                                 <td>" . $row["Tipo"] . "</td>
                                 <td><a href='vermais_pendencia.php?codigo={$row['id']}''> <img src='imagens/pendencia.png' class='rounded' style='width:30px'></a></td>
                                 <td><a href=editar_codigo.php?codigo={$row['id']}> <img src='imagens/editar.png' class='rounded' style='width:30px'></a></td>
                               </tr>
                             </tbody>
                           </table>";
              }
            } else {
              echo "Não Há registro de Pendências";
            }
            $conn->close();

            ?>

          </div>
        </div>
      </div>
    </div>

    <br>

    <!--- Painel de controle -->
    <div class="accordion accordion-flush" id="accordionFlushExample">
      <div class="accordion-item">
        <h2 class="accordion-header" id="flush-headingOne">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
            Pedidos Com Erro de Saída e Volta

          </button>
        </h2>
        <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
          <div class="accordion-body">
            <a href="verifica_dados_saida.php"> <button type="button" class="btn btn-warning"> Abrir Painel </button></a>

          </div>
        </div>
      </div>

    </div>

    <div id="chart_div1" style="width: 100%; height: 500px"></div>
    <div id="chart_div" style="width: 100%; height: 500px;"></div>
  </div>
</body>

</html>
