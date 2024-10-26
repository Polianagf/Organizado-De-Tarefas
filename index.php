<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Organizador de Tarefas com Alarme</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <div class="container">
    <h1>Organizador de Tarefas</h1>
    <form id="form-tarefa">
      <input type="text" id="titulo" placeholder="Título da Tarefa" required>
      <textarea id="descricao" placeholder="Descrição da Tarefa"></textarea>
      <input type="datetime-local" id="dataHora" required>
      <button type="button" onclick="adicionarTarefa()">Adicionar Tarefa</button>
    </form>
    <div id="lista-tarefas"></div>
  </div>

  <script src="js/script.js"></script>
</body>
</html>

