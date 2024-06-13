<link rel="stylesheet" href="<?= BASEPATH ?>public/css/style-menuLateral.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">


<div class="filtro__form">
    <?php
    if (isset($_SESSION['user'])) {
        ?>
        <div class="opcoes">
            <a href="">EDITAR PERFIL</a>
            <?php if ($_SESSION['user']->__get('tipo')=='doador') {?>
            <a class="cadastrarPet" href="<?= BASEPATH ?>cadastroPet">CADASTRAR ANIMAL</a>
            <a href="">REGISTRAR DEVOLUÇÃO</a>
            <?php } ?>
        </div>
        <?php
    } ?>
    <form method="POST" class="filtro__form">
        <div class="div-icone-funil">
            <img class="icone-funil" src="<?= BASEPATH ?>public/images/funnel-outline.svg" alt="Icone de funil">
        </div>
        <div class="itens-form-filtro">
            <div class="genero">
                <label for="genero">GÊNERO: </label>
                <select class="custom-select" name="genero" id="genero">
                    <option value="">Selecione</option>
                    <option value="M">Macho</option>
                    <option value="F">Fêmea</option>
                </select>
            </div>
            <div class="especie">
                <label for="especie">ESPÉCIE: </label>
                <select class="custom-select" name="especie" id="especie">
                    <option value="">Selecione</option>
                    <option value="Cachorro">Cachorro</option>
                    <option value="Gato">Gato</option>
                </select>
            </div>

        </div>
        <button class="filtrar-btn" type="submit">FILTRAR</button>
    </form>
</div>