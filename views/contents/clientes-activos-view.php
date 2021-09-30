<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

<!-- card contenedor de botones -->
<div class="card grid-margin">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12 col-md-4">
                <div class="form-group row justify-content-center">
                    <button type="button" class="btn btn-inverse-primary btn-icon-text btn-fw" data-toggle="modal" data-target="#modalNuevoPlan">
                        <i class="mdi mdi-plus-circle-multiple-outline btn-icon-prepend"></i> NUEVO PLAN
                    </button>
                </div>
            </div>
            <div class="col-sm-12 col-md-4">
                <div class="form-group row justify-content-center">
                    <button type="button" class="btn btn-inverse-success btn-icon-text btn-fw" data-toggle="modal" data-target="#modalNuevoCliente">
                        <i class="mdi mdi-plus-circle-multiple-outline btn-icon-prepend"></i> NUEVO CLIENTE
                    </button>
                </div>
            </div>
            <div class="col-sm-12 col-md-4">
                <div class="form-group row justify-content-center">
                    <button type="button" class="btn btn-inverse-secondary btn-icon-text btn-fw" data-toggle="modal" data-target="#modalNuevoContrato">
                        <i class="mdi mdi-plus-circle-multiple-outline btn-icon-prepend"></i> NUEVO CONTRATO
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- card contenedor de tabla de clientes -->
<div class="card">
    <div class="card-header py-3 text-center">
        <h4 class="m-0 font-weight-bold text-danger">CLIENTES PPPOE ACTIVOS</h4>
    </div>
    <div class="card-body">

        <div class="row">
            <div class="col-sm-12 col-md-6">
            </div>
            <div class="col-sm-12 col-md-6">

                <div class="form-group row justify-content-center>
                    <label class=" col-sm-2 col-form-label text-right">Buscar: </label>
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
            require_once "./controllers/clientesControlador.php";
            $ins_usuario = new clientesControlador();

            echo $ins_usuario->PaginadorClientesControlador($pagina[1], 10, $_SESSION['id_rol_lmr'], $_SESSION['id_lmr'], $pagina[0], "");

            ?>
        </div>
    </div>

</div>

<!----Script para buscar en tablas -->
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

<!----Script para datepicker -->
<script>
    $(function() {
        $('[data-toggle="datepicker"]').datepicker({
            autoHide: true,
            zIndex: 2048,
            format: "dd/mm/yyyy",
            language: "es"

        });
    });
</script>