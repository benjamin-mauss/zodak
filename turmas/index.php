
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
    <title>Document</title>
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
                <li><a class="dropdown-item dropItemMe" href="#">Turma</a></li>
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
              <a class="nav-link dropItemMe" href="/v1/alunos/presenca.php" >Presenças</a>
            </li>
            </li>
          </ul>
        </div>
        <a class="navbar-brand navLogout" href="/v1/login/logout.php">SAIR</a>
    </div>
</nav>






<!-- <nav class="navbar navbarme">
  <div class="container-fluid containerNav">
    <a class="navbar-brand" href="/v1/alunos">Alunos</a>
    <a class="navbar-brand mb-0 h1" href="/v1/turmas">Turmas</a>
    <a class="navbar-brand" href="/v1/horarios">Horarios</a>
  </div>
</nav> -->



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


<div class="containerform">
    <h2>Turmas</h2>
    <table class="table" contenteditable="true" id="table">
        <tr  contenteditable="false">
            <th>Ativo</th>
            <th>ID</th>
            <th>Nome</th>
            <th>Grade</th>
        </tr>
        <?php
        require_once("../database/connect.php");
        $q = mysqli_query($conn, "SELECT * FROM zodak.turmas");

        if (!$q) {
            echo 'Could not run query: ';
            exit;
        }
        $row = mysqli_fetch_assoc($q);
        while($row){
            $id= $row["id"];
            $nome = $row["nome"];
            $grade = $row["grade"];
            echo("<tr>
            
            <td contenteditable=false><input type='checkbox' id='$id' name='ativo' checked></td>
            <td contenteditable=false>$id</td>
            <td>$nome</td>
            <td>$grade</td>
            </tr>");

            $row = mysqli_fetch_assoc($q);
        }
        

        ?>
    </table>

    <button class="btnatt" type="submit" id="att">Atualizar turmas</button>
</div>

<div class="containerform">
    <h2>Adicione uma turma nova:</h2>
    <form action="" method="post">
        <input type="text" name="nome" class="form-control" id="nome" placeholder="nome">
        <input type="number" name="grade" class="form-control" id="grade" placeholder="grade">
        <button type="submit">adicionar</button>
    </form>
</div>

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
            var grade = cells[3].textContent;
            values.push({id: id, name: name, grade: grade});
            if(!ativo){
                del_array.push(id);
            }
        }

        // sends values to att.php

        var xhttp = new XMLHttpRequest();
        
        xhttp.open("POST", "/v1/turmas/att.php");
        xhttp.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
        xhttp.send(JSON.stringify(values));
        xhttp.onreadystatechange = function () {
                if(xhttp.readyState === XMLHttpRequest.DONE && xhttp.status === 200) {         
                    // deletes the rows that are not checked
                    if(del_array.length > 0 && confirm("Deseja deletar as turmas desmarcadas?")){
                        var xhttp2 = new XMLHttpRequest();
                        xhttp2.open("POST", "/v1/turmas/del.php");
                        xhttp2.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
                        xhttp2.send(JSON.stringify(del_array));
                        xhttp2.onreadystatechange = function () {
                            if(xhttp2.readyState === XMLHttpRequest.DONE && xhttp2.status === 200) {         
                                    location.href = ("/v1/turmas?r=Atualizou");     
                            }
                        };
                    }else{
                        location.href = ("/v1/turmas?r=Atualizou");
                    }
                }
            };

        
        

    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous" >


    </body>
</html>
