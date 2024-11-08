<?php
session_start();
include '../connection/connection.php';

if (!isset($_GET['user_id'])) {
    die("Usuario no especificado.");
}

$user_id = $_GET['user_id'];
$current_user_id = $_SESSION['username']['id'] ?? null;

$query = "SELECT username, description FROM users WHERE id = ?";
$stmt = mysqli_prepare($connect, $query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

// Si no se encontró el usuario, mostrar un mensaje
if (!$user) {
    echo "<p>Usuario no encontrado.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Perfil de <?= htmlspecialchars($user['username'] ?? "Usuario") ?></title>
</head>
<body>
    <h1>Perfil de <?= htmlspecialchars($user['username'] ?? "Usuario") ?></h1>
    <p><?= htmlspecialchars($user['description'] ?? "Sin descripción") ?></p>
    
    <?php if ($user_id == $current_user_id): ?>
        <form method="POST" action="edit_description.php">
            <textarea name="description" placeholder="Describe algo sobre ti"><?= htmlspecialchars($user['description'] ?? "") ?></textarea>
            <button type="submit">Actualizar descripción</button>
        </form>
    <?php else: ?>
        <form method="POST" action="follow.php">
            <input type="hidden" name="user_id" value="<?= $user_id ?>">
            <button type="submit" name="action" value="follow">Seguir</button>
            <button type="submit" name="action" value="unfollow">Dejar de seguir</button>
        </form>
    <?php endif; ?>

    <!-- Aquí va la sección de los tweets del usuario -->
</body>
</html>
