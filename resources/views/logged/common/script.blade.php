<script>
    $('.copyme').click(function (e) {
        e.stopPropagation();
        e.preventDefault();

        let inputCopy = document.createElement("input");
        inputCopy.value = $.trim($(this).attr('data'));
        document.body.appendChild(inputCopy);
        inputCopy.select();
        document.execCommand('copy');
        document.body.removeChild(inputCopy);

        var dataId = $(this).attr('data-id');

        $('#copied_'+dataId).fadeIn(700, function(){
            window.setTimeout(function(){
                $('#copied_'+dataId).fadeOut(700);
            }, 1000);
        });
    });
</script>