<?php
require_once __DIR__ . '/../config/database.php';

class Company {
    private $connection;

    public function __construct() {
        $this->connection = Connect::$connection;
    }

    public function isNameRegistered($nome) {
        $sql = "SELECT COUNT(*) FROM tbl_empresa WHERE nome = :nome";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(['nome' => $nome]);
        return $stmt->fetchColumn() > 0;
    }

    public function register($nome) {
        $sql = "INSERT INTO tbl_empresa (nome) VALUES (:nome)";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(['nome' => $nome]);
        return true;
    }

    public function listAll() {
        $sql = "SELECT id_empresa, nome FROM tbl_empresa";
        $stmt = $this->connection->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
