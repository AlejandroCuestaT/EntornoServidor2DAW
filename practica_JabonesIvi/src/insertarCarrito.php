<?php
require '../func/sesiones.php';
require '../func/bdlogic.php';
require '../func/formulario.php';

validarLogueado();
if (!$_SESSION['usuarioLogin']['carritoLogin']) {
    $cesta = obtenerDatos('cesta', ['email' => $_SESSION['usuarioLogin']['email']])->fetchAll()[0];
    // var_dump(obtenerDatos('cesta', ['email' => $_SESSION['usuarioLogin']['email']])->fetchAll()[0]);
    $_SESSION['usuarioLogin']['carritoLogin'] = $cesta;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cantidadProducto = obtenerDatos('productos', ['productoID' => $_POST['producto']], 'cantidad');
    if ($cantidadProducto && $cantidadProducto->rowCount() == 1) {
        // echo $cantidadProducto->fetchAll()[0]['cantidad'];
        if ($cantidadProducto->fetchAll()[0]['cantidad'] > 0) {
            $cestaCompra = array(
                'cantidad' => 1,
                'cestaID' => $_SESSION['usuarioLogin']['carritoLogin']['cestaID'],
                'productoID' => $_POST['producto'],
            );
            // var_dump($cestaCompra);
            insertarDatos('itemCesta', $cestaCompra);
            header("Location: ../views/vistaUsuario.php");
            exit();
        }
        header("Location: ../views/vistaUsuario.php");
        exit();
    }
}