<!DOCTYPE html>
<html lang="pt-br">

<head>
  <title>Meu amigo pet</title>
  <link rel="stylesheet" href="/meu-amigo-pet/public/css/style.css" />
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
      <h1 class="form__title">Cadastro</h1>

      <hr>

      <form action="#" class="login__form" method="POST">
        <fieldset class="tipo_cadastro">
          <legend>Tipo de Cadastro</legend>
          <div class="form__field">
            <input type="radio" name="tipo_cadastro" title="tipo_cadastro" value="adotante">
            <label for="tipo_cadastro">Adotante</label>
          </div>

          <div class="form__field">
            <input type="radio" name="tipo_cadastro" title="tipo_cadastro" value="ong_protetor">
            <label for="tipo_cadastro">ONG/Protetor(a)</label>
          </div>
        </fieldset>
        <fieldset class="dados_pessoais">
          <legend>Dados pessoais</legend>
          <div class="form__field">
            <label for="nome">Nome</label>
            <input type="text" name="nome" id="nome">
          </div>

          <div class="form__field">
            <label for="cpf-cnpj">CPF/CNPJ</label>
            <input type="text" name="cpf-cnpj" id="cpf-cnpj">
          </div>

          <div class="form__field">
            <label for="tel">Telefone</label>
            <input type="text" name="tel" id="tel">
          </div>
          <fieldset class="endereco">
            <legend>Endereço</legend>
            <div class="form__field">
              <label for="rua">Rua</label>
              <input type="text" name="rua" id="rua">
            </div>
            <div class="form__field">
              <label for="nukm">Número</label>
              <input type="text" name="num" id="num">
            </div>
            <div class="form__field">
              <label for="compl">Complemento</label>
              <input type="text" name="compl" id="compl">
            </div>
            <div class="form__field">
              <label for="bairro">Bairro</label>
              <input type="text" name="bairro" id="bairro">
            </div>
            <div class="form__field">
              <label for="uf">UF:</label>
              <select id="estado" onchange="buscaCidades(this.value)">
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
              </select>
            </div>
            <div class="form__field">
              <label for="cidade">Cidade:</label>
              <select id="cidade">
              </select>
            </div>
            <div class="form__field">
              <label for="cep">CEP</label>
              <input type="text" name="cep" id="cep">
            </div>
          </fieldset>
          <div class="form__field">
            <label for="email">E-mail</label>
            <input type="text" name="email" id="email">
          </div>

          <div class="form__field">
            <label for="senha">Senha</label>
            <input type="password" name="senha" id="senha">
          </div>
          <div class="form__field">
            <label for="conf-senha">Confirmar senha</label>
            <input type="password" name="conf-senha" id="conf-senha">
          </div>
        </fieldset>
        <button class="btn" type="submit">Cadastrar</button>
      </form>
    </section>
  </main>
  <script src="/meu-amigo-pet/public/js/app.js"></script>
  <script src="/meu-amigo-pet/public/js/cidades.js"></script>
</body>

</html>