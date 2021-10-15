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


	require "./fpdf.php";

	$pdf = new FPDF('P', 'mm', 'Letter');
	$pdf->SetMargins(17, 17, 17);
	$pdf->AddPage();
	$pdf->Image('../views/assets/images/logo.png', 10, 10, 30, 30, 'PNG');

	$pdf->SetFont('Arial', 'B', 18);
	$pdf->SetTextColor(0, 107, 181);
	$pdf->Cell(0, 10, utf8_decode(strtoupper("nombre de la empresa")), 0, 0, 'C');
	$pdf->SetFont('Arial', '', 12);
	$pdf->SetTextColor(33, 33, 33);
	$pdf->Cell(-35, 10, utf8_decode('N. de factura'), '', 0, 'C');

	$pdf->Ln(10);

	$pdf->SetFont('Arial', '', 15);
	$pdf->SetTextColor(0, 107, 181);
	$pdf->Cell(0, 10, utf8_decode(""), 0, 0, 'C');
	$pdf->SetFont('Arial', '', 12);
	$pdf->SetTextColor(97, 97, 97);
	$pdf->Cell(-35, 10, utf8_decode("CODIGO DE FACTURA"), '', 0, 'C');

	$pdf->Ln(25);

	$pdf->SetTextColor(33, 33, 33);
	$pdf->Cell(36, 8, utf8_decode('Fecha de emisión:'), 0, 0);
	$pdf->SetTextColor(97, 97, 97);
	$pdf->Cell(27, 8, utf8_decode(date("d/m/Y", strtotime("2020-01-07"))), 0, 0);
	$pdf->Ln(8);
	$pdf->SetTextColor(33, 33, 33);
	$pdf->Cell(27, 8, utf8_decode('Atendido por:'), "", 0, 0);
	$pdf->SetTextColor(97, 97, 97);
	$pdf->Cell(13, 8, utf8_decode("NOMBRE DEL ADMINISTRADOR"), 0, 0);

	$pdf->Ln(15);

	$pdf->SetFont('Arial', '', 12);
	$pdf->SetTextColor(33, 33, 33);
	$pdf->Cell(15, 8, utf8_decode('Cliente:'), 0, 0);
	$pdf->SetTextColor(97, 97, 97);
	$pdf->Cell(65, 8, utf8_decode("NOMBRE DEL CLIENTE"), 0, 0);
	$pdf->SetTextColor(33, 33, 33);
	$pdf->Cell(10, 8, utf8_decode('DNI:'), 0, 0);
	$pdf->SetTextColor(97, 97, 97);
	$pdf->Cell(40, 8, utf8_decode("0000000000"), 0, 0);
	$pdf->SetTextColor(33, 33, 33);
	$pdf->Cell(19, 8, utf8_decode('Teléfono:'), 0, 0);
	$pdf->SetTextColor(97, 97, 97);
	$pdf->Cell(35, 8, utf8_decode("(000)00000000"), 0, 0);
	$pdf->SetTextColor(33, 33, 33);

	$pdf->Ln(8);

	$pdf->Cell(8, 8, utf8_decode('Dir:'), 0, 0);
	$pdf->SetTextColor(97, 97, 97);
	$pdf->Cell(109, 8, utf8_decode("DIRECCION DEL CLIENTE"), 0, 0);

	$pdf->Ln(15);

	$pdf->SetFillColor(38, 198, 208);
	$pdf->SetDrawColor(38, 198, 208);
	$pdf->SetTextColor(33, 33, 33);
	$pdf->SetFont('Arial', '', 10);
	$pdf->Cell(15, 10, utf8_decode('Cant.'), 1, 0, 'C', true);
	$pdf->Cell(90, 10, utf8_decode('Descripción'), 1, 0, 'C', true);
	$pdf->Cell(51, 10, utf8_decode('Tiempo - Costo'), 1, 0, 'C', true);
	$pdf->Cell(25, 10, utf8_decode('Subtotal'), 1, 0, 'C', true);

	$pdf->Ln(10);

	$pdf->SetTextColor(97, 97, 97);


	$pdf->Cell(15, 10, utf8_decode(2000), 'L', 0, 'C');
	$pdf->Cell(90, 10, utf8_decode("00000 - silla plastica blanca"), 'L', 0, 'C');
	$pdf->Cell(51, 10, utf8_decode("7 Evento ($10.00 c/u)"), 'L', 0, 'C');
	$pdf->Cell(25, 10, utf8_decode("$100,000.00"), 'LR', 0, 'C');
	$pdf->Ln(10);
	$pdf->Cell(15, 10, utf8_decode(2000), 'L', 0, 'C');
	$pdf->Cell(90, 10, utf8_decode("00000 - Mesa plastica roja"), 'L', 0, 'C');
	$pdf->Cell(51, 10, utf8_decode("10 Evento ($10.00 c/u)"), 'L', 0, 'C');
	$pdf->Cell(25, 10, utf8_decode("$100,000.00"), 'LR', 0, 'C');

	$pdf->Ln(10);

	$pdf->SetTextColor(33, 33, 33);
	$pdf->Cell(15, 10, utf8_decode(''), 'T', 0, 'C');
	$pdf->Cell(90, 10, utf8_decode(''), 'T', 0, 'C');
	$pdf->Cell(51, 10, utf8_decode('TOTAL'), 'LTB', 0, 'C');
	$pdf->Cell(25, 10, utf8_decode("$100,000.00"), 'LRTB', 0, 'C');

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