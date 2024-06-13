<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Meu amigo pet</title>
    <link rel="stylesheet" href="<?= BASEPATH ?>public/css/style.css" />
    <link rel="stylesheet" href="<?= BASEPATH ?>public/css/style-cadastroPet.css" />
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
            <h1>CADASTRO</h1>
            <form class="cadastroPet__form" id="cadastroPet__form" method="POST" enctype="multipart/form-data">
                <div>
                    <h2>DADOS</h2>
                    <div class="dados">
                        <div>
                            <div>GÊNERO</div>
                            <div class="emLinha">
                                <input required type="radio" name="genero" title="genero" value="M">
                                <label for="genero">Macho</label>
                                <input required type="radio" name="genero" title="genero" value="F">
                                <label for="genero">Fêmea</label></td>
                            </div>
                        </div>
                        <div>
                            <div>CASTRADO</div>
                            <div class="emLinha">
                                <input required type="radio" name="castrado" title="castrado" value="S"
                                    onclick="mostrarForneceCastracao(this)">

                                <label for="castrado">Sim</label>
                                <input required type="radio" name="castrado" title="castrado" value="N"
                                    onclick="mostrarForneceCastracao(this)">
                                <label for="castrado">Não</label>
                            </div>
                        </div>
                        <div id="forneceCastracao" class="invisible"></div>
                        <div>
                            <div class="emLinha">
                                <label for="nome">NOME/APELIDO <p>*</p></label>
                                <input required type="text" name="nome" id="nome">
                            </div>
                            <div class="emLinha">
                                <label for="especie">ESPÉCIE <p>*</p></label>
                                <select required name="especie" id="especie">
                                    <option value="">SELECIONE</option>
                                    <option value="Cachorro">CACHORRO</option>
                                    <option value="Gato">GATO</option>
                                </select>
                            </div>
                            <div class="emLinha">
                                <label for="dataNascimento">DATA DE NASCIMENTO</label>
                                <input oninput="testarData()" type="date" name="dataNascimento" id="dataNascimento">
                            </div>
                            <div class="emLinha">
                                <label for="dataResgate">DATA DE RESGATE <p>*</p></label>
                                <input required oninput="testarData()" type="date" name="dataResgate" id="dataResgate">
                            </div>
                            <span class="invisible invalido" id="dataError"></span>
                        </div>
                    </div>
                </div>
                <div class="linhaDivisoria"></div>
                <div>
                    <h2>DOENÇAS EM TRATAMENTO</h2>
                    <div class="doencas">
                        <div class="emLinha">
                            <input type="checkbox" name="doencas[]" title="doencas[]"
                                value="Erlichiose (doença do carrapato)">
                            <label for="doencas[]">Erlichiose (doença do
                                carrapato)</label>
                        </div>
                        <div class='emLinha'><input type="checkbox" name="doencas[]" title="doencas[]"
                                value="Insuficiência renal">
                            <label for="doencas[]">Insuficiência renal</label>
                        </div>
                        <div class='emLinha'>
                            <input type="checkbox" name="doencas[]" title="doencas[]" value="Cinomose">
                            <label for="doencas[]">Cinomose</label>
                        </div>
                        <div class='emLinha'>
                            <input type="checkbox" name="doencas[]" title="doencas[]" value="Leishmaniose">
                            <label for="doencas[]">Leishmaniose</label>
                        </div>
                        <div class='emLinha'>
                            <input type="checkbox" name="doencas[]" title="doencas[]" value="FIV">
                            <label for="doencas[]">FIV</label>
                        </div>
                        <div class='emLinha'>
                            <input type="checkbox" name="doencas[]" title="doencas[]" value="FELV">
                            <label for="doencas[]">FELV</label>
                        </div>
                        <div class='emLinha'>
                            <input type="checkbox" name="doencas[]" title="doencas[]" value="Raiva">
                            <label for="doencas[]">Raiva</label>
                        </div>
                        <div class='emLinha'>
                            <input type="checkbox" name="doencas[]" title="doencas[]" value="Escabiose (Sarna)">
                            <label for="doencas[]">Escabiose (Sarna)</label>
                        </div>
                        <div class='emLinha'>
                            <label for="custoMensal">Custo Mensal (opcional) R$ </label>
                            <input type="text" size="12" onkeyup="mascaraMoeda(event)" name="custoMensal"
                                id="custoMensal">
                        </div>
                    </div>
                </div>
                <div class="linhaDivisoria"></div>
                <div class="detalhes">
                    <h2>DETALHES</h2>
                    <div class="historia">
                        <label for="historia">HISTÓRIA</label>
                        <textarea name="historia" id="historia" cols="30" rows="10"
                            placeholder="Descreva um pouco o resgate do pet e algumas características"></textarea>
                    </div>
                    <div class="emLinha">
                        <label for="foto">FOTO</label>
                        <input oninput="testarImg(), removerFotoAnterior('')" type="file" name="foto" id="foto"
                            accept="image/png, image/jpeg">
                    </div>
                    <span class="invisible invalido" id="fotoError"></span>
                    <img class='foto-pet invisible' id='foto-pet' src="" alt="Prévia da foto selecionada">
                </div>
                <div class="emLinha botoes">
                    <button class="btn" type="submit" id="enviar">CADASTRAR</button>
                    <button class="btn" type="button"><a href="<?= BASEPATH ?>home">CANCELAR</a></button>
                </div>
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