<?php
session_start();
if (!isset($_SESSION['id'])){
    header("Location: /v1/login?r=Nao_logado");
    die();
}

if($_POST){
    if(strlen($_POST['grade']) > 0 && strlen($_POST['nome']) > 0){
        
        require_once("../database/connect.php");
        $a = $_POST["grade"];
        $b = $_POST["nome"];
        echo("INSERT INTO zodak.turmas values (NULL, $a, $b)");
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
<form action="" method="post">
<br>
    <input type="text" name="nome" id="nome" placeholder="nome"><br>
    <input type="number" name="grade" id="grade" placeholder="grade"><br>
    <button type="submit">adicionar</button>
</form>


<table border="1px" contenteditable="true" id=table>
    <tr>
        <th>id</th>
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
        <td>$id</td>
        <td>$nome</td>
        <td>$grade</td>
        </tr>");

        $row = mysqli_fetch_assoc($q);
    }
    

    ?>
</table>

<button type="submit" id="att">Atualizar turmas</button>


<script>
    document.getElementById("att").onclick = function(){
        // extracts all the values of the table and sends to the server
        var table = document.getElementById("table");
        var rows = table.getElementsByTagName("tr");
        var values = []; // {id: value, name: value, grade: value}
        
        for(var i = 1; i < rows.length; i++){
            var cells = rows[i].getElementsByTagName("td");
            var id = cells[0].textContent;
            var name = cells[1].textContent;
            var grade = cells[2].textContent;
            values.push({id: id, name: name, grade: grade});
        }

        // sends values to att.php
        var xhttp = new XMLHttpRequest();
        
        xhttp.open("POST", "/v1/turmas/att.php");
        xhttp.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
        xhttp.send(JSON.stringify(values));
    }
</script>

<br><br><br>


litar as turmas aqui em uma table toscona
/turmas
    GET - lista as turmas, no front aparecendo opção para adicionar/remover turmar
    POST - dá pra adicionar nova turma
/turma/[ID_TURMA]
    GET - lista os alunos da turma
    POST - dá pra editar a turma (nome, ano e alunos)
    DELETE - remove a turma
