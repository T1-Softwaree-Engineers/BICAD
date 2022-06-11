<?php
session_start();
global $correo;
$correo = $_SESSION['usuario_login'];

if(!isset($_SESSION["usuario_login"]))  //Condicion Usuarios
{
header("location: login");
}
?>
<?php
	require_once "conn.php";

	if(isset($_REQUEST['btn_register'])) //compruebe el nombre del botón "btn_register" y configúrelo
	{
		$nombre 	= $_REQUEST['txt_nombre'];
		$apellidos 	= $_REQUEST['txt_apellidos'];
		$edad		= $_REQUEST['txt_edad'];	//input nombre "txt_email"
		$genero	    = $_REQUEST['txt_genero'];
		$contacto 	= $_REQUEST['txt_contacto'];

		if(empty($nombre))
		{
			$errorMsg[]="Ingrese su nombre";	//Revisar email input no vacio
		}
		else if(empty($apellidos))
		{
			$errorMsg[]="Este campo es obligatorio.";	//Revisar email input no vacio
		}
		else if(empty($edad))
		{
			$errorMsg[]="Ingrese edad";	//Revisar email input no vacio
		}
		else if(empty($genero))
		{
			$errorMsg[]="Este campo es obligatorio.";	//Revisar email input no vacio
		}
		else if(empty($contacto))
		{
			$errorMsg[]="Ingrese contacto";	//Revisar password vacio o nulo
		}
		else
		{	
			try
			{	
				$select_stmt=$db->prepare("SELECT ecuidador FROM adultosm WHERE ecuidador=:uemail"); // consulta sql  
				$select_stmt->bindParam(":uemail",$correo);      //parámetros de enlace
				$select_stmt->execute();
				$row=$select_stmt->fetch(PDO::FETCH_ASSOC);	

				if($row["ecuidador"] == $correo)
				{
                    echo("<script>alert('Ya tienes un adulto registrado')</script>");	//Verificar email existente
                }
                
				else if(!isset($errorMsg["error"]))
				{
					$insert_stmt=$db->prepare("INSERT INTO adultosm(ecuidador,nombre,apellido,edad,genero,contacto) VALUES(:ecuidador, :unombre,:uapellidos,:uedad,:ugenero,:ucontacto)"); //Consulta sql de insertar
					$insert_stmt->bindParam(":ecuidador",$correo);
                    $insert_stmt->bindParam(":unombre",$nombre);
					$insert_stmt->bindParam(":uapellidos",$apellidos);
                    $insert_stmt->bindParam(":uedad",$edad);
                    $insert_stmt->bindParam(":ugenero",$genero);
                    $insert_stmt->bindParam(":ucontacto",$contacto);
					if($insert_stmt->execute())
					{
						echo("<script>alert('Registro exitoso')</script>"); //Ejecuta consultas 
						header("refresh:1;dashboard"); //Actualizar despues de 2 segundo a la portada
					}
				}
			}
			catch(PDOException $e)
			{
				echo $e->getMessage();
			}
		}
	}

    if(isset($_REQUEST['btn_actualizar'])) //compruebe el nombre del botón "btn_register" y configúrelo
	{
		$nombre 	= $_REQUEST['txt_nombre'];
		$apellidos 	= $_REQUEST['txt_apellidos'];
		$edad		= $_REQUEST['txt_edad'];	//input nombre "txt_email"
		$genero	    = $_REQUEST['txt_genero'];
		$contacto 	= $_REQUEST['txt_contacto'];

		if(empty($nombre))
		{
			$errorMsg[]="Ingrese su nombre";	//Revisar email input no vacio
		}
		else if(empty($apellidos))
		{
			$errorMsg[]="Este campo es obligatorio.";	//Revisar email input no vacio
		}
		else if(empty($edad))
		{
			$errorMsg[]="Ingrese edad";	//Revisar email input no vacio
		}
		else if(empty($genero))
		{
			$errorMsg[]="Este campo es obligatorio.";	//Revisar email input no vacio
		}
		else if(empty($contacto))
		{
			$errorMsg[]="Ingrese contacto";	//Revisar password vacio o nulo
		}
		else
		{	
			try
			{	
				$select_stmt=$db->prepare("SELECT ecuidador FROM adultosm WHERE ecuidador=:uemail"); // consulta sql  
				$select_stmt->bindParam(":uemail",$correo);      //parámetros de enlace
				$select_stmt->execute();
				$row=$select_stmt->fetch(PDO::FETCH_ASSOC);	

				if($row["ecuidador"] == $correo)
				{
                    $update_stmt=$db->prepare("UPDATE adultosm SET nombre='$nombre', apellido='$apellidos', edad=$edad, genero='$genero', contacto='$contacto' WHERE ecuidador='$correo' "); //Consulta sql de actualizar
                    //$update_stmt->bindParam(":unombre",$nombre);
					//$insert_stmt->bindParam(":uapellidos",$apellidos);
                    //$insert_stmt->bindParam(":uedad",$edad);
                    //$insert_stmt->bindParam(":ugenero",$genero);
                    //$insert_stmt->bindParam(":ucontacto",$contacto);
					if($update_stmt->execute())
					{
						echo("<script>alert('Datos Actualizados exitosamente')</script>"); //Ejecuta consultas 
						header("refresh:1;dashboard"); //Actualizar despues de 2 segundo a la portada
                    //echo("<script>alert('Ya tienes un adulto registrado')</script>");	//Verificar email existente
                }
                
				else if(!isset($errorMsg["error"]))
				{
					
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
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <?php include "elements/header.php"; ?>
    <title>BICAD - Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="public/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="public/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">


        <style type="text/css">
        #estilo{
            width:150px;
            display:table-cell;
        }
        </style>

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <a class="nav-link active" href="./dashboard"><img src="./public/img/bicadlogo.png" class="img-fluid" alt="Responsive image" width="300px"></a>
                    <!-- Sidebar Toggle (Topbar) -->
 
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        


                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $correo ?></span>
                                <img class="img-profile rounded-circle"
                                    src="public/img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400">&nbsp;</i>
                                    <?php echo $correo; ?>
                                </a>
                                
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Cerrar sesión
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Hola! Usuario</h1>
                        <button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#modalRegistrar">
                            <i class="bi bi-person-plus-fill"></i> Registrar el Usuario BICAD</a>
                    </div>

                    <!-- Button trigger modal -->

                            <!-- Modal -->
                            <div class="modal fade" id="modalRegistrar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Registrar un Usuario BICAD</h5>
                                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form aaction="" method="post">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="estilo">Nombres:</span>
                                        <input type="text" name="txt_nombre" class="form-control" placeholder="Nombres del usuario BICAD" name="nombres" aria-label="Nombres" aria-describedby="basic-addon1">
                                    </div>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="estilo">Apellidos:</span>
                                        <input type="text" name="txt_apellidos" class="form-control" placeholder="Apellidos del usuario BICAD" name="apellidos"aria-label="Apellidos" aria-describedby="basic-addon1">
                                    </div>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="estilo">Edad:</span>
                                        <input type="text" name="txt_edad" class="form-control" placeholder="Edad del usuario BICAD" name="edad" aria-label="Edad" aria-describedby="basic-addon1">
                                    </div>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="estilo">Género:</span>
                                        <select class="form-select" name="txt_genero" aria-label="Default select example" name="genero" aria-describedby="basic-addon">
                                            <option selected>Menu de opciones de genero:</option>
                                            <option value="Hombre">Hombre</option>
                                            <option value="Mujer">Mujer</option>
                                            <option value="Indefinido">Prefiero no definirlo</option>
                                        </select>
                                    </div>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="estilo">Contacto:</span>
                                        <input type="text" name="txt_contacto" class="form-control" placeholder="Contacto de emergencia del usuario BICAD" name="contacto" aria-label="Contacto" aria-describedby="basic-addon1">
                                    </div>
                                    <div class="modal-footer">
                                    <!-- <button type="button" class="btn btn-primary" name="guardarusuario">Guardar Usuarios</button> -->
                                        <input type="submit" name="btn_register" class="btn btn-primary" value="Registro">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                </div>
                                    </form>
                                </div>

                                </div>
                            </div>
                            </div>

                            <?php 
                                    $miconexion = mysqli_connect("localhost", "root", "", "bicad");
                                    $query="SELECT ecuidador,nombre, apellido, edad, genero, contacto FROM adultosm WHERE ecuidador = '$correo'";
                                    if($result_contenido = mysqli_query($miconexion,$query))
                                    {
                                    if($row=mysqli_fetch_array($result_contenido))
                                    {
                            ?> 

                            <!--Modal Editar-->
                            <div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Editar Datos del Usuario BICAD</h5>
                                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form aaction="" method="post">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="estilo">Nombres:</span>
                                        <input type="text" name="txt_nombre" class="form-control" placeholder="Nombres del usuario BICAD" name="nombres" aria-label="Nombres" aria-describedby="basic-addon1" value="<?php echo $row['nombre'] ?>">
                                    </div>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="estilo">Apellidos:</span>
                                        <input type="text" name="txt_apellidos" class="form-control" placeholder="Apellidos del usuario BICAD" name="apellidos"aria-label="Apellidos" aria-describedby="basic-addon1" value="<?php echo $row['apellido'] ?>">
                                    </div>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="estilo">Edad:</span>
                                        <input type="text" name="txt_edad" class="form-control" placeholder="Edad del usuario BICAD" name="edad" aria-label="Edad" aria-describedby="basic-addon1" value="<?php echo $row['edad'] ?>">
                                    </div>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="estilo">Género:</span>
                                        <select class="form-select" name="txt_genero" aria-label="Default select example" name="genero" aria-describedby="basic-addon">
                                            <option selected><?php echo $row['genero'] ?></option>
                                            <option value="Hombre">Hombre</option>
                                            <option value="Mujer">Mujer</option>
                                            <option value="Indefinido">Prefiero no definirlo</option>
                                        </select>
                                    </div>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="estilo">Contacto:</span>
                                        <input type="text" name="txt_contacto" class="form-control" placeholder="Contacto de emergencia del usuario BICAD" name="contacto" aria-label="Contacto" aria-describedby="basic-addon1" value="<?php echo $row['contacto'] ?>">
                                    </div>
                                    <div class="modal-footer">
                                    <!-- <button type="button" class="btn btn-primary" name="guardarusuario">Guardar Usuarios</button> -->
                                        <input type="submit" name="btn_actualizar" class="btn btn-success" value="Actualizar">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                </div>
                                    </form>
                                </div>

                                </div>
                            </div>
                            </div>
                            <?php
                                    }
                                    }
                                    ?> 

                    <!-- Content Row -->

                     <!-- Content Row -->

                     <div class="row">
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-dark">Localizacion en tiempo real</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                            aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Dropdown Header:</div>
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="ratio ratio-16x9">
                                    <iframe frameborder="0" src="https://stem.ubidots.com/app/dashboards/public/widget/SLGmrhI69DyR1g7uWa2uQo9ipCDZzblQIxrJ8hzWaxk?embed=true"></iframe>
                                        </div>      
                                </div>
                            </div>
                        </div>
                            <div class="col-xl-4">
                                <div class="card shadow mb-4"> 
                                <div
                                    class="card-header py-3 align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-dark">Notificaciones</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <ol class="list-group">
                                    <li class="list-group-item d-flex justify-content-between align-items-start">
                                        <div class="ratio" style="--bs-aspect-ratio: 10%;">
                                        <iframe frameborder="0" src="https://stem.ubidots.com/app/dashboards/public/widget/MGqiO16RCVCiLUG9xkIAfYjA2f5RMmBql5Or_tLgkes?embed=true"></iframe></iframe>
                                        </div>  
                                    </li>
                                    </ol>     
                                </div>

                                </div>
                                <div class="card shadow mb-4"> 
                                    <div class="card-header py-3 align-items-center justify-content-between">
                                        <span><b>Datos del usuario BICAD</b></span>
                                        <button class="btn btn-link" data-toggle="modal" data-target="#modalEditar"><i class="bi bi-pencil-fill"></i></button>
                                    </div>
                                <div class="card-body">
                                <?php 
                                    $miconexion = mysqli_connect("localhost", "root", "", "bicad");
                                    $query="SELECT ecuidador,nombre, apellido, edad, genero, contacto FROM adultosm WHERE ecuidador = '$correo'";
                                    if($result_contenido = mysqli_query($miconexion,$query))
                                    {
                                    if($row=mysqli_fetch_array($result_contenido))
                                    {
                                    ?> 
                                <ul class="list-group pt-2 pb-4">
                                    <li class="list-group-item">Nombres: <?php echo $row['nombre'] ?></li>
                                    <li class="list-group-item">Apellidos: <?php echo $row['apellido'] ?></li>
                                    <li class="list-group-item">Edad: <?php echo $row['edad'] ?></li>
                                    <li class="list-group-item">Genero: <?php echo $row['genero'] ?></li>
                                    <li class="list-group-item">Contacto de emergencias: <?php echo $row['contacto'] ?></li>
                                    </ul>
                                </div>
                                <?php
                                    }
                                    }
                                    ?>       
                            </div>
        
                        <!-- Pie Chart -->
                     </div>

                     
                     <!-- <div class="row">
                        <div class="col-xl-6 col-lg-5">
                            <div class="card shadow mb-4">
                                 Card Header - Dropdown 
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-dark">Calorias</h6>
                                    
                                </div>
                                 Card Body 
                                <div class="card-body">
                                    <div class="chart-pie pt-4 pb-2">
                                        <canvas id="myPieChart"></canvas>
                                    </div>
                                
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-5">
                            <div class="card shadow mb-4">
                                 Card Header - Dropdown 
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-dark">Pasos</h6>
                                    
                                </div>
                                 Card Body 
                                <div class="card-body">
                                    <div class="chart-pie pt-4 pb-2">
                                        <canvas id="myPieChart2"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>-->

                       

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; BICAD 2022</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Salir</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">¿Estás seguro de que quieres salir?</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <a class="btn btn-primary" href="logout">Cerrar sesión</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="public/vendor/jquery/jquery.min.js"></script>
    <script src="public/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="public/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="public/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="public/vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="public/js/demo/chart-area-demo.js"></script>
    <script src="public/js/demo/chart-pie-demo.js"></script>


     <!-- SCRIPT PARA TRABAJAR EN FIREBASE -->

     <script type="module">
    // Import the functions you need from the SDKs you need
    import { initializeApp } from "https://www.gstatic.com/firebasejs/9.6.11/firebase-app.js";
    // TODO: Add SDKs for Firebase products that you want to use
    // https://firebase.google.com/docs/web/setup#available-libraries

    // Your web app's Firebase configuration
    const firebaseConfig = {
        apiKey: "AIzaSyDD003s4F8aJT6R1O-ZU0TQyZgL5OMxwj4",
        authDomain: "bicad-eb497.firebaseapp.com",
        projectId: "bicad-eb497",
        storageBucket: "bicad-eb497.appspot.com",
        messagingSenderId: "881644924077",
        appId: "1:881644924077:web:f8f5574e7242f4c9c82a24"
    };

    // Initialize Firebase
    const app = initializeApp(firebaseConfig);
    
    </script>


</body>

</html>