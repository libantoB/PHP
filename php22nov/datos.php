<?php
// Configuración de conexión a la base de datos
$host = 'localhost';
//$dbname = 'tps123';
$usuario = 'root';
$contraseña = ''; 

try {
    // Crear una nueva conexión PDO
    $pdo = new PDO("mysql:host=$host;port=3306;dbname=tps123;charset=utf8", $usuario, $contraseña);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verificar acceso a la base de datos con una consulta simple
    $query = $pdo->query("SHOW TABLES");
    if ($query) {
        echo "Conexión exitosa a la base de datos y acceso verificado.";
    } else {
        echo "Conexión establecida, pero no se pudo acceder a la base de datos.";
    }
} catch (PDOException $e) {
    die("¡Error en la conexión a la base de datos!: " . $e->getMessage());
}

// Función para insertar datos en la base de datos
function insertarUsuario($pdo, $aprNombre, $aprApellido, $aprCorreo, $aprFechNac ) {
    try {
        $sql = "INSERT INTO aprendiz (aprNombre, aprApellido, aprCorreo, aprFechNac) VALUES (:nombre, :apellido, :correo, :fecha)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nombre', $aprNombre);
        $stmt->bindParam(':apellido', $aprApellido);
        $stmt->bindParam(':correo', $aprCorreo);
        $stmt->bindParam(':fecha', $aprFechNac);

        if ($stmt->execute()) {
            echo "Registro exitoso.";
        } else {
            echo "Error al registrar los datos.";
        }
    } catch (PDOException $e) {
        echo "Error en la inserción de datos: " . $e->getMessage();
    }
}

// Bloque de recepción de datos del formulario
$nombre = $apellido = $correo = $fecha = ""; // Definir las variables correctamente
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['correo']) && isset($_POST['fecha'])) {
        // Asignar y limpiar variables
        $nombre = htmlspecialchars(trim($_POST['nombre']));
        $apellido = htmlspecialchars(trim($_POST['apellido']));
        $correo = htmlspecialchars(trim($_POST['correo']));
        $fecha = htmlspecialchars(trim($_POST['fecha']));

        // Llamada a la función de inserción
        insertarUsuario($pdo, $nombre, $apellido, $correo, $fecha);
    } else {
        echo "Error: faltan datos obligatorios. Asegúrate de completar todos los campos.";
    }
}




