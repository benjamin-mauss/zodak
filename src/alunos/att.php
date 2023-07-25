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
        if(strlen($data['matricula']) > 0 && strlen($data['name']) > 0 && strlen($data['turma']) > 0 && strlen($data['id']) > 0){
            $a = $data["turma"];
            $b = $data["name"];
            $c = $data["id"];
            $d = $data["matricula"];
            $sql = "UPDATE  zodak.alunos SET  id='$c', nome='$b', id_turma='$a', matricula='$d' WHERE id='$c'";
            echo $sql;
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
}
