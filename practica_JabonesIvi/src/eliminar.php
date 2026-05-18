<?php
require '../func/bdlogic.php';
session_start();
$mensaje = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['id'])) {
        $mensaje = 'No se a indentificado ningun producto';
        header("Location: ../views/vistaAdmin.php?mess=$mensaje");
    }
    try {
        //code...
        borrarDatos('itempedido', ['productoID' => $_POST['id']]);
        borrarDatos('productos', ['productoID' => $_POST['id']]);
        header('Location: ../views/vistaAdmin.php');
    } catch (Exception $e) {
        //throw $th;
        echo $e->getMessage();
    }


}
?>