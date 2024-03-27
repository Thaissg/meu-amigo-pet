<link rel="stylesheet" href="<?= BASEPATH ?>public/css/style-header.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">
<nav>
    <input type="checkbox" id="check" title="check" onchange="ocultarIcones()">
    <label for="check" class="checkbtn">
        <i class="fas fa-bars"></i>
    </label>
    <label class="logo">
        <img class="logo" src="<?= BASEPATH ?>public/images/Logo Meu amigo pet.png" alt="Logo Meu amigo pet">
    </label>
    <ul>
        <li><a id="home" class="" href="<?= BASEPATH ?>home" onclick="ativar(this.id)"> Home </a></li>
        <li><a id="adote" class="" href="<?= BASEPATH ?>adote" onclick="ativar(this.id)">Adote</a></li>
        <li><a id="ongs-protetores" class="" href="<?= BASEPATH ?>ongs-e-protetoras" onclick="ativar(this.id)">ONGs e
                Protetores(as)</a></li>
        <li><a href="<?= BASEPATH ?>logout" onclick="ativar(this.id)">Sair</a></li>
    </ul>
</nav>
<script>
    function ocultarIcones() {
        check = document.getElementById('check');
        icones = document.getElementsByClassName('icones');
        if (check.checked) {
            for (i = 0; i < icones.length; i++){
                icones[i].style.visibility = "hidden";
            }
        } else {
            for (i = 0; i < icones.length; i++){
                icones[i].style.visibility = "visible";
            }
        }
    }
</script>