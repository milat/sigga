<fieldset>
    <div class="mb-2 pt-2">
        <center>
            <h4>
                <b>{{$language::get('dashboard_request_status_year')}}</b>
            </h4>
        </center>
    </div>

    <canvas id="status_year"></canvas>
</fieldset>

<script>
    var ctx = document.getElementById('status_year');

    var status_year = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [
                <?php
                    foreach ($data['status']['year'] as $status) {
                        echo "'".$status['label']."',";
                    }
                ?>
            ],
            datasets: [{
                label: "{{$language::get('dashboard_info_label')}}",
                data: [
                    <?php
                        foreach ($data['status']['year'] as $status) {
                            echo $status['total'].",";
                        }
                    ?>
                ],
                backgroundColor: [
                    <?php
                        foreach ($data['status']['year'] as $status) {
                            echo "'".$status['backgroundColor']."',";
                        }
                    ?>
                ],
                borderColor: [
                    <?php
                        foreach ($data['status']['year'] as $status) {
                            echo "'".$status['borderColor']."',";
                        }
                    ?>
                ],
                borderWidth: 1
            }]
        },
        options: {
            legend: {
                display: false
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        callback: function(value) {if (value % 1 === 0) {return value;}}
                    }
                }],
            }
        }
    });
</script>