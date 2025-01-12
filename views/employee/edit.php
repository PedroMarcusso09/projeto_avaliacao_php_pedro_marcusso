<?php
require_once __DIR__ . '/../../services/EmployeeService.php';
require_once __DIR__ . '/../../services/CompanyService.php';


$employeeService  = new EmployeeService();
$companyService = new CompanyService(); 
$message = '';
$messageType = 'error';
$errors = [];
$companies = [];
$employee = null;

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    try {
        $id = intval($_GET['id']);
        $employee = $employeeService->getEmployeeById($id);
        $companies = $companyService->listCompanies();

        if (!$employee) {
            throw new Exception("Funcionário não encontrado.");
        }
    } catch (Exception $e) {
        die("Erro ao carregar os dados do funcionário: " . $e->getMessage());
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $employeeService->updateEmployee($_POST['id_funcionario'], $_POST);
        $message = "Funcionário atualizado com sucesso!";
        $messageType = 'success';

        // Redireciona para a lista de funcionários
        header("Location: list.php?message=" . urlencode($message));
        exit();
    } catch (Exception $e) {
        $message = $e->getMessage();
    }
}


?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Funcionário</title>
</head>
<body>
    <h1>Editar Funcionário</h1>
    <?php if (!empty($message)): ?>
        <p style="color: <?= $messageType === 'success' ? 'green' : 'red'; ?>;">
            <?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?>
        </p>
    <?php endif; ?>

    <?php if ($employee): ?>
        <form action="" method="POST">
            <input type="hidden" name="id_funcionario" value="<?= htmlspecialchars($employee['id_funcionario'], ENT_QUOTES, 'UTF-8') ?>">

            <label for="nome">Nome:</label><br>
            <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($employee['nome'], ENT_QUOTES, 'UTF-8') ?>" required><br><br>

            <label for="cpf">CPF:</label><br>
            <input type="text" id="cpf" name="cpf" value="<?= htmlspecialchars($employee['cpf'], ENT_QUOTES, 'UTF-8') ?>" readonly><br><br>

            <label for="rg">RG:</label><br>
            <input type="text" id="rg" name="rg" value="<?= htmlspecialchars($employee['rg'], ENT_QUOTES, 'UTF-8') ?>" readonly><br><br>

            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($employee['email'], ENT_QUOTES, 'UTF-8') ?>" required><br><br>

            <label for="salario">Salário:</label><br>
            <input type="text" id="salario" name="salario" value="<?= htmlspecialchars($employee['salario'], ENT_QUOTES, 'UTF-8') ?>" required><br><br>

            <label for="bonificacao">Bonificação:</label><br>
            <input type="text" id="bonificacao" name="bonificacao" value="<?= htmlspecialchars($employee['bonificacao'], ENT_QUOTES, 'UTF-8') ?>" readonly ><br><br>

            <label for="empresa">Empresa:</label><br>
            <select id="empresa" name="id_empresa" required>
                <?php foreach ($companies as $company): ?>
                    <option value="<?= $company['id_empresa'] ?>" <?= $company['id_empresa'] == $employee['id_empresa'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($company['nome'], ENT_QUOTES, 'UTF-8') ?>
                    </option>
                <?php endforeach; ?>
            </select><br><br>

            <p><strong>Data de Cadastro:</strong> <?= date('d/m/Y', strtotime($employee['data_cadastro'])) ?></p>

            <button type="submit">Atualizar</button>
        </form>
    <?php else: ?>
        <p>Funcionário não encontrado.</p>
    <?php endif; ?>
</body>
</html>

