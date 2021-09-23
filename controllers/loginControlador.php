<?php

if ($peticionAjax) {
    require_once "../models/loginModelo.php";
} else {
    require_once "./models/loginModelo.php";
}

class loginControlador extends loginModelo
{
    /* -- COntrolador Iniciar Sesion -- */
    public function iniciar_sesion_controlador()
    {
        $usuario = mainModel::limpiar_cadena($_POST['usuario_log']);
        $clave = mainModel::limpiar_cadena($_POST['passwd_log']);

        /* -- Comprobar campos vacíos -- */
        if ($usuario == "" || $clave == "") {
            echo '
                <script>
                    Swal.fire({
                        title: "Ocurrió un error inesperado",
                        text: "No ha llenado todos los campos obligatorios",
                        icon: "error",
                        confirmButtonText: "Aceptar"
                    });
                </script>
                ';
            exit();
        }

        /*== Verificando integridad de los datos ==*/
        // if (mainModel::verificar_datos("^((25[0-5]|2[0-4]\d|[01]?\d\d?)\.){3}(25[0-5]|2[0-4]\d|[01]?\d\d?)$", $ip)) {
        //     echo '
        //     <script>
        //         Swal.fire({
        //             title: "Ocurrió un error inesperado",
        //             text: "La Dirección IP V4 no tiene un formato válido",
        //             icon: "error",
        //             confirmButtonText: "Aceptar"
        //         });
        //     </script>
        //     ';
        // }

        // if (mainModel::verificar_datos("(^[0-9]{4})$", $puerto)) {
        //     echo '
        //     <script>
        //         Swal.fire({
        //             title: "Ocurrió un error inesperado",
        //             text: "El puero de conexión ingresado no tiene un formato válido",
        //             icon: "error",
        //             confirmButtonText: "Aceptar"
        //         });
        //     </script>
        //     ';
        // }

        if (mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,100}", $usuario)) {
            echo '
                <script>
                    Swal.fire({
                        title: "Ocurrió un error inesperado",
                        text: "El nombre de usuario no coincide con el formato solicitado",
                        icon: "error",
                        confirmButtonText: "Aceptar"
                    });
                </script>
                ';
            exit();
        }

        if (mainModel::verificar_datos("[a-zA-Z0-9$@.-]{7,25}", $clave)) {
            echo '
                <script>
                    Swal.fire({
                        title: "Ocurrió un error inesperado",
                        text: "LA CLAVE no coincide con el formato solicitado",
                        icon: "error",
                        confirmButtonText: "Aceptar"
                    });
                </script>
                ';
            exit();
        }

        $clave = mainModel::encryption($clave);

        $datos_login = [
            "Usuario" => $usuario,
            "Clave" => $clave
        ];

        $datos_cuenta = loginModelo::iniciar_sesion_modelo($datos_login);

        if ($datos_cuenta->rowCount() == 1) {
            $row = $datos_cuenta->fetch();
            //echo($datos_cuenta);
            session_start(['name' => 'LMR']);

            $_SESSION['id_lmr'] = $row['id_usuario'];
            $_SESSION['usuario_lmr'] = $row['nombre_usuario'];
            $_SESSION['rol_lmr'] = $row['nombre_rol'];
            $_SESSION['id_rol_lmr'] = $row['id_rol'];
            $_SESSION['token_lmr'] = md5(uniqid(mt_rand(), true));

            //return header("Location: ".SERVERURL."home/");
            //echo($_SESSION['usuario_lmr']);
            //echo "<script> window.location.href='" . SERVERURL . "home/'; </script>";

            if (headers_sent()) {
                echo "<script> window.location.href='" . SERVERURL . "home/'; </script>";
            } else {
                return header("Location: " . SERVERURL . "home/");
            }
        } else {
            echo '
                <script>
                    Swal.fire({
                        title: "Ocurrió un error inesperado",
                        text: "Las credenciales son erróneas o no existen en el sistema",
                        icon: "error",
                        confirmButtonText: "Aceptar"
                    });
                </script>
                ';
        }
    } //fin del controlador

    // COntrolador para forzar el cierre de sesión

    public function forzar_cierre_sesion_controlador()
    {
        session_unset();
        session_destroy();

        if (headers_sent()) {
            echo "<script> window.location.href='" . SERVERURL . "login/'; </script>";
        } else {
            return header("Location: " . SERVERURL . "login/");
        }
    } //fin del controlador


    // COntrolador para cierre de sesión

    public function cerrar_sesion_controlador()
    {
        session_start(['name' => 'LMR']);

        $token = mainModel::decryption($_POST['token']);
        $usuario = mainModel::decryption($_POST['usuario']);

        if ($token == $_SESSION['token_lmr'] && $usuario == $_SESSION['usuario_lmr']) {
            session_unset();
            session_destroy();
            $alerta = [
                "Alerta" => "redireccionar",
                "URL" => SERVERURL . "login/"
            ];
        } else {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "No se pudo cerrar la sesión en el sistema",
                "Tipo" => "error"
            ];
        }
        echo json_encode($alerta);
    } //fin del controlador
}

?>