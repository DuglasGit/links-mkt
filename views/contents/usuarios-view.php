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


<!-- card tabla usuarios -->
<div class="card d-pri">
    <div class="card-header py-3 text-center">
        <h6 class="m-0 font-weight-bold text-warning">LISTA DE USUARIOS REGISTRADOS EN EL SISTEMA</h6>
    </div>
    <div class="card-body">
        <div class="row">

            <div class="col-sm-12 col-md-8">

                <div class="form-group row justify-content-center>
                    <label class=" col-sm-2 col-form-label text-right">Buscar: </label>
                    <div class="col-sm-10">
                        <div class="input-group border border-light rounded">
                            <input type="search" id="myInput" class="form-control form-control-sm text-light" placeholder="Buscar..." aria-controls="dataTable">
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-sm-12 col-md-4">

                <div class="form-group row justify-content-center">
                    <button type="button" class="btn btn-inverse-primary btn-icon-text btn-fw" data-toggle="modal" data-target="#modalNuevoUsuario">
                        <i class="mdi mdi-plus-circle-multiple-outline btn-icon-prepend"></i> NUEVO USUARIO
                    </button>
                </div>

            </div>
        </div>

        <br>
        <div class="row justify-content-center">
            <br>
            <?php
            require_once "./controllers/usuarioControlador.php";
            $ins_usuario = new usuarioControlador();

            echo $ins_usuario->PaginadorUsuarioControlador($pagina[1], 10, $_SESSION['id_rol_lmr'], $_SESSION['id_lmr'], $pagina[0], "");

            ?>
        </div>
    </div>

</div>










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