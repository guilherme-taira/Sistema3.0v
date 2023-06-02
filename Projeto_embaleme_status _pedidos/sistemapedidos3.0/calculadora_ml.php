<?php

include_once 'index.php';

class calculadora{
    private $produto = 0;
    private $frete = 0;
    private $porcem = 0;
    private $modalidade = 0;

    function __construct($produto,$frete,$porcem,$modalidade)
    {
        $this->produto = $produto;
        $this->frete = $frete;
        $this->porcem = $porcem;
        $this->modalidade = $modalidade;
    }


    function calcular(){
        
                  # Calculo do Valor X
            
                $cont = $this->porcem / 100;
                
                $valor_final = ($this->produto + $this->frete) * ($cont + 1.00);
         

                # Calculo do Valor Percentual

                $calculopercentual = (($valor_final - $this->produto) * 100) / $this->produto;
                
         
                #calculo da prova real

                if($this->modalidade == '1'){
                 
                $cont1 = ceil($calculopercentual) / 100;
           
                $valor1 = ($this->produto * ($cont1 + 1.00));
                $tarifa = $valor1 * (0.11);
                $prova_real = ($valor1 - $tarifa - $this->frete);


                echo "<div>
                  <h5 class='card-title'>Valor X : " . $valor_final . "
                  <h5 class='card-title'>Valor Percentual Arredondado : " . ceil($calculopercentual)."
                  <h5 class='card-title'>Valor Prova Real : ". $prova_real."
                  <br>
                  <a href='calculadora_mercado_livre.php' class='btn btn-primary'>Voltar</a>
            
              </div>";
          

            }else if($this->modalidade == '2'){

                $cont1 = ceil($calculopercentual) / 100;
                $valor1 = ($this->produto * ($cont1 + 1.00));
                $tarifa = $valor1 * (0.16);
                $prova_real = ($valor1 - $tarifa - $this->frete);
                echo "<div>
                <h5 class='card-title'>Valor X : " . $valor_final . "
                <h5 class='card-title'>Valor Percentual Arredondado : " . ceil($calculopercentual)."
                <h5 class='card-title'>Valor Prova Real : ". $prova_real."
                <br>
                <a href='calculadora_mercado_livre.php' class='btn btn-primary'>Voltar</a>
            
            </div>";
    
                
                 }
            
    
    }
}

$valor_produto = $_POST['produto'];
$frete_get = $_POST['frete'];
$valor_porcentagem = $_POST['porcentagem'];
$Tipo = $_POST['Tipo'];

$conta = new calculadora($valor_produto,$frete_get,$valor_porcentagem,$Tipo);
$conta->calcular();
?>