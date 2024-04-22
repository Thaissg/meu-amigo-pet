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
var docUsuarios = []

function testaDocumento(value,usuariosDoc) {
    docUsuarios = usuariosDoc;
    if (value == "") {
        $("#validaDoc").html("É necessário preencher o número do CPF/CNPJ");
        $("#validaDoc").removeClass("invisible")
        return false
    }
    strDoc = String(value).replace(/\D/g, "")
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
        $("#validaDoc").removeClass("invisible");
    } else {
        if (usuariosDoc.includes(value)){
            $("#validaDoc").html("");
            $("#validaDoc").addClass("invisible");
        } else {
            $("#validaDoc").html("CPF/CNPJ não está cadastrado como adotante. \nSolicitar ao adotante que realize o cadastro.");
            $("#validaDoc").removeClass("invisible");
        }
        
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


const cadastroForm = document.getElementById("registrarAdocao__Form");

cadastroForm.addEventListener("submit", validate);

function validate(e) {
    e.preventDefault();

    const documento = document.getElementById("cpf-cnpj");
    let valid = true;

    if (!testaDocumento(documento.value,docUsuarios)) {
        documento.classList.add("invalid");
        valid = false;
    } else {
        documento.classList.remove("invalid");
    }
    if (valid == true) {
        e.target.submit();
    } else {
        alert("Preencha os campos corretamente!")
    }
    return valid;
}