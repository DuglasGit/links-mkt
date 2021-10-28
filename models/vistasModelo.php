<?php

class vistasModelo
{
    /* MODELO OBTENER VISTAS */
    protected static function obtenerVistasModelo($vistas)
    {
        $listaBlanca = ["home", "usuarios", "user-update", "clientes-activos", "clientes-suspendidos", "facturacion", "factura-search", "facturas-canceladas", "facturas-pagadas-historial", "editar-factura", "editar-factura-cancelada", "editar-factura-cancelada-historial", "trabajos", "editar-trabajo", "trabajos-terminados", "empresa", "nuevo-cliente", "actualizar-cliente", "nuevo-pppoe", "actualizar-pppoe", "pppoe-registrados", "pppoe-activos", "pppoe-suspendidos"];
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
