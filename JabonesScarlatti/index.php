<?php
// INDEX.PHP - Página pública (visitantes sin registrar pueden ver productos)
// RA6: Acceso seguro a datos, sin mostrar datos sensibles a no autenticados
session_start();
include_once("conexion.php");

// Paginación
$porPagina = 6;
$pagina = isset($_GET['pag']) ? (int)$_GET['pag'] : 1;
if ($pagina < 1) $pagina = 1;
$offset = ($pagina - 1) * $porPagina;

try {
    // Total de productos para calcular páginas
    $totalStmt = $conn->query("SELECT COUNT(*) FROM productos");
    $total = $totalStmt->fetchColumn();
    $totalPaginas = ceil($total / $porPagina);

    // Productos de esta página - consulta paginada
    $sql = "SELECT * FROM productos LIMIT :limite OFFSET :offset";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':limite', $porPagina, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Error al cargar productos: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>JabonesScarlatti - Jabones Naturales</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Georgia', serif; background: #fdf8f4; color: #333; }
        header {
            background: #2c1810;
            color: #f5e6d3;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        header h1 { font-size: 28px; letter-spacing: 2px; }
        header p { font-size: 13px; color: #c4a882; margin-top: 4px; }
        nav a {
            color: #f5e6d3;
            text-decoration: none;
            margin-left: 15px;
            padding: 8px 14px;
            border: 1px solid #c4a882;
            font-size: 13px;
            transition: background 0.2s;
        }
        nav a:hover { background: #c4a882; color: #2c1810; }
        .hero {
            background: linear-gradient(135deg, #f5e6d3 0%, #e8d5c0 100%);
            padding: 40px;
            text-align: center;
            border-bottom: 2px solid #c4a882;
        }
        .hero h2 { font-size: 22px; color: #2c1810; margin-bottom: 8px; }
        .hero p { color: #7a5c44; font-size: 14px; }
        .productos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 25px;
            padding: 40px;
            max-width: 1200px;
            margin: 0 auto;
        }
        .producto-card {
            background: white;
            border: 1px solid #e0d0c0;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .producto-card:hover { transform: translateY(-3px); box-shadow: 0 6px 16px rgba(0,0,0,0.12); }
        .producto-card img { width: 100%; height: 180px; object-fit: cover; border-radius: 4px; margin-bottom: 15px; }
        .producto-card .sin-imagen {
            width: 100%; height: 180px; background: #f5e6d3;
            display: flex; align-items: center; justify-content: center;
            border-radius: 4px; margin-bottom: 15px; font-size: 40px;
        }
        .producto-card h3 { font-size: 16px; color: #2c1810; margin-bottom: 8px; }
        .producto-card p { font-size: 13px; color: #7a5c44; margin-bottom: 10px; line-height: 1.5; }
        .producto-card .info { display: flex; justify-content: space-between; align-items: center; margin-top: 12px; }
        .producto-card .precio { font-size: 20px; font-weight: bold; color: #2c1810; }
        .producto-card .peso { font-size: 12px; color: #999; }
        .btn-comprar {
            display: block;
            margin-top: 12px;
            background: #2c1810;
            color: white;
            text-align: center;
            padding: 10px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 13px;
            transition: background 0.2s;
        }
        .btn-comprar:hover { background: #5a3020; }
        .btn-comprar.desactivado {
            background: #ccc;
            pointer-events: none;
            cursor: not-allowed;
        }
        /* Paginación */
        .paginacion {
            text-align: center;
            padding: 30px;
        }
        .paginacion a, .paginacion span {
            display: inline-block;
            margin: 0 4px;
            padding: 8px 14px;
            border: 1px solid #c4a882;
            text-decoration: none;
            color: #2c1810;
            font-size: 14px;
            border-radius: 4px;
        }
        .paginacion .actual { background: #2c1810; color: white; }
        .mensaje-info {
            background: #fff3cd;
            border: 1px solid #ffc107;
            padding: 12px 20px;
            margin: 20px 40px;
            border-radius: 4px;
            font-size: 14px;
        }
        footer {
            background: #2c1810;
            color: #c4a882;
            text-align: center;
            padding: 20px;
            font-size: 13px;
            margin-top: 40px;
        }
    </style>
</head>
<body>

<header>
    <div>
        <h1>🧼 JabonesScarlatti</h1>
        <p>Jabones naturales del taller de química</p>
    </div>
    <nav>
        <?php if (isset($_SESSION['admin'])): ?>
            <a href="admin.php">Panel Admin</a>
            <a href="logout.php">Cerrar Sesión</a>
        <?php elseif (isset($_SESSION['email_cliente'])): ?>
            <a href="cesta.php">🛒 Mi Cesta</a>
            <a href="misPedidos.php">Mis Pedidos</a>
            <a href="logout.php">Cerrar Sesión</a>
        <?php else: ?>
            <a href="login.php">Iniciar Sesión</a>
            <a href="registro.php">Registrarse</a>
        <?php endif; ?>
    </nav>
</header>

<div class="hero">
    <h2>Jabones artesanales elaborados en nuestro taller</h2>
    <p>Productos naturales hechos por los alumnos del taller de química · Recogida en el centro · Pago en mano</p>
</div>

<?php if (!isset($_SESSION['email_cliente']) && !isset($_SESSION['admin'])): ?>
<div class="mensaje-info">
    👋 Estás viendo nuestro catálogo como visitante. <a href="registro.php">Regístrate</a> o <a href="login.php">inicia sesión</a> para añadir productos a tu cesta.
</div>
<?php endif; ?>

<?php if (empty($productos)): ?>
    <p style="text-align:center; padding:60px; color:#999;">No hay productos disponibles en este momento.</p>
<?php else: ?>
<div class="productos-grid">
    <?php foreach ($productos as $p): ?>
    <div class="producto-card">
        <?php if (!empty($p['imagen']) && file_exists('uploads/' . $p['imagen'])): ?>
            <img src="uploads/<?php echo htmlspecialchars($p['imagen']); ?>" alt="<?php echo htmlspecialchars($p['nombre']); ?>">
        <?php else: ?>
            <div class="sin-imagen">🧼</div>
        <?php endif; ?>
        <h3><?php echo htmlspecialchars($p['nombre']); ?></h3>
        <p><?php echo htmlspecialchars($p['descripcion'] ?? 'Jabón natural artesanal.'); ?></p>
        <div class="info">
            <span class="precio"><?php echo number_format($p['precio'], 2); ?>€</span>
            <span class="peso"><?php echo number_format($p['peso'], 0); ?>g</span>
        </div>
        <?php if (isset($_SESSION['email_cliente'])): ?>
            <a href="añadirCesta.php?id=<?php echo urlencode($p['productoID']); ?>" class="btn-comprar">Añadir a la cesta</a>
        <?php else: ?>
            <a href="login.php" class="btn-comprar">Inicia sesión para comprar</a>
        <?php endif; ?>
    </div>
    <?php endforeach; ?>
</div>

<!-- PAGINACIÓN -->
<div class="paginacion">
    <?php if ($pagina > 1): ?>
        <a href="?pag=<?php echo $pagina - 1; ?>">← Anterior</a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
        <?php if ($i == $pagina): ?>
            <span class="actual"><?php echo $i; ?></span>
        <?php else: ?>
            <a href="?pag=<?php echo $i; ?>"><?php echo $i; ?></a>
        <?php endif; ?>
    <?php endfor; ?>

    <?php if ($pagina < $totalPaginas): ?>
        <a href="?pag=<?php echo $pagina + 1; ?>">Siguiente →</a>
    <?php endif; ?>
</div>
<?php endif; ?>

<footer>
    &copy; <?php echo date('Y'); ?> JabonesScarlatti · Taller de Química IES Scarlatti
</footer>

</body>
</html>