<?php
require_once __DIR__ . '/../models/Company.php';

class CompanyService {
    private $companyModel;

    public function __construct() {
        $this->companyModel = new Company();
    }

    public function registerCompany($data) {
        if (empty($data['nome'])) {
            throw new Exception("O nome da empresa é obrigatório.");
        }

        $nome = trim($data['nome']);

        if ($this->companyModel->isNameRegistered($nome)) {
            throw new Exception("A empresa '{$nome}' já está cadastrada.");
        }

        $this->companyModel->register($nome);
        return "Empresa cadastrada com sucesso!";
    }

    public function listCompanies() {
        return $this->companyModel->listAll();
    }
}
?>