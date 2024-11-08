<?php 
    #Es una pequeña información enviada por un sitio web y almacenada en el navegador del usuario, 
    #de manera que el sitio web puede consultar la actividad previa del navegador.

    #Crear cookie
    $nombreCookie = "nombre";
    $valorCookie = "valor que solo puede ser String";
    $caducidad = time() + (60*60*24*365); #Un año
    setcookie($nombreCookie, $valorCookie, $caducidad);
    #borrar cookie (hay que caducarla)
    # unset($_COOKIE["nombre"]); 
    # setcookie("nombre","",time()-100);
?>

<h1><?php 
    if(isset($_COOKIE["nombre"])) {
        echo $_COOKIE["nombre"];
    } else {
        echo "No existe cookie";
    }
?></h1>