<?php
session_start();
require_once('conexion.php');
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $conexion->real_escape_string($_POST['username']);
    $pass = $_POST['password'];

    $sql = "SELECT * FROM usuarios WHERE username = '$user'";
    $res = $conexion->query($sql);
    
    if ($res && $res->num_rows > 0) {
        $f = $res->fetch_assoc();
        if ($pass == $f['password']) {
            $_SESSION['usuario_valido'] = $f['username'];
            header("Location: dashboard.php");
            exit();
        } else { $error = "Contraseña incorrecta"; }
    } else { $error = "El usuario no existe"; }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>UGB Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="login-screen">
    <div class="card">
        <h2>UGB - Acceso</h2>
        <form method="POST">
            <input type="text" name="username" placeholder="Usuario (admin)" required>
            <input type="password" name="password" placeholder="Contraseña (12345)" required>
            <button type="submit">INGRESAR AL SISTEMA</button>
            <?php if($error) echo "<p class='error-msg'>$error</p>"; ?>
        </form>
    </div>
</body>
</html>