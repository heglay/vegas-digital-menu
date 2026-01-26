<?php
// Vegas Digital Menu - Admin Panel Main Page
session_start();

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: /painel/login.php');
    exit;
}

require_once __DIR__ . '/../config/database.php';

$message = $_SESSION['message'] ?? '';
$message_type = $_SESSION['message_type'] ?? '';
unset($_SESSION['message'], $_SESSION['message_type']);

// Get all products
$conn = getConnection();
$query = "SELECT * FROM produtos ORDER BY categoria, nome";
$result = $conn->query($query);

$products = [];
if ($result && $result->num_rows > 0) {
    $products = $result->fetch_all(MYSQLI_ASSOC);
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo - Vegas Motel</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <header class="admin-header">
        <div class="container">
            <nav class="admin-nav">
                <h1>🌟 Vegas Motel - Painel Administrativo</h1>
                <div>
                    <a href="/" class="btn btn-secondary" target="_blank">Ver Cardápio</a>
                    <a href="/painel/logout.php" class="btn btn-danger">Sair</a>
                </div>
            </nav>
        </div>
    </header>

    <main class="container">
        <?php if (!empty($message)): ?>
            <div class="alert alert-<?php echo $message_type; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <div style="margin-bottom: 20px;">
            <a href="/painel/produto_add.php" class="btn btn-primary">➕ Adicionar Novo Produto</a>
        </div>

        <div class="table-container">
            <h2 style="margin-bottom: 20px; color: var(--color-neon-pink);">Produtos Cadastrados</h2>
            
            <?php if (empty($products)): ?>
                <p>Nenhum produto cadastrado ainda.</p>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Categoria</th>
                            <th>Preço</th>
                            <th>Disponível</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $produto): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($produto['id']); ?></td>
                                <td><?php echo htmlspecialchars($produto['nome']); ?></td>
                                <td><?php echo htmlspecialchars($produto['categoria']); ?></td>
                                <td>R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></td>
                                <td><?php echo $produto['disponivel'] ? '✅ Sim' : '❌ Não'; ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="/painel/produto_edit.php?id=<?php echo $produto['id']; ?>" class="btn btn-sm btn-primary">✏️ Editar</a>
                                        <a href="/painel/produto_delete.php?id=<?php echo $produto['id']; ?>" 
                                           class="btn btn-sm btn-danger" 
                                           onclick="return confirm('Tem certeza que deseja excluir este produto?');">🗑️ Excluir</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </main>

    <footer class="footer">
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> Vegas Motel - Painel Administrativo</p>
        </div>
    </footer>
</body>
</html>
