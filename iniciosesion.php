<?php
// Lógica para mostrar mensajes de error que vienen de login.php
$error_message = '';
if (isset($_GET['error'])) {
    switch ($_GET['error']) {
        case 'email':
            $error_message = 'El correo electrónico no está registrado.';
            break;
        case 'password':
            $error_message = 'La contraseña es incorrecta.';
            break;
        case 'empty':
            $error_message = 'Por favor, completa todos los campos.';
            break;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login con PHP y Sessions</title>
    <style>
        .error-box { 
            color: #D8000C; 
            background-color: #FFD2D2; 
            border: 1px solid #D8000C; 
            padding: 10px; 
            margin-bottom: 15px; 
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <main>
        <h1>Iniciar Sesión</h1>
        <hr>

        <?php
        // Si hay un mensaje de error, lo mostramos aquí
        if (!empty($error_message)) {
            echo "<div class='error-box'>{$error_message}</div>";
        }
        ?>

        <form action="login.php" method="POST" id="login-form">
            <div class="input-form">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" placeholder="Escribe tu email" required/>
            </div>
            <div class="input-form">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" placeholder="Introduce tu contraseña" required/>
            </div>
            <button type="submit" value="Submit">Ingresar</button>
            <p>
                ¿No tienes usuario? <a href="register.php">Crea una cuenta aquí</a>
            </p>
        </form>
    </main>
</body>
</html>