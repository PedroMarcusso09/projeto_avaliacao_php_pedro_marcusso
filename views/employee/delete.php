<?php
require_once __DIR__ . '/../../services/EmployeeService.php';

$service = new EmployeeService();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    try {
        $id = intval($_GET['id']);
        $employee = $service->getEmployeeById($id);

        if (!$employee) {
            throw new Exception("Funcionário não encontrado.");
        }

        $service->deleteEmployee($id);
        header("Location: list.php?message=Funcionário excluído com sucesso!");
        exit();
    } catch (Exception $e) {
        header("Location: list.php?message=" . urlencode($e->getMessage()));
        exit();
    }
}
?>

