const exluirForm = document.getElementById("exluirPet__Form");

exluirForm.addEventListener("submit", validate);

function validate(e) {
    e.preventDefault();
    if (testarData()) {
        e.target.submit();
    } else {
        alert("Verifique os campos!")
    }
    return testarData();
}


function mostrarInputDataObito() {
    motivo = document.getElementById('motivo');
    if (motivo.value == 'obito') {
        dataObito = document.getElementById('divDataObito');
        dataObito.innerHTML = "<label for='dataObito'>Data do óbito</label><input required type='date' onchange='testarData()' name='dataObito' id='dataObito'>"
    } else {
        dataObito = document.getElementById('divDataObito');
        dataObito.innerHTML = ""
    }
}


function testarData() {
    dataResgate = document.getElementById("dataResgate").textContent;
    erro = document.getElementById("dataError");
    motivo = document.getElementById('motivo');
    if (motivo.value != 'obito') {
        return true
    } else {
        dataObito = document.getElementById("divDataObito");
        if (dataObito != null) {
            dataObitoValue = String(dataObito.value).split("-");
            for (i = 0; i < dataObitoValue.length; i++) {
                dataObitoValue[i] = parseInt(dataObitoValue[i]);
            }
            dataObitoValue = new Date(dataObitoValue[0], dataObitoValue[1] - 1, dataObitoValue[2]);
            if (Date.now() - dataObitoValue.valueOf() < 0) {
                erro.classList.remove("invisible");
                dataObito.classList.add("invalid");
                erro.classList.add("visible");
                erro.innerHTML = "A data do obito não pode ser data futura";
                return false;
            } else {
                dataResgate = dataResgate.split("\n")[1].split("-");
                for (i = 0; i < dataResgate.length; i++) {
                    dataResgate[i] = parseInt(dataResgate[i]);
                }
                dataResgate = new Date(dataResgate[0], dataResgate[1] - 1, dataResgate[2]);
            } 
            if (dataObitoValue.valueOf() - dataResgate.valueOf() < 0) {
                erro.classList.remove("invisible");
                dataObito.classList.add("invalid");
                erro.classList.add("visible");
                erro.innerHTML = "A data do óbito não pode ser anterior a data de resgate.<br>Data do resgate: " + dataResgate.getDate() + "/" + dataResgate.getMonth() + "/" + dataResgate.getFullYear();
                return false;
            }
        } else {
            erro.classList.remove("invisible");
            dataObito.classList.add("invalid");
            erro.classList.add("visible");
            erro.innerHTML = "É necessário preencher a data do óbito";
            return false;
        }
        erro.classList.add("invisible");
        erro.classList.remove("visible");
        dataObito.classList.remove("invalid");
        erro.innerHTML = "";
        return true;
    }
}