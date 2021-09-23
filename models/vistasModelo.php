<?php

class vistasModelo
{
    /* MODELO OBTENER VISTAS */
    protected static function obtenerVistasModelo($vistas)
    {
        $listaBlanca = ["home", "usuarios", "usuarios-edit", "clientes-activos", "clientes-inactivos", "clientes-suspendidos", "contratos", "facturacion", "equipos", "empresa", "grapics"];
        if (in_array($vistas, $listaBlanca)) {
            if (is_file("./views/contents/" . $vistas . "-view.php")) {
                $contenido = "./views/contents/" . $vistas . "-view.php";
            } else {
                $contenido = "404";
            }
        } elseif ($vistas == "login" || $vistas == "index") {
            $contenido = "login";
        } else {
            $contenido = "404";
        }
        return $contenido;
    }
}

?>