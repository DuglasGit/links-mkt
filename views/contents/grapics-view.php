<?php
////////////////////////////////////////////////////////////////////
// ESTE EJEMPLO SE DESCARGO DE www.tech-nico.com ///////////////////
// Creado por: Nicolas Daitsch. Guatrache. La Pampa ////////////////
// Contacto: administracion@tech-nico.com //////////////////////////
// RouterOS API: Grafica en tiempo real usando highcharts //////////
//////////////////////////////////////////////////////////////////// 
?>
<?php require_once('./routerMikrotik/api_mt_include2.php'); ?>
<?php
$ipRouteros = "192.168.0.151";
$Username = "admin";
$Pass = "ProyectosLinks2020";
$api_puerto = 8084;
$interface = "ether9"; //"<pppoe-nombreusuario>";

$API = new routerosAPI();
$API->debug = false;
if ($API->connect($ipRouteros, $Username, $Pass, $api_puerto)) {
	$rows = array();
	$rows2 = array();
	$API->write("/interface/monitor-traffic", false);
	$API->write("=interface=" . $interface, false);
	$API->write("=once=", true);
	$READ = $API->read(false);
	$ARRAY = $API->parseResponse($READ);
	if (count($ARRAY) > 0) {
		$rx = number_format($ARRAY[0]["rx-bits-per-second"] / 1024, 1);
		$tx = number_format($ARRAY[0]["tx-bits-per-second"] / 1024, 1);
		$rows['name'] = 'Tx';
		$rows['datas'][] = $tx;
		$rows2['name'] = 'Rx';
		$rows2['datas'][] = $rx;
	} else {
		echo $ARRAY['!trap'][0]['message'];
	}
} else {
	echo "<font color='#ff0000'>La conexion ha fallado. Verifique si el Api esta activo.</font>";
}
$API->disconnect();

$result = array();

array_push($result, $rows);
array_push($result, $rows2);
print_r($result);
print json_encode($result, JSON_NUMERIC_CHECK);
?>


<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script> 
	var chart;
	function requestDatta(interface) {

		$.ajax({

			datatype: "json",
			success: function(datas) {
				console.log(datas);
				var midatas = JSON.parse(datas);
				console.log('parseado '+midatas);
				if( midatas.length > 0 ) {
					var TX=parseInt(midatas[0].datas);
					var RX=parseInt(midatas[1].datas);
					var x = (new Date()).getTime(); 
					shift=chart.series[0].datas.length > 19;
					chart.series[0].addPoint([x, TX], true, shift);
					chart.series[1].addPoint([x, RX], true, shift);
					document.getElementById("trafico").innerHTML=TX + " / " + RX;
				}else{
					document.getElementById("trafico").innerHTML="- / -";
				}
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) { 
				console.error("Status: " + textStatus + " request: " + XMLHttpRequest); console.error("Error: " + errorThrown); 
			}       
		});
	}	

	$(document).ready(function() {
			Highcharts.setOptions({
				global: {
					useUTC: false
				}
			});
	

           chart = new Highcharts.Chart({
			   chart: {
				renderTo: 'container',
				animation: Highcharts.svg,
				type: 'spline',
				events: {
					load: function () {
						setInterval(function () {
							requestDatta(document.getElementById("interface").value);
						}, 1000);
					}				
			}
		 },
		 title: {
			text: 'Monitoring'
		 },
		 xAxis: {
			type: 'datetime',
				tickPixelInterval: 150,
				maxZoom: 20 * 1000
		 },
		 yAxis: {
			minPadding: 0.2,
				maxPadding: 0.2,
				title: {
					text: 'Trafico',
					margin: 80
				}
		 },
            series: [{
                name: 'TX',
                datas: []
            }, {
                name: 'RX',
                datas: []
            }]
	  });
  });

 
</script>

<?php
echo'
<div id="container" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
	Nombre: <input name="interface" id="interface" type="text" value="ether9" />
    <div id="trafico"></div>
';
?>


<script type="text/javascript" src="<?php echo SERVERURL; ?>/highchart/js/highcharts.js"></script>
<script type="text/javascript" src="<?php echo SERVERURL; ?>/highchart/js/themes/gray.js"></script>

