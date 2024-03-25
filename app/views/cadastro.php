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
      if (isset ($_SESSION['user'])) {
        include ('headerLogado.php');
      } else {
        include ('header.php');
      }
      ;
      ?>
    </div>
    <section id="form">
      <h1 class="form__title">Cadastro</h1>

      <form class="cadastro__form" id="cadastro__form" method="POST">
        <fieldset class="tipo_cadastro">
          <table>
            <tbody>
              <legend>O que você deseja?</legend>
              <tr>
                <td class="coluna1"><input required type="radio" name="tipo_cadastro" title="tipo_cadastro"
                    value="adotante">
                </td>
                <td><label for="tipo_cadastro">Quero adotar!</label></td>
              </tr>
              <tr>
                <td class="coluna1"><input required type="radio" name="tipo_cadastro" title="tipo_cadastro"
                    value="ong_protetor"></td>
                <td><label for="tipo_cadastro">Quero doar!</label></td>
              </tr>
            </tbody>
          </table>
        </fieldset>
        <fieldset class="dados_pessoais">
          <legend>Dados pessoais</legend>
          <table>
            <tbody>
              <tr>
                <td class="coluna1"><label for="nome">Nome</label></td>
                <td><input required type="text" name="nome" id="nome"></td>
              </tr>
              <tr>
                <td class="coluna1"><label for="cpf-cnpj">CPF/CNPJ</label></td>
                <td><input required type="text" name="cpf-cnpj" id="cpf-cnpj" onchange="testaDocumento(this.value)"
                    onkeyup="docMaskEvent(event)">
                </td>
              </tr>
              <tr>
                <td class="coluna1"></td>
                <td>
                  <div id="validaDoc" class="alert invalido invisible"></div>
                </td>
              </tr>
              <tr>
                <td class="coluna1"><label for="tel">Telefone</label></td>
                <td><input required type="text" name="tel" id="tel" onkeyup="telMaskEvent(event)" maxlength="15"
                    minlength="14" onchange="testaTelefone(this.value)">
                </td>
              </tr>
              <tr>
                <td class="coluna1"></td>
                <td>
                  <div id="validaTelefone" class="alert invalido invisible"></div>
                  <div id="validaTelefone2" class="alert invalido invisible"></div>
                </td>
              </tr>
              <tr>
              <tr>
                <td class="coluna1"><label for="email">E-mail</label></td>
                <td><input required type="text" name="email" id="email" onchange="testaEmail(this.value)">
                </td>
              </tr>
              <tr>
                <td class="coluna1"></td>
                <td>
                  <div id="validaEmail" class="alert invalido invisible"></div>
                </td>
              </tr>
              <tr>
                <td class="coluna1"><label for="tipoLogradouro">Tipo Logradouro</label></td>
                <td><select required name="tipoLogradouro" id="tipoLogradouro">
                    <option value="">Tipo</option>
                    <option value="Aeroporto">Aeroporto</option>
                    <option value="Alameda">Alameda</option>
                    <option value="Área">Área</option>
                    <option value="Avenida">Avenida</option>
                    <option value="Campo">Campo</option>
                    <option value="Chácara">Chácara</option>
                    <option value="Colônia">Colônia</option>
                    <option value="Condomínio">Condomínio</option>
                    <option value="Conjunto">Conjunto</option>
                    <option value="Distrito">Distrito</option>
                    <option value="Esplanada">Esplanada</option>
                    <option value="Estação">Estação</option>
                    <option value="Estrada">Estrada</option>
                    <option value="Favela">Favela</option>
                    <option value="Fazenda">Fazenda</option>
                    <option value="Feira">Feira</option>
                    <option value="Jardim">Jardim</option>
                    <option value="Ladeira">Ladeira</option>
                    <option value="Lago">Lago</option>
                    <option value="Lagoa">Lagoa</option>
                    <option value="Largo">Largo</option>
                    <option value="Loteamento">Loteamento</option>
                    <option value="Morro">Morro</option>
                    <option value="Núcleo">Núcleo</option>
                    <option value="Parque">Parque</option>
                    <option value="Passarela">Passarela</option>
                    <option value="Pátio">Pátio</option>
                    <option value="Praça">Praça</option>
                    <option value="Quadra">Quadra</option>
                    <option value="Recanto">Recanto</option>
                    <option value="Residencial">Residencial</option>
                    <option value="Rodovia">Rodovia</option>
                    <option value="Rua">Rua</option>
                    <option value="Setor">Setor</option>
                    <option value="Sítio">Sítio</option>
                    <option value="Travessa">Travessa</option>
                    <option value="Trecho">Trecho</option>
                    <option value="Trevo">Trevo</option>
                    <option value="Vale">Vale</option>
                    <option value="Vereda">Vereda</option>
                    <option value="Via">Via</option>
                    <option value="Viaduto">Viaduto</option>
                    <option value="Viela">Viela</option>
                    <option value="Vila">Vila</option>
                  </select></td>
              </tr>
              <tr>
                <td class="coluna1"><label for="nomeLogradouro">Logradouro</label></td>
                <td><input required type="text" name="nomeLogradouro" id="nomeLogradouro"></td>
              </tr>
              <tr>
                <td class="coluna1"><label for="num">Número</label></td>
                <td><input required type="number" name="num" id="num"></td>
              </tr>
              <tr>
                <td class="coluna1"><label for="compl">Complemento</label></td>
                <td><input type="text" name="compl" id="compl"></td>
              </tr>
              <tr>
                <td class="coluna1"><label for="bairro">Bairro</label></td>
                <td><input required type="text" name="bairro" id="bairro"></td>
              </tr>
              <tr>
                <td class="coluna1"><label for="uf">UF:</label></td>
                <td><select required name="uf" id="uf" onchange="buscaCidades(this.value)">
                    <option value="">Selecione o Estado</option>
                    <option value="AC">Acre</option>
                    <option value="AL">Alagoas</option>
                    <option value="AP">Amapá</option>
                    <option value="AM">Amazonas</option>
                    <option value="BA">Bahia</option>
                    <option value="CE">Ceará</option>
                    <option value="DF">Distrito Federal</option>
                    <option value="ES">Espírito Santo</option>
                    <option value="GO">Goiás</option>
                    <option value="MA">Maranhão</option>
                    <option value="MT">Mato Grosso</option>
                    <option value="MS">Mato Grosso do Sul</option>
                    <option value="MG">Minas Gerais</option>
                    <option value="PA">Pará</option>
                    <option value="PB">Paraíba</option>
                    <option value="PR">Paraná</option>
                    <option value="PE">Pernambuco</option>
                    <option value="PI">Piauí</option>
                    <option value="RJ">Rio de Janeiro</option>
                    <option value="RN">Rio Grande do Norte</option>
                    <option value="RS">Rio Grande do Sul</option>
                    <option value="RO">Rondônia</option>
                    <option value="RR">Roraima</option>
                    <option value="SC">Santa Catarina</option>
                    <option value="SP">São Paulo</option>
                    <option value="SE">Sergipe</option>
                    <option value="TO">Tocantins</option>
                  </select></td>
              </tr>
              <tr>
                <td class="coluna1"><label for="cidade">Cidade:</label></td>
                <td><select required name="cidade" id="cidade"></select></td>
              </tr>
              <tr>
                <td class="coluna1"><label for="cep">CEP</label></td>
                <td><input required type="text" name="cep" id="cep" onkeyup="cepMaskEvent(event)" maxlength="9"
                    minlength="9"></td>
              </tr>
              <tr>
                <td class="coluna1"><label for="senha">Senha</label></td>
                <td><input required type="password" name="senha" id="senha" onchange="testaSenha(this.value)"
                    minlength="8">
                </td>
              </tr>
              <tr>
                <td class="coluna1"><input class="checkMostrarSenha" type="checkbox" name="mostrar-senha"
                    id="mostrar-senha" onclick="mostrarSenha('senha',this)"></td>
                <td><label class="mostrar-senha" for="mostrar-senha">Mostrar senha</label></td>
              </tr>
              <tr>
                <td class="coluna1"><label for="conf-senha">Confirmar senha</label></td>
                <td><input required type="password" name="conf-senha" id="conf-senha"
                    onkeyup="testaConfSenha(this.value)"></td>
              </tr>
              <tr>
                <td class="coluna1"></td>
                <td>
                  <div id="validaConf" class="alert invalido invisible"></div>
                </td>
              </tr>
              <tr>
                <td class="coluna1"><input class="checkMostrarSenha" type="checkbox" name="mostrar-confSenha"
                    id="mostrar-confSenha" onclick="mostrarSenha('conf-senha',this)"></td>
                <td><label class="mostrar-senha " for="mostrar-confSenha">Mostrar senha</label></td>
              </tr>
              <tr>
                <td class="coluna1"></td>
                <td>
                  <div>
                    <p id="validaTamanho" class="alert">Senha deve conter no mínimo 8 caracteres</p>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </fieldset>
        <button class="btn" type="submit" id="enviar">Cadastrar</button>
        <span role="alert" id="documentError" aria-hidden="true">
          Por favor adicione um documento válido.
        </span>
        <span role="alert" id="phoneError" aria-hidden="true">
          Por favor adicione um telefone válido.
        </span>
        <span role="alert" id="emailError" aria-hidden="true">
          Por favor adicione um email válido.
        </span>
      </form>
    </section>
  </main>
  <script src="https://code.jquery.com/jquery-1.9.1.js"></script>
  <script src="<?= BASEPATH ?>public/js/app.js"></script>
  <script src="<?= BASEPATH ?>public/js/cidades.js"></script>
  <script src="<?= BASEPATH ?>public/js/cadastro.js"></script>
</body>

</html>