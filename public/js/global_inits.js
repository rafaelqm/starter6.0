$(function () {
  var mask = function (val) {
      return val.replace(/\D/g, '').length === 9 ? '00000-0000' : '0000-00009';
    },
    options = {
      onKeyPress: function (val, e, field, options) {
        field.mask(mask.apply({}, arguments), options);
      }
    };

  var SPMaskBehavior = function (val) {
      return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
    },
    spOptions = {
      onKeyPress: function(val, e, field, options) {
        field.mask(SPMaskBehavior.apply({}, arguments), options);
      }
    };

  $('.celphone').mask(SPMaskBehavior, spOptions);

  $('.phone').mask(mask, options);
  $('.cep').mask('00000-000');
  $('.cpf').mask('999.999.999-99');
  $('.cnpj').mask('99.999.999/9999-99');
  $('.rg').mask('99.999.999-A');
  $('.hora').mask('99:99');
  $('.money').mask('0.000.000.000.000,00', {reverse: true});

  $('.select2').each(function (n, el) {
    var $el = $(el);
    var placeholder = $el.find('[value=""]').first().text()
      || $el.prop('placeholder')
      || $el.data('placeholder')
      || '-';

    $el.select2({
      placeholder: placeholder,
      theme: 'coreui',
      language: "pt-BR",
      width: '100%',
      allowClear: true
    });
  });
});
