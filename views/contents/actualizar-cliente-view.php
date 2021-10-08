<?php
if ($login_controlador->encryption($_SESSION['id_lmr']) != $pagina[1]) {
    if ($_SESSION['id_rol_lmr'] != 1) {
        $login_controlador->forzar_cierre_sesion_controlador();
        exit();
    }
}
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<?php
require_once "./controllers/clienteControlador.php";
require_once "./routerMIkrotik/Resources.php";
$data = RouterR::RouterClientes();
$dataPro = RouterR::pppSecretProfile();
$ins_cliente = new clienteControlador();

$select_muni = $ins_cliente->llenarSelect(1, 0, "muni");
$select_muni_actual = $ins_cliente->llenarSelect(0, $pagina[1], "muni");
$select_tCliente = $ins_cliente->llenarSelect(1, 0, "tcliente");
$select_tCliente_actual = $ins_cliente->llenarSelect(0, $pagina[1], "tcliente");
$data = json_decode($data, true);
$dataProfile = json_decode($dataPro, true);
$datos_cliente = $ins_cliente->datosclienteControlador($pagina[1]);

if ($datos_cliente->rowCount() == 1) {
    $campos = $datos_cliente->fetch();

    $cliente_seleccionado = [];
    $prefijo="192.168.27.";
    $ipTerm=1;
    $ar=[];
    foreach ($data as $val) {
        if ($val['remote-address'] == $campos['ip_asignada']) {
            $cliente_seleccionado = [
                ".id" => $val['.id'],
                "name" => $val['name'],
                "password" => $val['password'],
                "service" => $val['service'],
                "profile" => $val['profile'],
                "remote-address" => $val['remote-address']
            ];
        }
        $a=$prefijo.strval($ipTerm);
        if($val['remote-address']==$a){
            $ar[]="si";
        }else{
            $ar[]=$prefijo.strval($ipTerm);
        }
        $ipTerm=$ipTerm+1;
    }

    
   print_r($ar);
    

?>



    <div class="row justify-content-center ">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card d-mc-light d-frmc">
                <div class="card-body">
                    <h4 class="card-title text-center text-danger">&nbsp; Actualizar Datos del Cliente</h4>
                    <form class="form-sample d-formc FormularioAjax" action="<?php echo SERVERURL; ?>ajax/clienteAjax.php" method="POST" data-form="update" autocomplete="off">
                        <h6 class="card-title text-primary">&nbsp; Datos Personales del Cliente</h6>
                        <div class="form-group row">
                            <input type="hidden" id="cliente_ip_update" name="cliente_ip_update" value="<?php echo $pagina[1]; ?>">
                            <input type="hidden" id="id_cliente_Up" name="id_cliente_Up" value="<?php echo $campos['id_cliente']; ?>">
                            <input type="hidden" id="id_clienteR_Up" name="id_clienteR_Up" value="<?php echo $cliente_seleccionado['.id']; ?>">
                            <div class="col-md-8">
                                <input type="text" class="form-control d-inp-cli" id="nombreCliente_Up" name="nombreCliente_Up" placeholder="Nombre del Cliente" pattern="^(([a-zA-ZáéíóúÁÉÍÓÚüñÑ]+)|((([a-zA-ZáéíóúÁÉÍÓÚüñÑ]+)[ ]([a-zA-ZáéíóúÁÉÍÓÚüñÑ]+))+))$" maxlength="100" required="" onchange="dibujarServicio(this.value)" value="<?php echo $campos['nombre_cliente']; ?>">
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control d-inp-cli" id="telefonoCliente_Up" name="telefonoCliente_Up" placeholder="Teléfono" pattern="^[0-9]{8}$" maxlength="8" required="" value="<?php echo $campos['telefono_cliente']; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <select class="custom-select custom-select-sm form-control form-control d-inp-cli" name="municipioCliente_Up" id="municipioCliente_Up">

                                    <?php foreach ($select_muni_actual as $opciones) : ?>
                                        <option selected value="<?php echo $opciones['id_municipio']; ?>"><?php echo $opciones['nombre_municipio']; ?></option>
                                    <?php endforeach ?>
                                    <?php foreach ($select_muni as $opciones) : ?>
                                        <option value="<?php echo $opciones['id_municipio'] ?>"><?php echo $opciones['nombre_municipio']; ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control d-inp-cli" id="direccionCliente_Up" name="direccionCliente_Up" placeholder="Dirección de Domicilio" pattern="^(([a-zA-ZáéíóúÁÉÍÓÚüñÑ]+)|((([a-zA-ZáéíóúÁÉÍÓÚüñÑ]+)[ ]([a-zA-ZáéíóúÁÉÍÓÚüñÑ]+))+))$" maxlength="100" required="" value="<?php echo $campos['domicilio']; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-8">
                                <input type="text" class="form-control d-inp-cli" id="gpsCliente_Up" name="gpsCliente_Up" placeholder="Ubicación GPS" pattern="^([0-9]{2,3}.([0-9]+), -[0-9]{2,3}.([0-9]+))$" maxlength="100" required="" value="<?php echo $campos['ubicacion_gps']; ?>">
                            </div>
                            <div class="col-md-4">
                                <select class="custom-select custom-select-sm form-control form-control d-inp-cli" name="tipoCliente_Up" id="tipoCliente_Up">
                                    <?php foreach ($select_tCliente_actual as $opciones) : ?>
                                        <option selected value="<?php echo $opciones['id_tipo_cliente'] ?>"><?php echo $opciones['nombre_tipo_cliente']; ?></option>
                                    <?php endforeach ?>

                                    <?php foreach ($select_tCliente as $opciones) : ?>
                                        <option value="<?php echo $opciones['id_tipo_cliente'] ?>"><?php echo $opciones['nombre_tipo_cliente']; ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <hr />

                        <h6 class="card-title text-primary">&nbsp; Datos Del Contrato</h6>
                        <div class="form-group row">
                            <div class="col-md-3">
                                <input type="text" class="form-control d-inp-cli" id="fechaContratoCliente_Up" name="fechaContratoCliente_Up" placeholder="Fecha Contrato" maxlength="100" required="" data-toggle="datepicker" value="<?php echo $campos['fecha_contrato']; ?>">
                            </div>
                            <div class="col-md-3">
                                <select class="custom-select custom-select-sm form-control form-control d-inp-cli" name="planCliente_Up" id="planCliente_Up" onchange="dibujarPlan(this.options[this.selectedIndex].innerHTML)">
                                    <option selected value="<?php echo $cliente_seleccionado['profile'] ?>"><?php echo $cliente_seleccionado['profile']; ?></option>
                                    <?php foreach ($dataProfile as $opciones) : ?>
                                        <option value="<?php echo $opciones['name']; ?>"><?php echo $opciones['name']; ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control d-inp-cli" id="ipClientec_Up" name="ipClientec_Up" placeholder="Asignar Dirección IP" pattern="^(([0-9]{1,3}).([0-9]{1,3}).([0-9]{1,3}).([0-9]{1,3}))$" maxlength="100" required="" onchange="dibujarIP(this.value)" value="<?php echo $campos['ip_asignada']; ?>">
                            </div>
                            <div class="col-md-3">
                                <select class="custom-select custom-select-sm form-control form-control d-inp-cli" name="estadoContratoCliente_Up" id="estadoContratoCliente_Up">
                                    <?php foreach ($select_tCliente_actual as $opciones) : ?>
                                        <option selected value="<?php echo $opciones['estado_contrato']; ?>">
                                            <?php
                                            $estado = "";
                                            if ($opciones['estado_contrato'] == 1) {
                                                $estado = "Activo";
                                            } else {
                                                $estado = "Inactivo";
                                            }
                                            echo $estado; ?></option>
                                    <?php endforeach ?>
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                            </div>
                        </div>
                        <hr />
                        <h6 class="card-title text-primary">&nbsp; Parámetros del Servicio a Contratar</h6>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <input type="text" class="form-control d-inp-cli" id="nombreServicio_Up" name="nombreServicio_Up" placeholder="Nombre del Servicio" pattern="^(([0-9a-zA-ZáéíóúÁÉÍÓÚüñÑ]+)|((([0-9a-zA-ZáéíóúÁÉÍÓÚüñÑ]+)_([0-9a-zA-ZáéíóúÁÉÍÓÚüñÑ]+))+))$" maxlength="100" required="" value="<?php echo $cliente_seleccionado['name']; ?>">
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control d-inp-cli" id="passServicio_Up" name="passServicio_Up" placeholder="Password Servicio" pattern="^([a-zA-ZñÑ0-9$@\.\- ]{3,50})$" maxlength="50" required="" value="<?php echo $cliente_seleccionado['password']; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <select class="custom-select custom-select-sm form-control form-control d-inp-cli" name="tipoServicio_Up" id="tipoServicio_Up">
                                    <option selected value="<?php echo $cliente_seleccionado['service']; ?>"><?php echo $cliente_seleccionado['service']; ?></option>
                                    <option value="Any">Any</option>
                                    <option value="Async">Async</option>
                                    <option value="l2tp">l2tp</option>
                                    <option value="ovpn">ovpn</option>
                                    <option value="pppoe">pppoe</option>
                                    <option value="pptp">pptp</option>
                                    <option value="sstp">sstp</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control d-inp-cli" id="perfil_Up" name="perfil_Up" placeholder="Perfil" pattern="^([0-9a-zA-Z\-]+)$" maxlength="100" required="" value="<?php echo $cliente_seleccionado['profile']; ?>">
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control d-inp-cli" id="ipCliente_Up" name="ipCliente_Up" placeholder="IP Address" pattern="^(([0-9]{1,3}).([0-9]{1,3}).([0-9]{1,3}).([0-9]{1,3}))$" maxlength="100" required="" value="<?php echo $cliente_seleccionado['remote-address']; ?>">
                            </div>
                        </div>
                        <hr />

                        <div class=" row justify-content-center">
                            <button type="submit" class="btn btn-inverse-primary mr-2">&nbsp; Registrar Cliente</button>
                            <a href="<?php echo SERVERURL; ?>clientes-activos/" class="btn btn-inverse-danger">&nbsp; Cancelar</a>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
<?php } else {
    echo
    '
<div clas="row">
<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>ATENCIÓN!</strong> Parece que no tienes los privilegios suficientes para acceder a esta página
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
</div>
';
} ?>



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

<script>
    var dibujarPlan = function(x) {
        document.getElementById('perfil_Up').value = x;
    };
    var dibujarServicio = function(x) {
        let txt = x.toLowerCase();
        const acentos = {
            'á': 'a',
            'é': 'e',
            'í': 'i',
            'ó': 'o',
            'ú': 'u',
            'Á': 'A',
            'É': 'E',
            'Í': 'I',
            'Ó': 'O',
            'Ú': 'U'
        };
        let txt2 = txt.split('').map(letra => acentos[letra] || letra).join('').toString();
        let key = txt2.replace(/ /g, "_");
        document.getElementById('nombreServicio_Up').value = key;

    };

    var dibujarIP = function(x) {
        document.getElementById('ipCliente_Up').value = x;
    };
</script>