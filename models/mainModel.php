<?php

if ($peticionAjax) {
	require_once "../config/SERVER.php";
} else {
	require_once "./config/SERVER.php";
}

class mainModel
{

	/*--------- Funcion conectar a BD ---------*/
	protected static function conectar()
	{
		$conexion = new PDO(SGBD, USER, PASS);
		$conexion->exec("SET CHARACTER SET utf8");
		return $conexion;
	}


	/*--------- Funcion ejecutar consultas simples ---------*/
	protected static function ejecutar_consulta_simple($consulta)
	{
		$sql = self::conectar()->prepare($consulta);
		$sql->execute();
		return $sql;
	}


	/*--------- Encriptar cadenas ---------*/
	public function encryption($string)
	{
		$output = FALSE;
		$key = hash('sha256', SECRET_KEY);
		$iv = substr(hash('sha256', SECRET_IV), 0, 16);
		$output = openssl_encrypt($string, METHOD, $key, 0, $iv);
		$output = base64_encode($output);
		return $output;
	}


	/*--------- Desencriptar cadenas ---------*/
	protected static function decryption($string)
	{
		$key = hash('sha256', SECRET_KEY);
		$iv = substr(hash('sha256', SECRET_IV), 0, 16);
		$output = openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
		return $output;
	}


	/*--------- Funcion generar codigos aleatorios ---------*/
	protected static function generar_codigo_aleatorio($letra, $longitud, $numero)
	{
		for ($i = 1; $i <= $longitud; $i++) {
			$aleatorio = rand(0, 9);
			$letra .= $aleatorio;
		}
		return $letra . "-" . $numero;
	}


	/*--------- Funcion limpiar cadenas ---------*/
	protected static function limpiar_cadena($cadena)
	{
		$cadena = trim($cadena);
		$cadena = stripslashes($cadena);
		$cadena = str_ireplace("<script>", "", $cadena);
		$cadena = str_ireplace("</script>", "", $cadena);
		$cadena = str_ireplace("<script src", "", $cadena);
		$cadena = str_ireplace("<script type=", "", $cadena);
		$cadena = str_ireplace("SELECT * FROM", "", $cadena);
		$cadena = str_ireplace("DELETE FROM", "", $cadena);
		$cadena = str_ireplace("INSERT INTO", "", $cadena);
		$cadena = str_ireplace("DROP TABLE", "", $cadena);
		$cadena = str_ireplace("DROP DATABASE", "", $cadena);
		$cadena = str_ireplace("TRUNCATE TABLE", "", $cadena);
		$cadena = str_ireplace("SHOW TABLES", "", $cadena);
		$cadena = str_ireplace("SHOW DATABASES", "", $cadena);
		$cadena = str_ireplace("<?php", "", $cadena);
		$cadena = str_ireplace("?>", "", $cadena);
		$cadena = str_ireplace("--", "", $cadena);
		$cadena = str_ireplace(">", "", $cadena);
		$cadena = str_ireplace("<", "", $cadena);
		$cadena = str_ireplace("[", "", $cadena);
		$cadena = str_ireplace("]", "", $cadena);
		$cadena = str_ireplace("^", "", $cadena);
		$cadena = str_ireplace("==", "", $cadena);
		$cadena = str_ireplace(";", "", $cadena);
		$cadena = str_ireplace("::", "", $cadena);
		$cadena = stripslashes($cadena);
		$cadena = trim($cadena);
		return $cadena;
	}

		/*--------- Funcion limpiar cadenas ---------*/
		protected static function formatearNombreServicio($cadena)
		{
			$cadena = trim($cadena);
			$cadena = strtolower($cadena);
			$cadena = str_replace("Á","a", $cadena);
			$cadena = str_replace("É","e", $cadena);
			$cadena = str_replace("Í","i", $cadena);
			$cadena = str_replace("Ó","o", $cadena);
			$cadena = str_replace("Ú","u", $cadena);
			$cadena = str_replace("á","a", $cadena);
			$cadena = str_replace("é","e", $cadena);
			$cadena = str_replace("í","i", $cadena);
			$cadena = str_replace("ó","o", $cadena);
			$cadena = str_replace("ú","u", $cadena);
			$cadena = str_replace(" ","_", $cadena);
			$cadena = str_replace(".","", $cadena);
			$cadena = str_replace(",","", $cadena);
			$cadena = str_replace(":","", $cadena);
			$cadena = trim($cadena);
			return $cadena;
		}


	/*--------- Funcion verificar datos ---------*/
	protected static function verificar_datos($filtro, $cadena)
	{
		if (preg_match("/^" . $filtro . "$/", $cadena)) {
			return false;
		} else {
			return true;
		}
	}


	/*--------- Funcion verificar fechas ---------*/
	protected static function verificar_fecha($fecha)
	{
		$valores = explode('-', $fecha);
		if (count($valores) == 3 && checkdate($valores[1], $valores[2], $valores[0])) {
			return false;
		} else {
			return true;
		}
	}



	/*--------- Funcion paginador de tablas ---------*/
	protected static function paginador_tablas($pagina, $Npaginas, $url, $botones)
	{
		$tabla = '
		<div class="row col-md-12 justify-content-center">
			<nav aria-label="Page navigation">
				<ul class="pagination justify-content-center">';

					if ($pagina == 1) {
						$tabla .= '<li class="page-inverse-item disabled"><a class="nav-link"><i class="mdi mdi-page-first"></i></a></li>';
					} else {
						$tabla .= '
							<li class="page-item"><a class="nav-link" href="' . $url . '1/"><i class="mdi mdi-page-first text-light"></i></a></li>
							<li class="page-item"><a class="nav-link" href="' . $url . ($pagina - 1) . '/">Anterior</a></li>
							';
					}


					$ci = 0;
					for ($i = $pagina; $i <= $Npaginas; $i++) {
						if ($ci >= $botones) {
							break;
						}

						if ($pagina == $i) {
							$tabla .= '<li class="page-item"><a class="nav-link text-warning active" href="' . $url . $i . '/">' . $i . '</a></li>';
						} else {
							$tabla .= '<li class="page-item"><a class="nav-link" href="' . $url . $i . '/">' . $i . '</a></li>';
						}

						$ci++;
					}


					if ($pagina == $Npaginas) {
						$tabla .= '<li class="page-item disabled"><a class="nav-link"><i class="mdi mdi-page-last"></i></a></li>';
					} else {
						$tabla .= '
							<li class="page-item"><a class="nav-link" href="' . $url . ($pagina + 1) . '/">Siguiente</a></li>
							<li class="page-item"><a class="nav-link" href="' . $url . $Npaginas . '/"><i class="mdi mdi-page-last text-secondary"></i></a></li>
							';
					}

					$tabla .= '
				</ul>
			</nav>
		</div>';
		return $tabla;
	}
}
