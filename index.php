<?php
// Conexión a la base de datos
$mysqli = new mysqli('localhost', 'root', '230913', 'mi_proyecto');
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

// Crear un producto
function createProduct($nombre, $descripcion, $precio) {
    global $mysqli;
    $stmt = $mysqli->prepare("INSERT INTO productos (nombre, descripcion, precio) VALUES (?, ?, ?)");
    $stmt->bind_param("ssd", $nombre, $descripcion, $precio);
    $stmt->execute();
    $stmt->close();
}

// Leer todos los productos
function getProducts() {
    global $mysqli;
    $result = $mysqli->query("SELECT id, nombre, descripcion, precio FROM productos");
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Leer un producto por ID
function getProduct($id) {
    global $mysqli;
    $stmt = $mysqli->prepare("SELECT id, nombre, descripcion, precio FROM productos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

// Actualizar un producto
function updateProduct($id, $nombre, $descripcion, $precio) {
    global $mysqli;
    $stmt = $mysqli->prepare("UPDATE productos SET nombre = ?, descripcion = ?, precio = ? WHERE id = ?");
    $stmt->bind_param("ssdi", $nombre, $descripcion, $precio, $id);
    $stmt->execute();
    $stmt->close();
}

// Eliminar un producto
function deleteProduct($id) {
    global $mysqli;
    $stmt = $mysqli->prepare("DELETE FROM productos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

// Obtener todos los productos para mostrarlos en la página
$productos = getProducts();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ventas (Productos)</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        header, footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px;
        }
        nav {
            text-align: center;
            margin: 20px;
        }
        nav a {
            color: #333;
            text-decoration: none;
            padding: 10px;
        }
        section {
            padding: 20px;
        }
        #productos {
            background-color: #ffffff;
            padding: 20px;
            width: 100%;
            margin: 20px auto;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        #productos h2 {
            font-size: 28px;
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }
        .producto {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin: 15px;
            text-align: center;
            transition: box-shadow 0.3s;
        }
        .producto:hover {
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        .producto img {
            max-width: 300px;
            height: auto;
            border-radius: 4px;
        }
        .producto h3 {
            font-size: 20px;
            color: #333;
            margin: 10px 0;
        }
        .producto p {
            font-size: 16px;
            color: #666;
            margin: 10px 0;
        }
        .precio {
            font-size: 18px;
            color: #007bff;
            font-weight: bold;
            margin: 10px 0;
        }
        .btn-agregar {
            background-color: #28a745;
            color: #ffffff;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn-agregar:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <header>
        <h1>Ventas (Productos)</h1>
    </header>
    <nav>
        <a href="index.php">Inicio</a>
    </nav>
    <section>
        <h2>Productos Disponibles</h2>
        <p>Aquí encontrarás información sobre nuestros productos.</p>
    </section>
    <section id="productos">
        <h2>Nuestros Productos</h2>
        <?php foreach ($productos as $producto) : ?>
            <div class="producto">
                <img src="producto.jpg" alt="<?php echo $producto['nombre']; ?>" class="ima_prod">
                <h3><?php echo $producto['nombre']; ?></h3>
                <p><?php echo $producto['descripcion']; ?></p>
                <span class="precio">$<?php echo $producto['precio']; ?></span>
                <button class="btn-agregar">Agregar al carrito</button>
            </div>
        <?php endforeach; ?>
    </section>
    <footer>
        <p>&copy; 2024 Mi Empresa. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
