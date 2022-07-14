<!DOCTYPE html>
<head>
  <meta charset="UTF-8" />
  <title>Formulário de Login e Registro com HTML5 e CSS3</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
  <link rel="stylesheet" type="text/css" href="/css/login.css" />
</head>
<body>
  <div class="container" >
    <a class="links" id="paracadastro"></a>
    <a class="links" id="paralogin"></a>
     
    <div class="content">      
      <!--FORMULÁRIO DE LOGIN-->
      <div id="login">
        <form method="post" action="/login/auth.php"> 
          <h1>Login</h1> 
          <p> 
            <label for="login">Login</label>
            <input id="login" name="login" required="required" type="text" placeholder="ex. 20191INF1234"/>
          </p>
           
          <p> 
            <label for="senha">Senha</label>
            <input id="senha" name="senha" required="required" type="password" placeholder="ex. 1234"/>
          </p>
          <p> 
            <input type="submit" value="Logar" /> 
          </p>
        </form>
      </div>

    </div>
  </div>  
</body>
</html>