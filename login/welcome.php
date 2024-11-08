<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido a Clon de Twitter</title>
    
    <link href="../css/style.css" rel="stylesheet" type="text/css">
    <script src="../js/script.js"></script>
</head>
<body>
    <div class="container">
        <!-- Sidebar izquierda -->
        <div class="sidebar">
            <div class="sidebar-logo">
                <a href="welcome.php"><img src="../media/icon/logo_tw.png" alt="Logo de Twitter" class="twitter-logo"></a>
            </div>
            <nav class="vertical-nav">
                <ul>
                    <li><a href="#">Inicio</a></li>
                    <li><a href="#">Explorar</a></li>
                    <li><a href="#">Notificaciones</a></li>
                    <li><a href="#">Mensajes</a></li>
                    <li><a href="#">Listas</a></li>
                    <li><a href="#">Premium+</a></li>
                    <li><a href="profile.php?user_id=<?= $_SESSION['username']['id'] ?>">Perfil</a></li>
                    <li><a href="../sessionSample/logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>
        
        <!-- Contenido principal -->
        <main class="main-content">
            <?php if(isset($_SESSION["username"])): ?>
                <div class="welcome-message">
                    <h2>Hola, <?= htmlspecialchars($_SESSION['username']['username']) ?>!</h2>
                    <p>Bienvenido a tu feed. Puedes ver los tweets de las personas que sigues o de todo el mundo.</p>
                </div>

                <!-- Formulario para publicar un nuevo tweet -->
                <div class="post-form">
                    <form method="POST" action="../post/post.php">
                        <textarea name="tweet_content" placeholder="¿Qué está pasando?" required></textarea>
                        <button type="submit">Twittear</button>
                    </form>
                </div>

                <!-- Opciones de feed: solo seguidos o todos los tweets -->
                <div class="feed-options">
                    <button onclick="location.href='welcome.php?feed=followed'">Seguidos</button>
                    <button onclick="location.href='welcome.php?feed=all'">Todos</button>
                </div>

                <div class="feed">
                    <h3>Feed <?= (isset($_GET['feed']) && $_GET['feed'] === 'all') ? "Global" : "de Seguidos" ?></h3>
                    <?php
                    include '../connection/connection.php';
                    $current_user_id = $_SESSION['username']['id'];
                    
                    // Consulta de tweets global o de seguidos
                    if (isset($_GET['feed']) && $_GET['feed'] === 'all') {
                        $query = "SELECT p.text, p.createDate, u.id, u.username 
                                  FROM publications p 
                                  JOIN users u ON p.userId = u.id 
                                  ORDER BY p.createDate DESC";
                    } else {
                        $query = "SELECT p.text, p.createDate, u.id, u.username 
                                  FROM publications p 
                                  JOIN users u ON p.userId = u.id 
                                  JOIN follows f ON f.userToFollowId = p.userId 
                                  WHERE f.users_id = ? 
                                  ORDER BY p.createDate DESC";
                    }

                    $stmt = mysqli_prepare($connect, $query);

                    if (!isset($_GET['feed']) || $_GET['feed'] !== 'all') {
                        mysqli_stmt_bind_param($stmt, "i", $current_user_id);
                    }

                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<div class='post'>";
                        echo "<p><strong><a href='profile.php?user_id=" . $row['id'] . "'>@" . htmlspecialchars($row['username']) . "</a></strong>: " . htmlspecialchars($row['text']) . "</p>";
                        echo "<small>Publicado el " . htmlspecialchars($row['createDate']) . "</small>";
                        echo "</div>";
                    }

                    // Sección de los propios tweets del usuario actual
                    echo "<h3>Mis Tweets</h3>";
                    
                    $query_own = "SELECT text, createDate 
                                  FROM publications 
                                  WHERE userId = ? 
                                  ORDER BY createDate DESC";

                    $stmt_own = mysqli_prepare($connect, $query_own);
                    mysqli_stmt_bind_param($stmt_own, "i", $current_user_id);
                    mysqli_stmt_execute($stmt_own);
                    $result_own = mysqli_stmt_get_result($stmt_own);

                    if (mysqli_num_rows($result_own) > 0) {
                        while ($row_own = mysqli_fetch_assoc($result_own)) {
                            echo "<div class='post'>";
                            echo "<p>" . htmlspecialchars($row_own['text']) . "</p>";
                            echo "<small>Publicado el " . htmlspecialchars($row_own['createDate']) . "</small>";
                            echo "</div>";
                        }
                    } else {
                        echo "<p>No tienes tweets aún.</p>";
                    }

                    mysqli_stmt_close($stmt);
                    mysqli_stmt_close($stmt_own);
                    mysqli_close($connect);
                    ?>
                </div>
            <?php else: ?>
                <h1>NO ESTÁS LOGUEADO</h1>
                <p><a href="login.php">Inicia sesión</a> para continuar.</p>
            <?php endif; ?>
        </main>

        <!-- Sidebar derecha -->
        <div class="right-sidebar">
            <div class="trending-topics">
                <h3>Trending Topics</h3>
                <ul>
                    <li><a href="#">#TrendingTopic1</a></li>
                    <li><a href="#">#TrendingTopic2</a></li>
                    <li><a href="#">#TrendingTopic3</a></li>
                    <li><a href="#">#TrendingTopic4</a></li>
                    <li><a href="#">#TrendingTopic5</a></li>
                </ul>
            </div>
            
            <div class="suggested-users">
                <h3>Quizás conozcas</h3>
                <ul>
                    <?php
                    include '../connection/connection.php';
                    $current_user_id = $_SESSION['username']['id'];

                    $query = "SELECT u.id, u.username 
                              FROM users u 
                              WHERE u.id != ? 
                              AND u.id NOT IN (SELECT f.userToFollowId FROM follows f WHERE f.users_id = ?)";

                    $stmt = mysqli_prepare($connect, $query);
                    mysqli_stmt_bind_param($stmt, "ii", $current_user_id, $current_user_id);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<li><a href='profile.php?user_id=" . $row['id'] . "'>@" . htmlspecialchars($row['username']) . "</a> 
                              <button onclick='followUser(" . $row['id'] . ")'>Seguir</button></li>";
                    }

                    mysqli_close($connect);
                    ?>
                </ul>
            </div>
        </div>
    </div>

    <script>
    function followUser(userId) {
        fetch(`follow.php?action=follow&userId=${userId}`, {
            method: 'POST',
            credentials: 'same-origin'
        }).then(response => {
            if (response.ok) {
                location.reload();
            } else {
                alert("Error al seguir usuario.");
            }
        });
    }
    </script>
</body>
</html>
