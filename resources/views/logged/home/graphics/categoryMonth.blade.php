<fieldset>
    <div class="mb-2 pt-2">
        <center>
            <h4>
                <b>{{$language::get('dashboard_request_category_month')}}</b>
            </h4>
        </center>
    </div>

    <canvas id="categories_month"></canvas>
    
</fieldset>

<script>
    var ctx = document.getElementById('categories_month');

    var categories_month = new Chart(ctx, {
        type: 'horizontalBar',
        data: {
            labels: [
                <?php
                    foreach ($data['categories']['month'] as $category) {
                        echo "'".$category['label']."',";
                    }
                ?>
            ],
            datasets: [{
                label: "{{$language::get('dashboard_info_label')}}",
                data: [
                    <?php
                        foreach ($data['categories']['month'] as $category) {
                            echo $category['total'].",";
                        }
                    ?>
                ],
                backgroundColor: [
                    <?php
                        foreach ($data['categories']['month'] as $category) {
                            echo "'".$category['colour']."80',";
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