<?php
/////// CONEXIÓN A LA BASE DE DATOS /////////
$host = 'localhost';
$basededatos = 'links_db';
$usuario = 'root';
$contraseña = '';

$conexion = new mysqli($host, $usuario,$contraseña, $basededatos);
if (!$conexion) {
    /* Use your preferred error logging method here */
    error_log('Connection error: ' . mysqli_connect_error());
}

//////////////// VALORES INICIALES ///////////////////////

$tabla="";
$query="SELECT factura.idfactura, factura.id_cliente, cliente.nombre_cliente, factura.fecha, factura.id_estado_pago, producto_servicio.nombre_producto_servicio, detalle_factura.precio, detalle_factura.mes_pagado FROM factura JOIN cliente ON (factura.id_cliente=cliente.id_cliente) JOIN detalle_factura ON (factura.idfactura=detalle_factura.id_factura) JOIN producto_servicio ON (detalle_factura.id_producto_servicio=producto_servicio.id_producto_servicio) WHERE factura.id_estado_pago=2 ORDER BY factura.fecha";

///////// LO QUE OCURRE AL TECLEAR SOBRE EL INPUT DE BUSQUEDA ////////////
if(isset($_POST['myInput']))
{
	$q=$conexion->real_escape_string($_POST['myInput']);
	$query="SELECT factura.idfactura, factura.id_cliente, cliente.nombre_cliente, factura.fecha, factura.id_estado_pago, producto_servicio.nombre_producto_servicio, detalle_factura.precio, detalle_factura.mes_pagado FROM factura JOIN cliente ON (factura.id_cliente=cliente.id_cliente) JOIN detalle_factura ON (factura.idfactura=detalle_factura.id_factura) JOIN producto_servicio ON (detalle_factura.id_producto_servicio=producto_servicio.id_producto_servicio) WHERE factura.id_estado_pago=2 AND cliente.nombre_cliente LIKE '%".$q."%'";
}

$buscarFactura=$conexion->query($query);
if ($buscarFactura->num_rows > 0)
{
	$tabla.= 
	'<table class="table">
		<tr class="bg-primary">
			<td>ID</td>
			<td>CLIENTE</td>
			<td>FECHA</td>
			<td>MES</td>
			<td>TOTAL</td>
			<td>ESTADO</td>
		</tr>';

	while($filaFactura= $buscarFactura->fetch_assoc())
	{
		$tabla.=
		'<tr>
			<td>'.$filaFactura['idfactura'].'</td>
			<td>'.$filaFactura['nombre_cliente'].'</td>
			<td>'.$filaFactura['fecha'].'</td>
			<td>'.$filaFactura['mes_pagado'].'</td>
			<td>'.$filaFactura['precio'].'</td>
			<td>'.$filaFactura['id_estado_pago'].'</td>
		 </tr>
		';
	}

	$tabla.='</table>';
} else
	{
		$tabla="No se encontraron coincidencias con sus criterios de búsqueda.";
	}


echo $tabla;
?>
