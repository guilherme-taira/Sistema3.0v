function CriaRequest() {
    try{
        request = new XMLHttpRequest();
    }catch (IEAtual){

        try{
            request = new ActiveXObject("Msxml2.XMLHTTP");
        }catch(IEAntigo){

            try{
                request = new ActiveXObject("Microsoft.XMLHTTP");
            }catch(falha){
                request = false;
            }
        }
    }

    if (!request)
        alert("Seu Navegador não suporta Ajax!");
    else
        return request;
}

/**
 * Função para enviar os dados
 */
function getDados() {

    // Declaração de Variáveis
    var nome   = document.getElementById("txtnome").value;
    var inicial   = document.getElementById("data_inicial").value;
    var final   = document.getElementById("data_final").value;
    var result = document.getElementById("resultado");
    var xmlreq = CriaRequest();

    // Exibi a imagem de progresso
    result.innerHTML = '<img src="imagens/time.gif" width="32px" height="32px"/>';

    // Iniciar uma requisição
    xmlreq.open("GET", "meu_ajax.php?nome=" + nome+"&data_inicial="+inicial+"&data_final="+final, true);

    // Atribui uma função para ser executada sempre que houver uma mudança de ado
    xmlreq.onreadystatechange = function(){

        // Verifica se foi concluído com sucesso e a conexão fechada (readyState=4)
        if (xmlreq.readyState == 4) {

            // Verifica se o arquivo foi encontrado com sucesso
            if (xmlreq.status == 200) {
                result.innerHTML = xmlreq.responseText;
            }else{
                result.innerHTML = "Erro: " + xmlreq.statusText;
            }
        }
    };
    xmlreq.send(null);
}


jQuery(window).load(function () {
    $(".loader").delay(1500).fadeOut("slow"); //retire o delay quando for copiar!
  $("#tudo_page").toggle("fast");
});