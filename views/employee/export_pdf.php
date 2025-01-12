<?php
require_once __DIR__ . '/../../libs/fpdf186/fpdf.php';
require_once __DIR__ . '/../../services/EmployeeService.php';

$service = new EmployeeService();
$employees = $service->listWithBonuses();

if (empty($employees)) {
    die('Nenhum funcionário encontrado para exportar.');
}

$pdf = new FPDF('L', 'mm', 'A4');
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);

$pdf->Cell(0, 10, utf8_decode('Lista de Funcionários'), 0, 1, 'C');
$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(200, 200, 200);
$pdf->Cell(15, 10, 'ID', 1, 0, 'C', true);
$pdf->Cell(40, 10, 'Nome', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'CPF', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'RG', 1, 0, 'C', true);
$pdf->Cell(50, 10, 'Email', 1, 0, 'C', true);
$pdf->Cell(40, 10, 'Empresa', 1, 0, 'C', true);
$pdf->Cell(25, 10, 'Salário', 1, 0, 'C', true);
$pdf->Cell(25, 10, 'Bonificação', 1, 1, 'C', true); 

$pdf->SetFont('Arial', '', 10);

foreach ($employees as $employee) {
    if ($employee['color'] === 'red') {
        $pdf->SetFillColor(255, 200, 200);
    } elseif ($employee['color'] === 'blue') {
        $pdf->SetFillColor(200, 200, 255);
    } else {
        $pdf->SetFillColor(255, 255, 255);
    }

    $pdf->Cell(15, 8, $employee['id_funcionario'], 1, 0, 'C', true);
    $pdf->Cell(40, 8, utf8_decode($employee['nome']), 1, 0, 'L', true);
    $pdf->Cell(30, 8, utf8_decode($employee['cpf']), 1, 0, 'L', true);
    $pdf->Cell(30, 8, utf8_decode($employee['rg']), 1, 0, 'L', true);
    $pdf->Cell(50, 8, utf8_decode($employee['email']), 1, 0, 'L', true);
    $pdf->Cell(40, 8, utf8_decode($employee['empresa']), 1, 0, 'L', true);
    $pdf->Cell(25, 8, 'R$ ' . number_format($employee['salario'], 2, ',', '.'), 1, 0, 'R', true);
    $pdf->Cell(25, 8, 'R$ ' . number_format($employee['bonificacao'], 2, ',', '.'), 1, 1, 'R', true);
}

$pdf->Output('D', 'lista_funcionarios.pdf');
?>
