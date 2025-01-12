<?php
require_once __DIR__ . '/../controllers/UserController.php';

class UserService {
    private $controller;

    public function __construct() {
        $this->controller = new UserController();
    }

    public function handleLogin($data) {
        $errors = [];

        try {
            $login = htmlspecialchars($data['login'] ?? '', ENT_QUOTES, 'UTF-8');
            $senha = htmlspecialchars($data['senha'] ?? '', ENT_QUOTES, 'UTF-8');

            if (empty($login)) {
                $errors['login'] = "O campo login é obrigatório.";
            } else {
                Validator::validateEmail($login);
            }

            if (empty($senha)) {
                $errors['senha'] = "O campo senha é obrigatório.";
            }

            if (!empty($errors)) {
                throw new Exception("Erro ao validar os campos.");
            }

            $this->controller->authenticate($login, $senha);

            return [
                'message' => "Login realizado com sucesso!",
                'messageType' => 'success',
                'redirect' => '../views/employee/list.php',
                'errors' => []
            ];
        } catch (Exception $e) {
            return [
                'message' => $e->getMessage(),
                'messageType' => 'error',
                'redirect' => null,
                'errors' => $errors
            ];
        }
    }
}
