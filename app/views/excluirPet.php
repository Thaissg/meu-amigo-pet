<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Meu amigo pet</title>
    <link rel="stylesheet" href="<?= BASEPATH ?>public/css/style.css" />
    <link rel="stylesheet" href="<?= BASEPATH ?>public/css/style-excluirPet.css" />
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
            $dataResgate = explode('-', $pet['dataResgate']);
            ?>
            <form method="POST" id="exluirPet__Form" class="exluirPet__Form">
                <div class="pet">
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
                    <div class="info-pet">
                        <h1 class="form__title">EXCLUIR PET</h1>
                        <p>NOME/APELIDO:
                            <?= mb_strtoupper($pet['nome'],'UTF-8') ?>
                        </p>
                        <p>GÊNERO:
                            <?= mb_strtoupper($genero,'UTF-8') ?>
                        </p>
                        <p>ESPÉCIE:
                            <?= mb_strtoupper($pet['especie'],'UTF-8') ?>
                        </p>
                        <p id='dataResgate'>DATA DE RESGATE:
                            <?= $dataResgate[2] . '/' . $dataResgate[1] . '/' . $dataResgate[0] ?>
                        </p>
                    </div>
                    <div class="fotoPet">
                        <img class='foto-pet' src="<?= BASEPATH ?>app/uploads/<?= $foto ?>"
                            alt="Foto do pet <?= $pet['nome'] ?>">
                    </div>
                </div>
                <div class="linhaDivisoria"></div>
                <div>
                    <div>
                        <label for="id">ID</label>
                        <input class="readonly" type="text" name="id" value=<?= $petId ?> readonly="readonly">
                    </div>
                    <div>
                        <div class='emLinha motivo'>
                            <label for="motivo">Qual motivo da exclusão?</label>
                            <select required name="motivo" id="motivo" onchange="mostrarInputDataObito()">
                                <option value=""></option>
                                <option value="obito">Óbito</option>
                                <option value="desaparecimento">Desaparecimento</option>
                                <option value="doacao">Doação por outro meio</option>
                            </select>
                        </div>
                        <div class='emLinha motivo' id='divDataObito'></div>
                        <span class="invisible invalido" id="dataError"></span>
                    </div>
                </div>
                <div class="emLinha botoes">
                    <button class="btn" type="button"><a href="<?= BASEPATH ?>home">CANCELAR
                        </a></button>
                    <button class="btn excluir" type="submit" id="enviar"
                        onclick="return confirm('Deseja mesmo excluir o pet?')">EXCLUIR</button>
                </div>
            </form>
        </section>
    </main>
    <script type="module" src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons/ionicons.esm.js"></script>
    <script src="https://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="<?= BASEPATH ?>public/js/app.js"></script>
    <script src="<?= BASEPATH ?>public/js/alertas.js"></script>
    <script src="<?= BASEPATH ?>public/js/excluirPet.js"></script>
</body>

</html>