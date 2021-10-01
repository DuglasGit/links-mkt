<?php

if ($peticionAjax) {
	require_once "../models/clienteModelo.php";
	require_once "../routerMIkrotik/Resources.php";
} else {
	require_once "./models/clienteModelo.php";
	require_once "./routerMIkrotik/Resources.php";
}

class clienteControlador extends clienteModelo
{

	// COntrolador Paginar usuario
	public function PaginadorClientesControlador($pagina, $registros, $rol, $id, $url, $busqueda)
	{
		$pagina = mainModel::limpiar_cadena($pagina);
		$registros = mainModel::limpiar_cadena($registros);
		$rol = mainModel::limpiar_cadena($rol);
		$id = mainModel::limpiar_cadena($id);
		$url = mainModel::limpiar_cadena($url);
		$busqueda = mainModel::limpiar_cadena($busqueda);
		$clientes = RouterR::RouterClientes();
		$url = SERVERURL . $url . "/";

		$tabla = "";

		$pagina = (isset($pagina) && $pagina > 0) ? (int)$pagina : 1;
		$inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;
		$datosCliente = json_decode($clientes, true);
		$consulta = $datosCliente;

		if (isset($busqueda) && $busqueda != "") {
			$consulta = array_slice($consulta, $inicio, $registros);
		} else {
			$consulta = array_slice($datosCliente, $inicio, $registros);
		}

		$total = count($datosCliente);
		$Npaginas = ceil($total / $registros);

		$tabla .= '
		<div class="table-responsive">

		<table class="table table-hover">
			<thead>
				<tr class="text-center">
					<th class="text-DANGER col-md-auto">ID</th>
					<th class="text-DANGER col-md-auto">NOMBRE DEL CLIENTE</th>
					<th class="text-DANGER col-md-auto">PLAN</th>
					<th class="text-DANGER col-md-auto">PASSWORD</th>
					<th class="text-DANGER col-md-auto">IP ASIGNADA</th>
                    <th class="text-DANGER col-md-auto">EDITAR</th>
                    <th class="text-DANGER col-md-auto">SUSPENDER</th>
                    <th class="text-DANGER col-md-auto">DESACTIVAR</th>
				</tr>
			</thead>
			<tbody id="myTable">
		';

		if ($total >= 1 && $pagina <= $Npaginas) {
			$contador = $inicio + 1;
			$registro_inicial = $inicio + 1;
			foreach ($consulta as $data) {

				$tabla .= '
					<tr class="text-center">
                        <td>' . $data['.id'] . '</td>
                        <td class="text-secondary">' . $data['name'] . '</td>
                        <td class="text-secondary">' . $data['profile'] . '</td>
                        <td class="text-secondary">' . $data['password'] . '</td>
                        <td class="text-secondary">' . $data['remote-address'] . '</td>
                        <td>
                            <a href="' . SERVERURL . 'actualizar-cliente/' . mainModel::encryption($data['.id']) . '/" type="button" class="btn btn-inverse-primary btn-icon-text btn-sm">
                                <i class="mdi mdi-lead-pencil btn-icon-prepend"></i> Editar
                            </a>
                        </td>
                        <td>
                            <button type="button" class="btn btn-inverse-warning btn-icon-text btn-sm" data-toggle="modal" data-target="#modalSuspenderCliente">
                                <i class="mdi mdi-lan-disconnect btn-icon-prepend"></i> Suspender
                            </button>
                        </td>
						<td>
                            <button type="button" class="btn btn-inverse-danger btn-icon-text btn-sm" data-toggle="modal" data-target="#modalDesactivarCliente">
                                <i class="mdi mdi-account-minus btn-icon-prepend"></i> Desactivar
                            </button>
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
				Mostrando usuario ' . $registro_inicial . ' al ' . $registro_final . ' de un total de ' . $total . '
				</p>
			</div>';

			$tabla .= mainModel::paginador_tablas($pagina, $Npaginas, $url, 10);
		}
		return $tabla;
	} // fin controlador

	public function agregarClienteControlador()
	{
		$nombreCliente = mainModel::limpiar_cadena($_POST['nombreCliente']);
		$telefonoCliente = mainModel::limpiar_cadena($_POST['telefonoCliente']);
		$municipioCliente = mainModel::limpiar_cadena($_POST['municipioCliente']);
		$direccionCliente = mainModel::limpiar_cadena($_POST['direccionCliente']);
		$gpsCliente = mainModel::limpiar_cadena($_POST['gpsCliente']);
		$tipoCliente = mainModel::limpiar_cadena($_POST['tipoCliente']);
		$fechaContratoCliente = mainModel::limpiar_cadena($_POST['fechaContratoCliente']);
		$planCliente = mainModel::limpiar_cadena($_POST['planCliente']);
		$estadoContratoCliente = mainModel::limpiar_cadena($_POST['estadoContratoCliente']);
		$nombreServicio = mainModel::limpiar_cadena($_POST['nombreServicio']);
		$passServicio = mainModel::limpiar_cadena($_POST['passServicio']);
		$tipoServicio = mainModel::limpiar_cadena($_POST['tipoServicio']);
		$perfil = mainModel::limpiar_cadena($_POST['perfil']);
		$ipCliente = mainModel::limpiar_cadena($_POST['ipCliente']);


		// /*== comprobar campos vacios ==*/
		// if ($nombre == "" || $pass == "" || $re_pass == "" || $rol == "") {
		// 	$alerta = [
		// 		"Alerta" => "simple",
		// 		"Titulo" => "Ocurrió un error inesperado",
		// 		"Texto" => "No has llenado todos los campos que son obligatorios",
		// 		"Tipo" => "error"
		// 	];
		// 	echo json_encode($alerta);
		// 	exit();
		// }


		// /*== Verificando integridad de los datos ==*/
		// if (mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,100}", $nombre)) {
		// 	$alerta = [
		// 		"Alerta" => "simple",
		// 		"Titulo" => "Ocurrió un error inesperado",
		// 		"Texto" => "El NOMBRE no coincide con el formato solicitado",
		// 		"Tipo" => "error"
		// 	];
		// 	echo json_encode($alerta);
		// 	exit();
		// }

		// if (mainModel::verificar_datos("[a-zA-Z0-9$@.-]{7,25}", $pass) || mainModel::verificar_datos("[a-zA-Z0-9$@.-]{7,25}", $re_pass)) {
		// 	$alerta = [
		// 		"Alerta" => "simple",
		// 		"Titulo" => "Ocurrió un error inesperado",
		// 		"Texto" => "Las CLAVES no coinciden con el formato solicitado",
		// 		"Tipo" => "error"
		// 	];
		// 	echo json_encode($alerta);
		// 	exit();
		// }

		// /*== Comprobando Nmbre Usuario ==*/
		// $check_usuario = mainModel::ejecutar_consulta_simple("SELECT nombre_usuario FROM usuario WHERE nombre_usuario='$nombre'");
		// if ($check_usuario->rowCount() > 0) {
		// 	$alerta = [
		// 		"Alerta" => "simple",
		// 		"Titulo" => "Ocurrió un error inesperado",
		// 		"Texto" => "El NOMBRE de usuario ingresado ya se encuentra registrado en el sistema",
		// 		"Tipo" => "error"
		// 	];
		// 	echo json_encode($alerta);
		// 	exit();
		// }

		// /*== Comprobando claves ==*/
		// if ($pass != $re_pass) {
		// 	$alerta = [
		// 		"Alerta" => "simple",
		// 		"Titulo" => "Ocurrió un error inesperado",
		// 		"Texto" => "Las claves que acaba de ingresar no coinciden",
		// 		"Tipo" => "error"
		// 	];
		// 	echo json_encode($alerta);
		// 	exit();
		// } else {
		// 	$clave = mainModel::encryption($pass);
		// }

		// /*== Comprobando privilegio ==*/
		// if ($rol < 1 || $rol > 3) {
		// 	$alerta = [
		// 		"Alerta" => "simple",
		// 		"Titulo" => "Ocurrió un error inesperado",
		// 		"Texto" => "El ROLL seleccionado no es valido",
		// 		"Tipo" => "error"
		// 	];
		// 	echo json_encode($alerta);
		// 	exit();
		// }

		// $datos_usuario_reg = [
		// 	"Nombre" => $nombre,
		// 	"Pass" => $clave,
		// 	"Rol" => $rol
		// ];

		// $agregar_usuario = usuarioModelo::agregar_usuario_modelo($datos_usuario_reg);

		// if ($agregar_usuario->rowCount() == 1) {
		// 	$alerta = [
		// 		"Alerta" => "recargar",
		// 		"Titulo" => "usuario registrado",
		// 		"Texto" => "Los datos del usuario han sido registrados con exito",
		// 		"Tipo" => "success"
		// 	];
		// } else {
		// 	$alerta = [
		// 		"Alerta" => "simple",
		// 		"Titulo" => "Ocurrió un error inesperado",
		// 		"Texto" => "No hemos podido registrar el usuario",
		// 		"Tipo" => "error"
		// 	];
		// }
		// echo json_encode($alerta);
	} /* Fin controlador */

	public function eliminarClienteControlador()
	{
	}

	public function actualizarClienteControlador()
	{
	}

	// controlador para llenar select de municipio
	public function llenarSelect($op, $id, $tabla)
	{
		$op = mainModel::limpiar_cadena($op);
		$id = mainModel::decryption($id);
		$id = mainModel::limpiar_cadena($id);
		$tabla = mainModel::limpiar_cadena($tabla);

		return clienteModelo::datosSelect($op, $id, $tabla);
	} // fin controlador

	// controlador para formatear nombre servicio
	public function formatearServicio($cadena)
	{
		return mainModel::formatearNombreServicio($cadena);

	} // fin controlador
}
