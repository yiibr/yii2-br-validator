/**
 * yiibr validation module.
 *
 * This JavaScript module provides the validation methods for the built-in validators.
 *
 * @link https://github.com/yiibr/yii2-br-validator
 * @license https://github.com/yiibr/yii2-br-validator/blob/master/LICENSE
 * @author Wanderson Bragança <wanderson.wbc@gmail.com>
 */
var yiibr = (typeof yiibr == "undefined" || !yiibr)? {} : yiibr;

yiibr.validation = (function($) {
    var pub = {
        isEmpty: function(value) {
            return value === null || value === undefined || value == [] || value === '';
        },
        addMessage: function(messages, message, value) {
            messages.push(message.replace(/\{value\}/g, value));
        },
        cpf: function(value, messages, options) {
            if (options.skipOnEmpty && pub.isEmpty(value)) {
                return;
            }
            String.prototype.repeat = function(num) {
                return new Array(isNaN(num) ? 1 : ++num).join(this);
            }
            var valid = true;
            var cpf = value.replace(/[^0-9_]/g, "");
            if (cpf.length != 11) {
                valid = false;
            } else {
                for (var x = 0; x < 10; x++) {
                    if (cpf === x.toString().repeat(11)) {
                        valid = false;
                    }
                }
                if (valid) {
                    var c = cpf.substr(0, 9);
                    var dv = cpf.substr(9, 2);
                    var d1 = 0;
                    for (i = 0; i < 9; i++) {
                        d1 += c.charAt(i) * (10 - i);
                    }
                    if (d1 == 0) {
                        valid = false;
                    } else {
                        d1 = 11 - (d1 % 11);
                        if (d1 > 9) d1 = 0;
                        if (dv.charAt(0) != d1) {
                            valid = false;
                        } else {
                            d1 *= 2;
                            for (i = 0; i < 9; i++) {
                                d1 += c.charAt(i) * (11 - i);
                            }
                            d1 = 11 - (d1 % 11);
                            if (d1 > 9) d1 = 0;
                            if (dv.charAt(1) != d1) {
                                valid = false;
                            }
                        }
                    }
                }
            }
            if (!valid) {
                pub.addMessage(messages, options.message, value);
            }
        },
        cnpj: function(value, messages, options) {
            if (options.skipOnEmpty && pub.isEmpty(value)) {
                return;
            }

            String.prototype.repeat = function(num) {
                return new Array(isNaN(num) ? 1 : ++num).join(this);
            }

            var valid = true;

            cnpj = value.replace(/[^\d]+/g, '');

            if (cnpj == "00000000000000" ||
                    cnpj == "11111111111111" ||
                    cnpj == "22222222222222" ||
                    cnpj == "33333333333333" ||
                    cnpj == "44444444444444" ||
                    cnpj == "55555555555555" ||
                    cnpj == "66666666666666" ||
                    cnpj == "77777777777777" ||
                    cnpj == "88888888888888" ||
                    cnpj == "99999999999999") {
                valid = false;
            }

            if (cnpj == '') {
                valid = false;
            }

            if (cnpj.length != 14) {
                valid = false;
            }

            tamanho = cnpj.length - 2;
            numeros = cnpj.substring(0, tamanho);
            digitos = cnpj.substring(tamanho);
            soma = 0;
            pos = tamanho - 7;
            for (i = tamanho; i >= 1; i--) {
                soma += numeros.charAt(tamanho - i) * pos--;
                if (pos < 2) {
                    pos = 9;
                }
            }
            resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
            if (resultado != digitos.charAt(0)) {
                valid = false;
            }

            tamanho = tamanho + 1;
            numeros = cnpj.substring(0, tamanho);
            soma = 0;
            pos = tamanho - 7;
            for (i = tamanho; i >= 1; i--) {
                soma += numeros.charAt(tamanho - i) * pos--;
                if (pos < 2) {
                    pos = 9;
                }
            }
            resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;

            if (resultado != digitos.charAt(1)) {
                valid = false;
            }

            if (!valid) {
                pub.addMessage(messages, options.message, value);
            }
        }
    };
    return pub;
})(jQuery);
