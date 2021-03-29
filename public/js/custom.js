$(document).ajaxSend(function(){
    $('.loading-gif').show();
});

$(document).ajaxComplete(function(){
    $('.loading-gif').hide();
});

setTimeout(function() {
    $(".fader").fadeOut(3000);
}, 5000);

$(document).ready(function() {

    $('.combo').select2({
        placeholder: "Selecione",
        theme: "bootstrap"
    });

    $('.cep').mask('00000-000');
    $('.cpf').mask('000.000.000-00');
    $('.cpf').mask('000.000.000-00');
    $('.cnpj').mask('00.000.000/0000-00');

    var maskBehavior = function (val) {
        return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
    },
    options = {onKeyPress: function(val, e, field, options) {
            field.mask(maskBehavior.apply({}, arguments), options);
        }
    };

    $('.telefone').mask(maskBehavior, options);

    $('#cep').blur(function(){

        var url = "https://viacep.com.br/ws/"+$(this).val()+"/json/";

        $.get(url, function (data) {
            $("#logradouro").val(data.logradouro);
            $("#bairro").val(data.bairro);
            $("#cidade").val(data.localidade);
            $('#uf').val(data.uf);
        });
    });

    /**
     *  Call search function
     */
    search();

    /**
     *  Trigger search function
     */
    $('#search').keyup(function(){
        search();
    });

    /**
     *  Paginates results
     */
    $('body').on('click', '.pagination a', function(e) {
        e.preventDefault();
        loadResult($(this).attr('href'));
    });

});

/**
 *  Searches
 */
function search()
{
    var url = $('#search').attr('url');
    var query = $('#search').val();

    loadResult(url+query);
}

/**
 *  Loads search results
 */
function loadResult(url)
{
    $('#result').html('');

    $.get(url, function (data) {
        $('#result').html(data);
    });
}
