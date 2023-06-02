<?php
include_once 'AppEmbalemeAuth.php';
// ---------- SESSÂO ABERTA --------------//

// PUT ATUALIZA PRODUTOS TRAY 
// create by GUILHERME TAIRA  --> 20/12/2021 as 16:31

// METHOD GET

// URLBASE PARA AUTENTICAR
define("URL_BASE_PUT_ATUALIZA_PRODUTOS_TRAY", "https://www.embaleme.com.br/web_api");

class AtualizaPromocaoTray
{
    private $access_token;
    private $id;
    private $preco;
    private $stock;
    private $precoPromocional;
    private $DataInicialPromocao;
    private $DataFinalPromocao;
    private $ativo;
    private $qtdbaixa;

    function __construct($access_token, $id, $precoPromocional, $preco, $stock, $DataInicialPromocao, $DataFinalPromocao, $ativo, $qtdbaixa)
    {
        $this->access_token = $access_token;
        $this->id = $id;
        $this->preco = $preco;
        $this->stock = $stock;
        $this->precoPromocional = $precoPromocional;
        $this->DataInicialPromocao = $DataInicialPromocao;
        $this->DataFinalPromocao = $DataFinalPromocao;
        $this->ativo = $ativo;
        $this->qtdbaixa = $qtdbaixa;
    }

    function resource()
    {
        return $this->get("products/{$this->getId()}?access_token=" . $this->getAccess_token());
    }

    function get($resource)
    {
        // ENDPOINT PARA REQUISICAO
        $endpoint = URL_BASE_PUT_ATUALIZA_PRODUTOS_TRAY . $resource;

        // dados Array
        $data = array(
            "Product" => array(
                "price" => $this->getPreco(),
                "stock" => $this->getStock(),
                "promotional_price" => $this->getPrecoPromocional(),
                "start_promotion" => $this->getDataInicialPromocao(),
                "end_promotion" => $this->getDataFinalPromocao(),
                "available" => $this->getAtivo(),
            ),
        );

        // data convertido em json
        $data_json = json_encode($data);

        $today = new DateTime();
        // CRIANDO ARQUIVO LOG COM NOME DATA DE HOJE
        $arquivo =  $today->format('Y-m-d') . '.txt';
        $fp = fopen($arquivo, "a+");
        fwrite($fp, "LOG: " . $today->format('Y-m-d H:i:s') . '=>' . $data_json . "\r\n\n");
        fclose($fp);

        // echo "<pre>";
        // print_r($data_json);

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $endpoint,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $data_json,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => ['Content-Type:application/json'],
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $decode = json_decode($response, false);

        // if ($httpCode == "200") {
        //     $_SESSION["msg_success"] = "<div class='alert alert-success'> Produto Atualizado com Sucesso! </div>";
        //     header(sprintf('location: %s', $_SERVER['HTTP_REFERER']));
        // } else if ($httpCode == "400") {
        //     $_SESSION["msg_error"] = "<div class='alert alert-danger'> Erro ao Cadastraro  Produto Verifique! </div>";
        //     header(sprintf('location: %s', $_SERVER['HTTP_REFERER']));
        // }

        return $decode;
    }


    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of precoPromocional
     */
    public function getPrecoPromocional()
    {
        return $this->precoPromocional;
    }

    /**
     * Set the value of precoPromocional
     *
     * @return  self
     */
    public function setPrecoPromocional($precoPromocional)
    {
        $this->precoPromocional = $precoPromocional;

        return $this;
    }

    /**
     * Get the value of DataInicialPromocao
     */
    public function getDataInicialPromocao()
    {
        return $this->DataInicialPromocao;
    }

    /**
     * Set the value of DataInicialPromocao
     *
     * @return  self
     */
    public function setDataInicialPromocao($DataInicialPromocao)
    {
        $this->DataInicialPromocao = $DataInicialPromocao;

        return $this;
    }



    /**
     * Get the value of DataFinalPromocao
     */
    public function getDataFinalPromocao()
    {
        return $this->DataFinalPromocao;
    }

    /**
     * Set the value of DataFinalPromocao
     *
     * @return  self
     */
    public function setDataFinalPromocao($DataFinalPromocao)
    {
        $this->DataFinalPromocao = $DataFinalPromocao;

        return $this;
    }

    /**
     * Get the value of access_token
     */
    public function getAccess_token()
    {
        return $this->access_token;
    }

    /**
     * Set the value of access_token
     *
     * @return  self
     */
    public function setAccess_token($access_token)
    {
        $this->access_token = $access_token;

        return $this;
    }


    /**
     * Get the value of preco
     */
    public function getPreco()
    {
        return $this->preco;
    }

    /**
     * Set the value of preco
     *
     * @return  self
     */
    public function setPreco($preco)
    {
        $this->preco = $preco;

        return $this;
    }

    /**
     * Get the value of stock
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * Set the value of stock
     *
     * @return  self
     */
    public function setStock($stock)
    {
        $this->stock = $stock;

        return $this;
    }


    /**
     * Get the value of ativo
     */
    public function getAtivo()
    {
        return $this->ativo;
    }

    /**
     * Set the value of ativo
     *
     * @return  self
     */
    public function setAtivo($ativo)
    {
        $this->ativo = $ativo;

        return $this;
    }

    /**
     * Get the value of qtdbaixa
     */
    public function getQtdbaixa()
    {
        return $this->qtdbaixa;
    }

    /**
     * Set the value of qtdbaixa
     *
     * @return  self
     */
    public function setQtdbaixa($qtdbaixa)
    {
        $this->qtdbaixa = $qtdbaixa;

        return $this;
    }
}



abstract class ProdutoFactory
{
    public abstract function VerificaPromocao($id, $Valor_promocao, $preco, $stock, \DateTimeInterface $DataInicialPromocao, \DateTimeInterface $DataFinalPromocao, $ativo, $qtdbaixa, $precosite);
    public abstract function Dividesaldo($saldo, $qtdbaixa);
    public abstract function VerificaPrecoDiferenteLojaFiscia($precoLoja, $precoSite): float;
    public abstract function VerificaAtivo($saldo);
    public abstract function VerificaPreco($Valor);
}

class PutProdutoEmbaleme extends ProdutoFactory
{
    public function VerificaPromocao($id, $Valor_promocao, $preco, $stock, \DateTimeInterface $DataInicialPromocao, \DateTimeInterface $DataFinalPromocao, $ativo, $qtdbaixa, $precosite)
    {

        $hoje = new \DateTime();
        if ($this->VerificaPreco($preco) == FALSE) {
            return false;
        } else if ($this->VerificaPreco($preco) == TRUE) {

            if ($DataFinalPromocao->format('Y-m-d') >= $hoje->format('Y-m-d') && $precosite == 0) {
                $AtualizaPrecoEstoqueTray = new AtualizaPromocaoTray($_SESSION['access_token_tray'], $id, $this->VerificaPrecoDiferenteLojaFiscia($Valor_promocao, $precosite), $preco, $this->Dividesaldo($stock, $qtdbaixa), $DataInicialPromocao->format('Y-m-d'), $DataFinalPromocao->format('Y-m-d'), $ativo, $qtdbaixa);
                return $AtualizaPrecoEstoqueTray->resource();
            } else {
                $AtualizaPrecoEstoqueTray = new AtualizaPromocaoTray($_SESSION['access_token_tray'], $id, 0, $this->VerificaPrecoDiferenteLojaFiscia($preco, $precosite), $this->Dividesaldo($stock, $qtdbaixa), $DataInicialPromocao->format('Y-m-d'), $DataFinalPromocao->format('Y-m-d'), $ativo, $qtdbaixa);
                return $AtualizaPrecoEstoqueTray->resource();
            }
        }
    }

    public function Dividesaldo($saldo, $qtdbaixa)
    {
        if ($saldo <= 1) {
            $saldo = 0;
            return $saldo;
        } else {
            if ($qtdbaixa == 0) {
                $qtdbaixa = 1;
                return ($saldo / $qtdbaixa) / 2;
            } else {
                return ($saldo / $qtdbaixa) / 2;
            }
        }
    }

    public function VerificaPrecoDiferenteLojaFiscia($precoLoja, $precoSite): float
    {
        if (floatval($precoSite <= 0)) {
            return floatval($precoLoja);
        } else {
            return floatval($precoSite);
        }
    }

    public function VerificaAtivo($Ativo)
    {
        return $Ativo;
    }

    public function VerificaPreco($Valor)
    {
        if ($Valor <= 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
}


class UpdateTrayDadosProduto
{

    private $pdo2;

    public function __construct(\PDO $pdo2)
    {
        $this->pdo2 = $pdo2;
    }

    public function AtualizaProduto()
    {
        // INSTANCIA DO BANCO 
        $statement = $this->getPdo2()->query("SELECT * FROM TrayProdutos WHERE flag_estoque = 'X' OR flag_preco = 'X' LIMIT 100");
        $produtos = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($produtos as $produto) {

            echo "
            <div class='card'>
            <div class='card-body'>
             <div class='alert alert-success' role='alert'>Código Interno RET : <span class='badge bg-success'>{$produto['referencia']}</span>  Preço Site RET : <span class='badge bg-success'>{$produto['precosite']}</span>     Preço:  <span class='badge bg-info text-dark'>{$produto['preco']} R$</span>    Estoque :  <span class='badge bg-warning text-dark'>{$produto['stock']} Unidades</span> Atualizado com Sucesso!</div>
            </div>
            </div>
            ";

            $DataInicialPromocao = DateTime::createFromFormat('Y-m-d', $produto['dataInicial']);
            $DataFinalPromocao = DateTime::createFromFormat('Y-m-d', $produto['dataFinal']);
            $dataInicial = $DataInicialPromocao->format('Y-m-d');
            $dataFinal = $DataFinalPromocao->format('Y-m-d');
            $FactoryProduto = new PutProdutoEmbaleme();
            print_r($FactoryProduto->VerificaPromocao($produto['id_produto'], floatval($produto['PrecoPromocional']), floatval($produto['preco']), $produto['stock'], $DataInicialPromocao, $DataFinalPromocao, intval($produto['Ativo']), $produto['QTDBAIXARET'], $produto['precosite']));
            $statement2 = $this->getPdo2()->query("UPDATE TrayProdutos SET flag_estoque = '', flag_preco = '' WHERE referencia = '{$produto['referencia']}'");
            $statement2->execute();
        }
    }

    /**
     * Get the value of pdo2
     */
    public function getPdo2()
    {
        return $this->pdo2;
    }

    /**
     * Set the value of pdo2
     *
     * @return  self
     */
    public function setPdo2($pdo2)
    {
        $this->pdo2 = $pdo2;

        return $this;
    }
}
