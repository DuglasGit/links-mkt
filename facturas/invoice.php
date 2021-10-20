<?php

$peticionAjax = true;
require_once "../config/APP.php";

$id = (isset($_GET['id'])) ? $_GET['id'] : 0;
$idfactura = (isset($_GET['idf'])) ? $_GET['idf'] : 0;
$opcion = (isset($_GET['op'])) ? $_GET['op'] : 0;

//Instancia al controlador Factura
require_once "../controllers/facturaControlador.php";
$ins_factura = new facturaControlador();

$datos_factura = $ins_factura->datosFacturaControlador("unico_cancelado_pdf", $idfactura);

if ($datos_factura->rowCount() == 1) {

	$datos_factura = $datos_factura->fetch();

	//Instancia al controlador Empresa
	require_once "../controllers/empresaControlador.php";
	$ins_empresa = new empresaControlador();

	$datos_empresa = $ins_empresa->datosEmpresaControlador();
	$datos_empresa = $datos_empresa->fetch();

	//Obtener datos del usuario que imprime la factura
	session_start(['name' => 'LMR']);


	require "./fpdf.php";

	$pdf = new FPDF('P', 'mm', 'Letter', true);
	$pdf->SetMargins(17, 17, 17);
	$pdf->AddPage();
	//$pdf->AddPage('landsacape', array(215,140));
	$pdf->Image('../views/assets/images/logo.png', 19, 10, 30, 30, 'PNG');

	$pdf->SetFont('Arial', 'B', 18);
	$pdf->SetTextColor(0, 55, 139);
	$pdf->Cell(0, 10, utf8_decode(strtoupper($datos_empresa['nombre_empresa'])), 0, 0, 'C');
	$pdf->SetFont('Arial', '', 12);
	$pdf->SetTextColor(33, 33, 33);
	$pdf->Cell(-35, 10, utf8_decode('N. de factura'), '', 0, 'C');



	$pdf->Ln(7);

	/*----------  INFO. EMPRESA  ----------*/
	$pdf->SetFont('Arial', '', 9);
	$pdf->Cell(0, 6, utf8_decode($datos_empresa['domicilio'] . ", " . $datos_empresa['nombre_municipio'] . ", " . $datos_empresa['nombre_departamento']), 0, 0, 'C');
	$pdf->SetFont('Courier', 'B', 12);
	$pdf->SetTextColor(169, 0, 0);
	$pdf->Cell(-35, 10, utf8_decode($datos_factura['idfactura']), '', 0, 'C');
	$pdf->Ln(4);
	$pdf->SetFont('Arial', '', 9);
	$pdf->SetTextColor(33, 33, 33);
	$pdf->Cell(0, 6, utf8_decode("Teléfonos: " . $datos_empresa['telefono_empresa']), 0, 0, 'C');
	$pdf->Ln(4);
	$pdf->Cell(0, 6, utf8_decode("Correo: " . $datos_empresa['correo_empresa']), 0, 0, 'C');

	$pdf->Ln(10);
	$pdf->SetFont('Arial', '', 9);
	$pdf->SetTextColor(33, 33, 33);
	$pdf->Cell(47, 8, utf8_decode('Fecha de Emisión de la Factura:'), 0, 0);
	$pdf->SetTextColor(97, 97, 97);
	$pdf->Cell(27, 8, utf8_decode(date("d/m/Y", strtotime($datos_factura['fecha']))), 0, 0);
	$pdf->Ln(4);
	$fechaActual = date('d/m/Y H:i:s');
	$pdf->SetTextColor(33, 33, 33);
	$pdf->Cell(30, 8, utf8_decode('Fecha de Impresión:'), 0, 0);
	$pdf->SetTextColor(97, 97, 97);
	$pdf->Cell(27, 8, utf8_decode($fechaActual), 0, 0);
	$pdf->Ln(4);
	$pdf->SetTextColor(33, 33, 33);
	$pdf->Cell(21, 8, utf8_decode('Atendido por:'), "", 0, 0);
	$pdf->SetTextColor(97, 97, 97);
	$pdf->Cell(13, 8, utf8_decode($_SESSION['usuario_lmr']), 0, 0);

	$pdf->Ln(8);

	$pdf->SetFont('Arial', '', 12);
	$pdf->SetTextColor(33, 33, 33);
	$pdf->Cell(15, 8, utf8_decode('Cliente:'), 0, 0);
	$pdf->SetTextColor(97, 97, 97);
	$pdf->Cell(69, 8, utf8_decode($datos_factura['nombre_cliente']), 0, 0);
	$pdf->SetTextColor(33, 33, 33);
	$pdf->Cell(25, 8, utf8_decode('TELÉFONO:'), 0, 0);
	$pdf->SetTextColor(97, 97, 97);
	$pdf->Cell(40, 8, utf8_decode($datos_factura['telefono_cliente']), 0, 0);

	$pdf->Ln(5);

	$pdf->SetTextColor(33, 33, 33);
	$pdf->Cell(20, 8, utf8_decode('Municipio:'), 0, 0);
	$pdf->SetTextColor(97, 97, 97);
	$pdf->Cell(64, 8, utf8_decode($datos_factura['nombre_municipio']), 0, 0);
	$pdf->SetTextColor(33, 33, 33);

	$pdf->Cell(20, 8, utf8_decode('Domicilio:'), 0, 0);
	$pdf->SetTextColor(97, 97, 97);
	$pdf->Cell(76, 8, utf8_decode($datos_factura['domicilio']), 0, 0);


	$pdf->Ln(10);

	$pdf->SetFillColor(105, 153, 226);
	$pdf->SetDrawColor(105, 153, 226);
	$pdf->SetTextColor(33, 33, 33);
	$pdf->SetFont('Arial', '', 10);
	$pdf->Cell(15, 10, utf8_decode('Cant.'), 1, 0, 'C', true);
	$pdf->Cell(106, 10, utf8_decode('Descripción'), 1, 0, 'C', true);
	$pdf->Cell(25, 10, utf8_decode('precio Unitario'), 1, 0, 'C', true);
	$pdf->Cell(35, 10, utf8_decode('Subtotal'), 1, 0, 'C', true);

	$pdf->Ln(10);

	$pdf->SetTextColor(97, 97, 97);


	//detalles de la factura
	$fechaHoy = date('Y/m/d');
	$ins_det_factura = new facturaControlador();
	$datos_detalle_factura = "";
	$total = 0;
	$mes_ini = "";
	$mes_fin = "";

	if ($opcion == 't') {
		$datos_detalle_factura = $ins_det_factura->datosDetalleFacturaControlador($id, $fechaHoy);
		$datos_detalle_factura = $datos_detalle_factura->fetchAll();
		foreach ($datos_detalle_factura as $items) {

			$subtotal = $items['cantidad'] * $items['precio'];
			$subtotal = number_format($subtotal, 2, '.', '');
			$pdf->Cell(15, 8, utf8_decode($items['cantidad']), 'L', 0, 'C');
			$pdf->Cell(106, 8, utf8_decode($items['id_factura'] . " - " . $items['id_producto_servicio'] . " - " . $items['nombre_producto_servicio'] . " - " . $items['mes_pagado']), 'L', 0);
			$pdf->Cell(25, 8, utf8_decode(MONEDA . $items['precio']), 'L', 0, 'C');
			$pdf->Cell(35, 8, utf8_decode(MONEDA . $subtotal), 'LR', 0, 'C');
			if ($total == 0) {
				$mes_ini = $items['mes_pagado'];
				$mes_fin = $mes_ini;
			} else {
				$mes_fin = $mes_ini . "-" . $items['mes_pagado'];
			}
			$pdf->Ln(8);
			$total += $subtotal;
		}
	} else if ($opcion == 'h') {
		$datos_detalle_factura = $ins_det_factura->datosDetalleFacturaControlador($id, 0);
		$datos = $datos_detalle_factura->fetch();
		$subtotal = $datos['cantidad'] * $datos['precio'];
		$subtotal = number_format($subtotal, 2, '.', '');
		$pdf->Cell(15, 8, utf8_decode($datos['cantidad']), 'L', 0, 'C');
		$pdf->Cell(106, 8, utf8_decode($datos['id_factura'] . " - " . $datos['id_producto_servicio'] . " - " . $datos['nombre_producto_servicio'] . " - " . $datos['mes_pagado']), 'L', 0, 'C');
		$pdf->Cell(25, 8, utf8_decode(MONEDA . $datos['precio']), 'L', 0, 'C');
		$pdf->Cell(35, 8, utf8_decode(MONEDA . $subtotal), 'LR', 0, 'C');
		if ($total == 0) {
			$mes_ini = $datos['mes_pagado'];
			$mes_fin = $mes_ini;
		} else {
			$mes_fin = $mes_ini . "-" . $datos['mes_pagado'];
		}
		$pdf->Ln(8);
		$total += $subtotal;
	}

	$pdf->SetTextColor(33, 33, 33);
	$pdf->Cell(15, 8, utf8_decode(''), 'T', 0, 'C');
	$pdf->Cell(106, 8, utf8_decode(''), 'T', 0, 'C');
	$pdf->Cell(25, 8, utf8_decode('TOTAL'), 'LTB', 0, 'C');
	$pdf->Cell(35, 8, utf8_decode(MONEDA . number_format($total, 2, '.', '')), 'LRTB', 0, 'C');

	$pdf->SetFont('Courier', 'B', 8);
	$ins_facturas_pendientes = new facturaControlador();
	$datosp = $ins_facturas_pendientes->datosFacturasPendientesControlador($id);
	$pendientes = "";
	if ($datosp->RowCount() <= 0) {
		$pdf->Ln(12);

		$pdf->SetTextColor(97, 97, 97);
		$pdf->MultiCell(0, 3, utf8_decode("SOLVENCIA: \nNO tiene pagos pendientes"), 0, 'J', false);
	} else if ($datosp->RowCount() == 1) {
		$pdf->Ln(12);
		foreach ($datosp as $val){
			$pendientes = $val['mes_pagado'];
		}
		$pdf->SetTextColor(97, 97, 97);
		$pdf->MultiCell(0, 3, utf8_decode("SOLVENCIA: \nPendiente de pagar el mes de: " . $pendientes), 0, 'J', false);
	} else if ($datosp->RowCount() > 1) {
		$pdf->Ln(12);
		
		$total_pendientes = $datosp->RowCount();
		$contador = 1;
		foreach ($datosp as $val) {
			if ($total_pendientes == 2 && $contador == 1) {
				$pendientes = $pendientes . $val['mes_pagado'] . " y ";
			} else if ($total_pendientes == 2 && $contador == 2) {
				$pendientes = $pendientes . $val['mes_pagado'];
			}else if ($total_pendientes > 2 && $contador >= 1 && $contador != $total_pendientes && $contador != $total_pendientes-1) {
				$pendientes = $pendientes . $val['mes_pagado'] . ", ";
			} else if ($total_pendientes > 2 && $contador >= 1 && $contador == $total_pendientes-1) {
				$pendientes = $pendientes . $val['mes_pagado'] . " y ";
			} else if ($total_pendientes > 2 && $contador >= 1 && $contador == $total_pendientes) {
				$pendientes = $pendientes . $val['mes_pagado'];
			}
			$contador++;
		}
		$pdf->SetTextColor(97, 97, 97);
		$pdf->MultiCell(0, 3, utf8_decode("SOLVENCIA: \nPendiente de pagar los meses de: " . $pendientes), 0, 'J', false);
	}



	$pdf->Output("I", "Factura_" . $datos_factura['idfactura'] . "_" . $datos_factura['nombre_cliente'] . "_" . $mes_fin . ".pdf", true);
} else {
?>
	<!DOCTYPE html>
	<html lang="es">

	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title><?php echo COMPANY; ?></title>
		<?php include "../views/include/Link.php"; ?>
	</head>

	<body>
		<div class="container-scroller">
			<div class="container-fluid page-body-wrapper full-page-wrapper">
				<div class="content-wrapper d-flex align-items-center text-center error-page bg-danger">
					<div class="row flex-grow">
						<div class="col-lg-7 mx-auto text-white">
							<div class="row align-items-center d-flex flex-row">
								<div class="col-lg-6 text-lg-right pr-lg-4">
									<h1 class="display-1 mb-0">404</h1>
								</div>
								<div class="col-lg-6 error-page-divider text-lg-left pl-lg-4">
									<h2>LO SENTIMOS!</h2>
									<h3 class="font-weight-light">la factura a la que intentas acceder no existe</h3>
								</div>
							</div>
							<div class="row mt-5">
								<div class="col-12 text-center mt-xl-2">
									<a class="text-white font-weight-medium text-warning" href="<?php echo SERVERURL; ?>home/">
										<== Regresar a Casa</a>
								</div>
							</div>
							<div class="row mt-5">
								<div class="col-12 mt-xl-2">
									<p class="text-white font-weight-medium text-center">Links Mega Red Copyright &copy; 2021 All rights reserved.</p>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- content-wrapper ends -->
			</div>
			<!-- page-body-wrapper ends -->
		</div>
		<?php include "../views/include/Script.php"; ?>
	</body>

	</html>
<?php } ?>