<?php 
    require_once "../connection/connection.php";

    if (isset($_POST)) {
        $email = trim($_POST["email"]);
        $password = $_POST["password"];
    }

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $res = mysqli_query($connect, $sql);

    if ($res && mysqli_num_rows($res) == 1) {
        $username = mysqli_fetch_assoc($res);

        if (password_verify($password, $username["password"])) {
            $_SESSION["username"] = $username;
            header("Location: welcome.php");
        } else {
            $_SESSION["error_login"] = "Login incorrecto";
            header("Location: ../index.php");
        }
    } else {
        $_SESSION["error_login"] = "Login incorrecto";
        header("Location: ../index.php");
    }


?>