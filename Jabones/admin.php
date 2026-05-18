<?php
session_start();

include_once("conexion.php");
include("paginacionPdo.php"); // Usamos tu misma paginación del examen

// CONTROL DE SEGURIDAD (RA6): Si no es el admin, lo echamos al login
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

// En vez de pacientes, el admin aquí ve la lista completa de clientes de la tienda
$query = 'SELECT * from clientes';
$listaPaginaActual = paginacion($conn, $query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Admin - Jabones Scarlatti</title>
    <style>
        /* Tus estilos literales de gestionaPacientes.php */
        h1{ text-align: center; font-size: 45px; }
        p{ text-align: center; font-size: 20px; }
        table { width: 80%; border-collapse: collapse; margin: 0 auto; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #eee; }
        
        .paginacion { text-align: center; margin-top: 20px; }
        .paginacion a, .paginacion strong {
            display: inline-block;
            border: 1px solid black;
            padding: 3px 6px;
            margin-right: 4px;
            text-decoration: none;
            color: black;
        }
        .paginacion strong { background-color: #ccc; }
    </style>
</head>
<body>

    <h1>Panel de Administración</h1>
    <p>Bienvenido, Administrador | <a href="logout.php" style="color:red;">Cerrar Sesión</a></p>
    
    <h3 style="text-align: center;">Listado de Clientes Registrados</h3>

    <table>
        <thead>
            <tr>
                <th>Email / Usuario</th>
                <th>Nombre Completo</th>
                <th>Dirección</th>
                <th>Código Postal</th>
                <th>Teléfono</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            // Tu bucle fetch exacto recorriendo la tabla
            if ($listaPaginaActual['total'] > 0): 
                while ($cliente = $listaPaginaActual['datos']->fetch(PDO::FETCH_ASSOC)): 
            ?>
                    <tr>
                        <td><?php echo htmlspecialchars($cliente['email']); ?></td>
                        <td><?php echo htmlspecialchars($cliente['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($cliente['direccion']); ?></td>
                        <td><?php echo $cliente['CP']; ?></td>
                        <td><?php echo $cliente['Tlfn']; ?></td>
                    </tr>
            <?php 
                endwhile; 
            else: 
            ?>
                <tr><td colspan="5" style="text-align:center;">No hay clientes en la base de datos.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class='paginacion'>
        <?php
        if ($listaPaginaActual['actual'] > 1) {
            $prev = $listaPaginaActual['actual'] - 1;
            echo "<a href='?pagina=$prev'> << Anterior </a> ";
        } else {
            echo "<span style='color:gray'> << Anterior </span> ";
        }

        $maxBotones = 10; 
        $mitad = floor($maxBotones / 2);
        $inicioRango = $listaPaginaActual['actual'] - $mitad;
        $finRango = $listaPaginaActual['actual'] + $mitad;

        if ($inicioRango < 1) {
            $inicioRango = 1;
            $finRango = min($maxBotones, $listaPaginaActual['paginas']);
        }
        if ($finRango > $listaPaginaActual['paginas']) {
            $finRango = $listaPaginaActual['paginas'];
            $inicioRango = max(1, $listaPaginaActual['paginas'] - $maxBotones + 1);
        }

        for ($i = $inicioRango; $i <= $finRango; $i++) {
            if ($i == $listaPaginaActual['actual']) {
                echo "<strong> $i </strong> "; 
            } else {
                echo "<a href='?pagina=$i'> $i </a> ";
            }
        }

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