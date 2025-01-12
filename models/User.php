<?php
require_once __DIR__ . '/../config/database.php';

class User {
    private $connection;

    public function __construct() {
        $this->connection = Connect::$connection;
    }

    public function authenticate($login, $senha) {
        $sql = "SELECT * FROM tbl_usuario WHERE login = :login AND senha = MD5(:senha)";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(['login' => $login, 'senha' => $senha]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>