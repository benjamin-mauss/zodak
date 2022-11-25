


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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.2/assets/css/docs.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="../css/turmas.css" rel="stylesheet">
    <link href="../css/navbar.css" rel="stylesheet">
    <title>Zodak</title>
</head>
<body>

<nav class="navbar navbar-expand-lg navbarme">
    <div class="container-fluid containerNav">
    <a class="navbar-brand navTitle" href="/v1">ZODAK</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar\-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse containerItemNav" id="navbarNavDropdown">
          <ul class="navbar-nav">
            <li class="nav-item dropdown">
              <a class="nav-link dropItemMe" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Alunos</a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item dropItemMe" href="/v1/alunos">Aluno</a></li>
                <li><a class="dropdown-item dropItemMe" href="/v1/alunos/add.php">Adicionar Aluno</a></li>
              </ul>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropItemMe" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Turmas</a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item dropItemMe" href="/v1/turmas">Turma</a></li>
                <li><a class="dropdown-item dropItemMe" href="/v1/turmas/add.php">Adicionar Turma</a></li>
              </ul>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropItemMe" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Horários</a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item dropItemMe" href="/v1/horarios">Horários</a></li>
                <li><a class="dropdown-item dropItemMe" href="/v1/horarios/add.php">Adicionar Horários</a></li>
              </ul>
              <li class="nav-item dropdown">
              <a class="nav-link dropItemMe" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Presenças</a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item dropItemMe" href="/v1/presencas">Presenças</a></li>
              </ul> 
            </li>
            </li>
          </ul>
        </div>
        <a class="navbar-brand navLogout" href="/v1/login/logout.php">SAIR</a>
    </div>
</nav>


<?php

if($_POST){
    if(strlen($_POST['grade']) > 0 && strlen($_POST['nome']) > 0){
        
        require_once("../database/connect.php");
        $a = $_POST["grade"];
        $b = $_POST["nome"];
        
        $q = mysqli_query($conn, "INSERT INTO zodak.turmas values (NULL, '$a', '$b')");
        header("Location: /v1/turmas?r=Incluiu");
        die();
    }else{
        header("Location: /v1/turmas?r=Erro_1");
        die();
    }
    
    header("Location: /v1/turmas?r=Erro_2");
    die();
}

?>

<style>
    table{
        width:100%;
    }
</style>


<h2>Veja, edite ou delete os horarios:</h2>
<table border="1px" contenteditable="true" id=table>
    <tr  contenteditable="false">
        <th>id</th>
        <th>turma</th>
        <th>periodo</th>
        <th>dia_semana</th>
        <th>inicio</th>
        <th>fim</th>
    </tr>
    <?php
    require_once("../database/connect.php");


    $q = mysqli_query($conn, "SELECT * FROM zodak.turmas");
    

    if (!$q) {
        echo 'Could not run query: ';
        exit;
    }
    $row = mysqli_fetch_assoc($q);
    $rows = [];
    while($row){
        array_push($rows, $row);

        $row = mysqli_fetch_assoc($q);
    }




    $qq = mysqli_query($conn, " SELECT h.id, h.id_turma, h.periodo, h.dia_semana, h.inicio, h.fim, t.nome as turma FROM zodak.horarios  as h JOIN zodak.turmas as t on h.id_turma= t.id;");
    

    if (!$qq) {
        echo 'Could not run query: ';
        exit;
    }
    $row = mysqli_fetch_assoc($qq);
    while($row){
        $id= $row["id"];
        $turma = $row["turma"];
        $id_turma = $row["id_turma"];
        $periodo = $row["periodo"];
        $dia_semana = $row["dia_semana"];
        $inicio = $row["inicio"];
        $fim = $row["fim"];
        $dias = ["Domingo", "Segunda-Feira", "Terça-Feira", "Quarta-Feira", "Quinta-Feira", "Sexta-Feira", "Sábado"];
        $tt = "";
        for($q =0; $q<sizeof($dias); $q++){
            $f = "";
            if($q == $dia_semana){
                $f .= " selected";
            }
            $tt .= "<option value=\"" . $q ."\"". $f. ">".$dias[$q]."</option>\n";
        }
        $tta = $tt;
        $tt = "";

        
        foreach ($rows as $r) {

            
            $t = "<option value=\"{$r["id"]}\" ";
            
            if($row["id_turma"] == $r["id"]){
                $t .= "selected";
            }
            $t.=">{$r["nome"]}</option>\n";
            $tt .=$t;
        }
        $ttb = "";

        for($f=0; $f<6; $f++){
            $ttb .= "<option value='$f'" ;#$periodo
            if($f == $periodo){
                $ttb .=" selected";
            }
            $ttb .= ">$f</option>\n";
        }

        echo("<tr>
        <td contenteditable=false>$id</td>
        
        <td contenteditable=false>
            <select name=\"selectmma\">$tt
            </select>
        </td>

        <td contenteditable=false>
            <select name=\"selectuua\">
                $ttb
            </select>
        </td>

        <td contenteditable=false>
        <select name=\"selectoaa\">
            $tta
        </select></td>
        <td>$inicio</td>
        <td>$fim</td>
        </tr>");

        $row = mysqli_fetch_assoc($qq);
    }
    

    ?>
</table>

<button type="submit" id="att">Atualizar horarios</button>

<script>
    document.getElementById("att").onclick = function(){
        // extracts all the values of the table and sends to the server
        var table = document.getElementById("table");
        var rows = table.getElementsByTagName("tr");
        var values = []; // {id: value, name: value, grade: value}
        

        for(var i = 1; i < rows.length; i++){
            var cells = rows[i].getElementsByTagName("td");
            var id = cells[0].textContent;
            var turma= cells[1].firstElementChild.value;
            var periodo = cells[2].firstElementChild.value;
            var dia_semana = cells[3].firstElementChild.value;
            var inicio = cells[4].textContent;
            var fim = cells[5].textContent;

            values.push({id, turma, periodo, dia_semana, inicio, fim});
           
        }

        // sends values to att.php
        var xhttp = new XMLHttpRequest();
        
        xhttp.open("POST", "/v1/horarios/att.php");
        xhttp.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
        xhttp.send(JSON.stringify(values));
        
        xhttp.onreadystatechange = function () {
                if(xhttp.readyState === XMLHttpRequest.DONE && xhttp.status === 200) {         
                    
                        
                        location.href = ("/v1/horarios?r=Atualizou");
                    
                }
            };

        
        

    }
</script>

<br><br><br>


    
    </body>
</html>
