<?php

class vistasModelo
{
    /* MODELO OBTENER VISTAS */
    protected static function obtenerVistasModelo($vistas)
    {
        $listaBlanca = ["home", "usuarios", "user-update", "clientes-activos", "clientes-suspendidos", "facturacion", "trabajos", "editar-trabajo", "trabajos-terminados", "empresa", "nuevo-cliente", "actualizar-cliente"];
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