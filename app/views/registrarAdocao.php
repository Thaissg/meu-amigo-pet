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
            <h1 class="form__title">Registrar Adoção</h1>
            <?php $petId = explode('?', $_SERVER['REQUEST_URI'])[1];
            use App\Database;
            use App\Models\Usuario;

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
            <form id="registrarAdocao__Form" class="registrarAdocao__Form" method="POST">
                <div class='pets'>
                    <?php
                    $foto = explode('/', $pet['foto']);
                    $foto = $foto[count($foto) - 1];
                    if ($foto == "") {
                        $foto = 'foto_padrao.png';
                    }
                    if ($pet['genero'] == 'M') {
                        $genero = 'Macho';
                    } else {
                        $genero = 'Fêmea';
                    }
                    if ($pet['castrado'] == 'S') {
                        $castrado = 'Sim';
                    } else {
                        $castrado = 'Não';
                    }
                    ?>
                    <table>
                        <tr>
                            <td>
                                <img class='foto-pet' src="<?= BASEPATH ?>app/uploads/<?= $foto ?>"
                                    alt="Foto do pet <?= $pet['nome'] ?>">
                                <p>Nome:
                                    <?= $pet['nome'] ?>
                                </p>
                                <p>Gênero:
                                    <?= $genero ?>
                                </p>
                                <p>Castrado:
                                    <?= $castrado ?>
                                </p>
                                <?php
                                if ($pet['forneceCastracao'] != "") {
                                    if ($pet['forneceCastracao'] == 'S') {
                                        $forneceCastracao = 'Sim';
                                    } else {
                                        $forneceCastracao = 'Não';
                                    }
                                    ?>
                                    <?= "<p>Fornece Castração: " . $forneceCastracao . ' </p>' ?>
                                    <?php
                                }
                                ?>
                                <p>Espécie:
                                    <?= $pet['especie'] ?>
                                </p>
                                <?php if ($pet['dataNascimento'] != "") { ?>
                                    <?= "<p id='dataNascimento'> Data de nacimento: " . $pet['dataNascimento'] . ' </p>' ?>
                                <?php } ?>
                                <p id='dataResgate'>Data do resgate:
                                    <?= $pet['dataResgate'] ?>
                                </p>
                                <?php if ($pet['custoMensal'] != "") { ?>
                                    <?= "<p> Custo mensal: " . $pet['custoMensal'] . ' </p>' ?>
                                <?php } ?>
                                <?php if ($pet['historia'] != "") { ?>
                                    <?= "<p> História: " . $pet['historia'] . ' </p>' ?>
                                <?php } ?>
                            </td>
                        </tr>
                    </table>
                </div>
                <fieldset class="Dados">
                    <table>
                        <tbody>
                            <tr>
                                <td>
                                    <label for="id">ID</label>
                                    <input class="readonly" type="text" name="id" value=<?= $petId ?>
                                        readonly="readonly">
                                </td>
                            </tr>
                            <?php
                            $stm = $con->prepare('SELECT cpf_cnpj FROM usuarios WHERE tipo = :tipo;');
                            $stm->bindValue(':tipo', 'adotante');
                            $stm->execute();
                            $usuariosDoc = $stm->fetchAll();
                            ?>
                            <tr>
                                <td>
                                    <div class='emLinha'>
                                        <label for="adotante">CPF/CNPJ do adotante:</label>
                                        <input required type="text" name="cpf-cnpj" id="cpf-cnpj"
                                            onkeyup="docMaskEvent(event)"
                                            onchange="testaDocumento(this.value,['<?=implode('\',\'',$usuariosDoc[0])?>'])">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div id="validaDoc" class="alert invalido invisible"></div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div id="adotante">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class='emLinha' id='dadosAdotante'></div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="invisible invalido" id="cpfError"></span>
                                </td>
                            </tr>

                            <!-- futuramente adicionar uma opção para fazer o download do termo de adoção -->
                        </tbody>
                    </table>

                    <table class="centralizado">
                        <tr>
                            <td class="centralizado">
                                <button class="btn" type="submit" id="enviar"
                                    onclick="return confirm('Confirma a doação do pet?')">Salvar</button>
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
    <script src="<?= BASEPATH ?>public/js/app.js"></script>
    <script src="<?= BASEPATH ?>public/js/alertas.js"></script>
    <script src="<?= BASEPATH ?>public/js/doacaoPet.js"></script>
</body>

</html>