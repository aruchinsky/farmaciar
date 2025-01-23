<?php
        require_once "./autoload.php";
        use app\models\mainModel;

        $consultaCategorias = new mainModel();
        $consultaCategorias = $consultaCategorias->seleccionarDatos("Menu","categorias",0,0);
        $consultaCategorias = $consultaCategorias->fetchAll(PDO::FETCH_OBJ);
?>
<!-- Contenido de la Pagina -->
<div class="content-wrapper" style="min-height: 227px;">

<!-- Parte Superior del Contenido -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Registrar Producto</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active">Registrar Producto</li>
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
                            <h2>Producto Nuevo</h2>
                            <form action="<?php echo APP_URL; ?>app/ajax/productAjax.php" method="post" autocomplete="off" class="FormularioAjax">

                                <input type="hidden" name="modulo_producto" value="registrar">
                                
                                <div class="row">
                                    <!-- Nombre -->
                                    <div class="form-group col-md-6">
                                        <label>Nombre:</label>
                                        <input type="text" name="nombre" class="form-control" 
                                           pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{3,100}" value="" required>
                                    </div>

                                    <!-- Precio -->
                                    <div class="form-group col-md-6">
                                        <label>Precio (solo números):</label>
                                        <input type="text" name="precio" class="form-control" 
                                           pattern="[0-9]{4,10}" value="" placeholder="Ej: 5000" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <!-- Descripcion -->
                                        <div class="form-group">
                                            <label>Descripcion:</label>
                                            <textarea name="descripcion" class="form-control" rows="3" placeholder="Detalles ..." required></textarea>
                                        </div>
                                    </div>

                                    <!-- Imagen -->
                                    <div class="form-group col-md-6">
                                        <label>URL de la Imagen:</label>
                                        <input type="text" name="imagen" class="form-control" value="" required>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <!-- Categorias -->
                                    <div class="form-group col-md-6">
                                        <label>Categorias: </label>
                                        <select class="form-control btn-info dropdown-toggle" id="category" name="categoria" required>
                                            <option value="0" class="form-control" type="button" data-bs-toggle="dropdown" aria-expanded="false">Seleccionar...</option>
                                            <?php
                                            foreach($consultaCategorias as $dato){
                                            ?>
                                            <option value="<?php echo $dato->id ?>" class="form-control"><?php echo $dato->descripcion?></option>
                                            <?php
                                            } 
                                            ?>           
                                        </select>
                                    </div>

                                    <!-- Stock -->
                                    <div class="form-group col-md-6">
                                        <label>Stock inicial (solo números):</label>
                                        <input type="text" name="stock" class="form-control" 
                                            pattern="[0-9]{1,200}" value="" required>
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