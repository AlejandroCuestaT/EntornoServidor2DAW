<?php
session_start();
include_once("conexion.php");

// Control de seguridad básico
if (!isset($_SESSION['cliente'])) {
    die("No tienes sesión de cliente iniciada.");
}

if (isset($_GET['id'])) {
    $productoID = $_GET['id'];
    $emailCliente = $_SESSION['cliente']; 
    
    $mesActual = date('m');
    $anioActual = date('Y');

    // 1. CONTROL DE RESTRICCIÓN (Contar unidades compradas este mes)
    $sqlContar = "SELECT SUM(ip.unidades) as total_mes 
                  FROM itempedido ip 
                  JOIN pedidos p ON ip.pedidoID = p.pedidoID 
                  WHERE p.email = :email 
                  AND MONTH(p.FechaPedido) = :mes 
                  AND YEAR(p.FechaPedido) = :anio";
    
    $stmtContar = $conn->prepare($sqlContar);
    $stmtContar->execute([
        ':email' => $emailCliente,
        ':mes'   => $mesActual,
        ':anio'  => $anioActual
    ]);
    
    $resultadoComp = $stmtContar->fetch(PDO::FETCH_ASSOC);
    $unidadesCompradas = $resultadoComp['total_mes'] ? (int)$resultadoComp['total_mes'] : 0;

    if ($unidadesCompradas >= 4) {
        echo "<script>alert('Límite excedido: Máximo 4 artículos al mes.'); window.location.href='tienda.php';</script>";
        exit;
    }

    // 2. BUSCAR O CREAR CESTA ABIERTA
    $sqlCesta = "SELECT cestaID FROM cesta WHERE email = :email LIMIT 1";
    $stmtCesta = $conn->prepare($sqlCesta);
    $stmtCesta->execute([':email' => $emailCliente]);
    $cesta = $stmtCesta->fetch(PDO::FETCH_ASSOC);

    if ($cesta) {
        $cestaID = $cesta['cestaID'];
    } else {
        // Si falla aquí, es porque tu $_SESSION['cliente'] no existe en la tabla 'clientes'
        $sqlNuevaCesta = "INSERT INTO cesta (email, fechaCreacion) VALUES (:email, CURDATE())";
        $stmtNuevaCesta = $conn->prepare($sqlNuevaCesta);
        $stmtNuevaCesta->execute([':email' => $emailCliente]);
        $cestaID = $conn->lastInsertId(); 
    }

    // 3. REVISAR O AGREGAR ITEM EN LA CESTA
    $sqlItem = "SELECT itemcestaID, cantidad FROM itemcesta WHERE cestaID = :cestaID AND productoID = :productoID";
    $stmtItem = $conn->prepare($sqlItem);
    $stmtItem->execute([':cestaID' => $cestaID, ':productoID' => $productoID]);
    $itemCesta = $stmtItem->fetch(PDO::FETCH_ASSOC);

    if ($itemCesta) {
        $nuevaCantidad = $itemCesta['cantidad'] + 1;
        $sqlUpdate = "UPDATE itemcesta SET cantidad = :cantidad WHERE itemcestaID = :itemID";
        $stmtUpdate = $conn->prepare($sqlUpdate);
        $stmtUpdate->execute([':cantidad' => $nuevaCantidad, ':itemID' => $itemCesta['itemcestaID']]);
    } else {
        $sqlInsertItem = "INSERT INTO itemcesta (cestaID, productoID, cantidad) VALUES (:cestaID, :productoID, 1)";
        $stmtInsertItem = $conn->prepare($sqlInsertItem);
        $stmtInsertItem->execute([':cestaID' => $cestaID, ':productoID' => $productoID]);
    }

    // Volvemos a la tienda
    header("Location: tienda.php");
    exit;

} else {
    header("Location: tienda.php");
    exit;
}
?>