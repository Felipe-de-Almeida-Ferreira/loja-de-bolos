<?php
session_start();
require '../db.php';

if (!isset($_SESSION['funcionario_id'])) {
    header("Location: login.php");
    exit();
}

$result = $conn->query("SELECT * FROM bolos");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Administração - Bolos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="..\mycss\styles.css">
</head>
<body>
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

    <div class="container mt-5">
        <h1 class="text-center">Gerenciamento de Bolos</h1>
        <a href="criar_bolo.php" class="btn btn-primary mb-3">Adicionar Novo Bolo</a>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Nome</th>
                    <th>Imagem</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($bolo = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($bolo['nome']) ?></td>
                        <td><img src="<?= htmlspecialchars($bolo['imagem_url']) ?>" width="100"></td>
                        <td>
                            <a href="edit_bolo.php?id=<?= $bolo['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a href="deletar_bolo.php?id=<?= $bolo['id'] ?>" class="btn btn-danger btn-sm">Excluir</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
