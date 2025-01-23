<div class="content-wrapper" style="min-height: 227px;">
    <!-- Parte Superior del Contenido -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Confirmación de Pedido</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                        <li class="breadcrumb-item active">Confirmación de Pedido</li>
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
                        </div>
                        <div class="card-body">
                            <!-- Resumen de Dirección de Envío -->
                            <h3>Dirección de Envío</h3>
                            <p><strong>Nombre:</strong> <?php echo $_SESSION['nombre']; ?></p>
                            <p><strong>Dirección:</strong> <?php echo $_SESSION['direccion']; ?></p>
                            <p><strong>Correo:</strong> <?php echo $_SESSION['correo']; ?></p>

                            <hr>

                            <!-- Resumen de Productos -->
                            <h3>Resumen de Pedido</h3>
                            <table id="productos" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Precio</th>
                                        <th>Cantidad</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $total = 0;
                                    if (!empty($_SESSION['productosCarrito'])) {
                                        foreach ($_SESSION['productosCarrito'] as $producto) {
                                            $subtotal = $producto['precio'] * $producto['cantidad'];
                                            $total += $subtotal;
                                            echo "
                                            <tr>
                                                <td>{$producto['nombre']}</td>
                                                <td>\${$producto['precio']}</td>
                                                <td>{$producto['cantidad']}</td>
                                                <td>\${$subtotal}</td>
                                            </tr>";
                                        }
                                    } else {
                                        echo "
                                        <tr>
                                            <td colspan='4' class='text-center'>No hay productos en el carrito</td>
                                        </tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>

                            <hr>

                            <h4>Total del Pedido: $<?php echo $total; ?></h4>

                            <hr>

                            <!-- Opciones de Pago -->
                            <h3>Forma de Pago</h3>
                            <form class="" action="<?php echo APP_URL; ?>app/ajax/carritoAjax.php" method="POST">
                                <input type="hidden" name="modulo_carrito" value="confirmar_pedido">
                                <input type="hidden" name="" value="">
                                <div class="form-group">
                                    <label>
                                        <input type="radio" name="pago" value="tarjeta" required onclick="mostrarFormularioPago('tarjeta')"> Pagar con Tarjeta
                                    </label>
                                    <br>
                                    <label>
                                        <input type="radio" name="pago" value="mercadopago" required onclick="mostrarFormularioPago('mercadopago')"> Pagar con Mercado Pago
                                    </label>
                                </div>

                                <!-- Formulario para pago con tarjeta -->
                                <div id="formularioTarjeta" style="display: none;">
                                    <h4>Detalles de la Tarjeta</h4>
                                    <div class="form-group">
                                        <label for="tarjetaNumero">Número de Tarjeta:</label>
                                        <input type="text" id="tarjetaNumero" name="tarjetaNumero" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="tarjetaFecha">Fecha de Expiración:</label>
                                        <input type="text" id="tarjetaFecha" name="tarjetaFecha" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="tarjetaCVV">CVV:</label>
                                        <input type="text" id="tarjetaCVV" name="tarjetaCVV" class="form-control" required>
                                    </div>
                                </div>

                                <!-- Opciones de Mercado Pago (si es necesario más información, se puede agregar aquí) -->
                                <div id="formularioMercadoPago" style="display: none;">
                                    <h4>Inicia sesión en Mercado Pago para continuar</h4>
                                    <p>Redirigiendo a Mercado Pago...</p>
                                </div>

                                <hr>

                                <!-- Botón de Pago Simulado -->
                                <button type="submit" class="btn btn-success btn-block">Realizar Pago</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /Contenido -->
</div>

<!-- JavaScript para mostrar u ocultar el formulario de pago -->
<script>
    function mostrarFormularioPago(opcion) {
        // Ocultar ambos formularios
        document.getElementById('formularioTarjeta').style.display = 'none';
        document.getElementById('formularioMercadoPago').style.display = 'none';

        // Mostrar el formulario correspondiente
        if (opcion === 'tarjeta') {
            document.getElementById('formularioTarjeta').style.display = 'block';
        } else if (opcion === 'mercadopago') {
            document.getElementById('formularioMercadoPago').style.display = 'block';
        }
    }
</script>

