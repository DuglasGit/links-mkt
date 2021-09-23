
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


<!-- card contenedor de tabla de clientes -->
<div class="card">
    <div class="card-header py-3 text-center">
        <h4 class="m-0 font-weight-bold text-primary">PANEL DE FACTURACIÓN</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12 col-md-4">
                <div class="form-group row justify-content-center">
                    <label class="col-sm-3 col-form-label">Mostrar </label>
                    <select name="dataTable_length" aria-controls="dataTable" class="custom-select form-control col-sm-2 form-control-sm border-light text-info">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    <label class="col-sm-7 col-form-label">Elementos </label>

                </div>
            </div>
            <div class="col-sm-12 col-md-4">

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
                    <button type="button" class="btn btn-inverse-primary btn-icon-text btn-fw" data-toggle="modal" data-target="#modalGenerarFacturas">
                        <i class="mdi mdi-plus-circle-multiple-outline btn-icon-prepend"></i> GENERAR FACTURAS
                    </button>
                </div>

            </div>
        </div>

        <div class="table-responsive">

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class="text-primary col-sm-1">ID FACTURA</th>
                        <th class="text-primary col-sm-2">NOMBRE CLIENTE</th>
                        <th class="text-primary col-sm-2">MES A PAGAR</th>
                        <th class="text-primary col-sm-2">FECHA GENERACIÓN</th>
                        <th class="text-primary col-sm-2">ESTADO</th>
                        <th class="text-primary col-sm-3">ACCIÓN</th>
                    </tr>
                </thead>
                <tbody id="myTable">
                    <tr>
                        <td>1</td>
                        <td class="text-secondary">Anabel</td>
                        <td class="text-secondary"> Agosto</td>
                        <td class="text-secondary">01/09/2021</td>
                        <td class="text-secondary">Pagado</td>
                        <td>
                            <button type="button" class="btn btn-inverse-success btn-icon-text btn-sm" data-toggle="modal" data-target="#modalEditarFactura">
                                <i class="mdi mdi-lead-pencil btn-icon-prepend"></i> Editar
                            </button>
                            <button type="button" class="btn btn-inverse-warning btn-icon-text btn-sm" data-toggle="modal" data-target="#modalImprimirCliente">
                                <i class="z btn-icon-prepend"></i> Imprimir
                            </button>
                            <button type="button" class="btn btn-inverse-danger btn-icon-text btn-sm" data-toggle="modal" data-target="#modalEliminarFactura">
                                <i class="mdi mdi-account-minus btn-icon-prepend"></i> Eliminar
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td class="text-secondary">Jacob</td>
                        <td class="text-secondary"> Agosto</td>
                        <td class="text-secondary">01/09/2021</td>
                        <td class="text-secondary">Pagado</td>
                        <td>
                            <button type="button" class="btn btn-inverse-success btn-icon-text btn-sm" data-toggle="modal" data-target="#modalEditarFactura">
                                <i class="mdi mdi-lead-pencil btn-icon-prepend"></i> Editar
                            </button>
                            <button type="button" class="btn btn-inverse-warning btn-icon-text btn-sm" data-toggle="modal" data-target="#modalImprimirCliente">
                                <i class="z btn-icon-prepend"></i> Imprimir
                            </button>
                            <button type="button" class="btn btn-inverse-danger btn-icon-text btn-sm" data-toggle="modal" data-target="#modalEliminarFactura">
                                <i class="mdi mdi-account-minus btn-icon-prepend"></i> Eliminar
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td class="text-secondary">Peter</td>
                        <td class="text-secondary"> Agosto</td>
                        <td class="text-secondary">01/09/2021</td>
                        <td class="text-secondary">Pagado</td>
                        <td>
                            <button type="button" class="btn btn-inverse-success btn-icon-text btn-sm" data-toggle="modal" data-target="#modalEditarFactura">
                                <i class="mdi mdi-lead-pencil btn-icon-prepend"></i> Editar
                            </button>
                            <button type="button" class="btn btn-inverse-warning btn-icon-text btn-sm" data-toggle="modal" data-target="#modalImprimirCliente">
                                <i class="z btn-icon-prepend"></i> Imprimir
                            </button>
                            <button type="button" class="btn btn-inverse-danger btn-icon-text btn-sm" data-toggle="modal" data-target="#modalEliminarFactura">
                                <i class="mdi mdi-account-minus btn-icon-prepend"></i> Eliminar
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td class="text-secondary">Lorena</td>
                        <td class="text-secondary"> Agosto </td>
                        <td class="text-secondary">01/09/2021</td>
                        <td class="text-secondary">Pagado</td>
                        <td>
                            <button type="button" class="btn btn-inverse-success btn-icon-text btn-sm" data-toggle="modal" data-target="#modalEditarFactura">
                                <i class="mdi mdi-lead-pencil btn-icon-prepend"></i> Editar
                            </button>
                            <button type="button" class="btn btn-inverse-warning btn-icon-text btn-sm" data-toggle="modal" data-target="#modalImprimirCliente">
                                <i class="z btn-icon-prepend"></i> Imprimir
                            </button>
                            <button type="button" class="btn btn-inverse-danger btn-icon-text btn-sm" data-toggle="modal" data-target="#modalEliminarFactura">
                                <i class="mdi mdi-account-minus btn-icon-prepend"></i> Eliminar
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td class="text-secondary">Yolanda</td>
                        <td class="text-secondary"> Agosto </td>
                        <td class="text-secondary">01/09/2021</td>
                        <td class="text-secondary">Pagado</td>
                        <td>
                            <button type="button" class="btn btn-inverse-success btn-icon-text btn-sm" data-toggle="modal" data-target="#modalEditarFactura">
                                <i class="mdi mdi-lead-pencil btn-icon-prepend"></i> Editar
                            </button>
                            <button type="button" class="btn btn-inverse-warning btn-icon-text btn-sm" data-toggle="modal" data-target="#modalImprimirCliente">
                                <i class="z btn-icon-prepend"></i> Imprimir
                            </button>
                            <button type="button" class="btn btn-inverse-danger btn-icon-text btn-sm" data-toggle="modal" data-target="#modalEliminarFactura">
                                <i class="mdi mdi-account-minus btn-icon-prepend"></i> Eliminar
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>6</td>
                        <td class="text-secondary">Manuel</td>
                        <td class="text-secondary"> Agosto </td>
                        <td class="text-secondary">01/09/2021</td>
                        <td class="text-secondary">Pagado</td>
                        <td>
                            <button type="button" class="btn btn-inverse-success btn-icon-text btn-sm" data-toggle="modal" data-target="#modalEditarFactura">
                                <i class="mdi mdi-lead-pencil btn-icon-prepend"></i> Editar
                            </button>
                            <button type="button" class="btn btn-inverse-warning btn-icon-text btn-sm" data-toggle="modal" data-target="#modalImprimirCliente">
                                <i class="z btn-icon-prepend"></i> Imprimir
                            </button>
                            <button type="button" class="btn btn-inverse-danger btn-icon-text btn-sm" data-toggle="modal" data-target="#modalEliminarFactura">
                                <i class="mdi mdi-account-minus btn-icon-prepend"></i> Eliminar
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>7</td>
                        <td class="text-secondary">Esteban</td>
                        <td class="text-secondary"> Agosto </td>
                        <td class="text-secondary">01/09/2021</td>
                        <td class="text-secondary">Pagado</td>
                        <td>
                            <button type="button" class="btn btn-inverse-success btn-icon-text btn-sm" data-toggle="modal" data-target="#modalEditarFactura">
                                <i class="mdi mdi-lead-pencil btn-icon-prepend"></i> Editar
                            </button>
                            <button type="button" class="btn btn-inverse-warning btn-icon-text btn-sm" data-toggle="modal" data-target="#modalImprimirCliente">
                                <i class="z btn-icon-prepend"></i> Imprimir
                            </button>
                            <button type="button" class="btn btn-inverse-danger btn-icon-text btn-sm" data-toggle="modal" data-target="#modalEliminarFactura">
                                <i class="mdi mdi-account-minus btn-icon-prepend"></i> Eliminar
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>8</td>
                        <td class="text-secondary">Mayra</td>
                        <td class="text-secondary"> Agosto</td>
                        <td class="text-secondary">01/09/2021</td>
                        <td class="text-secondary">Pagado</td>
                        <td>
                            <button type="button" class="btn btn-inverse-success btn-icon-text btn-sm" data-toggle="modal" data-target="#modalEditarFactura">
                                <i class="mdi mdi-lead-pencil btn-icon-prepend"></i> Editar
                            </button>
                            <button type="button" class="btn btn-inverse-warning btn-icon-text btn-sm" data-toggle="modal" data-target="#modalImprimirCliente">
                                <i class="z btn-icon-prepend"></i> Imprimir
                            </button>
                            <button type="button" class="btn btn-inverse-danger btn-icon-text btn-sm" data-toggle="modal" data-target="#modalEliminarFactura">
                                <i class="mdi mdi-account-minus btn-icon-prepend"></i> Eliminar
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>9</td>
                        <td class="text-secondary">Silvia</td>
                        <td class="text-secondary"> Agosto</td>
                        <td class="text-secondary">01/09/2021</td>
                        <td class="text-secondary">Pagado</td>
                        <td>
                            <button type="button" class="btn btn-inverse-success btn-icon-text btn-sm" data-toggle="modal" data-target="#modalEditarFactura">
                                <i class="mdi mdi-lead-pencil btn-icon-prepend"></i> Editar
                            </button>
                            <button type="button" class="btn btn-inverse-warning btn-icon-text btn-sm" data-toggle="modal" data-target="#modalImprimirCliente">
                                <i class="z btn-icon-prepend"></i> Imprimir
                            </button>
                            <button type="button" class="btn btn-inverse-danger btn-icon-text btn-sm" data-toggle="modal" data-target="#modalEliminarFactura">
                                <i class="mdi mdi-account-minus btn-icon-prepend"></i> Eliminar
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>10</td>
                        <td class="text-secondary">Carlos</td>
                        <td class="text-secondary"> Agosto</td>
                        <td class="text-secondary">01/09/2021</td>
                        <td class="text-secondary">Pagado</td>
                        <td>
                            <button type="button" class="btn btn-inverse-success btn-icon-text btn-sm" data-toggle="modal" data-target="#modalEditarFactura">
                                <i class="mdi mdi-lead-pencil btn-icon-prepend"></i> Editar
                            </button>
                            <button type="button" class="btn btn-inverse-warning btn-icon-text btn-sm" data-toggle="modal" data-target="#modalImprimirCliente">
                                <i class="z btn-icon-prepend"></i> Imprimir
                            </button>
                            <button type="button" class="btn btn-inverse-danger btn-icon-text btn-sm" data-toggle="modal" data-target="#modalEliminarFactura">
                                <i class="mdi mdi-account-minus btn-icon-prepend"></i> Eliminar
                            </button>
                        </td>
                    </tr>

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