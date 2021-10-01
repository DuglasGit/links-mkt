<?php
if ($_SESSION['id_rol_lmr'] != 1) {
    $login_controlador->forzar_cierre_sesion_controlador();
    exit();
}
require_once "./routerMIkrotik/Resources.php";
$data = RouterR::pppSecretProfile();

?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<?php
require_once "./controllers/clienteControlador.php";
$ins_cliente = new clienteControlador();
$datos_select_muni = $ins_cliente->llenarSelect(1, 0, "muni");
$datos_select_tcliente = $ins_cliente->llenarSelect(1, 0, "tcliente");
$datos_select_plan = $ins_cliente->llenarSelect(1, 0, "plan");
$datos_select_perfil = $ins_cliente->llenarSelect(1, 0, "perfil");
$data = json_decode($data, true);
$prueba = $ins_cliente->formatearServicio("Duglas: Adonías, Ló.pez García");
echo $prueba;

?>
<div class="row justify-content-center ">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card d-mc-light d-frmc">
            <div class="card-body">
                <h4 class="card-title text-center text-danger">&nbsp; Registrar Nuevo Cliente</h4>
                <form class="form-sample d-formc FormularioAjax" action="<?php echo SERVERURL; ?>ajax/usuarioAjax.php" method="POST" data-form="save" autocomplete="off">
                    <h6 class="card-title text-primary">&nbsp; Datos Personales del Cliente</h6>
                    <div class="form-group row">
                        <div class="col-md-8">
                            <input type="text" class="form-control d-inp-cli" id="nombreCliente" name="nombreCliente" placeholder="Nombre del Cliente" pattern="^(([a-zA-ZáéíóúÁÉÍÓÚüñÑ]+)|((([a-zA-ZáéíóúÁÉÍÓÚüñÑ]+)[ ]([a-zA-ZáéíóúÁÉÍÓÚüñÑ]+))+))$" maxlength="100" required="" onchange="dibujarServicio(this.value)">
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control d-inp-cli" id="telefonoCliente" name="telefonoCliente" placeholder="Teléfono" pattern="^[0-9]{8}$" maxlength="8" required="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <select class="custom-select custom-select-sm form-control form-control d-inp-cli" name="municipioCliente" id="municipioCliente">
                                <option selected value="">Elegir Municipio</option>

                                <?php foreach ($datos_select_muni as $opciones) : ?>
                                    <option value="<?php echo $opciones['id_municipio'] ?>"><?php echo $opciones['nombre_municipio']; ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control d-inp-cli" id="direccionCliente" name="direccionCliente" placeholder="Dirección de Domicilio" pattern="^(([a-zA-ZáéíóúÁÉÍÓÚüñÑ]+)|((([a-zA-ZáéíóúÁÉÍÓÚüñÑ]+)[ ]([a-zA-ZáéíóúÁÉÍÓÚüñÑ]+))+))$" maxlength="100" required="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-8">
                            <input type="text" class="form-control d-inp-cli" id="gpsCliente" name="gpsCliente" placeholder="Ubicación GPS" pattern="^([0-9]{2,3}\.([0-9]+)\, \-[0-9]{2,3}\.([0-9]+))$" maxlength="100" required="">
                        </div>
                        <div class="col-md-4">
                            <select class="custom-select custom-select-sm form-control form-control d-inp-cli" name="tipoCliente" id="tipoCliente">
                                <option selected value="">Elegir Tipo Cliente</option>

                                <?php foreach ($datos_select_tcliente as $opciones) : ?>
                                    <option value="<?php echo $opciones['id_tipo_cliente'] ?>"><?php echo $opciones['nombre_tipo_cliente']; ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <hr />

                    <h6 class="card-title text-primary">&nbsp; Datos Del Contrato</h6>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <input type="text" class="form-control d-inp-cli" id="fechaContratoCliente" name="fechaContratoCliente" placeholder="Fecha Contrato" pattern="^((0[1-9]|[1-2][0-9]|3[0-1])\/(0[1-9]|1[0-2])\/[1-2]([0-9]{3}))$" maxlength="100" required="" data-toggle="datepicker">
                        </div>
                        <div class="col-md-4">
                            <select class="custom-select custom-select-sm form-control form-control d-inp-cli" name="planCliente" id="planCliente" onchange="dibujarPlan(this.options[this.selectedIndex].innerHTML)">
                                <option selected value="">Elegir Plan</option>

                                <?php foreach ($data as $opciones) : ?>
                                    <option value="<?php echo $opciones['.id'] ?>"><?php echo $opciones['name']; ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select class="custom-select custom-select-sm form-control form-control d-inp-cli" name="estadoContratoCliente" id="estadoContratoCliente">
                                <option selected value="">Elegir Estado Contrato</option>
                                <option value="1">Activo</option>
                                <option value="2">Inactivo</option>
                            </select>
                        </div>
                    </div>
                    <hr />


                    <h6 class="card-title text-primary">&nbsp; Parámetros del Servicio a Contratar</h6>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <input type="text" class="form-control d-inp-cli" id="nombreServicio" name="nombreServicio" placeholder="Nombre del Servicio" pattern="^(([0-9a-zA-ZáéíóúÁÉÍÓÚüñÑ]+)|((([0-9a-zA-ZáéíóúÁÉÍÓÚüñÑ]+)\_([0-9a-zA-ZáéíóúÁÉÍÓÚüñÑ]+))+))$" maxlength="100" required="">
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control d-inp-cli" id="passServicio" name="passServicio" placeholder="Password Servicio" pattern="^([a-zA-ZñÑ0-9$@\.\- ]{3,50})$" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <select class="custom-select custom-select-sm form-control form-control d-inp-cli" name="tipoServicio" id="tipoServicio">
                                <option selected value="">Elegir Estado Contrato</option>
                                <option value="1">Any</option>
                                <option value="2">Async</option>
                                <option value="3">l2tp</option>
                                <option value="4">ovpn</option>
                                <option value="5">pppoe</option>
                                <option value="6">pptp</option>
                                <option value="7">sstp</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control d-inp-cli" id="perfil" name="perfil" placeholder="Perfil" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,100}" maxlength="100" required="">
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control d-inp-cli" id="ipCliente" name="ipCliente" placeholder="IP Address" pattern="^(([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3}))$" maxlength="100" required="">
                        </div>
                    </div>
                    <hr />

                    <div class=" row justify-content-center">
                        <button type="submit" class="btn btn-inverse-primary mr-2">&nbsp; Actualizar Datos</button>
                        <a href="<?php echo SERVERURL; ?>clientes-activos/" class="btn btn-inverse-danger">&nbsp; Cancelar</a>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

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

<script>
    var dibujarPlan = function(x) {
        document.getElementById('perfil').value = x;
    };
    var dibujarServicio = function(x) {
        let txt=x.toLowerCase();
        const acentos = {'á':'a','é':'e','í':'i','ó':'o','ú':'u','Á':'A','É':'E','Í':'I','Ó':'O','Ú':'U'};
	    let txt2=txt.split('').map( letra => acentos[letra] || letra).join('').toString();	
        let key=txt2.replace(/ /g,"_");
        document.getElementById('nombreServicio').value = key;

    };
</script>