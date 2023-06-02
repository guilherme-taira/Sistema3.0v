<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="jquery-3.5.1.min.js"></script>

    <style>
        .loader {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url('http://i.imgur.com/zAD2y29.gif') 50% 50% no-repeat white;
        }
    </style>



</head>

<body>
    <div id="loader" class="loader"></div>
    <div style="display:none" id="tudo_page"> CONTEUDO DA PÁGINA </div>



    <script type="text/javascript">
        $(document).keypress(function(e) {
            $(document).ready(function() {
                $(document).ready(function() {
                    $(".loader").delay(1000).fadeOut("slow"); //retire o delay quando for copiar!
                    $("#tudo_page").toggle("fast");
                });
            });
         
        });
    </script>

</body>

</html>