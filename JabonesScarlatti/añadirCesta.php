<?php
// AÑADIRCESTA.PHP - Apartado C: Añadir producto al carrito
// RA6: Seguridad - solo clientes autenticados, validaciones de negocio (2 artículos/mes, máx 2 unidades total)
session_start();
include_once("conexion.php");

// Solo clientes autenticados pueden usar el carrito
if (!isset($_SESSION['email_cliente'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$email = $_SESSION['email_cliente'];
$productoID = $_GET['id'];
$cantidad = isset($_POST['cantidad']) ? (int)$_POST['cantidad'] : 1;

// Mostrar formulario de cantidad si no se ha enviado
if (!isset($_POST['cantidad'])) {
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Añadir a la cesta</title>
    <style>
        body { font-family: 'Georgia', serif; background: #fdf8f4; display:flex; justify-content:center; padding: 60px 20px; }
        .card { background:white; padding:35px; border-radius:8px; border:1px solid #e0d0c0; width:360px; box-shadow:0 4px 15px rgba(0,0,0,0.1); }
        h2 { color:#2c1810; margin-bottom:20px; }
        label { display:block; font-weight:bold; color:#555; margin-top:15px; font-size:13px; }
        select { width:100%; padding:10px; border:1px solid #c4a882; border-radius:4px; font-size:14px; margin-top:5px; }
        .btn { width:100%; padding:12px; background:#2c1810; color:white; border:none; border-radius:4px; font-size:15px; cursor:pointer; margin-top:20px; font-family:'Georgia',serif; }
        .btn:hover { background:#5a3020; }
        .volver { display:block; text-align:center; margin-top:12px; color:#7a5c44; text-decoration:none; font-size:13px; }
        .info { font-size:13px; color:#999; margin-top:10px; font-style:italic; }
    </style>
</head>
<body>
<div class="card">
    <h2>Añadir a la cesta</h2>
    <?php
    // Mostrar nombre del producto
    $stmtP = $conn->prepare("SELECT nombre, precio FROM productos WHERE productoID = :id");
    $stmtP->execute([':id' => $productoID]);
    $prod = $stmtP->fetch(PDO::FETCH_ASSOC);
    if ($prod) {
        echo "<p><strong>" . htmlspecialchars($prod['nombre']) . "</strong> — " . number_format($prod['precio'],2) . "€</p>";
    }
    ?>
    <p class="info">Máximo 2 unidades por pedido · Solo 2 artículos al mes por cliente</p>
    <form action="añadirCesta.php?id=<?php echo urlencode($productoID); ?>" method="POST">
        <label>Cantidad:</label>
        <select name="cantidad">
            <option value="1">1</option>
            <option value="2">2</option>
        </select>
        <button type="submit" class="btn">Añadir a la cesta</button>
    </form>
    <a href="index.php" class="volver">← Volver a la tienda</a>
</div>
</body>
</html>
<?php
    exit;
}

// ---- PROCESAMIENTO ----
try {
    $conn->beginTransaction();

    // REGLA DE NEGOCIO 1: Máx 2 artículos por cliente al mes
    // Contamos cuántos items tiene en cestas o pedidos este mes
    $mesActual = date('Y-m');
    $sqlMes = "SELECT COALESCE(SUM(ic.cantidad), 0) as total
               FROM itemcesta ic
               INNER JOIN cesta c ON ic.cestaID = c.cestaID
               WHERE c.email = :email
               AND DATE_FORMAT(c.fechaCreacion, '%Y-%m') = :mes";
    $stmtMes = $conn->prepare($sqlMes);
    $stmtMes->execute([':email' => $email, ':mes' => $mesActual]);
    $totalMes = (int)$stmtMes->fetchColumn();

    if ($totalMes >= 2) {
        $conn->rollBack();
        $_SESSION['error_cesta'] = "Ya tienes 2 artículos este mes. Solo se permiten 2 artículos por cliente al mes.";
        header("Location: cesta.php");
        exit;
    }

    // Ajustar cantidad para no superar el límite mensual
    if ($totalMes + $cantidad > 2) {
        $cantidad = 2 - $totalMes;
    }

    // Buscar cesta activa del cliente (sin haber generado pedido)
    $stmtCesta = $conn->prepare("SELECT cestaID FROM cesta WHERE email = :email AND DATE_FORMAT(fechaCreacion, '%Y-%m') = :mes");
    $stmtCesta->execute([':email' => $email, ':mes' => $mesActual]);
    $cesta = $stmtCesta->fetch(PDO::FETCH_ASSOC);

    if (!$cesta) {
        // Crear nueva cesta
        $stmtNueva = $conn->prepare("INSERT INTO cesta (email, fechaCreacion) VALUES (:email, :fecha)");
        $stmtNueva->execute([':email' => $email, ':fecha' => date('Y-m-d')]);
        $cestaID = $conn->lastInsertId();
    } else {
        $cestaID = $cesta['cestaID'];
    }

    // REGLA DE NEGOCIO 2: Máx 2 unidades TOTAL en la cesta
    $stmtTotal = $conn->prepare("SELECT COALESCE(SUM(cantidad), 0) FROM itemcesta WHERE cestaID = :id");
    $stmtTotal->execute([':id' => $cestaID]);
    $totalCesta = (int)$stmtTotal->fetchColumn();

    if ($totalCesta >= 2) {
        $conn->rollBack();
        $_SESSION['error_cesta'] = "La cesta ya tiene el máximo de 2 unidades.";
        header("Location: cesta.php");
        exit;
    }

    if ($totalCesta + $cantidad > 2) {
        $cantidad = 2 - $totalCesta;
    }

    // Comprobar si el producto ya está en la cesta → actualizar cantidad
    $stmtExiste = $conn->prepare("SELECT itemcestaID, cantidad FROM itemcesta WHERE cestaID = :cesta AND productoID = :prod");
    $stmtExiste->execute([':cesta' => $cestaID, ':prod' => $productoID]);
    $itemExiste = $stmtExiste->fetch(PDO::FETCH_ASSOC);

    if ($itemExiste) {
        $nuevaCantidad = min(2, $itemExiste['cantidad'] + $cantidad);
        $stmtUp = $conn->prepare("UPDATE itemcesta SET cantidad = :cant WHERE itemcestaID = :id");
        $stmtUp->execute([':cant' => $nuevaCantidad, ':id' => $itemExiste['itemcestaID']]);
    } else {
        $stmtIns = $conn->prepare("INSERT INTO itemcesta (cestaID, productoID, cantidad) VALUES (:cesta, :prod, :cant)");
        $stmtIns->execute([':cesta' => $cestaID, ':prod' => $productoID, ':cant' => $cantidad]);
    }

    $conn->commit();
    $_SESSION['ok_cesta'] = "Producto añadido a la cesta.";
    header("Location: cesta.php");
    exit;

} catch (PDOException $e) {
    $conn->rollBack();
    die("Error al añadir a la cesta: " . $e->getMessage());
}
?>