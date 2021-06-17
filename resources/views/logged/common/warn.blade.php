<div class="modal fade" id="warnModal" tabindex="-1" role="dialog" aria-labelledby="warnModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title" id="warnModalTitle">{{$language::get('warn')}}</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" id="modal-content">
            <div class="alert alert-danger" role="alert">
                <span class="warn-count"></span>
            </div>

            <div class="warn-requests"></div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{$language::get('close')}}</button>
        </div>
        </div>
    </div>
</div>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

<script>
    $(document).ready(function() {
        $('.warner').click(function (e){
            e.preventDefault();
            e.stopPropagation();
            $('#warnModal').modal('show');
        });

        $.get('{{route("request.warn")}}', function (data) {

            if (data.length > 0) {

                $('.warn-badge').html(data.length);
                $('.warn-count').html(data.length+ "{{$language::get('requests_waiting_feedback')}}")

                $.each(data, function (key, item) {
                    $('.warn-requests').append('<hr /><a href="'+item.url+'">'
                        +'<b>'+item.category+'</b>: '
                        +'<br />Solicitante: <b>'+item.owner+'</b>'
                        +'<br />'+item.document_type+' <b>Nº '+item.document_code+'</b>'
                        +' enviado em <b>'+item.document_date+'</b>'+
                    '</a>');
                });

                $('.warner').show();

                if ($(location).attr("href").substring($(location).attr("href").lastIndexOf('/') + 1) == 'home') {
                    $('.warner').effect( "shake", {times:3}, 1000 );
                }
            }
        });
    });
</script>