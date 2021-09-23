<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


<div class="card">
    <div class="card-header py-3 text-center">
        <h4 class="m-0 font-weight-bold text-danger">CLIENTES PPPOE INACTIVOS</h4>
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
                        <th class="text-danger col-sm-2">ID</th>
                        <th class="text-danger col-sm-4">NOMBRE</th>
                        <th class="text-danger col-sm-2">ROLL</th>
                        <th class="text-danger col-sm-4">ACCIÓN</th>
                    </tr>
                </thead>
                <tbody id="myTable">
                    <tr>
                        <td>1</td>
                        <td class="text-secondary">Anabel</td>
                        <td class="text-secondary"> Oficina <i class="mdi mdi-office"></i></td>
                        <td>
                            <button type="button" class="btn btn-inverse-warning btn-icon-text" data-toggle="modal" data-target="#modalReactivarCliente">
                                <i class="mdi mdi-lead-pencil btn-icon-prepend"></i> Reactivar
                            </button>
                            <button type="button" class="btn btn-inverse-danger btn-icon-text" data-toggle="modal" data-target="#modalEliminarCliente">
                                <i class="mdi mdi-delete-sweep btn-icon-prepend"></i> Eliminar
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td class="text-secondary">Jacob</td>
                        <td class="text-warning"> Técnico de redes <i class="mdi mdi-worker"></i></td>
                        <td>
                            <button type="button" class="btn btn-inverse-warning btn-icon-text" data-toggle="modal" data-target="#modalReactivarCliente">
                                <i class="mdi mdi-lead-pencil btn-icon-prepend"></i> Reactivar
                            </button>
                            <button type="button" class="btn btn-inverse-danger btn-icon-text" data-toggle="modal" data-target="#modalEliminarCliente">
                                <i class="mdi mdi-delete-sweep btn-icon-prepend"></i> Eliminar
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td class="text-secondary">Peter</td>
                        <td class="text-success"> Administrador <i class="mdi mdi-key-plus"></i></td>
                        <td>
                            <button type="button" class="btn btn-inverse-warning btn-icon-text" data-toggle="modal" data-target="#modalReactivarCliente">
                                <i class="mdi mdi-lead-pencil btn-icon-prepend"></i> Reactivar
                            </button>
                            <button type="button" class="btn btn-inverse-danger btn-icon-text" data-toggle="modal" data-target="#modalEliminarCliente">
                                <i class="mdi mdi-delete-sweep btn-icon-prepend"></i> Eliminar
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td class="text-secondary">Lorena</td>
                        <td class="text-success"> Administrador <i class="mdi mdi-key-plus"></i></td>
                        <td>
                            <button type="button" class="btn btn-inverse-warning btn-icon-text" data-toggle="modal" data-target="#modalReactivarCliente">
                                <i class="mdi mdi-lead-pencil btn-icon-prepend"></i> Reactivar
                            </button>
                            <button type="button" class="btn btn-inverse-danger btn-icon-text" data-toggle="modal" data-target="#modalEliminarCliente">
                                <i class="mdi mdi-delete-sweep btn-icon-prepend"></i> Eliminar
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td class="text-secondary">Yolanda</td>
                        <td class="text-secondary"> Oficina <i class="mdi mdi-office"></i></td>
                        <td>
                            <button type="button" class="btn btn-inverse-warning btn-icon-text" data-toggle="modal" data-target="#modalReactivarCliente">
                                <i class="mdi mdi-lead-pencil btn-icon-prepend"></i> Reactivar
                            </button>
                            <button type="button" class="btn btn-inverse-danger btn-icon-text" data-toggle="modal" data-target="#modalEliminarCliente">
                                <i class="mdi mdi-delete-sweep btn-icon-prepend"></i> Eliminar
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>6</td>
                        <td class="text-secondary">Manuel</td>
                        <td class="text-secondary"> Oficina <i class="mdi mdi-office"></i></td>
                        <td>
                            <button type="button" class="btn btn-inverse-warning btn-icon-text" data-toggle="modal" data-target="#modalReactivarCliente">
                                <i class="mdi mdi-lead-pencil btn-icon-prepend"></i> Reactivar
                            </button>
                            <button type="button" class="btn btn-inverse-danger btn-icon-text" data-toggle="modal" data-target="#modalEliminarCliente">
                                <i class="mdi mdi-delete-sweep btn-icon-prepend"></i> Eliminar
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>7</td>
                        <td class="text-secondary">Esteban</td>
                        <td class="text-warning"> Técnico de redes <i class="mdi mdi-worker"></i></td>
                        <td>
                            <button type="button" class="btn btn-inverse-warning btn-icon-text" data-toggle="modal" data-target="#modalReactivarCliente">
                                <i class="mdi mdi-lead-pencil btn-icon-prepend"></i> Reactivar
                            </button>
                            <button type="button" class="btn btn-inverse-danger btn-icon-text" data-toggle="modal" data-target="#modalEliminarCliente">
                                <i class="mdi mdi-delete-sweep btn-icon-prepend"></i> Eliminar
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>8</td>
                        <td class="text-secondary">Mayra</td>
                        <td class="text-warning"> Técnico de redes <i class="mdi mdi-worker"></i></td>
                        <td>
                            <button type="button" class="btn btn-inverse-warning btn-icon-text" data-toggle="modal" data-target="#modalReactivarCliente">
                                <i class="mdi mdi-lead-pencil btn-icon-prepend"></i> Reactivar
                            </button>
                            <button type="button" class="btn btn-inverse-danger btn-icon-text" data-toggle="modal" data-target="#modalEliminarCliente">
                                <i class="mdi mdi-delete-sweep btn-icon-prepend"></i> Eliminar
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>9</td>
                        <td class="text-secondary">Silvia</td>
                        <td class="text-secondary"> Oficina <i class="mdi mdi-office"></i></td>
                        <td>
                            <button type="button" class="btn btn-inverse-warning btn-icon-text" data-toggle="modal" data-target="#modalReactivarCliente">
                                <i class="mdi mdi-lead-pencil btn-icon-prepend"></i> Reactivar
                            </button>
                            <button type="button" class="btn btn-inverse-danger btn-icon-text" data-toggle="modal" data-target="#modalEliminarCliente">
                                <i class="mdi mdi-delete-sweep btn-icon-prepend"></i> Eliminar
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>10</td>
                        <td class="text-secondary">Carlos</td>
                        <td class="text-warning"> Técnico de redes <i class="mdi mdi-worker"></i></td>
                        <td>
                            <button type="button" class="btn btn-inverse-warning btn-icon-text" data-toggle="modal" data-target="#modalReactivarCliente">
                                <i class="mdi mdi-lead-pencil btn-icon-prepend"></i> Reactivar
                            </button>
                            <button type="button" class="btn btn-inverse-danger btn-icon-text" data-toggle="modal" data-target="#modalEliminarCliente">
                                <i class="mdi mdi-delete-sweep btn-icon-prepend"></i> Eliminar
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

<div class="modal fade" id="modalNuevoUsuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog border border-primary rounded" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">NUEVO USUARIO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">NOMBRE USUARIO</label>
                        <input type="text" class="form-control border-primary text-light">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">PASSWORD USUARIO</label>
                        <input type="text" class="form-control border-primary text-light">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">ROL USUARIO</label>
                        <select class="custom-select custom-select-sm form-control form-control border-primary text-light">
                            <option selected>Elegir...</option>
                            <option value="1">Administrador</option>
                            <option value="2">Oficina</option>
                            <option value="3">Técnico de Redes</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-inverse-warning" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-inverse-primary">Registrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalReactivarCliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog border border-warning rounded" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Reactivar DATOS DE USUARIO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">NOMBRE USUARIO</label>
                        <input type="text" class="form-control border-warning text-warning" value="Nombre de Usuario">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">PASSWORD USUARIO</label>
                        <input type="text" class="form-control border-warning text-warning" value="AbcPass">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">ROL USUARIO</label>
                        <select class="custom-select custom-select-sm form-control form-control border-warning text-warning">
                            <option selected>Elegir...</option>
                            <option value="1">Administrador</option>
                            <option value="2">Oficina</option>
                            <option value="3">Técnico de Redes</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-inverse-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-inverse-warning">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEliminarCliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog border border-danger rounded" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-warning" id="exampleModalLabel">ATENCIÓN</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h3 class="modal-title text-danger" id="exampleModalLabel">Se eliminará al usuario USUARIO</h3>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-inverse-warning" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-inverse-danger">Confirmar</button>
            </div>
        </div>
    </div>
</div>

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