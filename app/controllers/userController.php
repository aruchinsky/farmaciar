<?php
    namespace app\controllers;
    use app\models\mainModel;
    use \PDOException;

    class userController extends mainModel{


		//Controlador para LISTA DATATABLES
        public function listarUsuarioControlador(){
            //Creamos la variable que contendra el resultado
            $tabla ='';

            //Generamos la consulta SQL
            $sql = "SELECT u.id idUsuario, tu.id idTipoUsuario, u.nombre Nombre, u.correo Correo, u.usuario NombreUsuario, u.clave Clave, u.direccion Direccion,
							u.fecha_registro FechaRegistro, tu.descripcion TipoUsuario
					FROM usuarios u
					JOIN tipo_usuarios tu
					ON tu.id = u.id_tipo_usuarios
					WHERE flag_mostrar = 1";
            //Ejecutamos la consulta
            $datos = $this->ejecutarConsulta($sql);
            //con fetchAll formateamos a filas nuestro resultado
            $datos = $datos->fetchAll();

            //Cargamos la estructura de la tabla
            $tabla = '<table id="usuarios" class="table display">
                        <thead> 
                            <tr> 
                                <td>Nombre</td> 
                                <td>Correo</td>
                                <td>Nombre de Usuario</td>
                                <td>Direccion</td>
                                <td>Fecha de Registro</td>
								<td>Tipo de Usuario</td>
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
                                <td>'.$rows['Correo'].'</td>
                                <td>'.$rows['NombreUsuario'].'</td>
                                <td>'.$rows['Direccion'].'</td>
                                <td>'.$rows['FechaRegistro'].'</td>
								<td>'.$rows['TipoUsuario'].'</td>
								<td>
                        			<a href="'.APP_URL."userUpdate/".$rows['idUsuario']."/".'" class="btn btn-sm btn-primary">
                            			<i class="fas fa-edit"></i> 
                        			</a>
                    			</td>
								
								<td>
                                    <form class="FormularioAjax" action="'.APP_URL.'app/ajax/userAjax.php" method="post" autocomplete="off">
                                        <input type="hidden" name="modulo_usuario" value="eliminar">
                                        <input type="hidden" name="usuario_id" value="'.$rows['idUsuario'].'">
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

		// Función para obtener datos de un usuario
        public function obtenerUsuarioPorId($id) {
			//Generamos la consulta SQL
            $sql = "SELECT * FROM usuarios WHERE id = $id";
            //Ejecutamos la consulta
            $datos = $this->ejecutarConsulta($sql);
            //con fetchAll formateamos a filas nuestro resultado
            $datos = $datos->fetchAll();

			return $datos;
        }

		// Controlador para ACTUALIZAR
		public function actualizarUsuarioControlador(){

			//Capturamos el id del usuario a actualizar
			$id=$this->limpiarCadena($_POST['idUsuario']);

			# Verificando usuario #
		    $datos=$this->ejecutarConsulta("SELECT * 
											FROM usuarios 
											WHERE id = $id");
					
			//Validamos si obtuvimos resultados de la consulta o no
			if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado el usuario en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }else{
		    	$datos=$datos->fetch();
		    }

			//ALmacenando los datos que vienen de la vista
            $nombre = $this->limpiarCadena($_POST['nombre']);
			$nombreUsuario = $this->limpiarCadena($_POST['nombreUsuario']);
			$correo = $this->limpiarCadena($_POST['correo']);
			$direccion = $this->limpiarCadena($_POST['direccion']);

			//Verificando campos obligatorios
            if($nombre=="" || $nombreUsuario=="" || $correo=="" || $direccion==""){
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
            if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$nombre)){
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
			//Verificando la integridad de los datos
            if($this->verificarDatos("[a-zA-Z0-9 ]{3,10}",$nombreUsuario)){
                //Definimos todo los valores de un array para la alerta
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Ocurrió un error inesperado",
                    "texto" => "El usuario no coincide con el formato solicitado",
                    "icono" => "error",

                ];
                //Devolvemos el array codificado en JSON
                return json_encode($alerta);
                exit();
            }
			//Verificando la integridad de los datos
            if($this->verificarDatos("[a-zA-Z0-9áéíóúÁÉÍÓÚÑñ ]{3,50}",$direccion)){
                //Definimos todo los valores de un array para la alerta
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Ocurrió un error inesperado",
                    "texto" => "La dirección no coincide con el formato solicitado",
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
						"campo_nombre"=>"usuario",
						"campo_marcador"=>":Usuario",
						"campo_valor"=>$nombreUsuario
					],
					[
						"campo_nombre"=>"nombre",
						"campo_marcador"=>":Nombre",
						"campo_valor"=>$nombre
					],
					[
						"campo_nombre"=>"correo",
						"campo_marcador"=>":Correo",
						"campo_valor"=>$correo
					],
					[
						"campo_nombre"=>"direccion",
						"campo_marcador"=>":Direccion",
						"campo_valor"=>$direccion
					]
				];
				$condicion_usuario=[
					"condicion_campo"=>"id",
					"condicion_marcador"=>":ID",
					"condicion_valor"=>$id
				];
				$ac_usuario=$this->actualizarDatos("usuarios",$usuario_datos_up,$condicion_usuario);

				if($id==$_SESSION['id']){
					$_SESSION['nombre']=$nombre;
					$_SESSION['usuario']=$nombreUsuario;
				}
				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Usuario actualizado",
					"texto"=>"Los datos del usuario ".$nombre." se actualizaron correctamente",
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

		// Controlador para ACTUALIZAR MI PERFIL
		public function actualizarMiUsuarioControlador(){

			//Capturamos el id del usuario a actualizar
			$id=$this->limpiarCadena($_POST['idUsuario']);

			# Verificando usuario #
		    $datos=$this->ejecutarConsulta("SELECT * 
											FROM usuarios 
											WHERE id = $id");
					
			//Validamos si obtuvimos resultados de la consulta o no
			if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado el usuario en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }else{
		    	$datos=$datos->fetch();
		    }

			//ALmacenando los datos que vienen de la vista
            $nombre = $this->limpiarCadena($_POST['nombre']);
			$nombreUsuario = $this->limpiarCadena($_POST['nombreUsuario']);
			$correo = $this->limpiarCadena($_POST['correo']);
			$direccion = $this->limpiarCadena($_POST['direccion']);
			$clave1 = $this->limpiarCadena($_POST['clave1']);
            $clave2 = $this->limpiarCadena($_POST['clave2']);

			//Verificando campos obligatorios
            if($nombre=="" || $nombreUsuario=="" || $correo=="" || $direccion==""
			|| $clave1=="" || $clave2==""){
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
            if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$nombre)){
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
			//Verificando la integridad de los datos
            if($this->verificarDatos("[a-zA-Z0-9 ]{3,10}",$nombreUsuario)){
                //Definimos todo los valores de un array para la alerta
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Ocurrió un error inesperado",
                    "texto" => "El usuario no coincide con el formato solicitado",
                    "icono" => "error",

                ];
                //Devolvemos el array codificado en JSON
                return json_encode($alerta);
                exit();
            }
			//Verificando la integridad de los datos
            if($this->verificarDatos("[a-zA-Z0-9áéíóúÁÉÍÓÚÑñ ]{3,50}",$direccion)){
                //Definimos todo los valores de un array para la alerta
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Ocurrió un error inesperado",
                    "texto" => "La dirección no coincide con el formato solicitado",
                    "icono" => "error",

                ];
                //Devolvemos el array codificado en JSON
                return json_encode($alerta);
                exit();
            }
			# Verificando claves #
            if($clave1!=$clave2){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"Las contraseñas que acaba de ingresar no coinciden, por favor verifique e intente nuevamente",
					"icono"=>"error"
				];
				return json_encode($alerta);
				exit();
			}else{
                $clave = $clave1;
            }

			try{
				// Cargamos el array de USUARIOS
				$usuario_datos_up=[
					[
						"campo_nombre"=>"usuario",
						"campo_marcador"=>":Usuario",
						"campo_valor"=>$nombreUsuario
					],
					[
						"campo_nombre"=>"nombre",
						"campo_marcador"=>":Nombre",
						"campo_valor"=>$nombre
					],
					[
						"campo_nombre"=>"correo",
						"campo_marcador"=>":Correo",
						"campo_valor"=>$correo
					],
					[
						"campo_nombre"=>"direccion",
						"campo_marcador"=>":Direccion",
						"campo_valor"=>$direccion
					],
					[
						"campo_nombre"=>"clave",
						"campo_marcador"=>":Clave",
						"campo_valor"=>$clave
					]
				];
				$condicion_usuario=[
					"condicion_campo"=>"id",
					"condicion_marcador"=>":ID",
					"condicion_valor"=>$id
				];
				$ac_usuario=$this->actualizarDatos("usuarios",$usuario_datos_up,$condicion_usuario);

				if($id==$_SESSION['id']){
					$_SESSION['nombre']=$nombre;
					$_SESSION['usuario']=$nombreUsuario;
				}
				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Usuario actualizado",
					"texto"=>"Los datos del usuario ".$nombre." se actualizaron correctamente",
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

		//CONTROLADOR PARA REGISTRAR
        public function registrarUsuarioControlador(){

			//ALmacenando los datos que vienen de la vista
            $nombre = $this->limpiarCadena($_POST['nombre']);
			$nombreUsuario = $this->limpiarCadena($_POST['nombreUsuario']);
			$correo = $this->limpiarCadena($_POST['correo']);
			$direccion = $this->limpiarCadena($_POST['direccion']);
			$clave1 = $this->limpiarCadena($_POST['clave1']);
            $clave2 = $this->limpiarCadena($_POST['clave2']);
			$tipoUsuario = $this->limpiarCadena($_POST['tipoUsuario']);

			//Verificando campos obligatorios
            if($nombre=="" || $nombreUsuario=="" || $correo=="" || $direccion==""
			|| $clave1=="" || $clave2=="" || $tipoUsuario==0){
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
            if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$nombre)){
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

			//Verificando la integridad de los datos
            if($this->verificarDatos("[a-zA-Z0-9 ]{3,10}",$nombreUsuario)){
                //Definimos todo los valores de un array para la alerta
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Ocurrió un error inesperado",
                    "texto" => "El usuario no coincide con el formato solicitado",
                    "icono" => "error",

                ];
                //Devolvemos el array codificado en JSON
                return json_encode($alerta);
                exit();
            }

			//Verificando la integridad de los datos
            if($this->verificarDatos("[a-zA-Z0-9áéíóúÁÉÍÓÚÑñ ]{3,50}",$direccion)){
                //Definimos todo los valores de un array para la alerta
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Ocurrió un error inesperado",
                    "texto" => "La dirección no coincide con el formato solicitado",
                    "icono" => "error",

                ];
                //Devolvemos el array codificado en JSON
                return json_encode($alerta);
                exit();
            }

			# Verificando email #
		    if($correo!=""){
				if(filter_var($correo, FILTER_VALIDATE_EMAIL)){
					//Verificando si ya existe
					$check_email=$this->ejecutarConsulta("SELECT correo FROM usuarios WHERE correo='$correo'");
					if($check_email->rowCount()>0){
						$alerta=[
							"tipo"=>"simple",
							"titulo"=>"Ocurrió un error inesperado",
							"texto"=>"El EMAIL que acaba de ingresar ya se encuentra registrado en el sistema, por favor verifique e intente nuevamente",
							"icono"=>"error"
						];
						return json_encode($alerta);
						exit();
					}
				}else{
					$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"Ha ingresado un correo electrónico no valido",
						"icono"=>"error"
					];
					return json_encode($alerta);
					exit();
				}
            }
            # Verificando claves #
            if($clave1!=$clave2){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"Las contraseñas que acaba de ingresar no coinciden, por favor verifique e intente nuevamente",
					"icono"=>"error"
				];
				return json_encode($alerta);
				exit();
			}else{
                $clave = $clave1;
            }

			try{
				// Cargamos el array de USUARIOS
				$usuario_datos_up=[
					[
						"campo_nombre"=>"usuario",
						"campo_marcador"=>":Usuario",
						"campo_valor"=>$nombreUsuario
					],
					[
						"campo_nombre"=>"nombre",
						"campo_marcador"=>":Nombre",
						"campo_valor"=>$nombre
					],
					[
						"campo_nombre"=>"correo",
						"campo_marcador"=>":Correo",
						"campo_valor"=>$correo
					],
					[
						"campo_nombre"=>"direccion",
						"campo_marcador"=>":Direccion",
						"campo_valor"=>$direccion
					],
					[
						"campo_nombre"=>"clave",
						"campo_marcador"=>":Clave",
						"campo_valor"=>$clave
					],
					[
						"campo_nombre"=>"id_tipo_usuarios",
						"campo_marcador"=>":idTipoUsuarios",
						"campo_valor"=>$tipoUsuario
					]
				];
				$registrar_usuario=$this->guardarDatos("usuarios",$usuario_datos_up);

				$alerta=[
					"tipo"=>"limpiar",
					"titulo"=>"Usuario registrado",
					"texto"=>"El usuario ".$nombre." se registro con exito",
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

		//Controlador para ELIMINAR
		public function eliminarUsuarioControlador(){
			$id = $this->limpiarCadena($_POST['usuario_id']);

			if($id==1){
                //Definimos todo los valores de un array para la alerta
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Ocurrió un error inesperado",
                    "texto" => "No podemos eliminar el usuario principal del sistema.",
                    "icono" => "error",

                ];
                //Devolvemos el array codificado en JSON
                return json_encode($alerta);
                exit();
			}

			//Verificar el usuario
			$datos = $this->ejecutarConsulta("SELECT *
											  FROM usuarios
											  WHERE id='$id'");

			if($datos->rowCount()<=0){
				//Definimos todo los valores de un array para la alerta
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Ocurrió un error inesperado",
                    "texto" => "No hemos encontrado al usuario en el sistema.",
                    "icono" => "error",

                ];
                //Devolvemos el array codificado en JSON
                return json_encode($alerta);
                exit();
			}else{
				$datos = $datos->fetch();
			}

			$eliminar_admin= $this->eliminarRegistro("usuarios","id",$id);

			if($eliminar_admin->rowCount()==1){

				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Usuario eliminado",
					"texto"=>"El usuario ".$datos['nombre']." se eliminó con exito",
					"icono"=>"success"
				];

			}else{
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No se pudo eliminar el usuario ".$datos['Nombre'].",
							  por favor intente nuevamente",
				   "icono"=>"error"
				];
			}
			return json_encode($alerta);
		}

    }



?>