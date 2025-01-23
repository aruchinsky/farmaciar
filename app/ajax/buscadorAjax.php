<?php
	
	require_once "../../config/app.php";
	require_once "../views/inc/session_start.php";
	require_once "../../autoload.php";
	
	use app\controllers\searchController;

	//PREGUNTAMOS SI SE RECIBIO ALGUN MODULO DE BUSQUEDA
	if(isset($_POST['modulo_buscador'])){

		//INSTANCIAMOS EL CONTROLADOR DE BUSQUEDA
		$insBuscador = new searchController();

		//PREGUNTAMOS SI SE ESTA INICIANDO LA BUSQUEDA
		if($_POST['modulo_buscador']=="buscar"){
			//PREGUNTAMOS SI LA BUSQUEDA ES SOBRE PRODUCTOS
			if($_POST['modulo_entidad']=="producto"){
				echo $insBuscador->iniciarInformeProductoControlador();
			}
		}
		//PREGUNTAMOS SI SE ESTA ELIMINANDO LA BUSQUEDA
		if($_POST['modulo_buscador']=="eliminar"){
			//PREGUNTAMOS SI LA ELIMINACION DE BUSQUEDA ES SOBRE PRODUCTOS
			if($_POST['modulo_entidad']=="producto"){
				echo $insBuscador->eliminarInformeProductoControlador();
			}
		}
	
	}else{
		//SI SE LLEGO AQUI DE MANERA ERRONEA SE CIERRA SESION EN EL SISTEMA
		// Y SE REDIRIGE AL LOGIN
		session_destroy();
		header("Location: ".APP_URL."login/");
	}