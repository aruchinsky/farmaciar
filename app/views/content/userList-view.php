<!-- Contenido de la Pagina -->
<div class="content-wrapper" style="min-height: 227px;">

    <!-- Parte Superior del Contenido -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Lista de Usuarios</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                        <li class="breadcrumb-item active">Lista de Usuarios</li>
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
                        <div class="card-header text-right">
                            <!-- Botón para registrar un nuevo usuario -->
                            <a href="<?php echo APP_URL.'userNew/'; ?>" class="btn btn-primary">
                                <i class="fas fa-user-plus"></i> Registrar Nuevo Usuario
                            </a>
                        </div>
                        <div class="card-body">
                            <!-- Tabla de Datos -->
                            <?php
                                use app\controllers\userController;

                                $insUser = new userController();

                                echo $insUser->listarUsuarioControlador();
                            ?>
                        </div>

                        <script>
                            $(document).ready(function() {
                                $("#usuarios").DataTable({
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
        </div>
    </section>
</div>

