<?php
require_once __DIR__ . '/../services/CompanyService.php';

class CompanyController {
    private $companyService;

    public function __construct() {
        $this->companyService = new CompanyService();
    }

    public function register($data) {
        return $this->companyService->registerCompany($data);
    }

    public function listCompanies() {
        return $this->companyService->listCompanies();
    }
}
?>