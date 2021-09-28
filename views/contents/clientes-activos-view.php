<?php
require_once "./routerMIkrotik/Resources.php";
$clientes = RouterR::RouterClientes();


?>

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
                <div class="form-group row justify-content-center">
                    <label class="col-sm-2 col-form-label">Mostrar </label>
                    <select name="dataTable_length" aria-controls="dataTable" class="custom-select form-control col-sm-2 form-control-sm border-light text-info">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    <label class="col-sm-8 col-form-label">Elementos </label>

                </div>
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

        <div class="table-responsive">

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class="text-danger col-sm-1">ID</th>
                        <th class="text-danger col-sm-2">NOMBRE CLIENTE</th>
                        <th class="text-danger col-sm-2">PLAN CONTRATADO</th>
                        <th class="text-danger col-sm-2">PASSWORD</th>
                        <th class="text-danger col-sm-2">IP ADDRESS</th>
                        <th class="text-danger col-sm-3">ACCIÓN</th>
                    </tr>
                </thead>
                <tbody id="myTable">

                    <?php
                    
                    $v = json_decode($clientes, true);
                    $count=count($v);
                    
                    for ($i=0; $i<$count; $i++ ) {

                    ?>

                        <tr>

                            <td class="text-secondary"><?php echo $v[$i]['.id']; ?></td>
                            <td class="text-secondary"><?php echo $v[$i]['name']; ?></td>
                            <td class="text-secondary"><?php echo $v[$i]['profile']; ?></td>
                            <td class="text-secondary"><?php echo $v[$i]['password']; ?></td>
                            <td class="text-secondary"><?php echo $v[$i]['remote-address']; ?></td>
                            <td>
                                <button type="button" class="btn btn-inverse-primary btn-icon-text btn-sm" data-toggle="modal" data-target="#modalEditarCliente">
                                    <i class="mdi mdi-lead-pencil btn-icon-prepend"></i> Editar
                                </button>
                                <button type="button" class="btn btn-inverse-warning btn-icon-text btn-sm" data-toggle="modal" data-target="#modalSuspenderCliente">
                                    <i class="mdi mdi-lan-disconnect btn-icon-prepend"></i> Suspender
                                </button>
                                <button type="button" class="btn btn-inverse-danger btn-icon-text btn-sm" data-toggle="modal" data-target="#modalDesactivarCliente">
                                    <i class="mdi mdi-account-minus btn-icon-prepend"></i> Desactivar
                                </button>
                            </td>
                        </tr>
                        
                    <?php 
                    } ?>

                </tbody>
            </table>
        </div>
        <br>
        <div class="row justify-content-center">

            <div class="dataTables_info" id="dataTable_info" role="status" aria-live="polite">Mostrando 1 a 10 de 57 Elementos</div>
        </div>
        <br>
        <div class="row justify-content-center">
            <div class="btn-group" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-inverse-primary disabled">Anterior</button>
                <button type="button" class="btn btn-inverse-primary active">1</button>
                <button type="button" class="btn btn-inverse-primary">2</button>
                <button type="button" class="btn btn-inverse-primary">3</button>
                <button type="button" class="btn btn-inverse-primary">Siguiente</button>
            </div>
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