<?php
// CESTA.PHP - Apartado C: Listado de productos en el carrito, modificar cantidad, eliminar
// RA6: Solo clientes autenticados
session_start();
include_once("conexion.php");

if (!isset($_SESSION['email_cliente'])) {
    header("Location: login.php");
    exit;
}

$email = $_SESSION['email_cliente'];
$mesActual = date('Y-m');

try {
    // Buscar cesta activa del mes
    $stmtC = $conn->prepare("SELECT cestaID FROM cesta WHERE email = :email AND DATE_FORMAT(fechaCreacion, '%Y-%m') = :mes");
    $stmtC->execute([':email' => $email, ':mes' => $mesActual]);
    $cesta = $stmtC->fetch(PDO::FETCH_ASSOC);

    $items = [];
    $total = 0;

    if ($cesta) {
        $cestaID = $cesta['cestaID'];
        $sqlItems = "SELECT ic.itemcestaID, ic.productoID, ic.cantidad, p.nombre, p.precio, p.peso
                     FROM itemcesta ic
                     INNER JOIN productos p ON ic.productoID = p.productoID
                     WHERE ic.cestaID = :id";
        $stmtI = $conn->prepare($sqlItems);
        $stmtI->execute([':id' => $cestaID]);
        $items = $stmtI->fetchAll(PDO::FETCH_ASSOC);

        foreach ($items as $item) {
            $total += $item['precio'] * $item['cantidad'];
        }
    }
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// Fecha estimada de entrega: 3 días hábiles desde hoy
$fechaEntrega = new DateTime();
$fechaEntrega->modify('+3 weekdays');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Cesta - JabonesScarlatti</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Georgia', serif; background: #fdf8f4; color: #333; }
        header { background: #2c1810; color: #f5e6d3; padding: 20px 40px; display:flex; justify-content:space-between; align-items:center; }
        header h1 { font-size: 22px; }
        header a { color: #f5e6d3; text-decoration:none; font-size:13px; border:1px solid #c4a882; padding:7px 13px; }
        header a:hover { background:#c4a882; color:#2c1810; }
        .contenido { max-width: 800px; margin: 40px auto; padding: 0 20px; }
        h2 { color: #2c1810; margin-bottom: 25px; }
        .alerta { padding: 12px 16px; border-radius:4px; margin-bottom:15px; font-size:14px; }
        .alerta.ok  { background:#d4edda; border:1px solid #28a745; color:#155724; }
        .alerta.err { background:#fde8e8; border:1px solid #e74c3c; color:#c0392b; }
        table { width:100%; border-collapse:collapse; }
        th, td { padding:12px 10px; border:1px solid #e0d0c0; text-align:left; font-size:14px; }
        th { background:#f5e6d3; color:#2c1810; }
        .btn-accion {
            padding:5px 10px; font-size:12px; border:1px solid #2c1810;
            background:white; cursor:pointer; font-family:'Georgia',serif;
            text-decoration:none; color:#2c1810; display:inline-block;
        }
        .btn-accion:hover { background:#2c1810; color:white; }
        .btn-accion.eliminar { border-color:#c0392b; color:#c0392b; }
        .btn-accion.eliminar:hover { background:#c0392b; color:white; }
        .resumen {
            background:white; border:1px solid #e0d0c0; border-radius:8px;
            padding:25px; margin-top:25px;
        }
        .resumen h3 { color:#2c1810; margin-bottom:15px; }
        .resumen .linea { display:flex; justify-content:space-between; margin:8px 0; font-size:14px; }
        .resumen .total-linea { border-top:2px solid #2c1810; padding-top:12px; margin-top:12px; font-weight:bold; font-size:16px; }
        .btn-pedido {
            display:block; width:100%; padding:14px; background:#2c1810; color:white;
            text-align:center; text-decoration:none; border-radius:4px; font-size:15px;
            margin-top:20px; font-family:'Georgia',serif; border:none; cursor:pointer;
            transition: background 0.2s;
        }
        .btn-pedido:hover { background:#5a3020; }
        .vacia { text-align:center; padding:60px; color:#999; }
        .info-entrega { font-size:13px; color:#7a5c44; margin-top:8px; font-style:italic; }
        select { padding:5px; border:1px solid #c4a882; border-radius:3px; font-family:'Georgia',serif; }
    </style>
</head>
<body>

<header>
    <h1>🛒 Mi Cesta</h1>
    <div>
        <a href="index.php">← Seguir comprando</a>
        <a href="logout.php" style="margin-left:10px; color:#ffaaaa; border-color:#ffaaaa;">Salir</a>
    </div>
</header>

<div class="contenido">
    <h2>Hola, <?php echo htmlspecialchars($_SESSION['nombre_cliente']); ?></h2>

    <?php if (isset($_SESSION['ok_cesta'])): ?>
        <div class="alerta ok"><?php echo $_SESSION['ok_cesta']; unset($_SESSION['ok_cesta']); ?></div>
    <?php endif; ?>
    <?php if (isset($_SESSION['error_cesta'])): ?>
        <div class="alerta err"><?php echo $_SESSION['error_cesta']; unset($_SESSION['error_cesta']); ?></div>
    <?php endif; ?>

    <?php if (empty($items)): ?>
        <div class="vacia">
            <p style="font-size:50px; margin-bottom:15px;">🧼</p>
            <p>Tu cesta está vacía.</p>
            <a href="index.php" style="color:#2c1810; font-weight:bold;">Ver productos →</a>
        </div>
    <?php else: ?>

    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Precio/ud</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item): ?>
            <tr>
                <td><?php echo htmlspecialchars($item['nombre']); ?><br><small style="color:#999"><?php echo $item['peso']; ?>g</small></td>
                <td><?php echo number_format($item['precio'], 2); ?>€</td>
                <td>
                    <!-- Formulario para actualizar cantidad -->
                    <form action="actualizarCesta.php" method="POST" style="display:inline">
                        <input type="hidden" name="itemID" value="<?php echo $item['itemcestaID']; ?>">
                        <select name="cantidad" onchange="this.form.submit()">
                            <option value="1" <?php if($item['cantidad']==1) echo 'selected'; ?>>1</option>
                            <option value="2" <?php if($item['cantidad']==2) echo 'selected'; ?>>2</option>
                        </select>
                    </form>
                </td>
                <td><?php echo number_format($item['precio'] * $item['cantidad'], 2); ?>€</td>
                <td>
                    <a href="eliminarItemCesta.php?id=<?php echo $item['itemcestaID']; ?>"
                       class="btn-accion eliminar"
                       onclick="return confirm('¿Eliminar este producto?')">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="resumen">
        <h3>Resumen del pedido</h3>
        <?php foreach ($items as $item): ?>
        <div class="linea">
            <span><?php echo htmlspecialchars($item['nombre']); ?> × <?php echo $item['cantidad']; ?></span>
            <span><?php echo number_format($item['precio'] * $item['cantidad'], 2); ?>€</span>
        </div>
        <?php endforeach; ?>
        <div class="linea total-linea">
            <span>TOTAL</span>
            <span><?php echo number_format($total, 2); ?>€</span>
        </div>
        <p class="info-entrega">📅 Fecha estimada de entrega: <strong><?php echo $fechaEntrega->format('d/m/Y'); ?></strong></p>
        <p class="info-entrega">📍 Recogida en el centro · Pago en mano</p>

        <a href="finalizarPedido.php" class="btn-pedido">Finalizar Pedido →</a>
    </div>

    <?php endif; ?>
</div>
</body>
</html>