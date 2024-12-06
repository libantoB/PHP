<?php
// Verifica si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtiene los datos del formulario
    $nombre = htmlspecialchars($_POST['nombre']);
    $apellido = htmlspecialchars($_POST['apellido']);
    $telefono = htmlspecialchars($_POST['telefono']);

    // Muestra los datos en pantalla
    echo "<h1>Datos Recibidos:</h1>";
    echo "<p><strong>Nombre:</strong> $nombre</p>";
    echo "<p><strong>Apellido:</strong> $apellido</p>";
    echo "<p><strong>Teléfono:</strong> $telefono</p>";
} else {
    // Si no se accede mediante POST, muestra un mensaje
    echo "<h1>Acceso inválido</h1>";
    echo "<p>Por favor, envíe el formulario desde la página correspondiente.</p>";
}
?>
