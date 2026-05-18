<?php
require_once 'funciones.php';

$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$porPagina = 6;
$offset = ($pagina - 1) * $porPagina;

$stmtCount = $conn->query("SELECT COUNT(*) as total FROM PRODUCTOS");
$totalProd = $stmtCount->fetch(PDO::FETCH_ASSOC)['total'];
$totalPaginas = ceil($totalProd / $porPagina);

$stmt = $conn->prepare("SELECT * FROM PRODUCTOS LIMIT :limite OFFSET :offset");
$stmt->bindValue(':limite', $porPagina, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Jabones Scarlatti</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: black; margin: 0; padding: 20px; }
        .container { max-width: 1200px; margin: 0 auto; }
        .header { background: white; padding: 15px 25px; border-radius: 12px; margin-bottom: 25px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; }
        .header h1 { margin: 0; color: #333; }
        .header a { color: #007bff; text-decoration: none; margin-left: 15px; }
        .productos { display: flex; flex-wrap: wrap; gap: 20px; justify-content: center; }
        .producto { background: white; border-radius: 12px; width: 280px; padding: 15px; box-shadow: 0 4px 8px rgba(0,0,0,0.2); text-align: center; }
        .producto img { max-width: 100%; height: 150px; object-fit: cover; border-radius: 8px; background: #eee; }
        .producto h3 { margin: 10px 0 5px; color: #333; }
        .producto p { color: #666; font-size: 14px; }
        .precio { font-weight: bold; color: #007bff; font-size: 18px; }
        .stock { font-size: 13px; color: #888; }
        .btn-agregar { background: #28a745; color: white; border: none; padding: 8px 12px; border-radius: 6px; cursor: pointer; width: 100%; margin-top: 10px; }
        .btn-agregar:hover { background: #218838; }
        .paginacion { text-align: center; margin-top: 30px; }
        .paginacion a { display: inline-block; background: white; padding: 8px 12px; margin: 0 4px; border-radius: 6px; text-decoration: none; color: #007bff; }
        .mensaje { background: #d4edda; color: #155724; padding: 10px; border-radius: 8px; margin-bottom: 20px; text-align: center; }
        .error { background: #f8d7da; color: #721c24; padding: 10px; border-radius: 8px; margin-bottom: 20px; text-align: center; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Jabones Artesanales Scarlatti</h1>
        <div>
            <?php if(isset($_SESSION['email'])): ?>
                <span>Hola, <?php echo htmlspecialchars($_SESSION['nombre']); ?></span>
                <a href="logout.php">Cerrar sesión</a>
                <?php if($_SESSION['tipo']=='admin'): ?>
                    <a href="admin.php">Admin</a>
                <?php else: ?>
                    <a href="carrito.php">Mi carrito</a>
                <?php endif; ?>
            <?php else: ?>
                <a href="login.php">Iniciar sesión</a>
                <a href="registro.php">Registrarse</a>
            <?php endif; ?>
        </div>
    </div>

    <?php if(isset($_SESSION['mensaje'])): ?>
        <div class="mensaje"><?php echo $_SESSION['mensaje']; unset($_SESSION['mensaje']); ?></div>
    <?php endif; ?>
    <?php if(isset($_SESSION['error'])): ?>
        <div class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <div class="productos">
        <?php foreach($productos as $prod): ?>
            <div class="producto">
                <?php if($prod['imagen'] && file_exists("uploads/".$prod['imagen'])): ?>
                    <img src="uploads/<?php echo $prod['imagen']; ?>">
                <?php else: ?>
                    <img src="placeholder.jpg">
                <?php endif; ?>
                <h3><?php echo htmlspecialchars($prod['nombre']); ?></h3>
                <p><?php echo htmlspecialchars($prod['descripcion']); ?></p>
                <div class="precio"><?php echo $prod['precio']; ?> €</div>
                <div class="stock">Stock: <?php echo $prod['stock']; ?></div>
                <?php if(isset($_SESSION['email']) && $_SESSION['tipo']=='cliente'): ?>
                    <form action="agregar_carrito.php" method="POST">
                        <input type="hidden" name="productoID" value="<?php echo $prod['productoID']; ?>">
                        <input type="number" name="cantidad" value="1" min="1" max="2" style="width: 60px; margin: 10px 0;">
                        <button type="submit" class="btn-agregar">Añadir al carrito</button>
                    </form>
                <?php elseif(!isset($_SESSION['email'])): ?>
                    <p style="font-size:12px; color:#888;">Regístrate para comprar</p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="paginacion">
        <?php for($i=1; $i<=$totalPaginas; $i++): ?>
            <a href="?pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
        <?php endfor; ?>
    </div>
</div>
</body>
</html>