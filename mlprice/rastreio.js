async function rastreio() {

    chrome.tabs.query({
        currentWindow: true,
        active: true
    }, function (tabs) {
        var linkML = tabs[0].url;
        var dados = linkML.split('-')[1];
        idML = 'MLB' + dados;
        const req = async () => {
            const mlresponse = await RequestMLApi(`https://api.mercadolibre.com/items?ids=${idML}`);
            //console.log(mlresponse);
            return mlresponse;
        }

        req().then(data => {
            const {
                body: {
                    id,
                    date_created,
                    health,
                    last_updated,
                    listing_type_id,
                    price,
                    pictures,
                    title,
                    attributes,
                    sold_quantity: estoque,
                    secure_thumbnail: foto
                }
          
            } = data[0];

            const req = async() => {
                const visitas = await RequestMLApi(`http://127.0.0.1:8000/api/v1/visitas?ids=${id}`);
                return visitas;
            }

            req().then(data => {
                //console.log(data);                
            });

            $('#abrirRastreado').on('click', function () {
                $('#msg_rastreio').removeClass('d-none')
                    .addClass('alert alert-success')
                    .append('agora você esta acompanhando este produto!')
                    .slideUp(3000);

                /*
                 *  API DE RASTREIO
                 */

               // REQUISIÇÂO PARA PEGAR DADOS DE VISITA PRAZO MAXIMO 7 DIAS
               req = async () => {
                const res = await RequestMLApi(`http://127.0.0.1:8000/api/v1/visitas?ids=${id}`);
                return res;
              }

                request().then(data => {
                    var {
                        id,
                        title,
                        foto,
                        estoque,
                        price
                    } = data || null;
                    console.log(data);
                });

            });
            
        });

    });
}

async function RequestMLStore(url, codigo, name, foto, estoque, preco) {
    try {
        const config = {
            method: 'POST',
            body: JSON.stringify({
                'codigo': codigo,
                'name': name,
                'foto': foto,
                'estoque': estoque,
                'preco': preco
            }),
            headers: {
                Accept: 'aplication/json',
                'Content-Type': 'aplication/json',
            },
        }

        const response = await fetch(url, config);
        const res = await response.json();
        return res;

    } catch (error) {
        console.log(error)
    }

}

async function RequestMLApi(url) {
    try {
        const config = {
            method: 'GET',
            headers: {
                cache: 'only-if-cached',
                mode: 'no-cors',
                'Access-Control-Allow-Origin': '*',
                'Access-Control-Allow-Methods': 'GET',
                'Access-Control-Allow-Headers':'*',
                'Access-Control-Max-Age':'86400',
            },
        }

        const response = await fetch(url, config);
        const res = await response.json();
        return res;

    } catch (error) {
        console.log(error)
    }

}

rastreio();
