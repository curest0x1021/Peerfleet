<div class="modal-body">
    <div class="row">
        <div class="p10 clearfix">
            <canvas id="leave-status-chart" style="width: 100%; height: 200px;"></canvas>
        </div>
    </div>
    <div class="row">
        <div class="p10 clearfix">
            <?php echo $user_leaves; ?> days holiday entitlement (<?php echo $user_leaves; ?> days plus 0 remain days)
        </div>
    </div>
    <div class="row">
        <div class="p10 clearfix">
            <div class='progress' title=''>
                <div  class='progress-bar' role='progressbar' aria-valuenow='<?php echo $total_leaves; ?>' aria-valuemin='0' aria-valuemax='<?php echo $user_leaves; ?>' style='width: <?php echo $total_leaves/$user_leaves*100; ?>%'>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-8">
            <?php echo $total_leaves; ?> days taken
        </div>
        <div class="col-4">
        <?php echo $user_leaves - $total_leaves; ?> days left
        </div>
    </div>
</div>
<script type="text/javascript">
    var ticketStatusChart = document.getElementById("leave-status-chart");

    var ticks = <?php echo $ticks; ?>;
    var tickets = <?php echo $total_tickets; ?>;

    new Chart(ticketStatusChart, {
        type: 'bar',
        data: {
            labels: ticks,
            datasets: [
                {
                    data: tickets,
                    backgroundColor: "#38B393",
                    borderWidth: 0
                }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                display: false
            },
            tooltips: {
                intersect: true,
                enabled: true
            },
            scales: {
                xAxes: [{
                        gridLines: {
                            display: false
                        },
                        ticks: {
                            display: true
                        }
                    }],
                yAxes: [{
                        gridLines: {
                            display: false
                        },
                        ticks: {
                            display: true
                        }
                    }]
            }
        }
    });
</script>