<?php

if ($peticionAjax) {
	require_once "../models/usuarioModelo.php";
} else {
	require_once "./models/usuarioModelo.php";
}

class usuarioControlador extends usuarioModelo
{

	/*--------- Controlador agregar usuario ---------*/
	public function agregar_usuario_controlador()
	{
		$nombre = mainModel::limpiar_cadena($_POST['nombre_reg']);
		$pass = mainModel::limpiar_cadena($_POST['password_reg']);
		$re_pass = mainModel::limpiar_cadena($_POST['re_password_reg']);
		$rol = mainModel::limpiar_cadena($_POST['rol_reg']);


		/*== comprobar campos vacios ==*/
		if ($nombre == "" || $pass == "" || $re_pass == "" || $rol == "") {
			$alerta = [
				"Alerta" => "simple",
				"Titulo" => "Ocurrió un error inesperado",
				"Texto" => "No has llenado todos los campos que son obligatorios",
				"Tipo" => "error"
			];
			echo json_encode($alerta);
			exit();
		}


		/*== Verificando integridad de los datos ==*/
		if (mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,100}", $nombre)) {
			$alerta = [
				"Alerta" => "simple",
				"Titulo" => "Ocurrió un error inesperado",
				"Texto" => "El NOMBRE no coincide con el formato solicitado",
				"Tipo" => "error"
			];
			echo json_encode($alerta);
			exit();
		}

		if (mainModel::verificar_datos("[a-zA-Z0-9$@.-]{7,25}", $pass) || mainModel::verificar_datos("[a-zA-Z0-9$@.-]{7,25}", $re_pass)) {
			$alerta = [
				"Alerta" => "simple",
				"Titulo" => "Ocurrió un error inesperado",
				"Texto" => "Las CLAVES no coinciden con el formato solicitado",
				"Tipo" => "error"
			];
			echo json_encode($alerta);
			exit();
		}

		/*== Comprobando Nmbre Usuario ==*/
		$check_usuario = mainModel::ejecutar_consulta_simple("SELECT nombre_usuario FROM usuario WHERE nombre_usuario='$nombre'");
		if ($check_usuario->rowCount() > 0) {
			$alerta = [
				"Alerta" => "simple",
				"Titulo" => "Ocurrió un error inesperado",
				"Texto" => "El NOMBRE de usuario ingresado ya se encuentra registrado en el sistema",
				"Tipo" => "error"
			];
			echo json_encode($alerta);
			exit();
		}


		/*== Comprobando email ==*/
		// if ($email != "") {
		// 	if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
		// 		$check_email = mainModel::ejecutar_consulta_simple("SELECT usuario_email FROM usuario WHERE usuario_email='$email'");
		// 		if ($check_email->rowCount() > 0) {
		// 			$alerta = [
		// 				"Alerta" => "simple",
		// 				"Titulo" => "Ocurrió un error inesperado",
		// 				"Texto" => "El EMAIL ingresado ya se encuentra registrado en el sistema",
		// 				"Tipo" => "error"
		// 			];
		// 			echo json_encode($alerta);
		// 			exit();
		// 		}
		// 	} else {
		// 		$alerta = [
		// 			"Alerta" => "simple",
		// 			"Titulo" => "Ocurrió un error inesperado",
		// 			"Texto" => "Ha ingresado un correo no valido",
		// 			"Tipo" => "error"
		// 		];
		// 		echo json_encode($alerta);
		// 		exit();
		// 	}
		// }


		/*== Comprobando claves ==*/
		if ($pass != $re_pass) {
			$alerta = [
				"Alerta" => "simple",
				"Titulo" => "Ocurrió un error inesperado",
				"Texto" => "Las claves que acaba de ingresar no coinciden",
				"Tipo" => "error"
			];
			echo json_encode($alerta);
			exit();
		} else {
			$clave = mainModel::encryption($pass);
		}

		/*== Comprobando privilegio ==*/
		if ($rol < 1 || $rol > 3) {
			$alerta = [
				"Alerta" => "simple",
				"Titulo" => "Ocurrió un error inesperado",
				"Texto" => "El ROLL seleccionado no es valido",
				"Tipo" => "error"
			];
			echo json_encode($alerta);
			exit();
		}

		$datos_usuario_reg = [
			"Nombre" => $nombre,
			"Pass" => $clave,
			"Rol" => $rol
		];

		$agregar_usuario = usuarioModelo::agregar_usuario_modelo($datos_usuario_reg);

		if ($agregar_usuario->rowCount() == 1) {
			$alerta = [
				"Alerta" => "recargar",
				"Titulo" => "usuario registrado",
				"Texto" => "Los datos del usuario han sido registrados con exito",
				"Tipo" => "success"
			];
		} else {
			$alerta = [
				"Alerta" => "simple",
				"Titulo" => "Ocurrió un error inesperado",
				"Texto" => "No hemos podido registrar el usuario",
				"Tipo" => "error"
			];
		}
		echo json_encode($alerta);
	} /* Fin controlador */


	// COntrolador Paginar usuario
	public function PaginadorUsuarioControlador($pagina, $registros, $rol, $id, $url, $busqueda)
	{
		$pagina = mainModel::limpiar_cadena($pagina);
		$registros = mainModel::limpiar_cadena($registros);
		$rol = mainModel::limpiar_cadena($rol);
		$id = mainModel::limpiar_cadena($id);
		$url = mainModel::limpiar_cadena($url);
		$busqueda = mainModel::limpiar_cadena($busqueda);

		$url = SERVERURL . $url . "/";

		$tabla = "";

		$pagina = (isset($pagina) && $pagina > 0) ? (int)$pagina : 1;
		$inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;

		if (isset($busqueda) && $busqueda != "") {
			$consulta = "SELECT SQL_CALC_FOUND_ROWS usuario.id_usuario, usuario.nombre_usuario, usuario.password_usuario, usuario.id_rol, rol_usuario.nombre_rol FROM rol_usuario JOIN usuario ON (rol_usuario.id_rol=usuario.id_rol) WHERE ((id_usuario!='$id' AND id_usuario!='1' AND id_rol!='1') OR nombre_usuario LIKE '%$busqueda%')  ORDER BY nombre_usuario ASC LIMIT $inicio, $registros";
		} else {
			$consulta = "SELECT SQL_CALC_FOUND_ROWS usuario.id_usuario, usuario.nombre_usuario, usuario.password_usuario, usuario.id_rol, rol_usuario.nombre_rol FROM rol_usuario JOIN usuario ON (rol_usuario.id_rol=usuario.id_rol) WHERE id_usuario!='$id' AND id_usuario!='1' ORDER BY nombre_usuario ASC LIMIT $inicio, $registros";
		}

		$conexion = mainModel::conectar();
		$datos = $conexion->query($consulta);
		$datos = $datos->fetchAll();
		$total = $conexion->query("SELECT FOUND_ROWS()");
		$total = (int) $total->fetchColumn();
		$Npaginas = ceil($total / $registros);

		$tabla .= '
		<div class="table-responsive">

		<table class="table table-hover">
			<thead>
				<tr class="text-center">
					<th class="text-warning col-sm-2">ID</th>
					<th class="text-warning col-sm-6">NOMBRE</th>
					<th class="text-warning col-sm-2">ROLL</th>
					<th class="text-warning col-sm-1">EDITAR</th>
					<th class="text-warning col-sm-1">ELIMINAR</th>
				</tr>
			</thead>
			<tbody id="myTable">
		';

		if ($total >= 1 && $pagina <= $Npaginas) {
			$contador = $inicio + 1;
			$registro_inicial = $inicio + 1;
			foreach ($datos as $rows) {
				$tabla .= '
					<tr class="text-center">
                        <td>' . $rows['id_usuario'] . '</td>
                        <td class="text-secondary">' . $rows['nombre_usuario'] . '</td>
                        <td class="text-secondary">' . $rows['nombre_rol'] . '</td>
                        <td>
                            <a href="' . SERVERURL . 'user-update/' . mainModel::encryption($rows['id_usuario']) . '/" type="button" class="btn btn-inverse-warning btn-icon-text">
                                <i class="mdi mdi-lead-pencil btn-icon-prepend"></i> Editar
                            </a>
                        </td>
						<td>
						<form class="FormularioAjax" action="' . SERVERURL . 'ajax/usuarioAjax.php" method="POST" data-form="delete" autocomplete="off">
								<input type="hidden" name="id_usuario_delete" value="' . mainModel::encryption($rows['id_usuario']) . '">
								<button type="submit" class="btn btn-inverse-danger btn-icon-text" data-toggle="modal" >
									<i class="mdi mdi-delete-sweep btn-icon-prepend"></i> Eliminar
								</button>
							</form>
						</td>
                    </tr>';
				$contador++;
			}
			$registro_final = $contador - 1;
		} else {
			if ($total >= 1) {
				$tabla .= '<tr><td colspan="9">
				<a href="' . $url . '" class="btn btn-inverse-warning btn-icon-text">Haga clic aqupi para recargar el listado</a>
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

	// Controlador para Eliminar Usuario
	public function eliminarUsuarioControlador()
	{
		//recibiendo id del usuario
		$id = mainModel::decryption($_POST['id_usuario_delete']);
		$id = mainModel::limpiar_cadena($id);


		//comprobando el usuario principal
		if ($id == 1) {
			$alerta = [
				"Alerta" => "simple",
				"Titulo" => "Ocurrió un error inesperado",
				"Texto" => "No se puede eliminar el usuario principal del sistema",
				"Tipo" => "error"
			];
			echo json_encode($alerta);
			exit();
		}

		// comprobando el usuario en BD
		$check_usuario = mainModel::ejecutar_consulta_simple("SELECT id_usuario FROM usuario WHERE id_usuario='$id'");

		if ($check_usuario->rowCount() <= 0) {
			$alerta = [
				"Alerta" => "simple",
				"Titulo" => "Ocurrió un error inesperado",
				"Texto" => "El usuario que intenta eliminar no existe en el sistema",
				"Tipo" => "error"
			];
			echo json_encode($alerta);
			exit();
		}

		// comprobar privilegios
		session_start(['name' => 'LMR']);
		if ($_SESSION['id_rol_lmr'] != 1) {
			$alerta = [
				"Alerta" => "simple",
				"Titulo" => "Ocurrió un error inesperado",
				"Texto" => "No tienes los permisos necesarios para realizar esta operación",
				"Tipo" => "error"
			];
			echo json_encode($alerta);
			exit();
		}

		$eliminar_usuario = usuarioModelo::eliminar_usuario_modelo($id);

		if ($eliminar_usuario->rowCount() == 1) {
			$alerta = [
				"Alerta" => "recargar",
				"Titulo" => "Usuario Eliminado",
				"Texto" => "EL usuario ha sido eliminado correctamente",
				"Tipo" => "success"
			];
		} else {
			$alerta = [
				"Alerta" => "simple",
				"Titulo" => "Ocurrió un error inesperado",
				"Texto" => "NO se pudo eliminar el usuario, por favor intente de nuevo",
				"Tipo" => "error"
			];
		}
		echo json_encode($alerta);
	} // fin controlador

	// Controlador datos del usuario
	public function datosUsuarioControlador($tipo, $id)
	{
		$tipo = mainModel::limpiar_cadena($tipo);
		$id = mainModel::decryption($id);
		$id = mainModel::limpiar_cadena($id);

		return usuarioModelo::datosUsuarioModelo($tipo, $id);
	} //fin controlador

	// controlador para llenar select de formulario actualizar usuario
	public function llenarSelect($op, $id)
	{
		$op = mainModel::limpiar_cadena($op);
		$id = mainModel::decryption($id);
		$id = mainModel::limpiar_cadena($id);

		return usuarioModelo::datosRol($op, $id);
	} // fin controlador

	// controlador para desencriptar password usuario
	public function desencriptar($pass)
	{
		$pass = mainModel::limpiar_cadena($pass);
		return mainModel::decryption($pass);
	} // fin controlador

	// controlador actualizar usuario
	public function actualizarUsuarioControlador()
	{
		// recibiendo id
		$idd = mainModel::decryption($_POST['usuario_id_update']);

		//comprobar el usuario en la base de datos
		$check_usuario = mainModel::ejecutar_consulta_simple("SELECT * FROM usuario WHERE id_usuario='$idd'");

		if ($check_usuario->rowCount() <= 0) {
			$alerta = [
				"Alerta" => "simple",
				"Titulo" => "Ocurrió un error inesperado",
				"Texto" => "NO se encotraron datos del usuario en la base de datos del sistema",
				"Tipo" => "error"
			];
			echo json_encode($alerta);
			exit();
		}

		$id = mainModel::decryption($_POST['usuario_id_update']);
		$id = mainModel::limpiar_cadena($id);
		$nombre = mainModel::limpiar_cadena($_POST['nombreU']);
		$rol = mainModel::limpiar_cadena($_POST['rolU']);
		$pass = mainModel::limpiar_cadena($_POST['txtPassword']);
		$re_pass = mainModel::limpiar_cadena($_POST['txtRePassword']);

		/*== comprobar campos vacios ==*/
		if ($id == "" || $nombre == "" || $rol == "" || $pass == "" || $re_pass == "") {
			$alerta = [
				"Alerta" => "simple",
				"Titulo" => "Ocurrió un error inesperado",
				"Texto" => "No has llenado todos los campos que son obligatorios",
				"Tipo" => "error"
			];
			echo json_encode($alerta);
			exit();
		}

		/*== Verificando integridad de los datos ==*/
		if (mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,100}", $nombre)) {
			$alerta = [
				"Alerta" => "simple",
				"Titulo" => "Ocurrió un error inesperado",
				"Texto" => "El NOMBRE no coincide con el formato solicitado",
				"Tipo" => "error"
			];
			echo json_encode($alerta);
			exit();
		}

		if (mainModel::verificar_datos("[a-zA-Z0-9$@.-]{7,25}", $pass) || mainModel::verificar_datos("[a-zA-Z0-9$@.-]{7,25}", $re_pass)) {
			$alerta = [
				"Alerta" => "simple",
				"Titulo" => "Ocurrió un error inesperado",
				"Texto" => "Las CLAVES no coinciden con el formato solicitado",
				"Tipo" => "error"
			];
			echo json_encode($alerta);
			exit();
		}

		/*== Comprobando Nombre Usuario ==*/
		$check_nombre = mainModel::ejecutar_consulta_simple("SELECT nombre_usuario FROM usuario WHERE nombre_usuario='$nombre' AND id_usuario!='$idd'");
		if ($check_nombre->rowCount() > 0) {
			$alerta = [
				"Alerta" => "simple",
				"Titulo" => "Ocurrió un error inesperado",
				"Texto" => "El NOMBRE de usuario ingresado ya se encuentra registrado en el sistema",
				"Tipo" => "error"
			];
			echo json_encode($alerta);
			exit();
		}

		/*== Comprobando claves ==*/
		if ($pass != $re_pass) {
			$alerta = [
				"Alerta" => "simple",
				"Titulo" => "Ocurrió un error inesperado",
				"Texto" => "Las Nuevas claves ingresadas no coinciden",
				"Tipo" => "error"
			];
			echo json_encode($alerta);
			exit();
		} else {
			$clave = mainModel::encryption($pass);
		}


		// Preparando datos para enviarlos al modelo
		$datos_usuario_update = [
			"NOMBRE" => $nombre,
			"PASS" => $clave,
			"ROL" => $rol,
			"ID" => $id
		];

		if (usuarioModelo::actualizarUsuarioModelo($datos_usuario_update)) {
			$alerta = [
				"Alerta" => "recargar",
				"Titulo" => "Datos actualizados",
				"Texto" => "Los datos del usuario han sido actualizados con exito",
				"Tipo" => "success"
			];
		} else {
			$alerta = [
				"Alerta" => "simple",
				"Titulo" => "Ocurrió un error inesperado",
				"Texto" => "No se pudo realizar la actualización, por favor intente de nuevo",
				"Tipo" => "error"
			];
		}
		echo json_encode($alerta);
	} //fin cntrolador
}
