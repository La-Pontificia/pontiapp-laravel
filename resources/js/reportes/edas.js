import { createChart } from "lightweight-charts";

var element = document.getElementById("chart-edas");

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
                color: "#eee",
                visible: false,
            },
            vertLines: {
                color: "#ffffff",
            },
        },
    });

    var darkTheme = {
        chart: {
            layout: {
                background: {
                    type: "solid",
                    color: "#020613",
                },
                lineColor: "#FFFFFF",
                textColor: "#FFFFFF",
            },
            watermark: {
                color: "rgba(0, 0, 0, 0)",
            },
            crosshair: {
                color: "#758696",
            },
            grid: {
                vertLines: {
                    color: "#2B2B43",
                },
                horzLines: {
                    color: "#363C4E",
                },
            },
        },
        series: {
            topColor: "rgba(33, 150, 243, 0.56)",
            bottomColor: "rgba(33, 150, 243, 0.04)",
            lineColor: "rgba(33, 150, 243, 1)",
        },
    };

    const lightTheme = {
        chart: {
            layout: {
                background: {
                    type: "solid",
                    color: "#0000",
                },
                lineColor: "#0000",
                textColor: "#191919",
            },
            watermark: {
                color: "rgba(0, 0, 0, 0)",
            },
            grid: {
                vertLines: {
                    visible: false,
                },
                horzLines: {
                    color: "#f0f3fa",
                },
            },
        },
        series: {
            topColor: "rgba(33, 150, 243, 0.56)",
            bottomColor: "rgba(33, 150, 243, 0.04)",
            lineColor: "rgba(33, 150, 243, 1)",
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
        fetch("/reportes/edas?report=timeline") // Reemplaza '/ruta-de-tu-api' con la ruta real de tu API
            .then((response) => response.json())
            .then((data) => {
                chart
                    .addAreaSeries({
                        topColor: "rgba(33, 150, 243, 0.56)",
                        bottomColor: "rgba(33, 150, 243, 0.04)",
                        lineColor: "rgba(33, 150, 243, 1)",
                        lineWidth: 2,
                    })
                    .setData(data.enviados.reverse());

                chart
                    .addAreaSeries({
                        color: "rgba(4, 111, 232, 1)",
                        lineWidth: 2,
                    })
                    .setData(data.aprobados.reverse());

                chart
                    .addAreaSeries({
                        topColor: "rgba(255,31,178, 0.56)",
                        bottomColor: "rgba(255,207,94, 0.04)",
                        lineColor: "rgba(255,31,178, 1)",
                        lineWidth: 2,
                    })
                    .setData(data.cerrados.reverse());
            })
            .catch((error) => console.error("Error al obtener datos:", error));
    }

    fetchDataAndDrawChart();
    syncToTheme("Ligth");
}
