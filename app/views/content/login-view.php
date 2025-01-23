<div class="login-page" style="min-height: 100vh; background: url('<?php echo APP_URL; ?>app/views/images/fondo_login.png') no-repeat center center; background-size: cover;">
    <div class="container">
        <div class="row align-items-center" style="min-height: 100vh;">
            <!-- Sección de texto -->
            <div class="col-md-6 text-center text-md-left">
                <h1 class="display-4 text-primary font-weight-bold">Farmacia Online</h1>
                <p class="text-muted">¡Bienvenido! Por favor, inicie sesión para continuar.</p>
            </div>

            <!-- Sección del Login -->
            <div class="col-md-6">
                <div class="login-box">
                    <div class="card card-outline card-primary">
                        <div class="card-header text-center">
                            <a href="#" class="h1"><b>FarmaciAR</b></a>
                        </div>
                        <div class="card-body">
                            <p class="login-box-msg">Identifíquese</p>
                            <form action="" method="post" autocomplete="off">
                                <!-- Usuario -->
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="login_usuario" pattern="[a-zA-Z0-9]{4,10}" placeholder="Usuario" required>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-user"></span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Clave -->
                                <div class="input-group mb-3">
                                    <input type="password" class="form-control" name="login_clave" pattern="[a-zA-Z0-9$@.-]{4,100}" placeholder="Clave" required>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-lock"></span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Botón de inicio -->
                                <div class="row">
                                    <div class="col-4 ml-auto">
                                        <button type="submit" class="btn btn-primary btn-block">Ingresar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card.card-outline.card-primary {
    background-color: rgba(255, 255, 255, 0.8); /* Fondo blanco translúcido */
    backdrop-filter: blur(10px); /* Efecto de desenfoque */
    border-radius: 10px; /* Bordes redondeados */
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); /* Sombra suave */
}
</style>


    <!-- Script de SweetAlert2 -->
<script src="<?php echo APP_URL;?>app/views/js/sweetalert2.all.min.js"></script>
<?php
    if(isset($_POST['login_usuario']) || isset($_POST['login_clave'])){
        $insLogin->iniciarSesionControlador();
    }


?>