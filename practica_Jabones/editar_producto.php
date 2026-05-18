<?php
require_once 'funciones.php';
if(!isset($_SESSION['email']) || $_SESSION['tipo']!='admin') redirigir('jabonescarlatti.php');

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $peso = $_POST['peso'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    $imagenNombre = null;
    if(isset($_FILES['imagen']) && $_FILES['imagen']['error']==0) {
        $imagenNombre = time() . '_' . basename($_FILES['imagen']['name']);
        move_uploaded_file($_FILES['imagen']['tmp_name'], 'uploads/' . $imagenNombre);
    }
    if($_POST['accion'] == 'agregar') {
        $stmt = $conn->prepare("INSERT INTO PRODUCTOS (nombre, descripcion, peso, precio, stock, imagen) VALUES (?,?,?,?,?,?)");
        $stmt->execute([$nombre, $descripcion, $peso, $precio, $stock, $imagenNombre]);
    } elseif($_POST['accion'] == 'editar') {
        $id = $_POST['id'];
        if($imagenNombre) {
            $stmt = $conn->prepare("UPDATE PRODUCTOS SET nombre=?, descripcion=?, peso=?, precio=?, stock=?, imagen=? WHERE productoID=?");
            $stmt->execute([$nombre, $descripcion, $peso, $precio, $stock, $imagenNombre, $id]);
        } else {
            $stmt = $conn->prepare("UPDATE PRODUCTOS SET nombre=?, descripcion=?, peso=?, precio=?, stock=? WHERE productoID=?");
            $stmt->execute([$nombre, $descripcion, $peso, $precio, $stock, $id]);
        }
    }
    redirigir('admin.php?accion=productos');
}

$idEditar = isset($_GET['id']) ? $_GET['id'] : null;
$producto = null;
if($idEditar) {
    $stmt = $conn->prepare("SELECT * FROM PRODUCTOS WHERE productoID = ?");
    $stmt->execute([$idEditar]);
    $producto = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Editar producto - Admin</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: black; margin: 0; padding: 40px; display: flex; justify-content: center; }
        .card { background: white; padding: 25px; border-radius: 12px; width: 500px; box-shadow: 0 10px 25px rgba(0,0,0,0.5); }
        h3 { margin-top: 0; text-align: center; }
        input, textarea { width: 100%; padding: 8px; margin: 5px 0 15px; border-radius: 6px; border: 1px solid #ccc; }
        .btn { background: #007bff; color: white; border: none; padding: 10px 15px; border-radius: 6px; cursor: pointer; }
        .btn-danger { background: #6c757d; }
        .btn-danger:hover { background: #5a6268; }
    </style>
</head>
<body>
<div class="card">
    <h3><?php echo $idEditar ? 'Editar producto' : 'Nuevo producto'; ?></h3>
    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="accion" value="<?php echo $idEditar ? 'editar' : 'agregar'; ?>">
        <?php if($idEditar): ?>
            <input type="hidden" name="id" value="<?php echo $idEditar; ?>">
        <?php endif; ?>
        <label>Nombre:</label><input type="text" name="nombre" value="<?php echo $producto ? htmlspecialchars($producto['nombre']) : ''; ?>" required>
        <label>Descripción:</label><textarea name="descripcion"><?php echo $producto ? htmlspecialchars($producto['descripcion']) : ''; ?></textarea>
        <label>Peso (g):</label><input type="text" name="peso" value="<?php echo $producto ? $producto['peso'] : ''; ?>">
        <label>Precio (€):</label><input type="text" name="precio" value="<?php echo $producto ? $producto['precio'] : ''; ?>" required>
        <label>Stock:</label><input type="number" name="stock" value="<?php echo $producto ? $producto['stock'] : ''; ?>" required>
        <label>Imagen:</label><input type="file" name="imagen">
        <?php if($producto && $producto['imagen']): ?>
            <p><small>Imagen actual: <?php echo $producto['imagen']; ?></small></p>
        <?php endif; ?>
        <button type="submit" class="btn">Guardar</button>
        <a href="admin.php?accion=productos" class="btn btn-danger">Cancelar</a>
    </form>
</div>
</body>
</html>