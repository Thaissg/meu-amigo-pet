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
            <h1 class="form__title">Cadastro</h1>

            <form class="cadastroPet__form" id="cadastroPet__form" method="POST" enctype="multipart/form-data">
                <fieldset class="Dados">
                    <table>
                        <tbody>
                            <tr class="cadastroPet">
                                <td>
                                    <fieldset class="Gênero">
                                        <table>
                                            <tbody>
                                                <legend>Gênero</legend>
                                                <tr>
                                                    <td><input required type="radio" name="genero" title="genero"
                                                            value="M">
                                                        <label for="genero">Macho</label>
                                                    </td>
                                                    <td><input required type="radio" name="genero" title="genero"
                                                            value="F"><label for="genero">Fêmea</label></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </fieldset>
                                </td>
                            </tr>
                            <tr class="cadastroPet">
                                <td>
                                    <fieldset class="Castrado">
                                        <table>
                                            <tbody>
                                                <legend>Animal castrado?</legend>
                                                <tr>
                                                    <td><input required type="radio" name="castrado" title="castrado"
                                                            value="S" onclick="mostrarForneceCastracao(this)">

                                                        <label for="castrado">Sim</label>
                                                    </td>
                                                    <td><input required type="radio" name="castrado" title="castrado"
                                                            value="N" onclick="mostrarForneceCastracao(this)">
                                                        <label for="castrado">Não</label>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </fieldset>
                                    <fieldset id="forneceCastracao" class="invisible"></fieldset>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="nome">Nome/apelido</label>
                                    <input required type="text" name="nome" id="nome">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="especie">Espécie</label>
                                    <select required name="especie" id="especie">
                                        <option value="">Espécie</option>
                                        <option value="Cachorro">Cachorro</option>
                                        <option value="Gato">Gato</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="dataNascimento">Data de nascimento (opcional)</label>
                                    <input oninput="testarData()" type="date" name="dataNascimento" id="dataNascimento">
                                </td>
                            </tr>
                            <tr>
                                <td><label for="dataResgate">Data do resgate</label>
                                    <input required oninput="testarData()" type="date" name="dataResgate"
                                        id="dataResgate">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="invisible invalido" id="dataError"></span>
                                </td>
                            </tr>

                            <tr class="cadastroPet">
                                <td>
                                    <div class="emLinha">
                                        <fieldset>
                                            <table>
                                                <tbody>
                                                    <legend>Doenças em tratamento (opcional)</legend>
                                                    <tr>
                                                        <td>
                                                            <div class='emLinha'>
                                                                <input type="checkbox" name="doencas[]"
                                                                    title="doencas[]"
                                                                    value="Erlichiose (doença do carrapato)">
                                                                <label for="doencas[]">Erlichiose (doença do
                                                                    carrapato)</label>
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class='emLinha'><input type="checkbox" name="doencas[]"
                                                                    title="doencas[]" value="Insuficiência renal">
                                                                <label for="doencas[]">Insuficiência renal</label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class='emLinha'>
                                                                <input type="checkbox" name="doencas[]"
                                                                    title="doencas[]" value="Cinomose">
                                                                <label for="doencas[]">Cinomose</label>
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class='emLinha'>
                                                                <input type="checkbox" name="doencas[]"
                                                                    title="doencas[]" value="Leishmaniose">
                                                                <label for="doencas[]">Leishmaniose</label>
                                                            </div>
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class='emLinha'>
                                                                <input type="checkbox" name="doencas[]"
                                                                    title="doencas[]" value="FIV">
                                                                <label for="doencas[]">FIV</label>
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class='emLinha'>
                                                                <input type="checkbox" name="doencas[]"
                                                                    title="doencas[]" value="FELV">
                                                                <label for="doencas[]">FELV</label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class='emLinha'>
                                                                <input type="checkbox" name="doencas[]"
                                                                    title="doencas[]" value="Raiva">
                                                                <label for="doencas[]">Raiva</label>
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class='emLinha'>
                                                                <input type="checkbox" name="doencas[]"
                                                                    title="doencas[]" value="Escabiose (Sarna)">
                                                                <label for="doencas[]">Escabiose (Sarna)</label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </fieldset>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <label for="custoMensal">Custo Mensal (opcional) R$ </label>
                                    <input type="text" size="12" onkeyup="mascaraMoeda(event)" name="custoMensal"
                                        id="custoMensal">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="emLinha">
                                        <label for="historia">História (opcional)</label>
                                        <textarea name="historia" id="historia" cols="30" rows="10"
                                            placeholder="Utilize este campo para descrever um pouco o resgate do pet e algumas características dele"></textarea>
                                    </div>
                                </td>
                            </tr>
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
                                    <img class='foto-pet invisible' id='foto-pet' src=""
                                        alt="Prévia da foto selecionada">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="centralizado">
                        <tr>
                            <td class="centralizado">
                                <button class="btn" type="submit" id="enviar">Cadastrar</button>
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
    <script src="https://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="<?= BASEPATH ?>public/js/cadastroPet.js"></script>
    <script src="<?= BASEPATH ?>public/js/app.js"></script>
    <script src="<?= BASEPATH ?>public/js/cidades.js"></script>
    <script src="<?= BASEPATH ?>public/js/alertas.js"></script>
</body>

</html>