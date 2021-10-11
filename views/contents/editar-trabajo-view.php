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
require_once "./controllers/trabajoControlador.php";
$ins_trabajo = new trabajoControlador();
$datos_trabajo = $ins_trabajo->datostrabajoControlador("Unico", $pagina[1]);
$datos_select_usuario = $ins_trabajo->llenarSelect(1, 0);
$datos_select__usuario_actual = $ins_trabajo->llenarSelect(0, $pagina[1]);
$datos_select_trabajo = $ins_trabajo->llenarSelect(3, 0);
$datos_select__trabajo_actual = $ins_trabajo->llenarSelect(2, $pagina[1]);

if ($datos_trabajo->rowCount() == 1) {
    $campos = $datos_trabajo->fetch();
?>
    <div class="row justify-content-center ">
        <div class="col-md-9 grid-margin stretch-card">
            <div class="card d-mc-light d-frmt">
                <div class="card-body">
                    <h4 class="card-title text-center">&nbsp; Actualizar Datos del Trabajo Asignado</h4>
                    <form class="form-sample FormularioAjax" action="<?php echo SERVERURL; ?>ajax/trabajoAjax.php" method="POST" data-form="update" autocomplete="off">
                        <div class="form-group row">
                            <input type="hidden" id="orden_trabajo_id_update" name="orden_trabajo_id_update" value="<?php echo $pagina[1]; ?>">
                            <label class="col-sm-4 col-form-label">&nbsp; Responsable del Trabajo</label>
                            <div class="col-sm-8">
                                <select class="custom-select custom-select-sm form-control form-control d-inp-green" name="responsable_Up" id="responsable_Up">
                                    <?php
                                    foreach ($datos_select__usuario_actual as $seleccionado) : ?>
                                        <option selected value="<?php echo $seleccionado['id_usuario']; ?>"><?php echo $seleccionado['nombre_usuario']; ?></option>
                                    <?php endforeach ?>

                                    <?php foreach ($datos_select_usuario as $opciones) : ?>
                                        <option value="<?php echo $opciones['id_usuario'] ?>"><?php echo $opciones['nombre_usuario']; ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">&nbsp; Fecha Asignada</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control d-inp-green" id="fechaAsignada_Up" name="fechaAsignada_Up" placeholder="Fecha Asignada" maxlength="100" required="" data-toggle="datepicker" value="<?php echo $campos['fecha_creacion']; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">&nbsp; Elegir Tipo de Trabajo</label>
                            <div class="col-sm-8">
                                <select class="custom-select custom-select-sm form-control form-control d-inp-green" name="trabajo_Up" id="trabajo_Up">
                                    <?php
                                    foreach ($datos_select__trabajo_actual as $seleccionado) : ?>
                                        <option selected value="<?php echo $seleccionado['id_tipo_trabajo']; ?>"><?php echo $seleccionado['nombre_tipo_trabajo']; ?></option>
                                    <?php endforeach ?>

                                    <?php foreach ($datos_select_trabajo as $opciones) : ?>
                                        <option value="<?php echo $opciones['id_tipo_trabajo'] ?>"><?php echo $opciones['nombre_tipo_trabajo']; ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">&nbsp; Descripcion</label>
                            <div class="col-sm-8">
                                <textarea class="form-control d-inp-green d-txtar-green" name="descripcionTrabajo_Up" id="descripcionTrabajo_Up" placeholder="Descripcion del Trabajo a Realizar" maxlength="255" required=""><?php echo $campos['descripcion_trabajo']; ?></textarea>
                            </div>
                        </div>
                        <div class=" row justify-content-center">
                            <button type="submit" class="btn btn-inverse-success mr-2">&nbsp; Actualizar Orden Trabajo</button>
                            <a href="<?php echo SERVERURL; ?>trabajos/" class="btn btn-inverse-danger">&nbsp; Cancelar</a>
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