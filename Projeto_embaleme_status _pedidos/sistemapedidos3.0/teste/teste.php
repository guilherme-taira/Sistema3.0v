<html>

<head>
    <title>Auto Refresh Div Content Demo | jQuery4u</title>
    <!-- For ease i'm just using a JQuery version hosted by JQuery- you can download any version and link to it locally -->
    <script src="https://code.jquery.com/jquery-latest.js"></script>
</head>

<body>
    <div class="container">
        <?php
        $codigo = "35221100458459000133550030001875611963579253";
        $funcionar1io = 1;
        $tipo = "V";
        include "bridge/classeConcreta.php";
        include "bridge/implementadorGravaInvoice.php";
        $pedido = new CadastrarInvoice(new ImplementadorType);
        $pedido->EncaminharUrl($codigo,$tipo);
        $status = $pedido->gravar($codigo, $tipo, 20000, 0, 1, 1, "", "159140", 0, 0, 0, 0);

        ?>
    </div>
</body>

</html>