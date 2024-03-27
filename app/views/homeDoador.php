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
    <div class="container">
      <div class="cadastrarPet"><a href="<?= BASEPATH ?>cadastroPet">Cadastrar pet</a></div>
      <div class='pets'>
        <?php
        use App\Database;

        $con = Database::getConnection();
        $stm = $con->prepare('SELECT * FROM pets WHERE idResponsavel = :idResponsavel;');
        $stm->bindValue(':idResponsavel', $_SESSION['user']->__get('id'));
        $stm->execute();
        $pets = $stm->fetchAll();
        foreach ($pets as $pet) {
          $foto = explode('/', $pet['foto']);
          $foto = $foto[count($foto) - 1];
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
            <table>
              <tr>
                <td>
                  <div class="dadosPet">
                    <img class='foto-pet' src="<?= BASEPATH ?>app/uploads/<?= $foto ?>"
                      alt="Foto do pet <?= $pet['nome'] ?>">
                    <div class="icones">
                      <a href=""><ion-icon name="create"></ion-icon></a>
                      <a href=""><ion-icon name="trash"></ion-icon></a>
                    </div>
                    <p>Nome:
                      <?= $pet['nome'] ?>
                    </p>
                    <p>Gênero:
                      <?= $genero ?>
                    </p>
                    <p>Castrado:
                      <?= $castrado ?>
                    </p>
                    <?php
                    if ($pet['forneceCastracao'] != "") {
                      if ($pet['forneceCastracao'] == 'S') {
                        $forneceCastracao = 'Sim';
                      } else {
                        $forneceCastracao = 'Não';
                      }
                      ?>
                      <?= "<p>Fornece Castração: " . $forneceCastracao . ' </p>' ?>
                      <?php
                    }
                    ?>
                    <p>Espécie:
                    <?= $pet['especie'] ?>
                    </p>
                    <?php if ($pet['dataNascimento'] != "") { ?>
                      <?= "<p> Data de nacimento: " . $pet['dataNascimento'] . ' </p>' ?>
                    <?php } ?>
                    <p>Data do resgate:
                    <?= $pet['dataResgate'] ?>
                    </p>
                    <?php if ($pet['custoMensal'] != "") { ?>
                      <?= "<p> Custo mensal: " . $pet['custoMensal'] . ' </p>' ?>
                    <?php } ?>
                    <?php if ($pet['historia'] != "") { ?>
                      <?= "<p> História: " . $pet['historia'] . ' </p>' ?>
                    <?php } ?>
                  </div>
                </td>


              </tr>
            </table>
          </div>
          <?php
        }
        ?>
      </div>
    </div>
  </main>
  <script type="module" src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons/ionicons.esm.js"></script>
  <script src="<?= BASEPATH ?>public/js/app.js"></script>
  <script src="<?= BASEPATH ?>public/js/alertas.js"></script>
</body>

</html>