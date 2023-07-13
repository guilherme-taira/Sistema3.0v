async function start() {

    var btnRastreador = document.getElementById('btnrastreador');
    var btnCalculadora = document.getElementById('btncalculadora');

    var pageCaculate = document.getElementById("calculate-page");
    var pageRastreio = document.getElementById("rastreio-page");

    btnRastreador.addEventListener("click", showRastreadorPage);
    btnCalculadora.addEventListener("click", showCalculadoraPage);

    function showRastreadorPage() {
        //console.log('clicou Rastreador');
        pageCaculate.style.display = "none";
        pageRastreio.style.display = "block";
    }

    // função que trás os rastreios dos produtos
    $('#btnrastreador').click(function () {
        const rastreio = getRastreios();
        //console.log(rastreio);
    });

    function showCalculadoraPage() {
        console.log('clicou calculadora');
        pageCaculate.style.display = "block";
        pageRastreio.style.display = "none";
    }

    chrome.tabs.query({
        currentWindow: true,
        active: true
    }, function (tabs) {

        var linkML = tabs[0].url;
        var dados = linkML.split('-')[1];
        idML = 'MLB' + dados;
        const req = async () => {
            const mlresponse = await RequestMLApi(`https://api.mercadolibre.com/items?ids=${idML}`);
            return mlresponse;
        }

        req().then(data => {
            const {
                body: {
                    date_created,
                    health,
                    last_updated,
                    listing_type_id,
                    price,
                    pictures,
                    title,
                    attributes
                }
            } = data[0];

            // calculo de frete pelo peso
            try {
                const {
                    value_struct: {
                        number
                    }
                } = attributes[13] || '0';
                const frete = Frete(number);
            } catch (error) {
                const frete = Frete(0);
            }


            $('#form-name').val(title);
            $('#form-precoatual').val(price);
            $('.progress-value').append(parseInt(health * 100) + '%');


            // valor do preço desejado
            $('#form-precodesejado').on('change paste keyup', function () {
                if (parseFloat($('#form-precodesejado').val()) > 79.99) {
                    $('.msg-fretegratis').removeClass('d-none');
                    $('#form-frete').val(frete).css('background-color', '#89fe00');
                } else {
                    $('.msg-fretegratis').addClass('d-none')
                }

                const preco = $('#form-precodesejado').val();

                $('#tipoAnuncio').change(function () {
                    const tipoAnuncio = $('#tipoAnuncio option:selected').val();

                    if (preco > 0.00 && tipoAnuncio != '') {
                        // Tipo de anuncio baseado na tarifa
                        const requisitionTarifa = async () => {
                            const tafiraPrecoDesejado = await RequestMLApi(`https://api.mercadolibre.com/sites/MLB/listing_prices?price=${preco}&listing_type_id=${tipoAnuncio}`);
                            return tafiraPrecoDesejado;
                        }

                        requisitionTarifa().then(data => {
                            var {
                                sale_fee_amount: tarifa,
                                listing_type_name: tipo,
                            } = data[0];
                            const valordesejado = parseFloat($('#form-precodesejado').val());
                            const total = parseFloat(frete) + parseFloat(tarifa);
                            const liquido = valordesejado - total;
                            $('#resultado').val('Tarifa : ' + tarifa + ' Frete: ' + frete + ' (' + valordesejado + ' - ' + parseFloat(total) + ' )  = ' + liquido.toFixed(2));
                        });
                    }
                });


            });
        });
    });

    function formatDate(date) {
        const startTime = new Date(date);
        startTime.setDate(startTime.getDate());
        const dataPeriodo = startTime.toLocaleDateString();

        return dataPeriodo;
    }

    function Frete(peso) {
        if (peso <= 500) {
            return 16.50;
        } else if (peso >= 500 && peso <= 1000) {
            return 18.45;
        } else if (peso >= 1000 && peso <= 2000) {
            return 18.95;
        } else if (peso >= 2000 && peso <= 5000) {
            return 23.45;
        } else if (peso >= 5000 && peso <= 9000) {
            return 34.95;
        } else if (peso >= 9000 && peso <= 13000) {
            return 54.95;
        } else if (peso >= 13000 && peso <= 17000) {
            return 60.95;
        } else if (peso >= 17000 && peso <= 23000) {
            return 71.45;
        } else if (peso >= 23000 && peso <= 30000) {
            return 82.45;
        } else if (peso >= 30000 && peso <= 40000) {
            return 93.45;
        } else if (peso >= 40000 && peso <= 50000) {
            return 99.95;
        } else if (peso >= 50000 && peso <= 60000) {
            return 107.45;
        } else if (peso >= 60000 && peso <= 70000) {
            return 115.45;
        } else if (peso >= 70000 && peso <= 80000) {
            return 122.95;
        } else if (peso >= 80000 && peso <= 90000) {
            return 130.95;
        } else if (peso >= 90000 && peso <= 100000) {
            return 138.45;
        }


    }

    async function getRastreios() {

        // ORDER NUMBER
        $.ajax({
            url: "http://127.0.0.1:8000/api/v1/rastreios",
            type: "GET",
            headers: {
                "Access-Control-Allow-Origin": "*",
                'Access-Control-Allow-Headers': 'Origin, Content-Type, X-Auth-Token',
                'Access-Control-Allow-Methods': 'GET, POST, PATCH, PUT, DELETE, OPTIONS',
                'X-Requested-With': 'XMLHttpRequest'
            },

            success: function (response) {
                // RESPONSE JSON DATA
                if (response) {
                    //SHOW ALL RESULT QUERY
                    var index = [];
                    var total = 0;
                    $.each(response.dados, function (i, item) {

                        // VARIAVEIS QUE TIRA OS 7 DIAS
                        const startTime = new Date(item.dataVerificada);
                        const today = new Date();
                        const oneDay = 24 * 60 * 60 * 1000; // h m s m
                        const diffDays = Math.round(Math.abs(startTime - today) / oneDay);

                        // REQUISIÇÂO PARA PEGAR DADOS DE VISITA PRAZO MAXIMO 7 DIAS
                        const req = async () => {
                            const res = await RequestMLApi(`http://127.0.0.1:8000/api/v1/visitas?ids=${item.codigo}&date=${item.dataVerificada}&days=${diffDays}`);
                            return res;
                        }

                        req().then(data => {
                            var res = JSON.parse(data);
                            const { results, item_id } = res; // retorna as visitas e o id do produto

                            // GET VALUE OF ITERATOR
                            const {codigo} = item;

                                 // DATA ATUAL 
                                 let today = new Date();
                                 const dataAual = today.toISOString().split('T')[0];

                            if (codigo == item_id) {
                                index[i] =
                                    "<tr class='py-2' id='produtosget'><td><img src=" + item.foto + " class='img-thumbnail mt-2' alt='Produto'></td>" + "<td class='nome-produto px-2'>" + item.name + "<hr>" + item.codigo + "</td></tr>";

                                    /**
                                     * ITEM OS VALORES DAS VISITAS
                                     **/ 

                                     $(results).each(function(indice,ele){

                                        // VARIAVEIS DATA E TOTAL DE VISITAS

                                        /**
                                         * PRECISA VERIFICAR SE A DATA QUE FOI ATIVADA
                                         * O RASTREIO É MENOR QUE A DATA ATUAL E SE FOR MENOR QUANTOS DIAS
                                         * ELE É MENOR E PEGAR A QUANTIDADE DE DIAS E IR SUBTRAINDO PRA PODER
                                         * NA REQUISICAO ELE PEGAR OS DIAS CORRETOS, SABENDO QUE 7 É O MAIOR 
                                         */

                                         const {date,total} = ele;
  
                                         if(item.dataVerificada > dataAual){
                                            index[i] += "<tr><th>Data</th><th>Visitas</th></tr>";
                                            index[i] += `<td>${formatDate(date)}</td><td>${total}</td><tr>`; 
                                         }
                                         
                                    });
                            } else {
                                   "<tr class='alert alert-danger' id='produtosget'><td>Você não tem produtos rastreados!</td><td></tr>";
                            }

                            var arr = jQuery.makeArray(index[i]);
                            arr.reverse();
                            $("#contentReturnApi").after(arr);
                        });
                    
                    });
                }
                // FINAL RESPONSE
            },
            error: function (error) {
                console.log(error);
            }
        });
    }


}
async function RequestMLApi(url) {
    try {
        const config = {
            method: 'GET',
            headers: {
                Accept: 'aplication/json',
                'Content-Type': 'aplication/json'
            },
        }

        const response = await fetch(url, {
            method: 'GET',
            headers: {
                'Access-Control-Allow-Origin': '*',
                'content-type': 'application/json',
                'Access-Control-Allow-Methods': 'GET',
            }
        });
        const res = await response.json();
        return res;

    } catch (error) {
        console.log(error)
    }



}



start();