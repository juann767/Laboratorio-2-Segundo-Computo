<?php
session_start();
require_once('conexion.php');

if (!isset($_SESSION['usuario_valido'])) { header("Location: index.php"); exit(); }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $n = $conexion->real_escape_string($_POST['nombre']);
    $e = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $ed = intval($_POST['edad']);

    if ($n && $e && $ed > 0) {
        $conexion->query("INSERT INTO registros (nombre, email, edad) VALUES ('$n', '$e', '$ed')");
    }
}

$datos = $conexion->query("SELECT * FROM registros ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard UGB</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <strong>SISTEMA DE LABORATORIO</strong>
        <div>
            <span>Usuario: <?php echo $_SESSION['usuario_valido']; ?></span> | 
            <a href="logout.php" style="color:var(--accent); text-decoration:none;">Cerrar Sesión</a>
        </div>
    </nav>

    <div class="container">
        <h3>+ Agregar Nuevo Registro</h3>
        <form method="POST" class="grid-form">
            <input type="text" name="nombre" placeholder="Nombre" required>
            <input type="email" name="email" placeholder="Correo electrónico" required>
            <input type="number" name="edad" placeholder="Edad" required>
            <button type="submit">GUARDAR</button>
        </form>

        <h3>Listado de Datos Registrados</h3>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Edad</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $datos->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['nombre']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['edad']; ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>