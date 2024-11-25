<?php
session_start();
require '../db.php';

if (!isset($_SESSION['funcionario_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $imagem_url = trim($_POST['imagem_url']);

    if (empty($nome) || empty($imagem_url)) {
        $erro = "Todos os campos são obrigatórios.";
    } elseif (!filter_var($imagem_url, FILTER_VALIDATE_URL)) {
        $erro = "A URL da imagem é inválida.";
    } else {
        $query = $conn->prepare("INSERT INTO bolos (nome, imagem_url) VALUES (?, ?)");
        $query->bind_param("ss", $nome, $imagem_url);

        if ($query->execute()) {
            header("Location: dashboard.php");
            exit();
        } else {
            $erro = "Erro ao salvar o bolo. Tente novamente.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Adicionar Bolo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="..\mycss\styles.css">
</head>
<body class="row">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="dashboard.php">Administração</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="criar_funcionario.php">Criar Funcionário</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="logout.php">Sair</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="col-sm-8">
        <img class="prep" src="..\assets\boloprep_1.png" alt="">
    </div>
    <div class="login col-sm-4 container mt-6" style="background-color: white; opacity: 85%;">
        <h1 class="text-center">Adicionar Novo Bolo</h1>
            <?php if (isset($erro)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div>
            <?php endif; ?>
            <form class="login" method="post" class="card p-4 shadow-sm">
                <div class="mb-3">
                    <label for="nome" class="form-label">Nome do Bolo:</label>
                    <input type="text" id="nome" name="nome" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="imagem_url" class="form-label">URL da Imagem:</label>
                    <input type="text" id="imagem_url" name="imagem_url" class="form-control" required oninput="updateImage()">
                </div>
                <!-- Elemento da imagem -->
                <div class="mt-3 mt d-flex justify-content-center">
                    <img id="previewImage" src="" alt="Pré-visualização do bolo" class="img-fluid" style="max-height: 300px; display: none; border: 1px solid #ccc; padding: 10px;">
                </div>
                <button type="submit" class="btn btn-success w-100">Adicionar Bolo</button>
            </form>
            <a href="dashboard.php" class="btn btn-link mt-3">Voltar para o Dashboard</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function updateImage() {
            const imageUrl = document.getElementById('imagem_url').value;
            const previewImage = document.getElementById('previewImage');
            
            if (imageUrl) {
                previewImage.src = imageUrl;
                previewImage.style.display = 'block';
            } else {
                previewImage.style.display = 'none';
            }
        }
    </script>
</body>
</html>
