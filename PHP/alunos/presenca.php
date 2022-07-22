<?php
session_start();
if (!isset($_SESSION['id'])){
    header("Location: /v1/login?r=Nao_logado");
    die();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<style>
    table{
        width:100%;
    }
</style>

<a href="/v1/alunos">alunos</a><br>
<a href="/v1/turmas">turmas</a><br>
<a href="/v1/presencas">presenças</a><br>
<br><br><br>   

<h2>pesquisa</h2>
<form action="" method="get">
    nome: <input type="text" name="nome" id="nome" placeholder="nome"><br>
    turma: <input type="text" name="turma" id="turma" placeholder="turma"><br>
    since: <input type="date" name="since" id="since"><br>
    until: <input type="date" name="until" id="until"><br> 
    <button type="submit">pesquisar</button>
</form>


<h2>Veja, delete ou edite as presenças</h2>
<table border="1px" contenteditable="false" id=table>
    <tr contenteditable="false">
        <th>ID presença</th>
        <th>Aluno</th>
        <th>Matrícula</th>
        <th>Turma</th>
        <th>Período</th>
        <th>Data</th>
        <th>Início</th>
        <th>Fim</th>
        <th>Presente</th>
    </tr>


<?php

    // vai dá pra ver a presença de todos os alunos
    // dá pra alterar também
    // futuramente, se pá, daria pra exportar pro suap, excel, etc.
    // a presença vai ser dado pelo algoritmo de reconhecimento facial em python

    // dia_semana 0 - 6, domingo à sábado
    // periodo de aula 0-5, do primeiro ao último
    // se pá que eu precisava do horário de início e fim do período de aula
    require_once("../database/connect.php");
    if($_POST){

    }

    $sql = "SELECT 
                p.id AS id_p,
                p.id_aluno AS id_a,
                t.id as id_t,
                p._data AS _date,
                a.matricula as matricula,
                p.present AS present,
                a.nome AS nome,
                h.periodo AS periodo,
                t.nome as turma,
                h.inicio as inicio,
                h.fim as fim
            FROM
                zodak.presencas AS p
                    JOIN
                zodak.alunos AS a ON p.id_aluno = a.id
                    JOIN
                zodak.horarios AS h ON p.id_horario = h.id
                    JOIN
                zodak.turmas AS t ON a.id_turma = t.id";

    if($_GET["aluno"] != null || $_GET["turma"] != null || $_GET["since"] != null || $_GET["until"] != null){
        $sql .= " WHERE 1=1 ";
        if($_GET["aluno"] != null){
            $sql .= " AND a.nome like '%".$_GET["aluno"] . "%'";
        }
        if($_GET["turma"] != null){
            $sql .= " AND t.nome like '%".$_GET["turma"] . "%'";
        }
        if($_GET["since"] != null){
            $sql .= " AND _data >= '".$_GET["since"]."'";
        }
        if($_GET["until"] != null){
            $sql .= " AND _data  <= '".$_GET["until"]."'";
        }
    }

    $q = mysqli_query($conn, $sql); 

    if (!$q) {
        echo 'Could not run query: ';
        exit;
    }
    $row = mysqli_fetch_assoc($q);
    while($row){
        echo("<tr>");
        echo("<td>".$row['id_p']."</td>");
        // echo("<td>".$row['id_a']."</td>");
        // echo("<td>".$row['id_t']."</td>");
        echo("<td>".$row['nome']."</td>");
        echo("<td>".$row['matricula']."</td>");
        echo("<td>".$row['turma']."</td>");
        echo("<td>".$row['periodo']."</td>");
        echo("<td>".$row['_date']."</td>");
        echo("<td>".$row['inicio']."</td>");
        echo("<td>".$row['fim']."</td>");
        echo("<td contenteditable=true>".$row['present']."</td>");
        echo("</tr>");
        $row = mysqli_fetch_assoc($q);
    }

?>

</body>
</html>