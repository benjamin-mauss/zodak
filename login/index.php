<!DOCTYPE html>
<head>
  <meta charset="UTF-8" />
  <title>Zodak</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
  <link href="/v1/lib/bootstrap.css" rel="stylesheet">
   <link href="/v1/lib/docs.css" rel="stylesheet">
   <script src="/v1/lib/bootstrap.js"></script>
   <link href="/v1/css/navbar.css" rel="stylesheet">
   <link href="/v1/css/login.css" rel="stylesheet">
</head>
<body id="bodyclass">
<div class="main">
      <div class="login-main-text">
         <h2>ZODAK</h2>
         <p>IFsul Campus Sapiranga</p>
      </div>
      <div class="col-md-4 login-form">
            <form method="post" action="/v1/login/auth.php">
               <div class="form-group">
                  <input id="login" class="form-control" name="login" required="required" type="text" placeholder="Username"/>
               </div>
               <div class="form-group">
                  <input id="senha" name="senha" class="form-control" required="required" type="password" placeholder="Senha"/>
               </div>
               <button type="submit" class="btn" value="Logar">Login</button>
            </form>
      </div>
   </div> 

</body>
</html>




