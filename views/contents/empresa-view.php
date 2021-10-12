<?php
if ($_SESSION['id_rol_lmr'] != 1) {
    $login_controlador->forzar_cierre_sesion_controlador();
    exit();
}
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<?php
require_once "./controllers/empresaControlador.php";

$ins_empresa = new empresaControlador();
$datos_select_muni = $ins_empresa->llenarSelect(1, 0, "muni");

$datos_empresa = $ins_empresa->datosEmpresaControlador();
$datos_router = $ins_empresa->datosRouterControlador();

if ($datos_empresa->rowCount() == 0 && $datos_router->rowCount() == 0) {

?>
    <div class="row justify-content-center ">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card d-mc-light d-frmi">
                <div class="card-body">
                    <h4 class="card-title text-center text-info">&nbsp; Agregar Datos de la Empresa y Router Mikrotik</h4>
                    <form class="form-sample d-formc FormularioAjax" action="<?php echo SERVERURL; ?>ajax/empresaAjax.php" method="POST" data-form="save" autocomplete="off">
                        <h6 class="card-title text-light">&nbsp; Datos de la Empresa y Representante Legal</h6>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label class="col-form-label text-info">&nbsp; Nombre de la Empresa</label>
                                <input type="text" class="form-control d-inp-emp" id="nombreEmpresa" name="nombreEmpresa" pattern="^(([a-zA-ZáéíóúÁÉÍÓÚüñÑ0-9\-]+)|((([a-zA-ZáéíóúÁÉÍÓÚüñÑ0-9\-]+)[ ]([a-zA-ZáéíóúÁÉÍÓÚüñÑ0-9]+))+))$" maxlength="100" required="">
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label text-info">&nbsp; Representante Legal</label>
                                <input type="text" class="form-control d-inp-emp" id="representanteLegal" name="representanteLegal" pattern="^(([a-zA-ZáéíóúÁÉÍÓÚüñÑ]+)|((([a-zA-ZáéíóúÁÉÍÓÚüñÑ]+)[ ]([a-zA-ZáéíóúÁÉÍÓÚüñÑ]+))+))$" maxlength="100" required="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3">
                                <label class="col-form-label text-info">&nbsp; Numero de NIT Empresa</label>
                                <input type="text" class="form-control d-inp-emp" id="nitEmpresa" name="nitEmpresa" pattern="^(([0-9]{7}-([0-9]|[a-zA-ZñÑ]))|[0-9]{8})$" maxlength="100" required="">
                            </div>
                            <div class="col-md-3">
                                <label class="col-form-label text-info">&nbsp; Teléfonos Empresa</label>
                                <input type="text" class="form-control d-inp-emp" id="telefonoEmpresa" name="telefonoEmpresa" pattern="^([0-9]{8}|([0-9]{8}[/][0-9]{8}))$" maxlength="100" required="">
                            </div>
                            <div class="col-md-3">
                                <label class="col-form-label text-info">&nbsp; Correo Electrónico Empresa</label>
                                <input type="text" class="form-control d-inp-emp" id="correoEmpresa" name="correoEmpresa" pattern="^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$" maxlength="100" required="">
                            </div>
                            <div class="col-md-3">
                                <label class="col-form-label text-info">&nbsp; Ubicación GPS Empresa</label>
                                <input type="text" class="form-control d-inp-emp" id="gpsEmpresa" name="gpsEmpresa" pattern="^([0-9]{2,3}.([0-9]+), -[0-9]{2,3}.([0-9]+))$" maxlength="100" required="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label class="col-form-label text-info">&nbsp; Municipio Empresa</label>
                                <select class="custom-select custom-select-sm form-control form-control d-inp-emp" name="municipioEmpresa" id="municipioEmpresa">
                                    <option selected value="">Elegir Municipio</option>
                                    <?php foreach ($datos_select_muni as $opciones) : ?>
                                        <option value="<?php echo $opciones['id_municipio'] ?>"><?php echo $opciones['nombre_municipio']; ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="col-md-8">
                                <label class="col-form-label text-info">&nbsp; Dirección de Domicilio Empresa</label>
                                <input type="text" class="form-control d-inp-emp" id="domicilioEmpresa" name="domicilioEmpresa" pattern="^(([a-zA-ZáéíóúÁÉÍÓÚüñÑ0-9-.,]+)|((([a-zA-ZáéíóúÁÉÍÓÚüñÑ0-9-.,]+)[ ]([a-zA-ZáéíóúÁÉÍÓÚüñÑ0-9-.,]+))+))$" maxlength="200" required="">
                            </div>
                        </div>
                        <hr />
                        <h6 class="card-title text-light">&nbsp; Datos Del Router Mikrotik</h6>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label class="col-form-label text-info">&nbsp; Modelo</label>
                                <input type="text" class="form-control d-inp-emp" id="modeloRouter" name="modeloRouter" pattern="^(([a-zA-ZáéíóúÁÉÍÓÚüñÑ0-9-.,]+)|((([a-zA-ZáéíóúÁÉÍÓÚüñÑ0-9-.,]+)[ ]([a-zA-ZáéíóúÁÉÍÓÚüñÑ0-9-.,]+))+))$" maxlength="100" required="">
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label text-info">&nbsp; Numero de Serie</label>
                                <input type="text" class="form-control d-inp-emp" id="serieRouter" name="serieRouter" pattern="^(([a-zA-ZáéíóúÁÉÍÓÚüñÑ0-9-.,]+)|((([a-zA-ZáéíóúÁÉÍÓÚüñÑ0-9-.,]+)[ ]([a-zA-ZáéíóúÁÉÍÓÚüñÑ0-9-.,]+))+))$" maxlength="100" required="">
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label text-info">&nbsp; IP del Router</label>
                                <input type="text" class="form-control d-inp-emp" id="ipRouter" name="ipRouter" pattern="^(([0-9]{1,3})[.]([0-9]{1,3})[.]([0-9]{1,3})[.]([0-9]{1,3}))$" maxlength="15" required="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <label class="col-form-label text-info">&nbsp; Usuario para acceder al Router</label>
                                    <input type="password" class="form-control d-inp-emp" id="usuarioRouter" name="usuarioRouter" pattern="^(([a-zA-ZáéíóúÁÉÍÓÚüñÑ0-9-.,]+)|((([a-zA-ZáéíóúÁÉÍÓÚüñÑ0-9-.,]+)[ ]([a-zA-ZáéíóúÁÉÍÓÚüñÑ0-9-.,]+))+))$" maxlength="100" required="">
                                    <div class="input-group-append">
                                        <button id="show_Repassword" class="btn" type="button" onclick="mostrarUsuario()"> <span class="mdi mdi-eye-off d-btn-info"></span> </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <label class="col-form-label text-info">&nbsp; Password del Router</label>
                                    <input type="password" class="form-control d-inp-emp" id="passwordRouter" name="passwordRouter" pattern="^(([a-zA-ZáéíóúÁÉÍÓÚüñÑ0-9-.,@#]+)|((([a-zA-ZáéíóúÁÉÍÓÚüñÑ0-9-.,@#]+)[ ]([a-zA-ZáéíóúÁÉÍÓÚüñÑ0-9-.,@#]+))+))$" maxlength="100" required="">
                                    <div class="input-group-append">
                                        <button id="show_Repassword" class="btn" type="button" onclick="mostrarPassword()"> <span class="mdi mdi-eye-off d-btn-info"></span> </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr />
                        <div class=" row justify-content-center">
                            <button type="submit" class="btn btn-inverse-warning mr-2">&nbsp;Registrar</button>
                            <a href="<?php echo SERVERURL; ?>clientes-activos/" class="btn btn-inverse-danger">&nbsp; Cancelar</a>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
<?php } else {
    $campos = $datos_empresa->fetch();
    $camposR = $datos_router->fetch();
    $datos_select_muni_actual = $ins_empresa->llenarSelect(0, $campos['id_empresa'], "muni");
?>
    <div class="row justify-content-center ">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card d-mc-light d-frmi">
                <div class="card-body">
                    <h4 class="card-title text-center text-info">&nbsp; Actualizar Datos de la Empresa y Router Mikrotik</h4>
                    <form class="form-sample d-formc FormularioAjax" action="<?php echo SERVERURL; ?>ajax/empresaAjax.php" method="POST" data-form="save" autocomplete="off">
                        <input type="hidden" id="id_empresa_update" name="id_empresa_update" value="<?php echo $campos['id_empresa'];?>">
                        <h6 class="card-title text-light">&nbsp; Datos de la Empresa y Representante Legal</h6>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label class="col-form-label text-info">&nbsp; Nombre de la Empresa</label>
                                <input type="text" class="form-control d-inp-emp" id="nombreEmpresa_up" name="nombreEmpresa_up" pattern="^(([a-zA-ZáéíóúÁÉÍÓÚüñÑ0-9\-]+)|((([a-zA-ZáéíóúÁÉÍÓÚüñÑ0-9\-]+)[ ]([a-zA-ZáéíóúÁÉÍÓÚüñÑ0-9]+))+))$" maxlength="100" required="" value="<?php echo $campos['nombre_empresa']; ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label text-info">&nbsp; Representante Legal</label>
                                <input type="text" class="form-control d-inp-emp" id="representanteLegal_up" name="representanteLegal_up" pattern="^(([a-zA-ZáéíóúÁÉÍÓÚüñÑ]+)|((([a-zA-ZáéíóúÁÉÍÓÚüñÑ]+)[ ]([a-zA-ZáéíóúÁÉÍÓÚüñÑ]+))+))$" maxlength="100" required="" value="<?php echo $campos['representante_legal']; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3">
                                <label class="col-form-label text-info">&nbsp; Numero de NIT Empresa</label>
                                <input type="text" class="form-control d-inp-emp" id="nitEmpresa_up" name="nitEmpresa_up" pattern="^(([0-9]{7}-([0-9]|[a-zA-ZñÑ]))|[0-9]{8})$" maxlength="9" required="" value="<?php echo $campos['nit_empresa']; ?>">
                            </div>
                            <div class="col-md-3">
                                <label class="col-form-label text-info">&nbsp; Teléfonos Empresa</label>
                                <input type="text" class="form-control d-inp-emp" id="telefonoEmpresa_up" name="telefonoEmpresa_up" pattern="^([0-9]{8}|([0-9]{8}[/][0-9]{8}))$" maxlength="17" required="" value="<?php echo $campos['telefono_empresa']; ?>">
                            </div>
                            <div class="col-md-3">
                                <label class="col-form-label text-info">&nbsp; Correo Electrónico Empresa</label>
                                <input type="text" class="form-control d-inp-emp" id="correoEmpresa_up" name="correoEmpresa_up" pattern="^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$" maxlength="100" required="" value="<?php echo $campos['correo_empresa']; ?>">
                            </div>
                            <div class="col-md-3">
                                <label class="col-form-label text-info">&nbsp; Ubicación GPS Empresa</label>
                                <input type="text" class="form-control d-inp-emp" id="gpsEmpresa_up" name="gpsEmpresa_up" pattern="^([0-9]{2,3}.([0-9]+), -[0-9]{2,3}.([0-9]+))$" maxlength="100" required="" value="<?php echo $campos['ubicacion_gps']; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label class="col-form-label text-info">&nbsp; Municipio de la Empresa</label>
                                <select class="custom-select custom-select-sm form-control form-control d-inp-emp" name="municipioEmpresa_up" id="municipioEmpresa_up">
                                    <?php foreach ($datos_select_muni_actual as $opcion) : ?>
                                        <option selected value="<?php echo $opcion['id_municipio'] ?>"><?php echo $opcion['nombre_municipio']; ?></option>
                                    <?php endforeach ?>
                                    <?php foreach ($datos_select_muni as $opciones) : ?>
                                        <option value="<?php echo $opciones['id_municipio'] ?>"><?php echo $opciones['nombre_municipio']; ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="col-md-8">
                                <label class="col-form-label text-info">&nbsp; Dirección de Domicilio de la Empresa</label>
                                <input type="text" class="form-control d-inp-emp" id="domicilioEmpresa_up" name="domicilioEmpresa_up" pattern="^(([a-zA-ZáéíóúÁÉÍÓÚüñÑ0-9-.,]+)|((([a-zA-ZáéíóúÁÉÍÓÚüñÑ0-9-.,]+)[ ]([a-zA-ZáéíóúÁÉÍÓÚüñÑ0-9-.,]+))+))$" maxlength="200" required="" value="<?php echo $campos['domicilio']; ?>">
                            </div>
                        </div>
                        <hr />

                        <h6 class="card-title text-light">&nbsp; Datos Del Router Mikrotik</h6>
                        <input type="hidden" id="id_router_update" name="id_router_update" value="<?php echo $camposR['id_router'];?>">
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label class="col-form-label text-info">&nbsp; Modelo</label>
                                <input type="text" class="form-control d-inp-emp" id="modeloRouter_up" name="modeloRouter_up" pattern="^(([a-zA-ZáéíóúÁÉÍÓÚüñÑ0-9-.,]+)|((([a-zA-ZáéíóúÁÉÍÓÚüñÑ0-9-.,]+)[ ]([a-zA-ZáéíóúÁÉÍÓÚüñÑ0-9-.,]+))+))$" maxlength="100" required="" value="<?php echo $camposR['modelo']; ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label text-info">&nbsp; Numero de Serie</label>
                                <input type="text" class="form-control d-inp-emp" id="serieRouter_up" name="serieRouter_up" pattern="^(([a-zA-ZáéíóúÁÉÍÓÚüñÑ0-9-.,]+)|((([a-zA-ZáéíóúÁÉÍÓÚüñÑ0-9-.,]+)[ ]([a-zA-ZáéíóúÁÉÍÓÚüñÑ0-9-.,]+))+))$" maxlength="100" required="" value="<?php echo $camposR['serie']; ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label text-info">&nbsp; IP del Router</label>
                                <input type="text" class="form-control d-inp-emp" id="ipRouter_up" name="ipRouter_up" pattern="^(([0-9]{1,3}).([0-9]{1,3}).([0-9]{1,3}).([0-9]{1,3}))$" maxlength="15" required="" value="<?php echo $camposR['ip_asignada']; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <label class="col-form-label text-info">&nbsp; Usuario para acceder al Router</label>
                                    <input type="password" class="form-control d-inp-emp" id="usuarioRouter_up" name="usuarioRouter_up" pattern="^(([a-zA-ZáéíóúÁÉÍÓÚüñÑ0-9-.,]+)|((([a-zA-ZáéíóúÁÉÍÓÚüñÑ0-9-.,]+)[ ]([a-zA-ZáéíóúÁÉÍÓÚüñÑ0-9-.,]+))+))$" maxlength="100" required="" value="<?php echo $camposR['usuario_router']; ?>">
                                    <div class="input-group-append">
                                        <button class="btn" type="button" onclick="mostrarUsuario_up()"> <span class="mdi mdi-eye-off d-btn-info"></span> </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <label class="col-form-label text-info">&nbsp; Password del Router</label>
                                    <input type="password" class="form-control d-inp-emp" id="passwordRouter_up" name="passwordRouter_up" pattern="^(([a-zA-ZáéíóúÁÉÍÓÚüñÑ0-9-.,@#]+)|((([a-zA-ZáéíóúÁÉÍÓÚüñÑ0-9-.,@#]+)[ ]([a-zA-ZáéíóúÁÉÍÓÚüñÑ0-9-.,@#]+))+))$" maxlength="100" required="" value="<?php echo $camposR['password_router']; ?>">
                                    <div class="input-group-append">
                                        <button class="btn" type="button" onclick="mostrarPassword_up()"> <span class="mdi mdi-eye-off d-btn-info"></span> </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr />
                        <div class=" row justify-content-center">
                            <button type="submit" class="btn btn-inverse-warning mr-2">&nbsp;Actualizar</button>
                            <a href="<?php echo SERVERURL; ?>clientes-activos/" class="btn btn-inverse-danger">&nbsp; Cancelar</a>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

<?php } ?>

<script type="text/javascript">
    function mostrarPassword() {
        var cambio = document.getElementById("passwordRouter");
        if (cambio.type == "password") {
            cambio.type = "text";
            $('.icon').removeClass('mdi mdi-eye-off').addClass('mdi mdi-eye');
        } else {
            cambio.type = "password";
            $('.icon').removeClass('mdi mdi-eye').addClass('mdi mdi-eye-off');
        }
    }

    function mostrarUsuario() {
        var cambio = document.getElementById("usuarioRouter");
        if (cambio.type == "password") {
            cambio.type = "text";
            $('.icon').removeClass('mdi mdi-eye-off').addClass('mdi mdi-eye');
        } else {
            cambio.type = "password";
            $('.icon').removeClass('mdi mdi-eye').addClass('mdi mdi-eye-off');
        }
    }

    function mostrarPassword_up() {
        var cambio = document.getElementById("passwordRouter_up");
        if (cambio.type == "password") {
            cambio.type = "text";
            $('.icon').removeClass('mdi mdi-eye-off').addClass('mdi mdi-eye');
        } else {
            cambio.type = "password";
            $('.icon').removeClass('mdi mdi-eye').addClass('mdi mdi-eye-off');
        }
    }

    function mostrarUsuario_up() {
        var cambio = document.getElementById("usuarioRouter_up");
        if (cambio.type == "password") {
            cambio.type = "text";
            $('.icon').removeClass('mdi mdi-eye-off').addClass('mdi mdi-eye');
        } else {
            cambio.type = "password";
            $('.icon').removeClass('mdi mdi-eye').addClass('mdi mdi-eye-off');
        }
    }
</script>