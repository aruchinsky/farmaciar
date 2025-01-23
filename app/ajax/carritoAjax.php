<?php

    // Contiene el nombre de la aplicacion y de la sesion
    require_once "../../config/app.php";
    // Contiene el inicio de la sesion junto con el nombre de la sesion
    require_once "../views/inc/session_start.php";
    // Contiene la funcion de AUTOLOAD
    require_once "../../autoload.php";
    // LLamamos al controlador
    use app\controllers\productController;

    //Verificamos si viene definida el MODULO DE FORMULARIO para poder empezar
    if(isset($_POST['modulo_carrito'])){
        //Instanciamos un objeto de tipo CONTROLADOR
        $insProduct = new productController();

        //Preguntamos que METODO vamos a utilizar: / registrar / actualizar / eliminar

        if($_POST['modulo_carrito']=="agregar_carrito"){
            //LLamamos al METODO para AGERGAR AL CARRITO - > Tambien dicho CONTROLADOR
            echo $insProduct->agregarCarritoProductoControlador();
        }

        if($_POST['modulo_carrito']=="registrar"){
            //LLamamos al METODO para REGISTRAR - > Tambien dicho CONTROLADOR
            echo $insProduct->registrarProductoControlador();
        }

        if($_POST['modulo_carrito']=="eliminar"){
            //LLamamos al METODO para ELIMINAR - > Tambien dicho CONTROLADOR
            echo $insProduct->eliminarCarritoProductoControlador();
        }

        if($_POST['modulo_carrito']=="confirmar_pedido"){
            //LLamamos al METODO para CONFIRMAR PEDIDO DE COMPRA
            //echo $insProduct->confirmarCarritoPedidoControlador();
        }



    }else{
        //Si no viene definido el MODULO DE FORMULARIO significa que se esta accediendo
        // a traves de la URL por eso DESTRUIMOS LA SESION y REDIRECCIONAMOS
        session_destroy();
        header("Location: ".APP_URL."login/");
    }


?>