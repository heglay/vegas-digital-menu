<?php
// Vegas Digital Menu - Edit Product
session_start();

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: /painel/login.php');
    exit;
}

require_once __DIR__ . '/../config/database.php';

$error = '';
$product = null;
$id = $_GET['id'] ?? 0;

// Validate ID
if (!is_numeric($id) || $id <= 0) {
    $_SESSION['message'] = 'ID de produto inválido.';
    $_SESSION['message_type'] = 'error';
    header('Location: /painel/index.php');
    exit;
}

// Get product data
$conn = getConnection();
$stmt = $conn->prepare("SELECT * FROM produtos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['message'] = 'Produto não encontrado.';
    $_SESSION['message_type'] = 'error';
    header('Location: /painel/index.php');
    exit;
}

$product = $result->fetch_assoc();
$stmt->close();

// Handle form submission
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
        // Use prepared statement to prevent SQL injection
        $stmt = $conn->prepare("UPDATE produtos SET nome = ?, descricao = ?, preco = ?, categoria = ?, disponivel = ? WHERE id = ?");
        $stmt->bind_param("ssdsii", $nome, $descricao, $preco, $categoria, $disponivel, $id);
        
        if ($stmt->execute()) {
            $_SESSION['message'] = 'Produto atualizado com sucesso!';
            $_SESSION['message_type'] = 'success';
            $stmt->close();
            $conn->close();
            header('Location: /painel/index.php');
            exit;
        } else {
            $error = 'Erro ao atualizar produto: ' . $conn->error;
        }
        
        $stmt->close();
    }
}

// Get existing categories for dropdown
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
    <title>Editar Produto - Vegas Motel</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <header class="admin-header">
        <div class="container">
            <nav class="admin-nav">
                <h1>🌟 Editar Produto</h1>
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
                           value="<?php echo htmlspecialchars($_POST['nome'] ?? $product['nome']); ?>">
                </div>

                <div class="form-group">
                    <label for="descricao">Descrição</label>
                    <textarea id="descricao" name="descricao" class="form-control" rows="3"><?php echo htmlspecialchars($_POST['descricao'] ?? $product['descricao']); ?></textarea>
                </div>

                <div class="form-group">
                    <label for="preco">Preço (R$) *</label>
                    <input type="number" id="preco" name="preco" class="form-control" step="0.01" min="0" required
                           value="<?php echo htmlspecialchars($_POST['preco'] ?? $product['preco']); ?>">
                </div>

                <div class="form-group">
                    <label for="categoria">Categoria *</label>
                    <input type="text" id="categoria" name="categoria" class="form-control" required 
                           list="categorias-list"
                           value="<?php echo htmlspecialchars($_POST['categoria'] ?? $product['categoria']); ?>">
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
                               <?php echo (isset($_POST['disponivel']) || (!isset($_POST['nome']) && $product['disponivel'])) ? 'checked' : ''; ?>>
                        <span>Produto disponível</span>
                    </label>
                </div>

                <div style="display: flex; gap: 10px; margin-top: 30px;">
                    <button type="submit" class="btn btn-success">✅ Salvar Alterações</button>
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
