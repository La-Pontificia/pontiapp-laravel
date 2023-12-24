import { createChart } from 'lightweight-charts';

var element = document.getElementById('chart-timeline-colaboradores');

if (element) {
    var chart = createChart(element, {
        autoSize: true,
        rightPriceScale: {
            scaleMargins: {
                top: 0.35,
                bottom: 0.2,
            },
            borderVisible: false,
        },
        timeScale: {
            borderVisible: false,
        },
        grid: {
            horzLines: {
                color: '#eee',
                visible: false,
            },
            vertLines: {
                color: '#ffffff',
            },
        },
    });


    // var chart  = createChart(element, {
    //     autoSize: true,
    //     rightPriceScale: {
    //         scaleMargins: {
    //             top: 0.35,
    //             bottom: 0.2,
    //         },
    //         borderVisible: false,
    //     },
    //     timeScale: {
    //         borderVisible: false,
    //     },
    //     grid: {
    //         horzLines: {
    //             color: '#eee',
    //             visible: false,
    //         },
    //         vertLines: {
    //             color: '#ffffff',
    //         },
    //     },
    //     crosshair: {
    //         horzLine: {
    //             visible: false,
    //             labelVisible: false
    //         },
    //         vertLine: {
    //             visible: true,
    //             style: 0,
    //             width: 2,
    //             color: 'rgba(32, 38, 46, 0.1)',
    //             labelVisible: false,
    //         }
    //     },
    // });

    var areaSeries = chart.addAreaSeries({
        topColor: 'rgba(33, 150, 243, 0.56)',
        bottomColor: 'rgba(33, 150, 243, 0.04)',
        lineColor: 'rgba(33, 150, 243, 1)',
        lineWidth: 3,
    });

    var darkTheme = {
        chart: {
            layout: {
                background: {
                    type: 'solid',
                    color: '#020613',
                },
                lineColor: '#FFFFFF',
                textColor: '#FFFFFF',
            },
            watermark: {
                color: 'rgba(0, 0, 0, 0)',
            },
            crosshair: {
                color: '#758696',
            },
            grid: {
                vertLines: {
                    color: '#2B2B43',
                },
                horzLines: {
                    color: '#363C4E',
                },
            },
        },
        series: {
            topColor: 'rgba(33, 150, 243, 0.56)',
            bottomColor: 'rgba(33, 150, 243, 0.04)',
            lineColor: 'rgba(33, 150, 243, 1)',
        },
    };

    const lightTheme = {
        chart: {
            layout: {
                background: {
                    type: 'solid',
                    color: '#0000',
                },
                lineColor: '#0000',
                textColor: '#191919',
            },
            watermark: {
                color: 'rgba(0, 0, 0, 0)',
            },
            grid: {
                vertLines: {
                    visible: false,
                },
                horzLines: {
                    color: '#f0f3fa',
                },
            },
        },
        series: {
            topColor: 'rgba(33, 150, 243, 0.56)',
            bottomColor: 'rgba(33, 150, 243, 0.04)',
            lineColor: 'rgba(33, 150, 243, 1)',
        },
    };

    var themesData = {
        Dark: darkTheme,
        Light: lightTheme,
    };

    function syncToTheme(theme) {
        chart.applyOptions(themesData[theme].chart);
        areaSeries.applyOptions(themesData[theme].series);
    }

    function fetchDataAndDrawChart() {
        fetch('/reportes/colaboradores?report=timeline') // Reemplaza '/ruta-de-tu-api' con la ruta real de tu API
            .then(response => response.json())
            .then(data => {
                areaSeries.setData(
                    data.reverse().map(item => {
                        return {
                            time: item.time,
                            value: item.value
                        }
                    })
                );
            })
            .catch(error => console.error('Error al obtener datos:', error));
    }

    fetchDataAndDrawChart();
    syncToTheme('Ligth');
}