<?php
session_start();
if (!isset($_SESSION['id'])){
    header("Location: /v1/login?r=Nao_logado");
    die();
}
$data = json_decode(file_get_contents('php://input'), true);
if($data){
    require_once("../database/connect.php");
    
    if(strlen($data['id']) > 0){
        $a = $data["id"];
        $b = $data["present"] == "true" ? 1 : 0;

        $sql = "UPDATE  zodak.presencas SET  id='$a', present='$b' WHERE id='$a'";
        
        $q = mysqli_query($conn, $sql);
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
