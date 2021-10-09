<script src="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
<div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="row w-100 m-0">
            <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
                <div class="card col-lg-4 mx-auto border border-light d-md-light" style="background-color: rgba(0,0,0,0.6);">
                    <div class="card-body px-5 py-5">
                        <h3 class="card-title text-left mb-3">Login Links Mega Red</h3>
                        <form action="" method="POST" autocomplete="off">

                            <div class="form-group">
                                <label>Usuario *</label>
                                <div class="input-group border border-warning rounded">
                                    <div class="input-group-prepend">
                                        <button type="button" tabindex="-1" class="btn btn-outline-warning border border-warning">
                                            <i class="mdi mdi-account d-block mb-1"></i>
                                        </button>
                                    </div>
                                    <input type="text" class="form-control d-inp-light" placeholder="Usuario" aria-label="Username" aria-describedby="basic-addon1" name="usuario_log" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,100}" maxlength="100" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Password *</label>
                                <div class="input-group border border-warning rounded">
                                    <div class="input-group-prepend">
                                        <button type="button" tabindex="-1" class="btn btn-outline-warning border border-warning">
                                            <i class="mdi mdi-account d-block mb-1"></i>
                                        </button>
                                    </div>
                                    <input type="password" class="form-control d-inp-light" placeholder="Password" aria-label="Username" aria-describedby="basic-addon1" name="passwd_log" pattern="[a-zA-Z0-9$@.-]{7,25}" maxlength="25" required="">
                                </div>
                            </div>
                            <div class="form-group d-flex align-items-center justify-content-between">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="checkbox" class="form-check-input"> Recordarme </label>
                                </div>
                                <a href="#" class="forgot-pass">Olvidé mi password</a>
                            </div>
                            <div class="text-center">

                                <button type="submit" class="btn btn-outline-primary btn-fw">Iniciar Sesión</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
        </div>
        <!-- row ends -->
    </div>
    <!-- page-body-wrapper ends -->
    <script src="<?php echo SERVERURL; ?>views/assets/js/noRecarga.js"></script>
</div>

<?php
if (isset($_POST['usuario_log']) && isset($_POST['passwd_log'])) {
    require_once "./controllers/loginControlador.php";
    require_once "./routerMIkrotik/Resources.php";
    $data = RouterR::RouterConnect();
    $ping = $data->estado;
    if ($ping == 0) {
        $ins_login = new loginControlador();
        $ins_login->pingRouter();
    } else {
        $ins_login = new loginControlador();
        $ins_login->iniciar_sesion_controlador();
    }
}

?>

