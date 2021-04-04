<script>
    /**
     *  Searches on ready
     */
    $(document).ready(function() {
        requestSearch();
    })

    /**
     *  Searches on type
     */
    $('#request_search').keyup(delay(function(){
        requestSearch();
    }, 600));

    /**
     *  Searches when status is changed
     */
    $('#status_id').change(function(){
        requestSearch();
    });

    /**
     *  Searches when category is changed
     */
    $('#category_id').change(function(){
        requestSearch();
    });

    /**
     *  Searches
     */
    function requestSearch()
    {
        var url = "{{route('request.search')}}/";
        var query = $('#request_search').val();
        var category = $('#category_id').val();
        var status = $('#status_id').val();

        var params = "?query="+query;

        if (category > 0) {
            params += "&category="+category;
        }

        if (status > 0) {
            params += "&status="+status;
        }

        requestLoad(url+params);
    }

    /**
     *  Loads result
     */
    function requestLoad(url)
    {
        $('#requests').html('');

        $.get(url, function (data) {
            $('#requests').html(data);
        });
    }
</script>