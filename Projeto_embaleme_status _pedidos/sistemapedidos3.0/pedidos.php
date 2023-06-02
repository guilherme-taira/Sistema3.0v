<?php
include "index.php";
?>
<div class="container mt-4">
    <div class="container-md">
        <form action="opcao.php" method="POST">
            <div class="card">
                <div class="card-header">
                    Escolha a Operação Desejada
                </div>
                <div class="card-body">
                    <h5 class="card-title">Opções</h5>
                    <p class="card-text">Abra a pagina desejada clicando nas opções abaixo</p>
                    <div class="d-grid gap-2 col-6 mx-auto">
                        <button class="btn btn-success py-4" type="submit" name="op" value="1"><i class="bi bi-clipboard2-check"></i>&nbsp; Saída</button>
                        <button class="btn btn-warning py-4" type="submit" name="op" value="2"><i class="bi bi-card-checklist"> &nbsp;</i>Picking & Packing (Volta)</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>