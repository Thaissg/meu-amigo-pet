const cadastroForm = document.getElementById("login__form");

cadastroForm.addEventListener("submit", validate);

function validate(e){
    e.preventDefault();
    const teste = document.getElementById("teste")
    teste.contains = "login";
    return false;
}
