<?php
ob_start();
// Conexão com o banco de dados
require_once 'teste/conexao_pdo.php';

// Inicia sessões
session_start();

// Recupera o login
$login = $_REQUEST['login'];
// Recupera a senha, a criptografando em MD5
$senha = $_REQUEST["senha"];


// Usuário não forneceu a senha ou o login

try {
    require_once 'estilos/bootrap.php';
    $query = "SELECT * FROM colaborador where nome = ? and senha = ?";
    $statement = $pdo->prepare($query);
    $statement->execute([$login, $senha]);
    $usuario = $statement->fetch();
    if ($usuario) {
        echo "<div class='alert alert-success d-flex align-items-center' role='alert'>
        <svg class='bi flex-shrink-0 me-2' width='24' height='24' role='img' aria-label='Success:''><use xlink:href='#check-circle-fill'/></svg>
        <div>
        Usuário: {$usuario['nome']} Logado(a) com Sucesso! <strong> Aguarde...<Strong>
        " . header('Refresh: 2;url=painel_ocorrencia.php');
        ".
        </div>
        </div>";
        $_SESSION["login_embaleme_id_usuario"] = $login;
    } else {

        echo "<div class='alert alert-warning d-flex align-items-center' role='alert'>
        <svg class='i flex-shrink-0 me-2' width='24' height='24' role='img' aria-label='Warning:'><use xlink:href='#exclamation-triangle-fill'/></svg>
        <div>
            Usuário ou Senha Incorreto! Verifique
        </div>
        </div>";
        exit;
    }
} catch (\PDOException $th) {
    $th->getMessage();
}
ob_flush();
