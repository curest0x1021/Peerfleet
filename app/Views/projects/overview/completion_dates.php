<!--checklist-->
<div class="card" style="min-height:25vh;">
    <div class="card-body">
        <div class="d-flex align-items-center" >
            <strong class="float-start"><?php echo app_lang("completion_dates"); ?> </strong>
            &nbsp;
            <?php echo modal_anchor(get_uri("projects/completion_dates/".$project_info->id),'<button class="btn btn-sm btn-default" ><i class="icon-16" data-feather="edit" ></i></button>',array());?>
        </div>
        <br/>
        <br/>
        <div>
            <div class="row" >
                <div class="col-md-6 flex flex-vertical justify-content-around" >
                    <p>Contractul delivery date : <?php echo isset($project_info->contractual_delivery_date)?date('d.m.Y', strtotime($project_info->contractual_delivery_date)):"";?></p>
                    <p>Yard's estimated completion date : <?php echo $project_info->yard_estimated_completion_date?date('d.m.Y', strtotime($project_info->yard_estimated_completion_date)):"";?></p>
                    <p>Own estimated date : <?php echo $project_info->deadline?date('d.m.Y', strtotime($project_info->deadline)):"";?></p>
                    <p>Actual completion date : <?php echo $project_info->actual_completion_date?date('d.m.Y', strtotime($project_info->actual_completion_date)):"";?></p>
                </div>
                <div class="col-md-3" >
                    <canvas id="completion-dates-days-chart" style="width:10vw"></canvas>
                </div>
                <div class="col-md-3" >
                    <canvas id="completion-dates-hours-chart" style="width:10vw"></canvas>
                </div>
            </div>
            <div class="row" style="margin-top:20px;" >
                <div class="col-md-6"></div>
                <div class="col-md-6 d-flex justify-content-center ">
                    <p>Upcoming milstone :  <?php echo isset($upcoming_milestone)?$upcoming_milestone->title:"No upcoming milestone"?></p>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        const now=new Date();
        const deadline=new Date('<?php echo $project_info->deadline;?>');
        const start_date=new Date('<?php echo $project_info->start_date;?>');
        const all_period=deadline-start_date;
        const left_period=deadline-now;
        var days=Math.floor(all_period/86400000);
        if(left_period>0) days=Math.floor(left_period/(86400000));
        var hours=24;
        if(left_period>0) { 
            hours=Math.floor((left_period%(86400000))/3600000)
        };
        const days_percent=((all_period-left_period)/all_period)*100;
        var days_color="#e74c3c";
        if(days_percent<10){

        }else if(days_percent<40){
            days_color="#F9A52D";
        }else if(days_percent<80){
            days_color="#00B393";
        }else {
            days_color="#2d9cdb";
        }
        console.log(deadline-now);

        const hours_percent=hours*100/24;
        var hours_color="#e74c3c";
        if(hours_percent<10){

        }else if(hours_percent<40){
            hours_color="#F9A52D";
        }else if(hours_percent<80){
            hours_color="#00B393";
        }else {
            hours_color="#2d9cdb";
        }
        console.log(deadline-now);
        new Chart(document.getElementById("completion-dates-days-chart"), {
            type: 'doughnut',
            data: {
                datasets: [{
                        label: 'Complete',
                        percent: ((all_period-left_period)/all_period)*100,
                        backgroundColor: [days_color],
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
                        ctx.textAlign = "";
                        var text = days + " days",
                                textX = Math.round((width - ctx.measureText(text).width) / 2),
                                textY = height / 2;
                        ctx.fillText(text, textX, textY);
                        ctx.save();
                    }
                }
            ],
            options: {
                maintainAspectRatio: false,
                cutoutPercentage: 90,
                rotation: Math.PI / 2,
                legend: {
                    display: false
                },
                tooltips: {
                    enabled:false,
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
        new Chart(document.getElementById("completion-dates-hours-chart"), {
            type: 'doughnut',
            data: {
                datasets: [{
                        label: 'Complete',
                        percent: hours*100/24,
                        backgroundColor: [hours_color],
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
                        ctx.textAlign = "";
                        var text = (hours) + " hours",
                                textX = Math.round((width - ctx.measureText(text).width) / 2),
                                textY = height / 2;
                        ctx.fillText(text, textX, textY);
                        ctx.save();
                    }
                }
            ],
            options: {
                maintainAspectRatio: false,
                cutoutPercentage: 90,
                rotation: Math.PI / 2,
                legend: {
                    display: false
                },
                tooltips: {
                    enabled:false,
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
    })
</script>
