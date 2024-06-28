<!DOCTYPE html>
<html lang="pt-br">

<head>
  <title>Meu amigo pet</title>
  <link rel="stylesheet" href="<?= BASEPATH ?>public/css/style.css" />
  <?php
  include ('head.php');
  ?>
</head>
<?php

use App\Database;

$con = Database::getConnection();
$filtro = '';
$filtros = [];
if (isset($_POST['genero'])) {
  if ($_POST['genero'] != "") {
    array_push($filtros, ' genero = \'' . $_POST['genero'] . '\'');
  }
}

if (isset($_POST['especie'])) {
  if ($_POST['especie'] != "") {
    array_push($filtros, ' especie = \'' . $_POST['especie'] . '\'');
  }
}

if (count($filtros) > 0) {
  $filtro = ' AND';
  foreach ($filtros as $filt) {
    if ($filt == $filtros[0]) {
      $filtro = $filtro . $filt;
    } else {
      $filtro = $filtro . ' AND' . $filt;
    }
  }
}


$stm = $con->prepare('SELECT * FROM pets WHERE disponivel = true' . $filtro . ';');
$stm->execute();
$pets = $stm->fetchAll();
?>

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
      if (!isset($_SESSION['user'])) {
        ?>
        <div class="cont1">
          <div class="item-container">
            <h3>ADOTE UM PET</h3>
            <a href="<?= BASEPATH ?>cadastro?check=adotante"><img class="icon-pet"
                src="<?= BASEPATH ?>public/images/icon-dog.png" alt="Icone de cachorro"></a>
            <p class="info">Conheça os pets que estão disponíveis para adoção, faça uma cadastro e adote um novo membro
              para sua
              família
            </p>
          </div>

          <div class="linha-divisoria-info"></div>

          <div class="item-container">
            <h3>PARA ONGs OU PROTETORES</h3>
            <a href="<?= BASEPATH ?>cadastro?check=doador"><img class="icon-pet"
                src="<?= BASEPATH ?>public/images/icon-cat.png" alt="Icone de gato"></a>
            <p class="info">
              Se você possui uma ONG ou realiza resgates faça um cadastro e registre o seu animalzinho. Podemos ajudar a
              encontrar um lar para ele(a).
            </p>
          </div>
        </div>
        <?php
      }
      ?>
      <div class="cont2">
        <?php
        include ('menuLateral.php');
        ?>

        <div class='pets'>
          <?php
          foreach ($pets as $pet) {
            $stm = $con->prepare('SELECT * FROM usuarios WHERE id = :idResponsavel;');
            $stm->bindValue(':idResponsavel', $pet['idResponsavel']);
            $stm->execute();
            $reponsavel = $stm->fetch();
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
              <div class='dadosPet'>
                <div class="foto-pet">
                  <img class='foto-pet' src="<?= BASEPATH ?>app/uploads/<?= $foto ?>"
                    alt="Foto do pet <?= $pet['nome'] ?>">
                </div>
                <div class='info-pet'>
                  <p>Gênero:
                    <?= $genero ?>
                  </p>
                  <p>Castrado:
                    <?= $castrado ?>
                  </p>
                  <p>Espécie:
                    <?= $pet['especie'] ?>
                  </p>
                  <?php $today = new DateTimeImmutable(date("Y-m-d"));
                  if ($pet['dataNascimento'] != "") {
                    $idade = $today->diff(new DateTimeImmutable($pet['dataNascimento']));
                    if ($idade->y > 0) {
                      if ($idade->y == 1) {
                        $idade = $idade->format('%y ano');
                      } else {
                        $idade = $idade->format('%y anos');
                      }
                    } elseif ($idade->m > 0) {
                      if ($idade->m == 1) {
                        $idade = $idade->format('%m mês');
                      } else {
                        $idade = $idade->format('%m meses');
                      }
                    } else {
                      if ($idade->d == 1) {
                        $idade = $idade->format('%a dia');
                      } else {
                        $idade = $idade->format('%a dias');
                      }
                    }
                    ?>
                    <?= "<p> Idade: " . $idade . ' </p>' ?>
                  <?php } ?>
                  <?php $idade = $today->diff(new DateTimeImmutable($pet['dataResgate']));
                  if ($idade->y > 0) {
                    if ($idade->y == 1) {
                      $idade = $idade->format('%y ano');
                    } else {
                      $idade = $idade->format('%y anos');
                    }
                  } elseif ($idade->m > 0) {
                    if ($idade->m == 1) {
                      $idade = $idade->format('%m mês');
                    } else {
                      $idade = $idade->format('%m meses');
                    }
                  } else {
                    if ($idade->d == 1) {
                      $idade = $idade->format('%a dia');
                    } else {
                      $idade = $idade->format('%a dias');
                    }
                  }
                  ?>
                  <?= "<p>Resgatado a " . $idade . ' </p>' ?>
                  <p>Responsável:
                    <?= $reponsavel['nome'] ?>
                  </p>

                  <?php
                  if (isset($_SESSION['user'])) {
                    ?>
                    <button class='queroAdotar'><a class='queroAdotar' href="#"
                        onclick="queroadotar(<?= $pet['id'] ?>,'<?= BASEPATH ?>queroadotar')">QUERO
                        ADOTAR!</a></button>
                    <?php
                  }
                  ?>
                </div>
              </div>
            </div>
            <?php
          }
          ?>
        </div>

      </div>

    </div>
  </main>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
  <script src="<?= BASEPATH ?>public/js/queroadotar.js"></script>
  <script src="<?= BASEPATH ?>public/js/app.js"></script>
  <script src="<?= BASEPATH ?>public/js/alertas.js"></script>
</body>

</html>