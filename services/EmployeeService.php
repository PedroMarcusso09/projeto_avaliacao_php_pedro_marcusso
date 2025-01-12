<?php
require_once __DIR__ . '/../models/Employee.php';
require_once __DIR__ . '/../utils/Validator.php';

class EmployeeService {
    private $employeeModel;

    public function __construct() {
        $this->employeeModel = new Employee();
    }

    public function listWithPagination($limit, $offset) {
        $employees = $this->employeeModel->getAll($limit, $offset);
        
        foreach ($employees as &$employee) {
            $bonusAndColor = $this->calculateBonusAndColor($employee['data_cadastro'], $employee['salario']);
            $employee['bonificacao'] = $bonusAndColor['bonus'];
            $employee['color'] = $bonusAndColor['color'];
        }
        
        return $employees;
    }
    

    public function getEmployeeCount() {
        return $this->employeeModel->getCount();
    }

    public function registerEmployee($data) {
        Validator::validateRequiredFields($data, ['nome', 'cpf', 'rg', 'email', 'id_empresa']);
        Validator::validateEmail($data['email']);
        Validator::validateCPF($data['cpf']);

        if ($this->employeeModel->isFieldRegistered('cpf', $data['cpf'])) {
            throw new Exception("O CPF informado já está cadastrado.");
        }

        if ($this->employeeModel->isFieldRegistered('rg', $data['rg'])) {
            throw new Exception("O RG informado já está cadastrado.");
        }

        if ($this->employeeModel->isFieldRegistered('email', $data['email'])) {
            throw new Exception("O email informado já está cadastrado.");
        }

        $this->employeeModel->register($data);
    }

    public function getEmployeeById($id) {
        return $this->employeeModel->getById($id);
    }

    public function updateEmployee($id, $data) {
        Validator::validateRequiredFields($data, ['nome', 'cpf', 'rg', 'email', 'id_empresa', 'salario']);
        $this->employeeModel->update($id, $data);
    }
    

    public function deleteEmployee($id) {
        $this->employeeModel->delete($id);
    }

    public function listWithBonuses() {
        $employees = $this->employeeModel->getAll();
    
        foreach ($employees as &$employee) {
            $bonusAndColor = $this->calculateBonusAndColor($employee['data_cadastro'], $employee['salario']);
            $employee['bonificacao'] = $bonusAndColor['bonus'];
            $employee['color'] = $bonusAndColor['color'];
        }
    
        return $employees;
    }
    
    private function calculateBonusAndColor($dataCadastro, $salario) {
        $currentDate = new DateTime();
        $entryDate = new DateTime($dataCadastro);
        $interval = $entryDate->diff($currentDate);
    
        $years = $interval->y;
        $bonus = 0;
        $color = '';
    
        if ($years > 5) {
            $bonus = $salario * 0.20; 
            $color = 'red'; 
        } elseif ($years > 1) {
            $bonus = $salario * 0.10; 
            $color = 'blue';
        }
    
        return ['bonus' => $bonus, 'color' => $color];
    }
    
}
