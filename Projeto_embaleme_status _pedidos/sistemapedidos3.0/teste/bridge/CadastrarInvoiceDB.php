<?php

include "statusController.php";

class SaveInvoice
{

    private String $invoice;
    private String $type;
    private String $weight;
    private DateTimeInterface $data;
    private float $weightDevolution;
    private PDO $conexao;
    private int $colaborador;
    private int $id_mktplace;
    private string $observacao;
    private string $id_pedido;
    private string $peso_loja;
    private string $divergencia_peso;
    private string $restricao;
    private string $pendencia;


    public function __construct($invoice, $type, $weight, DateTimeInterface $data, $weightDevolution, PDO $conexao, $colaborador, $id_mktplace, $observacao, $id_pedido, $peso_loja, $divergencia_peso, $restricao, $pendencia)
    {
        $this->invoice = $invoice;
        $this->type = $type;
        $this->weight = $weight;
        $this->data = $data;
        $this->weightDevolution = $weightDevolution;
        $this->conexao = $conexao;
        $this->colaborador = $colaborador;
        $this->id_mktplace = $id_mktplace;
        $this->observacao = $observacao;
        $this->id_pedido = $id_pedido;
        $this->peso_loja = $peso_loja;
        $this->divergencia_peso = $divergencia_peso;
        $this->restricao = $restricao;
        $this->pendencia = $pendencia;
    }


    public function message($number)
    {

        switch ($number) {
            case 1:
                echo "Nota Fiscal Cadastrado com Sucesso";
                break;
            case 2:
                echo "Nota Fiscal Já Cadastrado";
                break;
            default:
                echo "Dado Não Encontrado";
                break;
        }
    }

    public function VerificaInvoice()
    {
        $statement = $this->getConexao()->prepare("SELECT Tipo from codigo WHERE cod = :invoice and Tipo = :tipo");
        $statement->bindParam(':invoice', $this->invoice, PDO::PARAM_STR);
        $statement->bindParam(':tipo', $this->type, PDO::PARAM_STR);
        $statement->execute();
        $response = $statement->fetchAll();

        if (count($response) > 0) {
            return ["code" => 2];
        }

        return ["code" => 1];
    }

    public function SaveInvoicedb($type)
    {
        try {

            if (isset($type)) {

                $this->getConexao()->beginTransaction();

                $sql = "INSERT INTO codigo (cod,colaborador,datas,Tipo,id_mktplace,observacao,id_pedido,peso,peso_loja,divergencia_peso,restricao,pendencia)";
                $sql_values = " VALUES (:cod, :colaborador, :datas, :Tipo, :id_mktplace, :observacao, :id_pedido, :peso, :peso_loja, :divergencia_peso, :restricao,:pendencia   )";

                $statement = $this->getConexao()->prepare($sql .= $sql_values);
                $statement->bindValue('cod', (string) $this->invoice, PDO::PARAM_STR);
                $statement->bindValue('colaborador', (int) $this->colaborador, PDO::PARAM_INT);
                $statement->bindValue('datas', (string) $this->data->format('Y-m-d H:i:s'), PDO::PARAM_STR);
                $statement->bindValue('Tipo', (string) $type, PDO::PARAM_STR);
                $statement->bindValue('id_mktplace', $this->id_mktplace, PDO::PARAM_STR);
                $statement->bindValue('observacao', $this->observacao, PDO::PARAM_STR);
                $statement->bindValue('id_pedido', $this->id_pedido, PDO::PARAM_STR);
                $statement->bindValue('peso', (float) $this->weight, PDO::PARAM_STR);
                $statement->bindValue('peso_loja', $this->peso_loja, PDO::PARAM_STR);
                $statement->bindValue('divergencia_peso', (string) $this->divergencia_peso, PDO::PARAM_STR);
                // IMPLEMENTAR PESO DA DEVOLUCAO
                //$statement->bindValue('divergencia_peso', (string) $this->divergencia_peso, PDO::PARAM_STR);
                $statement->bindValue('restricao', (float) $this->restricao, PDO::PARAM_STR);
                $statement->bindValue('pendencia', (float) $this->pendencia, PDO::PARAM_STR);
                $statement->execute();
                $this->getConexao()->commit();
            }
        } catch (\Exception $th) {
            $this->getConexao()->rollBack();
        }
    }

    public function rules()
    {
        /**
         * REGRAS SÂO
         *
         * @if TYPE == NF* > NEXT > S
         * @if TYPE == S > NEXT > V
         * @if TYPE == V > NEXT > F
         * @if TYPE == F > NEXT > ML , SH , C
         * @if TYPE == ML , SH, C > NEXT > D (Devolucão)
         */
        $status = new Status($this->getStatus(), $this->getInvoice(), $this->getType());
        $status_code = $status->verifyStatus();

        if ($status_code == 1) {
            switch ($this->VerificaInvoice()['code']) {
                case '1':

                    if (is_array($status->varrerStatus($this->getType()))) {
                        // USA O VALOR DO TYPE
                        $this->message($this->VerificaInvoice()['code']);
                        $this->SaveInvoicedb($this->getType());
                    } else {
                        $this->message($this->VerificaInvoice()['code']);
                        $this->SaveInvoicedb($status->varrerStatus($this->getType()));
                    }
                    break;

                case '2':
                    $this->message($this->VerificaInvoice()['code']);
                    break;
            }
        }
    }

    public function getStatus()
    {
        try {
            $statement = $this->getConexao()->prepare("SELECT Tipo from codigo WHERE cod = :invoice");
            $statement->bindParam(':invoice', $this->invoice, PDO::PARAM_STR);
            $statement->execute();
            $response = $statement->fetchAll();
            return $response;
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
    /**
     * Get the value of invoice
     */
    public function getInvoice(): String
    {
        return $this->invoice;
    }

    /**
     * Set the value of invoice
     */
    public function setInvoice(String $invoice): self
    {
        $this->invoice = $invoice;

        return $this;
    }

    /**
     * Get the value of type
     */
    public function getType(): String
    {
        return $this->type;
    }

    /**
     * Set the value of type
     */
    public function setType(String $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get the value of weight
     */
    public function getWeight(): String
    {
        return $this->weight;
    }

    /**
     * Set the value of weight
     */
    public function setWeight(String $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get the value of data
     */
    public function getData(): DateTimeInterface
    {
        return $this->data;
    }

    /**
     * Set the value of data
     */
    public function setData(DateTimeInterface $data): self
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get the value of weightDevolution
     */
    public function getWeightDevolution(): float
    {
        return $this->weightDevolution;
    }

    /**
     * Set the value of weightDevolution
     */
    public function setWeightDevolution(float $weightDevolution): self
    {
        $this->weightDevolution = $weightDevolution;

        return $this;
    }

    /**
     * Get the value of conexao
     */
    public function getConexao(): PDO
    {
        return $this->conexao;
    }
}
