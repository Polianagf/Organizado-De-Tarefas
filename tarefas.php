<?php
$host = 'localhost';
$db = 'OrganizadorDetarefas';
$user = 'root'; // Altere se necessário
$password = '12345'; // Altere se necessário

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}

$metodo = $_SERVER['REQUEST_METHOD'];

if ($metodo === 'GET') {
    $stmt = $pdo->query("SELECT * FROM tarefas");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
} elseif ($metodo === 'POST') {
    $dados = json_decode(file_get_contents("php://input"), true);
    $titulo = $dados['titulo'];
    $descricao = $dados['descricao'];
    $dataHora = $dados['data_hora'];
    $stmt = $pdo->prepare("INSERT INTO tarefas (titulo, descricao, data_hora) VALUES (:titulo, :descricao, :data_hora)");
    $stmt->execute([':titulo' => $titulo, ':descricao' => $descricao, ':data_hora' => $dataHora]);
} elseif ($metodo === 'PUT') {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("UPDATE tarefas SET status = IF(status='pendente', 'concluida', 'pendente') WHERE id = :id");
    $stmt->execute([':id' => $id]);
} elseif ($metodo === 'DELETE') {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM tarefas WHERE id = :id");
    $stmt->execute([':id' => $id]);
}
?>
