<script>
    $('.view').click(function (e) {
        e.stopPropagation();
        e.preventDefault();

        $('#exampleModalLongTitle').html($(this).attr('data-title'));

        $.get($(this).attr('url'), function (data) {
            $('#modal-content').html(data);
        });

        $('#exampleModalLong').modal('show');
    });
</script>
