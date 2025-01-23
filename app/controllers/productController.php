<?php
    namespace app\controllers;
    use app\models\mainModel;
    use \PDOException;

class productController extends mainModel{

            //CONTROLADOR PARA REGISTRAR 
            public function registrarProductoControlador(){

                //ALmacenando los datos que vienen de la vista
                //Producto
                $nombre = $this->limpiarCadena($_POST['nombre']);
                $descripcion = $this->limpiarCadena($_POST['descripcion']);
                $precio = $this->limpiarCadena($_POST['precio']);
                $imagen = $this->limpiarCadena($_POST['imagen']);
                $categoria = $this->limpiarCadena($_POST['categoria']);
                $stock = $this->limpiarCadena($_POST['stock']);
    
                //Verificando campos obligatorios
                if($nombre=="" || $descripcion=="" || $precio=="" || 
                    $categoria==0 || $stock=="" || $imagen==""){
                    //Definimos todo los valores de un array para la alerta
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Ocurrió un error inesperado",
                        "texto" => "No has completado todos los datos que son obligatorios.",
                        "icono" => "error",
    
                    ];
                    //Devolvemos el array codificado en JSON
                    return json_encode($alerta);
                    exit();
                }
    
                //Verificando la integridad de los datos
                if($this->verificarDatos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{3,100}",$nombre)){
                    //Definimos todo los valores de un array para la alerta
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Ocurrió un error inesperado",
                        "texto" => "El nombre no coincide con el formato solicitado",
                        "icono" => "error",
    
                    ];
                    //Devolvemos el array codificado en JSON
                    return json_encode($alerta);
                    exit();
                }
                if($this->verificarDatos("[0-9]{4,10}",$precio)){
                    //Definimos todo los valores de un array para la alerta
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Ocurrió un error inesperado",
                        "texto" => "El precio no coincide con el formato solicitado",
                        "icono" => "error",
    
                    ];
                    //Devolvemos el array codificado en JSON
                    return json_encode($alerta);
                    exit();
                }
                if($this->verificarDatos("[0-9]{1,200}",$stock)){
                    //Definimos todo los valores de un array para la alerta
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Ocurrió un error inesperado",
                        "texto" => "El stock no coincide con el formato solicitado",
                        "icono" => "error",
    
                    ];
                    //Devolvemos el array codificado en JSON
                    return json_encode($alerta);
                    exit();
                }
    
                try{
                    // Cargamos el array que se va a insertar
                    $producto_datos_reg=[
                        [
                            "campo_nombre"=>"nombre",
                            "campo_marcador"=>":Nombre",
                            "campo_valor"=>$nombre
                        ],
                        [
                            "campo_nombre"=>"descripcion",
                            "campo_marcador"=>":Descripcion",
                            "campo_valor"=>$descripcion
                        ],
                        [
                            "campo_nombre"=>"precio",
                            "campo_marcador"=>":Precio",
                            "campo_valor"=>$precio
                        ],
                        [
                            "campo_nombre"=>"imagen_url",
                            "campo_marcador"=>":ImagenUrl",
                            "campo_valor"=>$imagen
                        ],
                        [
                            "campo_nombre"=>"id_categorias",
                            "campo_marcador"=>":IdCategorias",
                            "campo_valor"=>$categoria
                        ],
                        [
                            "campo_nombre"=>"stock",
                            "campo_marcador"=>":Stock",
                            "campo_valor"=>$stock
                        ],
                        [
                            "campo_nombre"=>"flag_mostrar",
                            "campo_marcador"=>":FlagMostrar",
                            "campo_valor"=>1
                        ]
                    ];
                    // 1-2. Registramos los datos de contactos
                    $registrar_producto=$this->guardarDatos("productos",$producto_datos_reg);
    
                }catch(PDOException $exc){
                    $mensaje_error =  $exc->getMessage();
                    $alerta=[
                        "tipo"=>"simple",
                        "titulo"=>"Ocurrió un error inesperado",
                        "texto"=>$exc,
                        "icono"=>"error"
                    ];
                    return json_encode($alerta);
                    exit();  
                }
    
                if($registrar_producto->rowCount()==1){
                     $alerta=[
                         "tipo"=>"limpiar",
                         "titulo"=>"Producto registrado",
                         "texto"=>"El producto ".$nombre." se registro con exito",
                         "icono"=>"success"
                     ];
                }else{
    
                     $alerta=[
                         "tipo"=>"simple",
                         "titulo"=>"Ocurrió un error inesperado",
                         "texto"=>"No se pudo registrar el producto, por favor intente nuevamente",
                        "icono"=>"error"
                     ];
                }
    
                 return json_encode($alerta);
            }

            //Controlador para LISTA DE PRODUCTOS
            public function listarProductoHomeControlador(){
                //Creamos la variable que contendra el resultado
                $tabla = '';
                //Generamos la consulta SQL
                $sql = "SELECT p.id idProductos, c.id idCategorias, p.imagen_url, p.nombre, p.descripcion,
                            p.precio, c.descripcion Categoria 
                        FROM productos p
                        JOIN categorias c
                        ON c.id = p.id_categorias
                        WHERE p.stock >= 1 AND p.flag_mostrar = 1";
                //Ejecutamos la consulta
                $datos = $this->ejecutarConsulta($sql);
                //con fetchAll formateamos a filas nuestro resultado
                $datos = $datos->fetchAll();
                //Recorremos las filas y vamos cargando la variable tabla con los resultados
                foreach($datos as $rows){
                        $tabla.='

                            <div class="col">
                                <div class="card h-100">
                                    <a href="'.APP_URL."productDetalle/".$rows['idProductos']."/".'">
                                        <img class="bd-placeholder-img card-img-top" 
                                            src="'.$rows['imagen_url'].'"  
                                            alt="Descripción de la imagen" 
                                            width="100%" 
                                            height="180" 
                                            style="object-fit: cover;">
                                    </a>

                                    <div class="card-body">
                                        <h5 class="card-title">'.$rows['nombre'].'</h5>
                                        <p class="card-text">$ '.$rows['precio'].'</p>
                                        <form class="FormularioAjax" action="'.APP_URL.'app/ajax/carritoAjax.php" method="post">
                                            <input type="hidden" name="modulo_carrito" value="agregar_carrito">
                                            <input type="hidden" name="producto_id" value="'.$rows['idProductos'].'">
                                            <button type="submit" class="btn btn-primary">
                                                Agregar al Carrito
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        ';
                }
                //Enviamos a la vista los resultados
                return $tabla;
            }

            //Controlador para LISTA DE PRODUCTOS DATATABLES
            public function listarProductoControlador(){
                //Creamos la variable que contendra el resultado
                $tabla ='';

                //Generamos la consulta SQL
                $sql = "SELECT p.id idProducto, c.id idCategorias, p.imagen_url, p.nombre, p.descripcion,
                            p.precio, p.stock, c.descripcion Categoria 
                        FROM productos p
                        JOIN categorias c
                        ON c.id = p.id_categorias
                        WHERE p.flag_mostrar = 1";
                //Ejecutamos la consulta
                $datos = $this->ejecutarConsulta($sql);
                //con fetchAll formateamos a filas nuestro resultado
                $datos = $datos->fetchAll();

                //Cargamos la estructura de la tabla
                $tabla = '<table id="productos" class="table display">
                            <thead> 
                                <tr> 
                                    <td>Nombre</td> 
                                    <td>Descripcion</td>
                                    <td>Categoria</td>
                                    <td>Precio</td>
                                    <td>Stock</td>
                                    <td>Editar</td>
								    <td>Eliminar</td>  
                                </tr> 
                            </thead> 
                            <tbody>';
                //Recorremos las filas y vamos cargando la variable tabla con los resultados
                foreach($datos as $rows){

                        $tabla.='
                                <tr>
                                    <td>'.$rows['nombre'].'</td>
                                    <td>'.$rows['descripcion'].'</td>
                                    <td>'.$rows['Categoria'].'</td>
                                    <td>'.$rows['precio'].'</td>
                                    <td>'.$rows['stock'].'</td>
                                    <td>
                        			    <a href="'.APP_URL."productUpdate/".$rows['idProducto']."/".'" class="btn btn-sm btn-primary">
                            			    <i class="fas fa-edit"></i> 
                        			    </a>
                    			    </td>
								    <td>
                                        <form class="FormularioAjax" action="'.APP_URL.'app/ajax/productAjax.php" method="post" autocomplete="off">
                                            <input type="hidden" name="modulo_producto" value="eliminar">
                                            <input type="hidden" name="producto_id" value="'.$rows['idProducto'].'">
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                        ';

                }                        
                //Cerramos la estructura de la tabla
                $tabla.= '                            
                            </tbody>
                        </table>
                        ';
                    
                //Enviamos a la vista los resultados
                return $tabla;
            }

            //Controlador para LISTA DE PRODUCTOS FILTRADO POR CATEGORIA
            public function listarProductoFiltradoControlador($idProducto){
                //Guardamos el id recibido por parametro
                $id = $idProducto;
                //Creamos la variable que contendra el resultado
                $tabla = '';
                //Generamos la consulta SQL
                $sql = "SELECT p.id idProductos, c.id idCategorias, p.imagen_url, p.nombre, p.descripcion,
                            p.precio, c.descripcion Categoria 
                        FROM productos p
                        JOIN categorias c
                        ON c.id = p.id_categorias
                        WHERE p.stock >= 1 AND p.flag_mostrar = 1 AND c.id = $id";
                //Ejecutamos la consulta
                $datos = $this->ejecutarConsulta($sql);
                //con fetchAll formateamos a filas nuestro resultado
                $datos = $datos->fetchAll();
                //Recorremos las filas y vamos cargando la variable tabla con los resultados
                foreach($datos as $rows){
                        $tabla.='

                            <div class="col">
                                <div class="card h-100">
                                    <a href="'.APP_URL."productDetalle/".$rows['idProductos']."/".'">
                                        <img class="bd-placeholder-img card-img-top" 
                                            src="'.$rows['imagen_url'].'"  
                                            alt="Descripción de la imagen" 
                                            width="100%" 
                                            height="180" 
                                            style="object-fit: cover;">
                                    </a>

                                    <div class="card-body">
                                        <h5 class="card-title">'.$rows['nombre'].'</h5>
                                        <p class="card-text">$ '.$rows['precio'].'</p>
                                        <form class="FormularioAjax" action="'.APP_URL.'app/ajax/carritoAjax.php" method="post">
                                            <input type="hidden" name="modulo_carrito" value="agregar_carrito">
                                            <input type="hidden" name="producto_id" value="'.$rows['idProductos'].'">
                                            <button type="submit" class="btn btn-primary">
                                                Agregar al Carrito
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        ';
                }
                //Enviamos a la vista los resultados
                return $tabla;
            }

            //Controlador para AGREGAR PRODUCTO AL CARRITO
            public function agregarCarritoProductoControlador(){

                //Guardamos el ID del producto
                $id = $this->limpiarCadena($_POST['producto_id']);

                //Traer los datos del producto
			    $datos = $this->ejecutarConsulta("SELECT *
                                            FROM productos
                                            WHERE id ='$id'");

                if($datos->rowCount()<=0){
                    //Definimos todo los valores de un array para la alerta
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Ocurrió un error inesperado",
                        "texto" => "No hemos encontrado el producto!",
                        "icono" => "error",
    
                    ];
                    //Devolvemos el array codificado en JSON
                    return json_encode($alerta);
                    exit();
                }else{
                    //Damos formato de una ROW - FILA
                    $datos = $datos->fetch();

                    // Verificamos si el producto ya existe en el carrito
                    $productoEncontrado = false;

                    foreach ($_SESSION['productosCarrito'] as &$producto) {
                        if ($producto['id'] == $id) {
                            // Si ya existe, aumentamos la cantidad
                            $producto['cantidad']++;
                            $productoEncontrado = true;
                            break;
                        }
                    }

                    // Si el producto no estaba en el carrito, lo añadimos con cantidad 1
                    if (!$productoEncontrado) {
                        $datos['cantidad'] = 1; // Agregamos la cantidad inicial
                        $_SESSION['productosCarrito'][] = $datos;
                    }

                    //Configuramos la alerta de exito!
                    $alerta=[
                        "tipo"=>"recargar",
                        "titulo"=>"Añadido al carrito!",
                        "texto"=>"El ".$datos['nombre']." se añadió con exito",
                        "icono"=>"success"
                    ];

                }
                //Notificamos que se agrego con exito!
                return json_encode($alerta);
            }

            //Controlador para VER UN PRODUCTO DETALLADO
            public function verProductoDetalladoControlador(){



                $id = $this->limpiarCadena($_POST['id']);
                //Creamos la variable que contendra el resultado
                $tabla ='';

                //Generamos la consulta SQL
                $sql = "SELECT * 
                        FROM productos
                        WHERE id = $id";
                //Ejecutamos la consulta
                $datos = $this->ejecutarConsulta($sql);
                //con fetchAll formateamos a filas nuestro resultado
                $datos = $datos->fetchAll();

                //Cargamos la estructura de la tabla
                $tabla = '<table id="productos" class="table display">
                            <thead> 
                                <tr> 
                                    <td>Nombre</td> 
                                    <td>Descripcion</td>
                                    <td>Precio</td>
                                    <td>Stock</td> 
                                </tr> 
                            </thead> 
                            <tbody>';
                //Recorremos las filas y vamos cargando la variable tabla con los resultados
                foreach($datos as $rows){

                        $tabla.='
                                <tr>
                                    <td>'.$rows['nombre'].'</td>
                                    <td>'.$rows['descripcion'].'</td>
                                    <td>'.$rows['precio'].'</td>
                                    <td>'.$rows['stock'].'</td>
                                </tr>
                        ';

                }                        
                //Cerramos la estructura de la tabla
                $tabla.= '                            
                            </tbody>
                        </table>
                        ';
                    
                //Enviamos a la vista los resultados
                return $tabla;
            }
            //Controlador para ELIMINAR PRODUCTO DEL CARRITO
            public function eliminarCarritoProductoControlador() {
                // Obtener el ID del producto que queremos eliminar
                $id = $this->limpiarCadena($_POST['producto_id']);
                
                // Verificamos si el carrito de compras está vacío o no existe
                if (isset($_SESSION['productosCarrito'])) {
                    // Recorremos los productos del carrito
                    foreach ($_SESSION['productosCarrito'] as $key => $producto) {
                        // Si el ID del producto coincide con el producto a eliminar
                        if ($producto['id'] == $id) {
                            // Eliminamos el producto usando el índice de la sesión
                            unset($_SESSION['productosCarrito'][$key]);
                            
                            // Reindexamos el arreglo para mantener la secuencia de índices
                            $_SESSION['productosCarrito'] = array_values($_SESSION['productosCarrito']);
                            
                            // Configuramos la alerta de éxito
                            $alerta = [
                                "tipo" => "recargar",
                                "titulo" => "Producto eliminado!",
                                "texto" => "El producto se ha eliminado con éxito del carrito.",
                                "icono" => "success"
                            ];
                            return json_encode($alerta);
                        }
                    }
            
                    // Si no se encontró el producto
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Producto no encontrado",
                        "texto" => "El producto que intentas eliminar no está en el carrito.",
                        "icono" => "error"
                    ];
                    return json_encode($alerta);
                } else {
                    // Si no hay productos en el carrito
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Carrito vacío",
                        "texto" => "No hay productos en el carrito.",
                        "icono" => "error"
                    ];
                    return json_encode($alerta);
                }
            }

            //Controlador para lista avanzada
            public function informeProductoControlador($pagina,$registros,$url,$busqueda){
    
                $pagina = $this->limpiarCadena($pagina);
                $registros = $this->limpiarCadena($registros);
    
                $url = $this->limpiarCadena($url);
                $url = APP_URL.$url."/";
    
                //$busqueda = $this->limpiarCadena($busqueda);

                //Dividimos los filtros
                if(!isset($busqueda[0])){$aKeyword='';}else{$aKeyword = explode(" ",$busqueda[0]);}
                if(!isset($busqueda[1])){$categoriaFil='';}else{$categoriaFil = $busqueda[1];}
                if(!isset($busqueda[2])){$stockFil='';}else{$stockFil = $busqueda[2];}

                //Preguntamos si todos los filtros vienen vacios
                if($aKeyword=='' && $categoriaFil=='' && $stockFil==''){
                    //  echo "Prueba ".$provinciaFil;
                    //  exit();
                    $query = "SELECT p.id idProducto, c.id idCategoria, p.nombre Nombre, p.descripcion Descripcion,
                                        p.precio Precio, p.imagen_url Imagen, p.stock Stock, c.descripcion Categoria
                              FROM productos p
                              JOIN categorias c
                              ON c.id = p.id_categorias
                              WHERE p.flag_mostrar = 1";

                    $consulta_total = "SELECT count(id) 
								       FROM productos
                                       WHERE flag_mostrar = 1";
                    
                }else{
                    //Generamos la consulta total
                    $query = "SELECT p.id idProducto, c.id idCategoria, p.nombre Nombre, p.descripcion Descripcion,
                                        p.precio Precio, p.imagen_url Imagen, p.stock Stock, c.descripcion Categoria
                              FROM productos p
                              JOIN categorias c
                              ON c.id = p.id_categorias
                              WHERE p.flag_mostrar = 1";

                    $consulta_total = "SELECT count(p.id) 
                                       FROM productos p
                                       JOIN categorias c
                                       ON c.id = p.id_categorias
                                       WHERE p.flag_mostrar = 1";


                }

                if($categoriaFil!=''){
                    $query.=" AND c.id = '$categoriaFil' ";
                    $consulta_total.=" AND c.id = '$categoriaFil' ";
                }

                if($stockFil!=''){
                    if($stockFil==1){
                        $query.=" AND p.stock >= 1 ";
                        $consulta_total.=" AND p.stock >= 1 ";
                    }else{
                        $query.=" AND p.stock = 0 ";
                        $consulta_total.=" AND p.stock = 0 ";
                    }
                }

                //print_r($query);
                //exit();

                $tabla = "";
    
                //Operador ternario : Se coloca una condicion entre parentesis,
                // si la condicion devuelve true se ejecuta lo que esta despues del signo de interrogacion
                // y antes de los dos puntos, sino ejecuta lo que esta al final
                $pagina = (isset($pagina) && $pagina>0) ? (int) $pagina : 1;
    
                // Nos va a indicar desde que numero empezar a contar cuando recorramos el array
                // que carga la tabla
                $inicio = ($pagina>0) ? (($pagina * $registros) - $registros) : 0 ;

                $query.=" LIMIT $inicio,$registros ";

                $datos = $this->ejecutarConsulta($query);
                $datos = $datos->fetchAll();
                $_SESSION['tablaProductos'] = $datos;
                $total = $this->ejecutarConsulta($consulta_total);
                $total = (int) $total->fetchColumn();

                $Npaginas = ceil($total/$registros);
    
                //Cargamos la estructura de la tabla
                $tabla = '<table id="productos" class="table display">
                            <thead> 
                                <tr> 
                                    <td>Nombre</td> 
                                    <td>Descripcion</td>
                                    <td>Categoria</td>
                                    <td>Precio</td>
                                    <td>Stock</td>
                                    <td>Editar</td>
								    <td>Eliminar</td>  
                                </tr> 
                            </thead> 
                            <tbody>';
                //Recorremos las filas y vamos cargando la variable tabla con los resultados
                foreach($datos as $rows){

                        $tabla.='
                                <tr>
                                    <td>'.$rows['Nombre'].'</td>
                                    <td>'.$rows['Descripcion'].'</td>
                                    <td>'.$rows['Categoria'].'</td>
                                    <td>'.$rows['Precio'].'</td>
                                    <td>'.$rows['Stock'].'</td>
                                    <td>
                        			    <a href="'.APP_URL."productUpdate/".$rows['idProducto']."/".'" class="btn btn-sm btn-primary">
                            			    <i class="fas fa-edit"></i> 
                        			    </a>
                    			    </td>
								    <td>
                                        <form class="FormularioAjax" action="'.APP_URL.'app/ajax/productAjax.php" method="post" autocomplete="off">
                                            <input type="hidden" name="modulo_producto" value="eliminar">
                                            <input type="hidden" name="producto_id" value="'.$rows['idProducto'].'">
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                        ';

                }                        
                //Cerramos la estructura de la tabla
                $tabla.= '                            
                            </tbody>
                        </table>
                        ';
                    
                //Enviamos a la vista los resultados
                return $tabla;
                
            }

        // Controlador para ACTUALIZAR
		public function actualizarProductoControlador(){

			//Capturamos el id del producto a actualizar
			$id=$this->limpiarCadena($_POST['idProducto']);

			# Verificando producto #
		    $datos=$this->ejecutarConsulta("SELECT * 
											FROM productos 
											WHERE id = $id");
					
			//Validamos si obtuvimos resultados de la consulta o no
			if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado el producto en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }else{
		    	$datos=$datos->fetch();
		    }

			//ALmacenando los datos que vienen de la vista
            $nombre = $this->limpiarCadena($_POST['nombre']);
            $precio = $this->limpiarCadena($_POST['precio']);
            $descripcion = $this->limpiarCadena($_POST['descripcion']);
            $imagen = $this->limpiarCadena($_POST['imagen']);
            $stock = $this->limpiarCadena($_POST['stock']);
            $categoria = $this->limpiarCadena($_POST['categoria']);


			//Verificando campos obligatorios
            if($nombre=="" || $precio=="" || $descripcion=="" || $imagen==""
            || $stock=="" || $categoria==0){
                //Definimos todo los valores de un array para la alerta
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Ocurrió un error inesperado",
                    "texto" => "No has llenado todos los campos que son obligatorios.",
                    "icono" => "error",

                ];
                //Devolvemos el array codificado en JSON
                return json_encode($alerta);
                exit();
            }

            //Verificando la integridad de los datos
            if($this->verificarDatos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{3,100}",$nombre)){
                //Definimos todo los valores de un array para la alerta
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Ocurrió un error inesperado",
                    "texto" => "El nombre no coincide con el formato solicitado",
                    "icono" => "error",

                ];
                //Devolvemos el array codificado en JSON
                return json_encode($alerta);
                exit();
            }
            if($this->verificarDatos("[0-9]{1,200}",$stock)){
                //Definimos todo los valores de un array para la alerta
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Ocurrió un error inesperado",
                    "texto" => "El stock no coincide con el formato solicitado",
                    "icono" => "error",

                ];
                //Devolvemos el array codificado en JSON
                return json_encode($alerta);
                exit();
            }
			try{
				// Cargamos el array de USUARIOS
				$usuario_datos_up=[
					[
						"campo_nombre"=>"nombre",
						"campo_marcador"=>":Nombre",
						"campo_valor"=>$nombre
					],
					[
						"campo_nombre"=>"descripcion",
						"campo_marcador"=>":Descripcion",
						"campo_valor"=>$descripcion
					],
					[
						"campo_nombre"=>"precio",
						"campo_marcador"=>":Precio",
						"campo_valor"=>$precio
					],
					[
						"campo_nombre"=>"imagen_url",
						"campo_marcador"=>":ImagenUrl",
						"campo_valor"=>$imagen
                    ],
                    [
						"campo_nombre"=>"id_categorias",
						"campo_marcador"=>":IdCategorias",
						"campo_valor"=>$categoria
                    ],
                    [
						"campo_nombre"=>"stock",
						"campo_marcador"=>":Stock",
						"campo_valor"=>$stock
                    ],
                    [
						"campo_nombre"=>"flag_mostrar",
						"campo_marcador"=>":FlagMostrar",
						"campo_valor"=>1
                    ]
				];
				$condicion_usuario=[
					"condicion_campo"=>"id",
					"condicion_marcador"=>":ID",
					"condicion_valor"=>$id
				];
				$ac_producto=$this->actualizarDatos("productos",$usuario_datos_up,$condicion_usuario);

				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Producto actualizado",
					"texto"=>"Los datos del producto ".$nombre." se actualizaron correctamente",
					"icono"=>"success"
				];
				
			}catch(PDOException $exc){
                $mensaje_error =  $exc->getMessage();
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"Ocurrió un error inesperado",
                    "texto"=>$exc,
                    "icono"=>"error"
                ];
                return json_encode($alerta);
                exit();  
            }
			return json_encode($alerta);

		}

        // Función para obtener datos de un usuario
        public function obtenerProductoPorId($id) {
			//Generamos la consulta SQL
            $sql = "SELECT * FROM productos WHERE id = $id";
            //Ejecutamos la consulta
            $datos = $this->ejecutarConsulta($sql);
            //con fetchAll formateamos a filas nuestro resultado
            $datos = $datos->fetchAll();

			return $datos;
        }

        //Controlador para ELIMINAR
		public function eliminarProductoControlador(){
			$id = $this->limpiarCadena($_POST['producto_id']);

			//Verificar el producto
			$datos = $this->ejecutarConsulta("SELECT *
											  FROM productos
											  WHERE id='$id'");

			if($datos->rowCount()<=0){
				//Definimos todo los valores de un array para la alerta
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Ocurrió un error inesperado",
                    "texto" => "No hemos encontrado el producto en el sistema.",
                    "icono" => "error",

                ];
                //Devolvemos el array codificado en JSON
                return json_encode($alerta);
                exit();
			}else{
				$datos = $datos->fetch();
			}

			$eliminar_producto= $this->eliminarRegistro("productos","id",$id);

			if($eliminar_producto->rowCount()==1){

				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Producto eliminado",
					"texto"=>"El producto ".$datos['nombre']." se eliminó con exito",
					"icono"=>"success"
				];

			}else{
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No se pudo eliminar el producto ".$datos['nombre'].",
							  por favor intente nuevamente",
				   "icono"=>"error"
				];
			}
			return json_encode($alerta);
		}



}
?>