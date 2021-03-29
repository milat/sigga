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
    $('#request_search').keyup(function(){
        requestSearch();
    });

    /**
     *  Searches when status is changed
     */
    $('#status_id').change(function(){
        requestSearch();
    });

    /**
     *  Paginação busca
     */
    // $('body').on('click', '.pagination a', function(e) {
    //     e.preventDefault();
    //     load($(this).attr('href'));
    // });

    /**
     *  Searches
     */
    function requestSearch()
    {
        var url = "{{route('request.search')}}/";
        var query = $('#request_search').val();
        var status = $('#status_id').val();

        var params = "?query="+query;

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