<!DOCTYPE html>
<html lang="pt-br">

<head>
  <title>Meu amigo pet</title>
  <link rel="stylesheet" href="<?= BASEPATH ?>public/css/style.css" />
  <link rel="stylesheet" href="<?= BASEPATH ?>public/css/style-homeDoador.css" />
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
    <div class="container">
      <?php
      include ('menuLateral.php');
      ?>

      <div class='pets'>
        <?php
        use App\Database;

        $con = Database::getConnection();
        $stm = $con->prepare('SELECT * FROM pets WHERE idResponsavel = :idResponsavel AND disponivel = true;');
        $stm->bindValue(':idResponsavel', $_SESSION['user']->__get('id'));
        $stm->execute();
        $pets = $stm->fetchAll();
        foreach ($pets as $pet) {
          $foto = explode('/', $pet['foto']);
          $foto = $foto[count($foto) - 1];
          $dataResgate = explode('-', $pet['dataResgate']);
          if ($foto == "") {
            $foto = 'foto_padrao.png';
          }
          if ($pet['genero'] == 'M') {
            $genero = 'Macho';
          } else {
            $genero = 'Fêmea';
          }
          if ($pet['castrado'] == 'S') {
            $castrado = 'Sim';
          } else {
            $castrado = 'Não';
          }
          ?>
          <div class='item-pet'>
            <div class="dadosPet">
              <div>
                <p><?= mb_strtoupper($pet['nome'],'UTF-8') ?></p>
              </div>
              <div class='foto-pet'><img class='foto-pet' src="<?= BASEPATH ?>app/uploads/<?= $foto ?>"
                  alt="Foto do pet <?= $pet['nome'] ?>"></div>
              <div class="opcoesPet">
                <div>
                  <a class="editarPet" href="<?= BASEPATH ?>editarPet?<?= $pet['id'] ?>"><ion-icon class="icone"
                      name="create"></ion-icon>
                    <p>EDITAR</p>
                  </a>
                </div>
                <div>
                  <a class="excluirPet" href="<?= BASEPATH ?>excluirPet?<?= $pet['id'] ?>"><ion-icon class="icone"
                      name="trash"></ion-icon>
                    <p>APAGAR</p>
                  </a>
                </div>
              </div>
              <div class="infoPet">
                <p>Gênero:
                  <?= $genero ?>
                </p>
                <p>Castrado:
                  <?= $castrado ?>
                </p>
                <p>Espécie:
                  <?= $pet['especie'] ?>
                </p>
                <p>Data do resgate:
                  <?= $dataResgate[2] . '/' . $dataResgate[1] . '/' . $dataResgate[0] ?>
                </p>
              </div>
              <div class="registrarAdocao">
                <a class="registrarAdocao" href="<?= BASEPATH ?>registrarAdocao?<?= $pet['id'] ?>">
                REGISTRAR ADOÇÃO
                </a>
              </div>
            </div>
          </div>
          <?php
        }
        ?>
      </div>
    </div>
  </main>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script><script src="<?= BASEPATH ?>public/js/app.js"></script>
  <script src="<?= BASEPATH ?>public/js/alertas.js"></script>
</body>

</html>