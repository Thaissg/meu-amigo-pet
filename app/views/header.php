<link rel="stylesheet" href="<?= BASEPATH ?>public/css/style-header.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">
<nav>
    <input type="checkbox" id="check" title="check">
    <label for="check" class="checkbtn">
        <i class="fas fa-bars"></i>
    </label>
    <ul>
        <li>
            <a id="home" class="" href="<?= BASEPATH ?>home" onclick="ativar(this.id)"><img class="img-header"
                    src="<?= BASEPATH ?>public/images/home-outline.svg" alt="icone de casa"><p class="item-header">HOME</p></a>
        </li>
        <li>
            <a id="adote" class="" href="<?= BASEPATH ?>adote" onclick="ativar(this.id)"><img class="img-header"
                    src="<?= BASEPATH ?>public/images/heart-outline.svg" alt="icone de coração"><p class="item-header">ADOTE</p></a>
        </li>
        <li>
            <a id="ongs-protetores" class="" href="<?= BASEPATH ?>ongs-e-protetoras" onclick="ativar(this.id)"><img
                    class="img-header" src="<?= BASEPATH ?>public/images/hand.png" alt="icone de mão"><p class="item-header">ONGs E PROTETORES</p></a>
        </li>
        <li>
            <a id="login" class="login" href="<?= BASEPATH ?>login" onclick="ativar(this.id)"><ion-icon
                    class="icone-login" name="person-circle-outline"></ion-icon><p class="item-header">LOGIN</p></a>
        </li>
    </ul>
</nav>