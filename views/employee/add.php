<?php
require_once __DIR__ . '/../../services/EmployeeService.php';
require_once __DIR__ . '/../../services/CompanyService.php';

$employeeService = new EmployeeService();
$companyService = new CompanyService();

$message = '';
$messageType = 'error';
$errors = [];
$companies = [];

try {
    $companies = $companyService->listCompanies();
} catch (Exception $e) {
    $message = $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $employeeService->registerEmployee($_POST);
        $message = "Funcionário cadastrado com sucesso!";
        $messageType = 'success';
    } catch (Exception $e) {
        $errors[] = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Novo Funcionário</title>
    <style>
        .error-feedback { color: red; font-size: 0.9em; }
    </style>
</head>
<body>
    <h1>Cadastrar Novo Funcionário</h1>
    <?php if (!empty($message)): ?>
        <p style="color: <?= $messageType === 'success' ? 'green' : 'red'; ?>;">
            <?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?>
        </p>
    <?php endif; ?>

    <form action="" method="POST">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($_POST['nome'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
        <?php if (in_array("O campo nome é obrigatório.", $errors)): ?>
            <span class="error-feedback">O campo nome é obrigatório.</span>
        <?php endif; ?>
        <br><br>

        <label for="cpf">CPF:</label>
        <input type="text" id="cpf" name="cpf" value="<?= htmlspecialchars($_POST['cpf'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
        <?php if (in_array("O CPF informado já está cadastrado.", $errors)): ?>
            <span class="error-feedback">O CPF informado já está cadastrado.</span>
        <?php endif; ?>
        <br><br>

        <label for="rg">RG:</label>
        <input type="text" id="rg" name="rg" value="<?= htmlspecialchars($_POST['rg'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
        <?php if (in_array("O RG informado já está cadastrado.", $errors)): ?>
            <span class="error-feedback">O RG informado já está cadastrado.</span>
        <?php endif; ?>
        <br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
        <?php if (in_array("O email informado já está cadastrado.", $errors)): ?>
            <span class="error-feedback">O email informado já está cadastrado.</span>
        <?php endif; ?>
        <br><br>

        <label for="empresa">Empresa:</label>
        <select id="empresa" name="id_empresa" required>
            <option value="">Selecione uma empresa</option>
            <?php foreach ($companies as $company): ?>
                <option value="<?= $company['id_empresa'] ?>" <?= ($_POST['id_empresa'] ?? '') == $company['id_empresa'] ? 'selected' : ''; ?>>
                    <?= htmlspecialchars($company['nome'], ENT_QUOTES, 'UTF-8') ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br><br>

        <label for="salario">Salário:</label>
        <input type="text" id="salario" name="salario" value="<?= htmlspecialchars($_POST['salario'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"><br><br>

        <label for="bonificacao">Bonificação:</label>
        <input type="text" id="bonificacao" name="bonificacao" value="<?= htmlspecialchars($_POST['bonificacao'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"><br><br>

        <label for="data_cadastro">Data de Cadastro:</label>
        <input type="date" id="data_cadastro" name="data_cadastro" value="<?= htmlspecialchars($_POST['data_cadastro'] ?? date('Y-m-d'), ENT_QUOTES, 'UTF-8'); ?>"><br><br>

        <button type="submit">Cadastrar Funcionário</button>
    </form>
</body>
</html>

