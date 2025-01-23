<?php
        require_once "./autoload.php";
        use app\models\mainModel;

        $consultaCategorias = new mainModel();
        $consultaCategorias = $consultaCategorias->seleccionarDatos("Menu","categorias",0,0);
        $consultaCategorias = $consultaCategorias->fetchAll(PDO::FETCH_OBJ);
?>
<!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                <a href="<?php echo APP_URL; ?>dashboard" class="nav-link">Inicio</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                <a href="#" class="nav-link">Contacto</a>
                </li>
            </ul>
            <!-- CARRITO DE COMPRAS  -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <span class="badge badge-danger navbar-badge">
                            <!-- NUMERITO ROJO QUE VA SOBRE EL CARRITO CANTIDAD TOTAL DE PRODUCTOS -->
                            <?php
                                if (!isset($_SESSION['productosCarrito'])) {
                            ?>
                                    0
                            <?php
                                }else{
                                    echo count($_SESSION['productosCarrito']); 
                                }
                                
                            ?>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

            <?php
                // Verificar si hay datos en el arrayCarrito
                if (!empty($_SESSION['productosCarrito'])) {
            ?>
                    <!-- Titulo superior del carrito -->
                    <span class="dropdown-item dropdown-header"><?php echo count($_SESSION['productosCarrito']); ?> Productos Agregados</span>

                    <div class="dropdown-divider"></div>
                    <div class="overflow-auto" style="max-height: 300px;">
            <?php

                //unset($_SESSION['productosCarrito']);

                // Acceder a los productos almacenados
                foreach ($_SESSION['productosCarrito'] as $producto) {

                    echo '

                        <!-- Producto 1 -->
                        <a href="#" class="dropdown-item d-flex align-items-center">
                            <!-- Imagen del producto -->
                            <img src="'.$producto['imagen_url'].'" alt="Laptop" class="img-size-50 mr-3 img-circle">
                            <div class="w-100">
                                <!-- Nombre del producto -->
                                <span class="d-block">'.$producto['nombre'].'</span>
                                <!-- Precio del producto -->
                                <span class="float-right text-muted text-sm"> $ '.$producto['precio'].'</span>
                                <!-- Cantidad del producto -->
                                <span class="float-right text-muted text-sm ml-2">Cantidad: '.$producto['cantidad'].' x </span>
                            </div>
                        </a>
                        <div class="dropdown-divider"></div>
                        
                        

                    ';

                }
            } else {
            ?>
                <div class="overflow-auto" style="max-height: 300px;">
            <?php
                echo '
                                <!-- Titulo superior del carrito -->
                                <span class="dropdown-item dropdown-header">No hay productos en el carrito</span>

                                <div class="dropdown-divider"></div>

                                <!-- Mensaje cuando no hay productos -->
                                <span class="dropdown-item">
                                    Tu carrito está vacío.
                                </span>

                                <div class="dropdown-divider"></div>


                    ';
            }

            ?>
                    </div>
                                    <!-- Total -->
                                    <span class="dropdown-item">
                            <strong>Total:</strong>
                            <!-- Monto total de la compra -->
                            <span class="float-right text-muted text-sm">$ 
                                <?php
                                // Calcular el total teniendo en cuenta la cantidad de cada producto
                                $total = array_sum(array_map(function($producto) {
                                    return $producto['precio'] * $producto['cantidad'];  // Multiplicamos precio por cantidad
                                }, $_SESSION['productosCarrito']));
                                
                                echo $total;  // Mostrar el total
                                ?>
                            </span>

                        </span>
                        <div class="dropdown-divider"></div>
                        <!-- Ir al carrito -->
                        <a href="<?php echo APP_URL."shopList/"; ?>" class="dropdown-item dropdown-footer">Ir al Carrito</a>
                    </div>
                </li>

                <!--MI PERFIL-->
                <li class="nav-item dropdown">
                    <a class="nav-link d-sm-inline-block" data-toggle="dropdown" href="#">
                        <i class="fa-solid fa-user"></i>  <?php echo $_SESSION['usuario']; ?>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <a href="<?php echo APP_URL."userShop/".$_SESSION['id']."/"; ?>" class="dropdown-item">
                            <i class="fa-solid fa-clock-rotate-left mr-2"></i> Mis Compras
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="<?php echo APP_URL."myUser/".$_SESSION['id']."/"; ?>" class="dropdown-item">
                            <i class="fa-solid fa-user-gear mr-2"></i> Mi Perfil
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="<?php echo APP_URL; ?>logOut/" id="btn_exit" class="dropdown-item">
                            <i class="fa fa-times mr-2"></i> Cerrar Sesion
                        </a>
                        <div class="dropdown-divider"></div>
                    </div>
                </li>
            </ul>
            <!-- /CARRITO DE COMPRAS  -->

            
        </nav>
        <!-- /Navbar -->

        <!-- SIDEBAR -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Logo Encabezado -->
            <a href="<?php echo APP_URL; ?>dashboard/" class="brand-link">
                <img src="<?php echo APP_URL; ?>app/views/images/logo.png" alt="Bulma" class="brand-image img-circle elevation-3">
                <span class="brand-text font-weight-light"><?php echo APP_NAME; ?></span>
            </a>
            <!-- /Logo Encabezado -->

            <!--CONTENIDO DEL SIDEBAR-->
            <div class="sidebar">
                            <!-- NOMBRE Y PERFIL -->
                            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                                <div class="info">
                                <a href="#" class="d-block"><?php echo $_SESSION['nombre']; ?></a>
                                </div>
                            </div>
                            <!-- /NOMBRE Y PERFIL -->

                            <!-- ITEMS DEL SIDEBAR -->
                            <nav class="mt-2">
                                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                                        <!-- CATEGORIAS -->
                                        <li class="nav-item">
                                            <!-- Encabezado Desplegable -->
                                            <a href="#" class="nav-link">
                                            <i class="fa-solid fa-list-ul nav-icon"></i>
                                                <p>Categorias<i class="right fas fa-angle-left"></i></p>
                                            </a>
                                            <!-- /Encabezado Desplegable -->

                                             <!-- Items -->
                                            <ul class="nav nav-treeview">
                                                <?php
                                                foreach($consultaCategorias as $dato){
                                                ?>
                                                    <li class="nav-item">
                                                        <a href="<?php echo APP_URL; ?>productFiltrado/<?php echo $dato->id ?>" class="nav-link">
                                                        <i class="fa-regular fa-circle-dot nav-icon"></i>
                                                        <p><?php echo $dato->descripcion?></p>
                                                        </a>
                                                    </li>
                                                <?php
                                                } 
                                                ?>  
                                            </ul>
                                            <!-- /Items -->
                                        </li>
                                    </ul>
                            </nav>
                            <!-- /ITEMS DEL SIDEBAR -->
            </div>
            <!--/CONTENIDO DEL SIDEBAR-->


        </aside>
        <!-- /SIDEBAR -->