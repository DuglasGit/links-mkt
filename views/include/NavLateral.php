<nav class="sidebar sidebar-offcanvas d-pri" id="sidebar">
    <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top d-pri">
        <a class="sidebar-brand brand-logo"><img src="<?php echo SERVERURL; ?>views/assets/images/logo-links-l.svg" alt="logo" /></a>
        <a class="sidebar-brand brand-logo-mini"><img src="<?php echo SERVERURL; ?>views/assets/images/logo-links-s.svg" alt="logo" /></a>
    </div>
    <ul class="nav">
        <li class="nav-item profile">
            <div class="profile-desc">
                <div class="profile-pic">
                    <div class="count-indicator">
                        <img class="img-xs rounded-circle" src="<?php echo SERVERURL; ?>views/assets/images/faces/face15.jpg" alt="">
                        <span class="count bg-success"></span>
                    </div>
                    <div class="profile-name">
                        <h5 class="mb-0 font-weight-normal"><?php echo $_SESSION['usuario_lmr']; ?></h5>
                        <span><?php echo $_SESSION['rol_lmr']; ?></span>
                    </div>
                </div>
                <?php if ($_SESSION['id_rol_lmr'] == 1) { ?>
                    <a href="#" id="profile-dropdown" data-toggle="dropdown">
                        <i class="mdi mdi-dots-vertical"></i>
                    </a>
                <?php } ?>
                <div class="dropdown-menu dropdown-menu-right sidebar-dropdown preview-list" aria-labelledby="profile-dropdown">
                    <a href="#" class="dropdown-item preview-item" data-toggle="modal" data-target="#modalEditarUsuario">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-dark rounded-circle">
                                <i class="mdi mdi-account-settings text-primary"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <p class="preview-subject ellipsis mb-1 text-small">Ajustes de cuenta</p>
                        </div>
                    </a>
                </div>
            </div>
        </li>
        <li class="nav-item nav-category">
            <span class="nav-link text-secondary">MENÚ DE OPCIONES</span>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" href="<?php echo SERVERURL; ?>home/">
                <span class="menu-icon">
                    <i class="mdi mdi-home-outline text-primary"></i>
                </span>
                <span class="menu-title text-primary">Home</span>
            </a>
        </li>
        <?php if ($_SESSION['id_rol_lmr'] == 1) { ?>
            <li class="nav-item menu-items">
                <a class="nav-link" href="<?php echo SERVERURL; ?>usuarios/">
                    <span class="menu-icon">
                        <i class="mdi mdi-shopping text-warning"></i>
                    </span>
                    <span class="menu-title text-warning">Usuarios</span>

                </a>
            </li>
        <?php } ?>
        <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#ui-clientes" aria-expanded="false" aria-controls="ui-clientes">
                <span class="menu-icon">
                    <i class="mdi mdi-account-multiple-outline text-danger"></i>
                </span>
                <span class="menu-title text-danger">Clientes PPPoE</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-clientes">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="<?php echo SERVERURL; ?>clientes-activos/">Clientes Activos</a></li>
                    <li class="nav-item"> <a class="nav-link" href="<?php echo SERVERURL; ?>clientes-suspendidos/">Clientes Suspendidos</a></li>
                </ul>
            </div>
        </li>


        <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#ui-facturas" aria-expanded="false" aria-controls="ui-facturas">
                <span class="menu-icon">
                    <i class="mdi mdi-shopping text-light"></i>
                </span>
                <span class="menu-title text-light">Facturación</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-facturas">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="<?php echo SERVERURL; ?>facturacion/">Facturas Pendientes</a></li>
                    <li class="nav-item"> <a class="nav-link" href="<?php echo SERVERURL; ?>facturas-canceladas/">Facturas Canceladas</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#ui-trabajos" aria-expanded="false" aria-controls="ui-trabajos">
                <span class="menu-icon">
                    <i class="mdi mdi-account-multiple-outline text-success"></i>
                </span>
                <span class="menu-title text-success">Gestionar Trabajos</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-trabajos">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="<?php echo SERVERURL; ?>trabajos/">Asignar Trabajos </a></li>
                    <li class="nav-item"> <a class="nav-link" href="<?php echo SERVERURL; ?>trabajos-terminados/">Trabajos Terminados</a></li>
                </ul>
            </div>
        </li>
        <?php if ($_SESSION['id_rol_lmr'] == 1) { ?>
            <li class="nav-item menu-items">
                <a class="nav-link" href="<?php echo SERVERURL; ?>empresa/">
                    <span class="menu-icon">
                        <i class="mdi mdi-certificate"></i>
                    </span>
                    <span class="menu-title text-info">Empresa y Router</span>
                </a>
            </li>
        <?php } ?>

    </ul>
</nav>