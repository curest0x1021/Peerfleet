<div class="card" style="height:350px;" >
    <div class="clearfix text-center mb-1">
        <div class="mt-50 chart-circle">
            <canvas id="project-progress-chart"></canvas>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        var project_progress = <?php echo $project_progress; ?>;
        var projectProgressChart = document.getElementById("project-progress-chart");

        var textDirection = "<?php echo app_lang("text_direction"); ?>";
        var textAlign = "";
        if (textDirection === "rtl") {
            var textAlign = "center";
        }

        window.chart_project_progress=new Chart(projectProgressChart, {
            type: 'doughnut',
            data: {
                datasets: [{
                        label: 'Complete',
                        percent: project_progress,
                        backgroundColor: ['#6690F4'],
                        borderWidth: 0
                    }]
            },
            plugins: [{
                    beforeInit: (chart) => {
                        const dataset = chart.data.datasets[0];
                        chart.data.labels = [dataset.label];
                        dataset.data = [dataset.percent, 100 - dataset.percent];
                    }
                },
                {
                    beforeDraw: (chart) => {
                        var width = chart.chart.width,
                                height = chart.chart.height,
                                ctx = chart.chart.ctx;
                        ctx.restore();
                        ctx.font = 1.5 + "em sans-serif";
                        ctx.fillStyle = "#9b9b9b";
                        ctx.textBaseline = "middle";
                        ctx.textAlign = textAlign;
                        var text = chart.data.datasets[0].percent + "%",
                                textX = Math.round((width - ctx.measureText(text).width) / 2),
                                textY = height / 2;
                        ctx.fillText(text, textX, textY);
                        ctx.save();
                    }
                }
            ],
            options: {
                transitions:{
                    duration:300
                },
                animation:{
                    duration:300
                },
                maintainAspectRatio: false,
                cutoutPercentage: 90,
                rotation: Math.PI / 2,
                legend: {
                    display: false
                },
                tooltips: {
                    filter: tooltipItem => tooltipItem.index === 0,
                    callbacks: {
                        afterLabel: function (tooltipItem, data) {
                            var dataset = data['datasets'][0];
                            var percent = Math.round((dataset['data'][tooltipItem['index']] / dataset["_meta"][Object.keys(dataset["_meta"])[0]]['total']) * 100);
                            return '(' + percent + '%)';
                        }
                    }
                }
            }
        });
    });
</script>
