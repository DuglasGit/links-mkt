<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


<div class="row">
    <div class="card-body text-center">
        <div class="btn-group" role="group" aria-label="Basic example">
            <a type="button" href="<?php echo SERVERURL; ?>facturacion/" class="btn btn-outline-secondary">
                <i class="mdi mdi-file-check d-block mb-1"></i> Ver Facturas No Pagadas </a>
            <a type="button" href="<?php echo SERVERURL; ?>facturas-canceladas/" class="btn btn-outline-secondary">
                <i class="mdi mdi-file-check d-block mb-1"></i> Ver Factruas Pagadas Hoy </a>
        </div>
    </div>
</div>

<?php
if (!isset($_SESSION['busqueda_factura_historial']) && empty($_SESSION['busqueda_factura_historial'])) {
?>
    <!-- card tabla usuarios -->
    <div class="card d-pri">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-light text-center">HISTORIAL DE PAGOS REALIZADOS HASTA LA FECHA</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12 col-md-10">
                    <form class="form-inline FormularioAjax" action="<?php echo SERVERURL; ?>ajax/buscadorAjax.php" method="POST" data-form="search" autocomplete="off">
                        <input type="hidden" name="modulo" value="factura_historial">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="search" class="form-control" name="busqueda_inicial" id="busqueda_inicial" placeholder="Buscar Cliente" aria-label="Buscar Cliente" aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <button class="btn btn-sm btn-inverse-primary" type="submit">Buscar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <br>
            <div class="row justify-content-center">
                <br>
                <?php
                require_once "./controllers/facturaControlador.php";
                $ins_trabajo = new facturaControlador();

                echo $ins_trabajo->PaginadorHistorialFacturasCanceladasControlador($pagina[1], 10, $_SESSION['id_rol_lmr'], $_SESSION['id_lmr'], $pagina[0], "");

                ?>
            </div>

        </div>

    </div>

<?php } else { ?>

    <!-- card tabla facturas -->
    <div class="card d-pri">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-light text-center">HISTORIAL DE PAGOS REALIZADOS HASTA LA FECHA</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12 col-md-10">
                    <form class="form-inline FormularioAjax" action="<?php echo SERVERURL; ?>ajax/buscadorAjax.php" method="POST" data-form="search-delete" autocomplete="off">
                        <input type="hidden" name="modulo" value="factura_historial">
                        <input type="hidden" name="eliminar_busqueda" value="eliminar">
                        <div class="my-1 mr-sm-2 flexbox">
                            <label class="text-warning">“Resultados de la Búsqueda=><?php echo $_SESSION['busqueda_factura_historial']; ?>”</label>
                        </div>

                        <button type="submit" class="btn btn-sm btn-inverse-danger"><i class="far fa-trash-alt"></i> &nbsp; ELIMINAR BÚSQUEDA</button>

                    </form>
                </div>
            </div>

            <br>
            <div class="row justify-content-center">
                <br>
                <?php
                require_once "./controllers/facturaControlador.php";
                $ins_trabajo = new facturaControlador();

                echo $ins_trabajo->PaginadorHistorialFacturasCanceladasControlador($pagina[1], 10, $_SESSION['id_rol_lmr'], $_SESSION['id_lmr'], $pagina[0], $_SESSION['busqueda_factura_historial']);

                ?>
            </div>

        </div>

    </div>

<?php } ?>


<!-- script buscador tabla -->
<script>
    $(document).ready(function() {
        $("#busqueda_inicial").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTable tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
