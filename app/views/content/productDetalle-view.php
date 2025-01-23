<?php
    use app\controllers\productController;
    $insProduct = new productController();
    $insProduct->listarProductoHomeControlador();

        //Recuperamos el id de usuario que enviamos
        //El ARRAY llamado URL es creado en el INDEX del sistema
        //En el ARRAY llamado URL viene: [0] = nombre de la vista, [1] = id que enviamos
		$idProducto=$insLogin->limpiarCadena($url[1]);

        $datos=$insLogin->ejecutarConsultaLibre("SELECT p.id idProducto, c.id idCategoria, p.nombre Nombre,
                                                        p.descripcion Descripcion, p.precio Precio, p.imagen_url Imagen,
                                                        p.stock Stock, c.descripcion Categoria
                                                 FROM productos p
                                                 JOIN categorias c
                                                 ON c.id = p.id_categorias
                                                 WHERE p.id = '$idProducto'");

        if($datos->rowCount()==1){
            $datos = $datos->fetch();

?>

<div class="content-wrapper" style="min-height: 1604.44px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          <button class="btn btn-secondary float-left btn-back"><?php include "./app/views/inc/btn_volver.php"; ?></button>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Inicio</a></li>
              <li class="breadcrumb-item active"><?php echo $datos['Categoria']; ?></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card card-solid">
        <div class="card-body">
          <div class="row">
            <div class="col-12 col-sm-6">
              <h3 class="d-inline-block d-sm-none"><?php echo $datos['Nombre']; ?></h3>
              <div class="col-12">
                <img src="<?php echo $datos['Imagen']; ?>" class="product-image" alt="Product Image">
              </div>
            </div>
            <div class="col-12 col-sm-6">
              <h3 class="my-3"><?php echo $datos['Nombre']; ?></h3>
              <p><?php echo $datos['Descripcion']; ?>.</p>

              <hr>

              <div class="bg-gray py-2 px-3 mt-4">
                <h2 class="mb-0">
                  $ <?php echo $datos['Precio']; ?>
                </h2>
                <h4 class="mt-0">
                  <small>Stock: <?php echo $datos['Stock']; ?></small>
                </h4>
              </div>

              <div class="mt-4">
                <div class="btn btn-primary btn-lg btn-flat">
                  <i class="fas fa-cart-plus fa-lg mr-2"></i>
                  Añadir al Carrito
                </div>
              </div>

            </div>
          </div>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
  <?php
            }else{
                include "./app/views/inc/error_alert.php";
            }  
        
?>