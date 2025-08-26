<?php
session_start(); // 1. Inicia o reanuda la sesión

session_unset(); // 2. Elimina todas las variables de la sesión

session_destroy(); // 3. Destruye la sesión por completo

// 4. Redirige al usuario a la página de inicio
header("Location: index.php");
exit(); // 5. Asegura que el script se detenga aquí
?>