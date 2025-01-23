<?php
        require_once "./autoload.php";
        use app\models\mainModel;

        $consultaTipoUsuario = new mainModel();
        $consultaTipoUsuario = $consultaTipoUsuario->seleccionarDatos("Menu","tipo_usuarios",0,0);
        $consultaTipoUsuario = $consultaTipoUsuario->fetchAll(PDO::FETCH_OBJ);
?>
<!-- Contenido de la Pagina -->
<div class="content-wrapper" style="min-height: 227px;">

<!-- Parte Superior del Contenido -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Registrar Usuario</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active">Registrar Usuario</li>
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
                            <h2>Usuario Nuevo</h2>
                            <form action="<?php echo APP_URL; ?>app/ajax/userAjax.php" method="post" autocomplete="off" class="FormularioAjax">

                                <input type="hidden" name="modulo_usuario" value="registrar">
                                
                                <div class="row">
                                    <!-- Nombre -->
                                    <div class="form-group col-md-6">
                                        <label>Nombre:</label>
                                        <input type="text" name="nombre" class="form-control" 
                                           pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" value="" required>
                                    </div>

                                    <!-- Nombre de Usuario -->
                                    <div class="form-group col-md-6">
                                        <label>Nombre de Usuario:</label>
                                        <input type="text" name="nombreUsuario" class="form-control" 
                                           pattern="[a-zA-Z0-9 ]{3,10}" value="" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Correo -->
                                    <div class="form-group col-md-6">
                                        <label>Correo:</label>
                                        <input type="email" name="correo" class="form-control" 
                                            value="">
                                    </div>

                                    <!-- Dirección -->
                                    <div class="form-group col-md-6">
                                        <label>Dirección:</label>
                                        <input type="text" name="direccion" class="form-control" 
                                            pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚÑñ ]{3,50}" value="" required>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <!-- Correo -->
                                    <div class="form-group col-md-6">
                                        <label>Clave:</label>
                                        <input type="text" name="clave1" class="form-control" 
                                            pattern="[a-zA-Z0-9 ]{3,50}" value="" required>
                                    </div>

                                    <!-- Dirección -->
                                    <div class="form-group col-md-6">
                                        <label>Confirmar Clave:</label>
                                        <input type="text" name="clave2" class="form-control" 
                                            pattern="[a-zA-Z0-9 ]{3,50}" value="" required>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <!-- Tipo de Usuario -->
                                    <div class="form-group col-md-6">
                                        <label>TIpo de Usuario</label>
                                        <select class="form-control btn-info dropdown-toggle" id="category" name="tipoUsuario" required>
                                            <option value="0" class="form-control" type="button" data-bs-toggle="dropdown" aria-expanded="false">Seleccionar...</option>
                                            <?php
                                            foreach($consultaTipoUsuario as $dato){
                                            ?>
                                            <option value="<?php echo $dato->id ?>" class="form-control"><?php echo $dato->descripcion?></option>
                                            <?php
                                            } 
                                            ?>           
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Botones Guardar y Cancelar -->
                                    <div class="form-group col-md-12 text-right">
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-save"></i> Guardar
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