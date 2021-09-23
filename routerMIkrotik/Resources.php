<?php
require('routeros_api.class.php');
require_once "./config/SERVER.php";


class RouterR
{
	public static function RouterConnect()
	{
		$API = new RouterosAPI();
		$data = new StdClass();
		$desc = "Desconectado";
		if ($API->connect(IP_ROUTER, USER_ROUTER, PASS_ROUTER)) {
			$API->write('/system/resource/print');

			$READ = $API->read(false);
			$ARRAY = $API->parseResponse($READ);

			$API->write('/ppp/secret/print');

			$READ = $API->read(false);
			$ARRAYC = $API->parseResponse($READ);

			$API->disconnect();
			$data->estado =1;
			$data->tencendido = $ARRAY[0]['uptime'];
			$data->version = $ARRAY[0]['version'];
			$data->ffabrica = $ARRAY[0]['build-time'];
			$data->fsoftware = $ARRAY[0]['factory-software'];
			$data->raml = $ARRAY[0]['free-memory'];
			$data->ramt = $ARRAY[0]['total-memory'];
			$data->cpu = $ARRAY[0]['cpu'];
			$data->ncpu = $ARRAY[0]['cpu-count'];
			$data->fcpu = $ARRAY[0]['cpu-frequency'];
			$data->ccpu = $ARRAY[0]['cpu-load'];
			$data->fhdd = $ARRAY[0]['free-hdd-space'];
			$data->thdd = $ARRAY[0]['total-hdd-space'];
			$data->arch = $ARRAY[0]['architecture-name'];
			$data->bname = $ARRAY[0]['board-name'];
			$data->plataforma = $ARRAY[0]['platform'];
			$data->poe = count($ARRAYC);
		} else {
			$data->estado =0;
			$data->tencendido = $desc;
			$data->version = $desc;
			$data->ffabrica = $desc;
			$data->fsoftware = $desc;
			$data->raml = $desc;;
			$data->ramt = $desc;
			$data->cpu = $desc;
			$data->ncpu = $desc;
			$data->fcpu = $desc;
			$data->ccpu = $desc;
			$data->fhdd = $desc;
			$data->thdd = $desc;
			$data->arch = $desc;
			$data->bname = $desc;
			$data->plataforma = $desc;
			$data->poe = 0;
		}
		return $data;
	}


	// public static function RouterClientes()
	// {
	// 	$API = new RouterosAPI();
	// 	$conteo = 0;
	// 	if ($API->connect(IP_ROUTER, USER_ROUTER, PASS_ROUTER)) {
	// 		$API->write('/ppp/secret/print');

	// 		$READ = $API->read(false);
	// 		$ARRAYC = $API->parseResponse($READ);

	// 		$API->disconnect();
	// 		$conteo = count($ARRAYC);
	// 	} else {
	// 		echo '<script language="javascript">alert("No se ha podido conectar al router");</script>';
	// 	}
	// 	//echo json_encode($ARRAY);
	// 	return $conteo;
	// }

	public static function grap()
	{
		$Port = 8084;


		$Interface = $_GET["interface"]; //"<pppoe-nombreusuario>";
		$Type = $_GET["type_interface"]; //   0=interfaces     1=queues
		$ConnectedFlag = false;
		$API = new routerosAPI();
		$API->debug = false;
		if ($API->connect(IP_ROUTER, USER_ROUTER, PASS_ROUTER, $Port)) {
			$rows = array();
			$rows2 = array();

			if ($Type == 0) {  // Interfaces
				$API->write("/interface/monitor-traffic", false);
				$API->write("=interface=" . $Interface, false);
				$API->write("=once=", true);
				$READ = $API->read(false);
				$ARRAY = $API->parseResponse($READ);
				if (count($ARRAY) > 0) {
					$rx = ($ARRAY[0]["rx-bits-per-second"]);
					$tx = ($ARRAY[0]["tx-bits-per-second"]);
					$rows['name'] = 'Tx';
					$rows['data'][] = $tx;
					$rows2['name'] = 'Rx';
					$rows2['data'][] = $rx;
				} else {
					echo $ARRAY['!trap'][0]['message'];
				}
			} else if ($Type == 1) { //  Queues
				$API->write("/queue/simple/print", false);
				$API->write("=stats", false);
				$API->write("?name=" . $Interface, true);
				$READ = $API->read(false);
				$ARRAY = $API->parseResponse($READ);
				//print_r($ARRAY[0]);
				if (count($ARRAY) > 0) {
					$rx = explode("/", $ARRAY[0]["rate"])[0];
					$tx = explode("/", $ARRAY[0]["rate"])[1];
					$rows['name'] = 'Tx';
					$rows['data'][] = $tx;
					$rows2['name'] = 'Rx';
					$rows2['data'][] = $rx;
				} else {
					echo $ARRAY['!trap'][0]['message'];
				}
			}


			$ConnectedFlag = true;
		} else {
			echo "<font color='#ff0000'>La conexion ha fallado. Verifique si el Api esta activo.</font>";
		}

		if ($ConnectedFlag) {
			$result = array();
			array_push($result, $rows);
			array_push($result, $rows2);
			print json_encode($result, JSON_NUMERIC_CHECK);
		}
		$API->disconnect();
	}
}
