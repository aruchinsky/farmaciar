	<?php 
        use app\controllers\userController;

        $insUser = new userController();
        
        // Capturar el ID del usuario
        $id=$insLogin->limpiarCadena($url[1]);
        
        if ($id) {
            // Traer los datos del usuario seleccionado
            $usuario = $insUser->obtenerUsuarioPorId($id);
            //print_r($usuario);
            //exit();
        } else {
            echo "No se ha seleccionado un usuario.";
            exit();
        }
    ?>

    
<!-- Contenido de la Pagina -->
<div class="content-wrapper" style="min-height: 227px;">

<!-- Parte Superior del Contenido -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Actualizar Usuario</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active">Actualizar Usuario</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- /Parte superior del Contenido -->

<!-- Contenido -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-6">
                <div class="card card-lightblue">
                    <div class="card-body">
                        <!-- Formulario de actualización -->
                        <div class="container">
                            <h2><?php echo $usuario[0]['nombre']; ?></h2>
                            <form action="<?php echo APP_URL; ?>app/ajax/userAjax.php" method="post" autocomplete="off" class="FormularioAjax">

                                <input type="hidden" name="modulo_usuario" value="actualizar">

                                <input type="hidden" name="idUsuario" value="<?php echo $usuario[0]['id']; ?>">
                                
                                <div class="row">
                                    <!-- Nombre -->
                                    <div class="form-group col-md-6">
                                        <label>Nombre:</label>
                                        <input type="text" name="nombre" class="form-control" 
                                           pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" value="<?php echo $usuario[0]['nombre']; ?>" required>
                                    </div>

                                    <!-- Nombre de Usuario -->
                                    <div class="form-group col-md-6">
                                        <label>Nombre de Usuario:</label>
                                        <input type="text" name="nombreUsuario" class="form-control" 
                                           pattern="[a-zA-Z0-9 ]{3,10}" value="<?php echo $usuario[0]['usuario']; ?>" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Correo -->
                                    <div class="form-group col-md-6">
                                        <label>Correo:</label>
                                        <input type="email" name="correo" class="form-control" 
                                            value="<?php echo $usuario[0]['correo']; ?>">
                                    </div>

                                    <!-- Dirección -->
                                    <div class="form-group col-md-6">
                                        <label>Dirección:</label>
                                        <input type="text" name="direccion" class="form-control" 
                                            pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚÑñ ]{3,50}" value="<?php echo $usuario[0]['direccion']; ?>" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Botones Guardar y Cancelar -->
                                    <div class="form-group col-md-12 text-right">
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-save"></i> Actualizar
                                        </button>

                                        <button class="btn btn-secondary float-left btn-back"><?php include "./app/views/inc/btn_back.php"; ?></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-footer">
                        <!-- Paginador -->

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>