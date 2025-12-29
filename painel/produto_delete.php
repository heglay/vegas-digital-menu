<?php
// Vegas Digital Menu - Delete Product
session_start();

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: /painel/login.php');
    exit;
}

require_once __DIR__ . '/../config/database.php';

$id = $_GET['id'] ?? 0;

// Validate ID
if (!is_numeric($id) || $id <= 0) {
    $_SESSION['message'] = 'ID de produto inválido.';
    $_SESSION['message_type'] = 'error';
    header('Location: /painel/index.php');
    exit;
}

$conn = getConnection();

// Check if product exists
$stmt = $conn->prepare("SELECT nome FROM produtos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['message'] = 'Produto não encontrado.';
    $_SESSION['message_type'] = 'error';
    $stmt->close();
    $conn->close();
    header('Location: /painel/index.php');
    exit;
}

$product = $result->fetch_assoc();
$stmt->close();

// Delete product using prepared statement
$stmt = $conn->prepare("DELETE FROM produtos WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    $_SESSION['message'] = 'Produto "' . $product['nome'] . '" excluído com sucesso!';
    $_SESSION['message_type'] = 'success';
} else {
    $_SESSION['message'] = 'Erro ao excluir produto: ' . $conn->error;
    $_SESSION['message_type'] = 'error';
}

$stmt->close();
$conn->close();

header('Location: /painel/index.php');
exit;
?>
