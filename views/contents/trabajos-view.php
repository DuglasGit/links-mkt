<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<div class="row">
    <div class="col-sm-4 grid-margin">
        <div class="card-body">
            <button type="button" class="btn btn-outline-success btn-icon-text" data-toggle="modal" data-target="#modalNuevoTipoTrabajo">
                <i class="mdi mdi-tooltip-edit btn-icon-prepend mdi-36px"></i>
                <span class="d-inline-block text-left">
                    <small class="font-weight-light d-block">NUEVO</small>TIPO DE TRABAJO</span>
            </button>
        </div>
    </div>
    <div class="col-sm-4 grid-margin">
        <div class="card-body">
            <button type="button" class="btn btn-outline-success btn-icon-text" data-toggle="modal" data-target="#modalNuevoTrabajo">
                <i class="mdi mdi-calendar-clock btn-icon-prepend mdi-36px"></i>
                <span class="d-inline-block text-left">
                    <small class="font-weight-light d-block">NUEVA</small>ORDEN DE TRABAJO</span>
            </button>
        </div>
    </div>
    <div class="col-sm-4 grid-margin">
        <div class="card-body">
            <a type="button" href="<?php echo SERVERURL; ?>trabajos-terminados/" class="input-group btn btn-outline-success btn-icon-text">
                <i class="mdi mdi-briefcase-check btn-icon-prepend mdi-36px"></i>
                <span class="d-inline-block text-left">
                    <small class="font-weight-light d-block">VER</small>TRABAJOS TERMINADOS</span>
            </a>
        </div>
    </div>

</div>

<!-- card tabla usuarios -->
<div class="card d-pri">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-success text-center">ORDENES DE TRABAJO POR REALIZAR</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12 col-md-4">

            </div>
            <div class="col-sm-12 col-md-4">

                <div class="form-group row justify-content-center">
                    <div class="col-sm-10">
                        <div class="input-group border border-light rounded">
                            <input type="search" id="myInput" class="form-control form-control-sm text-light" placeholder="Buscar..." aria-controls="dataTable">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4">
            </div>
        </div>

        <br>
        <div class="row justify-content-center">
            <br>
            <?php
            require_once "./controllers/trabajoControlador.php";
            $ins_trabajo = new trabajoControlador();

            echo $ins_trabajo->PaginadorTrabajoPendienteControlador($pagina[1], 10, $_SESSION['id_rol_lmr'], $_SESSION['id_lmr'], $pagina[0], "");

            ?>
        </div>

    </div>

</div>




<!-- Modal Nueva Orden de Trabajo-->
<div class="modal fade" id="modalNuevoTrabajo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog border border-success rounded d-md-success " role="document" style="width:375px;">
        <div class="modal-content d-mc-light">
            <div class="modal-header">
                <h5 class="modal-title text-center w-100 text-center" id="exampleModalLabel">CREAR NUEVA ORDEN DE TRABAJO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php
            require_once "./controllers/trabajoControlador.php";
            $ins_trabajo = new trabajoControlador();
            $datos_select_usuario = $ins_trabajo->llenarSelect(1, 0);
            $datos_select_trabajo = $ins_trabajo->llenarSelect(3, 0);
            ?>
            <form class="FormularioAjax" action="<?php echo SERVERURL; ?>ajax/trabajoAjax.php" method="POST" data-form="save" autocomplete="off">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Responsable del Trabajo a Realizar</label>
                        <select class="custom-select custom-select-sm form-control form-control d-inp-green" name="responsable" id="responsable">
                            <option selected value="">Seleccionar Responsable</option>
                            <?php foreach ($datos_select_usuario as $opciones) : ?>
                                <option value="<?php echo $opciones['id_usuario'] ?>"><?php echo $opciones['nombre_usuario']; ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Fecha Asignada</label>
                        <input type="text" class="form-control d-inp-green" id="fechaAsignada" name="fechaAsignada" placeholder="Fecha Asignada" maxlength="100" required="" data-toggle="datepicker" value="">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Tipo de Trabajo a Realizar</label>
                        <select class="custom-select custom-select-sm form-control form-control d-inp-green" name="trabajo" id="trabajo">
                                <option selected value="">Seleccionar Tipo Trabajo</option>
                            <?php foreach ($datos_select_trabajo as $opciones) : ?>
                                <option value="<?php echo $opciones['id_tipo_trabajo'] ?>"><?php echo $opciones['nombre_tipo_trabajo']; ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Descripción del trabajo a Realizar</label>
                        <textarea class="form-control d-inp-green d-txtar-green-d" name="descripcionTrabajo" id="descripcionTrabajo" placeholder="Descripcion del Trabajo a Realizar" maxlength="255" required=""></textarea>
                    </div>         
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-inverse-primary" data-dismiss="modal">Cancelar</button>
                    <button type="sumbit" class="btn btn-inverse-success">Registrar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Fin Modal Nueva Orden de Trabajo-->




<!-- script buscador tabla -->
<script>
    $(document).ready(function() {
        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTable tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>

<script>
    $(document).on("click", ".open-mostrarDescripcion", function() {
        var descripcion = $(this).data('id');
        $(".modal-body #descripcion").val(descripcion);
    });
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