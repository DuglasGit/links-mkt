<!--============ MODALES DE USUARIO ============-->
<!-- modal nuevo usuario -->
<div class="modal fade" id="modalNuevoUsuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog border border-primary rounded d-md-primary" role="document">
        <div class="modal-content d-mc-primary">
            <div class="modal-header">
                <h5 class="modal-title w-100 text-center" id="exampleModalLabel">NUEVO USUARIO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="FormularioAjax" action="<?php echo SERVERURL; ?>ajax/usuarioAjax.php" method="POST" data-form="save" autocomplete="off">
                <div class="modal-body">

                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">NOMBRE USUARIO</label>
                        <input type="text" class="form-control border-primary text-light d-inp-primary" name="nombre_reg" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,100}" maxlength="100" required="">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">PASSWORD USUARIO</label>
                        <input type="text" class="form-control border-primary text-light d-inp-primary" name="password_reg" pattern="[a-zA-Z0-9$@.-]{7,25}" maxlength="25" required="">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">CONFIRMAR PASSWORD USUARIO</label>
                        <input type="text" class="form-control border-primary text-light d-inp-primary" name="re_password_reg" pattern="[a-zA-Z0-9$@.-]{8,25}" maxlength="25" required="">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">ROL USUARIO</label>
                        <select class="custom-select custom-select-sm form-control border-primary text-light d-inp-primary" name="rol_reg">
                            <option value="" selected="">Elegir...</option>
                            <option value="1">Administrador</option>
                            <option value="2">Oficina</option>
                            <option value="3">Técnico de Redes</option>
                        </select>
                    </div>

                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-inverse-warning" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-inverse-primary">Registrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- modal modalEditarUsuario -->
<div class="modal fade" id="modalEditarUsuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog border border-warning rounded d-md-warning" role="document">
        <div class="modal-content d-mc-warning">
            <div class="modal-header">
                <h5 class="modal-title w-100 text-center" id="exampleModalLabel">EDITAR DATOS DE USUARIO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                    <input type="text" hidden="" class="form-control border-warning text-warning d-inp-warning" name="" id="idUsuario">
                        <label for="recipient-name" class="col-form-label">NOMBRE USUARIO</label>
                        <input type="text" class="form-control border-warning text-warning d-inp-warning" name="" id="nombreUsuario">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">PASSWORD USUARIO</label>
                        <input type="text" class="form-control border-warning text-warning d-inp-warning" name="" id="passwordUsuario">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">ROL USUARIO</label>
                        <select class="custom-select custom-select-sm form-control form-control border-warning text-warning d-inp-warning" name="" id="rolUsuario">
                            <option selected>Elegir...</option>
                            <option value="1">Administrador</option>
                            <option value="2">Oficina</option>
                            <option value="3">Técnico de Redes</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-inverse-danger" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-inverse-warning submitBtn">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>

<!-- modal eliminar usuario -->
<div class="modal fade" id="modalEliminarUsuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog d-md-danger d-bdr-danger" role="document">
        <div class="modal-content d-mc-black">
            <div class="modal-header d-bdr-black">
                <h5 class="modal-title text-warning w-100 text-center" id="exampleModalLabel">ATENCIÓN</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h3 class="modal-title text-danger w-100 text-center" id="exampleModalLabel">Se eliminará al usuario USUARIO</h3>
            </div>
            <div class="modal-footer d-bdr-black justify-content-center">
                <button type="button" class="btn btn-inverse-warning" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-inverse-danger">Confirmar</button>
            </div>
        </div>
    </div>
</div>





<!--============ MODALES DE CLIENTES ACTIVOS ============-->

<!-- modal de nuevo plan -->
<div class="modal fade" id="modalNuevoPlan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog border border-primary rounded d-md-primary" role="document">
        <div class="modal-content d-mc-primary">
            <div class="modal-header">
                <h5 class="modal-title text-center w-100 text-center" id="exampleModalLabel">NUEVO PLAN</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">NOMBRE PLAN</label>
                        <input type="text" class="form-control border-primary text-light d-inp-light">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">VELOCIDAD NAVEGACIÓN</label>
                        <input type="text" class="form-control border-primary text-light d-inp-light">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">LÍMITE SUBIDA</label>
                        <input type="text" class="form-control border-primary text-light d-inp-light">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">LÍMITE DESCARGA</label>
                        <input type="text" class="form-control border-primary text-light d-inp-light">
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-inverse-warning" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-inverse-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- modal de nuevo Cliente -->
<div class="modal fade" id="modalNuevoCliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog border border-success rounded d-md-success" role="document">
        <div class="modal-content d-mc-success">
            <div class="modal-header">
                <h5 class="modal-title text-center w-100 text-center" id="exampleModalLabel">NUEVO CLIENTE</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Nombre Cliente</label>
                        <input type="text" class="form-control border-success d-t-black d-inp-light">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Municipio</label>
                        <select class="custom-select custom-select-sm form-control form-control border-success d-t-black d-inp-light">
                            <option selected>Elegir...</option>
                            <option value="1">Municipio 1</option>
                            <option value="2">Municipio 2</option>
                            <option value="3">Municipio 3</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Domicilio</label>
                        <input type="text" class="form-control border-success d-t-black d-inp-light">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Tipo Cliente</label>
                        <select class="custom-select custom-select-sm form-control form-control border-success d-t-black d-inp-light">
                            <option selected>Elegir...</option>
                            <option value="1">Residencial</option>
                            <option value="2">Corporativo</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-inverse-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-inverse-success">Registrar</button>
            </div>
        </div>
    </div>
</div>

<!-- modal de nuevo Contrato -->
<div class="modal fade" id="modalNuevoContrato" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog d-bdr-black rounded d-md-light" role="document">
        <div class="modal-content d-mc-light">
            <div class="modal-header d-bdr-black">
                <h5 class="modal-title text-center w-100 text-center" id="exampleModalLabel">NUEVO CONTRATO PARA CLIENTE</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Cliente</label>
                        <select class="custom-select custom-select-sm form-control form-control d-bdr-black d-t-black d-inp-light">
                            <option selected>Elegir...</option>
                            <option value="1">Cliente Nuevo 1</option>
                            <option value="2">Cliente Nuevo 2</option>
                            <option value="3">Cliente Nuevo 3</option>
                        </select>
                    </div>
                    <div class="form-group">

                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Fecha Contrato</label>
                        <input type="text" class="form-control d-t-black d-inp-light d-bdr-black d-inp-light" data-toggle="datepicker">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Plan</label>
                        <select class="custom-select custom-select-sm form-control form-control d-bdr-black d-t-black d-inp-light">
                            <option selected>Elegir...</option>
                            <option value="1">Residencial Básico</option>
                            <option value="2">Residencial Profesional</option>
                            <option value="3">Residencial Premium</option>
                            <option value="4">Residencial Corporativo</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Estado Contrato</label>
                        <input type="text" class="form-control d-bdr-black d-t-black d-inp-light" value="1">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">IP Asignada</label>
                        <input type="text" class="form-control d-bdr-black d-t-black d-inp-light">
                    </div>

                </form>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-inverse-warning" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-inverse-secondary">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- modal de Editar Cliente -->
<div class="modal fade" id="modalEditarCliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog border border-primary rounded d-md-primary" role="document">
        <div class="modal-content d-mc-primary">
            <div class="modal-header">
                <h5 class="modal-title text-center w-100 text-center" id="exampleModalLabel">EDITAR DATOS DEL CLIENTE</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Nombre Cliente</label>
                        <input type="text" class="form-control border-primary d-t-black d-inp-light">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Municipio</label>
                        <select class="custom-select custom-select-sm form-control form-control border-primary d-t-black d-inp-light">
                            <option selected>Elegir...</option>
                            <option value="1">Municipio 1</option>
                            <option value="2">Municipio 2</option>
                            <option value="3">Municipio 3</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Domicilio</label>
                        <input type="text" class="form-control border-primary d-t-black d-inp-light">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Tipo Cliente</label>
                        <select class="custom-select custom-select-sm form-control form-control border-primary d-t-black d-inp-light">
                            <option selected>Elegir...</option>
                            <option value="1">Residencial</option>
                            <option value="2">Corporativo</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-inverse-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-inverse-warning">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Suspender Cliente -->
<div class="modal fade" id="modalSuspenderCliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog d-md-warning d-bdr-warning rounded" role="document">
        <div class="modal-content d-mc-black">
            <div class="modal-header d-bdr-black">
                <h5 class="modal-title w-100 text-center text-warning" id="exampleModalLabel">ATENCIÓN</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h3 class="modal-title text-center text-warning" id="exampleModalLabel">Se suspenderán los servicios de red del cliente ABC</h3>
            </div>
            <div class="modal-footer justify-content-center d-bdr-black">
                <button type="button" class="btn btn-inverse-primary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-inverse-warning">Confirmar</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal de Desactivar Cliente -->
<div class="modal fade" id="modalDesactivarCliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog d-md-danger d-bdr-danger" role="document">
        <div class="modal-content d-mc-black">
            <div class="modal-header d-bdr-black">
                <h5 class="modal-title w-100 text-center text-light" id="exampleModalLabel">ATENCIÓN</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h3 class="modal-title text-center text-danger" id="exampleModalLabel">Se desactivarán los servicios de red del cliente ABC</h3>
            </div>
            <div class="modal-footer justify-content-center d-bdr-black">
                <button type="button" class="btn btn-inverse-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-inverse-danger">Confirmar</button>
            </div>
        </div>
    </div>
</div>




<!--============ MODALES DE CLIENTES SUSPENDIDOS ============-->

<!-- Modal de Reactivar Cliente -->
<div class="modal fade" id="modalReactivarCliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog d-md-primary d-bdr-primary rounded" role="document">
        <div class="modal-content d-mc-primary">
            <div class="modal-header d-bdr-black">
                <h5 class="modal-title w-100 text-center text-primary" id="exampleModalLabel">ATENCIÓN</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h3 class="modal-title text-center text-light" id="exampleModalLabel">Se Reactivarán los servicios de red del cliente ABC</h3>
            </div>
            <div class="modal-footer justify-content-center d-bdr-black">
                <button type="button" class="btn btn-inverse-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-inverse-primary">Confirmar</button>
            </div>
        </div>
    </div>
</div>


<!--============ MODALES DE CLIENTES INACTIVOS ============-->
<!-- Modal de Eliminar Cliente -->
<div class="modal fade" id="modalEliminarCliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog d-md-danger d-bdr-danger" role="document">
        <div class="modal-content d-mc-black">
            <div class="modal-header d-bdr-black">
                <h5 class="modal-title w-100 text-center text-light" id="exampleModalLabel">ATENCIÓN</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h3 class="modal-title text-center text-danger" id="exampleModalLabel">Se eliminarán permanentemente los servicios de red del cliente ABC</h3>
            </div>
            <div class="modal-footer justify-content-center d-bdr-black">
                <button type="button" class="btn btn-inverse-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-inverse-danger">Confirmar</button>
            </div>
        </div>
    </div>
</div>



<!--============ MODALES DE CONTRATOS DE CLIENTES ============-->
<!-- modal de Editar Contrato -->
<div class="modal fade" id="modalEditarContrato" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog d-bdr-black rounded d-md-light" role="document">
        <div class="modal-content d-mc-primary">
            <div class="modal-header d-bdr-black">
                <h5 class="modal-title text-center w-100 text-center" id="exampleModalLabel">EDITAR DATOS DE CONTRATO PARA CLIENTE</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Cliente</label>
                        <select class="custom-select custom-select-sm form-control form-control d-bdr-black d-t-black d-inp-light">
                            <option selected>Cliente Nuevo 1</option>
                            <option value="1">Cliente Nuevo 1</option>
                            <option value="2">Cliente Nuevo 2</option>
                            <option value="3">Cliente Nuevo 3</option>
                        </select>
                    </div>
                    <div class="form-group">

                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Fecha Contrato</label>
                        <input type="text" class="form-control d-t-black d-inp-light d-bdr-black d-inp-light" data-toggle="datepicker" value="01/01/2021">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Plan</label>
                        <select class="custom-select custom-select-sm form-control form-control d-bdr-black d-t-black d-inp-light">
                            <option selected>Residencial Básico</option>
                            <option value="1">Residencial Básico</option>
                            <option value="2">Residencial Profesional</option>
                            <option value="3">Residencial Premium</option>
                            <option value="4">Residencial Corporativo</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Estado Contrato</label>
                        <input type="text" class="form-control d-bdr-black d-t-black d-inp-light" value="1">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">IP Asignada</label>
                        <input type="text" class="form-control d-bdr-black d-t-black d-inp-light" value="192.168.0.100">
                    </div>

                </form>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-inverse-warning" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-inverse-secondary">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Eliminar Contrato -->
<div class="modal fade" id="modalEliminarContrato" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog d-md-danger d-bdr-danger" role="document">
        <div class="modal-content d-mc-black">
            <div class="modal-header d-bdr-black">
                <h5 class="modal-title text-center text-light w-100 text-center" id="exampleModalLabel">ATENCIÓN</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h3 class="modal-title text-center text-danger w-100 text-center"" id=" exampleModalLabel">Se eliminará permanentemente el contrato del cliente ABC y se desvincularán los servicios de red asociados</h3>
            </div>
            <div class="modal-footer justify-content-center d-bdr-black">
                <button type="button" class="btn btn-inverse-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-inverse-danger">Confirmar</button>
            </div>
        </div>
    </div>
</div>



<!--============ MODALES DE CONTRATOS DE CLIENTES ============-->
<!-- modal Editar Facturas -->
<div class="modal fade" id="modalEditarFactura" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog border border-primary rounded d-md-primary" role="document">
        <div class="modal-content d-mc-primary">
            <div class="modal-header">
                <h5 class="modal-title w-100 text-center" id="exampleModalLabel">EDITAR DATOS DE FACTURA GENERADA</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">FECHA DE GENERACIÓN</label>
                        <input type="text" class="form-control text-dark d-inp-light d-bdr-black d-inp-light" data-toggle="datepicker">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">MES A PAGAR</label>
                        <select class="custom-select custom-select-sm form-control form-control border-primary text-dark d-inp-light">
                            <option selected>Elegir...</option>
                            <option value="1">Enero</option>
                            <option value="2">Febrero</option>
                            <option value="3">Marzo</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">CLIENTE</label>
                        <select class="custom-select custom-select-sm form-control form-control border-primary text-dark d-inp-light">
                            <option selected>Elegir...</option>
                            <option value="1">Cliente 1</option>
                            <option value="2">Cliente 2</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-inverse-warning" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-inverse-primary">Generar</button>
            </div>
        </div>
    </div>
</div>

<!-- modal Generar Factura -->
<div class="modal fade" id="modalGenerarFacturas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog border border-primary rounded d-md-primary" role="document">
        <div class="modal-content d-mc-primary">
            <div class="modal-header">
                <h5 class="modal-title w-100 text-center" id="exampleModalLabel">GENERAR FACTURAS EN SERIE</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">MES A PAGAR</label>
                        <select class="custom-select custom-select-sm form-control form-control border-primary text-dark d-inp-light">
                            <option selected>Elegir...</option>
                            <option value="1">Enero</option>
                            <option value="2">Febrero</option>
                            <option value="3">Marzo</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">FECHA GENERADA</label>
                        <input type="text" class="form-control d-t-black d-inp-light d-bdr-black d-inp-light" data-toggle="datepicker">
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">TIPO DE CLIENTE</label>
                        <select class="custom-select custom-select-sm form-control form-control border-primary text-dark d-inp-light">
                            <option selected>Elegir...</option>
                            <option value="1">Residencial</option>
                            <option value="2">Corporativo</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-inverse-warning" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-inverse-primary">Generar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Eliminar Factura -->
<div class="modal fade" id="modalEliminarFactura" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog d-md-danger d-bdr-danger" role="document">
        <div class="modal-content d-mc-black">
            <div class="modal-header d-bdr-black">
                <h5 class="modal-title text-center text-light w-100 text-center" id="exampleModalLabel">ATENCIÓN</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h3 class="modal-title text-center text-danger w-100 text-center"" id=" exampleModalLabel">Se eliminará permanentemente la factura 123 y todos los datos vinculados</h3>
            </div>
            <div class="modal-footer justify-content-center d-bdr-black">
                <button type="button" class="btn btn-inverse-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-inverse-danger">Confirmar</button>
            </div>
        </div>
    </div>
</div>



<!--============ MODALES DE CONTRATOS DE CLIENTES ============-->
<!-- modal de nuevo Equipo -->
<div class="modal fade" id="modalNuevoEquipo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog border border-success rounded d-md-success" role="document">
        <div class="modal-content d-mc-success">
            <div class="modal-header">
                <h5 class="modal-title text-center w-100 text-center" id="exampleModalLabel">VINCULAR NUEVO EQUIPO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Nombre Equipo</label>
                        <input type="text" class="form-control border-success d-t-black d-inp-light">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Tipo Equipo</label>
                        <select class="custom-select custom-select-sm form-control form-control border-success d-t-black d-inp-light">
                            <option selected>Elegir...</option>
                            <option value="1">Tipo 1</option>
                            <option value="2">Tipo 2</option>
                            <option value="3">Tipo 3</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Cliente Asociado</label>
                        <select class="custom-select custom-select-sm form-control form-control border-success d-t-black d-inp-light">
                            <option selected>Elegir...</option>
                            <option value="1">Cliente 1</option>
                            <option value="2">Cliente 2</option>
                            <option value="2">Cliente 3</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-inverse-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-inverse-success">Registrar y Vincular</button>
            </div>
        </div>
    </div>
</div>

<!-- modal de Editar Equipo -->
<div class="modal fade" id="modalEditarEquipo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog border border-success rounded d-md-success" role="document">
        <div class="modal-content d-mc-success">
            <div class="modal-header">
                <h5 class="modal-title text-center w-100 text-center" id="exampleModalLabel">EDITAR VINCULO DE EQUIPO DE RED</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Nombre Equipo</label>
                        <input type="text" class="form-control border-success d-t-black d-inp-light">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Tipo Equipo</label>
                        <select class="custom-select custom-select-sm form-control form-control border-success d-t-black d-inp-light">
                            <option selected>Elegir...</option>
                            <option value="1">Tipo 1</option>
                            <option value="2">Tipo 2</option>
                            <option value="3">Tipo 3</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Cliente Asociado</label>
                        <select class="custom-select custom-select-sm form-control form-control border-success d-t-black d-inp-light">
                            <option selected>Elegir...</option>
                            <option value="1">Cliente 1</option>
                            <option value="2">Cliente 2</option>
                            <option value="2">Cliente 3</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-inverse-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-inverse-success">Registrar y Vincular</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Eliminar Vinculo Equipo -->
<div class="modal fade" id="modalEliminarEquipo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog d-md-danger d-bdr-danger" role="document">
        <div class="modal-content d-mc-black">
            <div class="modal-header d-bdr-black">
                <h5 class="modal-title text-center text-light w-100 text-center" id="exampleModalLabel">ATENCIÓN</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h3 class="modal-title text-center text-danger w-100 text-center"" id=" exampleModalLabel">Se eliminará permanentemente el registro del equipo ABC y se desvinculará del cliente asociado</h3>
            </div>
            <div class="modal-footer justify-content-center d-bdr-black">
                <button type="button" class="btn btn-inverse-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-inverse-danger">Confirmar</button>
            </div>
        </div>
    </div>
</div>