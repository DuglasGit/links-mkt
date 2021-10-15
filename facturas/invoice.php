<?php

$peticionAjax = true;
require_once "../config/APP.php";

$id = (isset($_GET['id'])) ? $_GET['id'] : 0;

//Instancia al controlador Factura
require_once "../controllers/facturaControlador.php";
$ins_factura = new facturaControlador();

$datos_factura = $ins_factura->datosFacturaControlador("Unico", $id);

if ($datos_factura->rowCount() == 1) {

	$datos_factura = $datos_factura->fetch();

	//Instancia al controlador Empresa
	require_once "../controllers/empresaControlador.php";
	$ins_empresa = new empresaControlador();

	$datos_empresa = $ins_empresa->datosEmpresaControlador();
	$datos_empresa=$datos_empresa->fetch();

	//Obtener datos del usuario que imprime la factura
	$datos_usuario = $ins_factura->datosUsuarioFacturaControlador($id);
	$datos_usuario=$datos_usuario->fetch();


	//Instancia al controlador Cliente de la factura
	require_once "../controllers/clienteControlador.php";
	$ins_cliente = new clienteControlador();

	$datos_cliente = $ins_cliente->datosClienteFacturaControlador($id);
	$datos_cliente=$datos_cliente->fetch();

	require "./fpdf.php";

	$pdf = new FPDF('P', 'mm', 'Letter');
	$pdf->SetMargins(17, 17, 17);
	$pdf->AddPage();
	$pdf->Image('../views/assets/images/logo.png', 10, 10, 30, 30, 'PNG');

	$pdf->SetFont('Arial', 'B', 18);
	$pdf->SetTextColor(0, 107, 181);
	$pdf->Cell(0, 10, utf8_decode(strtoupper($datos_empresa['nombre_empresa'])), 0, 0, 'C');
	$pdf->SetFont('Arial', '', 12);
	$pdf->SetTextColor(33, 33, 33);
	$pdf->Cell(-35, 10, utf8_decode('N. de factura'), '', 0, 'C');

	$pdf->Ln(10);

	$pdf->SetFont('Arial', '', 15);
	$pdf->SetTextColor(0, 107, 181);
	$pdf->Cell(0, 10, utf8_decode(""), 0, 0, 'C');
	$pdf->SetFont('Arial', '', 12);
	$pdf->SetTextColor(97, 97, 97);
	$pdf->Cell(-35, 10, utf8_decode($datos_factura['idfactura']), '', 0, 'C');

	$pdf->Ln(25);

	$pdf->SetTextColor(33, 33, 33);
	$pdf->Cell(36, 8, utf8_decode('Fecha de emisión:'), 0, 0);
	$pdf->SetTextColor(97, 97, 97);
	$pdf->Cell(27, 8, utf8_decode(date("d/m/Y", strtotime($datos_factura['fecha']))), 0, 0);
	$pdf->Ln(8);
	$pdf->SetTextColor(33, 33, 33);
	$pdf->Cell(27, 8, utf8_decode('Atendido por:'), "", 0, 0);
	$pdf->SetTextColor(97, 97, 97);
	$pdf->Cell(13, 8, utf8_decode($datos_usuario['nombre_usuario']), 0, 0);

	$pdf->Ln(15);

	$pdf->SetFont('Arial', '', 12);
	$pdf->SetTextColor(33, 33, 33);
	$pdf->Cell(15, 8, utf8_decode('Cliente:'), 0, 0);
	$pdf->SetTextColor(97, 97, 97);
	$pdf->Cell(69, 8, utf8_decode($datos_factura['nombre_cliente']), 0, 0);
	$pdf->SetTextColor(33, 33, 33);
	$pdf->Cell(25, 8, utf8_decode('TELÉFONO:'), 0, 0);
	$pdf->SetTextColor(97, 97, 97);
	$pdf->Cell(40, 8, utf8_decode($datos_factura['telefono_cliente']), 0, 0);

	$pdf->Ln(8);

	$pdf->SetTextColor(33, 33, 33);
	$pdf->Cell(20, 8, utf8_decode('Municipio:'), 0, 0);
	$pdf->SetTextColor(97, 97, 97);
	$pdf->Cell(65, 8, utf8_decode($datos_factura['nombre_municipio']), 0, 0);
	$pdf->SetTextColor(33, 33, 33);

	$pdf->Cell(20, 8, utf8_decode('Domicilio:'), 0, 0);
	$pdf->SetTextColor(97, 97, 97);
	$pdf->Cell(76, 8, utf8_decode($datos_factura['domicilio']), 0, 0);
	

	$pdf->Ln(15);

	$pdf->SetFillColor(38, 198, 208);
	$pdf->SetDrawColor(38, 198, 208);
	$pdf->SetTextColor(33, 33, 33);
	$pdf->SetFont('Arial', '', 10);
	$pdf->Cell(15, 10, utf8_decode('Cant.'), 1, 0, 'C', true);
	$pdf->Cell(90, 10, utf8_decode('Descripción'), 1, 0, 'C', true);
	$pdf->Cell(51, 10, utf8_decode('precio Unitario'), 1, 0, 'C', true);
	$pdf->Cell(25, 10, utf8_decode('Subtotal'), 1, 0, 'C', true);

	$pdf->Ln(10);

	$pdf->SetTextColor(97, 97, 97);

	//detalles de la factura
	$id_cliente=$datos_cliente['id_cliente'];
	$datos_detalle_factura = $ins_factura->datosDetalleFacturaControlador($id);
	$datos_detalle_factura=$datos_detalle_factura->fetch();

	$pdf->Cell(15, 10, utf8_decode($datos_factura['cantidad']), 'L', 0, 'C');
	$pdf->Cell(90, 10, utf8_decode($datos_factura['id_producto_servicio']." - ".$datos_factura['nombre_producto_servicio']." - ".$datos_factura['mes_pagado']), 'L', 0, 'C');
	$pdf->Cell(51, 10, utf8_decode(MONEDA.$datos_factura['precio']), 'L', 0, 'C');
	$pdf->Cell(25, 10, utf8_decode(MONEDA.$datos_factura['precio']), 'LR', 0, 'C');
	// $pdf->Ln(10);
	// $pdf->Cell(15, 10, utf8_decode(2000), 'L', 0, 'C');
	// $pdf->Cell(90, 10, utf8_decode("00000 - Mesa plastica roja"), 'L', 0, 'C');
	// $pdf->Cell(51, 10, utf8_decode("10 Evento ($10.00 c/u)"), 'L', 0, 'C');
	// $pdf->Cell(25, 10, utf8_decode("$100,000.00"), 'LR', 0, 'C');

	$pdf->Ln(10);

	$pdf->SetTextColor(33, 33, 33);
	$pdf->Cell(15, 10, utf8_decode(''), 'T', 0, 'C');
	$pdf->Cell(90, 10, utf8_decode(''), 'T', 0, 'C');
	$pdf->Cell(51, 10, utf8_decode('TOTAL'), 'LTB', 0, 'C');
	$pdf->Cell(25, 10, utf8_decode(MONEDA.$datos_factura['precio']), 'LRTB', 0, 'C');

	$pdf->Ln(15);

	$pdf->MultiCell(0, 9, utf8_decode("OBSERVACIÓN: "), 0, 'J', false);

	$pdf->SetFont('Arial', '', 12);
	if (true) {
		$pdf->Ln(12);

		$pdf->SetTextColor(97, 97, 97);
		$pdf->MultiCell(0, 9, utf8_decode("NOTA IMPORTANTE: \nEsta factura presenta un saldo pendiente de pago por la cantidad de $.00"), 0, 'J', false);
	}

	$pdf->Ln(25);

	/*----------  INFO. EMPRESA  ----------*/
	$pdf->SetFont('Arial', 'B', 9);
	$pdf->SetTextColor(33, 33, 33);
	$pdf->Cell(0, 6, utf8_decode("NOMBRE DE LA EMPRESA"), 0, 0, 'C');
	$pdf->Ln(6);
	$pdf->SetFont('Arial', '', 9);
	$pdf->Cell(0, 6, utf8_decode("DIRECCION DE LA EMPRESA"), 0, 0, 'C');
	$pdf->Ln(6);
	$pdf->Cell(0, 6, utf8_decode("Teléfono: "), 0, 0, 'C');
	$pdf->Ln(6);
	$pdf->Cell(0, 6, utf8_decode("Correo: "), 0, 0, 'C');


	$pdf->Output("I", "Factura_1.pdf", true);
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