<?php
// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'vacunaips');
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Validar si los datos fueron enviados
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $clienteId = $_POST['clienteId'];
    $productoId = $_POST['productoId'];
    $cantidadProducto = $_POST['cantidadProducto'];
    $valorProducto = $_POST['valorProducto'];

    // Obtener el nombre del cliente
    $queryCliente = "SELECT CONCAT(cliNombre, ' ', cliApellido) AS nombreCliente FROM cliente WHERE cliId = $clienteId";
    $resultadoCliente = $conn->query($queryCliente);
    $nombreCliente = $resultadoCliente->fetch_assoc()['nombreCliente'];

    // Obtener el nombre del producto
    $queryProducto = "SELECT proNombreProducto FROM productos WHERE proId = $productoId";
    $resultadoProducto = $conn->query($queryProducto);
    $nombreProducto = $resultadoProducto->fetch_assoc()['proNombreProducto'];

    // Insertar factura
    $queryFactura = "INSERT INTO factura (clienteId, nombreCliente, productoId, nombreProducto, cantidadProducto, valorProducto)
                     VALUES ($clienteId, '$nombreCliente', $productoId, '$nombreProducto', $cantidadProducto, $valorProducto)";
    if ($conn->query($queryFactura) === TRUE) {
        echo "<h1>Factura generada</h1>";
        echo "<p>Cliente: $nombreCliente</p>";
        echo "<p>Producto: $nombreProducto</p>";
        echo "<p>Cantidad: $cantidadProducto</p>";
        echo "<p>Valor unitario: $valorProducto</p>";
        echo "<p>Total: " . ($cantidadProducto * $valorProducto) . "</p>";
        
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>

