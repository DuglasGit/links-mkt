<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- card tabla usuarios -->
<div class="card d-pri">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-info text-center">ORDENES DE TRABAJO COMPLETADOS</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12 col-md-4">
                <div class="form-group row justify-content-center">
                    <a type="button" href="<?php echo SERVERURL; ?>trabajos/" class="btn btn-outline-info btn-icon-text">
                        <i class="mdi mdi-calendar-clock btn-icon-prepend mdi-35px"></i>
                        <span class="d-inline-block text-left">
                            <small class="font-weight-light d-block">VER TRABAJOS PENDIENTES</small></span>
                    </a>
                </div>
            </div>
            <div class="col-sm-12 col-md-8">
                <div class="form-group row justify-content-center">
                    <div class="col-sm-10">
                        <div class="input-group border border-light rounded">
                            <input type="search" id="myInput" class="form-control form-control-sm text-light" placeholder="Buscar..." aria-controls="dataTable">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <br>
        <div class="row justify-content-center">
            <br>
            <?php
            require_once "./controllers/trabajoControlador.php";
            $ins_trabajo = new trabajoControlador();

            echo $ins_trabajo->PaginadorTrabajoTerminadoControlador($pagina[1], 10, $_SESSION['id_rol_lmr'], $_SESSION['id_lmr'], $pagina[0], "");

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

<script>
    $(document).on("click", ".open-mostrarDescripcionTerminado", function() {
        var descripcionT = $(this).data('id');
        $(".modal-body #descripcionT").val(descripcionT);
    });
</script>