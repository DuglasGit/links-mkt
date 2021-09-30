<?php

if ($peticionAjax) {
    require_once "../models/usuarioModelo.php";
    require_once "../routerMIkrotik/Resources.php";
} else {
    require_once "./models/usuarioModelo.php";
    require_once "./routerMIkrotik/Resources.php";
}

class clientesControlador extends usuarioModelo
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
            foreach ($consulta as $data){

                $tabla .= '
					<tr class="text-center">
                        <td>' . $data['.id'] . '</td>
                        <td class="text-secondary">' . $data['name'] . '</td>
                        <td class="text-secondary">' . $data['profile'] . '</td>
                        <td class="text-secondary">' . $data['password'] . '</td>
                        <td class="text-secondary">' . $data['remote-address'] . '</td>
                        <td>
                            <button type="button" class="btn btn-inverse-primary btn-icon-text btn-sm" data-toggle="modal" data-target="#modalEditarCliente">
                                <i class="mdi mdi-lead-pencil btn-icon-prepend"></i> Editar
                            </button>
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

}
