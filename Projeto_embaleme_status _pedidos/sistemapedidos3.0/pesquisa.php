<?php
include_once 'index.php';
?>
<div class="container-md">

  <div class="card mt-4">
    <div class="card-header">
      Digite a Chave da Nota Fiscal para Pesquisar seu Status
    </div>
    <div class="card-body">
      <h5 class="card-title">Busca Pedido</h5>
      <p class="card-text">Pedido Status: </p>
      <input class="form-control" type="text" placeholder="Digite o Código da Caixa" id="codigo" name="codigo">
      <input value="Pesquisar" type="hidden" id="enviar" class="btn btn-primary mt-4" onclick="showQueryPesquisaStatus();">

      <!-- DIV QUE MOSTRA RESULTADO DA QUERY -->
      <div id="resultadoQuery" class="mt-4"></div>
    </div>
  </div>





</div>

<script>
  $("#codigo").focus();
  $(document).ready(function() {
    $("#codigo").on("keydown", function(event) {
      if (event.which === 13) {
        showQueryPesquisaStatus();
        $("#codigo").val("");
      }
    });
  });
</script>