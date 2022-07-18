<?php
session_start();
if (!isset($_SESSION['id'])){
    header("Location: /v1/login?r=Nao_logado");
    die();
}
$big_data = json_decode(file_get_contents('php://input'), true);
if($big_data){
    require_once("../database/connect.php");
    foreach( $big_data as $data){
        if(strlen($data['grade']) > 0 && strlen($data['name']) > 0  && strlen($data['id']) > 0){
            $a = $data["grade"];
            $b = $data["name"];
            $c = $data["id"];
            $q = mysqli_query($conn, "UPDATE  zodak.turmas SET  id='$c', nome='$b', grade='$a' WHERE id='$c'");
            if (!$q) {
                echo 'Could not run query: ';
                die();
            }
            echo("Mudou");
            
        }else{
            echo("Erro_1");
            die();
        }
    }
}
