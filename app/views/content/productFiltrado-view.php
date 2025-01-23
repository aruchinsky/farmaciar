<?php
    use app\controllers\productController;
    //Capturamos el ID del Producto desde la URL
    $idProducto=$insLogin->limpiarCadena($url[1]);
    //Instanciamos la clase PRODUCTO
    $insProduct = new productController();
    //Llamamos al metodo que nos traera los datos FILTRADOS
    //$insProduct->listarProductoFiltradoControlador($idProducto);
?>
<!-- Contenido de la Pagina -->
        <div class="content-wrapper" style="min-height: 227px;">

            <!-- Parte Superior del Contenido -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <!-- <h1 class="m-0">Todos los Productos</h1> -->
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                                <li class="breadcrumb-item active">Todos los Productos</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Parte superior del Contenido -->

            <!-- Contenido -->
            <section class="content">
                <div class="container-fluid">
                    
                    <!-- Todos los Productos -->
                    <div class="row row-cols-1 row-cols-md-3 g-3">

                        <?php
                            echo $insProduct->listarProductoFiltradoControlador($idProducto);
                        ?>

                    </div>

                    <!-- Anuncios y publicidades -->
                    <div class="row">

                        <section class="col-lg-6 connectedSortable ui-sortable">

                            <div class="card">
                                <div class="card-header">
                                <h3 class="card-title">OFERTA 1</h3>
                                </div>
                                <div class="card-body"></div>
                                <div class="card-footer"></div>
                            </div>

                        </section>
                        <section class="col-lg-6 connectedSortable ui-sortable">

                            <div class="card">
                                <div class="card-header">
                                <h3 class="card-title">OFERTA 2</h3>
                                </div>
                                <div class="card-body"></div>
                                <div class="card-footer"></div>
                            </div>

                        </section>

                    </div>
                </div>
            </section>
            <!-- /Contenido -->

        </div>
        <!-- /Contenido de la Pagina -->
</div>

<style>
.card {
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s ease-in-out;
}

.card:hover {
    transform: scale(1.05); /* Ampliar levemente */
}

.card-img-top {
    object-fit: cover;
    height: 180px; /* Asegura una altura uniforme */
}

</style>