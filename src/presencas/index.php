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
    <link href="/v1/lib/bootstrap.css" rel="stylesheet">
    <link href="/v1/lib/docs.css" rel="stylesheet">
    <script src="/v1/lib/bootstrap.js"></script>
    <link href="/v1/css/navbar.css" rel="stylesheet">
    <link href="/v1/css/presencas.css" rel="stylesheet">
    <title>Zodak</title>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark navbarme">
    <div class="container-fluid containerNav">
      <a class="navbar-brand navTitle" href="/v1">ZODAK</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
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
 
<div class="pesquisaform">
    <form class="formpesquisa" action="" method="get">
        <div>
            <label for="nome">Nome: </label>
            <input type="text" name="nome" id="nome" placeholder=""><br>
        </div>
        <div>
            <label for="turma">Turma: </label>
            <input type="text" name="turma" id="turma" placeholder=""><br>
        </div>
        <div>
            <label for="since">Since: </label>
            <input type="date" name="since" id="since"><br>
        </div>
        <div>
            <label for="since">Until: </label>
            <input type="date" name="until" id="until"><br> 
        </div>
        <button class="btnAtt" type="submit">PESQUISAR</button>
    </form>
</div>

<div class="containerform">
    <h2>PRESENÇAS</h2>
    <table class="table" contenteditable="false" id="table">
    <thead>
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
    </thead>
    <tbody>
        <?php
        require_once("../database/connect.php");

        if($_POST){}

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

        if(isset($aluno) || isset($turma) || isset($since) || isset($until)){
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
            echo("<td>".$row['id_p']."</td>\n");
            // echo("<td>".$row['id_a']."</td>");
            // echo("<td>".$row['id_t']."</td>");
            echo("<td>".$row['nome']."</td>\n");
            echo("<td>".$row['matricula']."</td>\n");
            echo("<td>".$row['turma']."</td>\n");
            echo("<td>".$row['periodo']."</td>\n");
            echo("<td>".$row['_date']."</td>\n");
            echo("<td>".$row['inicio']."</td>\n");
            echo("<td>".$row['fim']."</td>\n");
            echo("<td contenteditable=false>"."<input type='checkbox' class='checks' name='present' ". ($row['present'] == 1? "checked" : "" )."></td>\n");
            echo("</tr>");
            $row = mysqli_fetch_assoc($q);
        }
        ?>
    </div>
<script>
    var checks = document.getElementsByClassName("checks");
    for(check of checks){
        check.addEventListener("click", function(){
            var id = this.parentNode.parentNode.firstChild.innerHTML;
            var present = this.checked;
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "/v1/presencas/att_presenca.php", true);
            xhr.setRequestHeader("Content-Type", "application/json");
            xhr.send(JSON.stringify({id: id, present: present}));
            
        });
    }

    // setTimeout(()=>{
    //     location.reload()
    // },1000)
</script>

</body>
</html>