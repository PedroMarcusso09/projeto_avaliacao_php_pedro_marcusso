<?php
require_once __DIR__ . '/../config/database.php';

class Employee {
    private $connection;

    public function __construct() {
        $this->connection = Connect::$connection;
    }

    public function getAll($limit = null, $offset = null) {
        $sql = "SELECT f.*, e.nome AS empresa FROM tbl_funcionario f 
                JOIN tbl_empresa e ON f.id_empresa = e.id_empresa";
        if ($limit !== null && $offset !== null) {
            $sql .= " LIMIT :limit OFFSET :offset";
        }
        $stmt = $this->connection->prepare($sql);
        if ($limit !== null && $offset !== null) {
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCount() {
        $sql = "SELECT COUNT(*) FROM tbl_funcionario";
        $stmt = $this->connection->query($sql);
        return $stmt->fetchColumn();
    }

    public function getById($id) {
        $sql = "SELECT * FROM tbl_funcionario WHERE id_funcionario = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function register($data) {
        $sql = "INSERT INTO tbl_funcionario (nome, cpf, rg, email, id_empresa, data_cadastro, salario, bonificacao) 
                VALUES (:nome, :cpf, :rg, :email, :id_empresa, :data_cadastro, :salario, :bonificacao)";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([
            'nome' => $data['nome'],
            'cpf' => $data['cpf'],
            'rg' => $data['rg'],
            'email' => $data['email'],
            'id_empresa' => $data['id_empresa'],
            'data_cadastro' => $data['data_cadastro'] ?? date('Y-m-d'),
            'salario' => $data['salario'] ?? null,
            'bonificacao' => $data['bonificacao'] ?? null,
        ]);
    }

    public function update($id, $data) {
        $sql = "UPDATE tbl_funcionario 
                SET nome = :nome, cpf = :cpf, rg = :rg, email = :email, id_empresa = :id_empresa, salario = :salario 
                WHERE id_funcionario = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([
            'nome' => $data['nome'],
            'cpf' => $data['cpf'],
            'rg' => $data['rg'],
            'email' => $data['email'],
            'id_empresa' => $data['id_empresa'],
            'salario' => $data['salario'],
            'id' => $id
        ]);
    }

    public function delete($id) {
        $sql = "DELETE FROM tbl_funcionario WHERE id_funcionario = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(['id' => $id]);
    }

    public function isFieldRegistered($field, $value) {
        $sql = "SELECT COUNT(*) FROM tbl_funcionario WHERE $field = :value";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(['value' => $value]);
        return $stmt->fetchColumn() > 0;
    }
}