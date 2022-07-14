<?php
session_start();
if (!isset($_SESSION['id'])){
    header("Location: /login?r=Nao_logado");
    die();
}

?>

logado