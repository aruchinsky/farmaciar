<?php
    require_once "./config/app.php";
    require_once "./autoload.php";
    require_once "./app/views/inc/session_start.php";

    // preguntamos si viene una vista por el metodo GET
    if(isset($_GET['views'])){
        //EXPLODE = Funcion que divide una cadena en base a un caracter
        $url=explode("/",$_GET['views']);
    }else{
        // Si no viene niguna vista se asigna la vista LOGIN
        $url=["login"];
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <?php require_once "./app/views/inc/head.php"; ?>
</head>
<body class="sidebar-mini layout-navbar-fixed layout-fixed" style="height: auto;">
    <!-- Contenedor PRINCIPAL -->
    <div class="wrapper">

    <?php
        //LLamamos al CONTROLADOR de VISTAS
        use app\controllers\viewsController;
        //LLamamos al CONTROLADOR de LOGIN
        use app\controllers\loginController;  
        //Instanciamos el CONTROLADOR de LOGIN
        $insLogin = new loginController();
        //Instanciamos el CONTROLADOR de VISTAS
        $viewsController = new viewsController();
        //Llamamos al METODO para obtener VISTAS y pasamos como PARAMTERO
        // la url recibida
        $vista = $viewsController->obtenerVistasControlador($url[0]);

        //Validamos si viene login o 404 para cargar esas vistas
        if($vista=="login" || $vista=="404"){
            require_once "./app/views/content/".$vista."-view.php";
        }else{

            //Con ISSET preguntamos si la variable session ID esta iniciada.
            // En caso que no este iniciada significa que no iniciaron sesion
            // entonces cerramos el sistema y redireccionamos al LOGIN
            if(!isset($_SESSION['id']) || !isset($_SESSION['usuario']) || $_SESSION['id']==""
            || $_SESSION['usuario']==""){
                $insLogin->cerrarSesionControlador();
                exit();
            }

            //Incluimos la barra de navegacion junto con la vista

            // VALIDACION DE TIPOS DE USUARIO
            // 1 Administrador
            // 2 Normal
            if($_SESSION['idTipoUsuario']==1){
                require_once "./app/views/inc/navbar.php";
                require_once $vista;
            }else{
                require_once "./app/views/inc/navbar2.php";
                require_once $vista;
            }

        }
            require_once "./app/views/inc/script.php";

    ?>

    </div>
    <!-- /Contenedor PRINCIPAL -->
</body>
</html>