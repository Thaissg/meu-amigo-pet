<!DOCTYPE html>
<html lang="en">

<head>
    <title>Meu amigo pet - Login</title>
    <link rel="stylesheet" href="<?= BASEPATH ?>public/css/style.css">
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

        <div>
            Email confirmado com sucesso! <br><br>
            <a href="<?=BASEPATH?>login">Faça seu login para usar a plataforma</a>
        </div>
    </main>
    <script src="<?= BASEPATH ?>public/js/alertas.js"></script>
</body>

</html>