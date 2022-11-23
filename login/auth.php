<?php

require_once ("../database/connect.php");


session_start();
if (isset($_SESSION['id'])){
    header("Location: /v1/turmas?r=Ja_logado");
    die();
}


if (! $_POST || !$_POST["login"] || !$_POST["senha"]){
    header("Location: /v1/login?r=Acesso_direto");
    die();
}

$hash = md5($_POST['senha']);
$mat = strtolower($_POST["login"]);

var_dump($conn);
$q = mysqli_query($conn, "SELECT * FROM zodak.admins WHERE siape='{$_POST["login"]}' and hash_senha='$hash';");

if ($q && (mysqli_num_rows($q) == 1)){
    $r=mysqli_fetch_assoc($q);
    $_SESSION['id'] = $r['id'];
    $_SESSION['siape'] = $r['siape'];
    $_SESSION['nome'] = $r['nome'];
    header("Location: /v1/turmas?r=senha_correta");
    die();
}else{
    header("Location: /v1/login?r=senha_errada");
    die();
}




?>