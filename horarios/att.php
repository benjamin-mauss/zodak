<?php
session_start();

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

if (!isset($_SESSION['id'])){
    header("Location: /v1/login?r=Nao_logado");
    die();
}
$big_data = json_decode(file_get_contents('php://input'), true);
if($big_data){
    require_once("../database/connect.php");
    foreach( $big_data as $data){
        // data = {id, turma, periodo, dia_semana, inicio, fim}

        $id = $data["id"];
        $turma = $data["turma"];
        $periodo = $data["periodo"];
        $dia_semana = $data["dia_semana"];
        $inicio = $data["inicio"];
        $fim = $data["fim"];

        
        $q = mysqli_query($conn, "UPDATE  zodak.horarios 
                SET  
                    id='$id', id_turma='$turma', periodo='$periodo', dia_semana='$dia_semana', inicio='$inicio', fim='$fim'
                WHERE
                    id='$id'
                ");
        if (!$q) {
            echo 'Could not run query: ';
            die();
        }
        echo("Mudou");
        
    
    }
}

