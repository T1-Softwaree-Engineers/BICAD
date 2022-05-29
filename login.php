<?php
  require_once "conn.php";
  session_start();

  if(isset($_SESSION["usuario_login"]))  //Condicion Usuarios
  {
    header("location: dashboard");
  }

  if(isset($_REQUEST['btn_login'])) 
  {
    $email    =$_REQUEST["txt_email"];  //textbox nombre "txt_email"
    $password =$_REQUEST["txt_password"]; //textbox nombre "txt_password"
    $password   = hash('sha512', $password);
    $role   =$_REQUEST["txt_role"];   //select opcion nombre "txt_role"
    if(empty($email))
    {           
      $errorMsg[]="Por favor ingrese Email";  //Revisar email
    }
    else if(empty($password))
    {
      $errorMsg[]="Por favor ingrese Password"; //Revisar password vacio
    }
    else if(empty($role))
    {
      $errorMsg[]="Por favor seleccione rol";  //Revisar rol vacio
    }
    else if($email AND $password AND $role)
    {
      try
      {
        $select_stmt=$db->prepare("SELECT email,pwd,role FROM usuarios WHERE email=:uemail AND pwd=:upassword AND role=:urole"); 
        $select_stmt->bindParam(":uemail",$email);
        $select_stmt->bindParam(":upassword",$password);
        $select_stmt->bindParam(":urole",$role);
        $select_stmt->execute();  //execute query   
        while($row=$select_stmt->fetch(PDO::FETCH_ASSOC)) 
        {
          $dbemail  =$row["email"];
          $dbpassword =$row["pwd"];
          $dbrole   =$row["role"];
        }
        if($email!=null AND $password!=null AND $role!=null)  
        {
          if($select_stmt->rowCount()>0)
          {
            if($email==$dbemail and $password==$dbpassword and $role==$dbrole)
            {
              switch($dbrole)   //inicio de sesión de usuario base de roles
              {
                case "usuario":
                  $_SESSION["usuario_login"]=$email;      
                  $loginMsg="Usuario: Inicio de sesión exitoso."; 
                    header("refresh:2; dashboard");
                  break; 
                default:
                  $errorMsg[]="Correo electrónico o contraseña incorrectos";
              }
            }
            else
            {
              $errorMsg[]="Correo electrónico o contraseña incorrectos";
            }
          }
          else
          {
            $errorMsg[]="Correo electrónico o contraseña incorrectos";
          }
        }
      }
      catch(PDOException $e)
      {
        $e->getMessage();
      }   
    }
    else
    {
      $errorMsg[]="Correo electrónico o contraseña incorrectos";
    }
  }
?>

<!doctype html>
<html lang="en">
  <head>
    <?php include "elements/header.php"; ?>
    <title>Login</title>
  </head>
  <body class="bg-primary">  
    <div class="container">
      <?php
        if(isset($errorMsg))
        {
          foreach($errorMsg as $error)
          {
      ?>
            <div class="alert alert-danger">
              <strong><?php echo $error; ?></strong>
            </div>
      <?php
          }
        }
        if(isset($loginMsg))
        {
      ?>
        <div class="alert alert-success">
          <strong>ÉXITO ! <?php echo $loginMsg; ?></strong>
        </div>
      <?php
      }
      ?>
      <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9 ">
          <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
              <div class="row">
                <div class="col-lg-6 d-none d-lg-block">
                  <img src="resources/images/BICAD_image.png" class="img-fluid" alt="">
                </div>
                <div class="col-lg-6">
                  <div class="p-5">
                    <div class="text-center">
                      <h1 class="h4 text-gray-900 mb-4">Bienvenido!</h1>
                    </div>
                    <form action="" method="post">
                      <div class="input-group form-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="bi bi-person-circle"></i></span>
                        </div>
                        <input type="text" name="txt_email" class="form-control" placeholder="Email">
                      </div>
                      <div class="input-group form-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="bi bi-key"></i></i></span>
                        </div>
                        <input type="password" name="txt_password" class="form-control" placeholder="Contraseña">
                      </div>
                      <div hidden class="form-group">
                        <div class="input-group-prepend">
                          <select class="form-control" name="txt_role">
                            <option value="usuario">Usuarios</option>
                          </select>
                        </div>
                      </div>
                      <center>
                        <div class="form-group">
                          <input type="submit" name="btn_login" class="btn btn-success w-50" value="Iniciar sesión">
                        <a href="index" class="btn btn-danger btn-block">Cancelar</a>
                        </div>
                      </center>
                    </form>
                    <div class="text-center mt-3">
                    <a class="small" href="register">Crear Una Nueva Cuenta!</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php include "elements/footer.php"; ?>
  </body>
</html>