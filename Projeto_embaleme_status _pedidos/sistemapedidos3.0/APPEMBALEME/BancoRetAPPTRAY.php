<?php
//String de Conexão ********************

// echo "<pre>";
// Warning: odbc_connect(): SQL error: [ODBC Firebird Driver]Unable to connect to data source: library 'gds32.dll' failed to load, SQL state 08004 in SQLConnect in
// print_r(get_loaded_extensions());
// print_r(PDO::getAvailableDrivers ());
// echo "</pre>";
// $hostname = "firebird:dbname=C:\Users\Usuario\Downloads\retteste.fdb";
$usuario = "SYSDBA"; // Usuário padrão do Firebird
$senha = "masterkey"; // Senha padrão do Firebird
 // DRIVER=Firebird/InterBase(r) driver;UID=SYSDBA;PWD=masterkey;DBNAME=C:\Users\Usuario\Downloads\retteste.fdb;
// $conn = "DRIVER=Firebird/InterBase(r) driver; SERVER=127.0.0.1; DATABASE=C:\Users\Usuario\Downloads\retteste.fdb";

 $options = [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_CASE => PDO::CASE_NATURAL,
  PDO::ATTR_ORACLE_NULLS => PDO::NULL_EMPTY_STRING,
  PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
];

try {
  $pdo = new PDO('odbc:retnovo',$usuario,$senha,$options);
  if($pdo){
  //   echo "<p><div class='spinner-grow text-success' role='status'>
  //   <span class='visually-hidden'>Loading...</span>
  // </div>Conectado no banco com sucesso</p>";
  }
  }catch (PDOException $exception) {   
    echo $exception->getMessage();
    exit;
  }
