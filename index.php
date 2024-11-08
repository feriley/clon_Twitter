<?php
    require_once("connection/connection.php");
    $_SESSION["variable_persistente"] = "Ejemplo de variable de session";
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Este es mi portfolio personal">
    <meta name="keywords" content="html, css, sass, bootstrap, js, portfolio, proyectos">
    <meta name="language" content="EN">
    <meta name="author" content="tumail@vedruna.es">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE-edge, chrome1">

    <!-- Fuente similar a Twitter -->
    <link href="https://fonts.googleapis.com/css2?family=Helvetica+Neue:wght@400;700&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" defer></script>

  

    <!-- Icono pagina arriba-->
    <link rel="shortcut icon" href="media/icon/logo_tw.png" type="image/x-png">

    <title>Clon_Twitter</title>

    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background-color: #f5f8fa;
            color: #14171a;
        }
        .container {
            max-width: 400px;
            margin-top: 50px;
        }
        .form-control {
            border-radius: 50px;
            padding: 12px;
        }
        .btn-primary {
            background-color: #1da1f2;
            border-color: #1da1f2;
            border-radius: 50px;
            padding: 10px 20px;
        }
        .btn-primary:hover {
            background-color: #0d8bec;
            border-color: #0d8bec;
        }
        fieldset {
            border: none;
            margin-bottom: 30px;
        }
        legend {
            font-size: 1.5rem;
            color: #14171a;
        }
        label {
            color: #657786;
        }
        input {
            border: 1px solid #ccd6dd;
        }
        .input-group-text {
            background-color: #e1e8ed;
            border: none;
        }
        .border-primary {
            border-color: #1da1f2 !important;
        }
    </style>
</head>

<body>
    <div id="contact" class="container">
        <?php if(isset($_SESSION["errores"])) { var_dump($_SESSION["errores"]); } ?>

        <?php if(isset($_SESSION["completado"])) { echo "Registro completado"; } ?>

        <form action="registro/registro.php" method="POST">
            <fieldset class="p-4 align-items-center">
                <legend class="text-dark">Registrate</legend>

                <div class="form-group mb-3">
                    <label for="username">Username:</label>
                    <input type="text" id="username" class="form-control" name="username" required />
                </div>

                <div class="form-group mb-3">
                    <label for="mail">Email:</label>
                    <div class="input-group">
                        <span class="input-group-text">@</span>
                        <input type="email" id="mail" class="form-control" name="mail" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" />
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="password">Password:</label>
                    <input type="password" id="password" class="form-control" name="password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
                        title="Debe contener al menos un número, una mayúscula, una minúscula y 8 o más caracteres" />
                </div>

                <div class="text-center">
                    <input id="sendBttn" class="btn btn-primary" type="submit" value="Send" name="submit"/>
                </div>
            </fieldset>
        </form>
    </div>

    <?php 
        if(isset($_SESSION["errores"])) {
            $_SESSION["errores"] = null;
            session_unset($_SESSION["errores"]);
        }
    ?>

    <div id="login" class="container"> 
        <?php if(isset($_SESSION["error_login"])) { var_dump($_SESSION["error_login"]); } ?>

        <form action="login/login.php" method="POST">
            <fieldset class="p-4 align-items-center">
                <legend class="text-dark">Login</legend>

                <div class="form-group mb-3">
                    <label for="email">Email:</label>
                    <div class="input-group">
                        <span class="input-group-text">@</span>
                        <input type="email" id="email" class="form-control" name="email" required />
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="password">Password:</label>
                    <input type="password" id="password" class="form-control" name="password" required />
                </div>

                <div class="text-center">
                    <input id="sendBttn2" class="btn btn-primary" type="submit" value="Send" name="submit"/>
                </div>
            </fieldset>
        </form>
    </div>

    <?php 
        if(isset($_SESSION["error_login"])) {
            $_SESSION["error_login"] = null;
            session_unset();
        }
    ?>
</body>
</html>
