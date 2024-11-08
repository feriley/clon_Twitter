<?php 

if (isset($_POST["submit"])) {
    require_once("../connection/connection.php");
    #session_start();

    //Recoger los datos
    $username = isset($_POST["username"]) ? mysqli_real_escape_string($connect, $_POST["username"]) : false;
    $mail = isset($_POST["mail"]) ? mysqli_real_escape_string($connect, trim($_POST["mail"])) : false;
    $password = isset($_POST["password"]) ? mysqli_real_escape_string($connect, $_POST["password"]) : false;
    //var_dump($_POST);

    $arrayErrores = array();
    //Hacemos validadores necesarios
    if (!empty($username) && !is_numeric($username)) {
        $usernameValidado = true;
    } else {
        $usernameValidado = false;
        $arrayErrores["username"] = "El username no es valido";
    }

    if (!empty($mail) && filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        $mailValidado = true;
    } else {
        $mailValidado = false;
        $arrayErrores["mail"] = "El mail no es valido";
    }

    if (!empty($password)) {
        $passValidado = true;
    } else {
        $passValidado = false;
        $arrayErrores["password"] = "El password no es valido";
    }
    if (count($arrayErrores) == 0) {
        $guardarUsuario = true;
    
        // Hashing the password
        $passSegura = password_hash($password, PASSWORD_BCRYPT, ["cost" => 4]);
    
        // Prepare the SQL statement
        $stmt = $connect->prepare("INSERT INTO users (username, email, password, createDate) VALUES (?, ?, ?, CURDATE())");
        
        // Bind parameters
        $stmt->bind_param("sss", $username, $mail, $passSegura);
        
        // Execute the statement
        if ($stmt->execute()) {
            $_SESSION["completado"] = "Registro completado";
        } else {
            $_SESSION["errores"]["general"] = "Fallo en el registro: " . $stmt->error;
        }
    
        // Close the statement
        $stmt->close();
    } else {
        $_SESSION["errores"] = $arrayErrores;
    }
    header("Location: ../index.php");
    
}
?>