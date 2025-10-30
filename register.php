<?php
// 1. Definimos la variable de mensaje para usarla después
$message = null;

// 2. Verificamos si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Incluimos la clase (asegúrate de que la ruta sea correcta)
    require_once(__DIR__ . '/classes/registerC.php');

    // 3. Obtenemos los datos del formulario de forma segura
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // 4. Validamos que los campos no estén vacíos
    if (!empty($username) && !empty($email) && !empty($password)) {
        // Creamos el objeto Register con los tres parámetros
        $register = new Register($username, $email, $password);
        $message = $register->get_confirmation();
    } else {
        $message = "Por favor, completa todos los campos.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de usuario</title>
    <style>
        /* Estilo opcional para que los mensajes se vean mejor */
        .message {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
        }
        .success { background-color: #d4edda; color: #155724; }
        .error { background-color: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <main>
        <hr>
        <form action="" method="POST" id="register-form">

        <?php
            // 5. Mostramos el mensaje si existe
            if (isset($message)) {
                // Determinamos si el mensaje es de éxito o error para aplicar un estilo
                $message_class = (strpos($message, 'éxito') !== false) ? 'success' : 'error';
                echo "<div class='message {$message_class}'>{$message}</div>";
            }
        ?>
            <div class="input-form">
                <label for="username">Nombre de usuario:</label>
                <input type="text" name="username" id="username" placeholder="Elige un nombre de usuario" required/>
            </div>

            <div class="input-form">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" placeholder="Escribe tu email" required/>
            </div>
            
            <div class="input-form">
                <label for="password">Contraseña:</label>
                <input type="password" name="password" id="password" placeholder="Introduce tu contraseña" required/>
            </div>

            <button type="submit" form="register-form" value="Submit">Registrar</button>
            <a href="index.php" class="go-back-button" >Volver</a>

        </form>
    </main>
</body>
</html>