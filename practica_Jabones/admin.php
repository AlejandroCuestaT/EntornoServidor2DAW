<?php
require_once 'funciones.php';
if(!isset($_SESSION['email']) || $_SESSION['tipo']!='admin') redirigir('jabonescarlatti.php');

$accion = isset($_GET['accion']) ? $_GET['accion'] : 'productos';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Panel Admin - Jabones Scarlatti</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: black; margin: 0; padding: 30px; }
        .admin-container { max-width: 1200px; margin: 0 auto; background: white; border-radius: 12px; padding: 25px; box-shadow: 0 10px 25px rgba(0,0,0,0.5); }
        h2, h3 { color: #333; }
        .nav { background: #f2f2f2; padding: 12px; border-radius: 8px; margin-bottom: 20px; }
        .nav a { margin-right: 20px; color: #007bff; text-decoration: none; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin: 15px 0; }
        th, td { padding: 10px; border-bottom: 1px solid #ddd; text-align: left; }
        th { background: #e9ecef; }
        .btn { background: #007bff; color: white; padding: 6px 12px; border-radius: 5px; text-decoration: none; display: inline-block; margin: 2px; }
        .btn-danger { background: #dc3545; }
        .btn-success { background: #28a745; }
        form input, form textarea { width: 100%; padding: 8px; margin: 5px 0 10px; border-radius: 6px; border: 1px solid #ccc; }
        .form-group { margin-bottom: 15px; }
    </style>
</head>
<body>
<div class="admin-container">
    <h2>Panel de Administración</h2>
    <div class="nav">
        <a href="?accion=productos">Productos</a>
        <a href="?accion=pedidos">Pedidos</a>
        <a href="jabonescarlatti.php">Volver a tienda</a>
        <a href="logout.php">Cerrar sesión</a>
    </div>

    <?php if($accion == 'productos'): ?>
        <h3>Gestión de Productos</h3>
        <a href="?accion=agregar_producto" class="btn btn-success">+ Nuevo producto</a>
        <table>
            <tr><th>ID</th><th>Nombre</th><th>Precio</th><th>Stock</th><th>Imagen</th><th>Acciones</th></tr>
            <?php
            $productos = $conn->query("SELECT * FROM PRODUCTOS")->fetchAll(PDO::FETCH_ASSOC);
            foreach($productos as $prod):
            ?>
            <tr>
                <td><?php echo $prod['productoID']; ?></td>
                <td><?php echo htmlspecialchars($prod['nombre']); ?></td>
                <td><?php echo $prod['precio']; ?> €</td>
                <td><?php echo $prod['stock']; ?></td>
                <td><?php echo $prod['imagen']; ?></td>
                <td>
                    <a href="editar_producto.php?id=<?php echo $prod['productoID']; ?>" class="btn">Editar</a>
                    <a href="eliminar_producto.php?id=<?php echo $prod['productoID']; ?>" class="btn btn-danger" onclick="return confirm('¿Eliminar este producto?')">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>

    <?php elseif($accion == 'agregar_producto'): ?>
        <h3>Agregar nuevo producto</h3>
        <form method="POST" action="editar_producto.php" enctype="multipart/form-data">
            <input type="hidden" name="accion" value="agregar">
            <div class="form-group"><label>Nombre:</label><input type="text" name="nombre" required></div>
            <div class="form-group"><label>Descripción:</label><textarea name="descripcion" rows="3"></textarea></div>
            <div class="form-group"><label>Peso (g):</label><input type="text" name="peso"></div>
            <div class="form-group"><label>Precio (€):</label><input type="text" name="precio" required></div>
            <div class="form-group"><label>Stock:</label><input type="number" name="stock" required></div>
            <div class="form-group"><label>Imagen:</label><input type="file" name="imagen"></div>
            <button type="submit" class="btn btn-success">Guardar producto</button>
            <a href="admin.php?accion=productos" class="btn">Cancelar</a>
        </form>

    <?php elseif($accion == 'pedidos'): ?>
        <h3>Pedidos realizados</h3>
        <table>
            <tr><th>ID</th><th>Cliente</th><th>Fecha</th><th>Total</th><th>Entregado</th><th>Fecha entrega estimada</th><th>Acción</th></tr>
            <?php
            $pedidos = $conn->query("SELECT p.*, c.nombre FROM PEDIDOS p JOIN CLIENTES c ON p.email = c.email ORDER BY p.fechaPedido DESC")->fetchAll(PDO::FETCH_ASSOC);
            foreach($pedidos as $ped):
            ?>
            <tr>
                <td><?php echo $ped['pedidoID']; ?></td>
                <td><?php echo htmlspecialchars($ped['nombre']); ?></td>
                <td><?php echo $ped['fechaPedido']; ?></td>
                <td><?php echo $ped['totalPedido']; ?> €</td>
                <td><?php echo $ped['entregado'] ? 'Sí' : 'No'; ?></td>
                <td><?php echo $ped['fechaEntregaEstimada']; ?></td>
                <td>
                    <?php if(!$ped['entregado']): ?>
                        <a href="?accion=marcar_entregado&id=<?php echo $ped['pedidoID']; ?>" class="btn btn-success" onclick="return confirm('¿Marcar como entregado?')">Marcar entregado</a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php if(isset($_GET['marcar_entregado'])): 
            $idPed = $_GET['id'];
            $upd = $conn->prepare("UPDATE PEDIDOS SET entregado=1 WHERE pedidoID=?");
            $upd->execute([$idPed]);
            echo "<p style='color:green;'>Pedido marcado como entregado.</p>";
        endif; ?>
    <?php endif; ?>
</div>
</body>
</html>