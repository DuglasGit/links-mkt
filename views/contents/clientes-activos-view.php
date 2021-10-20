<?php
if ($_SESSION['id_rol_lmr'] >3) {
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
    <!-- card contenedor de tabla de clientes -->
    <div class="card">
        <div class="card-header py-3 text-center">
            <h4 class="m-0 font-weight-bold text-danger">CLIENTES PPPOE ACTIVOS</h4>
        </div>
        <div class="card-body">

            <div class="row">
                <div class="col-sm-12 col-md-4">
                    <div class="form-group row justify-content-center">
                        <a href="<?php echo SERVERURL; ?>nuevo-cliente/" type="button" class="btn btn-inverse-primary btn-icon-text btn-fw">
                            <i class="mdi mdi-plus-circle-multiple-outline btn-icon-prepend"></i> NUEVO CLIENTE
                        </a>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4">
                    <div class="form-group row justify-content-center">
                        <a href="<?php echo SERVERURL; ?>clientes-suspendidos/" type="button" class="btn btn-inverse-warning btn-icon-text btn-fw">
                            <i class="mdi mdi-plus-circle-multiple-outline btn-icon-prepend"></i> VER CLIENTES SUSPENDIDOS
                        </a>
                    </div>
                </div>
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
                require_once "./controllers/clienteControlador.php";
                $ins_cliente = new clienteControlador();

                echo $ins_cliente->PaginadorClientesActivosControlador($pagina[1], 10, $_SESSION['id_rol_lmr'], $_SESSION['id_lmr'], $pagina[0], "");

                ?>
            </div>
        </div>

    </div>
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