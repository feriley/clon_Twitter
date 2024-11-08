<?php
session_start();
include '../connection/connection.php';

// Verificar si el usuario está logueado
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit;
}

$current_user_id = $_SESSION['username']['id'];
$user_to_follow_id = $_POST['user_id'] ?? null;
$action = $_POST['action'] ?? null;

if ($user_to_follow_id && $action) {
    if ($action === 'follow') {
        // Consulta para seguir al usuario
        $query = "INSERT INTO follows (users_id, userToFollowId) VALUES (?, ?)";
    } elseif ($action === 'unfollow') {
        // Consulta para dejar de seguir al usuario
        $query = "DELETE FROM follows WHERE users_id = ? AND userToFollowId = ?";
    }

    $stmt = mysqli_prepare($connect, $query);
    mysqli_stmt_bind_param($stmt, "ii", $current_user_id, $user_to_follow_id);
    mysqli_stmt_execute($stmt);
}

// Redirigir de vuelta al perfil
header("Location: profile.php?user_id=" . $user_to_follow_id);
exit;
