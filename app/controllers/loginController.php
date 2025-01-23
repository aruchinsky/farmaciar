<?php
    namespace app\controllers;
    use app\models\mainModel;
    use \PDOException;

    class loginController extends mainModel{

        //Controlador INICIAR SESION
        public function iniciarSesionControlador(){

            //Almacenamos los valores del formulario de inicio de sesion
            $usuario = $this->limpiarCadena($_POST['login_usuario']);
            $clave =  $this->limpiarCadena($_POST['login_clave']);

            //Verificando campos obligatorios
            if($usuario=="" || $clave==""){
                echo "
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Ocurrio un error inesperado',
                            text: 'No has llenado todos los campos que son obligatorios',
                            confirmButtonText: 'Aceptar'
                        });
                    </script>
                ";
            }else{
                //Verificando la integridad de los datos
                if($this->verificarDatos("[a-zA-Z0-9]{4,10}",$usuario)){
                    echo "
                        <script>
                            Swal.fire({
                                icon: 'error',
                                title: 'Ocurrio un error inesperado',
                                text: 'El USUARIO no coincide con el formato solicitado',
                                confirmButtonText: 'Aceptar'
                            });
                        </script>
                    ";
                }else{
                    if($this->verificarDatos("[a-zA-Z0-9$@.-]{4,100}",$clave)){
                        echo "
                            <script>
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Ocurrio un error inesperado',
                                    text: 'La clave no coincide con el formato solicitado',
                                    confirmButtonText: 'Aceptar'
                                });
                            </script>
                        ";
                    }else{
                        # Verificando usuario #
                        //Consultamos si existe el usuario
                        $check_usuario=$this->ejecutarConsulta("SELECT id idUsuarios, usuario Usuario, nombre Nombre,
                                                                    direccion Direccion, correo Correo,
                                                                    clave Clave, id_tipo_usuarios idTipoUsuarios
                                                                FROM usuarios u
                                                                WHERE usuario = '$usuario';");

                        if($check_usuario->rowCount()==1){
                            //Si el usuario existe creamos un array con los datos del mismo
                            $check_usuario = $check_usuario->fetch();
                            //Preguntamos si el nombre de usuario y la clave desencriptada son iguales 
                            // a las que ingresaron en el login
                            if($check_usuario['Usuario']==$usuario && $check_usuario['Clave']==$clave){
                                //Guardamos todos los datos necesarios para la sesion
                                $_SESSION['id'] = $check_usuario['idUsuarios'];
                                $_SESSION['nombre'] = $check_usuario['Nombre'];
                                $_SESSION['usuario'] = $check_usuario['Usuario'];
                                $_SESSION['direccion'] = $check_usuario['Direccion'];
                                $_SESSION['correo'] = $check_usuario['Correo'];
                                $_SESSION['idTipoUsuario'] = $check_usuario['idTipoUsuarios'];
                                $_SESSION['productosCarrito'] = [];

                                //Corroboramos si los encabezados se han enviado
                                if(headers_sent()){
                                    if($_SESSION['idTipoUsuario']==1){
                                        //Si ya se han enviado encabezados, usamos javascript para redireccionar
                                        echo "
                                            <script>window.location.href='".APP_URL."productList';</script>
                                        ";
                                    }else{
                                        //Si ya se han enviado encabezados, usamos javascript para redireccionar
                                        echo "
                                            <script>window.location.href='".APP_URL."dashboard';</script>
                                        ";
                                    }
                                }else{
                                    if($_SESSION['idTipoUsuario']==1){
                                         //Si no se han enviado encabezados usamos PHP puro para redireccionar
                                         header("Location: ".APP_URL."productList");
                                    }else{
                                        //Si no se han enviado encabezados usamos PHP puro para redireccionar
                                        header("Location: ".APP_URL."dashboard");
                                    }
                                }
                            }else{
                                echo "
                                    <script>
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Ocurrio un error inesperado',
                                            text: 'Usuario o Clave incorrectos',
                                            confirmButtonText: 'Aceptar'
                                        });
                                    </script>
                                ";
                            }
                        }else{
                            echo "
                                <script>
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Ocurrio un error inesperado',
                                        text: 'Usuario o Clave incorrectos',
                                        confirmButtonText: 'Aceptar'
                                    });
                                </script>
                            ";
                        }
                    }
                }
            }



        }

        //Controlador CERRAR SESION
        public function cerrarSesionControlador(){
            //Eliminamos todas las variables de sesion
            session_destroy();
            //Corroboramos si los encabezados se han enviado
            if(headers_sent()){
                //Si ya se han enviado encabezados, usamos javascript para redireccionar
                echo "
                    <script>window.location.href='".APP_URL."login/';</script>
                ";
            }else{
                //Si no se han enviado encabezados usamos PHP puro para redireccionar
                header("Location: ".APP_URL."login/");
            }
        }




    }