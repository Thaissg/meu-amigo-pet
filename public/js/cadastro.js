function testaDocumento(strDoc) {
    var teste
    if (strDoc.length == 14) {
        teste = validaCNPJ(strDoc);
    } else if (strDoc.length == 11) {
        teste = TestaCPF(strDoc);
    } else {
        teste = false
    }
    if (teste == false) {
        $("#validaDoc").html("CPF/CNPJ inválido");
    }
    return teste
}

function TestaCPF(strCPF) {
    var Soma;
    var Resto;
    Soma = 0;
    if (strCPF == "00000000000") {
        return false;
    }

    for (i = 1; i <= 9; i++) Soma = Soma + parseInt(strCPF.substring(i - 1, i)) * (11 - i);
    Resto = (Soma * 10) % 11;

    if ((Resto == 10) || (Resto == 11)) Resto = 0;
    if (Resto != parseInt(strCPF.substring(9, 10))) return false;

    Soma = 0;
    for (i = 1; i <= 10; i++) Soma = Soma + parseInt(strCPF.substring(i - 1, i)) * (12 - i);
    Resto = (Soma * 10) % 11;

    if ((Resto == 10) || (Resto == 11)) Resto = 0;
    if (Resto != parseInt(strCPF.substring(10, 11))) {
        return false;
    }
    return true;
}


function validaCNPJ(cnpj) {
    var b = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2]
    var c = String(cnpj).replace(/[^\d]/g, '')

    if (c.length !== 14)
        return false

    if (/0{14}/.test(c))
        return false

    for (var i = 0, n = 0; i < 12; n += c[i] * b[++i]);
    if (c[12] != (((n %= 11) < 2) ? 0 : 11 - n))
        return false

    for (var i = 0, n = 0; i <= 12; n += c[i] * b[i++]);
    if (c[13] != (((n %= 11) < 2) ? 0 : 11 - n))
        return false

    return true
}


const telMask = (event) => {
    let input = event.target
    input.value = phoneMask(input.value)
}

const phoneMask = (value) => {
    if (!value) return ""
    value = value.replace(/\D/g, '')
    value = value.replace(/(\d{2})(\d)/, "($1) $2")
    value = value.replace(/(\d)(\d{4})$/, "$1-$2")
    return value
}


function validacaoEmail(email) {
    var re = /\S+@\S+\.\S+/;
    if (re.test(email)) {
        $("#validaEmail").html("");
        return true
    } else {
        $("#validaEmail").html("Email inválido");
        return false
    }
}

function validaSenha(senha) {
    elem = $('#validaTamanho')
    if (senha.length < 8) {
        if (elem.hasClass('valido')) {
            elem.removeClass('valido');
        }
        elem.addClass('invalido');
        return false;
    } else {
        if (elem.hasClass('invalido')) {
            elem.removeClass('invalido');
        }
        elem.addClass('valido');
        return false;
    }
}

function validaConfSenha(confSenha){
    senha = document.getElementById('senha').value
    if (confSenha==senha){
        $('#validaConf').html("");
        return true
    } else {
        $('#validaConf').html("As senhas não conferem");
        return false
    }
}

function mostrarSenha(entrada,checkbox){
    campo = document.getElementById(entrada)
    if (checkbox.checked == true) {
        campo.type = 'text'
    } else {
        campo.type = 'password'
    }
}