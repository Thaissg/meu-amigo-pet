<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <title>Meu amigo pet</title>
    <link rel="stylesheet" href="<?= BASEPATH  ?>public/css/style.css" />
    <?php 
      include('head.php');
    ?>
  </head>
  <body>
    <main>
      <div class="header">
        <?php 
            if(isset($_SESSION['user'])){
              include('headerLogado.php');
            } else {
              include('header.php');
            };
        ?>
      </div>
      <div class="container">
        <div><a href="<?= BASEPATH  ?>cadastroPet">Cadastrar pet</a></div>
        <div><a href="">Administrar pets cadastrados</a></div>
      </div>
    </main>
    <script src="<?= BASEPATH  ?>public/js/app.js"></script>
    <script src="<?= BASEPATH ?>public/js/alertas.js"></script>
  </body>
</html>
