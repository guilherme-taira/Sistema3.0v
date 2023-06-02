<?php

class Status
{

    private array $status;
    private String $invoice;
    private String $atualStatus;

    public function __construct(array $status, String $invoice, $atualStatus)
    {
        $this->status = $status;
        $this->invoice = $invoice;
        $this->atualStatus = $atualStatus;
    }

    public function countStatus()
    {
        try {
            return count($this->getStatus());
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function varrerStatus($type)
    {
        $array = [];
        foreach ($this->getStatus() as $tipo) {
            array_push($array, $tipo["Tipo"]);
        }
        return $this->NextStatus($type);
    }


    public function NextStatus()
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

        switch (count($this->getStatus())) {
            case 1:
                return "S";
                break;
            case 2:
                return "V";
                break;
            case 3:
                return "F";
                break;
            case 4:
                return ["C", "SH", "ML"];
                break;
            case 5:
                return "D";
                break;
        }
    }

    public function verifyStatus()
    {
        switch ($this->atualStatus) {
            case 'S':
                echo $this->showStatus("NF*");
                break;
            case 'V':
                if ($this->showStatus("V")["code"] == 0) {
                    return 1;
                } else {
                    echo "<pre>";
                    echo "<h2>Nota Fiscal Ainda Não pode Ser Voltada <hr> Status Já Cadastrado </h2>";
                    echo "<table border=1><th>Nota FIscal</th><th>Status</th>";
                    $i = 0;
                    foreach ($this->showStatus("V")["status"] as $key => $value) {
                        echo "<tr><td>{$value['cod']}</td><td>{$value['tipo']}</td></tr>";
                    }
                    echo "</table>";
                }
                break;
            case 'F':
                if ($this->showStatus("F")["code"] == 0) {
                    return $this->NextStatus();
                } else {
                    echo "<h2>Nota Fiscal Já Cadastrada ou Ainda Não Voltada, Verifique o Último Status <hr> Status Já Cadastrado </h2>";
                    echo "<table border=1><th>Nota FIscal</th><th>Status</th>";
                    $i = 0;
                    foreach ($this->showStatus("V")["status"] as $key => $value) {
                        echo "<tr><td>{$value['cod']}</td><td>{$value['tipo']}</td></tr>";
                    }
                    echo "</table>";
                }
                break;

            default:
                # code...
                break;
        }
    }


    public function showStatus($type)
    {
        include_once 'conexao_pdo.php'; // abre a conexao com o pdo.
        $conexao = new Banco;
        $statemente = $conexao->pdo->query("SELECT * from codigo where cod = $this->invoice and Tipo = '$type'");
        $pedido = $statemente->fetchAll(PDO::FETCH_ASSOC);
        if ($pedido) {
            return [
                "code" => 1,
                "status" => $this->listStatus(),
            ];
        } else {
            return [
                "code" => 0,
                "status" => $this->listStatus()
            ];
        }
    }

    public function listStatus()
    {
        include_once 'conexao_pdo.php'; // abre a conexao com o pdo.
        $conexao = new Banco;
        $statemente = $conexao->pdo->query("SELECT cod,tipo from codigo where cod = $this->invoice");
        $pedido = $statemente->fetchAll(PDO::FETCH_ASSOC);
        return $pedido;
    }
    /**
     * Get the value of status
     */
    public function getStatus(): array
    {
        return $this->status;
    }

    /**
     * Set the value of status
     */
    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get the value of invoice
     */
    public function getInvoice(): String
    {
        return $this->invoice;
    }
}
