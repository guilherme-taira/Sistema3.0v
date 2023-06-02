<?php
session_start();
include_once 'teste/conexao_pdo.php';

interface PendenciaCreate{
    public function cadastraPendencia(\PDO $pdo);
}

class Pendencia implements PendenciaCreate{
    
    private $chavenf;
    private $funcionario;
    private $data;
    private $tipo;
    private $market;
    private $observacao;
    private $n_pedido;
    private $peso;
    private $peso_loja;
    private $divergencia_peso;
    private $json;

    public function __construct($chavenf, $funcionario, $data, $tipo, $market,$observacao,$n_pedido,$peso = 0,$peso_loja,$divergencia_peso,$json)
    {
        $this->chavenf = $chavenf;
        $this->funcionario = $funcionario;
        $this->data = $data;
        $this->tipo = $tipo;
        $this->market = $market;
        $this->observacao = $observacao;
        $this->n_pedido = $n_pedido;
        $this->peso = $peso;
        $this->peso_loja = $peso_loja;
        $this->divergencia_peso = $divergencia_peso;
        $this->json = $json;
    }

    public function cadastraPendencia(\PDO $pdo){
        try {
            $pdo->beginTransaction();

            $sql = "INSERT INTO codigo (cod,colaborador,datas,Tipo, id_mktplace,observacao,id_pedido,peso,peso_loja,divergencia_peso,pendencia)
            VALUES (:chavenf,:colaborador,:data,:tipo,:market,:observacao,:n_pedido,:peso,:peso_loja,:divergencia_peso,:json)";

            $statement = $pdo->prepare($sql);
            $statement->bindValue(':chavenf', $this->chavenf, PDO::PARAM_STR);
            $statement->bindValue(':colaborador', $this->funcionario, PDO::PARAM_STR);
            $statement->bindValue(':data', $this->data, PDO::PARAM_STR);
            $statement->bindValue(':tipo', $this->tipo, PDO::PARAM_STR);
            $statement->bindValue(':market', $this->market, PDO::PARAM_STR);
            $statement->bindValue(':observacao', $this->observacao, PDO::PARAM_STR);
            $statement->bindValue(':n_pedido', $this->n_pedido, PDO::PARAM_STR);
            $statement->bindValue(':peso', $this->peso, PDO::PARAM_STR);
            $statement->bindValue(':peso_loja', $this->peso_loja, PDO::PARAM_STR);
            $statement->bindValue(':divergencia_peso', $this->divergencia_peso, PDO::PARAM_STR);
            $statement->bindValue(':json', $this->json, PDO::PARAM_STR);
            $statement->execute();
            $pdo->commit();
        } catch (\PDOException $e) {
            $pdo->rollBack();
            echo $e->getMessage();
            echo $e->getCode();
        }
    }

    /**
     * Get the value of chavenf
     */ 
    public function getChavenf()
    {
        return $this->chavenf;
    }

    /**
     * Set the value of chavenf
     *
     * @return  self
     */ 
    public function setChavenf($chavenf)
    {
        $this->chavenf = $chavenf;

        return $this;
    }

    /**
     * Get the value of funcionario
     */ 
    public function getFuncionario()
    {
        return $this->funcionario;
    }

    /**
     * Set the value of funcionario
     *
     * @return  self
     */ 
    public function setFuncionario($funcionario)
    {
        $this->funcionario = $funcionario;

        return $this;
    }

    /**
     * Get the value of data
     */ 
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set the value of data
     *
     * @return  self
     */ 
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get the value of tipo
     */ 
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set the value of tipo
     *
     * @return  self
     */ 
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get the value of observacao
     */ 
    public function getObservacao()
    {
        return $this->observacao;
    }

    /**
     * Set the value of observacao
     *
     * @return  self
     */ 
    public function setObservacao($observacao)
    {
        $this->observacao = $observacao;

        return $this;
    }

    /**
     * Get the value of n_pedido
     */ 
    public function getN_pedido()
    {
        return $this->n_pedido;
    }

    /**
     * Set the value of n_pedido
     *
     * @return  self
     */ 
    public function setN_pedido($n_pedido)
    {
        $this->n_pedido = $n_pedido;

        return $this;
    }

    /**
     * Get the value of peso
     */ 
    public function getPeso()
    {
        return $this->peso;
    }

    /**
     * Set the value of peso
     *
     * @return  self
     */ 
    public function setPeso($peso)
    {
        $this->peso = $peso;

        return $this;
    }

    /**
     * Get the value of peso_loja
     */ 
    public function getPeso_loja()
    {
        return $this->peso_loja;
    }

    /**
     * Set the value of peso_loja
     *
     * @return  self
     */ 
    public function setPeso_loja($peso_loja)
    {
        $this->peso_loja = $peso_loja;

        return $this;
    }

    /**
     * Get the value of divergencia_peso
     */ 
    public function getDivergencia_peso()
    {
        return $this->divergencia_peso;
    }

    /**
     * Set the value of divergencia_peso
     *
     * @return  self
     */ 
    public function setDivergencia_peso($divergencia_peso)
    {
        $this->divergencia_peso = $divergencia_peso;

        return $this;
    }

    /**
     * Get the value of json
     */ 
    public function getJson()
    {
        return $this->json;
    }

    /**
     * Set the value of json
     *
     * @return  self
     */ 
    public function setJson($json)
    {
        $this->json = $json;

        return $this;
    }

        /**
     * Get the value of market
     */ 
    public function getMarket()
    {
        return $this->market;
    }

    /**
     * Set the value of market
     *
     * @return  self
     */ 
    public function setMarket($market)
    {
        $this->market = $market;

        return $this;
    }
}

abstract class PendenciaFactory {
    public abstract function verificaPendencia($chavenf, $funcionario, $data, $tipo, $market,$observacao,$n_pedido,$peso,$peso_loja,$divergencia_peso,$json, $pdo);
}


class FactoryPendenciaNew extends PendenciaFactory
{
    public function verificaPendencia($chavenf, $funcionario, $data, $tipo, $market,$observacao,$n_pedido,$peso,$peso_loja,$divergencia_peso,$json, $pdo)
    {
        /**
         * VERIFICA SE JÁ EXISTE NO BANCO
         * **/

         $datahora = new DateTime();
        try {
            $statement = $pdo->query("SELECT * FROM codigo where cod = '$chavenf' and Tipo = 'P'");
            $dados = $statement->fetch();
    
            if (!empty($dados)) {
                $_SESSION['msg_error'] = "<div class='alert alert-danger text-center' id='mensagem_error' role='alert'><strong>Pendência Já Cadastrada, Verifique!</strong></div>";
                header(sprintf('location: %s', $_SERVER['HTTP_REFERER']));
            }else {
                $cadastrarpendencia = new Pendencia($chavenf, $funcionario, $data, $tipo, $market,$observacao,$n_pedido,$peso,$peso_loja,$divergencia_peso,$json);
                $cadastrarpendencia->cadastraPendencia($pdo);
                header('refresh:2;url=pendencia.php');
            }
        } catch (\PDOException $e) {
            echo $e->getCode();
            echo $e->getMessage();
        }
    }
}

$chavenf = $_SESSION['cod_nf'];
$funcionario = $_SESSION['colaborador'];
$data = $_SESSION['datahora'];
$tipo = 'P';
$market = $_SESSION['opcao'];
$observacao = "N/D";
$n_pedido = 0;
$peso = 0;
$peso_loja = 0;
$divergencia_peso = 0;
$json = $_SESSION['pendencia'];

// echo "<pre>";
// print_r($_SESSION);
$factory = new FactoryPendenciaNew();
$factory->verificaPendencia($chavenf,$funcionario,$data,$tipo,$market,$observacao,$n_pedido,$peso,$peso_loja,$divergencia_peso,$json,$pdo);


