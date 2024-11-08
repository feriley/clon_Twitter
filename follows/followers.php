<?php
session_start();
include '../connection/connection.php';

// Verificar si el parámetro user_id está definido
if (!isset($_GET['user_id']) || empty($_GET['user_id'])) {
    echo "<p>Error: ID de usuario no especificado.</p>";
    exit;
}

$user_id = $_GET['user_id'];

$query = "SELECT u.id, u.username 
          FROM users u 
          JOIN follows f ON u.id = f.users_id 
          WHERE f.userToFollowId = ?";
$stmt = mysqli_prepare($connect, $query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Seguidores</title>
    <style>
        /* Aquí el CSS para el estilo de la página */
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f8fa;
            color: #14171a;
            text-align: center;
        }
        
        .followers-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        
        h1 {
            color: #1da1f2;
            font-size: 24px;
        }
        
        ul {
            list-style-type: none;
            padding: 0;
        }
        
        li {
            padding: 10px;
            border-bottom: 1px solid #e1e8ed;
        }
        
        .username {
            font-weight: bold;
            color: #1da1f2;
            text-decoration: none;
        }
        
        .username:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="followers-container">
        <h1>Seguidores</h1>
        <ul>
            <?php while ($follower = mysqli_fetch_assoc($result)): ?>
                <li>
                    <a href="profile.php?user_id=<?php echo $follower['id']; ?>" class="username">
                        <?php echo htmlspecialchars($follower['username']); ?>
                    </a>
                </li>
            <?php endwhile; ?>
        </ul>
    </div>
</body>
</html>
