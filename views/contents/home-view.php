<?php
require_once "./routerMIkrotik/Resources.php";
$data = RouterR::RouterConnect();

?>

<?php
if ($data->estado == 0) {
    echo
    '
<div clas="row">
<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>ATENCIÓN!</strong> No se ha podio establecer comunicación con el Router Mikrotik
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
</div>
';
}
?>

    <div class="row">
        <div class="col-lg-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="chartjs-size-monitor">
                        <div class="chartjs-size-monitor-expand">
                            <div class=""></div>
                        </div>
                        <div class="chartjs-size-monitor-shrink">
                            <div class=""></div>
                        </div>
                    </div>
                    <h4 class="card-title">Trafico de Red</h4>
                    <canvas id="areaChart" style="height: 289px; display: block; width: 578px;" width="578" height="289" class="chartjs-render-monitor"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="chartjs-size-monitor">
                        <div class="chartjs-size-monitor-expand">
                            <div class=""></div>
                        </div>
                        <div class="chartjs-size-monitor-shrink">
                            <div class=""></div>
                        </div>
                    </div>
                    <h4 class="card-title">Estado de Clientes</h4>
                    <canvas id="doughnutChart" style="height: 230px; display: block; width: 461px;" width="461" height="230" class="chartjs-render-monitor"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="chartjs-size-monitor">
                        <div class="chartjs-size-monitor-expand">
                            <div class=""></div>
                        </div>
                        <div class="chartjs-size-monitor-shrink">
                            <div class=""></div>
                        </div>
                    </div>
                    <h4 class="card-title">Trafico de Red</h4>
                    <canvas id="barChart" style="height: 289px; display: block; width: 578px;" width="578" height="289" class="chartjs-render-monitor"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-2 grid-margin stretch-card">
            <div class="card">
                <div class="card-body d-card d-card">
                    <h6 class="d-lbl">Tmp. encendido</h6>
                    <div class="media">
                        <i class="mdi mdi-timer icon-sm text-danger d-flex align-self-start mr-2"></i>
                        <div class="media-body">
                            <h6 class="d-lbl"><?php echo $data->tencendido; ?></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2 grid-margin stretch-card">
            <div class="card">
                <div class="card-body d-card">
                    <h6 class="d-lbl">Version del SO</h6>
                    <div class="media">
                        <i class="mdi mdi-information-outline icon-sm text-warning d-flex align-self-start mr-3"></i>
                        <div class="media-body">
                            <h6 class="d-lbl"><?php echo $data->version; ?></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2 grid-margin stretch-card">
            <div class="card">
                <div class="card-body d-card">
                    <h6 class="d-lbl">RAM Libre</h6>
                    <div class="media">
                        <i class="mdi mdi-cpu-64-bit icon-sm text-danger d-flex align-self-start mr-3"></i>
                        <div class="media-body">
                            <h6 class="d-lbl">
                                <?php
                                if ($data->raml == "Desconectado") {
                                    echo $data->raml;
                                } else {

                                    echo round((($data->raml / 1024) / 1024), 2, PHP_ROUND_HALF_DOWN), " MB";
                                } ?>
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2 grid-margin stretch-card">
            <div class="card">
                <div class="card-body d-card">
                    <h6 class="d-lbl">RAM Total</h6>
                    <div class="media">
                        <i class="mdi mdi-memory icon-sm text-warning d-flex align-self-start mr-3"></i>
                        <div class="media-body">
                            <h6 class="d-lbl">
                                <?php
                                if ($data->ramt == "Desconectado") {
                                    echo $data->ramt;
                                } else {
                                    echo round((($data->ramt / 1024) / 1024), 2, PHP_ROUND_HALF_DOWN), " MB";
                                } ?>
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2 grid-margin stretch-card">
            <div class="card">
                <div class="card-body d-card">
                    <h6 class="d-lbl">CPU</h6>
                    <div class="media">
                        <i class="mdi mdi-chip icon-sm text-primary d-flex align-self-start mr-3"></i>
                        <div class="media-body">
                            <h6 class="d-lbl"><?php echo $data->cpu; ?></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2 grid-margin stretch-card">
            <div class="card">
                <div class="card-body d-card">
                    <h6 class="d-lbl">Procesadores</h6>
                    <div class="media">
                        <i class="mdi mdi-cube icon-sm text-success d-flex align-self-start mr-3"></i>
                        <div class="media-body">
                            <h6 class="d-lbl">
                                <?php
                                if ($data->ncpu == "Desconectado") {
                                    echo $data->ncpu;
                                } else {
                                    echo ("$data->ncpu Núcleos");
                                } ?>
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class=" row">

        <div class="col-md-2 grid-margin stretch-card">
            <div class="card">
                <div class="card-body d-card">
                    <h6 class="d-lbl">Frecuencia CPU</h6>
                    <div class="media">
                        <i class="mdi mdi-stairs icon-sm text-danger d-flex align-self-start mr-3"></i>
                        <div class="media-body">
                            <h6 class="d-lbl">
                                <?php
                                if ($data->fcpu == "Desconectado") {
                                    echo $data->fcpu;
                                } else {
                                    echo ("$data->fcpu GHZ");
                                } ?>
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2 grid-margin stretch-card">
            <div class="card">
                <div class="card-body d-card">
                    <h6 class="d-lbl">Carga de CPU</h6>
                    <div class="media">
                        <i class="mdi mdi-blur icon-sm text-warning d-flex align-self-start mr-3"></i>
                        <div class="media-body">
                            <h6 class="d-lbl">
                                <?php
                                if ($data->ccpu == "Desconectado") {
                                    echo $data->ccpu;
                                } else {
                                    echo ("$data->ccpu %");
                                } ?>
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2 grid-margin stretch-card">
            <div class="card">
                <div class="card-body d-card">
                    <h6 class="d-lbl">Espacio HDD Libre</h6>
                    <div class="media">
                        <i class="mdi mdi-database text-primary d-flex align-self-start mr-3"></i>
                        <div class="media-body">
                            <h6 class="d-lbl">
                                <?php
                                if ($data->fhdd == "Desconectado") {
                                    echo $data->fhdd;
                                } else {
                                    echo round((($data->fhdd / 1024) / 1024), 2, PHP_ROUND_HALF_DOWN), " MB";
                                } ?>
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2 grid-margin stretch-card">
            <div class="card">
                <div class="card-body d-card">
                    <h6 class="d-lbl">HDD Total</h6>
                    <div class="media">
                        <i class="mdi mdi-database-plus icon-sm text-success d-flex align-self-start mr-3"></i>
                        <div class="media-body">
                            <h6 class="d-lbl">
                                <?php
                                if ($data->thdd == "Desconectado") {
                                    echo $data->thdd;
                                } else {
                                    echo round((($data->thdd / 1024) / 1024), 2, PHP_ROUND_HALF_DOWN), " MB";
                                } ?>
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2 grid-margin stretch-card">
            <div class="card">
                <div class="card-body d-card">
                    <h6 class="d-lbl">Plataforma</h6>
                    <div class="media">
                        <i class="mdi mdi-memory icon-sm text-warning d-flex align-self-start mr-3"></i>
                        <div class="media-body">
                            <h6 class="d-lbl"><?php echo $data->plataforma; ?></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2 grid-margin stretch-card">
            <div class="card">
                <div class="card-body d-card">
                    <h6 class="d-lbl">Clientes PPPoE</h6>
                    <div class="media">
                        <i class="mdi mdi-timer icon-sm text-primary d-flex align-self-start mr-3"></i>
                        <div class="media-body">
                            <h6 class="d-lbl"><?php echo $data->poe; ?> Activos</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>