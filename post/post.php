<?php
include '../connection/connection.php';

session_start();

if (!isset($_SESSION['username'])) {
    header('Location: ../login/login.php');
    exit();
}

$current_user_id = $_SESSION['username']['id'];
$tweet_content = mysqli_real_escape_string($connect, $_POST['tweet_content']);
$createDate = date('Y-m-d H:i:s');

// Insertar nueva publicación
$query = "INSERT INTO publications (userId, text, createDate) VALUES (?, ?, ?)";
$stmt = mysqli_prepare($connect, $query);
mysqli_stmt_bind_param($stmt, "iss", $current_user_id, $tweet_content, $createDate);

if (mysqli_stmt_execute($stmt)) {
    header('Location: ../login/welcome.php');
} else {
    echo "Error al publicar el tweet.";
}

mysqli_close($connect);
?>
