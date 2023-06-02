
    <?php
    // variavel chave da nota fiscal para pesquisar
    $codigo = isset($_REQUEST['codigo']) ? $_REQUEST['codigo'] : 0;

    function busca_avancada($codigo)
    {

      include "teste/conexao_pdo.php";

        $sql = "SELECT *,codigo.id as ID_CODIGO FROM codigo INNER JOIN colaborador on codigo.colaborador = colaborador.id where cod = '$codigo'";
        $statement = $pdo->query($sql);
        $registros = $statement->fetchAll(PDO::FETCH_ASSOC);
        $result = count($registros);
        
        if ($result > 0) {
        echo "<table class='table table-striped table-hover'>
        <thead>
          <tr>
            <th scope='col'>ID</th>
            <th scope='col'>Chave Nota Fiscal</th>
            <th scope='col'>Colaborador</th>
            <th scope='col'>Data hora</th>
            <th scope='col'>Status</th>
            <th scope='col'>Peso Produtos</th>
            <th scope='col'>Peso Loja</th>
            <th scope='col'>Divergência</th>
          </tr>
        </thead>
        <tbody>";

        foreach ($registros as $registro) {
          echo "  
            <tr>
            <td>{$registro['ID_CODIGO']}</td>
            <td>{$registro['cod']}</td>
            <td>{$registro['nome']}</td>
            <td>{$registro['datas']}</td>
            <td>{$registro['Tipo']}</td> 
            <td>{$registro['peso']}</td> 
            <td>{$registro['peso_loja']}</td> 
            <td>{$registro['divergencia_peso']}</td> 
            </tr>";
        }

        "  </tbody>
        </table>";
      } else {
        echo "<div class='alert alert-warning mt-2 text-center'>Não Há registro no código Digitado</div>";
      }
    }
    ?>
