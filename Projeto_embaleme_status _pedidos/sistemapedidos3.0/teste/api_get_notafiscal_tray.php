<?php
   $array = array();
   $array = ['id'=> 0, 'Nome'=>'Chocolate Crispearl', 'Quantidade' => 3];

   lista_array($array);

   function lista_array(&$lista){
    echo "<pre>";
    if($lista['id'] == 0 ){
            $lista['Quantidade'] - 1 ."<br>";
            print_r($lista);
        echo "Existe <br>"; 
    }else{
        echo "não existe esse produto <br>";
    }
    var_dump($lista);
   }
?>