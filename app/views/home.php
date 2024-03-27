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
  $filtro = ' WHERE';
  foreach ($filtros as $filt) {
    if ($filt == $filtros[0]) {
      $filtro = $filtro . $filt;
    } else {
      $filtro = $filtro . ' AND' . $filt;
    }
  }
}


$stm = $con->prepare('SELECT * FROM pets' . $filtro . ';');
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
      <div>
        <table>
          <tr>
            <td class="filtro">
              <div class="filtro__form">
                <form method="POST">
                  <table>
                    <tr>
                      <td>
                        <label for="genero">Gênero: </label>
                      </td>
                      <td>
                        <select name="genero" id="genero">
                          <option value="">Selecione</option>
                          <option value="M">Macho</option>
                          <option value="F">Fêmea</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <label for="especie">Espécie: </label>
                      </td>
                      <td>
                        <select name="especie" id="especie">
                          <option value="">Selecione</option>
                          <option value="Cachorro">Cachorro</option>
                          <option value="Gato">Gato</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <button type="submit">Filtrar</button>
                      </td>
                    </tr>
                  </table>

                </form>
              </div>
            </td>
            <td>
              <div class="item-container">
                <h2>Adote um pet</h2>
                <p>Conheça os pets que estão disponíveis para adoção, faça uma cadastro e adote um novo membro para sua
                  família
                </p>
              </div>

              <div class="item-container">
                <h2>Para ONGs e Protetores(as) independentes</h2>
                <p>
                  Se você possui uma ONG ou realiza resgates e gostaria de incluir seus resgates no nosso sistema para
                  auxiliar
                  na doação.
                  Faça um cadastro da sua instituição e registre o seu animalzinho. Podemos ajudar a encontrar um lar
                  pra
                  ele(a).
                </p>
              </div>
            </td>
          </tr>

        </table>
      </div>

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
          <div class='item-pet dadosPet'>
            <img class='foto-pet' src="<?= BASEPATH ?>app/uploads/<?= $foto ?>" alt="Foto do pet <?= $pet['nome'] ?>">
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
            <?php if ($pet['custoMensal'] != "") { ?>
              <?= "<p> Custo mensal: " . $pet['custoMensal'] . ' </p>' ?>
            <?php } ?>
            <?php if ($pet['historia'] != "") { ?>
              <?= "<p> História: " . $pet['historia'] . ' </p>' ?>
            <?php } ?>
            <p>Responsável:
              <?= $reponsavel['nome'] ?>
            </p>
          </div>
          <?php
        }
        ?>
      </div>

    </div>
  </main>
  <script src="<?= BASEPATH ?>public/js/app.js"></script>
  <script src="<?= BASEPATH ?>public/js/alertas.js"></script>
</body>

</html>