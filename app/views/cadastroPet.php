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
            if (isset ($_SESSION['user'])) {
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
                                                    </td>
                                                    <td><label for="genero">Macho</label></td>
                                                    <td><input required type="radio" name="genero" title="genero"
                                                            value="F"></td>
                                                    <td><label for="genero">Fêmea</label></td>
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
                                                    </td>
                                                    <td><label for="castrado">Sim</label></td>
                                                    <td><input required type="radio" name="castrado" title="castrado"
                                                            value="N" onclick="mostrarForneceCastracao(this)">
                                                    </td>
                                                    <td><label for="castrado">Não</label></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </fieldset>
                                    <fieldset id="forneceCastracao" class="invisible"></fieldset>
                                </td>
                            </tr>

                            <table>
                                <tbody>
                                    <tr>
                                        <td><label for="nome">Nome/apelido</label></td>
                                        <td><input required type="text" name="nome" id="nome"></td>
                                    </tr>
                                    <tr>
                                        <td><label for="especie">Espécie</label></td>
                                        <td><select required name="especie" id="especie">
                                                <option value="">Espécie</option>
                                                <option value="Cachorro">Cachorro</option>
                                                <option value="Gato">Gato</option>
                                            </select></td>
                                    </tr>
                                </tbody>
                            </table>
                            <table>
                                <tbody>
                                    <tr>
                                        <td><label for="dataNascimento">Data de nascimento (opcional)</label></td>
                                        <td><input oninput="testarData()" type="date" name="dataNascimento"
                                                id="dataNascimento"></td>
                                    </tr>
                                    <tr>
                                        <td><label for="dataResgate">Data do resgate</label></td>
                                        <td><input required oninput="testarData()" type="date" name="dataResgate"
                                                id="dataResgate"></td>
                                    </tr>
                                </tbody>
                            </table>
                            <span class="invisible invalido" id="dataError"></span>
                            <tr class="cadastroPet">
                                <td>
                                    <fieldset>
                                        <table>
                                            <tbody>
                                                <legend>Doenças em tratamento (opcional)</legend>
                                                <tr>
                                                    <td><input type="checkbox" name="doencas[]" title="doencas[]"
                                                            value="Erlichiose (doença do carrapato)">
                                                    </td>
                                                    <td><label for="doencas[]">Erlichiose (doença do carrapato)</label>
                                                    </td>

                                                    <td><input type="checkbox" name="doencas[]" title="doencas[]"
                                                            value="Insuficiência renal">
                                                    </td>
                                                    <td><label for="doencas[]">Insuficiência renal</label></td>
                                                </tr>
                                                <tr>
                                                    <td><input type="checkbox" name="doencas[]" title="doencas[]"
                                                            value="Cinomose">
                                                    </td>
                                                    <td><label for="doencas[]">Cinomose</label></td>

                                                    <td><input type="checkbox" name="doencas[]" title="doencas[]"
                                                            value="Leishmaniose ">
                                                    </td>
                                                    <td><label for="doencas[]">Leishmaniose</label></td>
                                                </tr>
                                                <tr>
                                                    <td><input type="checkbox" name="doencas[]" title="doencas[]"
                                                            value="FIV">
                                                    </td>
                                                    <td><label for="doencas[]">FIV</label></td>

                                                    <td><input type="checkbox" name="doencas[]" title="doencas[]"
                                                            value="FELV">
                                                    </td>
                                                    <td><label for="doencas[]">FELV</label></td>
                                                </tr>
                                                <tr>
                                                    <td><input type="checkbox" name="doencas[]" title="doencas[]"
                                                            value="Raiva">
                                                    </td>
                                                    <td><label for="doencas[]">Raiva</label></td>

                                                    <td><input type="checkbox" name="doencas[]" title="doencas[]"
                                                            value="Escabiose (Sarna)">
                                                    </td>
                                                    <td><label for="doencas[]">Escabiose (Sarna)</label></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </fieldset>
                                </td>
                            </tr>
                            <table>
                                <tbody>
                                    <tr>
                                        <td><label for="custoMensal">Custo Mensal (opcional) R$ </label></td>
                                        <td><input type="text" size="12" onkeyup="mascaraMoeda(event)"
                                                name="custoMensal" id="custoMensal"></td>
                                    </tr>
                                    <tr>
                                        <td><label for="historia">História (opcional)</label></td>
                                        <td><textarea name="historia" id="historia" cols="30" rows="10"
                                                placeholder="Utilize este campo para descrever um pouco o resgate do pet e algumas características dele"></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label for="foto">Foto do pet (opcional)</label></td>
                                        <td><input oninput="testarImg()" type="file" name="foto" id="foto"
                                                accept="image/png, image/jpeg"></td>
                                    </tr>
                                </tbody>
                            </table>
                            <span class="invisible invalido" id="fotoError"></span>
                        </tbody>
                    </table>
                </fieldset>

                <button class="btn" type="submit" id="enviar">Cadastrar</button>
            </form>
        </section>
    </main>
    <script src="https://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="<?= BASEPATH ?>public/js/cadastroPet.js"></script>
    <script src="<?= BASEPATH ?>public/js/app.js"></script>
    <script src="<?= BASEPATH ?>public/js/cidades.js"></script>
</body>

</html>