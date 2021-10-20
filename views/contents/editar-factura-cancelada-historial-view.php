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
require_once "./controllers/facturaControlador.php";
$ins_factura = new facturaControlador();
$datos_factura = $ins_factura->datosFacturaControlador("unico_cancelado", $pagina[1]);
$select_cliente = $ins_factura->llenarSelect("todo", 0, "cliente");
$select_estado = $ins_factura->llenarSelect("todo", 0, "estado");
$select_estado_actual = $ins_factura->llenarSelect("actual", $pagina[1], "estado");
$select_producto = $ins_factura->llenarSelect("todo", 0, "producto");
$select_precio = $ins_factura->llenarSelect("todo", 0, "precio");

if ($datos_factura->rowCount() == 1) {
    $campos = $datos_factura->fetch();
?>
    <div class="row justify-content-center ">
        <div class="col-md-8 grid-margin stretch-card">
            <div class="card d-mc-light d-frm">
                <div class="card-body">
                    <h4 class="card-title text-center">&nbsp; ACTUALIZAR DATOS DE FACTURACIÓN</h4>
                    <form class="form-sample FormularioAjax" action="<?php echo SERVERURL; ?>ajax/facturaAjax.php" method="POST" data-form="update" autocomplete="off">
                        <div class="form-group row">
                            <input type="hidden" id="factura_cancelada_id_updateH" name="factura_cancelada_id_updateH" value="<?php echo $pagina[1]; ?>">
                            <label class="col-sm-4 col-form-label">&nbsp; Fecha de Creación</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control d-inp-light" id="fecha_upCH" name="fecha_upCH" maxlength="10" required="" data-toggle="datepicker" value="<?php echo $campos['fecha']; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">&nbsp; Nombre del Cliente</label>
                            <div class="col-sm-8">
                                <select class="custom-select custom-select-sm form-control form-control d-inp-light" name="id_cliente_upCH" id="id_cliente_upCH">
                                    <option selected value="<?php echo $campos['id_cliente']; ?>"><?php echo $campos['nombre_cliente']; ?></option>
                                    <?php foreach ($select_cliente as $opciones) : ?>
                                        <option value="<?php echo $opciones['id_cliente'] ?>"><?php echo $opciones['nombre_cliente']; ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <input type="hidden" id="id_usuario_upCH" name="id_usuario_upCH" value="<?php echo $_SESSION['id_rol_lmr']; ?>">
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">&nbsp; Estado del Pago</label>
                            <div class="col-sm-8">
                                <select class="custom-select custom-select-sm form-control form-control d-inp-light" name="estado_pago_upCH" id="estado_pago_upCH">
                                    <?php
                                    foreach ($select_estado_actual as $seleccionado) : ?>
                                        <option selected value="<?php echo $seleccionado['id_estado_pago']; ?>"><?php echo $seleccionado['nombre_estado']; ?></option>
                                    <?php endforeach ?>
                                    <?php foreach ($select_estado as $opciones) : ?>
                                        <option value="<?php echo $opciones['id_estado_pago'] ?>"><?php echo $opciones['nombre_estado']; ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <hr />
                        <div class="form-group row">
                            <input type="hidden" id="id_detalle_cancelado_updateH" name="id_detalle_cancelado_updateH" value="<?php echo $campos['id_detalle_factura']; ?>">
                            <label class="col-sm-4 col-form-label">&nbsp; Item a Facturar</label>
                            <div class="col-sm-8">
                                <select class="custom-select custom-select-sm form-control form-control d-inp-light" name="producto_servicio_upCH" id="producto_servicio_upCH">
                                    <option selected value="<?php echo $campos['id_producto_servicio']; ?>"><?php echo $campos['nombre_producto_servicio']; ?></option>
                                    <?php foreach ($select_producto as $opciones) : ?>
                                        <option value="<?php echo $opciones['id_producto_servicio'] ?>"><?php echo $opciones['nombre_producto_servicio']; ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">&nbsp; Subtotal</label>
                            <div class="col-sm-8">
                                <select class="custom-select custom-select-sm form-control form-control d-inp-light" name="precio_upCH" id="precio_upCH">
                                    <option selected value="<?php echo $campos['precio']; ?>"><?php echo $campos['precio']; ?></option>
                                    <?php foreach ($select_precio as $opciones) : ?>
                                        <option value="<?php echo $opciones['precio'] ?>"><?php echo $opciones['precio']; ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">&nbsp; Mes a Pagar</label>
                            <div class="col-sm-8">
                                <select class="custom-select custom-select-sm form-control form-control d-inp-light" name="mes_pagado_upCH" id="mes_pagado_upCH">
                                    <option selected value="<?php echo $campos['mes_pagado']; ?>"><?php echo $campos['mes_pagado']; ?></option>
                                    <option value="Enero">Enero</option>
                                    <option value="Febrero">Febrero</option>
                                    <option value="Marzo">Marzo</option>
                                    <option value="Abril">Abril</option>
                                    <option value="Mayo">Mayo</option>
                                    <option value="Junio">Junio</option>
                                    <option value="Julio">Julio</option>
                                    <option value="Agosto">Agosto</option>
                                    <option value="Septiembre">Septiembre</option>
                                    <option value="Octubre">Octubre</option>
                                    <option value="Noviembre">Noviembre</option>
                                    <option value="Dicimebre">Dicimebre</option>
                                </select>
                            </div>
                        </div>
                        <div class=" row justify-content-center">
                            <button type="submit" class="btn btn-inverse-primary mr-2">&nbsp; Actualizar Datos</button>
                            <a href="<?php echo SERVERURL; ?>facturacion/" class="btn btn-inverse-danger">&nbsp; Cancelar</a>
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

<!----Script para datepicker -->
<script>
    $(function() {
        $('[data-toggle="datepicker"]').datepicker({
            autoHide: true,
            zIndex: 2048,
            format: "yyyy-mm-dd",
            language: "es"

        });
    });
</script>