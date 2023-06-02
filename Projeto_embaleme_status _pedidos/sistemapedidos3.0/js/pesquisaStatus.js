

var xmlhttp = false;

try {
    xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
} catch (error) {
    try {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    } catch (error) {
        xmlhttp = false;
    }
}

if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
    xmlhttp = new XMLHttpRequest();
}


function showQueryPesquisaStatus() {

    var content = document.getElementById("resultadoQuery");
    var codigo = document.getElementById("codigo").value;

    var serverPage = "busca_avancada.php?codigo=" + codigo;

    xmlhttp.open("GET", serverPage);
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            content.innerHTML = xmlhttp.responseText;
        }
    }

    xmlhttp.send(null);
}
