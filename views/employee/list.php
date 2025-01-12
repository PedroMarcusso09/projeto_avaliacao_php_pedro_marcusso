<?php
require_once __DIR__ . '/../../services/EmployeeService.php';

$service = new EmployeeService();
$message = '';
$messageType = 'error';
$page = $_GET['page'] ?? 1;
$limit = 10;
$offset = ($page - 1) * $limit;

try {
    $employees = $service->listWithPagination($limit, $offset);
    $totalEmployees = $service->getEmployeeCount();
    $totalPages = ceil($totalEmployees / $limit);
} catch (Exception $e) {
    $message = $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Funcionários - Lista</title>
</head>
<body>
    <h1>Lista de Funcionários</h1>
    <a href="../employee/add.php">Cadastrar Funcionário</a>
    <a href="export_pdf.php" target="_blank">Exportar para PDF</a>
    <a href="../company/add.php">Cadastrar Empresa</a>
    <?php if ($message): ?>
        <p style="color: red;"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></p>
    <?php endif; ?>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>CPF</th>
                <th>RG</th>
                <th>Email</th>
                <th>Empresa</th>
                <th>Data de Cadastro</th>
                <th>Salário</th>
                <th>Bonificação</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($employees): ?>
                <?php foreach ($employees as $employee): ?>
                    <tr style="background-color: <?= htmlspecialchars($employee['color'] ?? '', ENT_QUOTES, 'UTF-8'); ?>; color: <?= $employee['color'] === 'red' ? 'white' : 'black'; ?>;">
                    <td><?= htmlspecialchars($employee['id_funcionario'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?= htmlspecialchars($employee['nome'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?= htmlspecialchars($employee['cpf'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?= htmlspecialchars($employee['rg'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?= htmlspecialchars($employee['email'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?= htmlspecialchars($employee['empresa'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?= htmlspecialchars(date('d/m/Y', strtotime($employee['data_cadastro'])), ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?= htmlspecialchars('R$ ' . number_format($employee['salario'], 2, ',', '.'), ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?= htmlspecialchars('R$ ' . number_format($employee['bonificacao'], 2, ',', '.'), ENT_QUOTES, 'UTF-8'); ?></td>
                        <td>
                            <a href="edit.php?id=<?= $employee['id_funcionario']; ?>">Editar</a>
                            <a href="delete.php?id=<?= $employee['id_funcionario']; ?>" onclick="return confirm('Tem certeza que deseja excluir este funcionário?')">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="10">Nenhum funcionário encontrado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div>
        <p>Páginas:</p>
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?page=<?= $i; ?>"><?= $i; ?></a>
        <?php endfor; ?>
    </div>
</body>
</html>


