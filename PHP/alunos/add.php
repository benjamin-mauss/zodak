
<!-- mudar de turmas para alunos (todos os endpoints) -->

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
    

<?php

if($_POST){
    $target_dir =  "/opt/lampp/htdocs/uploads/" ;
    

    // getting the next id

    require_once("../database/connect.php");

    $q = mysqli_query($conn, "SHOW TABLE STATUS from zodak where name='alunos'");
   

    if (!$q) {
        echo 'Could not run query (1): ';
        exit;
    }
    
    $row = mysqli_fetch_assoc($q);
    $id= $row["auto_increment"];
    
    
    $target_file = $target_dir . basename($id . ".png");


    
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
    }

    // Check if file already exists
    if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    ) {
    echo "Sorry, only JPG, JPEG, PNG files are allowed.";
    $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded 1.";
    die(); 
    // if everything is ok, try to upload file
    } else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file 2.";
    }

    // agora pegar o faceId chamando a função em python
    // salvar saporra na table faceId - será que a gente usa tabela?
    // dar include no aluno
    // apesar de não mostrar os arquivos ficam em /
}

}

?>

<style>
    table{
        width:100%;
    }
</style>
<form action="" method="post" enctype="multipart/form-data">
<br>
    <input type="text" name="nome" id="nome" placeholder="nome"><br>
    <input type="matricula" name="matricula" id="matricula" placeholder="matricula"><br>
    <select name="turma">
    
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
            echo("<option value='$id'>$nome</option>\n");

            $row = mysqli_fetch_assoc($q);
        }
        

        ?>
    </select>
    <br>
    <input type="file" name="fileToUpload" id="fileToUpload" accept="image/*">
    <br><br>
    <button type="submit">adicionar</button>
</form>

enviar foto
- criar arquivo separado para chamar o bagulho em python, pq a gente vai ter que usar no editar.php tbm
