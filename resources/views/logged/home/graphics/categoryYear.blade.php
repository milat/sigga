<fieldset>
    <div class="mb-2 pt-2">
        <center>
            <h4>
                <b>{{$language::get('dashboard_request_category_year')}}</b>
            </h4>
        </center>
    </div>

    <canvas id="categories_year"></canvas>

</fieldset>

<script>
    var ctx = document.getElementById('categories_year');

    var categories_year = new Chart(ctx, {
        type: 'horizontalBar',
        data: {
            labels: [
                <?php
                    foreach ($data['categories']['year'] as $category) {
                        echo "'".$category['label']."',";
                    }
                ?>
            ],
            datasets: [{
                label: "{{$language::get('dashboard_info_label')}}",
                data: [
                    <?php
                        foreach ($data['categories']['year'] as $category) {
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