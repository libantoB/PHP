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

// Funciones CRUD para productos

function crearProducto($pdo, $nombreProducto, $loteProducto, $valor) {
    try {
        $sql = "INSERT INTO productos (proNombreProducto, proLote, proValor) VALUES (:nombreProducto, :loteProducto, :valor)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nombreProducto', $nombreProducto);
        $stmt->bindParam(':loteProducto', $loteProducto);
        $stmt->bindParam(':valor', $valor);
        $stmt->execute();
        echo "Producto creado exitosamente.";
    } catch (PDOException $e) {
        echo "Error al crear producto: " . $e->getMessage();
    }
}

function leerProducto($pdo, $nombreProducto) {
    try {
        $sql = "SELECT * FROM productos WHERE proNombreProducto = :nombreProducto";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nombreProducto', $nombreProducto);
        $stmt->execute();
        $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($productos) {
            foreach ($productos as $producto) {
                echo "Nombre Producto: " . $producto['proNombreProducto'] . "<br>";
                echo "Lote Producto: " . $producto['proLote'] . "<br>";
                echo "Valor: " . $producto['proValor'] . "<br><br>";
            }
        } else {
            echo "No se encontraron productos con el nombre proporcionado.";
        }
    } catch (PDOException $e) {
        echo "Error al buscar producto: " . $e->getMessage();
    }
}

function actualizarProducto($pdo, $nombreProducto, $loteProducto, $valor) {
    try {
        $sql = "UPDATE productos SET proLote = :loteProducto, proValor = :valor WHERE proNombreProducto = :nombreProducto";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nombreProducto', $nombreProducto);
        $stmt->bindParam(':loteProducto', $loteProducto);
        $stmt->bindParam(':valor', $valor);
        if ($stmt->execute()) {
            echo "Producto actualizado exitosamente.";
        } else {
            echo "Error al actualizar producto.";
        }
    } catch (PDOException $e) {
        echo "Error al actualizar producto: " . $e->getMessage();
    }
}

function eliminarProducto($pdo, $nombreProducto) {
    try {
        $sql = "DELETE FROM productos WHERE proNombreProducto = :nombreProducto";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nombreProducto', $nombreProducto);
        if ($stmt->execute()) {
            echo "Producto eliminado exitosamente.";
        } else {
            echo "Error al eliminar producto.";
        }
    } catch (PDOException $e) {
        echo "Error al eliminar producto: " . $e->getMessage();
    }
}

// Manejo de datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    var_dump($_POST); // Verifica los valores enviados
    $accion = $_POST['accion'] ?? '';
    $nombreProducto = htmlspecialchars(trim($_POST['nombreProducto'] ?? ''));
    $loteProducto = htmlspecialchars(trim($_POST['loteProducto'] ?? ''));
    $valor = htmlspecialchars(trim($_POST['valor'] ?? ''));

    switch ($accion) {
        case 'create':
            // Verificamos que los campos necesarios estén llenos
            if ($nombreProducto && $loteProducto && $valor) {
                crearProducto($pdo, $nombreProducto, $loteProducto, $valor);
            } else {
                echo "Error: todos los campos son obligatorios para crear un producto.";
            }
            break;

        case 'read':
            // Verificamos que se haya proporcionado un nombre de producto para buscar
            if ($nombreProducto) {
                leerProducto($pdo, $nombreProducto);
            } else {
                echo "Error: debe seleccionar un producto para buscar.";
            }
            break;

        case 'update':
            // Verificamos que se haya proporcionado al menos un dato para actualizar
            if ($nombreProducto && ($loteProducto || $valor)) {
                actualizarProducto($pdo, $nombreProducto, $loteProducto, $valor);
            } else {
                echo "Error: el nombre del producto y al menos un dato adicional son obligatorios para actualizar.";
            }
            break;

        case 'delete':
            // Verificamos que se haya proporcionado un nombre de producto para eliminar
            if ($nombreProducto) {
                eliminarProducto($pdo, $nombreProducto);
            } else {
                echo "Error: debe seleccionar un producto para eliminar.";
            }
            break;

        default:
            echo "Error: acción no reconocida.";
            break;
    }
}
?>
