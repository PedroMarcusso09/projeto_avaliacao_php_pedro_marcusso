<?php
require_once __DIR__ . '/../services/EmployeeService.php';

class EmployeeController {
    private $employeeService;

    public function __construct() {
        $this->employeeService = new EmployeeService();
    }

    public function listWithBonuses() {
        return $this->employeeService->listWithBonuses();
    }
     
    public function listWithPagination($limit, $offset) {
        return $this->employeeService->listWithPagination($limit, $offset);
    }

    public function getEmployeeCount() {
        return $this->employeeService->getEmployeeCount();
    }

    public function register($data) {
        return $this->employeeService->registerEmployee($data);
    }

    public function getById($id) {
        return $this->employeeService->getEmployeeById($id);
    }

    public function update($id, $data) {
        return $this->employeeService->updateEmployee($id, $data);
    }

    public function delete($id) {
        return $this->employeeService->deleteEmployee($id);
    }
}
?>