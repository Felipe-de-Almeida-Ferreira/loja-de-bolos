<?php
$host = 'localhost';
$db = 'loja_bolos';
$user = 'root';
$password = '';

// Ativar relatório de erros detalhados do MySQLi
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Conexão com o banco de dados
$conn = new mysqli($host, $user, $password, $db, $porta);

// Verifica se houve erro na conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
?>
