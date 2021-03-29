<div class="mb-2">
    <center>
        <b>{{$language::get('dashboard_request_category_year')}}</b>
    </center>
</div>

<canvas id="categories_year"></canvas>

<script>
    var ctx = document.getElementById('categories_year');

    var categories_year = new Chart(ctx, {
        type: 'horizontalBar',
        data: {
            labels: [
                <?php
                    foreach ($data['categories']['year'] as $categoria) {
                        echo "'".$categoria['label']."',";
                    }
                ?>
            ],
            datasets: [{
                label: "{{$language::get('dashboard_info_label')}}",
                data: [
                    <?php
                    foreach ($data['categories']['year'] as $categoria) {
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