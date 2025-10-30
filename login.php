<?php
// 1. Incluir la clase
require_once(__DIR__ . '/classes/loginC.php');

// 2. Verificar que los datos lleguen por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // 3. Validar que los campos no estén vacíos
    if (!empty($email) && !empty($password)) {
        // El constructor de la clase Login se encarga de todo el proceso
        new Login($email, $password);
    } else {
        // Si están vacíos, redirigir de vuelta a index.php con un error
        header('Location: index.php?error=empty');
        exit();
    }
} else {
    // Si alguien intenta acceder a este archivo sin enviar datos, lo regresamos al inicio
    header('Location: index.php');
    exit();
}
?>