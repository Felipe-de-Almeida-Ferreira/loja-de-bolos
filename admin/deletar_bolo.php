<?php
session_start();
require '../db.php';

// Verifica se o funcionário está autenticado
if (!isset($_SESSION['funcionario_id'])) {
    header("Location: login.php");
    exit();
}

// Verifica se o ID foi passado na URL
if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];

    // Deleta o bolo do banco
    $query = $conn->prepare("DELETE FROM bolos WHERE id = ?");
    $query->bind_param("i", $id);

    if ($query->execute()) {
        header("Location: dashboard.php");
        exit();
    } else {
        $erro = "Erro ao deletar o bolo.";
    }
} else {
    header("Location: dashboard.php");
    exit();
}
?>
