<?php
require '../func/sesiones.php';
require '../func/bdlogic.php';
require '../func/formulario.php';



$tipoVisitante;
if (!empty($_SESSION['usuarioLogin'])) {
    $tipoVisitante = $_SESSION['usuarioLogin']['email'];
} else {
    $tipoVisitante = "Visitante";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_SESSION['carrito'])) {

    } else {
        logout();
    }

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
    <header><?php echo $tipoVisitante ?></header>
    <form action="" method="post">
        <input type="submit" value="cerrarSesion">
    </form>
    <button><a href="../src/login.php">Iniciar Sesion</a></button>
    <div>
        <h2>Productos</h2>
        <?php vista('productos', 'ProductoID,nombre,descripción,peso,precio,imagen') ?>
        <h3>Comprar un producto</h3>
        <form action="../src/insertarCarrito.php" method="post">
            <input type="hidden" name="token_csrf" value="<?php echo (crearToken()) ?>">
            <?php
            if ($tipoVisitante == 'Visitante') {
                echo ('<p>Debes iniciar sesion para poder comprar</p>');
            } else {
                echo " <input type='number' name='producto'>
            <input type='submit' value='introducir'>";
            }
            ?>
        </form>
    </div>
    <div id="cesta">
        <?php
        if (!empty($_SESSION['usuarioLogin'])) {
            $datos = obtenerDatos('itemcesta', ['cestaID' => $_SESSION['usuarioLogin']['carritoLogin']['cestaID']], 'productoID');
            if ($datos->rowCount() == 0) {
                echo "<h3>Aun no hay productos en tu cesta</h3>";
            } else {
                mostrarTabla($datos->fetchAll());
                echo "<form action='../src/comprar.php' method='post'>
            <input type='submit' value='comprar'>
            </form>";
            }
        }
        ?>

    </div>

</body>

</html>