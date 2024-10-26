async function carregarTarefas() {
  const resposta = await fetch("tarefas.php");
  const tarefas = await resposta.json();

  const listaTarefas = document.getElementById("lista-tarefas");
  listaTarefas.innerHTML = "";

  tarefas.forEach((tarefa) => {
    const tarefaElemento = document.createElement("div");
    tarefaElemento.classList.add("tarefa");
    if (tarefa.status === "concluida") {
      tarefaElemento.classList.add("concluida");
    }

    const dataHoraFormatada = new Date(tarefa.data_hora).toLocaleString("pt-BR");

    tarefaElemento.innerHTML = `
      <span><strong>${tarefa.titulo}</strong> - ${dataHoraFormatada}</span>
      <button class="botao-tarefa" onclick="alterarStatus(${tarefa.id})">✔</button>
      <button class="botao-tarefa" onclick="deletarTarefa(${tarefa.id})">❌</button>
    `;

    listaTarefas.appendChild(tarefaElemento);
  });
}

async function adicionarTarefa() {
  const titulo = document.getElementById("titulo").value;
  const descricao = document.getElementById("descricao").value;
  const dataHora = document.getElementById("dataHora").value;

  await fetch("tarefas.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ titulo, descricao, data_hora: dataHora }),
  });

  document.getElementById("titulo").value = "";
  document.getElementById("descricao").value = "";
  document.getElementById("dataHora").value = "";
  carregarTarefas();
}

async function alterarStatus(id) {
  await fetch(`tarefas.php?id=${id}`, { method: "PUT" });
  carregarTarefas();
}

async function deletarTarefa(id) {
  await fetch(`tarefas.php?id=${id}`, { method: "DELETE" });
  carregarTarefas();
}

function verificarAlarmes() {
  const now = new Date();

  fetch("tarefas.php")
    .then(response => response.json())
    .then(tarefas => {
      tarefas.forEach(tarefa => {
        const tarefaDataHora = new Date(tarefa.data_hora);
        const diff = tarefaDataHora - now;
        const minutos = 10 * 60 * 1000; // 10 minutos antes do horário da tarefa

        if (diff > 0 && diff <= minutos && tarefa.status === "pendente") {
          alert(`Alerta: A tarefa "${tarefa.titulo}" está próxima do horário!`);
        }
      });
    });
}

document.addEventListener("DOMContentLoaded", () => {
  carregarTarefas();
  setInterval(verificarAlarmes, 60000); // Verifica alarmes a cada minuto
});
