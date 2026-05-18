<?php
require_once 'funciones.php';
if(!isset($_SESSION['email']) || $_SESSION['tipo']!='cliente') redirigir('jabonescarlatti.php');

$email = $_SESSION['email'];
$cestaID = obtenerCarritoActivo($email);
$totalCarrito = 0;

$stmt = $conn->prepare("SELECT i.productoID, p.nombre, p.precio, i.cantidad, (p.precio * i.cantidad) as subtotal 
                        FROM ITEMCESTA i JOIN PRODUCTOS p ON i.productoID = p.productoID WHERE i.cestaID = ?");
$stmt->execute([$cestaID]);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['actualizar'])) {
    foreach($_POST['cantidad'] as $prodID => $cant) {
        if($cant<=0) {
            $del = $conn->prepare("DELETE FROM ITEMCESTA WHERE cestaID=? AND productoID=?");
            $del->execute([$cestaID, $prodID]);
        } else {
            $upd = $conn->prepare("UPDATE ITEMCESTA SET cantidad=? WHERE cestaID=? AND productoID=?");
            $upd->execute([$cant, $cestaID, $prodID]);
        }
    }
    redirigir('carrito.php');
}
if(isset($_GET['eliminar'])) {
    $prodEliminar = $_GET['eliminar'];
    $del = $conn->prepare("DELETE FROM ITEMCESTA WHERE cestaID=? AND productoID=?");
    $del->execute([$cestaID, $prodEliminar]);
    redirigir('carrito.php');
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Mi carrito - Jabones Scarlatti</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: black; margin: 0; padding: 30px; }
        .card { max-width: 900px; margin: 0 auto; background: white; border-radius: 12px; padding: 25px; box-shadow: 0 10px 25px rgba(0,0,0,0.5); }
        h2 { color: #333; margin-top: 0; text-align: center; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #f2f2f2; }
        .total { font-size: 20px; font-weight: bold; text-align: right; margin-top: 15px; }
        .btn { background: #007bff; color: white; border: none; padding: 10px 20px; border-radius: 6px; cursor: pointer; font-size: 16px; text-decoration: none; display: inline-block; margin-top: 10px; }
        .btn-finalizar { background: #28a745; }
        .btn-finalizar:hover { background: #218838; }
        .btn:hover { background: #0056b3; }
        .acciones { margin-top: 20px; display: flex; gap: 15px; flex-wrap: wrap; justify-content: space-between; align-items: center; }
        .error { background: #f8d7da; color: #721c24; padding: 10px; border-radius: 8px; margin-bottom: 20px; }
    </style>
</head>
<body>
<div class="card">
    <h2>Mi carrito de compra</h2>
    <?php if(isset($_SESSION['error'])): ?>
        <div class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>
    <form method="POST">
        <table>
            <tr><th>Producto</th><th>Precio</th><th>Cantidad</th><th>Subtotal</th><th></th></tr>
            <?php foreach($items as $row): 
                $totalCarrito += $row['subtotal']; ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                    <td><?php echo $row['precio']; ?> €</td>
                    <td><input type="number" name="cantidad[<?php echo $row['productoID']; ?>]" value="<?php echo $row['cantidad']; ?>" min="0" max="2" style="width: 60px;"></td>
                    <td><?php echo $row['subtotal']; ?> €</td>
                    <td><a href="?eliminar=<?php echo $row['productoID']; ?>" style="color: red;">Eliminar</a></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <div class="total">Total: <?php echo $totalCarrito; ?> €</div>
        <div class="acciones">
            <button type="submit" name="actualizar" class="btn">Actualizar cantidades</button>
            <?php if(count($items)>0): ?>
                <a href="procesar_pedido.php" class="btn btn-finalizar">Finalizar pedido</a>
            <?php endif; ?>
            <a href="jabonescarlatti.php" class="btn">Seguir comprando</a>
        </div>
    </form>
</div>
</body>
</html>