<?php

require_once('functions.php');

class Register {
    private $username;
    private $email;
    private $password;
    private $connectionDB;
    private $result_code; // Guardará el código de resultado del SP

    public function __construct($username, $email, $password) {
        // Asumimos que functions.php tiene estas funciones
        $this->username = secure_data($username);
        $this->email = secure_data($email);
        $this->password = hash_password(secure_data($password)); // Hashea la contraseña
        $this->connectionDB = connectionDB();

        try {
            $this->create_user();
        } catch (Exception $e) {
            die('ERROR: ' . $e->getMessage());
        }
    }

    private function create_user() {
        // 1. Preparamos la llamada al procedimiento almacenado
        $stmt = $this->connectionDB->prepare("CALL RegisterUser(:username, :email, :password, @result_code)");

        // 2. Vinculamos los parámetros de entrada (IN)
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $this->password);
        
        // 3. Ejecutamos la llamada
        $stmt->execute();
        $stmt->closeCursor(); // Importante cerrar el cursor para la siguiente consulta

        // 4. Obtenemos el valor del parámetro de salida (OUT)
        $result = $this->connectionDB->query("SELECT @result_code AS result_code")->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $this->result_code = $result['result_code'];
        }
    }

    public function get_confirmation() {
        // 5. Devolvemos un mensaje basado en el código de resultado
        switch ($this->result_code) {
            case 0:
                return '✨ Usuario creado con éxito.';
            case 1:
                return 'El email ya existe en el sistema.';
            case 2:
                return 'El nombre de usuario ya está en uso.';
            default:
                return 'Ha ocurrido un error inesperado.';
        }
    }
}
?>