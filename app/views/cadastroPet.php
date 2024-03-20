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

            <form class="cadastro__form" id="cadastro__form" method="POST">
                <fieldset class="Dados">
                    <fieldset class="Gênero">
                        <table>
                            <tbody>
                                <legend>Gênero</legend>
                                <tr>
                                    <td class="coluna1"><input required type="radio" name="genero" title="genero"
                                            value="M">
                                    </td>
                                    <td><label for="genero">Macho</label></td>
                                </tr>
                                <tr>
                                    <td class="coluna1"><input required type="radio" name="genero" title="genero"
                                            value="F"></td>
                                    <td><label for="genero">Fêmea</label></td>
                                </tr>
                            </tbody>
                        </table>
                    </fieldset>
                    <table>
                        <tbody>
                            <tr>
                                <td class="coluna1"><label for="nome">Nome/apelido</label></td>
                                <td><input required type="text" name="nome" id="nome"></td>
                            </tr>
                            <tr>
                                <td class="coluna1"><label for="especie">Espécie</label></td>
                                <td><select required name="especie" id="especie">
                                        <option value="">Espécie</option>
                                        <option value="Cachorro">Cachorro</option>
                                        <option value="Gato">Gato</option>
                                    </select></td>
                            </tr>
                        </tbody>
                    </table>
                    <fieldset class="Castrado">
                        <table>
                            <tbody>
                                <legend>Animal castrado?</legend>
                                <tr>
                                    <td class="coluna1"><input required type="radio" name="castrado" title="castrado"
                                            value="S">
                                    </td>
                                    <td><label for="castrado">Sim</label></td>
                                </tr>
                                <tr>
                                    <td class="coluna1"><input required type="radio" name="castrado" title="castrado"
                                            value="N"></td>
                                    <td><label for="castrado">Não</label></td>
                                </tr>
                            </tbody>
                        </table>
                    </fieldset>
                    <table>
                        <tbody>
                            <tr>
                                <td class="coluna1"><label for="dataNascimento">Data de nascimento</label></td>
                                <td><input required type="date" name="dataNascimento" id="dataNascimento"></td>
                            </tr>
                            <tr>
                                <td class="coluna1"><label for="dataResgate">Data do resgate</label></td>
                                <td><input required type="date" name="dataResgate" id="dataResgate"></td>
                            </tr>
                        </tbody>
                    </table>
                </fieldset>
                <button class="btn" type="submit" id="enviar">Cadastrar</button>
                <span role="alert" id="documentError" aria-hidden="true">
                    Por favor adicione um documento válido.
                </span>
                <span role="alert" id="phoneError" aria-hidden="true">
                    Por favor adicione um telefone válido.
                </span>
                <span role="alert" id="emailError" aria-hidden="true">
                    Por favor adicione um email válido.
                </span>
            </form>
        </section>
    </main>
    <script src="https://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="<?= BASEPATH ?>public/js/app.js"></script>
    <script src="<?= BASEPATH ?>public/js/cidades.js"></script>
    <script src="<?= BASEPATH ?>public/js/cadastro.js"></script>
</body>

</html>