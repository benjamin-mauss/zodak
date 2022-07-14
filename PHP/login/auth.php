<?php

require_once ("../database/connect.php");


session_start();
if (isset($_SESSION['id'])){
    header("Location: /turmas?r=Ja_logado");
    die();
}


if (! $_POST || !$_POST["login"] || !$_POST["senha"]){
    header("Location: /login?r=Acesso_direto");
    die();
}

$hash = md5($_POST['senha']);
$mat = strtolower($_POST["login"]);
echo("SELECT * FROM zodak.admin where matricula='{$_POST["login"]}' and hash_senha='$hash';");
$q = mysqli_query($conn, "SELECT * FROM zodak.admin WHERE matricula='{$_POST["login"]}' and hash_senha='$hash';");


var_dump($q);
if ($q && (mysqli_num_rows($q) == 1)){
    $r=mysqli_fetch_assoc($q);
    $_SESSION['id'] = $r['id'];
    $_SESSION['matricula'] = $r['matricula'];
    $_SESSION['nome'] = $r['nome'];
    header("Location: /turmas?r=senha_errada");
    die();
}else{
    header("Location: /login?r=senha_errada");
    die();
}




?>