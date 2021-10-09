<?php
if ($login_controlador->encryption($_SESSION['id_lmr']) != $pagina[1]) {
    if ($_SESSION['id_rol_lmr'] != 1) {
        $login_controlador->forzar_cierre_sesion_controlador();
        exit();
    }
}
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<?php
require_once "./controllers/usuarioControlador.php";
$ins_usuario = new usuarioControlador();
$datos_usuario = $ins_usuario->datosUsuarioControlador("Unico", $pagina[1]);
$datos_select = $ins_usuario->llenarSelect(1, 0);
$datos_select_actual = $ins_usuario->llenarSelect(0, $pagina[1]);

if ($datos_usuario->rowCount() == 1) {
    $campos = $datos_usuario->fetch();
    $pass = $ins_usuario->desencriptar($campos['password_usuario']);
?>
    <div class="row justify-content-center ">
        <div class="col-md-8 grid-margin stretch-card">
            <div class="card d-mc-light d-frm">
                <div class="card-body">
                    <h4 class="card-title text-center">&nbsp; Actualizar Datos del usuario</h4>
                    <form class="form-sample FormularioAjax" action="<?php echo SERVERURL; ?>ajax/usuarioAjax.php" method="POST" data-form="update" autocomplete="off">
                        <div class="form-group row">
                            <input type="hidden" id="usuario_id_update" name="usuario_id_update" value="<?php echo $pagina[1]; ?>">
                            <label class="col-sm-4 col-form-label">&nbsp; Nombre Usuario</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control d-inp-light" id="nombreU" name="nombreU" placeholder="Username" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,100}" maxlength="100" required="" value="<?php echo $campos['nombre_usuario']; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">&nbsp; Rol Usuario</label>
                            <div class="col-sm-8">
                                <select class="custom-select custom-select-sm form-control form-control d-inp-light" name="rolU" id="rolU">
                                    <?php
                                    print_r($datos_select_actual);
                                    foreach ($datos_select_actual as $seleccionado) : ?>
                                        <option selected value="<?php echo $seleccionado['id_rol']; ?>"><?php echo $seleccionado['nombre_rol']; ?></option>
                                    <?php endforeach ?>

                                    <?php foreach ($datos_select as $opciones) : ?>
                                        <option value="<?php echo $opciones['id_rol'] ?>"><?php echo $opciones['nombre_rol']; ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">&nbsp; Nueva Clave</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <input id="txtPassword" name="txtPassword" type="password" class="form-control d-inp-light" placeholder="Nuevo Password" pattern="[a-zA-Z0-9$@.-]{7,25}" maxlength="25" required="" value="<?php echo $pass; ?>">
                                    <div class="input-group-append">
                                        <button id="show_password" class="btn" type="button" onclick="mostrarPassword()"> <span class="mdi mdi-eye-off d-btn-light"></span> </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">&nbsp; Confirmar Clave</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <input id="txtRePassword" name="txtRePassword" type="password" class="form-control d-inp-light" placeholder="Confirmar Password" pattern="[a-zA-Z0-9$@.-]{7,25}" maxlength="25" required="" value="<?php echo $pass; ?>">
                                    <div class="input-group-append">
                                        <button id="show_Repassword" class="btn" type="button" onclick="mostrarRePassword()"> <span class="mdi mdi-eye-off d-btn-light"></span> </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class=" row justify-content-center">
                            <button type="submit" class="btn btn-inverse-primary mr-2">&nbsp; Actualizar Datos</button>
                            <a href="<?php echo SERVERURL; ?>usuarios/" class="btn btn-inverse-danger">&nbsp; Cancelar</a>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
<?php } else {
    echo
    '
<div clas="row">
<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>ATENCIÓN!</strong> Parece que no tienes los privilegios suficientes para acceder a esta página
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
</div>
';
} ?>

<script type="text/javascript">
    function mostrarPassword() {
        var cambio = document.getElementById("txtPassword");
        if (cambio.type == "password") {
            cambio.type = "text";
            $('.icon').removeClass('mdi mdi-eye-off').addClass('mdi mdi-eye');
        } else {
            cambio.type = "password";
            $('.icon').removeClass('mdi mdi-eye').addClass('mdi mdi-eye-off');
        }
    }

    function mostrarRePassword() {
        var cambio = document.getElementById("txtRePassword");
        if (cambio.type == "password") {
            cambio.type = "text";
            $('.icon').removeClass('mdi mdi-eye-off').addClass('mdi mdi-eye');
        } else {
            cambio.type = "password";
            $('.icon').removeClass('mdi mdi-eye').addClass('mdi mdi-eye-off');
        }
    }
</script>