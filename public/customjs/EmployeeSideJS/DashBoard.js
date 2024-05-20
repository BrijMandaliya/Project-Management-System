$(document).ready(function () {
    if ($("#TaskDataPieChart").length) {
        var salesChartCCanvas = $("#TaskDataPieChart").get(0).getContext("2d");
        var salesChartC = new Chart(salesChartCCanvas, {
            type: "doughnut",
            data: {
                datasets: [
                    {
                        data: _TaskDataForPieChart,
                        backgroundColor: ["#f39915", "#21bf06", "#3cb5da"],
                        borderColor: ["#f39915", "#21bf06", "#3cb5da"],
                    },
                ],

                labels: _TaskLabelForPieChart,
            },
            options: {
                responsive: true,
                animation: {
                    animateScale: true,
                    animateRotate: true,
                },
                legend: {
                    display: false,
                },
                legendCallback: function (chart) {
                    var text = [];
                    text.push('<ul class="legend' + chart.id + '">');
                    for (
                        var i = 0;
                        i < chart.data.datasets[0].data.length;
                        i++
                    ) {
                        text.push(
                            '<li><span class="legend-dots" style="background-color:' +
                                chart.data.datasets[0].backgroundColor[i] +
                                '"></span>'
                        );
                        if (chart.data.labels[i]) {
                            text.push(chart.data.labels[i]);
                        }
                        text.push("</li>");
                    }
                    text.push("</ul>");
                    return text.join("");
                },
            },
        });
    }

    if ($("#ProjectDataPieChart").length) {
        var ProjectDataCharCanvas = $("#ProjectDataPieChart")
            .get(0)
            .getContext("2d");
        var ProjectDataChartC = new Chart(ProjectDataCharCanvas, {
            type: "doughnut",
            data: {
                datasets: [
                    {
                        data: _ProjectDataForPieChart,
                        backgroundColor: [
                            "#f39915",
                            "#21bf06",
                            "#cada3c",
                            "#3cb5da",
                        ],
                        borderColor: [
                            "#f39915",
                            "#21bf06",
                            "#cada3c",
                            "#3cb5da",
                        ],
                    },
                ],
                labels: _ProjectLabelsForPieChart, // These labels appear in the legend and tooltips
            },
            options: {
                responsive: true,
                animation: {
                    animateScale: true,
                    animateRotate: true,
                },
                layout:{
                    padding:{
                        top: 20,
                        bottom: 20,
                        right: 20,
                        left: 20,
                    },
                },
                legend: {
                    display: false,

                },
                legendCallback: function (chart) {
                    var text = [];
                    text.push('<ul class="legend' + chart.id + '">');
                    for (var i = 0;i < chart.data.datasets[0].data.length;i++) {

                            text.push(
                                '<li><span class="legend-dots" style="background-color:' +
                                    chart.data.datasets[0].backgroundColor[i] +
                                    '"></span>'
                            );
                            if (chart.data.labels[i]) {
                                text.push(chart.data.labels[i]);
                            }

                            text.push("</li>");

                    }
                    text.push("</ul>");

                    return text.join("");
                },
            },
        });
    }
});
