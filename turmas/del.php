<?php
session_start();
if (!isset($_SESSION['id'])){
    header("Location: /v1/login?r=Nao_logado");
    die();
}
$big_data = json_decode(file_get_contents('php://input'), true);
if($big_data){
    foreach( $big_data as $id){
        if(strlen($id) > 0){
            require_once("../database/connect.php");
            $q = mysqli_query($conn, "DELETE FROM zodak.turmas WHERE id='$id'");
            if (!$q) {
                echo 'Could not run query: ';
                die();
            }
            echo("deletou");
            
        }else{
            echo("Erro_1");
            die();
        }
    }
}

