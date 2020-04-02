$(function () {
    let mask = function (val) {
            return val.replace(/\D/g, '').length === 9
                ? '00000-0000'
                : '0000-00009';
        },
        options = {
            onKeyPress: function (val, e, field, options) {
                field.mask(mask.apply({}, arguments), options);
            },
        };

    let SPMaskBehavior = function (val) {
            return val.replace(/\D/g, '').length === 11
                ? '(00) 00000-0000'
                : '(00) 0000-00009';
        },
        spOptions = {
            onKeyPress: function (val, e, field, options) {
                field.mask(SPMaskBehavior.apply({}, arguments), options);
            },
        };

    $('.celphone').mask(SPMaskBehavior, spOptions);

    $('.phone').mask(mask, options);
    $('.cep').mask('00000-000');
    $('.cpf').mask('999.999.999-99');
    $('.cnpj').mask('99.999.999/9999-99');
    $('.rg').mask('99.999.999-A');
    $('.hora').mask('99:99');
    $('.money').mask('0.000.000.000.000,00', { reverse: true });

    $('.datetimepicker').datetimepicker({
        format: 'DD/MM/YYYY HH:mm:ss',
        useCurrent: true,
        icons: {
            up: 'icon-arrow-up-circle icons font-2xl',
            down: 'icon-arrow-down-circle icons font-2xl',
        },
        sideBySide: true,
    });
    $('.datepicker').datetimepicker({
        format: 'DD/MM/YYYY',
        useCurrent: true,
        icons: {
            up: 'icon-arrow-up-circle icons font-2xl',
            down: 'icon-arrow-down-circle icons font-2xl',
        },
        sideBySide: true,
    });

    if (!Modernizr.inputtypes.date) {
        $('input[type=date]').each(function (index, obj) {
            var data = $(obj).val();
            if (data != '' && (data.indexOf('-') > 1)) {
                var ano = data.substring(0, 4);
                var mes = data.substring(5, 7);
                var dia = data.substring(8, 10);
                var data_formatada = dia + '/' + mes + '/' + ano;

                $(obj).attr('type', 'text').val(data_formatada).datetimepicker({
                    format: 'DD/MM/YYYY',
                    useCurrent: true,
                    icons: {
                        up: 'icon-arrow-up-circle icons font-2xl',
                        down: 'icon-arrow-down-circle icons font-2xl',
                    },
                    sideBySide: true,
                });
            }
        });

        $('input[type=date]').attr('type', 'text').datetimepicker({
            format: 'DD/MM/YYYY',
            useCurrent: true,
            icons: {
                up: 'icon-arrow-up-circle icons font-2xl',
                down: 'icon-arrow-down-circle icons font-2xl',
            },
            sideBySide: true,
        });
    }

    $('.select2').each(function (n, el) {
        var $el = $(el);
        var placeholder = $el.find('[value=""]').first().text()
            || $el.prop('placeholder')
            || $el.data('placeholder')
            || '-';

        $el.select2({
            placeholder: placeholder,
            theme: 'coreui',
            language: 'pt-BR',
            width: '100%',
            allowClear: true,
        });
    });

    $('[data-toggle="tooltip"]').tooltip();
});
