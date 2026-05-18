<?php
require_once 'funciones.php';
if(!isset($_SESSION['email']) || $_SESSION['tipo']!='admin') redirigir('jabonescarlatti.php');

$id = $_GET['id'];
$stmt = $conn->prepare("DELETE FROM PRODUCTOS WHERE productoID = ?");
$stmt->execute([$id]);
redirigir('admin.php?accion=productos');
?>