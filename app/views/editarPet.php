<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Meu amigo pet</title>
    <link rel="stylesheet" href="<?= BASEPATH ?>public/css/style.css" />
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
            <h1 class="form__title">Editar cadastro</h1>
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
                <fieldset class="Dados">
                    <table>
                        <tbody>
                            <tr>
                                <td>
                                    <label for="idPet">ID</label>
                                    <input class="readonly" type="text" name="idPet" value=<?=$petId?> readonly="readonly">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="nome">Nome/apelido</label>
                                    <input required type="text" name="nome" id="nome" value=<?= $pet['nome'] ?>>
                                </td>
                            </tr>
                            <tr class="cadastroPet">
                                <td>
                                    <fieldset class="Castrado">
                                        <table>
                                            <tbody>
                                                <legend>Animal castrado?</legend>
                                                <tr>
                                                    <?php if ($pet['castrado'] == "S") { ?>
                                                        <?= "<td><input required type='radio' name='castrado' title='castrado'
                                                            value='S' onclick='mostrarForneceCastracao(this)' checked='checked'>
                                                    <label for='castrado'>Sim</label></td>
                                                    <td><input required type='radio' name='castrado' title='castrado'
                                                            value='N' onclick='mostrarForneceCastracao(this)'>
                                                    <label for='castrado'>Não</label></td>"
                                                            ?>
                                                        <?php
                                                    } else { ?>
                                                        <?= "<td><input required type='radio' name='castrado' title='castrado'
                                                            value='S' onclick='mostrarForneceCastracao(this)'>
                                                    <label for='castrado'>Sim</label></td>
                                                    <td><input required type='radio' name='castrado' title='castrado'
                                                            value='N' onclick='mostrarForneceCastracao(this)' checked='checked'>
                                                    <label for='castrado'>Não</label></td>"
                                                            ?>
                                                        <?php
                                                    }
                                                    ?>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </fieldset>
                                    <fieldset id="forneceCastracao" class="invisible"></fieldset>
                                </td>
                            </tr>                            
                            <tr class="cadastroPet">
                                <td>
                                    <fieldset>
                                        <table>
                                            <tbody>
                                                <legend>Doenças em tratamento (opcional)</legend>

                                                <?php
                                                $stm = $con->prepare('SELECT nomeDoenca FROM doencasPet WHERE idPet = :idPet');
                                                $stm->bindValue(':idPet', $petId);
                                                $stm->execute();
                                                $doencas = $stm->fetchAll();
                                                $nomeDoencas = [];
                                                foreach ($doencas as $doenca){
                                                    array_push($nomeDoencas,$doenca[0]);
                                                }
                                                ?>
                                                <tr>
                                                    <td>
                                                        <div class='emLinha'>
                                                            <input type="checkbox" name="doencas[]" title="doencas[]"
                                                                value="Erlichiose (doença do carrapato)"
                                                                <?php if (in_array("Erlichiose (doença do carrapato)",$nomeDoencas)){
                                                                    ?>
                                                                    <?= "checked='checked'"?>
                                                                    <?php
                                                                }
                                                                ?>
                                                                >
                                                            <label for="doencas[]">Erlichiose (doença do
                                                                carrapato)</label>
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <div class='emLinha'><input type="checkbox" name="doencas[]"
                                                                title="doencas[]" value="Insuficiência renal"
                                                                <?php if (in_array("Insuficiência renal",$nomeDoencas)){
                                                                    ?>
                                                                    <?= "checked='checked'"?>
                                                                    <?php
                                                                }
                                                                ?>
                                                                >
                                                            <label for="doencas[]">Insuficiência renal</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class='emLinha'>
                                                            <input type="checkbox" name="doencas[]" title="doencas[]"
                                                                value="Cinomose"
                                                                <?php if (in_array("Cinomose",$nomeDoencas)){
                                                                    ?>
                                                                    <?= "checked='checked'"?>
                                                                    <?php
                                                                }
                                                                ?>
                                                                >
                                                            <label for="doencas[]">Cinomose</label>
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <div class='emLinha'>
                                                            <input type="checkbox" name="doencas[]" title="doencas[]"
                                                                value="Leishmaniose"
                                                                <?php if (in_array("Leishmaniose",$nomeDoencas)){
                                                                    ?>
                                                                    <?= "checked='checked'"?>
                                                                    <?php
                                                                }
                                                                ?>
                                                                >
                                                            <label for="doencas[]">Leishmaniose</label>
                                                        </div>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class='emLinha'>
                                                            <input type="checkbox" name="doencas[]" title="doencas[]"
                                                                value="FIV"
                                                                <?php if (in_array("FIV",$nomeDoencas)){
                                                                    ?>
                                                                    <?= "checked='checked'"?>
                                                                    <?php
                                                                }
                                                                ?>
                                                                >
                                                            <label for="doencas[]">FIV</label>
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <div class='emLinha'>
                                                            <input type="checkbox" name="doencas[]" title="doencas[]"
                                                                value="FELV"
                                                                <?php if (in_array("FELV",$nomeDoencas)){
                                                                    ?>
                                                                    <?= "checked='checked'"?>
                                                                    <?php
                                                                }
                                                                ?>
                                                                >
                                                            <label for="doencas[]">FELV</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class='emLinha'>
                                                            <input type="checkbox" name="doencas[]" title="doencas[]"
                                                                value="Raiva"
                                                                <?php if (in_array("Raiva",$nomeDoencas)){
                                                                    ?>
                                                                    <?= "checked='checked'"?>
                                                                    <?php
                                                                }
                                                                ?>
                                                                >
                                                            <label for="doencas[]">Raiva</label>
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <div class='emLinha'>
                                                            <input type="checkbox" name="doencas[]" title="doencas[]"
                                                                value="Escabiose (Sarna)"
                                                                <?php if (in_array("Escabiose (Sarna)",$nomeDoencas)){
                                                                    ?>
                                                                    <?= "checked='checked'"?>
                                                                    <?php
                                                                }
                                                                ?>
                                                                >
                                                            <label for="doencas[]">Escabiose (Sarna)</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </fieldset>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="custoMensal">Custo Mensal (opcional) R$ </label>
                                    <input type="text" size="12" onkeyup="mascaraMoeda(event)" name="custoMensal"
                                        id="custoMensal" value=<?= $pet['custoMensal'] ?>>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="emLinha">
                                        <label for="historia">História (opcional)</label>
                                        <textarea name="historia" id="historia" cols="30" rows="10"
                                            placeholder="Utilize este campo para descrever um pouco o resgate do pet e algumas características dele"><?= $pet['historia'] ?></textarea>
                                    </div>
                                </td>
                            </tr>
                            <?php $foto = explode('/', $pet['foto']);
                            $foto = $foto[count($foto) - 1];
                            if ($foto == "") {
                                $foto = 'foto_padrao.png';
                            }
                            ?>
                            <tr>
                                <td>
                                    <div class="emLinha">
                                        <label for="foto">Foto do pet (opcional)</label>
                                        <input oninput="testarImg(), removerFotoAnterior('')" type="file" name="foto"
                                            id="foto" accept="image/png, image/jpeg">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="invisible invalido" id="fotoError"></span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <img class='foto-pet' id='foto-pet' src="<?= BASEPATH ?>app/uploads/<?= $foto ?>"
                                        alt="Foto do pet <?= $pet['nome'] ?>">
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="centralizado">
                        <tr>
                            <td class="centralizado">
                                <button class="btn" type="submit" id="enviar">Salvar</button>
                            </td>
                            <td class="centralizado">
                                <button class="btn" type="button"><a href="<?= BASEPATH ?>home">Cancelar</a></button>
                            </td>
                        </tr>
                    </table>
                </fieldset>
            </form>
        </section>
    </main>
    <script type="module" src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons/ionicons.esm.js"></script>
    <script src="https://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="<?= BASEPATH ?>public/js/cadastroPet.js"></script>
    <script src="<?= BASEPATH ?>public/js/app.js"></script>
    <script src="<?= BASEPATH ?>public/js/alertas.js"></script>
</body>

</html>