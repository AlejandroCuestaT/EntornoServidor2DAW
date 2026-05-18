<?php
require '../func/bdlogic.php';
require '../func/formulario.php';
require '../func/sesiones.php';


function vistaProductos($datosVisibles)
{
    $productos = obtenerDatos('productos', [], $datosVisibles);
    mostrarTabla($productos->fetchAll());
}
function vistaItemPedido($datosVisibles)
{
    $itemProductos = obtenerDatos('itempedido', [], $datosVisibles);
    mostrarTabla($itemProductos->fetchAll());
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    echo 'post';
    validar_token();
    logout();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <header>

        <h2>
            <?php echo isset($_SESSION['usuarioLogin']['email']) ? $_SESSION['usuarioLogin']['email'] : 'Sesion no iniciada' ?>
        </h2>
        <form action="" method="post">
            <input type="hidden" name="token_csrf" value="<?php echo (crearToken()) ?>">
            <input type="submit" value="CerrarSesion">
        </form>

    </header>
    <h2>Producto</h2>
    <div class="adminProductos">
        <?php vistaProductos('productoID , nombre , precio, peso') ?>
        <h2>Eliminar producto</h2>
        <form action="../src/eliminar.php" method="post">
            <input type="text" name="id">
            <input type="submit" value="Eliminar">
            <input type="hidden" name="token_csrf" value="<?php echo (crearToken()) ?>">
        </form>
        <h2>Insertar Producto</h2>
        <form action="../src/insertar.php" method="post">
            <input type="hidden" name="tabla" value="productos">
            <input type="hidden" name="token_csrf" value="<?php echo (crearToken()) ?>">
            <label>descripcion</label>
            <input name='descripción' type="text">
            <label>imagen</label>
            <input name='imagen' type="text">
            <label>nombre</label>
            <input name='nombre' type="text">
            <label>peso</label>
            <input name='peso' type="number">
            <label>precio</label>
            <input name='precio' type="number">
            <input type="submit" value="Enviar">
        </form>
    </div>
    <hr>
    <div id="adminProductos">
        <h2>Item Pedido</h2>
        <?php vistaItemPedido('itemPedidoID, pedidoID, productoID, unidades') ?>
        <h2>Eliminar</h2>
        <form action="../src/eliminar.php">
            <label>id</label>
            <input type="hidden" name="token_csrf" value="<?php echo crearToken() ?>">
            <input type="text" name="id">
            <input type="submit" value="Enviar">
        </form>
        <h2>Insertar</h2>
        <form action="../src/insertar.php" method="post">
            <input type="hidden" name="tabla" value="itempedido">
            <input type="hidden" name="token_csrf" value="<?php echo (crearToken()) ?>">
            <label>Pedido</label>
            <select name="pedidoID">
                <?php opciones('pedidos', 'pedidoID') ?>
            </select>
            <label>Producto</label>
            <select name="productoID">
                <?php opciones('productos', 'productoID') ?>

            </select>
            <label>unidades</label>
            <input type="number" name="unidades">
            <input type="submit" value="Enviar">
        </form>
    </div>

</body>

</html>