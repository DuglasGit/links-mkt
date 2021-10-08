<?php
session_start(['name' => 'LMR']);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo COMPANY; ?></title>
    <!-- plugins:css -->
    <?php
    include "./views/include/Link.php";
    include "./views/contents/modales-view.php";
    ?>
</head>

<body>
    <?php
    $peticionAjax = false;
    require_once "./controllers/vistasControlador.php";
    $IV = new vistasControlador();

    $vistas = $IV->obtenerVistasControlador();

    if ($vistas == "login" || $vistas == "404") {
        require_once "./views/contents/" . $vistas . "-view.php";
    } else {

        $pagina=explode("/", $_GET['views']);

        require_once "./controllers/loginControlador.php";
        $login_controlador = new loginControlador();

        if (!isset($_SESSION['token_lmr']) || !isset($_SESSION['usuario_lmr']) || !isset($_SESSION['rol_lmr']) || !isset($_SESSION['id_lmr'])) {
            $login_controlador->forzar_cierre_sesion_controlador();
            exit();
        }


    ?>


        <div class="container-scroller">
            <!-- partial:../../partials/_sidebar.html -->
            <?php
            include "./views/include/NavLateral.php";
            ?>

            <!-- partial -->
            <div class="container-fluid page-body-wrapper">
                <!-- partial:../../partials/_navbar.html -->
                <?php
                include "./views/include/NavBar.php";
                ?>
                <!-- partial -->
                <div class="main-panel">
                    <div class="content-wrapper d-cwr">
                        <?php include $vistas; ?>
                    </div>
                    
                </div>
                <!-- main-panel ends -->
            </div>
            <!-- page-body-wrapper ends -->
        </div>
        <!-- container-scroller -->
        <!-- plugins:js -->
    <?php
        include "./views/include/LogOut.php";
    }
    include "./views/include/Script.php";

    ?>
    <!-- Custom js for this page -->
    <!-- End custom js for this page -->
</body>

</html>