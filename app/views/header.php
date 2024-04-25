<link rel="stylesheet" href="<?= BASEPATH ?>public/css/style-header.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">
<nav>
    <input type="checkbox" id="check" title="check">
    <label for="check" class="checkbtn">
        <i class="fas fa-bars"></i>
    </label>
    <ul>
        <li><a id="home" class="" href="<?= BASEPATH ?>home" onclick="ativar(this.id)">HOME</a></li>
        <li><a id="adote" class="" href="<?= BASEPATH ?>adote" onclick="ativar(this.id)">ADOTE</a></li>
        <li><a id="ongs-protetores" class="" href="<?= BASEPATH ?>ongs-e-protetoras" onclick="ativar(this.id)">ONGs E
                PROTETORES</a></li>
        <li><a id="login" class="login" href="<?= BASEPATH ?>login" onclick="ativar(this.id)">
                LOGIN<ion-icon class="icone-login" name="person-circle-outline"></ion-icon>
            </a></li>
    </ul>
</nav>