<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.min.js"></script>
<?php
require_once "./routerMIkrotik/Resources.php";
$data = RouterR::RouterConnect();
$activos = RouterR::RouterClientesActivos();
$activos = json_decode($activos);
$activos = count($activos);

$suspendidos = RouterR::RouterClientesSuspendidos();
$suspendidos = json_decode($suspendidos, true);

$clientes = RouterR::RouterClientes();
$clientes = json_decode($clientes, true);

$c = 0;
foreach ($suspendidos as $val) {
    if ($val['list'] == "Moroso") {
        $c++;
    }
}
$suspendidos = $c;


$perfiles = [
    "2M" => 0,
    "4M" => 0,
    "6M" => 0,
    "8M" => 0,
    "10M" => 0,
    "12M" => 0,
    "ILIMITADO" => 0,
    "OTRO" => 0,
];

foreach ($clientes as $val) {

    switch ($val['profile']) {
        case '2M': {
                $perfiles['2M'] = $perfiles['2M'] + 1;
                break;
            }
        case '4M': {
                $perfiles['4M'] = $perfiles['4M'] + 1;
                break;
            }
        case '6M': {
                $perfiles['6M'] = $perfiles['6M'] + 1;
                break;
            }
        case '8M': {
                $perfiles['8M'] = $perfiles['8M'] + 1;
                break;
            }
        case '10M': {
                $perfiles['10M'] = $perfiles['10M'] + 1;
                break;
            }
        case '12M': {
                $perfiles['12M'] = $perfiles['12M'] + 1;
                break;
            }
        case 'ILIMITADO': {
                $perfiles['ILIMITADO'] = $perfiles['ILIMITADO'] + 1;
                break;
            }
        default: {
                $perfiles['OTRO'] = $perfiles['OTRO'] + 1;
                break;
            }
    }
}

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

<div class="row justify-content-center">
    <div class="col-md-12 col-lg-5 grid-margin stretch-card">
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
                <h4 class="card-title text-center">ESTADO DE CLIENTES</h4>
                <canvas id="dona" style="height: 230px; display: block; width: 461px;" width="461" height="230" class="chartjs-render-monitor"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-lg-5 grid-margin stretch-card">
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
                <h4 class="card-title text-center">PERFIL DE CLIENTES</h4>
                <canvas id="columna" style="height: 289px; display: block; width: 578px;" width="578" height="289" class="chartjs-render-monitor"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <br>
    <h4 class="card-title text-light">Información de Uso de Recursos del Router Mikrotik</h4>
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
                    <i class="mdi mdi-account-multiple-plus icon-sm text-primary d-flex align-self-start mr-3"></i>
                    <div class="media-body">
                        <h6 class="d-lbl"><?php echo $data->poe; ?></h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var ctx = document.getElementById("dona").getContext('2d');
    var doughnutPieData = {
        datasets: [{
            data: [<?php echo $activos; ?>, <?php echo $suspendidos; ?>],
            backgroundColor: [
                'rgba(54, 162, 235, 0.5)',
                'rgba(255, 99, 132, 0.5)',

                'rgba(255, 206, 86, 0.5)',
                'rgba(75, 192, 192, 0.5)',
                'rgba(153, 102, 255, 0.5)',
                'rgba(255, 159, 64, 0.5)'
            ],
            borderColor: [
                'rgba(54, 162, 235, 1)',
                'rgba(255,99,132,1)',

                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
        }],

        // These labels appear in the legend and in the tooltips when hovering different arcs
        labels: [
            'ACTIVOS',
            'SUSPENDIDOS',
        ]
    };

    var doughnutPieOptions = {
        responsive: true,
        animation: {
            animateScale: true,
            animateRotate: true
        }
    };

    var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: doughnutPieData,
        options: doughnutPieOptions
    });
</script>

<script>
    var ctx = document.getElementById("columna").getContext('2d');
    var data = {
        labels: ["2MB", "4MB", "6MB", "8MB", "10MB", "12MB", "ILIM"],
        datasets: [{
            label: '# Clientes',
            data: [<?php echo $perfiles['2M']; ?>, <?php echo $perfiles['4M']; ?>, <?php echo $perfiles['6M']; ?>, <?php echo $perfiles['8M']; ?>, <?php echo $perfiles['10M']; ?>, <?php echo $perfiles['12M']; ?>, <?php echo $perfiles['ILIMITADO']; ?>],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 99, 132, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255,99,132,1)'
            ],
            borderWidth: 1,
            fill: false
        }]
    };

    var options = {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                },
                gridLines: {
                    color: "rgba(204, 204, 204,0.1)"
                }
            }],
            xAxes: [{
                gridLines: {
                    color: "rgba(204, 204, 204,0.1)"
                }
            }]
        },
        legend: {
            display: false
        },
        elements: {
            point: {
                radius: 0
            }
        }
    };

    var barChart = new Chart(ctx, {
        type: 'bar',
        data: data,
        options: options
    });
</script>