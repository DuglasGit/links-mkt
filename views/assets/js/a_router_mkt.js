$(function () {
    $("#estadoTxt").html('Conectando...');
    $.ajax({
        url: 'php/infoDashboard.php',
        dataType: 'json',
        success: function (data) {
            console.log(data);
            if (data.estado == 0) {
                //$("#estadoTxt").html('No se pudo conectar');
                alert('Error al conectar con Routerboard');

            } else {
                //$("#estadoTxt").html('Conectado');
                console.log('Conexion exitosa!');
                // $("#modelTxt").html(data.boardname);
                // $("#uptimeTxt").html(data.uptime);
                // $("#cpuTxt").html(data.cpuload + '%');
                // $("#versionTxt").html(data.version);
            }
        }
    });

});