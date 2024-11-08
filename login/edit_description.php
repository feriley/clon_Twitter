<?php
// Conexión a la base de datos
include '../connection/connection.php';

// Iniciar sesión
session_start();
if (!isset($_SESSION['username'])) {
    // Redirige al login si el usuario no ha iniciado sesión
    header('Location: login.php');
    exit();
}

// Obtén el ID del usuario actual desde la sesión
$current_user_id = $_SESSION['username']['id'];

// Si se envía el formulario, procesa la actualización
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_description = mysqli_real_escape_string($connect, $_POST['description']);

    // Actualiza la descripción en la base de datos
    $query = "UPDATE users SET description = ? WHERE id = ?";
    $stmt = mysqli_prepare($connect, $query);
    mysqli_stmt_bind_param($stmt, "si", $new_description, $current_user_id);

    if (mysqli_stmt_execute($stmt)) {
        // Redirige a la página de bienvenida o perfil una vez actualizada
        header('Location: welcome.php');
    } else {
        echo "Error al actualizar la descripción.";
    }

    mysqli_stmt_close($stmt);
}

// Obtén la descripción actual del usuario para mostrarla en el formulario
$query = "SELECT description FROM users WHERE id = ?";
$stmt = mysqli_prepare($connect, $query);
mysqli_stmt_bind_param($stmt, "i", $current_user_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $current_description);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);
mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Descripción</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background-color: #f5f8fa;
            color: #14171a;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            max-width: 500px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Editar Descripción de Perfil</h2>
        <form action="edit_description.php" method="POST">
            <div class="mb-3">
                <label for="description" class="form-label">Nueva Descripción</label>
                <textarea id="description" name="description" class="form-control" rows="3" required><?= htmlspecialchars($current_description); ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            <a href="welcome.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>
</html>
