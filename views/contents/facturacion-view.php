<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


<div class="row">
    <div class="card-body text-center">
        <div class="btn-group" role="group" aria-label="Basic example">
            <button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#modalGenerarFacturas">
                <i class="mdi mdi-file-multiple d-block mb-1"></i> Generar Facturas del Mes </button>
            <button type="button" class="btn btn-outline-secondary">
                <i class="mdi mdi-file d-block mb-1"></i> Generar Facturas Individuales </button>
            <a type="button" class="btn btn-outline-secondary" href="<?php echo SERVERURL; ?>factura-search/">
                <i class="mdi mdi-cash-multiple d-block mb-1"></i> Realizar Nuevo Pago </a>
            <a type="button" href="<?php echo SERVERURL; ?>facturas-canceladas/" class="btn btn-outline-secondary">
                <i class="mdi mdi-file-check d-block mb-1"></i> Listar Facturas Pagadas </a>
        </div>
    </div>
</div>

<!-- card tabla usuarios -->
<div class="card d-pri">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-light text-center">LISTA DE FACTURAS PENDIENTE DE PAGO</h6>
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
            require_once "./controllers/facturaControlador.php";
            $ins_trabajo = new facturaControlador();

            echo $ins_trabajo->PaginadorFacturasPendientesControlador($pagina[1], 15, $_SESSION['id_rol_lmr'], $_SESSION['id_lmr'], $pagina[0], "");

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