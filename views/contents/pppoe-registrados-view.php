<?php
if ($_SESSION['id_rol_lmr'] > 3) {
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
require_once "./routerMIkrotik/Resources.php";
$data = RouterR::RouterClientes();


?>

<?php
if ($data == "Desconectado") {
    echo
    '
<div clas="row">
<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>ATENCIÓN!</strong> No se ha podio establecer comunicación con el Router Mikrotik
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
</div>
';
} else {

?>


    <div class="row justify-content-center">
        <div class="card-title">
            <div class="row">
                <div class="col-sm-12 col-md-auto">
                    <div class="form-group row justify-content-center">
                        <a href="<?php echo SERVERURL; ?>nuevo-cliente/" type="button" class="btn btn-outline-danger btn-icon-text btn-fw btn-lg">
                            <i class="mdi mdi-plus-circle-multiple-outline btn-icon-prepend"></i> NUEVO CLIENTE
                        </a>
                    </div>
                </div>
                <div class="col-sm-12 col-md-auto">
                    <div class="form-group row justify-content-center">
                        <a href="<?php echo SERVERURL; ?>pppoe-activos/" type="button" class="btn btn-outline-danger btn-icon-text btn-fw btn-lg">
                            <i class="mdi mdi-plus-circle-multiple-outline btn-icon-prepend"></i> CLIENTES ACTIVOS
                        </a>
                    </div>
                </div>
                <div class="col-sm-12 col-md-auto">
                    <div class="form-group row justify-content-center">
                        <a href="<?php echo SERVERURL; ?>pppoe-suspendidos/" type="button" class="btn btn-outline-danger btn-icon-text btn-fw btn-lg">
                            <i class="mdi mdi-plus-circle-multiple-outline btn-icon-prepend"></i> CLIENTES SUSPENDIDOS
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    if (!isset($_SESSION['busqueda_cli_registrados']) && empty($_SESSION['busqueda_cli_registrados'])) {
    ?>
        <!-- card tabla clientes registrados -->
        <div class="card d-pri">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-light text-center">LISTA DE CLIENTES PPPOE REGISTRADOS EN EL ROUTER MIKROTIK</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12 col-md-auto">
                        <form class="form-inline FormularioAjax" action="<?php echo SERVERURL; ?>ajax/buscadorAjax.php" method="POST" data-form="search" autocomplete="off">
                            <input type="hidden" name="modulo" value="cli_registrados">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="search" class="form-control d-inp-danger" name="busqueda_inicial" id="busqueda_inicial" placeholder="Buscar Cliente" aria-label="Buscar Cliente" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <button class="btn btn-sm btn-inverse-danger" type="submit">Buscar</button>
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
                    require_once "./controllers/pppoeControlador.php";
                    $ins_cliente = new pppoeControlador();

                    echo $ins_cliente->PaginadorClientesRegistradosControlador($pagina[1], 10, $_SESSION['id_rol_lmr'], $_SESSION['id_lmr'], $pagina[0], "");

                    ?>
                </div>

            </div>

        </div>

    <?php } else { ?>

        <!-- card tabla clientes registrados -->
        <div class="card d-pri">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-light text-center">LISTA DE CLIENTES PPPOE REGISTRADOS EN EL ROUTER MIKROTIK</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12 col-md-10">
                        <form class="form-inline FormularioAjax" action="<?php echo SERVERURL; ?>ajax/buscadorAjax.php" method="POST" data-form="search-delete" autocomplete="off">
                            <input type="hidden" name="modulo" value="cli_registrados">
                            <input type="hidden" name="eliminar_busqueda" value="eliminar">
                            <div class="my-1 mr-sm-2 flexbox">
                                <label class="text-warning">“Resultados de la Búsqueda=><?php echo $_SESSION['busqueda_cli_registrados']; ?>”</label>
                            </div>

                            <button type="submit" class="btn btn-sm btn-inverse-danger"><i class="far fa-trash-alt"></i> &nbsp; ELIMINAR BÚSQUEDA</button>

                        </form>
                    </div>
                </div>

                <br>
                <div class="row justify-content-center">
                    <br>
                    <?php
                    require_once "./controllers/pppoeControlador.php";
                    $ins_cliente = new pppoeControlador();

                    echo $ins_cliente->PaginadorClientesRegistradosControlador($pagina[1], 10, $_SESSION['id_rol_lmr'], $_SESSION['id_lmr'], $pagina[0], $_SESSION['busqueda_cli_registrados']);

                    ?>
                </div>

            </div>

        </div>

    <?php } ?>


    <!-- card contenedor de tabla de clientes
    <div class="card">

        <div class="card-header py-3 text-center">
            <h4 class="m-0 font-weight-bold text-danger">CLIENTES PPPOE REGISTRADOS EN EL ROUTER MIKROTIK</h4>
        </div>
        <div class="card-body">


            <div class="row">

                <div class="col-sm-12 col-md-4">
                    <div class="form-group row justify-content-center">
                        <div class="input-group border border-light rounded">
                            <input type="search" id="myInput" class="form-control form-control-sm text-light" placeholder="Buscar..." aria-controls="dataTable">
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="row justify-content-center">
                <br>
                <?php
                require_once "./controllers/pppoeControlador.php";
                $ins_cliente = new pppoeControlador();

                echo $ins_cliente->PaginadorClientesRegistradosControlador($pagina[1], 10, $_SESSION['id_rol_lmr'], $_SESSION['id_lmr'], $pagina[0], "");

                ?>
            </div>
        </div>

    </div> -->
<?php } ?>



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