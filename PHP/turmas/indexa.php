
aaaaaa
<?php
session_start();
if (!isset($_SESSION['id'])){
    header("Location: /v1/login?r=Nao_logado");
    die();
}
require_once("../database/connect.php");

if($_POST){
    if(strlen($_POST['grade']) > 0 && strlen($_POST['nome']) > 0){
        
        
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
aaaaaaa
<form action="" method="post">
<br>
    <input type="text" name="nome" id="nome" placeholder="nome"><br>
    <input type="number" name="grade" id="grade" placeholder="grade"><br>
    <button type="submit">adicionar</button>
</form>


<table>
    <tr>
        <th>Nome</th>
    </tr>
    <tr>
        <th>Grade</th>
    </tr>
    <?php
    echo("aa");
    $q = mysqli_query($conn, "select * from turmas;");
    
    var_dump($q);
    $r=mysqli_fetch_assoc($q);
    if (!$r) {
        echo 'Could not run query: ';
        exit;
    }
    $row = mysqli_fetch_assoc($q);
    while($row){
        
        $nome = $r["nome"];
        $grade = $r["grade"];
        echo("<tr>\
        <td>$nome</td>\
        </tr>\
        <tr>\
        <td>$grade</td>\
        </tr>");

        $row = mysqli_fetch_assoc($q);
    }
    

    ?>
</table>

litar as turmas aqui em uma table toscona
/turmas
    GET - lista as turmas, no front aparecendo opção para adicionar/remover turmar
    POST - dá pra adicionar nova turma
/turma/[ID_TURMA]
    GET - lista os alunos da turma
    POST - dá pra editar a turma (nome, ano e alunos)
    DELETE - remove a turma
