<link rel="stylesheet" href="<?= BASEPATH ?>public/css/style-header.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">
<nav>
    <input type="checkbox" id="check" title="check">
    <label for="check" class="checkbtn">
        <i class="fas fa-bars"></i>
    </label>
    <ul>
        <li>
            <a id="home" class="header" href="<?= BASEPATH ?>home" onclick="ativar(this.id)"><img class="img-header"
                    src="<?= BASEPATH ?>public/images/home-outline.svg" alt="icone de casa">
                <p class="item-header">HOME</p>
            </a>
        </li>
        <li>
            <a id="adote" class="header" href="<?= BASEPATH ?>adote" onclick="ativar(this.id)"><img class="img-header"
                    src="<?= BASEPATH ?>public/images/heart-outline.svg" alt="icone de coração">
                <p class="item-header">ADOTE</p>
            </a>
        </li>
        <li>
            <a id="ongs-protetores" class="header" href="<?= BASEPATH ?>ongs-e-protetoras"
                onclick="ativar(this.id)"><img class="img-header" src="<?= BASEPATH ?>public/images/hand.png"
                    alt="icone de mão">
                <p class="item-header">ONGs E PROTETORES</p>
            </a>
        </li>
        <li>
            <a class="header" href="<?= BASEPATH ?>logout" onclick="ativar(this.id)"><img class="img-header"
                    src="<?= BASEPATH ?>public/images/log-out-outline.svg" alt="icone de logout">
            <p class="item-header">SAIR</p></a>
        </li>
    </ul>
</nav>