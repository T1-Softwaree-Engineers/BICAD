<?php
  session_start();
  if(isset($_SESSION["usuario_login"]))  //Condicion Usuarios
  {
    header("location: index.php");
  }
?>

<?php
  require_once "conn.php";
  if(isset($_REQUEST['btn_register'])) //compruebe el nombre del botón "btn_register" y configúrelo
  {
    $username = $_REQUEST['txt_username'];  //input nombre "txt_username"
    $nombre   = $_REQUEST['txt_nombre'];
    $apellidos  = $_REQUEST['txt_apellidos'];
    $email    = $_REQUEST['txt_email']; //input nombre "txt_email"
    $contacto   = $_REQUEST['txt_contacto'];
    $password = $_REQUEST['txt_password'];
    $password = hash('sha512', $password);
    $role   = $_REQUEST['txt_role'];  //seleccion nombre "txt_role"
    if(empty($username))
    {
      $errorMsg[]="Ingrese nombre de usuario";  //Compruebe input nombre de usuario no vacío
    }
    else if(empty($nombre))
    {
      $errorMsg[]="Ingrese su nombre";  //Revisar email input no vacio
    }
    else if(empty($apellidos))
    {
      $errorMsg[]="Este campo es obligatorio."; //Revisar email input no vacio
    }
    else if(empty($email))
    {
      $errorMsg[]="Ingrese email";  //Revisar email input no vacio
    }
    else if(empty($contacto))
    {
      $errorMsg[]="Este campo es obligatorio."; //Revisar email input no vacio
    }
    else if(!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
      $errorMsg[]="Ingrese email válido"; //Verificar formato de email
    }
    else if(empty($password))
    {
      $errorMsg[]="Ingrese password"; //Revisar password vacio o nulo
    }
    else if(strlen($password) < 6)
    {
      $errorMsg[] = "Password minimo 6 caracteres"; //Revisar password 6 caracteres
    }
    else if(empty($role))
    {
      $errorMsg[]="Seleccione rol"; //Revisar etiqueta select vacio
    }
    else
    { 
      try
      { 
        $select_stmt=$db->prepare("SELECT username, email FROM usuarios WHERE username=:uname OR email=:uemail"); // consulta sql
        $select_stmt->bindParam(":uname",$username);   
        $select_stmt->bindParam(":uemail",$email);      //parámetros de enlace
        $select_stmt->execute();
        $row=$select_stmt->fetch(PDO::FETCH_ASSOC); 

        while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) 
        {
          $row['username'];
          $row['email'];
        }
        
        if(!isset($errorMsg))
        {
          $insert_stmt=$db->prepare("INSERT INTO usuarios(username,nombre,apellidos,email,contacto,pwd,role) VALUES(:uname,:unombre,:uapellidos,:uemail,:ucontacto,:upassword,:urole)"); //Consulta sql de insertar
          $insert_stmt->bindParam(":uname",$username);
          $insert_stmt->bindParam(":unombre",$nombre);
          $insert_stmt->bindParam(":uapellidos",$apellidos);  
          $insert_stmt->bindParam(":uemail",$email);
          $insert_stmt->bindParam(":ucontacto",$contacto);        //parámetros de enlace 
          $insert_stmt->bindParam(":upassword",$password);
          $insert_stmt->bindParam(":urole",$role);
          if($insert_stmt->execute())
          {
            $registerMsg="Registro exitoso: redirigiendo al dashboard..."; //Ejecuta consultas 
            header("refresh:2; index.php"); //Actualizar despues de 2 segundo a la portada
          }
        }
      }
      catch(PDOException $e)
      {
        echo $e->getMessage();
      }
    }
  }
?>
<!doctype html>
<html lang="en">
  <head>
    <?php include "elements/header.php"; ?>
    <title>Registro</title>
  </head>
  <body class="bg-primary">
    <?php
      if(isset($errorMsg))
      {
        foreach($errorMsg as $error)
        {
        ?>
          <div class="alert alert-danger">
            <strong>INCORRECTO ! <?php echo $error; ?></strong>
          </div>
              <?php
        }
      }
      if(isset($registerMsg))
        {
        ?>
          <div class="alert alert-success">
            <strong>EXITO ! <?php echo $registerMsg; ?></strong>
          </div>
            <?php
        }
      ?> 
      <div class="container">
        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
          <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-5 d-none d-lg-block">
                <img src="resources/images/bicadlogo.png" alt="" class="img-fluid" style="object-fit: contain; width: 100%; height: 100%;">
              </div>
              <div class="col-lg-7">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Registro</h1>
                  </div>      
                  <form method="post" class="form-horizontal">
                    <!---->
                    <div class="form-group pb-2">
                      <label class="col-sm-9 text-left">Usuario</label>
                      <div class="col-sm-12">
                        <input type="text" name="txt_username" class="form-control" placeholder="Ingrese usuario" required/>
                      </div>
                    </div>
                    <!---->
                    <div class="form-group">
                      <label class="col-sm-9 text-left">Nombre</label>
                      <div class="col-sm-12">
                        <input type="text" name="txt_nombre" class="form-control" placeholder="Ingrese el nombre del validador" required />
                      </div>
                    </div>
                    <!---->
                    <div class="form-group pb-2">
                      <label class="col-sm-9 text-left">Apellidos</label>
                      <div class="col-sm-12">
                        <input type="text" name="txt_apellidos" class="form-control" placeholder="Ingrese apellidos" required />
                      </div>
                    </div>
                    <!---->
                    <div class="form-group pb-2">
                      <label class="col-sm-9 text-left">Email</label>
                      <div class="col-sm-12">
                        <input type="text" name="txt_email" class="form-control" placeholder="Ingrese email" />
                      </div>
                    </div>
                    <!---->
                    <div class="form-group pb-2">
                      <label class="col-sm-9 text-left">Celular</label>
                      <div class="col-sm-12">
                        <input type="text" name="txt_contacto" class="form-control" placeholder="Número telefónico/celular" maxlength="10" />
                      </div>
                    </div>
                    <!---->
                    <div class="form-group pb-2">
                      <label class="col-sm-9 text-left">Password</label>
                      <div class="col-sm-12">
                        <input type="password" name="txt_password" class="form-control" placeholder="Ingrese password" />
                      </div>
                    </div>
                    <!---->
                    <div hidden class="form-group pb-2">
                      <label class="col-sm-9 text-left">Seleccione tipo</label>
                      <div class="col-sm-12">
                        <select class="form-control" name="txt_role">
                          <option value="usuario">Usuario</option>
                        </select>
                      </div>
                    </div>
                    <!---->
                    <div class="form-group pb-3">
                      <div class="col-sm-12">
                        <input type="submit" name="btn_register" class="btn btn-primary btn-block" value="Registrar">
                        <a href="index" class="btn btn-danger btn-block">Cancelar</a>
                      </div>
                    </div>
                    <!---->
                  </form> 
                  <div class="text-center">
                    <a class="small" href="login">Ya tienes cuenta? Inicia Sesion!</a>
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