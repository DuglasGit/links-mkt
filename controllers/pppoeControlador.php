<?php

if ($peticionAjax) {
	require_once "../models/pppoeModelo.php";
	require_once "../routerMIkrotik/Resources.php";
} else {
	require_once "./models/pppoeModelo.php";
	require_once "./routerMIkrotik/Resources.php";
}

class pppoeControlador extends pppoeModelo
{

	// COntrolador Paginar cliente
	public function PaginadorClientesRegistradosControlador($pagina, $registros, $rol, $id, $url, $busqueda)
	{
		$pagina = mainModel::limpiar_cadena($pagina);
		$registros = mainModel::limpiar_cadena($registros);
		$rol = mainModel::limpiar_cadena($rol);
		$id = mainModel::limpiar_cadena($id);
		$url = mainModel::limpiar_cadena($url);
		$busqueda = mainModel::limpiar_cadena($busqueda);
		$clientes = RouterR::RouterClientes();
		$clientesdb = mainModel::ejecutar_consulta_simple("SELECT cliente.nombre_cliente, cliente.id_cliente FROM cliente JOIN contrato_servicio ON (cliente.id_cliente=contrato_servicio.id_cliente)");
		$clientesdb = $clientesdb->fetchAll();
		$clientesdb = array_column($clientesdb, 'nombre_cliente');
		$clientesdbFormateado = [];
		$c = 0;
		foreach ($clientesdb as $val) {
			$clientesdbFormateado[$c] = mainModel::formatearNombreServicio($val);
			$c++;
		}
		//print_r($clientesdbFormateado);
		$url = SERVERURL . $url . "/";
		$tabla = "";


		$pagina = (isset($pagina) && $pagina > 0) ? (int)$pagina : 1;
		$inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;
		$datosCliente = json_decode($clientes, true);

		$Registrados = [];
		$c = 0;
		foreach ($datosCliente as $val) {

			$Registrados[$c]['.id'] = $val['.id'];
			$Registrados[$c]['name'] = $val['name'];
			$Registrados[$c]['service'] = $val['service'];
			$Registrados[$c]['caller-id'] = $val['caller-id'];
			$Registrados[$c]['password'] = $val['password'];
			$Registrados[$c]['profile'] = $val['profile'];
			$Registrados[$c]['remote-address'] = $val['remote-address'];
			$Registrados[$c]['routes'] = $val['routes'];
			$Registrados[$c]['limit-bytes-in'] = $val['limit-bytes-in'];
			$Registrados[$c]['limit-bytes-out'] = $val['limit-bytes-out'];
			$Registrados[$c]['last-logged-out'] = $val['last-logged-out'];
			if ($val['disabled'] == "false") {
				$Registrados[$c]['disabled'] = 'Enabled';
			} else {
				$Registrados[$c]['disabled'] = 'Disabled';
			}

			if (!(in_array($val['name'], $clientesdbFormateado))) {
				$Registrados[$c]['disabled'] = 'Unregistered';
			}
			$c++;
		}

		$encontrados = [];
		$consulta = "";
		$total = 0;

		if (isset($busqueda) && $busqueda != "") {
			$reemplazo = "_";
			//regex para espacios en blanco
			$reemplazar = "/\s+/";
			$busqueda = preg_replace($reemplazar, $reemplazo, $busqueda);
			//Demilitador 'i' para no diferenciar mayus y minus
			$busqueda = "/$busqueda/i";
			$c = 0;
			foreach ($datosCliente as $val) {
				if (preg_match($busqueda, $val['name'])) {
					$encontrados[$c]['name'] = $val;
					$encontrados[$c]['.id'] = $val['.id'];
					$encontrados[$c]['name'] = $val['name'];
					$encontrados[$c]['service'] = $val['service'];
					$encontrados[$c]['caller-id'] = $val['caller-id'];
					$encontrados[$c]['password'] = $val['password'];
					$encontrados[$c]['profile'] = $val['profile'];
					$encontrados[$c]['remote-address'] = $val['remote-address'];
					$encontrados[$c]['routes'] = $val['routes'];
					$encontrados[$c]['limit-bytes-in'] = $val['limit-bytes-in'];
					$encontrados[$c]['limit-bytes-out'] = $val['limit-bytes-out'];
					$encontrados[$c]['last-logged-out'] = $val['last-logged-out'];
					$encontrados[$c]['disabled'] = $val['disabled'];

					$c++;
				}
			}
			$consulta = $encontrados;

			$consulta = array_slice($consulta, $inicio, $registros);
			$total = count($consulta);
		} else {
			$consulta = array_slice($Registrados, $inicio, $registros);
			$total = count($Registrados);
		}


		$Npaginas = ceil($total / $registros);

		$tabla .= '
		<div class="table-responsive">

		<table class="table table-hover">
			<thead>
				<tr class="text-center">
					<th class="text-danger col-md-auto">ID</th>
					<th class="text-danger col-md-auto">NOMBRE DEL CLIENTE</th>
					<th class="text-danger col-md-auto">PLAN</th>
					<th class="text-danger col-md-auto">PASSWORD</th>
					<th class="text-danger col-md-auto">IP ASIGNADA</th>
					<th class="text-danger col-md-auto">ESTADO</th>
                    <th class="text-danger col-md-auto">ACCIONES</th>
				</tr>
			</thead>
			<tbody id="myTable">
		';

		if ($total >= 1 && $pagina <= $Npaginas) {
			$contador = $inicio + 1;
			$registro_inicial = $inicio + 1;

			$ids  = array_column($consulta, '.id');

			array_multisort($ids, SORT_ASC, $consulta);

			foreach ($consulta as $data) {

				$tabla .= '
					<tr class="text-center">
                        <td>' . $data['.id'] . '</td>
                        <td class="text-secondary">' . $data['name'] . '</td>
                        <td class="text-secondary">' . $data['profile'] . '</td>
                        <td class="text-secondary">' . $data['password'] . '</td>
                        <td class="text-secondary">' . $data['remote-address'] . '</td>
						';
				if ($data['disabled'] == 'Unregistered') {
					$tabla .= '
					<td>
						<div class="row justify-content-center">
							<div class="col-md-auto">
								<a href="' . SERVERURL . 'actualizar-pppoe/' . mainModel::encryption($data['remote-address']) . '/" type="button" class="btn btn-inverse-success btn-sm d-btn" data-title="registrar"><i class="mdi mdi-lead-pencil btn-icon-prepend"></i>Registrar</a>
							</div>
						</div>
					</td>
					<td>
						<div class="row justify-content-center">
							<div class="col-md-4">
								<a class="btn btn-outline-primary btn-sm d-btn" data-title="EDITAR"><i class="mdi mdi-lead-pencil btn-icon-prepend"></i>Editar</a>
							</div>
							<div class="col-md-4">
								<a class="btn btn-outline-warning btn-sm d-btn" data-toggle="modal" data-title="SUSPENDER"><i class="mdi mdi-lan-disconnect"></i>Suspender</a>
								
							</div>
						</div>
					</td>
                    </tr>';
				} else {
					$tabla .= '
					<td class="text-secondary">' . $data['disabled'] . '</td>
					<td>
						<div class="row justify-content-center">
							<div class="col-md-4">
								<a href="' . SERVERURL . 'actualizar-pppoe/' . mainModel::encryption($data['remote-address']) . '/" type="button" class="btn btn-inverse-primary btn-sm d-btn" data-title="EDITAR"><i class="mdi mdi-lead-pencil btn-icon-prepend"></i>Editar</a>
							</div>
							<div class="col-md-4">
								<form class="FormularioAjax" action="' . SERVERURL . 'ajax/pppoeAjax.php" method="POST" data-form="disabled" autocomplete="off">
									<input type="hidden" name="pppoe_id_disabled" value="' . mainModel::encryption($data['.id']) . '">
									<input type="hidden" name="pppoe_name_disabled" value="' . mainModel::encryption($data['name']) . '">
									<input type="hidden" name="pppoe_ip_disabled" value="' . mainModel::encryption($data['remote-address']) . '">
									<button type="submit" class="btn btn-inverse-warning btn-sm d-btn" data-toggle="modal" data-title="SUSPENDER"><i class="mdi mdi-lan-disconnect"></i>Suspender</button>
								</form>
							</div>
						</div>
					</td>
                    </tr>';
				}

				$contador++;
			}
			$registro_final = $contador - 1;
		} else {
			if ($total >= 1) {
				$tabla .= '<tr><td colspan="9">
				<a href="' . $url . '" class="btn btn-inverse-warning btn-icon-text">Haga clic aqui para recargar el listado</a>
				</td></tr>';
			} else {
				$tabla .= '<tr><td colspan="9">No hay registros en el sistema</td></tr>';
			}
		}

		$tabla .= '</tbody></table></div>';

		if ($total >= 1 && $pagina <= $Npaginas) {
			$tabla .= '
			<div class="row col-md-12 justify-content-center">
				<p class="text-center">
				Mostrando usuario ' . $registro_inicial . ' al ' . $registro_final . ' de un total de ' . $total . '
				</p>
			</div>';

			$tabla .= mainModel::paginador_tablas($pagina, $Npaginas, $url, 5);
		}

		return $tabla;
	} // fin controlador

	// COntrolador Paginar cliente
	public function PaginadorClientesActivosControlador($pagina, $registros, $rol, $id, $url, $busqueda)
	{
		$pagina = mainModel::limpiar_cadena($pagina);
		$registros = mainModel::limpiar_cadena($registros);
		$rol = mainModel::limpiar_cadena($rol);
		$id = mainModel::limpiar_cadena($id);
		$url = mainModel::limpiar_cadena($url);
		$busqueda = mainModel::limpiar_cadena($busqueda);
		$clientes = RouterR::RouterClientes();
		$clientesAc = RouterR::RouterClientesActivos();
		$suspendidos = RouterR::RouterClientesSuspendidos();
		$clientesAc = json_decode($clientesAc, true);
		$suspendidos = json_decode($suspendidos, true);
		$ipActivos = array_column($clientesAc, 'address');
		$ipSuspendidos = array_column($suspendidos, 'address');
		$uptime = array_column($clientesAc, 'address', 'uptime');

		$url = SERVERURL . $url . "/";
		$tabla = "";


		$pagina = (isset($pagina) && $pagina > 0) ? (int)$pagina : 1;
		$inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;
		$datosCliente = json_decode($clientes, true);

		$clientesActivos = [];
		$c = 0;
		foreach ($datosCliente as $val) {
			if (in_array($val['remote-address'], $ipActivos)) {

				$clientesActivos[$c]['.id'] = $val['.id'];
				$clientesActivos[$c]['name'] = $val['name'];
				$clientesActivos[$c]['service'] = $val['service'];
				$clientesActivos[$c]['caller-id'] = $val['caller-id'];
				$clientesActivos[$c]['password'] = $val['password'];
				$clientesActivos[$c]['profile'] = $val['profile'];
				$clientesActivos[$c]['remote-address'] = $val['remote-address'];
				$clientesActivos[$c]['routes'] = $val['routes'];
				$clientesActivos[$c]['limit-bytes-in'] = $val['limit-bytes-in'];
				$clientesActivos[$c]['limit-bytes-out'] = $val['limit-bytes-out'];
				$clientesActivos[$c]['last-logged-out'] = $val['last-logged-out'];
				$clientesActivos[$c]['disabled'] = '--';
				$clientesActivos[$c]['status'] = '';
				$c++;
			}
		}

		$c = 0;
		foreach ($clientesActivos as $val) {
			if (in_array($val['remote-address'], $ipSuspendidos)) {
				$clientesActivos[$c]['status'] = 'locked';
			} else {
				$clientesActivos[$c]['status'] = 'Active';
			}
			$c++;
		}

		$encontrados = [];
		$consulta = "";
		$total = 0;

		if (isset($busqueda) && $busqueda != "") {

			$reemplazo = "_";
			//regex para espacios en blanco
			$reemplazar = "/\s+/";
			$busqueda = preg_replace($reemplazar, $reemplazo, $busqueda);
			//Demilitador 'i' para no diferenciar mayus y minus
			$busqueda = "/$busqueda/i";
			$c = 0;
			foreach ($clientesActivos as $val) {
				if (preg_match($busqueda, $val['name'])) {
					$encontrados[$c]['.id'] = $val['.id'];
					$encontrados[$c]['name'] = $val['name'];
					$encontrados[$c]['service'] = $val['service'];
					$encontrados[$c]['caller-id'] = $val['caller-id'];
					$encontrados[$c]['password'] = $val['password'];
					$encontrados[$c]['profile'] = $val['profile'];
					$encontrados[$c]['remote-address'] = $val['remote-address'];
					$encontrados[$c]['routes'] = $val['routes'];
					$encontrados[$c]['limit-bytes-in'] = $val['limit-bytes-in'];
					$encontrados[$c]['limit-bytes-out'] = $val['limit-bytes-out'];
					$encontrados[$c]['last-logged-out'] = $val['last-logged-out'];
					$encontrados[$c]['disabled'] = $val['disabled'];
					$encontrados[$c]['status'] = $val['status'];

					$c++;
				}
			}
			$consulta = $encontrados;

			$consulta = array_slice($consulta, $inicio, $registros);
			$total = count($consulta);
		} else {
			$consulta = array_slice($clientesActivos, $inicio, $registros);
			$total = count($clientesActivos);
		}

		$Npaginas = ceil($total / $registros);

		$tabla .= '
		<div class="table-responsive">

		<table class="table table-hover">
			<thead>
				<tr class="text-center">
					<th class="text-primary col-md-auto d-th">ID</th>
					<th class="text-primary col-md-auto d-th">NOMBRE DEL CLIENTE</th>
					<th class="text-primary col-md-auto d-th">PLAN</th>
					<th class="text-primary col-md-auto d-th">PASS</th>
					<th class="text-primary col-md-auto d-th">IP ASIGNADA</th>
					<th class="text-primary col-md-auto d-th">TIEMPO ACT</th>
					<th class="text-primary col-md-auto d-th">STATUS</th>
                    <th class="text-primary col-md-auto d-th">ACCIONES</th>
				</tr>
			</thead>
			<tbody id="myTable">
		';

		if ($total >= 1 && $pagina <= $Npaginas) {
			$contador = $inicio + 1;
			$registro_inicial = $inicio + 1;

			$ids  = array_column($consulta, '.id');

			array_multisort($ids, SORT_ASC, $consulta);

			foreach ($consulta as $data) {

				if (in_array($data['remote-address'], $uptime)) {

					$data['disabled'] = array_search($data['remote-address'], $uptime);
				}

				$tabla .= '
					<tr class="text-center">
                        <td class="d-td">' . $data['.id'] . '</td>
                        <td class="text-secondary d-td">' . $data['name'] . '</td>
                        <td class="text-secondary d-td">' . $data['profile'] . '</td>
						<td class="d-td">
                        	<a data-toggle="modal" data-id="' . $data['password'] . '" class="open-mostrarPass btn btn-inverse-warning btn-sm d-btn btn-icon-text" href="#mostrarPass"><i class="mdi mdi-eye btn-icon-prepend"></i>Ver</a>
                        </td>
                        <td class="text-secondary d-td">' . $data['remote-address'] . '</td>
						<td class="text-secondary d-td">' . $data['disabled'] . '</td>
						<td class="text-secondary d-td">' . $data['status'] . '</td>
                        <td class="d-td">
						<div class="row">
							<div class="col-md-4">
								<a href="' . SERVERURL . 'actualizar-cliente/' . mainModel::encryption($data['remote-address']) . '/" type="button" class="btn btn-inverse-primary btn-sm d-btn" data-title="EDITAR"><i class="mdi mdi-lead-pencil btn-icon-prepend"></i>Editar</a>
							</div>
							<div class="col-md-4">
								<form class="FormularioAjax" action="' . SERVERURL . 'ajax/pppoeAjax.php" method="POST" data-form="disabled" autocomplete="off">
									<input type="hidden" name="cliente_id_disabled" value="' . mainModel::encryption($data['.id']) . '">
									<input type="hidden" name="cliente_name_disabled" value="' . mainModel::encryption($data['name']) . '">
									<input type="hidden" name="cliente_ip_disabled" value="' . mainModel::encryption($data['remote-address']) . '">
									<button type="submit" class="btn btn-inverse-danger btn-sm d-btn" data-toggle="modal" data-title="SUSPENDER"><i class="mdi mdi-lan-disconnect"></i>Suspender</button>
								</form>
							</div>
					</div>
                    </tr>';
				$contador++;
			}
			$registro_final = $contador - 1;
		} else {
			if ($total >= 1) {
				$tabla .= '<tr><td colspan="9">
				<a href="' . $url . '" class="btn btn-inverse-warning btn-icon-text">Haga clic aqui para recargar el listado</a>
				</td></tr>';
			} else {
				$tabla .= '<tr><td colspan="9">No hay registros en el sistema</td></tr>';
			}
		}

		$tabla .= '</tbody></table></div>';

		if ($total >= 1 && $pagina <= $Npaginas) {
			$tabla .= '
			<div class="row col-md-12 justify-content-center">
				<p class="text-center">
				Mostrando usuario ' . $registro_inicial . ' al ' . $registro_final . ' de un total de ' . $total . '
				</p>
			</div>';

			$tabla .= mainModel::paginador_tablas($pagina, $Npaginas, $url, 5);
		}

		return $tabla;
	} // fin controlador


	// COntrolador Paginar cliente
	public function PaginadorClientesSuspendidosControlador($pagina, $registros, $rol, $id, $url, $busqueda)
	{
		$pagina = mainModel::limpiar_cadena($pagina);
		$registros = mainModel::limpiar_cadena($registros);
		$rol = mainModel::limpiar_cadena($rol);
		$id = mainModel::limpiar_cadena($id);
		$url = mainModel::limpiar_cadena($url);
		$busqueda = mainModel::limpiar_cadena($busqueda);
		$suspendidos = RouterR::RouterClientesSuspendidos();
		$url = SERVERURL . $url . "/";

		$tabla = "";

		$pagina = (isset($pagina) && $pagina > 0) ? (int)$pagina : 1;
		$inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;
		$datosSuspendidos = json_decode($suspendidos, true);

		$clientesSuspendidos = [];
		$c = 0;
		foreach ($datosSuspendidos as $val) {

			if ($val['list'] == "Moroso") {

				$clientesSuspendidos[$c]['.id'] = $val['.id'];
				$clientesSuspendidos[$c]['comment'] = $val['comment'];
				$clientesSuspendidos[$c]['creation-time'] = $val['creation-time'];
				$clientesSuspendidos[$c]['address'] = $val['address'];
				$clientesSuspendidos[$c]['list'] = $val['list'];
				$c++;
			}
		}

		$encontrados = [];
		$consulta = "";
		$total = 0;

		if (isset($busqueda) && $busqueda != "") {

			$reemplazo = "_";
			//regex para espacios en blanco
			$reemplazar = "/\s+/";
			$busqueda = preg_replace($reemplazar, $reemplazo, $busqueda);
			//Demilitador 'i' para no diferenciar mayus y minus
			$busqueda = "/$busqueda/i";
			$c = 0;
			foreach ($clientesSuspendidos as $val) {
				if (preg_match($busqueda, $val['comment'])) {

					$encontrados[$c]['.id'] = $val['.id'];
					$encontrados[$c]['comment'] = $val['comment'];
					$encontrados[$c]['creation-time'] = $val['creation-time'];
					$encontrados[$c]['address'] = $val['address'];
					$encontrados[$c]['list'] = $val['list'];

					$c++;
				}
			}
			$consulta = $encontrados;

			$consulta = array_slice($consulta, $inicio, $registros);
			$total = count($consulta);
		} else {
			$consulta = array_slice($clientesSuspendidos, $inicio, $registros);
			$total = count($clientesSuspendidos);
		}

		$Npaginas = ceil($total / $registros);

		$tabla .= '
		<div class="table-responsive">

		<table class="table table-hover">
			<thead>
				<tr class="text-center">
					<th class="text-warning col-md-auto">ID</th>
					<th class="text-warning col-md-auto">NOMBRE DEL CLIENTE</th>
					<th class="text-warning col-md-auto">FECHA SUSPENSIÓN</th>
					<th class="text-warning col-md-auto">IP ASIGNADA</th>
					<th class="text-warning col-md-auto">CLASIFICACION</th>
                    <th class="text-warning col-md-auto">ACCIONES</th>
				</tr>
			</thead>
			<tbody id="myTable">
		';

		if ($total >= 1 && $pagina <= $Npaginas) {
			$contador = $inicio + 1;
			$registro_inicial = $inicio + 1;

			$ids  = array_column($consulta, '.id');

			array_multisort($ids, SORT_ASC, $consulta);

			foreach ($consulta as $data) {

				$tabla .= '
					<tr class="text-center">
                        <td>' . $data['.id'] . '</td>
                        <td class="text-secondary">' . $data['comment'] . '</td>
                        <td class="text-secondary">' . $data['creation-time'] . '</td>
                        <td class="text-secondary">' . $data['address'] . '</td>
                        <td class="text-secondary">' . $data['list'] . '</td>
                        <td>
							<div class="row">
								<div class="col-md-4">
									<form class="FormularioAjax" action="' . SERVERURL . 'ajax/pppoeAjax.php" method="POST" data-form="enabled" autocomplete="off">
										<input type="hidden" name="cliente_id_enabled" value="' . mainModel::encryption($data['.id']) . '">
										<input type="hidden" name="cliente_name_enabled" value="' . mainModel::encryption($data['comment']) . '">
										<input type="hidden" name="cliente_ip_enabled" value="' . mainModel::encryption($data['address']) . '">
										<button type="submit" class="btn btn-inverse-success btn-sm d-btn" data-toggle="modal" data-title="REACTIVAR"><i class="mdi mdi-lan-disconnect"></i>Reactivar</button>
									</form>
								</div>
							</div>
						</td>
                    </tr>';
				$contador++;
			}
			$registro_final = $contador - 1;
		} else {
			if ($total >= 1) {
				$tabla .= '<tr><td colspan="9">
				<a href="' . $url . '" class="btn btn-inverse-warning btn-icon-text">Haga clic aqui para recargar el listado</a>
				</td></tr>';
			} else {
				$tabla .= '<tr><td colspan="9">No hay registros en el sistema</td></tr>';
			}
		}

		$tabla .= '</tbody></table></div>';

		if ($total >= 1 && $pagina <= $Npaginas) {
			$tabla .= '
			<div class="row col-md-12 justify-content-center">
				<p class="text-center">
				Mostrando cliente ' . $registro_inicial . ' al ' . $registro_final . ' de un total de ' . $total . '
				</p>
			</div>';

			$tabla .= mainModel::paginador_tablas($pagina, $Npaginas, $url, 5);
		}
		return $tabla;
	} // fin controlador

	//Controlador para agregar nuevo cliente a la base de datos y al router
	public function agregarClienteControlador()
	{
		$nombreCliente = mainModel::limpiar_cadena($_POST['nombreCliente']);
		$telefonoCliente = mainModel::limpiar_cadena($_POST['telefonoCliente']);
		$municipioCliente = mainModel::limpiar_cadena($_POST['municipioCliente']);
		$direccionCliente = mainModel::limpiar_cadena($_POST['direccionCliente']);
		$gpsCliente = mainModel::limpiar_cadena($_POST['gpsCliente']);
		$tipoCliente = mainModel::limpiar_cadena($_POST['tipoCliente']);
		$fechaContratoCliente = $_POST['fechaContratoCliente'];
		$planCliente = mainModel::limpiar_cadena($_POST['planCliente']);
		$ipClientec = mainModel::limpiar_cadena($_POST['ipClientec']);
		$estadoContratoCliente = mainModel::limpiar_cadena($_POST['estadoContratoCliente']);
		$nombreServicio = mainModel::limpiar_cadena($_POST['nombreServicio']);
		$passServicio = mainModel::limpiar_cadena($_POST['passServicio']);
		$tipoServicio = mainModel::limpiar_cadena($_POST['tipoServicio']);
		$perfil = mainModel::limpiar_cadena($_POST['perfil']);
		$ipCliente = mainModel::limpiar_cadena($_POST['ipCliente']);

		// comprobar privilegios
		session_start(['name' => 'LMR']);
		if ($_SESSION['id_rol_lmr'] > 2) {
			$alerta = [
				"Alerta" => "exitoredireccion",
				"Titulo" => "PETICIÓN DENEGADA",
				"Texto" => "No tienes los permisos necesarios para realizar esta operación",
				"Tipo" => "error",
				"URL" => SERVERURL . "clientes-activos/"
			];
			echo json_encode($alerta);
			exit();
		}

		/*== comprobar campos vacios ==*/
		if ($nombreCliente == "" || $municipioCliente == "" || $direccionCliente == "" || $tipoCliente == "" || $planCliente == "" || $ipClientec == "" || $nombreServicio == "" || $passServicio == "" || $tipoServicio == "" || $perfil == "" || $ipCliente == "" || $fechaContratoCliente == "" || $telefonoCliente == "" || $gpsCliente == "" || $estadoContratoCliente == "") {
			$alerta = [
				"Alerta" => "simple",
				"Titulo" => "Ocurrió un error inesperado",
				"Texto" => "No has llenado todos los campos que son obligatorios",
				"Tipo" => "error"
			];
			echo json_encode($alerta);
			exit();
		}

		/*== Comprobando Nmbre del cliente ==*/
		$check_usuario = mainModel::ejecutar_consulta_simple("SELECT nombre_cliente FROM cliente WHERE nombre_cliente='$nombreCliente'");

		if ($check_usuario->rowCount() > 0) {

			$alerta = [
				"Alerta" => "simple",
				"Titulo" => "Ocurrió un error inesperado",
				"Texto" => "El CLIENTE ingresado ya se encuentra registrado en el sistema",
				"Tipo" => "error"
			];
			echo json_encode($alerta);
			exit();
		}

		$datos_cliente_reg = [
			"NOMBRE" => $nombreCliente,
			"TELEFONO" => $telefonoCliente,
			"IDMUNICIPIO" => $municipioCliente,
			"DOMICILIO" => $direccionCliente,
			"GPS" => $gpsCliente,
			"TIPOCLIENTE" => $tipoCliente
		];

		$agregar_cliente = pppoeModelo::agregar_cliente_modelo($datos_cliente_reg, "cliente");
		$exito = 0;
		if ($agregar_cliente->rowCount() == 1) {
			$exito = 1;
			$obtener_id_cliente = pppoeModelo::agregar_cliente_modelo($nombreCliente, "idCliente");
			$id = "";
			foreach ($obtener_id_cliente as $rows) {
				$id = $rows['id_cliente'];
			}

			$datos_contrato_reg = [
				"IDCLIENTE" => $id,
				"FECHACONTRATO" => $fechaContratoCliente,
				"PLAN" => $planCliente,
				"ESTADOCONTRATO" => $estadoContratoCliente,
				"IP" => $ipClientec
			];

			$agregar_contrato = pppoeModelo::agregar_cliente_modelo($datos_contrato_reg, "contrato");

			if ($agregar_contrato->rowCount() == 1 && $exito == 1) {
				$exito = 2;
				$datos_cliente_ppp_router_reg = [
					"NAME" => $nombreServicio,
					"PASSWORD" => $passServicio,
					"SERVICE" => $tipoServicio,
					"PROFILE" => $perfil,
					"REMOTE_ADDRESS" => $ipCliente
				];

				$agregar_cliente_router = RouterR::pppAgregarClientePPP($datos_cliente_ppp_router_reg);

				if ($agregar_cliente_router == 1 && $exito == 2) {
					$exito = 3;
				}
			}
		}

		switch ($exito) {
			case 0: {
					$alerta = [
						"Alerta" => "simple",
						"Titulo" => "Ocurrió un error inesperado",
						"Texto" => "No hemos podido registrar al cliente, porfavor verifique los datos e intenete nuevamente",
						"Tipo" => "error"
					];
					echo json_encode($alerta);
					exit();
					break;
				}
			case 1: {
					$alerta = [
						"Alerta" => "simple",
						"Titulo" => "Ocurrió un error inesperado",
						"Texto" => "NO se pudo registrar los datos del contrato",
						"Tipo" => "error"
					];
					echo json_encode($alerta);
					exit();
					break;
				}
			case 2: {
					$alerta = [
						"Alerta" => "simple",
						"Titulo" => "Ocurrió un error inesperado",
						"Texto" => "NO se pudo completar la petición del registro del cliente al Router Mikrotik",
						"Tipo" => "error"
					];
					echo json_encode($alerta);
					exit();
					break;
				}
			case 3: {
					$alerta = [
						"Alerta" => "exitoredireccion",
						"Titulo" => "CLIENTE REGISTRADO",
						"Texto" => "El Cliente ha sido registrado correctamente",
						"Tipo" => "success",
						"URL" => SERVERURL . "clientes-activos/"
					];
					echo json_encode($alerta);
					exit();
					break;
				}
			default: {
					break;
				}
		}
	} /* Fin controlador */


	//Controlador para actualizar el cliente
	public function actualizarClienteControlador()
	{
		// recibiendo ip
		$ip = mainModel::decryption($_POST['cliente_ip_update']);

		// comprobar privilegios
		session_start(['name' => 'LMR']);
		if ($_SESSION['id_rol_lmr'] > 2) {
			$alerta = [
				"Alerta" => "exitoredireccion",
				"Titulo" => "PETICIÓN DENEGADA",
				"Texto" => "No tienes los permisos necesarios para realizar esta operación",
				"Tipo" => "error",
				"URL" => SERVERURL . "clientes-activos/"
			];
			echo json_encode($alerta);
			exit();
		}

		//comprobar el Cliente en la base de datos
		$check_cliente = mainModel::ejecutar_consulta_simple("SELECT * FROM contrato_servicio WHERE ip_asignada='$ip'");

		if ($check_cliente->rowCount() <= 0) {
			$alerta = [
				"Alerta" => "simple",
				"Titulo" => "ACCION ABORTADA",
				"Texto" => "NO hay registros del usuario en la base de datos del sistema",
				"Tipo" => "error"
			];
			echo json_encode($alerta);
			exit();
		}

		$ip = mainModel::decryption($_POST['cliente_ip_update']);
		$ip = mainModel::limpiar_cadena($ip);
		$id_clienteRU = $_POST['id_clienteR_Up'];
		$id_clienteU = mainModel::limpiar_cadena($_POST['id_cliente_Up']);
		$nombreClienteU = mainModel::limpiar_cadena($_POST['nombreCliente_Up']);
		$telefonoClienteU = mainModel::limpiar_cadena($_POST['telefonoCliente_Up']);
		$municipioClienteU = mainModel::limpiar_cadena($_POST['municipioCliente_Up']);
		$direccionClienteU = mainModel::limpiar_cadena($_POST['direccionCliente_Up']);
		$gpsClienteU = mainModel::limpiar_cadena($_POST['gpsCliente_Up']);
		$tipoClienteU = mainModel::limpiar_cadena($_POST['tipoCliente_Up']);
		$fechaContratoClienteU = $_POST['fechaContratoCliente_Up'];
		$planClienteU = mainModel::limpiar_cadena($_POST['planCliente_Up']);
		$ipClientecU = mainModel::limpiar_cadena($_POST['ipClientec_Up']);
		$estadoContratoClienteU = mainModel::limpiar_cadena($_POST['estadoContratoCliente_Up']);
		$nombreServicioU = mainModel::limpiar_cadena($_POST['nombreServicio_Up']);
		$passServicioU = mainModel::limpiar_cadena($_POST['passServicio_Up']);
		$tipoServicioU = mainModel::limpiar_cadena($_POST['tipoServicio_Up']);
		$perfilU = mainModel::limpiar_cadena($_POST['perfil_Up']);
		$ipClienteU = mainModel::limpiar_cadena($_POST['ipCliente_Up']);

		/*== comprobar campos vacios ==*/
		if ($nombreClienteU == "" || $municipioClienteU == "" || $direccionClienteU == "" || $tipoClienteU == "" || $planClienteU == "" || $ipClientecU == "" || $nombreServicioU == "" || $passServicioU == "" || $tipoServicioU == "" || $perfilU == "" || $ipClienteU == "" || $fechaContratoClienteU == "" || $telefonoClienteU == "" || $gpsClienteU == "" || $estadoContratoClienteU == "") {
			$alerta = [
				"Alerta" => "simple",
				"Titulo" => "Ocurrió un error inesperado",
				"Texto" => "No has llenado todos los campos que son obligatorios",
				"Tipo" => "error"
			];
			echo json_encode($alerta);
			exit();
		}

		// Preparando datos cliente para enviarlos al modelo
		$datos_cliente_update = [
			"ID_CLIENTE" => $id_clienteU,
			"NOMBRE" => $nombreClienteU,
			"TELEFONO" => $telefonoClienteU,
			"MUNICIPIO" => $municipioClienteU,
			"DOMICILIO" => $direccionClienteU,
			"UBICACION_GPS" => $gpsClienteU,
			"ID_TIPO_CLIENTE" => $tipoClienteU
		];
		$exito = 0;
		if (pppoeModelo::actualizarClienteModelo($datos_cliente_update)) {
			$exito = 1;
			// Preparando datos cliente para enviarlos al modelo
			$datos_contrato_cliente_update = [
				"ID_CLIENTEC" => $id_clienteU,
				"FECHA_CONTRATO" => $fechaContratoClienteU,
				"PLAN" => $planClienteU,
				"ESTADO_CONTRATO" => $estadoContratoClienteU,
				"IP_ASIGNADA" => $ipClientecU
			];

			if (pppoeModelo::actualizarContratoClienteModelo($datos_contrato_cliente_update)) {
				$exito = 2;
				$datos_cliente_ppp_router_up = [
					"ID" => $id_clienteRU,
					"NAME" => $nombreServicioU,
					"PASSWORD" => $passServicioU,
					"SERVICE" => $tipoServicioU,
					"PROFILE" => $perfilU,
					"REMOTE_ADDRESS" => $ipClienteU
				];


				$actualizar_cliente_router = RouterR::pppModificarClientePPP($datos_cliente_ppp_router_up);

				if ($actualizar_cliente_router == 1 && $exito == 2) {
					$exito = 3;
				}
			}
		}

		switch ($exito) {
			case 0: {
					$alerta = [
						"Alerta" => "simple",
						"Titulo" => "ACCIÓN ABORTADA",
						"Texto" => "Error en los datos del cliente",
						"Tipo" => "error"
					];
					echo json_encode($alerta);
					exit();
					break;
				}
			case 1: {
					$alerta = [
						"Alerta" => "simple",
						"Titulo" => "ACCIÓN ABORTADA",
						"Texto" => "NO se pudo actualizar los datos del contrato",
						"Tipo" => "error"
					];
					echo json_encode($alerta);
					exit();
					break;
				}
			case 2: {
					$alerta = [
						"Alerta" => "simple",
						"Titulo" => "ACCIÓN ABORTADA",
						"Texto" => "El Router Mikrotik rechazó la petición",
						"Tipo" => "error"
					];
					echo json_encode($alerta);
					exit();
					break;
				}
			case 3: {
					$alerta = [
						"Alerta" => "exitoredireccion",
						"Titulo" => "ACTUALIZACIÓN EXITOSA",
						"Texto" => "Cliente actualizado en Router Mikrotik y Base de Datos",
						"Tipo" => "success",
						"URL" => SERVERURL . "clientes-activos/"
					];
					echo json_encode($alerta);
					exit();
					break;
				}
			default: {
					break;
				}
		}
	} //fin controlador


	//suspender cliente
	public function suspenderClienteControlador()
	{
		//recibiendo id del usuario
		$id = mainModel::decryption($_POST['pppoe_id_disabled']);
		$name = mainModel::decryption($_POST['pppoe_name_disabled']);
		$ip = mainModel::decryption($_POST['pppoe_ip_disabled']);
		$status = "Suspendido";
		//$id = mainModel::limpiar_cadena($id);
		$name = mainModel::limpiar_cadena($name);
		//$ip = mainModel::limpiar_cadena($ip);

		//comprobando el usuario principal
		if ($id == "*1" || $id == "*C1" || $id == "*2" || $id == "*9E") {
			$alerta = [
				"Alerta" => "simple",
				"Titulo" => "ACCIÓN DENEGADA",
				"Texto" => "Cuenta protegida",
				"Tipo" => "error"
			];
			echo json_encode($alerta);
			exit();
		}

		// comprobando el usuario en BD
		// $check_cliente = mainModel::ejecutar_consulta_simple("SELECT ip_asignada FROM contrato_servicio WHERE ip_asignada='$ip'");

		// if ($check_cliente->rowCount() <= 0) {
		// 	$alerta = [
		// 		"Alerta" => "simple",
		// 		"Titulo" => "ACCIÓN DENEGADA",
		// 		"Texto" => "No hay vinculos en la Base de Datos",
		// 		"Tipo" => "error"
		// 	];
		// 	echo json_encode($alerta);
		// 	exit();
		// }

		// comprobar privilegios
		session_start(['name' => 'LMR']);
		if ($_SESSION['id_rol_lmr'] > 2) {
			$alerta = [
				"Alerta" => "simple",
				"Titulo" => "ACCIÓN DENEGADA",
				"Texto" => "Sesion Actual con Privilegios Insuficientes",
				"Tipo" => "error"
			];
			echo json_encode($alerta);
			exit();
		}

		$suspender_cliente = RouterR::reactivarClientePPP($id, $name, $ip);
		$exito = 0;
		if ($suspender_cliente == 1) {
			$exito = 1;

			// $datos_contrato = [
			// 	"ESTADO_CONTRATO" => $status,
			// 	"IP_ASIGNADA" => $ip
			// ];

			// if (pppoeModelo::actualizarEstadoContratoClienteModelo($datos_contrato)) {
			// 	$exito = 2;
			// }
		}

		switch ($exito) {
			case 0: {
					$alerta = [
						"Alerta" => "simple",
						"Titulo" => "CLIENTE NO SUSPENDIDO",
						"Texto" => "El Router Mikrotik rechazó la petición",
						"Tipo" => "error"
					];
					echo json_encode($alerta);
					exit();
					break;
				}
			case 2: {
					$alerta = [
						"Alerta" => "simple",
						"Titulo" => "ERROR SQL",
						"Texto" => "Cambios no realizados en Base de Datos",
						"Tipo" => "error"
					];
					echo json_encode($alerta);
					exit();
					break;
				}
			case 1: {
					$alerta = [
						"Alerta" => "recargar",
						"Titulo" => "CLIENTE SUSPENDIDO EXITOSAMENTE",
						"Texto" => "Cambios realizados en Router Mikrotik y Base de Datos",
						"Tipo" => "success"
					];
					echo json_encode($alerta);
					exit();
					break;
				}
			default: {
					break;
				}
		}
	} // fin controlador


	//suspender cliente
	public function reactivarClienteControlador()
	{
		//recibiendo id del usuario
		$id = mainModel::decryption($_POST['cliente_id_enabled']);
		$name = mainModel::decryption($_POST['cliente_name_enabled']);
		$ip = mainModel::decryption($_POST['cliente_ip_enabled']);
		$id = mainModel::limpiar_cadena($id);
		$name = mainModel::limpiar_cadena($name);
		$ip = mainModel::limpiar_cadena($ip);
		$status = "Activo";


		// comprobando el usuario en BD
		$check_cliente = mainModel::ejecutar_consulta_simple("SELECT ip_asignada FROM contrato_servicio WHERE ip_asignada='$ip'");

		if ($check_cliente->rowCount() <= 0) {
			$alerta = [
				"Alerta" => "simple",
				"Titulo" => "ACCIÓN DENEGADA",
				"Texto" => "No existe un vinculo del Router Mikrotik a la Base de Datos",
				"Tipo" => "error"
			];
			echo json_encode($alerta);
			exit();
		}

		// comprobar privilegios
		session_start(['name' => 'LMR']);
		if ($_SESSION['id_rol_lmr'] > 2) {
			$alerta = [
				"Alerta" => "simple",
				"Titulo" => "ACCIÓN DENEGADA",
				"Texto" => "Privilegios Insuficientes",
				"Tipo" => "error"
			];
			echo json_encode($alerta);
			exit();
		}

		$reactivar_cliente = RouterR::reactivarClientePPP($id);

		$exito = 0;
		if ($reactivar_cliente == 1) {
			$exito = 1;

			$datos_contrato = [
				"ESTADO_CONTRATO" => $status,
				"IP_ASIGNADA" => $ip
			];

			if (pppoeModelo::actualizarEstadoContratoClienteModelo($datos_contrato)) {
				$exito = 2;
			}
		}

		switch ($exito) {
			case 0: {
					$alerta = [
						"Alerta" => "simple",
						"Titulo" => "CLIENTE NO REACTIVADO",
						"Texto" => "El Router Mikrotik rechazó la petición",
						"Tipo" => "error"
					];
					echo json_encode($alerta);
					exit();
					break;
				}
			case 1: {
					$alerta = [
						"Alerta" => "simple",
						"Titulo" => "ERROR SQL",
						"Texto" => "Cambios no realizados en Base de Datos",
						"Tipo" => "error"
					];
					echo json_encode($alerta);
					exit();
					break;
				}
			case 2: {
					$alerta = [
						"Alerta" => "recargar",
						"Titulo" => "CLIENTE REACTIVADO EXITOSAMENTE",
						"Texto" => "Cambios realizados en Router Mikrotik y Base de Datos",
						"Tipo" => "success"
					];
					echo json_encode($alerta);
					exit();
					break;
				}
			default: {
					break;
				}
		}
	} // fin controlador


	// Controlador datos del cliente
	public function datosClienteControlador($ip)
	{
		$ip = mainModel::decryption($ip);
		$ip = mainModel::limpiar_cadena($ip);
		return pppoeModelo::datosClienteModelo($ip);
	} //fin controlador

	// Controlador datos del cliente
	public function datosClienteFacturaControlador($idfactura)
	{
		$idfactura = mainModel::decryption($idfactura);
		$idfactura = mainModel::limpiar_cadena($idfactura);
		return pppoeModelo::datosClienteFacturaModelo($idfactura);
	} //fin controlador


	// controlador para llenar selects
	public function llenarSelect($op, $id, $tabla)
	{
		$op = mainModel::limpiar_cadena($op);
		$id = mainModel::decryption($id);
		$id = mainModel::limpiar_cadena($id);
		$tabla = mainModel::limpiar_cadena($tabla);

		return pppoeModelo::datosSelect($op, $id, $tabla);
	} // fin controlador

	// controlador para desencriptar password Cliente
	public function desencriptar($pass)
	{
		$pass = mainModel::limpiar_cadena($pass);
		return mainModel::decryption($pass);
	} // fin controlador

	// controlador para formatear nombre servicio
	public function formatearServicio($cadena)
	{
		return mainModel::formatearNombreServicio($cadena);
	} // fin controlador

}
