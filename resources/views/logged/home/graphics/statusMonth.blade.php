<div class="mb-2">
    <center>
        <b>{{$language::get('dashboard_request_status_month')}}</b>
    </center>
</div>

<canvas id="status_month"></canvas>

<script>
    var ctx = document.getElementById('status_month');

    var status_mes = new Chart(ctx, {
        type: 'polarArea',
        data: {
            labels: [
                <?php
                    foreach ($data['status']['month'] as $status) {
                        echo "'".$status['label']."',";
                    }
                ?>
            ],
            datasets: [{
                label: "{{$language::get('dashboard_info_label')}}",
                data: [
                    <?php
                        foreach ($data['status']['month'] as $status) {
                            echo $status['total'].",";
                        }
                    ?>
                ],
                backgroundColor: [
                    <?php
                        foreach ($data['status']['month'] as $status) {
                            echo "'".$status['backgroundColor']."',";
                        }
                    ?>
                ],
                borderColor: [
                    <?php
                        foreach ($data['status']['month'] as $status) {
                            echo "'".$status['borderColor']."',";
                        }
                    ?>
                ],
                borderWidth: 1
            }]
        },
    });
</script>