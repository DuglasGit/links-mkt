<?php

session_start(['name' => 'LMR']);
require_once "../config/APP.php";

if (isset($_POST['busqueda_inicial']) || isset($_POST['eliminar_busqueda']) || isset($_POST['fecha_inicio']) || isset($_POST['fecha_final'])) {

    $data_url = [
        "factura" => "facturacion",
        "factura_cancelada_hoy" => "facturas-canceladas",
        "factura_historial" => "facturas-pagadas-historial",
        "cliente" => "cliente-search",
        "dosinput" => "dosinput-search"
    ];

    if (isset($_POST['modulo'])) {
        $modulo = $_POST['modulo'];

        if (!isset($data_url[$modulo])) {

            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "BUSQUEDA BLOQUEADA",
                "Texto" => "Error de configuración",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }
    } else {
        $alerta = [
            "Alerta" => "simple",
            "Titulo" => "BUSQUEDA BLOQUEADA",
            "Texto" => "Parece que hay datos desconocidos en la búsqueda",
            "Tipo" => "error"
        ];
        echo json_encode($alerta);
        exit();
    }

    if ($modulo == "dosinputfecha") {
        $fecha_inicio = "fecha_inicio_" . $modulo;
        $fecha_final = "fecha_final_" . $modulo;

        // iniciar busqueda
        if (isset($_POST['fecha_inicio']) || isset($_POST['fecha_final'])) {

            if ($_POST['fecha_inicio'] == "" || $_POST['fecha_final'] == "") {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "BUSQUEDA NO INICIADA",
                    "Texto" => "Ingrese fecha inicial y fecha final",
                    "Tipo" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }

            $_SESSION[$fecha_inicio] = $_POST['fecha_inicio'];
            $_SESSION[$fecha_final] = $_POST['fecha_final'];
        }

        //eliminar busqueda
        if (isset($_POST['eliminar_busqueda'])) {

            unset($_SESSION[$fecha_inicio]);
            unset($_SESSION[$fecha_final]);
        }
    } else {
        $name_var = "busqueda_" . $modulo;

        //iniciar busqueda
        if (isset($_POST['busqueda_inicial'])) {
            if ($_POST['busqueda_inicial'] == "") {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "BUSQUEDA NO INICIADA",
                    "Texto" => "Ingrese datos para buscar",
                    "Tipo" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }

            $_SESSION[$name_var] = $_POST['busqueda_inicial'];
        }

        //eliminar busqueda
        if (isset($_POST['eliminar_busqueda'])) {

            unset($_SESSION[$name_var]);
        }
    }

    // redireccionar
    $url = $data_url[$modulo];
    $alerta = [
        "Alerta" => "redireccionar",
        "URL" => SERVERURL . $url . "/"
    ];
    echo json_encode($alerta);
} else {
    session_unset();
    session_destroy();
    header("Location:" . SERVERURL . "login/");
    exit();
}
