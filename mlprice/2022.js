window.onload = function () {

    "use strict"

    async function init() {

        const price = document.querySelector('div.ui-pdp-price__second-line > span.andes-money-amount.ui-pdp-price__part.andes-money-amount--cents-superscript.andes-money-amount--compact > span.andes-money-amount__fraction')
            ?.innerText.replace('.', '') || '0';

        const cents = document.querySelector('div.ui-pdp-price__second-line > span.andes-money-amount.ui-pdp-price__part.andes-money-amount--cents-superscript.andes-money-amount--compact > span.andes-money-amount__cents.andes-money-amount__cents--superscript-36')
            ?.innerText || '0';

        const sold = Number(document.querySelector('.ui-pdp-header__subtitle').innerText.split(' ')[4] || '0');

        const container = document.querySelector('.ui-pdp-header__title-container');

        const adId = document.querySelector('meta[name="twitter:app:url:iphone"]').content.split('id=')[1];
    
        const mlresponse = await RequestMLApi(`https://api.mercadolibre.com/items?ids=${adId}`);
        const { body: { category_id, listing_type_id, start_time, title,sold_quantity }
        } = mlresponse[0] || null;

        const { sale_fee_amount } =
            (await RequestMLApi(`https://api.mercadolibre.com/sites/MLB/listing_prices?price=${price}&listing_type_id=${listing_type_id}&category_id=${category_id}`) || {});


        const unitReceipt = price - sale_fee_amount;
        const Receipt = unitReceipt * sold;
        const startTime = new Date(start_time);
        const today = new Date();
        const oneDay = 24 * 60 * 60 * 1000; // h m s m
        const diffDays = Math.round(Math.abs(startTime - today) / oneDay);
        const daySellavg = Receipt / diffDays;

        const total = Number(price + '.' + cents) * sold;

        setTimeout(() => {
            
        // request data of product
        const req = async() => {
            const res = await RequestMLApi(`https://api.mercadolibre.com/items?ids=${adId}`);
            return res;
        } 

        req().then(async data => {
            //console.log(data[0]);
            const { body: { sold_quantity, start_time,price, title, category_id,id,listing_type_id,health,seller_address,attributes,seller_id}
        } = data[0] || null;

        // VALORES MARCA , EAN, EMPRESA E MEDALHA.
        const {value_name} = attributes[1]; // MARCA
        const BRAND = (value_name == null ? "SEM MARCA" : value_name);
        const {value_name:GTIN} = attributes[5]; // GTIN
        const EAN = (isNaN(GTIN) || GTIN == null ? "N/A" : GTIN);

        if(seller_id){
            const {nickname:empresa,seller_reputation: {power_seller_status}} = await RequestMLApi(`https://www.mercadolivrehub.embaleme.com.br/api/v1/getSellerId?sellerId=${seller_id}`);
            // VALORES MARCA , EAN, EMPRESA E MEDALHA.    
        }
        

        // city.name CIDADE DO SELLER
        // state.name CIDADE DO SELLER
        const {city,state} = seller_address;
        }, 1000);
        
         // REQUEST GET PRICE 

         const request = async() => {
            const { sale_fee_amount } =
            (await RequestMLApi(`https://api.mercadolibre.com/sites/MLB/listing_prices?price=${price}&listing_type_id=${listing_type_id}&category_id=${category_id}`) || {});
            return sale_fee_amount;
        }

        // valor da tarifa requisiçao com valor data
        request().then(data => {
        const priceTarifa = data;
        const startTime = new Date(start_time);
        startTime.setDate(startTime.getDate());
        const dataPeriodo = startTime.toLocaleDateString();
        //console.log('DATA PERIODO' + dataPeriodo);

        const today = new Date();
        today.setDate(today.getDate() - 60);
        const dataAtual = today.toLocaleDateString();
        
        const hoje = new Date();
        const oneDay = 24 * 60 * 60 * 1000; // h m s m
        const diffDays = Math.round(Math.abs(startTime - hoje) / oneDay);
        const saude = health * 100;
        

            /**
             *  LAYOUT COM OS DADOS BASEADO NAS MÉTRICAS
             *  LAYOUTS MAIOR 400PX e MENOR 400PX
             */
                 

        // DATA DO MES PASSADO DO ANUNCIO 

        const mesPassado = new Date(hoje);
        mesPassado.setDate(mesPassado.getDate() - 30);
        const dateMouthpast = mesPassado.toISOString().split('T')[0];
        

        // DATA DO ANUNCIO 
        const mesAtual = new Date(hoje);
        mesAtual.setDate(mesAtual.getDate());
        const dateMouthNow = mesAtual.toISOString().split('T')[0];

        const dadosArray = [];

        container.insertAdjacentHTML('afterend',
        `
        <div class='mlprice-Container' id='mlLoading'>
            <img src="https://s3-sa-east-1.amazonaws.com/cdn.siteblindado.com/images/loading.gif" class="loadingPicture">
        </div>
        `);
        
        const HideContent = document.getElementById('mlLoading');
        
            const req = async() => {
                // await sleep(100);
                dadosArray['dado1'] =  await getAftervisitMounth(`https://www.mercadolivrehub.embaleme.com.br/api/v1/visitasMounth?id=${adId}&date=${dateMouthpast}`);
                dadosArray['dado2'] =  await getAftervisitMounth(`https://www.mercadolivrehub.embaleme.com.br/api/v1/visitasMounth?id=${adId}&date=${dateMouthNow}`);
                HideContent.style.display = 'none';
                return dadosArray;
            }

       
            req().then(data => {
                let quantidade = 0;
                const {dado1:{total:total1,id:id1}} = data;
                const {dado2:{total:total2,id:id2}} = data;
                //console.log(`${adId}MÊS PASSADO = : ${dateMouthpast} MÊS ATUAL = :  ${dateMouthNow}`);
               
                if(total1 > total2){

                

                // função que extrai a porcentagem dos dois periodos
                const valuePorcem = calculatePorcentagemVisits(total1,total2);
                    
                    /**
                     *  CARD DE PRODUTO EM DECLINIO COM TAMANHO MAIOR DE 400PX*
                     */
                      
                     container.insertAdjacentHTML('afterend',
                     `
                     <div class='mlprice-Container2'>
                         <div class="card mb-3">
                         <div class="row g-0">
                             <div class="col-md-4">
                             <img src="https://cdn-icons-png.flaticon.com/512/1303/1303238.png" class="img-fluid rounded-start imagem-minerado" alt="...">
                             </div>
                             <div class="col-md-8">
                             <div class="card-body">
                             <h5 class="card-title">Produto em Declinio</h5>
                                <p class="card-text"><img src="https://cdn-icons-png.flaticon.com/32/981/981086.png"> ${Math.abs(valuePorcem.toFixed(2))}% - Mês Passado</p>
                            
                                </div>
                             </div>
                         </div>
                         </div>
                     </div>

                     <ul class='mlprice-Container'>
                     <li>Empresa: <span class='tituloMarca'>Máximo Produtos Software</span></li>
                     <li>Receita Bruta: <span>${formatyMoney(total)}</span></li>
                     <li>Receita Líquida <span>${formatyMoney(Receipt)}</span></li>
                     <li>Receita por Unidade <span>${formatyMoney(unitReceipt)}</span></li>
                     <li>Receita Média Diária <span>${formatyMoney(daySellavg)}</span></li>
                     <li>Comisão do Mercado Livre <span>${formatyMoney(sale_fee_amount)}</span></li>
                     <li>Receita por Unidade <span>${formatyMoney(unitReceipt)}</span></li>
                     <li>Criado Em  <span>${formatDate(startTime)} - ${diffDays} Dia(s)</span></li>
                     <li><button class="botao_ver_mais" id="botao_verperiodo" >Ver Outros Períodos</button></li>
                    </ul>
                     `);
                    
                     //console.log(`ID : ${idML}  Porcentagem subiu > ${valuePorcem} ESTE MES CAIU EM RELACAO A MES PASSADO ${total1} - ${total2}`)
                    
                }else{

                    // função que extrai a porcentagem dos dois periodos
                    const valuePorcem = calculatePorcentagemVisits(total1,total2);
                      
                    /**
                     *  CARD DE PRODUTO EM ALTA COM TAMANHO MAIOR DE 400PX*
                     */
                      
                     container.insertAdjacentHTML('afterend',
                     `
                     <div class='mlprice-Container2'>
                         <div class="card mb-3">
                         <div class="row g-0">
                             <div class="col-md-4">
                             <img src="https://cdn-icons-png.flaticon.com/512/1303/1303237.png" class="img-fluid rounded-start imagem-minerado" alt="...">
                             </div>
                             <div class="col-md-8">
                             <div class="card-body">
                             <h5 class="card-title">Produto em Alta</h5>
                             <p class="card-text"><img src="https://cdn-icons-png.flaticon.com/32/833/833580.png">${Math.abs(valuePorcem.toFixed(2))}% - Mês Passado</p>
                              
                                 </div>
                             </div>
                         </div>
                         </div>
                     </div>
                     <ul class='mlprice-Container'>
                     <li>Empresa: <span class='tituloMarca'>Máximo Produtos Software</span></li>
                     <li>Receita Bruta: <span>${formatyMoney(total)}</span></li>
                     <li>Receita Líquida <span>${formatyMoney(Receipt)}</span></li>
                     <li>Receita por Unidade <span>${formatyMoney(unitReceipt)}</span></li>
                     <li>Receita Média Diária <span>${formatyMoney(daySellavg)}</span></li>
                     <li>Comisão do Mercado Livre <span>${formatyMoney(sale_fee_amount)}</span></li>
                     <li>Receita por Unidade <span>${formatyMoney(unitReceipt)}</span></li>
                     <li>Criado Em  <span>${formatDate(startTime)} - ${diffDays} Dia(s)</span></li>
                     <li><button class="botao_ver_mais" id="botao_verperiodo" >Ver Outros Períodos</button></li>
                 </ul>
                     `);
                    }    

            document.getElementById('botao_verperiodo').onclick = function() { myFunction(adId) };

            function myFunction($id) {
                var params = [
                    'height='+screen.height,
                    'width='+screen.width,
                    'fullscreen=yes' // only works in IE, but here for completeness
                ].join(',');
                     // and any other options from
                     // https://developer.mozilla.org/en/DOM/window.open
                
                var popup = window.open(`https://www.mercadolivrehub.embaleme.com.br/metrics?id=${adId}`, params); 
                popup.moveTo(0,0);
            }
               
            });
        });

        }, 2000);

       
    }
  
    async function chromeStorageLocalGet(key) {
        return new Promise((resolve) => 
            chrome.storage.local.get([key],(result) =>{
                resolve(result[key]);
            })
        );
    }

    function formatDate(date) {
        const day = date.getDate().toString().padStart(2, '0'),
            month = (date.getMonth() + 1).toString().padStart(2, '0'),
            year = date.getFullYear();

        return `${day}/${month}/${year}`;
    }

    function formatDateCampeao(date) {
        const day = date.getDate() - 60;
        return `${day}`;
    }

    function formatyMoney(value) {
        return value.toLocaleString('pt-br', {
            style: 'currency',
            currency: 'BRL',
        });
    }


    async function pageProducts() {
        // PAGINA DE PRODUTO INIT

            /**
             *  FORMULARIO DE LOGIN ACIMA TRATA
             *  OS ERROS
            */

            setTimeout(async function() {

            const pesquisa = document.querySelector('h1.ui-search-breadcrumb__title');

            if(pesquisa){
            pesquisa.insertAdjacentHTML('beforeend',
            `<div id="form-login" class="form-login">
            <h4 class="login_h4">Login
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-bounding-box" viewBox="0 0 16 16">
            <path d="M1.5 1a.5.5 0 0 0-.5.5v3a.5.5 0 0 1-1 0v-3A1.5 1.5 0 0 1 1.5 0h3a.5.5 0 0 1 0 1h-3zM11 .5a.5.5 0 0 1 .5-.5h3A1.5 1.5 0 0 1 16 1.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 1-.5-.5zM.5 11a.5.5 0 0 1 .5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 1 0 1h-3A1.5 1.5 0 0 1 0 14.5v-3a.5.5 0 0 1 .5-.5zm15 0a.5.5 0 0 1 .5.5v3a1.5 1.5 0 0 1-1.5 1.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 1 .5-.5z"/>
            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
            </svg>
            </h4>
          

            <form class="formulario-login"> 
                <label class="label-form" id="email-login">Digite seu Email:</label>
                <input class="input-form" id="email" type="text">
                <br>
                <input class="botao-logar" type="submit" value="Entrar">
            </form>
            <div class="telefone-info"><a href="https://api.whatsapp.com/send?phone=5519999920256&text=ol%C3%A1%20seja%20Bem-Vindo%20a%20MeliM%C3%A1ximo" class="telefone-form">Suporte MeliMáximo
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-headset" viewBox="0 0 16 16">
            <path d="M8 1a5 5 0 0 0-5 5v1h1a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V6a6 6 0 1 1 12 0v6a2.5 2.5 0 0 1-2.5 2.5H9.366a1 1 0 0 1-.866.5h-1a1 1 0 1 1 0-2h1a1 1 0 0 1 .866.5H11.5A1.5 1.5 0 0 0 13 12h-1a1 1 0 0 1-1-1V8a1 1 0 0 1 1-1h1V6a5 5 0 0 0-5-5z"/>
            </svg>
            </a></div>
            </div>`);
            }

            try {
                 // GET TOKEN ACESS TOKEN
                var token_access = sessionStorage.getItem("token_access");

                const response = (await RequestHttp(`https://www.mercadolivrehub.embaleme.com.br/api/v1/users/1`,token_access));
                
                // GET ACCESS TOKEN DO BANCO
                const {access_token} = response || null;
                // COMPARA AS CHAVES DO TOKEN 
                if(token_access){
                    console.log(token_access);
                }else{
                    sessionStorage.setItem('token_access','');
                }
            
                if(response.message == 'Unauthenticated.'){
                    const errorMsgLogin = document.querySelector('#form-login');
                    if(errorMsgLogin){
                          errorMsgLogin.insertAdjacentHTML('beforebegin','<p class="msg-doLogin">Efetue o Login para Começar a Mineirar</p>');
                    }
                  
                    const h2ofTitleNameofProduct = document.getElementsByClassName('ui-search-item__group ui-search-item__group--title');
                
                    for (var i = 0, ilen = h2ofTitleNameofProduct.length -1; i < ilen; i++) {

                    h2ofTitleNameofProduct[i].insertAdjacentHTML('afterend',
                    `<div class='content-normal400width'>
                        <div class="card mb-3">
                        <div class="row g-0">
                            <div class="col-md-4">
                            <img src="https://cdn-icons-png.flaticon.com/512/3649/3649531.png" class="img-fluid rounded-start imagem-minerado" alt="...">
                            </div>
                            <div class="col-md-8">
                            <div class="card-body">
                            <h2 class="card-title">Faça login e Começe a Minerar Agora Mesmo!</h2>
                            <p class="card-text">Caso não tenha se cadastrado <a href='#'>Clique aqui!</a></p>
                           </div>
                            </div>
                        </div>
                        </div>
                        <div class='selonormal'></div>
                    </div>
                    `);
                 }
                }else{

           /**
             *  FORMULARIO DE LOGIN FINAL
            */

        setTimeout(function(){

    
            // FORMATACAO DA PAGINA SUPERMERCADO 
            var params = document.URL;
            let result = params.includes('https://lista.mercadolivre.com.br/supermercado/');
            // PAGINA SUPERMERCADO
            if(result){
                const  products = document.getElementsByClassName("ui-search-layout__item");

                for (var i = 0, ilen = products.length -1; i < ilen; i++) {
                    
                    // PARTE DE BAIXO DO CONTEUDO DO ANUNCIO
                    const content = products[i].getElementsByClassName('ui-search-result__content ui-search-link')[0];
                    const indice = i;
  
                    const idML = products[i].querySelector('div.ui-search-result__wrapper > div > div.ui-search-result__bookmark > form').action.split('/')[5]

                    // request data of product
                    const req = async() => {
                        const res = await RequestMLApi(`https://api.mercadolibre.com/items?ids=${idML}`);
                        return res;
                    } 
    
                    req().then(data => {
                        const { body: { sold_quantity, start_time, title, id,listing_type_id,price,category_id}
                    } = data[0] || null;

                    const startTime = new Date(start_time);
                    startTime.setDate(startTime.getDate());
                    const dataPeriodo = startTime.toLocaleDateString();
    
                    const today = new Date();
                    //today.setDate(today.getDate());
                    today.setDate(today.getDate() - 60);
                    const dataAtual = today.toLocaleString();
    
                        if(dataAtual > dataPeriodo){
                            // media da quantidade vendida nos ultimos 60 dias
                            const SoldAvg = Math.round(sold_quantity / 60);
                            if(SoldAvg >= 3){

                                content.insertAdjacentHTML('beforeend',
                                `
                                <div class='content-campeaoSupermercado'>
                                 <div class='seloCampeaoSupermercado'></div>
                                    <div class="card mb-3">
                                    <div class="row g-0">
                                        <div class="col-md-4">
                                        <img src="https://icon-library.com/images/mining-icon/mining-icon-15.jpg" class="img-fluid rounded-start imagem-minerado" alt="...">
                                        </div>
                                        <div class="col-md-8">
                                        <div class="card-body">
                                            <h5 class="card-title">Produto Selo Campeão</h5>
                                            <p class="card-text">Data de Criação: ${formatDate(startTime)} Quantidade de Vendas: ${sold_quantity} Und. Tipo: ${tipoanuncio(listing_type_id)}</p>
                                            <p class="card-text"><small class="text-muted">Cruiado à ${formatDate(startTime)} - ${diffDays}</small></p>
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                `);
                            }
                        }
                
                    });
                }
            }else{

                // CLASSES DE PARTE DOS ANUNCIOS
                const  products = document.getElementsByClassName("ui-search-layout__item");
                const collum = document.getElementsByClassName("ui-search-layout ui-search-layout--grid");
                const description = document.getElementsByClassName("ui-search-result__content-wrapper");
                const allDescription = document.getElementsByClassName('ui-search-result__content ui-search-link');
                const h2ofTitleNameofProduct = document.getElementsByClassName('ui-search-item__group ui-search-item__group--title');
                
                for (var i = 0, ilen = products.length -1; i < ilen; i++) {
                    
                const indice = i;

                // LOADING DOS PRODUTOS
                 h2ofTitleNameofProduct[indice].insertAdjacentHTML('afterend',
                 `
                 <div class='mlprice-Container' id='mlLoading${indice}'>
                     <img src="https://s3-sa-east-1.amazonaws.com/cdn.siteblindado.com/images/loading.gif" class="loadingPicture">
                 </div>
                 `);
                 
                 const HideContent = document.getElementById(`mlLoading${indice}`);

                    const product = document.getElementsByClassName("ui-search-result__content");
                      
                    // LARGURA DO ANUCIO
                    var clientWidth = products[i].querySelector('div.ui-search-result__wrapper').offsetWidth;
                         // APLICA MARGEM SE FOR MENOR DE 400 DE WIDTH
                        if(clientWidth < 400){

                            var descriptionHeight = description[indice].offsetHeight;
                        
                            if(descriptionHeight <= 114) {
                                
                                var element = h2ofTitleNameofProduct[indice];
                                const classes = element.classList;
                                // ADD CLASS 114 PX
                                classes.add("separaColunaProdutos114");

                            }else if(descriptionHeight > 114 && descriptionHeight <= 135){

                                var element = h2ofTitleNameofProduct[indice];
                                const classes = element.classList;
                                // ADD CLASS 132 PX
                                classes.add("separaColunaProdutos132");

                                //console.log(allDescription[indice]);
                            
                            }else if(descriptionHeight > 135 && descriptionHeight <= 149){

                                var element = h2ofTitleNameofProduct[indice];
                                const classes = element.classList;
                                // ADD CLASS 149 PX
                                classes.add("separaColunaProdutos149");

                                //console.log(allDescription[indice]);

                            }else if(descriptionHeight > 149 && descriptionHeight <= 158){
                                
                                var element = h2ofTitleNameofProduct[indice];
                                const classes = element.classList;
                                // ADD CLASS 158 PX
                                classes.add("separaColunaProdutos158");
                                //console.log(allDescription[indice]);
                            }else if(descriptionHeight > 158 && descriptionHeight <= 200){
                                
                                var element = h2ofTitleNameofProduct[indice];
                                const classes = element.classList;
                                // ADD CLASS 158 PX
                                classes.add("separaColunaProdutos173");
                                //console.log(allDescription[indice]);
                            }

                            if(collum[indice]){
                               collum[indice].insertAdjacentHTML('afterend',`<div class="separaColunaProdutos"></div>`);
                            }
                         
                        }
                        // FIM
                        
                    const idML = products[i].querySelector('div.ui-search-result__wrapper > div > div.ui-search-result__bookmark > form').action.split('/')[5]
    
                    // request data of product
                    const req = async() => {
                        const res = await RequestMLApi(`http://127.0.0.1:8000/api/v1/getDataProduct?idML=${idML}`);
                        console.log(res);
                        return res;
                    } 
    
                    req().then(async data => {
                        const { body: { sold_quantity, start_time,price, title, category_id,id,listing_type_id,health,seller_address,attributes,seller_id}
                    } = data[0] || null;
                    
                    // VALORES MARCA , EAN, EMPRESA E MEDALHA.
                    const {value_name} = attributes[1]; // MARCA
                    const BRAND = (value_name == null ? "SEM MARCA" : value_name);
      
                    // const {value_name:GTIN} = attributes??[5]; // GTIN
                    // console.log("GTIN : " + GTIN);
                    // const EAN = (GTIN == null) ? "N/A" : GTIN;
                    const EAN = attributes[5] ? attributes[5].value_name : 'N/D'; // GTIN
                    console.log(`QUANTIDADE VENDIDA : ${sold_quantity}, ID : ${idML}`);
                    const VALOR_NAME = (value_name == null ? "N/A" : value_name);              

                    const {nickname:empresa, power_seller_status} = await RequestMLApi(`http://127.0.0.1:8000/api/v1/getSellerId?sellerId=${seller_id}`);
                    // VALORES MARCA , EAN, EMPRESA E MEDALHA.    
        

                    // city.name CIDADE DO SELLER
                    // state.name CIDADE DO SELLER
                    const {city,state} = seller_address;
                
                     // REQUEST GET PRICE 

                     const req = async() => {
                        const { sale_fee_amount } =
                        (await RequestMLApi(`https://api.mercadolibre.com/sites/MLB/listing_prices?price=${price}&listing_type_id=${listing_type_id}&category_id=${category_id}`) || {});
                        HideContent.style.display = 'none';
                        return sale_fee_amount;
                    }

                    // valor da tarifa requisiçao com valor data
                    req().then(data => {
                    const priceTarifa = data;
                    const startTime = new Date(start_time);
                    startTime.setDate(startTime.getDate());
                    const dataPeriodo = startTime.toLocaleDateString();
                    //console.log('DATA PERIODO' + dataPeriodo);

                    const today = new Date();
                    today.setDate(today.getDate() - 60);
                    const dataAtual = today.toLocaleDateString();
                    
                    const hoje = new Date();
                    const oneDay = 24 * 60 * 60 * 1000; // h m s m
                    const diffDays = Math.round(Math.abs(startTime - hoje) / oneDay);
                    const saude = health * 100;
                    /**
                     *  LAYOUT COM OS DADOS BASEADO NAS MÉTRICAS
                     *  LAYOUTS MAIOR 400PX e MENOR 400PX
                     */
                        /**
                         *  LAYOUT | DEV TESTE
                         * 
                         */

                          // DATA DO MES PASSADO DO ANUNCIO 
                          const mesPassado = new Date(hoje);
                          mesPassado.setDate(mesPassado.getDate() - 30);
                          const dateMouthpast = mesPassado.toISOString().split('T')[0];
                          //console.log("MES PASSADO: " + dateMouthpast);

                         // DATA DO ANUNCIO 
                         const mesAtual = new Date(hoje);
                         mesAtual.setDate(mesAtual.getDate());
                         const dateMouthNow = mesAtual.toISOString().split('T')[0];
                        
                        /**
                         *  METRICAS DE PROVA SOCIAL 
                         */

                        const ReqMetrics = async() => {
                            const responseMetrics = await RequestMLApi(`http://127.0.0.1:8000/api/v1/getItem?idML=${idML}`);
                            return responseMetrics; 
                        }

                 
                        ReqMetrics().then(async data => {

                            const {rating_average,rating_levels:{one_star,two_star,three_star,four_star,five_star},reviews} = data || null;
                        
                        if(today < startTime){
                            // media da quantidade vendida nos ultimos 60 dias
                            const SoldAvg = Math.round(sold_quantity / 60);
                            //console.log("CAMPEAO" + SoldAvg + "  _ "  + idML);
                            
                            /**
                             * SELOS DE PRODUTO CAMPEAO
                             */
                            
                                    // LOADING DOS PRODUTOS
                                    h2ofTitleNameofProduct[indice].insertAdjacentHTML('afterend',
                                    `
                                    <div class='mlprice-Container' id='mlLoading${indice}'>
                                        <img src="https://s3-sa-east-1.amazonaws.com/cdn.siteblindado.com/images/loading.gif" class="loadingPicture">
                                    </div>
                                    `);
                                    
                                    const HideContent = document.getElementById(`mlLoading${indice}`);
                                    HideContent.style.display = 'none';

                                    if(SoldAvg >= 3){
                                        if(clientWidth < 400){                           
                                            h2ofTitleNameofProduct[indice].insertAdjacentHTML('afterend',
                                            `<div class='content-campeao'>
                                                <div class="card mb-3">
                                                <div class="row g-0">
                                                    <div class="col-md-4">
                                                    <img src="https://icon-library.com/images/mining-icon/mining-icon-15.jpg" class="img-fluid rounded-start imagem-minerado" alt="...">
                                                    </div>
                                                    <div class="col-md-12">
                                                    <div class="card-body">
                                                        <h5 class="card-title">Produto Selo Campeão</h5>
                                                        <p class="card-text">Criado à ${formatDate(startTime)} - ${diffDays} Dias</p>
                                                        <p class="card-text">Quantidade de Vendas: ${sold_quantity} Und. / Visitas </p>
                                                        <p class="card-text">Anúncio: ${power_seller_status} / Saúde ${saude}%</p>
                                                        <p class="card-text">Qualidade: xx  - Tarifa: ${priceTarifa} R$</p>
                                                        <p class="card-text>Marca: ${BRAND}, GTIN: ${EAN}</p>
                                                        <p class="card-text>Vendedor: ${empresa}, Tipo: ${power_seller_status}</p>
                                                    </div>
                                                    </div>
                                                </div>
                                                </div>
                                                <div class='seloCampeao'></div>
                                            </div>
                                            `);
                                        
                                        }else{
                                            h2ofTitleNameofProduct[indice].insertAdjacentHTML('afterend',
                                            `<div class='seloCampeao'></div>
                                            <div class='content-campeao'>
                                                <div class="card mb-3 float-start">
                                                <div class="row g-0">
                                                    <div class="col-md-4">
                                                    <img src="https://icon-library.com/images/mining-icon/mining-icon-15.jpg" class="img-fluid rounded-start imagem-minerado" alt="...">
                                                    </div>
                                                    <div class="col-md-12">
                                                    <div class="card-body">
                                                    <h5 class="card-title">Produto Minerado</h5>
                                                    <p class="card-text">Criado à ${formatDate(startTime)} - ${diffDays} Dias</p>
                                                    <p class="card-text">Quantidade de Vendas: ${sold_quantity} Und. / Visitas </p>
                                                    <p class="card-text">Anúncio: ${power_seller_status} / Saúde ${saude}%</p>
                                                    <p class="card-text">Qualidade: xx  - Tarifa: ${priceTarifa} R$</p>
                                                    <p class="card-text>Marca: ${BRAND}, GTIN: ${EAN}</p>
                                                    <p class="card-text>Vendedor: ${empresa}, Tipo: ${power_seller_status}</p>
                                                    <div id="Reviews${indice}"></div>
                                                        <table class="table table-dark">
                                                        <tr>
                                                            <th colspan="3" class="mediaStar">Média: ${rating_average} <th>
                                                        </tr>
                                                            <tr>
                                                            <th scope="col">Estrelas</th>
                                                            <th scope="col">Quantidade Avaliações</th>
                                                            </tr>
                                                                <tr class="rateMargin">
                                                                    <td>1 Estrela</td>
                                                                    <td>${one_star}</td>
                                                                </tr>
                                                                <tr class="rateMargin">
                                                                    <td>2 Estrelas</td>
                                                                    <td>${two_star}</td>
                                                                </tr>
                                                                <tr class="rateMargin">
                                                                    <td>3 Estrelas</td>
                                                                    <td>${three_star}</td>
                                                                </tr>
                                                                <tr class="rateMargin">
                                                                    <td>4 Estrelas</td>
                                                                    <td>${four_star}</td>
                                                                </tr>
                                                                <tr class="rateMargin">
                                                                    <td>5 Estrelas</td>
                                                                    <td>${five_star}</td>
                                                                </tr>  
                                                            </table>

                                                            <div id="BotaoVerMais${indice}"><img src="https://cdn-icons-png.flaticon.com/24/1057/1057061.png".</div>
                                                            <div class="hide" id="conteudoAwait${indice}"><h4>Comentários: </h4></div>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                        `);
                                    } // END IF DO TAMANHO < 400px 
                                    }else{
                                        h2ofTitleNameofProduct[indice].insertAdjacentHTML('afterend',
                                        `<div class='content-normal400width'>
                                            <div class="card mb-3">
                                            <div class="row g-0">
                                                <div class="col-md-4">
                                                <img src="https://cdn-icons-png.flaticon.com/512/3145/3145827.png" class="img-fluid rounded-start imagem-minerado" alt="...">
                                                </div>
                                                <div class="col-md-12">
                                                <div class="card-body">
                                                <h5 class="card-title">Veja Mais Sobre o Produto</h5>
                                                <p class="card-text">Criado à ${formatDate(startTime)} - ${diffDays} Dias</p>
                                                <p class="card-text">Quantidade de Vendas: ${sold_quantity} Und. / Visitas </p>
                                                <p class="card-text">Anúncio: ${power_seller_status} / Saúde ${saude}%</p>
                                                <p class="card-text">Qualidade: xx  - Tarifa: ${priceTarifa} R$</p>
                                                <p class="card-text>Marca: ${BRAND}, GTIN: ${EAN}</p>
                                                <p class="card-text>Vendedor: ${empresa}, Tipo: ${power_seller_status}</p>
                                                <div id="Reviews${indice}"></div>
                                                <table class="table table-dark">
                                                <tr>
                                                    <th colspan="3" class="mediaStar">Média: ${rating_average} <th>
                                                </tr>
                                                    <tr>
                                                    <th scope="col">Estrelas</th>
                                                    <th scope="col">Quantidade Avaliações</th>
                                                    <tr class="rateMargin">
                                                    <td>1 Estrela</td>
                                                    <td>${one_star}</td>
                                                    </tr>
                                                    <tr class="rateMargin">
                                                        <td>2 Estrelas</td>
                                                        <td>${two_star}</td>
                                                    </tr>
                                                    <tr class="rateMargin">
                                                        <td>3 Estrelas</td>
                                                        <td>${three_star}</td>
                                                    </tr>
                                                    <tr class="rateMargin">
                                                        <td>4 Estrelas</td>
                                                        <td>${four_star}</td>
                                                    </tr>
                                                    <tr class="rateMargin">
                                                        <td>5 Estrelas</td>
                                                        <td>${five_star}</td>
                                                    </tr> 
                                                    </table>

                                                    <div id="BotaoVerMais${indice}"><img src="https://cdn-icons-png.flaticon.com/24/1057/1057061.png".</div>
                                                    <div class="hide" id="conteudoAwait${indice}"><h4>Comentários: </h4></div>
                                                </div>
                                               
                                                </div>
                                                </div>
                                            </div>
                                            </div>

                                            <div class='selonormal'></div>
                                        </div>
                                        `);
                                    }                       
                              }else{
                              
                                // // função que extrai a porcentagem dos dois periodos
                                // const valuePorcem = calculatePorcentagemVisits(total1,total2);
                                        
                                        /**
                                         *  CARD DE PRODUTO EM DECLINIO COM TAMANHO MAIOR DE 400PX*
                                         */

                                               // LOADING DOS PRODUTOS
                                    h2ofTitleNameofProduct[indice].insertAdjacentHTML('afterend',
                                    `
                                    <div class='mlprice-Container' id='mlLoading${indice}'>
                                        <img src="https://s3-sa-east-1.amazonaws.com/cdn.siteblindado.com/images/loading.gif" class="loadingPicture">
                                    </div>
                                    `);
                                    
                                    const HideContent = document.getElementById(`mlLoading${indice}`);
                                    HideContent.style.display = 'none';
                                      
                                         h2ofTitleNameofProduct[indice].insertAdjacentHTML('afterend',
                                         `<div class='content-normal400width'>
                                             <div class="card mb-3">
                                             <div class="row g-0">
                                                 <div class="col-md-4">
                                                 <img src="https://cdn-icons-png.flaticon.com/512/3145/3145827.png" class="img-fluid rounded-start imagem-minerado" alt="...">
                                                 </div>
                                                 <div class="col-md-8">
                                                    <div class="card-body">
                                                    <h5 class="card-title">Veja Mais Sobre o Produto</h5>
                                                        <p class="card-text">Criado à ${formatDate(startTime)} - ${diffDays} Dias</p>
                                                        <p class="card-text">Quantidade de Vendas: ${sold_quantity} Und. / Visitas </p>
                                                        <p class="card-text">Anúncio: ${power_seller_status} / Saúde ${saude}%</p>
                                                        <p class="card-text">Qualidade: xx  - Tarifa: ${priceTarifa} R$</p>
                                                        <p class="card-text">Marca: ${BRAND}, GTIN: ${EAN}</p>
                                                        <p class="card-text">Vendedor: ${empresa}, Tipo: </p>
                                                        <div class='mlprice-Container' id="avaliacoes">
                                                        <div id="Reviews${isset(indice)?indice:0}"></div>
                                                        <table class="table table-dark">
                                                        <tr>
                                                            <th colspan="3" class="mediaStar">Média: ${rating_average} <th>
                                                        </tr>
                                                            <tr>
                                                            <th scope="col">Estrelas</th>
                                                            <th scope="col">Quantidade Avaliações</th>
                                                            </tr>
                                                            <tr class="rateMargin">
                                                            <td>1 Estrela</td>
                                                            <td>${one_star}</td>
                                                            </tr>
                                                            <tr class="rateMargin">
                                                                <td>2 Estrelas</td>
                                                                <td>${two_star}</td>
                                                            </tr>
                                                            <tr class="rateMargin">
                                                                <td>3 Estrelas</td>
                                                                <td>${three_star}</td>
                                                            </tr>
                                                            <tr class="rateMargin">
                                                                <td>4 Estrelas</td>
                                                                <td>${four_star}</td>
                                                            </tr>
                                                            <tr class="rateMargin">
                                                                <td>5 Estrelas</td>
                                                                <td>${five_star}</td>
                                                            </tr> 
                                                            </table>

                                                            <div id="BotaoVerMais${indice}"><img src="https://cdn-icons-png.flaticon.com/24/1057/1057061.png".</div>
                                                            <div class="hide" id="conteudoAwait${indice}"><h4>Comentários: </h4></div>
                                                        </div>
                                                    </div>
                                                 </div>
                                             </div>
                                             </div>
                                             <div class='selonormal'></div>
                                         </div>
                                         `);

                                         const test = document.getElementById(`BotaoVerMais${indice}`);
                                         const conteudoReview = document.getElementById(`conteudoAwait${indice}`);
                                         test.addEventListener("mouseenter", (event) => {
                                            // highlight the mouseleave target
                                            event.target.style.color = "black";
                                            
                                            conteudoReview.style.display = 'block';
                                            
                                          });

                                          test.addEventListener("mouseout", (event) => {
                                            // highlight the mouseleave target
                                            event.target.style.color = "black";
                                            
                                            conteudoReview.style.display = 'none';
                                            
                                          });
                                         
                                        } //
                                
                                    reviews.forEach(element => 
                                        //buying_date, rate, relevance
                                        document.getElementById(`conteudoAwait${indice}`).innerHTML += 
                                        `
                                        <ul>
                                            <li class="dataCompraLI">Data da Compra: ${formatDateReviews(new Date(element.buying_date))}</li>
                                            <li class="conteudoComentario">Comentário: <hr>${element.content}</li>
                                            <li class="relevanciaReviews">Relevância:  ${element.relevance} %</li>
                                        <ul>
                                        `
                                    );
                            });
                        });
                    });
                    }

                }              
            
    },2000);

    /**
     *  LOGIN CONTINUACAO
     */
    }
    
} catch (error) {
    console.log(error);
}

function criaSessionSenha(token){

    if(token){
       // cria o LS
       sessionStorage.setItem("token_access", token);
    }else if(!token){
      // $(".gotit").show();
    }

 }

const formSubmit = document.getElementById('form-login'); // ID DO LOGIN
const emailField = document.querySelector("#email");

if(formSubmit){
    formSubmit.addEventListener('submit', submitForm); // PEGA O SUBMIT DO LOGIN
}


async function submitForm(event){
    event.preventDefault();
    const responseLogin = await RequestLogin(`https://www.mercadolivrehub.embaleme.com.br/api/v1/auth/login?email=${emailField.value}`);
    const {code} = responseLogin;
    const errorMsgLogin = document.querySelector('#form-login');
    const removeMsgLogin = document.querySelector('#root-app > div > div.ui-search-main.ui-search-main--exhibitor.ui-search-main--with-topkeywords > aside > div.ui-search-breadcrumb > h1 > p.msg-doLogin');
    const removeMsgLoginSuccess = document.querySelector('#root-app > div > div.ui-search-main.ui-search-main--exhibitor.ui-search-main--with-topkeywords > aside > div.ui-search-breadcrumb > h1 > p.msg-succesLogin');
    if(code == '200'){
        // mensagem de sucesso
        errorMsgLogin.insertAdjacentHTML('beforebegin','<p class="msg-succesLogin">Logado com Sucesso! Aguarde..</p>');
        setTimeout(() => {
            const {token} = responseLogin;
            criaSessionSenha(token);
            
            //window.location.reload();       
          }, 2000);
        
    }else if(code == '401'){
        errorMsgLogin.insertAdjacentHTML('beforebegin','<p class="msg-errorLogin">Error!, Verique o Email ou Senha.</p>');
    }
    event.preventDefault();
}
},2000);
    
        // PAGINA DE PRODUTO FIM
    }

    function formatDateReviews(date) {
        const day = date.getDate().toString().padStart(2, '0'),
            month = (date.getMonth() + 1).toString().padStart(2, '0'),
            year = date.getFullYear();

        return `${day}/${month}/${year}`;
    }


    function HideAvaliacoes(element){
        document.getElementById('target').style.display = 'none';
    }

    function montaUrl(url) {
        const urlName = [];
        url.forEach(function(nome,i) {
            if(i <= 4){
                const fullUrl = urlName.concat(nome);
            }
        });

        return fullUrl;
    }

   async function getAftervisitMounth(url){

    // CONTROLADOR DE ABORTO
    const controller = new AbortController();
    // TEMPO DE 2 SEGUNDOS
    const timeoutId = setTimeout(() => controller.abort(), 1000)

        // REQUISIÇÂO PARA PEGAR DADOS DE VISITA PRAZO MAXIMO 7 DIAS
        try {
            const config = {
                method: 'GET',
                headers: {
                    Accept: 'aplication/json',
                    'Access-Control-Allow-Origin':'*',
                    'Access-Control-Allow-Methods': 'DELETE, POST, GET, OPTIONS',
                    'Access-Control-Allow-Headers': 'Content-Type, Authorization, X-Requested-With'
                },
            }

           const res =  await fetch(url, config, 1000) // throw after max 5 seconds timeout error
            .then((result) => {
                return result.json();
            })
            .catch((e) => {
                 console.log(e);
            })     

            return res;

        } catch (error) {
            console.log(error)
        }
    }

     function tipoanuncio(tipo){
        if(tipo == 'gold_pro'){
            return 'Premium';
        }else{
            return 'Clássico';
        }
    }

    function mouseOver(indice) {
        document.getElementById(`conteudoAwait${indice}`).style.display = 'nome';
    }

    function mouseOut(indice) {
        document.getElementById(`conteudoAwait${indice}`).style.display = 'block';
    }

    function calculatePorcentagemVisits(valuea,valueb) {
        if(valuea == '0' || valuea == undefined){
            var total = parseInt(valueb);
        }else if(valueb == '0' || valuea == undefined){
            var total = parseInt(valuea);
        }else{
            var total = (parseInt(valuea) - parseInt(valueb)) / parseInt(valuea) * 100;
        }
        return (isNaN(total) ? 1 : total);
    }

    async function RequestMLApiLoading(url){
        requestFetch = async function(){
            // BEFORE SEND

            const response = await fetch(url);
            const res = await response.json();
            return res;
        }
    }

    async function RequestMLApi(url) {
        try {
            const config = {
                method: 'GET',
                headers: {
                    Accept: 'aplication/json',
                    'Access-Control-Allow-Origin':'*',
                    'Access-Control-Allow-Methods': 'DELETE, POST, GET, OPTIONS',
                    'Access-Control-Allow-Headers': 'Content-Type, Authorization, X-Requested-With',
                    'Retry-After': 3600
                },
            }

            const response = await fetch(url);
            const res = await response.json();
            return res;

        } catch (error) {
            console.log(error)
        }
    }

    async function RequestHttp(url,token) {
        console.log(" URL DA REQUISICAO" + url);
        try {
            const config = {
                method: 'POST',
                headers: {
                    'Content-Type': 'aplication/json',
                    'Accept': 'aplication/json',
                    'Access-Control-Allow-Origin':'*',
                    'Access-Control-Allow-Methods': 'DELETE, POST, GET, OPTIONS',
                    'Authorization': 'Bearer '+ token,
                    'Access-Control-Allow-Headers': 'Content-Type, Authorization, X-Requested-With',
                    'Retry-After': 2000,
                },
                body: JSON.stringify({
                    'token': token,    
                }),
            }

            const response = await fetch(url, config);
            const res = await response.json();
            return res;

        } catch (error) {
           return response.status
        }
    }

    async function RequestLogin(url,email) {
        try {
            const config = {
                method: 'POST',
                headers: {
                    Accept: 'aplication/json',
                    'Content-Type': 'aplication/json',
                    'Access-Control-Allow-Origin':'*',
                    'Access-Control-Allow-Methods': 'POST',
                },
                body: JSON.stringify({
                    'email': email, 
                }),
            }

            const response = await fetch(url, config);
            const res = await response.json();
            console.log(res);
            return res;

        } catch (error) {
            console.log(error)
        }
    }

    pageProducts();
    init();

}
