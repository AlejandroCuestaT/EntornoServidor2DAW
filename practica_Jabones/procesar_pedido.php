<?php
require_once 'funciones.php';
if(!isset($_SESSION['email']) || $_SESSION['tipo']!='cliente') redirigir('jabonescarlatti.php');

$email = $_SESSION['email'];
$cestaID = obtenerCarritoActivo($email);
$unidadesCarrito = totalUnidadesCarrito($cestaID);
$unidadesMes = unidadesPedidasEsteMes($email);

if($unidadesCarrito + $unidadesMes > 2) {
    $_SESSION['error'] = "Has superado el límite mensual de 2 unidades.";
    redirigir('carrito.php');
}

$stmtItems = $conn->prepare("SELECT i.productoID, i.cantidad, p.precio, p.nombre, p.stock 
                             FROM ITEMCESTA i JOIN PRODUCTOS p ON i.productoID = p.productoID WHERE i.cestaID = ?");
$stmtItems->execute([$cestaID]);
$items = $stmtItems->fetchAll(PDO::FETCH_ASSOC);

if(count($items) == 0) redirigir('carrito.php');

$totalPedido = 0;
$productosPedido = [];
foreach($items as $item) {
    if($item['cantidad'] > $item['stock']) {
        $_SESSION['error'] = "Stock insuficiente para " . $item['nombre'];
        redirigir('carrito.php');
    }
    $totalPedido += $item['cantidad'] * $item['precio'];
    $productosPedido[] = $item;
}

$fechaEntrega = date('Y-m-d', strtotime('+7 days'));
$conn->beginTransaction();
try {
    $stmtPedido = $conn->prepare("INSERT INTO PEDIDOS (email, totalPedido, fechaEntregaEstimada) VALUES (?, ?, ?)");
    $stmtPedido->execute([$email, $totalPedido, $fechaEntrega]);
    $pedidoID = $conn->lastInsertId();

    foreach($productosPedido as $prod) {
        $stmtItemPed = $conn->prepare("INSERT INTO ITEMPEDIDO (pedidoID, productoID, unidades, precio_unitario) VALUES (?,?,?,?)");
        $stmtItemPed->execute([$pedidoID, $prod['productoID'], $prod['cantidad'], $prod['precio']]);

        $nuevoStock = $prod['stock'] - $prod['cantidad'];
        $stmtStock = $conn->prepare("UPDATE PRODUCTOS SET stock = ? WHERE productoID = ?");
        $stmtStock->execute([$nuevoStock, $prod['productoID']]);
    }

    $delCesta = $conn->prepare("DELETE FROM ITEMCESTA WHERE cestaID = ?");
    $delCesta->execute([$cestaID]);

    $conn->commit();

    $_SESSION['mensaje'] = "Pedido #$pedidoID realizado con éxito. Fecha estimada de entrega: " . date('d/m/Y', strtotime('+7 days'));
    redirigir('jabonescarlatti.php');

} catch(Exception $e) {
    $conn->rollBack();
    $_SESSION['error'] = "Error al procesar el pedido: " . $e->getMessage();
    redirigir('carrito.php');
}
?>