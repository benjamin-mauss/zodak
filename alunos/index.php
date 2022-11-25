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
        <a class="navbar-brand navTitle" href="#">ZODAK</a>
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
                <li><a class="dropdown-item dropItemMe" href="/v1/presencas/att_presenca.php">Adicionar Presenças</a></li>
              </ul> 
            </li>
            </li>
          </ul>
        </div>
        <a class="navbar-brand navLogout" href="/v1/login/logout.php">SAIR</a>
    </div>
</nav>

<h2 class='title'>Veja, delete ou edite os alunos</h2>
<table class="table tableMe" contenteditable="true" id=table>
    <thead>
        <tr contenteditable="false">
            <th>Ativo</th>
            <th>Id</th>
            <th>Nome</th>
            <th>Matrícula</th>
            <th>Turma</th>
        </tr>
    </thead>
        <tbody class="table-group-divider">
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

        
        $q = mysqli_query($conn, "SELECT a.id, a.nome, a.matricula, a.id_turma, t.nome as turma FROM zodak.alunos as a INNER JOIN zodak.turmas as t on a.id_turma = t.id ; ");
        
        

        if (!$q) {
            echo 'Could not run query: ';
            exit;
        }
        $row = mysqli_fetch_assoc($q);
        
        while($row){
            
            $id= $row["id"];
            $nome = $row["nome"];
            $matricula = $row["matricula"];
            $turma= $row["id_turma"];
            $tt = "";

            
            foreach ($rows as $r) {

                
                $t = "<option value=\"{$r["id"]}\" ";
                
                if($row["id_turma"] == $r["id"]){
                    $t .= "selected";
                }
                $t.=">{$r["nome"]}</option>\n";
                $tt .=$t;
            }
            echo("<tr>
            
            <td contenteditable=false><input type='checkbox' id='$id' name='ativo' checked></td>
            <td contenteditable=false>$id</td>
            <td >$nome</td>
            <td>$matricula</td>
            <td contenteditable=false> <select name='turma'>" . $tt . "</select></td>
            </tr>");

            $row = mysqli_fetch_assoc($q);
        }
        

        ?>
    </tbody>
</table>

<button class="btn btn-info" type="submit" id="att">Atualizar alunos</button>


<script>
    document.getElementById("att").onclick = function(){
        // extracts all the values of the table and sends to the server
        var table = document.getElementById("table");
        var rows = table.getElementsByTagName("tr");
        var values = []; // {id: value, name: value, grade: value}
        
        // del array
        var del_array = [];

        for(var i = 1; i < rows.length; i++){
            var cells = rows[i].getElementsByTagName("td");
            var ativo = cells[0].firstChild.checked;
            var id = cells[1].textContent;
            var name = cells[2].textContent;
            var matricula = cells[3].textContent;
            var turma = cells[4].lastChild.value;
            values.push({id: id, name: name, matricula: matricula, turma:turma});
            if(!ativo){
                del_array.push(id);
            }
        }
        // copiar o atualizado

         // sends values to att.php
        var xhttp = new XMLHttpRequest();
        
        xhttp.open("POST", "/v1/alunos/att.php");
        xhttp.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
        xhttp.send(JSON.stringify(values));
        xhttp.onreadystatechange = function () {
                if(xhttp.readyState === XMLHttpRequest.DONE && xhttp.status === 200) {         
                    // deletes the rows that are not checked
                    if(del_array.length > 0 && confirm("Deseja deletar os alunos desmarcados?")){
                        var xhttp2 = new XMLHttpRequest();
                        xhttp2.open("POST", "/v1/alunos/del.php");
                        xhttp2.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
                        xhttp2.send(JSON.stringify(del_array));
                        xhttp2.onreadystatechange = function () {
                            if(xhttp2.readyState === XMLHttpRequest.DONE && xhttp2.status === 200) {         
                                    location.href = ("/v1/alunos?r=Atualizou");     
                            }
                        };
                    }else{
                        location.href = ("/v1/alunos?r=Atualizou");
                    }
                }
            };

    }
</script>

<br><br><br>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
    </body>
</html>
