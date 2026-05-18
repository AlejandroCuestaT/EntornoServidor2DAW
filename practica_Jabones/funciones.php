<?php
require_once 'config.php';

function redirigir($url) {
    header("Location: $url");
    exit;
}

function obtenerCarritoActivo($email) {
    global $conn;
    $stmt = $conn->prepare("SELECT cestaID FROM CESTA WHERE email = ?");
    $stmt->execute([$email]);
    $fila = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($fila) {
        return $fila['cestaID'];
    } else {
        $stmt2 = $conn->prepare("INSERT INTO CESTA (email) VALUES (?)");
        $stmt2->execute([$email]);
        return $conn->lastInsertId();
    }
}

function unidadesPedidasEsteMes($email) {
    global $conn;
    $inicioMes = date('Y-m-01 00:00:00');
    $finMes = date('Y-m-t 23:59:59');
    $stmt = $conn->prepare("SELECT SUM(unidades) as total FROM ITEMPEDIDO 
        JOIN PEDIDOS ON ITEMPEDIDO.pedidoID = PEDIDOS.pedidoID 
        WHERE PEDIDOS.email = ? AND PEDIDOS.fechaPedido BETWEEN ? AND ?");
    $stmt->execute([$email, $inicioMes, $finMes]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row['total'] ? $row['total'] : 0;
}

function totalUnidadesCarrito($cestaID) {
    global $conn;
    $stmt = $conn->prepare("SELECT SUM(cantidad) as total FROM ITEMCESTA WHERE cestaID = ?");
    $stmt->execute([$cestaID]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row['total'] ? $row['total'] : 0;
}
?>