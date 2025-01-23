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
                <h1 class="m-0">Mi Perfil</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active">Mi Perfil</li>
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
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <!-- <img class="profile-user-img img-fluid img-circle" src="../../dist/img/user4-128x128.jpg" alt="User profile picture"> -->
                </div>

                <h3 class="profile-username text-center"><?php echo $usuario[0]['nombre']; ?></h3>

                <!-- <p class="text-muted text-center">Software Engineer</p> -->

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Seguidores</b> <a class="float-right">1,322</a>
                  </li>
                  <li class="list-group-item">
                    <b>Siguiendo</b> <a class="float-right">543</a>
                  </li>
                  <li class="list-group-item">
                    <b>Amigos</b> <a class="float-right">13,287</a>
                  </li>
                </ul>

                <a href="<?php echo APP_URL."myUserUpdate/".$_SESSION['id']."/"; ?>" class="btn btn-primary btn-block"><b>Editar Perfil</b></a>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Sobre Mi</h3>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <!-- <strong><i class="fas fa-book mr-1"></i> Educación</strong>

                    <p class="text-muted">
                    B.S. in Computer Science from the University of Tennessee at Knoxville
                    </p>

                    <hr> -->

                    <strong><i class="fa-solid fa-envelope"></i> Correo</strong>

                    <p class="text-muted"> <?php echo $usuario[0]['correo']; ?> </p>

                    <hr>

                    <strong><i class="fas fa-map-marker-alt mr-1"></i> Dirección</strong>

                    <p class="text-muted"><?php echo $usuario[0]['direccion']; ?></p>

                    <!-- <hr>

                    <strong><i class="fas fa-pencil-alt mr-1"></i> Habilidades</strong>

                    <p class="text-muted">
                    <span class="tag tag-danger">UI Design</span>
                    <span class="tag tag-success">Coding</span>
                    <span class="tag tag-info">Javascript</span>
                    <span class="tag tag-warning">PHP</span>
                    <span class="tag tag-primary">Node.js</span>
                    </p>

                    <hr>

                    <strong><i class="far fa-file-alt mr-1"></i> Notas</strong>

                    <p class="text-muted">Notas dato</p> -->
                </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>