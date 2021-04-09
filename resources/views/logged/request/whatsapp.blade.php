@if ($request && $request->document && ($request->status_id == config('request_statuses.sent.id')) && $request->requester()->phone && $request->requester()->phone->type->name == 'WhatsApp')
    <div class="row">
        <div class="col-12">
            <a class="whatsapp" href="https://api.whatsapp.com/send?phone=+55{{$request->requester()->phone->getOnlyNumber()}}&text={{$language::feedbackSent($request)}}" target="_blank;">
                Enviar feedback via WhatsApp
            </a>
        </div>

        <div class="col-12">
            <a class="copyfeedback" href="javascript:;" data="{{str_replace(config('system.whatsapp_breakline'), ' ', $language::feedbackSent($request))}}">
                Copiar texto do feedback
            </a>
            <br />
            <span class='copied' style='color:green; display:none;'>Copiado <x-bi-check2-square/></span>
        </div>
    </div>

    <script>
        $('.copyfeedback').click(function (e) {
            e.stopPropagation();
            e.preventDefault();

            let inputCopy = document.createElement("input");
            inputCopy.value = $.trim($(this).attr('data'));
            document.body.appendChild(inputCopy);
            inputCopy.select();
            document.execCommand('copy');
            document.body.removeChild(inputCopy);

            $('.copied').fadeIn(700, function(){
                window.setTimeout(function(){
                    $('.copied').fadeOut(700);
                }, 1000);
            });
        });
    </script>
@endif