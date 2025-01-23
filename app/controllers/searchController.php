<?php

	namespace app\controllers;
	use app\models\mainModel;

	class searchController extends mainModel{

		/*----------  Controlador iniciar Informe de Productos  ----------*/
		public function iniciarInformeProductoControlador(){

			//Se preparan los filtros de busqueda en caso que esten seleccionados
		    $url=$this->limpiarCadena($_POST['modulo_url']);
			if(!isset($_POST['txt_buscador'])){$texto=' ';}else{$texto = $_POST['txt_buscador'];}
			if(!isset($_POST['productoCategoriaFil'])){$categoria='';}else{$categoria = $_POST['productoCategoriaFil'];}
			if(!isset($_POST['productoStockFil'])){$stock='';}else{$stock = $_POST['productoStockFil'];}
			//INICIALIZAMOS la variable sesion en formato ARRAY que contiene los filtros de busqueda
			$_SESSION['AvanzadaProducto'] = [];
			// el ARRAY local con los filtros de busqueda
			$busqueda_avanzada = [$texto,$categoria,$stock];

			// print_r($busqueda_avanzada[2]);
			// exit();

			//CORROBORAMOS que el modulo de busqueda estee en la lista de permitidos
			if($this->modulosBusquedaControlador($url)){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No podemos procesar la petición en este momento",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
			}

			//CARGAMOS la variable sesion en formato ARRAY que contendra los filtros de busqueda
			$_SESSION['AvanzadaProducto']=$busqueda_avanzada;
			//Se guarda el texto ingresado en el primer filtro
			$_SESSION['texto']=$busqueda_avanzada[0];
			$_SESSION[$url]=$texto;

			//Redireccionamos a la url que viene como MODULO DEL POST
			$alerta=[
				"tipo"=>"redireccionar",
				"url"=>APP_URL.$url."/"
			];

			return json_encode($alerta);
		}
		/*----------  Controlador eliminar busqueda Productos ----------*/
		public function eliminarInformeProductoControlador(){

			//Recibimos la url que viene COMO MODULO DEL POST
			$url=$this->limpiarCadena($_POST['modulo_url']);

			//CORROBORAMOS que este modulo esta en la lista de permitidos
			if($this->modulosBusquedaControlador($url)){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No podemos procesar la petición en este momento",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
			}

			//DESTRUIMOS LAS SESIONES CON TODO EL CONTENIDO
			unset($_SESSION[$url]);
			unset($_SESSION['tablaProductos']);

			//REDIRECCIONAMOS A LA URL QUE VINO COMO MODULO DEL POST
			$alerta=[
				"tipo"=>"redireccionar",
				"url"=>APP_URL.$url."/"
			];

			return json_encode($alerta);
		}

/*------------------------------------------------------------------------------------------------------*/

		/*----------  Controlador modulos de busquedas LISTA DE MODULOS  ----------*/
		public function modulosBusquedaControlador($modulo){
			//Declaramos los modulos que vamos a permitir que hagan informes
			$listaModulos=['medicInform',
						   'productInform'];

			//Recorremos el array de permitidos buscando coincidencia con el que se recibió por parametro
			if(in_array($modulo, $listaModulos)){
				return false;
			}else{
				return true;
			}
		}

/*------------------------------------------------------------------------------------------------------*/

		/*----------  Controlador iniciar busqueda UNIVERSAL  ----------*/
		public function iniciarBuscadorControlador(){

		    $url=$this->limpiarCadena($_POST['modulo_url']);
			$texto=$this->limpiarCadena($_POST['txt_buscador']);

			if($this->modulosBusquedaControlador($url)){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No podemos procesar la petición en este momento",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
			}

			if($texto==""){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"Introduce un termino de busqueda",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
			}

			if($this->verificarDatos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}",$texto)){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El termino de busqueda no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
			}

			$_SESSION[$url]=$texto;

			$alerta=[
				"tipo"=>"redireccionar",
				"url"=>APP_URL.$url."/"
			];

			return json_encode($alerta);
		}

		/*----------  Controlador eliminar busqueda UNIVERSAL  ----------*/
		public function eliminarBuscadorControlador(){

			$url=$this->limpiarCadena($_POST['modulo_url']);

			if($this->modulosBusquedaControlador($url)){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No podemos procesar la petición en este momento",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
			}

			unset($_SESSION[$url]);

			$alerta=[
				"tipo"=>"redireccionar",
				"url"=>APP_URL.$url."/"
			];

			return json_encode($alerta);
		}

	}