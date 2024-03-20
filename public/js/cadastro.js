function testaDocumento(strDoc) {
    if (strDoc == "") {
        $("#validaDoc").html("É necessário preencher o número do CPF/CNPJ");
        return false
    }
    strDoc = String(strDoc).replace(/\D/g, "")
    var teste
    if (strDoc.length == 14) {
        teste = testaCNPJ(strDoc);
    } else if (strDoc.length == 11) {
        teste = testaCPF(strDoc);
    } else {
        teste = false
    }
    if (teste == false) {
        $("#validaDoc").html("CPF/CNPJ inválido");
    } else {
        $("#validaDoc").html("");
    }
    return teste
}

function testaCPF(strCPF) {
    var Soma;
    var Resto;
    Soma = 0;
    if (strCPF == "00000000000") return false;

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


function testaCNPJ(cnpj) {
    var b = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2]
    var c = String(cnpj).replace(/\D/g, "")

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


const telMaskEvent = (event) => {
    let input = event.target
    input.value = telMask(input.value)
}

const telMask = (value) => {
    if (!value) return ""
    value = value.replace(/\D/g, '')
    value = value.replace(/(\d{2})(\d)/, "($1) $2")
    value = value.replace(/(\d)(\d{4})$/, "$1-$2")
    return value
}

const docMaskEvent = (event) => {
    let input = event.target
    input.value = docMask(input.value)
}

const docMask = (value) => {
    if (!value) return ""
    if (value.length < 15) {
        value = value.replace(/\D/g, '')
        value = value.replace(/(\d{3})(\d)/, "$1.$2")
        value = value.replace(/(\d{3})(\d)/, "$1.$2")
        value = value.replace(/(\d{3})(\d{1,2})$/, "$1-$2")
    } else {
        value = value.replace(/\D/g, "")
        value = value.replace(/^(\d{2})(\d)/, "$1.$2")
        value = value.replace(/^(\d{2})\.(\d{3})(\d)/, "$1.$2.$3")
        value = value.replace(/\.(\d{3})(\d)/, ".$1/$2")
        value = value.replace(/(\d{4})(\d)/, "$1-$2")
    }

    return value
}


const cepMaskEvent = (event) => {
    let input = event.target
    input.value = cepMask(input.value)
}

const cepMask = (value) => {
    if (!value) return ""
    value = value.replace(/\D/g, '')
    value = value.replace(/(\d{5})(\d)/, "$1-$2")
    return value
}


function testaEmail(email) {
    var re = /\S+@\S+\.\S+/;
    if (re.test(email)) {
        $("#validaEmail").html("");
        return true
    } else {
        $("#validaEmail").html("Email inválido");
        return false
    }
}

function testaSenha(senha) {
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

function testaConfSenha(confSenha) {
    senha = document.getElementById('senha').value
    if (confSenha == senha) {
        $('#validaConf').html("");
        return true
    } else {
        $('#validaConf').html("As senhas não conferem");
        return false
    }
}

function mostrarSenha(entrada, checkbox) {
    campo = document.getElementById(entrada)
    if (checkbox.checked == true) {
        campo.type = 'text'
    } else {
        campo.type = 'password'
    }
}

function testaTelefone(tel) {
    tel = String(tel).replace(/\D/g, "");
    if (tel == ""){
        $("#validaTelefone").html("É necessário preencher o número do telefone");
        return false;
    } else if (tel.length < 10 || tel.length > 11){
        $('#validaTelefone').html("Telefone deve conter 10 ou 11 dígitos.");
        $('#validaTelefone2').html("(Exemplo: (xx) xxxx-xxxx ou (xx) xxxxx-xxxx)");
        return false;
    } else {
        $('#validaTelefone').html("");
        $('#validaTelefone2').html("");
        return true;
    } 
}


const cadastroForm = document.getElementById("cadastro__form");

cadastroForm.addEventListener("submit", validate);

function validate(e) {
    e.preventDefault();

    const documento = document.getElementById("cpf-cnpj");
    const telefone = document.getElementById("tel");
    const email = document.getElementById("email");
    const cep = document.getElementById("cep");
    const senha = document.getElementById("senha");
    const confSenha = document.getElementById("conf-senha");
    let valid = true;

    if (!testaDocumento(documento.value)) {
        const documentError = document.getElementById("documentError");
        documentError.classList.add("visible");
        documento.classList.add("invalid");
        documentError.setAttribute("aria-hidden", false);
        documentError.setAttribute("aria-invalid", true);
        valid = false;
    } else {
        const documentError = document.getElementById("documentError");
        documentError.classList.remove("visible");
        documento.classList.remove("invalid");
        documentError.setAttribute("aria-hidden", true);
        documentError.setAttribute("aria-invalid", false);
    }
    if (!testaTelefone(telefone.value)){
        const phoneError = document.getElementById("phoneError");
        phoneError.classList.add("visible");
        telefone.classList.add("invalid");
        phoneError.setAttribute("aria-hidden", false);
        phoneError.setAttribute("aria-invalid", true);
        valid = false;
    } else {
        const phoneError = document.getElementById("phoneError");
        phoneError.classList.remove("visible");
        telefone.classList.remove("invalid");
        phoneError.setAttribute("aria-hidden", true);
        phoneError.setAttribute("aria-invalid", false);
    }
    if (!testaEmail(email.value)) {
        const emailError = document.getElementById("emailError");
        emailError.classList.add("visible");
        email.classList.add("invalid");
        emailError.setAttribute("aria-hidden", false);
        emailError.setAttribute("aria-invalid", true);
        valid = false;
    } else {
        const emailError = document.getElementById("emailError");
        emailError.classList.remove("visible");
        email.classList.remove("invalid");
        emailError.setAttribute("aria-hidden", true);
        emailError.setAttribute("aria-invalid", false);
    }
    if (valid==true){
        e.target.submit();
        alert("Usuario cadastrado com sucesso!")
    }
    return valid;
}