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


<!-- Modal de ver descripcion del trabajo -->
<div class="modal fade" id="mostrarDescripcion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog d-md-success d-bdr-light rounded" role="document">
        <div class="modal-content d-mc-black">
            <div class="modal-header d-bdr-black">
                <h5 class="modal-title w-100 text-center text-success" id="exampleModalLabel">DESCRIPCION DEL TRABAJO A REALIZAR</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <textarea class="form-control d-txtar" name="descripcion" id="descripcion" readonly></textarea>
            </div>
            <div class="modal-footer justify-content-center d-bdr-black">
                <button type="button" class="btn btn-inverse-success" data-dismiss="modal">Entendido</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de ver descripcion del trabajo terminado -->
<div class="modal fade" id="mostrarDescripcionTerminado" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog d-md-light d-bdr-light rounded" role="document">
        <div class="modal-content d-mc-black">
            <div class="modal-header d-bdr-black">
                <h5 class="modal-title w-100 text-center text-info" id="exampleModalLabel">DESCRIPCION DEL TRABAJO TERMINADO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <textarea class="form-control d-txtar" name="descripcionT" id="descripcionT" readonly></textarea>
            </div>
            <div class="modal-footer justify-content-center d-bdr-black">
                <button type="button" class="btn btn-inverse-info" data-dismiss="modal">Entendido</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Nuevo Tipo de Trabajo-->
<div class="modal fade" id="modalNuevoTipoTrabajo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog border border-success rounded d-md-success " role="document" style="width:375px;">
        <div class="modal-content d-mc-light">
            <div class="modal-header">
                <h5 class="modal-title text-center w-100 text-center" id="exampleModalLabel">CREAR NUEVO TIPO DE TRABAJO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="FormularioAjax" action="<?php echo SERVERURL; ?>ajax/trabajoAjax.php" method="POST" data-form="save" autocomplete="off">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Nombre del Nuevo Tipo de Trabajo:</label>
                        <input type="text" class="form-control d-inp-green" id="nombre_tipo_trabajo" name="nombre_tipo_trabajo" placeholder="Escriba Aquí el nombre del nuevo tipo de trabajo" maxlength="100" required="">
                    </div>

                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-inverse-info" data-dismiss="modal">Cancelar</button>
                    <button type="sumbit" class="btn btn-inverse-primary">Registrar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Fin Modal Nuevo Tipo de Trabajo-->

<!-- Modal generar facturas-->
<div class="modal fade" id="modalGenerarFacturas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog border border-light rounded d-md-light" role="document" style="width:375px;">
        <div class="modal-content d-mc-light">
            <div class="modal-header">
                <h5 class="modal-title text-center w-100 text-center" id="exampleModalLabel">GENERAR FACTURAS EN SERIE</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="FormularioAjax" action="<?php echo SERVERURL; ?>ajax/facturaAjax.php" method="POST" data-form="saveserie" autocomplete="off">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Fecha Generada</label>
                        <input type="text" class="form-control d-inp-white" id="fechaAsignada" name="fechaAsignada" placeholder="Seleccionar fecha" maxlength="100" required="" data-toggle="datepicker" value="">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Mes a Pagar</label>
                        <select class="custom-select custom-select-sm form-control form-control d-inp-white" name="mes" id="mes">
                            <option selected value="">Seleccionar Mes</option>
                            <option value="Enero">Enero</option>
                            <option value="Febrero">Febrero</option>
                            <option value="Marzo">Marzo</option>
                            <option value="Abril">Abril</option>
                            <option value="Mayo">Mayo</option>
                            <option value="Junio">Junio</option>
                            <option value="Julio">Julio</option>
                            <option value="Agosto">Agosto</option>
                            <option value="Septiembre">Septiembre</option>
                            <option value="Octubre">Octubre</option>
                            <option value="Noviembre">Noviembre</option>
                            <option value="Dicimebre">Dicimebre</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-inverse-danger" data-dismiss="modal">Cancelar</button>
                    <button type="sumbit" class="btn btn-inverse-primary">Generar facturas</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Fin Modal generar facturas-->