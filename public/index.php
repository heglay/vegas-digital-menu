<?php
// Vegas Digital Menu - Public Menu Page
require_once __DIR__ . '/config/database.php';

// Get all available products grouped by category
$conn = getConnection();
$query = "SELECT * FROM produtos WHERE disponivel = TRUE ORDER BY categoria, nome";
$result = $conn->query($query);

$products = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[$row['categoria']][] = $row;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vegas Motel - Cardápio Digital</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <h1>🌟 Vegas Motel 🌟</h1>
            <p>Cardápio Digital - Desfrute de nossa seleção especial</p>
        </div>
    </header>

    <main class="container">
        <?php if (empty($products)): ?>
            <div class="alert alert-info">
                <p>Nosso cardápio está sendo atualizado. Por favor, volte em breve!</p>
            </div>
        <?php else: ?>
            <?php foreach ($products as $categoria => $items): ?>
                <section class="menu-category">
                    <h2 class="category-title"><?php echo htmlspecialchars($categoria); ?></h2>
                    <div class="product-grid">
                        <?php foreach ($items as $produto): ?>
                            <div class="product-card <?php echo !$produto['disponivel'] ? 'product-unavailable' : ''; ?>">
                                <h3 class="product-name"><?php echo htmlspecialchars($produto['nome']); ?></h3>
                                <?php if (!empty($produto['descricao'])): ?>
                                    <p class="product-description"><?php echo htmlspecialchars($produto['descricao']); ?></p>
                                <?php endif; ?>
                                <div class="product-price">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></div>
                                <?php if (!$produto['disponivel']): ?>
                                    <span class="unavailable-badge">Indisponível</span>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endforeach; ?>
        <?php endif; ?>
    </main>

    <footer class="footer">
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> Vegas Motel - Todos os direitos reservados</p>
        </div>
    </footer>
</body>
</html>
