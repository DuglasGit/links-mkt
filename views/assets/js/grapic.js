
var chart;
function requestDatta(interface) {
    $.ajax({
        datatype: "json",
        success: function (data) {
            var midata = JSON.parse(data);
            console.log(data);
            if (midata.length > 0) {
                var TX = parseInt(midata[0].data);
                var RX = parseInt(midata[1].data);
                var x = (new Date()).getTime();
                shift = chart.series[0].data.length > 19;
                chart.series[0].addPoint([x, TX], true, shift);
                chart.series[1].addPoint([x, RX], true, shift);
                document.getElementById("trafico").innerHTML = TX + " / " + RX;
            } else {
                document.getElementById("trafico").innerHTML = "- / -";
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.error("Status: " + textStatus + " request: " + XMLHttpRequest); console.error("Error: " + errorThrown);
        }
    });
}

$(document).ready(function () {
    Highcharts.setOptions({
        global: {
            useUTC: false
        }
    });


    chart = new Highcharts.Chart({
        chart: {
            renderTo: 'container',
            animation: Highcharts.svg,
            type: 'spline',
            events: {
                load: function () {
                    setInterval(function () {
                        requestDatta(document.getElementById("interface").value);
                    }, 1000);
                }
            }
        },
        title: {
            text: 'Monitoring'
        },
        xAxis: {
            type: 'datetime',
            tickPixelInterval: 150,
            maxZoom: 20 * 1000
        },
        yAxis: {
            minPadding: 0.2,
            maxPadding: 0.2,
            title: {
                text: 'Trafico',
                margin: 80
            }
        },
        series: [{
            name: 'TX',
            data: []
        }, {
            name: 'RX',
            data: []
        }]
    });
});
