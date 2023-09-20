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
          include('header.php');
        ?>
      </div>
      <div class="container">
        <div class="item-container">
          <h2>Adote um pet</h2>
          <p>Conheça os pets que estão disponíveis para adoção, faça uma cadastro e adote um novo membro para sua família</p>
        </div>
        <div class="acoes">
            <a href="#" id="btn-acoes">Conheça os pets</a>
            <a href="#" id="btn-acoes">Conheça as instituições cadastradas</a>
            <a href="cadastro.php" id="btn-acoes">Cadastre-se</a>
            <a href="#" id="btn-acoes">Login</a>
        </div>
      </div>
    </main>
    <script src="<?= BASEPATH  ?>public/js/app.js"></script>
  </body>
</html>
