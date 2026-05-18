<?php
session_start();

include_once("conexion.php");
include("paginacionPdo.php"); // Incluye tu archivo estrella

// CONTROL DE SEGURIDAD (RA6): Si no está logueado como cliente, al login
if (!isset($_SESSION['cliente'])) {
    header("Location: login.php");
    exit;
}

// Cambiamos 'SELECT * from pacientes' por tu tabla de productos de jabones
$query = 'SELECT * from productos';
$listaPaginaActual = paginacion($conn, $query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tienda - Jabones Scarlatti</title>
    <style>
        /* Copiado de tus estilos base del examen */
        h1 { text-align: center; font-size: 45px; }
        p { text-align: center; font-size: 20px; }
        .grid-productos { display: flex; gap: 20px; justify-content: center; margin-top: 20px; }
        .card-producto { border: 1px solid black; padding: 15px; width: 220px; text-align: center; background: #fff; }
        .card-producto img { max-width: 100%; height: 120px; object-fit: cover; }
        .precio { font-size: 18px; font-weight: bold; color: green; margin: 10px 0; }
        
        /* Tus estilos literales para la botonera de páginas */
        .paginacion { text-align: center; margin-top: 20px; }
        .paginacion a, .paginacion strong {
            display: inline-block;
            border: 1px solid black;
            padding: 3px 6px;
            margin-right: 4px;
            text-decoration: none;
            color: black;
        }
        .paginacion strong {
            background-color: #ccc;
        }
    </style>
</head>
<body>

    <h1>Catálogo de Jabones</h1>
    <p>Bienvenido/a, <?php echo htmlspecialchars($_SESSION['cliente']); ?> | <a href="logout.php" style="color:red;">Salir</a></p>
    
    <div class="grid-productos">
        <?php 
        // Tu bucle fetch(PDO::FETCH_ASSOC) idéntico al de tus exámenes anteriores
        if ($listaPaginaActual['total'] > 0): 
            while ($pro = $listaPaginaActual['datos']->fetch(PDO::FETCH_ASSOC)): 
        ?>
                <div class="card-producto">
                    <img src="img/<?php echo !empty($pro['imagen']) ? $pro['imagen'] : 'default.jpg'; ?>" alt="Jabón">
                    <h3><?php echo htmlspecialchars($pro['nombre']); ?></h3>
                    <p style="font-size: 14px;"><?php echo htmlspecialchars($pro['descripcion']); ?></p>
                    <div class="precio"><?php echo $pro['precio']; ?> €</div>
                    
                    <a href="agregarCarrito.php?id=<?php echo $pro['productoID']; ?>" style="background: green; color: white; padding: 5px 10px; text-decoration: none; display: inline-block;">Comprar</a>
                </div>
        <?php 
            endwhile; 
        else: 
        ?>
            <p>No se encontraron productos en el catálogo.</p>
        <?php endif; ?>
    </div>

    <div class='paginacion'>
        <?php
        // Botón Anterior
        if ($listaPaginaActual['actual'] > 1) {
            $prev = $listaPaginaActual['actual'] - 1;
            echo "<a href='?pagina=$prev'> << Anterior </a> ";
        } else {
            echo "<span style='color:gray'> << Anterior </span> ";
        }

        // Los botones entre anterior y siguiente, son 10 y el actual en el medio
        $maxBotones = 10; 
        $mitad = floor($maxBotones / 2);

        $inicioRango = $listaPaginaActual['actual'] - $mitad;
        $finRango = $listaPaginaActual['actual'] + $mitad;

        // Si estamos en las primeras paginas que no aparezca la activa en el medio
        if ($inicioRango < 1) {
            $inicioRango = 1;
            $finRango = min($maxBotones, $listaPaginaActual['paginas']);
        }

        // Igual pero al final
        if ($finRango > $listaPaginaActual['paginas']) {
            $finRango = $listaPaginaActual['paginas'];
            $inicioRango = max(1, $listaPaginaActual['paginas'] - $maxBotones + 1);
        }

        // Imprimimos solo los números calculados en el rango
        for ($i = $inicioRango; $i <= $finRango; $i++) {
            if ($i == $listaPaginaActual['actual']) {
                echo "<strong> $i </strong> "; 
            } else {
                echo "<a href='?pagina=$i'> $i </a> ";
            }
        }

        // Boton siguiente para ir hacia adelante
        if ($listaPaginaActual['actual'] < $listaPaginaActual['paginas']) {
            $next = $listaPaginaActual['actual'] + 1;
            echo "<a href='?pagina=$next'> Siguiente >> </a> ";
        } else {
            echo "<span style='color:gray'> Siguiente >> </span> ";
        }
        ?>
    </div>

</body>
</html>