<?php
require_once('functions.php'); // Asegúrate de que este archivo exista

class Login {
    private $email;
    private $password;
    private $connectionDB;

    public function __construct($email, $password) {
        $this->email = secure_data($email);
        $this->password = secure_data($password);
        $this->connectionDB = connectionDB();
        $this->authenticate_user();
    }

    private function authenticate_user() {
        $stmt = $this->connectionDB->prepare("CALL GetUserByEmail(:email)");
        $stmt->bindParam(':email', $this->email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        // Dividimos la validación en dos pasos
        if ($user) {
            // PASO 1: El usuario SÍ existe. Ahora verificamos la contraseña.
            if (password_verify($this->password, $user['PASSWORD'])) {
                // Autenticación exitosa: la contraseña es correcta
                ob_start();
                session_start();
                $_SESSION['user_id'] = $user['ID_USER'];
                $_SESSION['username'] = $user['USERNAME'];
                $_SESSION['email'] = $this->email;
                $_SESSION['valid'] = true;
                header('Location: index.html');
                exit();
            } else {
                // Fallo: la contraseña es incorrecta
                header('Location: index.php?error=password');
                exit();
            }
        } else {
            // PASO 2: El usuario NO existe (el email no fue encontrado).
            header('Location: index.php?error=email');
            exit();
        }
    }
}
?>