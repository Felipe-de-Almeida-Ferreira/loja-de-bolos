<?php
session_start();
require '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome_usuario = $_POST['nome_usuario'];
    $senha = $_POST['senha'];

    $query = $conn->prepare("SELECT * FROM funcionarios WHERE nome_usuario = ?");
    $query->bind_param("s", $nome_usuario);
    $query->execute();
    $result = $query->get_result();
    $funcionario = $result->fetch_assoc();

    if ($funcionario && password_verify($senha, $funcionario['senha_hash'])) {
        $_SESSION['funcionario_id'] = $funcionario['id'];
        header("Location: dashboard.php");
        exit();
    } else {
        $erro = "Nome de usuário ou senha inválidos.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login - Administração</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="..\css\styles.css">
</head>
<body class="row">
    <div class="col-sm-8">
        <img src="..\assets\bolo3.png" alt="">
    </div>
    <div class="login col-sm-4 container mt-6" style="background-color: white; opacity: 85%;">
        <h1 class="text-center mb-4">Login</h1>
        <?php if (isset($erro)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div>
        <?php endif; ?>
        <form class="login" method="post">
            <div class="mb-3">
                <label for="nome_usuario" class="form-label">Nome de Usuário:</label>
                <input type="text" id="nome_usuario" name="nome_usuario" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="senha" class="form-label">Senha:</label>
                <input type="password" id="senha" name="senha" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Entrar</button>
        </form>
        <a href="../index.php" class="btn btn-link mt-3">Voltar para o catálogo</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
