<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
     <style>
        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .detalles-link {
            color: #007bff;
            text-decoration: none;
        }
        .detalles-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <?php
    //una tabla id producto nombre precio y lgo otra columna que diga detalles que sea un href 
    //que enlace a un script que muestre los detalles de los productos, las propiedades del producto 
    //todos llevan a recibeprocesa y depende del id del prodcuto muestra sus detalles
    $productos = [
    ['id' => 1, 'nombre' => 'Laptop Gamer', 'precio' => 1200.50],
    ['id' => 2, 'nombre' => 'Mouse Inalámbrico', 'precio' => 25.99],
    ['id' => 3, 'nombre' => 'Teclado Mecánico', 'precio' => 89.75],
    ['id' => 4, 'nombre' => 'Monitor', 'precio' => 199.00],
    ['id' => 5, 'nombre' => 'Auriculares Bluetooth', 'precio' => 45.30]
];
    ?>
    <h2 style="text-align: center;">Lista de Productos</h2>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Producto</th>
                <th>Precio</th>
                <th>Detalles</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productos as $producto): ?>
            <tr>
                <td><?php echo $producto['id']; ?></td>
                <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                <td><?php echo number_format($producto['precio'], 2); ?> €</td>
                <td>
                    <a href="13_recibeProcesa.php?id=<?php echo $producto['id']; ?>&nombre=<?php echo urlencode($producto['nombre']); ?>&precio=<?php echo $producto['precio']; ?>" class="detalles-link">
                        Ver Detalles
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>

    
   