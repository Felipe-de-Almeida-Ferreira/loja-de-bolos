<?php
session_start();
require '../db.php';

// Verifica se o funcionário está autenticado
if (!isset($_SESSION['funcionario_id'])) {
    header("Location: login.php");
    exit();
}

// Verifica se o ID do bolo foi passado
if (isset($_GET['id'])) {
    $id_bolo = $_GET['id'];

    // Busca o bolo no banco de dados
    $query = $conn->prepare("SELECT * FROM bolos WHERE id = ?");
    $query->bind_param("i", $id_bolo);
    $query->execute();
    $result = $query->get_result();
    $bolo = $result->fetch_assoc();

    if (!$bolo) {
        die("Bolo não encontrado.");
    }

    // Processa o formulário de edição de bolo
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nome = trim($_POST['nome']);
        $imagem_url = trim($_POST['imagem_url']);

        // Valida os dados
        if (empty($nome) || empty($imagem_url)) {
            $erro = "Todos os campos são obrigatórios.";
        } elseif (!filter_var($imagem_url, FILTER_VALIDATE_URL)) {
            $erro = "A URL da imagem é inválida.";
        } else {
            // Atualiza o bolo no banco de dados
            $update_query = $conn->prepare("UPDATE bolos SET nome = ?, imagem_url = ? WHERE id = ?");
            $update_query->bind_param("ssi", $nome, $imagem_url, $id_bolo);

            if ($update_query->execute()) {
                // Redireciona para o dashboard após o sucesso
                header("Location: dashboard.php");
                exit();
            } else {
                $erro = "Erro ao atualizar o bolo. Tente novamente.";
            }
        }
    }
} else {
    die("ID do bolo não fornecido.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Editar Bolo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href=".\css\styles.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h1 class="text-center">Editar Bolo</h1>
        <?php if (isset($erro)) echo "<p style='color:red;'>$erro</p>"; ?>
        <form method="post" class="card p-4 shadow-sm">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome do Bolo:</label>
                <input type="text" id="nome" name="nome" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="imagem_url" class="form-label">URL da Imagem:</label>
                <input type="text" id="imagem_url" name="imagem_url" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success w-100">Adicionar Bolo</button>
        </form>
        <a href="dashboard.php" class="btn btn-link mt-3">Voltar para o Dashboard</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

</html>
    