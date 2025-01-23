<!-- Contenido de la Página -->
<div class="content-wrapper" style="min-height: 227px;">

    <!-- Parte Superior del Contenido -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Carrito de Compras</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                        <li class="breadcrumb-item active">Carrito de Compras</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- /Parte Superior del Contenido -->

    <!-- Contenido -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-lightblue">
                        <div class="card-header text-right">
                            <!-- Botón Volver -->
                            <button class="btn btn-secondary float-left btn-back"><?php include "./app/views/inc/btn_volver.php"; ?></button>
                            <!-- Botón para finalizar la compra -->
                            <a href="<?php echo APP_URL.'shopPay/'; ?>" class="btn btn-success">
                                Realizar Compra
                            </a>
                        </div>
                        <div class="card-body">
                            <table id="productos" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Imagen</th>
                                        <th>Producto</th>
                                        <th>Descripción</th>
                                        <th>Precio</th>
                                        <th>Cantidad</th>
                                        <th>Total</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($_SESSION['productosCarrito'])) {
                                        foreach ($_SESSION['productosCarrito'] as $producto) {
                                            $subtotal = $producto['precio'] * $producto['cantidad'];
                                            echo "
                                            <tr>
                                                <td><img src='{$producto['imagen_url']}' alt='{$producto['nombre']}' class='img-size-50 img-circle'></td>
                                                <td>{$producto['nombre']}</td>
                                                <td>{$producto['descripcion']}</td>
                                                <td>\${$producto['precio']}</td>
                                                <td>{$producto['cantidad']}</td>
                                                <td>\${$subtotal}</td>
                                                <td class='text-center'>
                                                    <form class='FormularioAjax' action='".APP_URL."app/ajax/carritoAjax.php' method='post'>
                                                        <input type='hidden' name='modulo_carrito' value='eliminar'>
                                                        <input type='hidden' name='producto_id' value='".$producto['id']."'>
                                                        <button type='submit' class='btn btn-danger'>
                                                            <i class='fa-solid fa-x'></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>";
                                        }
                                    } else {
                                        echo "
                                        <tr>
                                            <td colspan='7' class='text-center'>No hay productos en el carrito</td>
                                        </tr>";
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="5" class="text-right">Total:</th>
                                        <th colspan="2">
                                            <?php
                                            $total = array_sum(array_map(function ($producto) {
                                                return $producto['precio'] * $producto['cantidad'];
                                            }, $_SESSION['productosCarrito'] ?? []));
                                            echo "\$" . $total;
                                            ?>
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="card-footer">
                    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /Contenido -->

</div>
