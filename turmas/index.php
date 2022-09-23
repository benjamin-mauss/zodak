


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

<a href="/v1/alunos">alunos</a><br>
<a href="/v1/turmas">turmas</a><br>
<a href="/v1/horarios">horarios</a><br>

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

<h2>Adicione uma turma nova:</h2>
<form action="" method="post">
<br>
    <input type="text" name="nome" id="nome" placeholder="nome"><br>
    <input type="number" name="grade" id="grade" placeholder="grade"><br>
    <button type="submit">adicionar</button>
</form>

<h2>Veja, edite ou delete a turmas:</h2>
<table border="1px" contenteditable="true" id=table>
    <tr  contenteditable="false">
        <th>ativo</th>
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
        
        <td contenteditable=false><input type='checkbox' id='$id' name='ativo' checked></td>
        <td contenteditable=false>$id</td>
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

<br><br><br>



    </body>
</html>
