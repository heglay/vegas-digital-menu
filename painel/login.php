<?php
// Vegas Digital Menu - Admin Login
session_start();

// Redirect if already logged in
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: /painel/index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . '/../config/database.php';
    
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (!empty($username) && !empty($password)) {
        $conn = getConnection();
        
        // Use prepared statement to prevent SQL injection
        $stmt = $conn->prepare("SELECT id, password FROM admin_users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            // Verify password
            if (password_verify($password, $user['password'])) {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_id'] = $user['id'];
                $_SESSION['admin_username'] = $username;
                
                header('Location: /painel/index.php');
                exit;
            } else {
                $error = 'Usuário ou senha inválidos.';
            }
        } else {
            $error = 'Usuário ou senha inválidos.';
        }
        
        $stmt->close();
        $conn->close();
    } else {
        $error = 'Por favor, preencha todos os campos.';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Painel Administrativo</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h2>🌟 Vegas Motel 🌟</h2>
            <h3 style="text-align: center; color: var(--color-gray); margin-bottom: 30px;">Painel Administrativo</h3>
            
            <?php if (!empty($error)): ?>
                <div class="alert alert-error">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label for="username">Usuário</label>
                    <input type="text" id="username" name="username" class="form-control" required autofocus>
                </div>
                
                <div class="form-group">
                    <label for="password">Senha</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
                
                <button type="submit" class="btn btn-primary" style="width: 100%;">Entrar</button>
            </form>
            
            <p style="text-align: center; margin-top: 20px; color: var(--color-gray);">
                <a href="/" style="color: var(--color-neon-pink);">← Voltar para o Cardápio</a>
            </p>
        </div>
    </div>
</body>
</html>
