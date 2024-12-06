<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Factura</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

    <?php
    // Conexión a la base de datos
    $conn = new mysqli('localhost', 'root', '', 'vacunaips');
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Obtener clientes
    $queryClientes = "SELECT cliId, CONCAT(cliNombre, ' ', cliApellido) AS nombreCompleto FROM cliente";
    $resultadoClientes = $conn->query($queryClientes);

    // Obtener productos
    $queryProductos = "SELECT proId, proNombreProducto FROM productos";
    $resultadoProductos = $conn->query($queryProductos);
    ?>

    <!-- Barra de navegación fija -->
    <nav class="fixed top-0 left-0 w-full bg-blue-600 p-4 shadow-md z-10">
        <div class="max-w-6xl mx-auto flex justify-between items-center">
            <a href="#" class="text-white text-2xl font-bold">Vacunas IPS</a>
            <ul class="flex space-x-6">
                <li><a href="htmlCRUD.html" class="text-white hover:bg-blue-500 px-3 py-2 rounded-md text-lg font-semibold">Cliente</a></li>
                <li><a href="producto.html" class="text-white hover:bg-blue-500 px-3 py-2 rounded-md text-lg font-semibold">Productos</a></li>
                <li><a href="paginaFactura.php" class="text-white hover:bg-blue-500 px-3 py-2 rounded-md text-lg font-semibold">Facturas</a></li>
            </ul>
        </div>
    </nav>

    <!-- Formulario principal -->
    <div class="w-full max-w-lg bg-white rounded-lg shadow-md p-8 mt-24 mx-auto">
        <h2 class="text-2xl font-semibold text-gray-800 text-center mb-6">Registrar Factura</h2>
        <form action="factura.php" method="POST">
            <!-- Cliente -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="clienteId">Cliente</label>
                <select name="clienteId" id="clienteId" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                    <option value="">Seleccione un cliente</option>
                    <?php while ($cliente = $resultadoClientes->fetch_assoc()) { ?>
                        <option value="<?php echo $cliente['cliId']; ?>"><?php echo $cliente['nombreCompleto']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <!-- Producto -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="productoId">Producto</label>
                <select name="productoId" id="productoId" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                    <option value="">Seleccione un producto</option>
                    <?php while ($producto = $resultadoProductos->fetch_assoc()) { ?>
                        <option value="<?php echo $producto['proId']; ?>"><?php echo $producto['proNombreProducto']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <!-- Cantidad -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="cantidadProducto">Cantidad</label>
                <input type="number" name="cantidadProducto" id="cantidadProducto" class="w-full px-4 py-2 border border-gray-300 rounded-lg" placeholder="Ingrese la cantidad" min="1" required>
            </div>

            <!-- Valor -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="valorProducto">Valor</label>
                <input type="number" name="valorProducto" id="valorProducto" class="w-full px-4 py-2 border border-gray-300 rounded-lg" placeholder="Ingrese el valor del producto" required>
            </div>

            <!-- Botón de envío -->
            <div class="mb-4 text-center">
                <button type="submit" class="w-full bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Registrar Factura</button>
            </div>
        </form>
    </div>

    <?php $conn->close(); ?>
</body>
</html>
