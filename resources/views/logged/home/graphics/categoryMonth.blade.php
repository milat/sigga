<div class="mb-2">
    <center>
        <b>{{$language::get('dashboard_request_category_month')}}</b>
    </center>
</div>

<canvas id="categories_month"></canvas>

<script>
    var ctx = document.getElementById('categories_month');

    var categories_month = new Chart(ctx, {
        type: 'horizontalBar',
        data: {
            labels: [
                <?php
                    foreach ($data['categories']['month'] as $categoria) {
                        echo "'".$categoria['label']."',";
                    }
                ?>
            ],
            datasets: [{
                label: "{{$language::get('dashboard_info_label')}}",
                data: [
                    <?php
                        foreach ($data['categories']['month'] as $categoria) {
                            echo $categoria['total'].",";
                        }
                    ?>
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                    }
                }],
                xAxes: [{
                    ticks: {
                        beginAtZero: true,
                        callback: function(value) {if (value % 1 === 0) {return value;}}
                    }
                }],
            }
        }
    });
</script>