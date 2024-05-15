<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Meu amigo pet - Login</title>
    <link rel="stylesheet" href="<?= BASEPATH ?>public/css/styleLogin.css">
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
            <p class="tipo_cadastro">TIPO DE CADASTRO</p>

            <form class="login__form" name="login__form" id="login__form" onsubmit="logado()" method="POST">
                <div class="form__field">
                    <input required type="radio" name="tipo_cadastro" title="tipo_cadastro" value="adotante">
                    <label for="tipo_cadastro" class="tipo_cadastro">Adotante</label>
                    <input required type="radio" name="tipo_cadastro" title="tipo_cadastro" value="doador">
                    <label for="tipo_cadastro" class="tipo_cadastro">Doador</label>
                </div>

                <div class="form__field">
                    <label for="email">EMAIL: </label>
                    <input class="input-txt" required type="email" name="email" id="email">
                </div>

                <div class="form__field">
                    <label for="password">SENHA: </label>
                    <input class="input-txt" required type="password" name="password" id="password">
                </div>
                <div class="submit">
                    <button class="btn" type="submit">ENTRAR</button>
                </div>
                <div class="cadastre-se">
                    <p>Não possui conta? <a href="<?= BASEPATH ?>cadastro" class="cadastre-se">Cadastre-se</a> </p>
                </div>
            </form>
        </section>
    </main>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="<?= BASEPATH ?>public/js/alertas.js"></script>
</body>

</html>