<?php
// Vegas Digital Menu - Add Product
session_start();

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: /painel/login.php');
    exit;
}

require_once __DIR__ . '/../config/database.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $preco = $_POST['preco'] ?? '';
    $categoria = trim($_POST['categoria'] ?? '');
    $disponivel = isset($_POST['disponivel']) ? 1 : 0;
    
    // Validate inputs
    if (empty($nome)) {
        $error = 'O nome do produto é obrigatório.';
    } elseif (empty($preco) || !is_numeric($preco) || $preco < 0) {
        $error = 'O preço deve ser um valor válido.';
    } elseif (empty($categoria)) {
        $error = 'A categoria é obrigatória.';
    } else {
        $conn = getConnection();
        
        // Use prepared statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO produtos (nome, descricao, preco, categoria, disponivel) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdsi", $nome, $descricao, $preco, $categoria, $disponivel);
        
        if ($stmt->execute()) {
            $_SESSION['message'] = 'Produto adicionado com sucesso!';
            $_SESSION['message_type'] = 'success';
            header('Location: /painel/index.php');
            exit;
        } else {
            $error = 'Erro ao adicionar produto: ' . $conn->error;
        }
        
        $stmt->close();
        $conn->close();
    }
}

// Get existing categories for dropdown
$conn = getConnection();
$categories_query = "SELECT DISTINCT categoria FROM produtos ORDER BY categoria";
$categories_result = $conn->query($categories_query);
$categories = [];
if ($categories_result && $categories_result->num_rows > 0) {
    while ($row = $categories_result->fetch_assoc()) {
        $categories[] = $row['categoria'];
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Produto - Vegas Motel</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <header class="admin-header">
        <div class="container">
            <nav class="admin-nav">
                <h1>🌟 Adicionar Novo Produto</h1>
                <a href="/painel/index.php" class="btn btn-secondary">← Voltar</a>
            </nav>
        </div>
    </header>

    <main class="container">
        <div class="table-container" style="max-width: 800px; margin: 0 auto;">
            <?php if (!empty($error)): ?>
                <div class="alert alert-error">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="form-group">
                    <label for="nome">Nome do Produto *</label>
                    <input type="text" id="nome" name="nome" class="form-control" required 
                           value="<?php echo htmlspecialchars($_POST['nome'] ?? ''); ?>">
                </div>

                <div class="form-group">
                    <label for="descricao">Descrição</label>
                    <textarea id="descricao" name="descricao" class="form-control" rows="3"><?php echo htmlspecialchars($_POST['descricao'] ?? ''); ?></textarea>
                </div>

                <div class="form-group">
                    <label for="preco">Preço (R$) *</label>
                    <input type="number" id="preco" name="preco" class="form-control" step="0.01" min="0" required
                           value="<?php echo htmlspecialchars($_POST['preco'] ?? ''); ?>">
                </div>

                <div class="form-group">
                    <label for="categoria">Categoria *</label>
                    <input type="text" id="categoria" name="categoria" class="form-control" required 
                           list="categorias-list"
                           value="<?php echo htmlspecialchars($_POST['categoria'] ?? ''); ?>">
                    <datalist id="categorias-list">
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?php echo htmlspecialchars($cat); ?>">
                        <?php endforeach; ?>
                    </datalist>
                    <small style="color: var(--color-gray); display: block; margin-top: 5px;">
                        Você pode selecionar uma categoria existente ou criar uma nova
                    </small>
                </div>

                <div class="form-group">
                    <label style="display: flex; align-items: center; cursor: pointer;">
                        <input type="checkbox" name="disponivel" style="margin-right: 10px;" 
                               <?php echo (isset($_POST['disponivel']) || !isset($_POST['nome'])) ? 'checked' : ''; ?>>
                        <span>Produto disponível</span>
                    </label>
                </div>

                <div style="display: flex; gap: 10px; margin-top: 30px;">
                    <button type="submit" class="btn btn-success">✅ Adicionar Produto</button>
                    <a href="/painel/index.php" class="btn btn-secondary">❌ Cancelar</a>
                </div>
            </form>
        </div>
    </main>

    <footer class="footer">
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> Vegas Motel - Painel Administrativo</p>
        </div>
    </footer>
</body>
</html>
