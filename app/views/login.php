<!DOCTYPE html>
<html lang="en">

<head>
    <title>Meu amigo pet - Login</title>
    <link rel="stylesheet" href="<?= BASEPATH  ?>public/css/style.css">
    <?php 
      include('head.php');
    ?>
</head>

<body>
    <main>
        <div class="header">
            <?php 
            include('header.php');
            ?>
        </div>

        <section id="form">
            <h1 class="form__title">Login</h1>

            <hr>

            <form class="login__form" name="login__form" method="POST">

                <div class="form__field">
                    <label for="email">E-mail</label>
                    <input type="email" name="email" id="email">
                </div>

                <div class="form__field">
                    <label for="password">Senha</label>
                    <input type="password" name="password" id="password">
                </div>
                <p>Não possui conta? <a href="<?= BASEPATH  ?>cadastro">Cadastre-se</a> </p>
                <button class="btn" type="submit">Entrar</button>
            </form>
        </section>
    </main>
</body>

</html>