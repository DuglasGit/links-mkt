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
            <button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#modalNuevaFactura">
                <i class="mdi mdi-file d-block mb-1"></i> Generar Facturas Individuales </button>
            <a type="button" href="<?php echo SERVERURL; ?>facturas-canceladas/" class="btn btn-outline-secondary">
                <i class="mdi mdi-file-check d-block mb-1"></i> Listar Facturas Pagadas </a>
        </div>
    </div>
</div>

<?php
if (!isset($_SESSION['busqueda_factura']) && empty($_SESSION['busqueda_factura'])) {
?>
    <!-- card tabla usuarios -->
    <div class="card d-pri">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-light text-center">LISTA DE FACTURAS PENDIENTE DE PAGO</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12 col-md-10">
                    <form class="form-inline FormularioAjax" action="<?php echo SERVERURL; ?>ajax/buscadorAjax.php" method="POST" autocomplete="off">
                        <input type="hidden" name="modulo" value="factura">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="search" class="form-control" name="busqueda_inicial" id="busqueda_inicial" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="basic-addon2">
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

                echo $ins_trabajo->PaginadorFacturasPendientesControlador($pagina[1], 10, $_SESSION['id_rol_lmr'], $_SESSION['id_lmr'], $pagina[0], "");

                ?>
            </div>

        </div>

    </div>

<?php } else { ?>

    <!-- card tabla facturas -->
    <div class="card d-pri">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-light text-center">LISTA DE FACTURAS PENDIENTE DE PAGO</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12 col-md-10">
                    <form class="form-inline FormularioAjax" action="<?php echo SERVERURL; ?>ajax/buscadorAjax.php" method="POST" autocomplete="off">
                        <input type="hidden" name="modulo" value="factura">
                        <input type="hidden" name="eliminar_busqueda" value="eliminar">
                        <div class="my-1 mr-sm-2 flexbox">
                            <label class="text-warning">“Resultados de la Búsqueda=><?php echo $_SESSION['busqueda_factura']; ?>”</label>
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

                echo $ins_trabajo->PaginadorFacturasPendientesControlador($pagina[1], 10, $_SESSION['id_rol_lmr'], $_SESSION['id_lmr'], $pagina[0], $_SESSION['busqueda_factura']);

                ?>
            </div>

        </div>

    </div>

<?php } ?>



<!-- Modal generar facturas-->
<div class="modal fade" id="modalNuevaFactura" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog border border-light rounded d-md-light" role="document" style="width:400px;">
        <div class="modal-content d-mc-light">
            <div class="modal-header">
                <h5 class="modal-title text-center w-100 text-center" id="exampleModalLabel">GENERAR FACTURA INDIVIDUAL</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php
            require_once "./controllers/facturaControlador.php";
            $ins_factura = new facturaControlador();
            $datos_factura = $ins_factura->datosFacturaControlador("Unico", $pagina[1]);
            $select_cliente = $ins_factura->llenarSelect("todo", 0, "cliente");
            $select_estado = $ins_factura->llenarSelect("todo", 0, "estado");
            $select_estado_actual = $ins_factura->llenarSelect("actual", $pagina[1], "estado");
            $select_producto = $ins_factura->llenarSelect("todo", 0, "producto");
            $select_precio = $ins_factura->llenarSelect("todo", 0, "precio");

            if ($datos_factura->rowCount() == 1) {
                $campos = $datos_factura->fetch();
            }
            ?>
            <form class="FormularioAjax" action="<?php echo SERVERURL; ?>ajax/facturaAjax.php" method="POST" data-form="save" autocomplete="off">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Nombre del Cliente</label>
                        <select class="custom-select-sm form-control form-control-sm d-inp-white" name="id_cliente_reg" id="id_cliente_reg">
                            <option selected value="">Seleccionar</option>
                            <?php foreach ($select_cliente as $opciones) : ?>
                                <option value="<?php echo $opciones['id_cliente'] ?>"><?php echo $opciones['nombre_cliente']; ?></option>
                            <?php endforeach ?>
                        </select>
                        <input type="hidden" id="id_usuario_reg" name="id_usuario_reg" value="<?php echo $_SESSION['id_rol_lmr']; ?>">
                    </div>
                    <div class="form-group row">
                        <div class="form-group col-sm-6">
                            <label for="recipient-name" class="col-form-label">Fecha Generada</label>
                            <input type="text" class="form-control form-control-sm d-inp-white" id="fecha_reg" name="fecha_reg" placeholder="Seleccionar fecha" maxlength="100" required="" data-toggle="datepicker" value="">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="recipient-name" class="col-form-label">Estado del Pago</label>
                            <select class="custom-select-sm form-control form-control-sm d-inp-white" name="estado_pago_reg" id="estado_pago_reg">
                                <option selected value="">Seleccionar</option>
                                <?php foreach ($select_estado as $opciones) : ?>
                                    <option value="<?php echo $opciones['id_estado_pago'] ?>"><?php echo $opciones['nombre_estado']; ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Item a Facturar</label>
                        <select class="custom-select-sm form-control form-control-sm d-inp-white" name="producto_servicio_reg" id="producto_servicio_reg">
                            <option selected value="">Seleccionar</option>
                            <?php foreach ($select_producto as $opciones) : ?>
                                <option value="<?php echo $opciones['id_producto_servicio'] ?>"><?php echo $opciones['nombre_producto_servicio']; ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group row">
                        <div class="form-group col-sm-6">
                            <label for="recipient-name" class="col-form-label">Subtotal</label>
                            <select class="custom-select-sm form-control form-control-sm d-inp-white" name="precio_reg" id="precio_reg">
                                <option selected value="">Seleccionar</option>
                                <?php foreach ($select_precio as $opciones) : ?>
                                    <option value="<?php echo $opciones['precio'] ?>"><?php echo $opciones['precio']." | ".$opciones['nombre_plan']; ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="recipient-name" class="col-form-label">Mes a Pagar</label>
                            <select class="custom-select-sm form-control form-control-sm d-inp-white" name="mes_pagado_reg" id="mes_pagado_reg">
                                <option selected value="">Seleccionar</option>
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
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-inverse-warning" data-dismiss="modal">Cancelar</button>
                    <button type="sumbit" class="btn btn-inverse-primary">Generar Factura</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Fin Modal generar facturas-->


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