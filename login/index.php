<!DOCTYPE html>
<head>
  <meta charset="UTF-8" />
  <title>Zodak</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
  <link href="index.css" type="text/css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

</head>
<body id="bodyclass">
   <div class="sidenav">
      <div class="login-main-text">
         <h2>ZODAK</h2>
         <p>IFsul Campus Sapiranga</p>
      </div>
   </div>
   <div class="main">
      <div class="col-md-6">
         <div class="login-form">
            <form method="post" action="/v1/login/auth.php">
               <div class="form-group">
                  <label for="login">User Name</label>
                  <input id="login" class="form-control" name="login" required="required" type="text" placeholder="ex. 20191INF1234"/>
               </div>
               <div class="form-group">
                  <label>Password</label>
                  <input id="senha" name="senha" class="form-control" required="required" type="password" placeholder="ex. 1234"/>
               </div>
               <button type="submit" class="btn btn-black" value="Logar">Login</button>
            </form>
         </div>
      </div>
   </div> 

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>
</html>




