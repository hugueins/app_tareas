<?php
require_once './config/config.php';

class UserModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function login($username, $password) {
        $stmt = $this->db->prepare("SELECT id, name, username, email FROM users WHERE username = ? AND password = ?");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            return [
                'success' => true,
                'message' => 'Login exitoso',
                'data' => [
                    'user' => $user
                ]
            ];
        }
        
        return [
            'success' => false,
            'message' => 'Credenciales inválidas'
        ];
    }
}
?>