<?php

class Validator {
    public static function validateRequiredFields($data, $requiredFields) {
        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                throw new Exception("O campo $field é obrigatório.");
            }
        }
    }

    public static function validateEmail($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Email inválido. Por favor, insira um email válido.");
        }
    }
    

    public static function validateCPF($cpf) {
        if (!preg_match('/^\d{11}$/', $cpf)) {
            throw new Exception("CPF inválido. Deve conter 11 dígitos.");
        }
    }

    public static function validateRG($rg) {
        if (!preg_match('/^\d{9}$/', $rg)) {
            throw new Exception("RG inválido. Deve conter 9 dígitos.");
        }
    }

    public static function validateEmployee($data) {
        self::validateRequiredFields($data, ['nome', 'cpf', 'email', 'id_empresa']);
        self::validateEmail($data['email']);
        self::validateCPF($data['cpf']);
    }

    public static function validateDate($date, $format = 'Y-m-d') {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }
    
    
}