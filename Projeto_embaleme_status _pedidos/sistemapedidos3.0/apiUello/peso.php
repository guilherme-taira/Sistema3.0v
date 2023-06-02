<?php

interface CalculoProduto{
    public function CalculaDimensao(array $dados);
    public function CalculaPeso(array $dados);
}



class Frete implements CalculoProduto{

    public function CalculaDimensao(array $dados){
     
        $peso = implode("/", $dados);
        $prods = explode("/",$peso);
        $jsonTransf = json_encode($prods);
        $json = json_decode($jsonTransf,false);

        $Dimensao = 0.0;
        foreach ($json as $value) {
            // gera o array com os dados até a chave 07
            $novo = explode(";", $value);
            $Dimensao += (($novo[0] * $novo[1] * $novo[2]) * 10) * $novo[4];    
        }
        return $Dimensao;
    }

    public function CalculaPeso(array $dados){
        
        $peso = implode("/", $dados);
        $prods = explode("/",$peso);
        $jsonTransf = json_encode($prods);
        $json = json_decode($jsonTransf,false);

        $pesoTotal = 0.0;
        foreach ($json as $value) {
            // gera o array com os dados até a chave 07
            $novo = explode(";", $value);
            $pesoTotal += ($novo[5] * $novo[4]);    
        }
        return $pesoTotal;
    }
}
//0,0160

// $Dados = '0.2;0.2;0.4;0.008;1;0.1;6;43.99/0.3;0.5;0.5;0.033;2;0.235;8;151.33';
// $peso = explode("/", $Dados);

// //print_r($peso);
// $Frete = new Frete;
// echo "<br> Dimensão : ".$Frete->CalculaDimensao($peso);
// echo "<br> Peso : ".$Frete->CalculaPeso($peso);

