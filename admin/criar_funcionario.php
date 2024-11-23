<?php
session_start();
require '../db.php';

if (!isset($_SESSION['funcionario_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome_usuario']);
    $senha = trim($_POST['senha']);
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    if (empty($nome) || empty($senha)) {
        $erro = "Todos os campos são obrigatórios.";
    } else {
        $query = $conn->prepare("INSERT INTO funcionarios (nome_usuario, senha_hash) VALUES (?, ?)");
        $query->bind_param("ss", $nome, $senha_hash); // Substituído $nome_usuario por $nome

        if ($query->execute()) {
            header("Location: dashboard.php");
            exit();
        } else {
            $erro = "Erro ao salvar o funcionário. Tente novamente.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Criar novo funcionário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="..\mycss\styles.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <h1 class="text-center mb-4">Cadastrar Funcionário</h1>
                <?php if (isset($erro)): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div>
                <?php endif; ?>
                <form method="post" class="card p-4 shadow-sm">
                    <div class="mb-3">
                        <label for="nome_usuario" class="form-label">Nome de Usuário:</label>
                        <input type="text" id="nome_usuario" name="nome_usuario" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="senha" class="form-label">Senha:</label>
                        <input type="password" id="senha" name="senha" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Cadastrar</button>
                </form>
            </div>
            <div class="d-flex justify-content-center mb-3">
            <a href="dashboard.php" class="btn btn-link mt-3">Voltar para o Dashboard</a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
