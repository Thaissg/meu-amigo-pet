
if ("serviceWorker" in navigator) {
  window.addEventListener("load", function () {
    navigator.serviceWorker
      .register("/meu-amigo-pet/public/js/serviceWorker.js")
      .then(res => console.log("service worker registered"))
      .catch(err => console.log("service worker not registered", err))
  })
}


function autoSaveRadioSelection(radioname) {
  //Carrega o valor salvo
  var selectedValue = localStorage.getItem(radioname);
  //Busca os radio boxes
  var radioboxes = document.getElementsByName(radioname);

  function saveStatus() {
    //Grava o valor do radio selecionado
    localStorage.setItem(this.name, this.value);
  };

  //Navega pelos radios existentes
  for (key in radioboxes) {
    radio = radioboxes[key];
    //vincula o evento de alteração a função que salva o valor
    radio.onchange = saveStatus;
    //Marca ou não o radio comparando seu valor com o valor salvo
    radio.checked = selectedValue == radio.value;
  };
}
autoSaveRadioSelection('tipo_cadastro');

