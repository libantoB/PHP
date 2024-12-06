<?php
// Configuración de conexión a la base de datos
$host = 'localhost';
$dbname = 'vacunaIPS';
$usuario = 'root';
$contraseña = '';

try {
    // Crear una nueva conexión PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $usuario, $contraseña);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("¡Error en la conexión a la base de datos!: " . $e->getMessage());
}

// Funciones CRUD
function crearUsuario($pdo, $nombre, $apellido, $telefono, $tipoDocumento, $documento, $nacimiento) {
    try {
        $sql = "INSERT INTO cliente (cliNombre, cliApellido, cliTelefono, cliTipoDocumento, cliDocumento, cliFechaNacimiento) VALUES (:nombre, :apellido, :telefono, :tipoDocumento, :documento, :nacimiento)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido', $apellido);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':tipoDocumento', $tipoDocumento);
        $stmt->bindParam(':documento', $documento);
        $stmt->bindParam(':nacimiento', $nacimiento);
        $stmt->execute();
        echo "Usuario creado exitosamente.";
    } catch (PDOException $e) {
        echo "Error al crear usuario: " . $e->getMessage();
    }
}

function leerUsuario($pdo, $nombre, $apellido, $telefono, $tipoDocumento, $documento, $nacimiento) {
    try {
        $sql = "SELECT * FROM aprendices WHERE nombre = :nombre OR apellido = :apellido OR telefono = :telefono";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido', $apellido);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':tipoDocumento', $tipoDocumento);
        $stmt->bindParam(':documento', $documento);
        $stmt->bindParam(':nacimiento', $nacimiento);

        $stmt->execute();
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($usuarios) {
            foreach ($usuarios as $usuario) {
                echo "ID: " . $usuario['id'] . "<br>";
                echo "Nombre: " . $usuario['nombre'] . "<br>";
                echo "Apellido: " . $usuario['apellido'] . "<br>";
                echo "Teléfono: " . $usuario['telefono'] . "<br><br>";
            }
        } else {
            echo "No se encontraron usuarios con los datos proporcionados.";
        }
    } catch (PDOException $e) {
        echo "Error al buscar usuario: " . $e->getMessage();
    }
}

function actualizarUsuario($pdo, $nombre, $apellido, $telefono, $tipoDocumento, $documento, $nacimiento) {
    try {
        $sql = "UPDATE aprendices SET apellido = :apellido, telefono = :telefono WHERE nombre = :nombre";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido', $apellido);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':tipoDocumento', $tipoDocumento);
        $stmt->bindParam(':documento', $documento);
        $stmt->bindParam(':nacimiento', $nacimiento);

        if ($stmt->execute()) {
            echo "Usuario actualizado exitosamente.";
        } else {
            echo "Error al actualizar usuario.";
        }
    } catch (PDOException $e) {
        echo "Error al actualizar usuario: " . $e->getMessage();
    }
}

function eliminarUsuario($pdo, $nombre, $apellido, $telefono, $tipoDocumento, $documento, $nacimiento) {
    try {
        $sql = "DELETE FROM aprendices WHERE nombre = :nombre OR apellido = :apellido OR telefono = :telefono";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido', $apellido);
        $stmt->bindParam(':telefono', $telefono);
                $stmt->bindParam(':tipoDocumento', $tipoDocumento);
        $stmt->bindParam(':documento', $documento);
        $stmt->bindParam(':nacimiento', $nacimiento);

        if ($stmt->execute()) {
            echo "Usuario eliminado exitosamente.";
        } else {
            echo "Error al eliminar usuario.";
        }
    } catch (PDOException $e) {
        echo "Error al eliminar usuario: " . $e->getMessage();
    }
}

// Manejo de datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $accion = $_POST['accion'] ?? '';
    $nombre = htmlspecialchars(trim($_POST['nombre'] ?? ''));
    $apellido = htmlspecialchars(trim($_POST['apellido'] ?? ''));
    $telefono = htmlspecialchars(trim($_POST['telefono'] ?? ''));
    $tipoDocumento = htmlspecialchars(trim($_POST['tipoDocumento'] ?? ''));
    $documento = htmlspecialchars(trim($_POST['documento'] ?? ''));
    $nacimiento = htmlspecialchars(trim($_POST['nacimiento'] ?? ''));

    

    switch ($accion) {
        case 'create':
            if ($nombre && $apellido && $telefono) {
                crearUsuario($pdo, $nombre, $apellido, $telefono, $tipoDocumento, $documento, $nacimiento);
            } else {
                echo "Error: todos los campos son obligatorios para crear un usuario.";
            }
            break;

        case 'read':
            leerUsuario($pdo, $nombre, $apellido, $telefono, $tipoDocumento, $documento, $nacimiento);
            break;

        case 'update':
            if ($nombre && ($apellido || $telefono)) {
                actualizarUsuario($pdo, $nombre, $apellido, $telefono, $tipoDocumento, $documento, $nacimiento);
            } else {
                echo "Error: el nombre y al menos un dato adicional son obligatorios para actualizar.";
            }
            break;

        case 'delete':
            eliminarUsuario($pdo, $nombre, $apellido, $telefono, $tipoDocumento, $documento, $nacimiento);
            break;

        default:
            echo "Error: acción no reconocida.";
            break;
    }
}
?>
