<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <?php
    
    // Arrays adicionales para los detalles
    $dimensiones = [
        1 => "35.8 x 24.2 x 2.3 cm",
        2 => "11.5 x 6.0 x 3.5 cm", 
        3 => "44.0 x 13.5 x 3.0 cm",
        4 => "55.2 x 33.5 x 5.1 cm",
        5 => "18.5 x 16.0 x 8.5 cm"
    ];

    $descripciones = [
        1 => "Laptop gaming de alto rendimiento con procesador Intel i7, 16GB RAM, SSD 512GB y tarjeta gráfica RTX 3060.",
        2 => "Mouse ergonómico inalámbrico con sensor óptico de 1600 DPI y batería recargable.",
        3 => "Teclado mecánico retroiluminado con switches blue y diseño anti-ghosting.",
        4 => "Monitor LED Full HD 24 pulgadas con tiempo de respuesta de 1ms y conexión HDMI.",
        5 => "Auriculares inalámbricos con cancelación de ruido y batería de 20 horas de duración."
    ];

    $colores = [
        1 => "Negro mate",
        2 => "Blanco y plateado",
        3 => "Negro con RGB",
        4 => "Negro con bordes finos",
        5 => "Negro y azul"
    ];
    $id = $_GET['id'];
    $nombre = $_GET['nombre'];
    $precio = $_GET['precio'];

    echo '<b>El producto: </b>';
    echo $nombre;
    echo '<br>';
    echo '<b>Con un precio de: </b>';
    echo $precio.'€';
    echo '<br>';
    echo '<b>Las dimensiones son: </b>';
    echo $dimensiones[$id];
    echo '<br>';
    echo '<b>La descripcion del producto es: </b>';
    echo $descripciones[$id];
    echo '<br>';
    echo '<b>Los colores del producto es: </b>';
    echo $colores[$id];
    echo '<br>';


    ?>


    
</body>
</html>