$(document).ajaxSend(function(){
    $('.loading-gif').show();
});

$(document).ajaxComplete(function(){
    $('.loading-gif').hide();
});

setTimeout(function() {
    $(".fader").fadeOut(3000);
}, 5000);

// Opens combo on focus
$(document).on('focus', '.select2-selection.select2-selection--single', function (e) {
    $(this).closest(".select2-container").siblings('select:enabled').select2('open');
});

$('select.select2').on('select2:closing', function (e) {
    $(e.target).data("select2").$selection.one('focus focusin', function (e) {
        e.stopPropagation();
    });
});

function delay(callback, ms) {
    var timer = 0;
    return function() {
        var context = this, args = arguments;
        clearTimeout(timer);
        timer = setTimeout(function () {
            callback.apply(context, args);
        }, ms || 0);
    };
}

$(document).ready(function() {

    $('.combo').select2({
        placeholder: "Selecione",
        theme: "bootstrap",
        selectOnClose: true
    });

    $('.combo_tag').select2({
        placeholder: "Selecione",
        theme: "bootstrap",
        tags: true,
        selectOnClose: true
    });

    $('.document_combo').select2({
        placeholder: "Selecione o documento",
        theme: "bootstrap",
        language: {
            inputTooShort: function () {
                return 'Busque o documento pelo número, título ou data.';
            },
            formatNoMatches: function () {
                return 'Busque o documento pelo número, título ou data.';
            },
        },
        minimumInputLength: 3,
        ajax: {
          url: "/documentos/combo",
          dataType: 'json',
        }
    });

    $('.cep').mask('00000-000');
    $('.cpf').mask('000.000.000-00');
    $('.cpf').mask('000.000.000-00');
    $('.cnpj').mask('00.000.000/0000-00');
    $('.document_number').mask("0000/0000", {reverse: true, autoclear: false });

    $('.document_number').blur(function() {
        var number = $(this).val().replace(/D/g,"");
        var n = number.length >= 5 ? 9 : 8;
        number = number.padStart(n,'0');
        number = number.replace(/^(\d{4})(\d)/,"$1/$2");
        $(this).val(number);
    });

    var maskBehavior = function (val) {
        return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
        }, options = {onKeyPress: function(val, e, field, options) {
                field.mask(maskBehavior.apply({}, arguments), options);
            }
        };

    $('.telefone').mask(maskBehavior, options);

    $('#address_code').blur(function(){
        
        var url = "https://viacep.com.br/ws/"+$(this).val()+"/json/";

        $.get(url, function (data) {
            $("#address_name").val(data.logradouro);
            $("#address_neighborhood").val(data.bairro);
            $("#address_city").val(data.localidade);
            $('#address_state').val(data.uf);
        });
    });

    /**
     *  Call search function
     */
    search();

    /**
     *  Trigger search function
     */
    $('#search').keyup(delay(function(){
        search();
    }, 600));

    /**
     *  Paginates results
     */
    $('body').on('click', '.pagination a', function(e) {
        e.preventDefault();
        loadResult($(this).attr('href'));
    });

    $('.copyme').click(function (e) {
        e.stopPropagation();
        e.preventDefault();

        let inputCopy = document.createElement("input");
        inputCopy.value = $.trim($(this).html());
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
