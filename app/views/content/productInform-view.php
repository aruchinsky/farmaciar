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
                <button class="btn btn-secondary float-left btn-back"><?php include "./app/views/inc/btn_volver.php"; ?></button>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                        <li class="breadcrumb-item active">Informes de Productos</li>
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
                            <!-- Formulario de Búsqueda -->
                            <?php
                                use app\controllers\productController;

                                $insProduct = new productController();
                                //Preguntamos si NO se cargo NINGUN informe
                                if(!isset($_SESSION[$url[0]]) && empty($_SESSION[$url[0]])){
                            ?>
                            <!-- SI NO HAY INFORME MOSTRAMOS EL FORMULARIO INICIAL -->
                            <div class="columns">
                                <div class="column">

                                <div class="container-fluid">
                                    <h2 class="text-center display-4">Buscar</h2>
                                    <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/buscadorAjax.php" method="POST" autocomplete="off" >
                                        <input type="hidden" name="modulo_buscador" value="buscar">
                                        <input type="hidden" name="modulo_entidad" value="producto">
                                        <input type="hidden" name="modulo_url" value="<?php echo $url[0]; ?>">
                                        <div class="row">
                                            <div class="col-md-10 offset-md-1">
                                                <div class="row">
                                                    <!-- Categorias -->
                                                    <div class="col-5">
                                                        <div class="form-group">
                                                            <label>Categoría</label>
                                                                <select class="btn bg-lightblue dropdown-toggle" style="width: 100%;" id="category" name="productoCategoriaFil">
                                                                    <option value="" class="form-control" type="button" data-bs-toggle="dropdown" aria-expanded="false">Seleccionar...</option>
                                                                    <?php
                                                                            foreach($consultaCategorias as $dato){
                                                                        ?>
                                                                    <option value="<?php echo $dato->id ?>" class="form-control"><?php echo $dato->descripcion ?></option>
                                                                        <?php
                                                                            } 
                                                                        ?>
                                                                </select>
                                                        </div>
                                                    </div>
                                                    <!-- Stock -->
                                                    <div class="col-5">
                                                        <div class="form-group">
                                                            <label>Stock</label>
                                                            <select class="btn bg-lightblue dropdown-toggle" style="width: 100%;" id="category" name="productoStockFil">
                                                                    <option value="" class="form-control" type="button" data-bs-toggle="dropdown" aria-expanded="false">Seleccionar...</option>
                                                                    <option value="0" class="form-control">Sin Stock</option>
                                                                    <option value="1" class="form-control">Con Stock</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <!-- Busqueda -->
                                                    <div class="col-1">
                                                        <div class="form-group">
                                                        <label></label>
                                                            <div class="input-group input-group-lg">
                                                                <button type="submit" class="btn btn-default">
                                                                    <i class="fa fa-search"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                    </form>
                                                    <!-- Limpiar Busqueda -->
                                                    <div class="col-1">
                                                        <form class="input-group-append FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/buscadorAjax.php" method="POST" autocomplete="off" >
                                                            <input type="hidden" name="modulo_buscador" value="eliminar">
                                                            <input type="hidden" name="modulo_entidad" value="producto">
                                                            <input type="hidden" name="modulo_url" value="<?php echo $url[0]; ?>">
                                                            <div class="form-group">
                                                            <label></label>
                                                                <div class="input-group input-group-lg">
                                                                    <button type="submit" class="btn bg-lightblue">
                                                                        <i class="fa-solid fa-filter-circle-xmark"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                   
                            <?php } else { ?>
                                <!-- SI YA HAY INFORMES SOLICITADOS SE MUESTRA EL MISMO FORMULARIO YA CON LA TABLA ACTIVA -->
                                <div class="container-fluid">
                                    <h2 class="text-center display-4">Buscar</h2>
                                    <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/buscadorAjax.php" method="POST" autocomplete="off" >
                                        <input type="hidden" name="modulo_buscador" value="buscar">
                                        <input type="hidden" name="modulo_entidad" value="producto">
                                        <input type="hidden" name="modulo_url" value="<?php echo $url[0]; ?>">
                                        <div class="row">
                                            <div class="col-md-10 offset-md-1">
                                                <div class="row">
                                                    <!-- Categorias -->
                                                    <div class="col-5">
                                                        <div class="form-group">
                                                            <label>Categoría</label>
                                                                <select class="btn bg-lightblue dropdown-toggle" style="width: 100%;" id="category" name="productoCategoriaFil">
                                                                    <option value="" class="form-control" type="button" data-bs-toggle="dropdown" aria-expanded="false">Seleccionar...</option>
                                                                    <?php
                                                                            foreach($consultaCategorias as $dato){
                                                                        ?>
                                                                    <option value="<?php echo $dato->id ?>" <?php echo ($_SESSION['AvanzadaProducto'][1] == $dato->id) ? 'selected' : ''; ?> class="form-control"><?php echo $dato->descripcion ?></option>
                                                                        <?php
                                                                            } 
                                                                        ?>
                                                                </select>
                                                        </div>
                                                    </div>
                                                    <!-- Stock -->
                                                    <div class="col-5">
                                                        <div class="form-group">
                                                            <label>Stock</label>
                                                            <select class="btn bg-lightblue dropdown-toggle" style="width: 100%;" id="category" name="productoStockFil">
                                                                    <option value="" class="form-control" type="button" data-bs-toggle="dropdown" aria-expanded="false">Seleccionar...</option>
                                                                    <option value="0" class="form-control">Sin Stock</option>
                                                                    <option value="1" class="form-control">Con Stock</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <!-- Busqueda -->
                                                    <div class="col-1">
                                                        <div class="form-group">
                                                        <label></label>
                                                            <div class="input-group input-group-lg">
                                                                <button type="submit" class="btn btn-default">
                                                                    <i class="fa fa-search"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                    </form>
                                                    <!-- Limpiar Busqueda -->
                                                    <div class="col-1">
                                                        <form class="input-group-append FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/buscadorAjax.php" method="POST" autocomplete="off" >
                                                            <input type="hidden" name="modulo_buscador" value="eliminar">
                                                            <input type="hidden" name="modulo_entidad" value="producto">
                                                            <input type="hidden" name="modulo_url" value="<?php echo $url[0]; ?>">
                                                            <div class="form-group">
                                                            <label></label>
                                                                <div class="input-group input-group-lg">
                                                                    <button type="submit" class="btn bg-lightblue">
                                                                        <i class="fa-solid fa-filter-circle-xmark"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                <div class="card card-outline card-primary">
                                    <div class="card-header">
                                        
                                    </div>
                                    <div class="card-body">
                                        <?php
                                            //LLAMAMOS AL METODO QUE CARGA EL DATATABLE CON SUS PARAMETROS DE BUSQUEDA
                                            echo $insProduct->informeProductoControlador($url[1], 10, $url[0], $_SESSION['AvanzadaProducto']);
                                        }
                                        ?>

                                    </div>
                                    <script>
                                        $(document).ready(function() {
                                            $("#productos").DataTable({
                                                dom: 'Bfrtip',  // B para los botones, f para el cuadro de búsqueda y r para el selector de registros por página
                                                buttons: [
                                                    {
                                                        extend: 'copy',
                                                        text: 'Copiar'
                                                    },
                                                    {
                                                        extend: 'excel',
                                                        text: 'Excel'
                                                    },
                                                    {
                                                        extend: 'pdf',
                                                        text: 'PDF'
                                                    },
                                                    {
                                                        extend: 'print',
                                                        text: 'Imprimir'
                                                    }
                                                ],
                                                language: {
                                                    "lengthMenu": "Mostrar _MENU_ registros por página",
                                                    "zeroRecords": "No se encontraron resultados",
                                                    "info": "Mostrando página _PAGE_ de _PAGES_",
                                                    "infoEmpty": "No hay registros disponibles",
                                                    "infoFiltered": "(filtrado de _MAX_ registros en total)"
                                                }
                                            });
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <!-- Pie de Tabla -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
