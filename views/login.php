<?php
require_once __DIR__ . '/../services/UserService.php';

$service = new UserService();
$message = "";
$messageType = "error";
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = $service->handleLogin($_POST);
    $message = $response['message'];
    $messageType = $response['messageType'];
    $errors = $response['errors'] ?? [];

    if (!empty($response['redirect'])) {
        echo "<script>
            setTimeout(function() {
                window.location.href = '{$response['redirect']}';
            }, 2000);
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Controle de Funcionários</title>
    <style>
        .error { color: red; }
        .success { color: green; }
        .error-feedback { color: red; font-size: 0.9em; }
    </style>
</head>
<body>
    <h1>Login</h1>

    <?php if (!empty($message)): ?>
        <p class="<?= htmlspecialchars($messageType, ENT_QUOTES, 'UTF-8'); ?>">
            <?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?>
        </p>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="login">Login (Email):</label><br>
        <input type="text" id="login" name="login" 
               value="<?= htmlspecialchars($_POST['login'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
        <?php if (!empty($errors['login'])): ?>
            <span class="error-feedback"><?= htmlspecialchars($errors['login'], ENT_QUOTES, 'UTF-8'); ?></span>
        <?php endif; ?>
        <br><br>

        <label for="senha">Senha:</label><br>
        <input type="password" id="senha" name="senha" required>
        <?php if (!empty($errors['senha'])): ?>
            <span class="error-feedback"><?= htmlspecialchars($errors['senha'], ENT_QUOTES, 'UTF-8'); ?></span>
        <?php endif; ?>
        <br><br>

        <button type="submit">Entrar</button>
    </form>
</body>
</html>

