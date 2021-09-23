<?php

require_once "./models/vistasModelo.php";

class vistasControlador extends vistasModelo{
    /* CONTROLADOR OBTENER PLANTILLA */
    public function obtenerPlantillaControlador()
    {
        return require_once "./views/plantilla.php";
    }

    /* CONTROLADOR OBTENER VISTAS */
    public function obtenerVistasControlador()
    {
        if(isset($_GET['views'])){
            $ruta=explode("/",$_GET['views']);
            $respuesta=vistasModelo::obtenerVistasModelo($ruta[0]);
        }else{
            $respuesta="login";

        }
        return $respuesta;
    }
}

?>