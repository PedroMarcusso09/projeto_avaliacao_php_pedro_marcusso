<?php
require_once __DIR__ . '/../../services/CompanyService.php';

$service = new CompanyService();
$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $message = $service->registerCompany($_POST);
        $messageType = 'success';
    } catch (Exception $e) {
        $message = $e->getMessage();
        $messageType = 'error';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Nova Empresa</title>
    <style>
        .success { color: green; }
        .error { color: red; }
        .feedback { margin-top: 10px; font-size: 0.9em; }
    </style>
</head>
<body>
    <h1>Cadastrar Nova Empresa</h1>

    <?php if (!empty($message)): ?>
        <p class="feedback <?= htmlspecialchars($messageType, ENT_QUOTES, 'UTF-8'); ?>">
            <?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?>
        </p>
    <?php endif; ?>

    <form action="" method="POST">
        <label for="nome">Nome da Empresa:</label><br>
        <input type="text" id="nome" name="nome" placeholder="Digite o nome da empresa" required>
        <br><br>
        <button type="submit">Cadastrar Empresa</button>
    </form>
</body>
</html>