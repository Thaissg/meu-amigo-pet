<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Meu amigo pet</title>
    <link rel="stylesheet" href="<?= BASEPATH ?>public/css/style.css" />
    <link rel="stylesheet" href="<?= BASEPATH ?>public/css/style-editarPet.css" />
    <?php
    include ('head.php');
    ?>
</head>

<body>
    <main>
        <div class="header">
            <?php
            if (isset($_SESSION['user'])) {
                include ('headerLogado.php');
            } else {
                include ('header.php');
            }
            ;
            ?>
        </div>
        <section id="form">
            <h1 class="form__title">EDITAR CADASTRO</h1>
            <?php $petId = explode('?', $_SERVER['REQUEST_URI'])[1];
            use App\Database;

            $con = Database::getConnection();
            $stm = $con->prepare('SELECT * FROM pets WHERE id = :idPet AND idResponsavel = :idResponsavel;');
            $stm->bindValue(':idPet', $petId);
            $stm->bindValue(':idResponsavel', $_SESSION['user']->__get('id'));
            $stm->execute();
            $pet = $stm->fetch();
            if (!$pet) {
                header('Location: ' . BASEPATH . "home?mensagem=Usuário não é responsável por esse pet!");
            }
            ?>
            <form method="POST" id="editarPet__Form" class="editarPet__Form" enctype="multipart/form-data">
                <div>
                    <div class="emLinha">
                        <label for="idPet">ID</label>
                        <input class="readonly" type="text" name="idPet" value=<?= $petId ?> readonly="readonly">
                    </div>
                    <div class="emLinha">
                        <label for="nome">NOME/APELIDO </label>
                        <input required type="text" name="nome" id="nome" value=<?= $pet['nome'] ?>>
                    </div>
                    <div>
                        <p>ANIMAL CASTRADO</p>
                        <div class="emLinha">
                            <?php if ($pet['castrado'] == "S") { ?>
                                <?= "<div class='emLinha'><input required type='radio' name='castrado' title='castrado'
                                value='S' onclick='mostrarForneceCastracao(this)' checked='checked'>
                        <label for='castrado'>Sim</label></div>
                        <div class='emLinha'><input required type='radio' name='castrado' title='castrado'
                                value='N' onclick='mostrarForneceCastracao(this)'>
                        <label for='castrado'>Não</label></div>"
                                    ?>
                                <?php
                            } else { ?>
                                <?= "<div class='emLinha'><input required type='radio' name='castrado' title='castrado'
                                value='S' onclick='mostrarForneceCastracao(this)'>
                        <label for='castrado'>Sim</label></div>
                        <div class='emLinha'><input required type='radio' name='castrado' title='castrado'
                                value='N' onclick='mostrarForneceCastracao(this)' checked='checked'>
                        <label for='castrado'>Não</label></div>"
                                    ?>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <div class="linhaDivisoria"></div>
                </div>
                <div>
                    <h1>DOENÇAS EM TRATAMENTO</h1>
                </div>
                <?php
                $stm = $con->prepare('SELECT nomeDoenca FROM doencasPet WHERE idPet = :idPet');
                $stm->bindValue(':idPet', $petId);
                $stm->execute();
                $doencas = $stm->fetchAll();
                $nomeDoencas = [];
                foreach ($doencas as $doenca) {
                    array_push($nomeDoencas, $doenca[0]);
                    echo($doenca[0]);
                }
                ?>


                <div class="doencas">
                    <div class='emLinha'>
                        <?php
                        if (in_array("Erlichiose (doença do carrapato)", $nomeDoencas)) {
                            $checked = "checked";
                        } else {
                            $checked = "";
                        } ?>
                        <input type="checkbox" name="doencas[]" title="doencas[]"
                            value="Erlichiose (doença do carrapato)" <?= $checked ?>>
                        <label for="doencas[]">Erlichiose (doença do carrapato)</label>
                    </div>

                    <?php if (in_array("Insuficiência renal", $nomeDoencas)) {
                        $checked = "checked";
                    } else {
                        $checked = "";
                    } ?>
                    <div class='emLinha'><input type="checkbox" name="doencas[]" title="doencas[]"
                            value="Insuficiência renal" <?= $checked ?>>
                        <label for="doencas[]">Insuficiência renal</label>
                    </div>

                    <?php if (in_array("Cinomose", $nomeDoencas)) {
                        $checked = "checked";
                    } else {
                        $checked = "";
                    }
                    ?>
                    <div class='emLinha'>
                        <input type="checkbox" name="doencas[]" title="doencas[]" value="Cinomose" <?= $checked ?>>
                        <label for="doencas[]">Cinomose</label>
                    </div>

                    <?php if (in_array("Leishmaniose", $nomeDoencas)) {
                        $checked = "checked";
                    } else {
                        $checked = "";
                    }
                    ?>
                    <div class='emLinha'>
                        <input type="checkbox" name="doencas[]" title="doencas[]" value="Leishmaniose" <?= $checked ?>>
                        <label for="doencas[]">Leishmaniose</label>
                    </div>


                    <?php if (in_array("FIV", $nomeDoencas)) {
                        $checked = "checked";
                    } else {
                        $checked = "";
                    }
                    ?>
                    <div class='emLinha'>
                        <input type="checkbox" name="doencas[]" title="doencas[]" value="FIV" <?= $checked ?>>
                        <label for="doencas[]">FIV</label>
                    </div>


                    <?php if (in_array("FELV", $nomeDoencas)) {
                        $checked = "checked='checked'";
                    } else {
                        $checked = "";
                    }
                    ?>
                    <div class='emLinha'>
                        <input type="checkbox" name="doencas[]" title="doencas[]" value="FELV" <?= $checked ?>>
                        <label for="doencas[]">FELV</label>
                    </div>

                    <?php if (in_array("Raiva", $nomeDoencas)) {
                        $checked = "checked='checked'";
                    } else {
                        $checked = "";
                    }
                    ?>
                    <div class='emLinha'>
                        <input type="checkbox" name="doencas[]" title="doencas[]" value="Raiva" <?= $checked ?>>
                        <label for="doencas[]">Raiva</label>
                    </div>


                    <?php if (in_array("Escabiose (Sarna)", $nomeDoencas)) {
                        $checked = "checked='checked'";
                    } else {
                        $checked = "";
                    }
                    ?>
                    <div class='emLinha'>
                        <input type="checkbox" name="doencas[]" title="doencas[]" value="Escabiose (Sarna)" <?= $checked ?>>
                        <label for="doencas[]">Escabiose(Sarna)</label>
                    </div>
                </div>

                <div class="emLinha">
                    <label for="custoMensal">CUSTO MENSAL R$</label>
                    <input type="text" size="12" onkeyup="mascaraMoeda(event)" name="custoMensal" id="custoMensal"
                        value=<?= $pet['custoMensal'] ?>>
                </div>

                <div class="linhaDivisoria"></div>

                <div>
                    <?php
                    if ($pet['historia'] == "") {
                        $historia = "Descreva o resgate e as principais características do pet";
                    } else {
                        $historia = $pet['historia'];
                    }
                    ?>
                    <h1>HISTÓRIA</h1>
                    <textarea name="historia" id="historia" cols="30" rows="10" placeholder=<?= $historia ?>><?= $pet['historia'] ?></textarea>
                </div>
                <?php $foto = explode('/', $pet['foto']);
                $foto = $foto[count($foto) - 1];
                if ($foto == "") {
                    $foto = 'foto_padrao.png';
                }
                ?>
                <div class="emLinha foto">
                    <label for="foto">FOTO DO PET </label>
                    <input oninput="testarImg(), removerFotoAnterior('')" type="file" name="foto" id="foto"
                        accept="image/png, image/jpeg">
                </div>
                <span class="invisible invalido" id="fotoError"></span>
                <img class='foto-pet' id='foto-pet' src="<?= BASEPATH ?>app/uploads/<?= $foto ?>"
                    alt="Foto do pet <?= $pet['nome'] ?>">


                <div class="emLinha botoes">
                    <button class="btn" type="submit" id="enviar">SALVAR</button>
                    <button class="btn" type="button"><a href="<?= BASEPATH ?>home">CANCELAR</a></button>
                </div>

            </form>
        </section>
    </main>
    <script type="module" src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons/ionicons.esm.js"></script>
    <script src="https://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="<?= BASEPATH ?>public/js/editarPet.js"></script>
    <script src="<?= BASEPATH ?>public/js/app.js"></script>
    <script src="<?= BASEPATH ?>public/js/alertas.js"></script>
</body>

</html>