<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../utils/Validator.php';

class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
        $this->startSession();
    }

    private function startSession() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function authenticate($login, $senha) {
        Validator::validateRequiredFields(compact('login', 'senha'), ['login', 'senha']);
        Validator::validateEmail($login);

        $user = $this->userModel->authenticate($login, $senha);

        if ($user) {
            return [
                'id_usuario' => $user['id_usuario'],
                'login' => $user['login'],
                'nome' => $user['nome'] ?? ''
            ];
        }

        throw new Exception("Login ou senha inválidos.");
    }

}
?>