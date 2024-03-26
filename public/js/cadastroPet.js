const cadastroForm = document.getElementById("cadastroPet__form");

cadastroForm.addEventListener("submit", validate);

function validate(e) {
    e.preventDefault();
    if (testarData()&&testarImg()) {
        e.target.submit();
    } else {
        alert("Verifique os campos!")
    }
    return testarData();
}

function reverseString(str) {
    var newString = "";
    for (var i = str.length - 1; i >= 0; i--) {
        newString += str[i];
    }
    return newString;
}

function mascaraMoeda(evento) {
    let input = evento.target;
    var valor = input.value;
    if (valor.length == 1) {
        input.value = "0,0" + valor;
    } else {
        zeroEsquerda = true;
        while (zeroEsquerda) {
            i = 0;
            if (valor[i] == "0") {
                valor = valor.substring(1, valor.length)
            } else {
                zeroEsquerda = false
            }

        }
        valor = reverseString(valor.replace(/[^\d]+/gi, ''));
        var resultado = "";
        var mascara = reverseString("##.###.###,##");
        for (var x = 0, y = 0; x < mascara.length && y < valor.length;) {
            if (mascara.charAt(x) != '#') {
                resultado += mascara.charAt(x);
                x++;
            } else {
                resultado += valor.charAt(y);
                y++;
                x++;
            }
        }
        input.value = reverseString(resultado);
    }

}

function testarData() {
    dataNascimento = document.getElementById("dataNascimento");
    dataResgate = document.getElementById("dataResgate");
    erro = document.getElementById("dataError");
    dataNascimentoValor = dataNascimento.value;
    dataResgateValor = dataResgate.value;
    if (dataResgateValor != "") {
        dataResgateValor = dataResgateValor.split("-");
        for (i = 0; i < dataResgateValor.length; i++) {
            dataResgateValor[i] = parseInt(dataResgateValor[i]);
        }
        dataResgateValor = new Date(dataResgateValor[0], dataResgateValor[1] - 1, dataResgateValor[2]);
        if (Date.now() - dataResgateValor.valueOf() < 0) {
            erro.classList.remove("invisible");
            dataNascimento.classList.add("invalid");
            dataResgate.classList.add("invalid");
            erro.classList.add("visible");
            erro.innerHTML = "A data do resgate não pode ser data futura";
            return false;
        }
        if (dataNascimentoValor != "") {
            dataNascimentoValor = dataNascimentoValor.split("-");
            for (i = 0; i < dataNascimentoValor.length; i++) {
                dataNascimentoValor[i] = parseInt(dataNascimentoValor[i]);
            }
            dataNascimentoValor = new Date(dataNascimentoValor[0], dataNascimentoValor[1] - 1, dataNascimentoValor[2]);
            if (Date.now() - dataNascimentoValor.valueOf() < 0) {
                erro.classList.remove("invisible");
                dataNascimento.classList.add("invalid");
                dataResgate.classList.add("invalid");
                erro.classList.add("visible");
                erro.innerHTML = "A data do nascimento não pode ser data futura";
                return false;
            } else if (dataResgateValor.valueOf()- dataNascimentoValor.valueOf() < 0) {
                erro.classList.remove("invisible");
                dataNascimento.classList.add("invalid");
                dataResgate.classList.add("invalid");
                erro.classList.add("visible");
                erro.innerHTML = "A data do resgate não pode ser anterior a data de nascimento";
                return false;
            }
        }
    }
    erro.classList.add("invisible");
    erro.classList.remove("visible");
    dataNascimento.classList.remove("invalid");
    dataResgate.classList.remove("invalid");
    erro.innerHTML = "";
    return true;
}


function mostrarForneceCastracao(radio) {
    const forneceCast = document.getElementById("forneceCastracao");
    const table = "";
    if (radio.value == "N") {
        forneceCast.innerHTML = "<table><tbody><legend>Fornece castração?</legend><tr><td><input required type='radio' name='forneceCastracao' title='forneceCastracao' value='S'></input></td><td><label for='forneceCastracao'>Sim</label></td><td><input required type='radio' name='forneceCastracao' title='forneceCastracao' value='N'></input></td><td><label for='forneceCastracao'>Não</label></td></tr></tbody></table>";
        forneceCast.classList.remove("invisible");
    } else {
        forneceCast.classList.add("invisible");
        forneceCast.innerHTML = "";
    }
}

function testarImg() {
    const foto =  document.getElementById("foto");
    erro = document.getElementById("fotoError");
    if(foto.files[0].size > 2097152){
        erro.classList.remove("invisible");
        foto.classList.add("invalid");
        erro.classList.add("visible");
        erro.innerHTML = "A imagem não pode ser maior do que 2Mb";
        return false;
    } else {
        erro.classList.add("invisible");
        erro.classList.remove("visible");
        foto.classList.remove("invalid");
        erro.innerHTML = "";
        return true;
    }
}