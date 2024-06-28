<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Meu amigo pet</title>
    <link rel="stylesheet" href="<?= BASEPATH ?>public/css/style.css" />
    <link rel="stylesheet" href="<?= BASEPATH ?>public/css/style-regAdocao.css" />
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
            $dtResgate = explode('-', $pet['dataResgate']);
            ?>
            <form id="registrarAdocao__Form" class="registrarAdocao__Form" method="POST">
                <div class="info">
                    <div>
                        <h1 class="form__title">REGISTRAR ADOÇÃO</h1>
                    </div>

                    <div class='pet'>
                        <?php
                        $foto = explode('/', $pet['foto']);
                        $foto = $foto[count($foto) - 1];
                        if ($foto == "") {
                            $foto = 'foto_padrao.png';
                        }
                        if ($pet['genero'] == 'M') {
                            $genero = 'MACHO';
                        } else {
                            $genero = 'FÊMEA';
                        }
                        if ($pet['castrado'] == 'S') {
                            $castrado = 'Sim';
                        } else {
                            $castrado = 'Não';
                        }
                        ?>
                        <div class="dados-pet">
                            <p class="dado-pet">NOME/APELIDO:
                                <?= strtoupper($pet['nome']) ?>
                            </p>
                            <p class="dado-pet">GÊNERO:
                                <?= $genero ?>
                            </p>
                            <p class="dado-pet">ESPÉCIE:
                                <?= strtoupper($pet['especie']) ?>
                            </p>
                            <p class="dado-pet" id='dataResgate'>DATA DE RESGATE:
                                <?= $dtResgate[2]."/". $dtResgate[1]."/".$dtResgate[0] ?>
                            </p>
                        </div>

                        <div class='div-foto-pet'>
                            <img class='foto-pet' src="<?= BASEPATH ?>app/uploads/<?= $foto ?>"
                                alt="Foto do pet <?= $pet['nome'] ?>">
                        </div>
                    </div>
                </div>

                <div class="linhaDivisoria"></div>

                <div class="preencher-cpf">
                    <div class='emLinha'>
                        <div>
                            <label for="id">ID</label>
                            <input class="readonly" type="text" name="id" value=<?= $petId ?> readonly="readonly">
                        </div>
                    </div>

                    <?php
                    $stm = $con->prepare('SELECT cpf_cnpj FROM usuarios WHERE tipo = :tipo;');
                    $stm->bindValue(':tipo', 'adotante');
                    $stm->execute();
                    $usuariosDoc = $stm->fetchAll();
                    $strUsuariosDoc = "";
                    for ($i=0; $i<count($usuariosDoc);$i++){
                        $doc = $usuariosDoc[$i][0];
                        if ($i == 0){
                            $strUsuariosDoc = $strUsuariosDoc." '".$doc."'";
                        }else{
                            $strUsuariosDoc = $strUsuariosDoc.", '".$doc."'";
                        }
                    }
                    ?>

                    <div class='emLinha'>
                        <label for="adotante">CPF/CNPJ DO ADOTANTE</label>
                        <input required type="text" name="cpf-cnpj" id="cpf-cnpj" onkeyup="docMaskEvent(event)"
                            onchange="testaDocumento(this.value,[<?= $strUsuariosDoc ?>])">
                    </div>

                    <div id="validaDoc" class="alert invalido invisible"></div>

                    <div id="adotante">
                    </div>

                    <div class='emLinha' id='dadosAdotante'></div>

                    <span class="invisible invalido" id="cpfError"></span>

                    <!-- futuramente adicionar uma opção para fazer o download do termo de adoção -->

                </div>

                <div class="botoes">
                    <button class="btn" type="submit" id="enviar"
                        onclick="return confirm('Confirma a doação do pet?')">Salvar</button>
                    <button class="btn" type="button"><a href="<?= BASEPATH ?>home">Cancelar</a></button>
                </div>
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