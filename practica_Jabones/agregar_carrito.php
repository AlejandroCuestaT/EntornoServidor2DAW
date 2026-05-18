<?php
require_once 'funciones.php';
if(!isset($_SESSION['email']) || $_SESSION['tipo']!='cliente') redirigir('jabonescarlatti.php');

$email = $_SESSION['email'];
$productoID = $_POST['productoID'];
$cantidad = (int)$_POST['cantidad'];

$cestaID = obtenerCarritoActivo($email);
$unidadesCarrito = totalUnidadesCarrito($cestaID);
$unidadesMes = unidadesPedidasEsteMes($email);

if($unidadesCarrito + $cantidad > 2 || $unidadesMes + $unidadesCarrito + $cantidad > 2) {
    $_SESSION['error'] = "Solo se permiten 2 unidades por cliente al mes y máximo 2 por compra.";
    redirigir('jabonescarlatti.php');
}

$stmtCheck = $conn->prepare("SELECT cantidad FROM ITEMCESTA WHERE cestaID = ? AND productoID = ?");
$stmtCheck->execute([$cestaID, $productoID]);
$existe = $stmtCheck->fetch(PDO::FETCH_ASSOC);

if($existe) {
    $nuevaCant = $existe['cantidad'] + $cantidad;
    if($nuevaCant > 2) {
        $_SESSION['error'] = "No puedes tener más de 2 unidades de un mismo producto en el carrito.";
        redirigir('jabonescarlatti.php');
    }
    $stmtUp = $conn->prepare("UPDATE ITEMCESTA SET cantidad = ? WHERE cestaID = ? AND productoID = ?");
    $stmtUp->execute([$nuevaCant, $cestaID, $productoID]);
} else {
    $stmtIns = $conn->prepare("INSERT INTO ITEMCESTA (cestaID, productoID, cantidad) VALUES (?,?,?)");
    $stmtIns->execute([$cestaID, $productoID, $cantidad]);
}
redirigir('carrito.php');
?>