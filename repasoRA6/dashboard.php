<?php
session_start();
include_once("conexion.php");

// RA6: Control de accesos perimetral
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

// Lógica rápida para AGREGAR un usuario (Create)
if (isset($_POST['agregar'])) {
    $u = trim($_POST['nuevo_user']);
    $p = trim($_POST['nuevo_pass']);
    $r = $_POST['nuevo_rol'];

    if (!empty($u) && !empty($p)) {
        try {
            $sqlIns = "INSERT INTO usuario (user, pass, rol) VALUES (:u, :p, :r)";
            $stmtIns = $conn->prepare($sqlIns);
            $stmtIns->execute([':u' => $u, ':p' => $p, ':r' => $r]);
            header("Location: dashboard.php");
            exit;
        } catch(PDOException $e) {
            die("Error al registrar el usuario.");
        }
    }
}

// Lógica rápida para ELIMINAR un usuario (Delete)
if (isset($_GET['eliminar'])) {
    $idEliminar = (int)$_GET['eliminar'];
    try {
        $sqlDel = "DELETE FROM usuario WHERE id = :id";
        $stmtDel = $conn->prepare($sqlDel);
        $stmtDel->execute([':id' => $idEliminar]);
        header("Location: dashboard.php");
        exit;
    } catch(PDOException $e) {
        die("Error al eliminar el registro.");
    }
}

// Obtener listado completo de usuarios (Read)
$usuarios = $conn->query("SELECT * FROM usuario")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <style>
        body { font-family: sans-serif; margin: 40px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; }
        .form-add { background: #eee; padding: 15px; margin-top: 20px; border-radius: 5px; }
    </style>
</head>
<body>

    <h1>Panel CRUD de Usuarios</h1>
    <p>Conectado como: <strong><?php echo htmlspecialchars($_SESSION['admin']); ?></strong> | <a href="logout.php" style="color:red;">Cerrar sesión</a></p>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $usr): ?>
                <tr>
                    <td><?php echo $usr['id']; ?></td>
                    <td><?php echo htmlspecialchars($usr['user']); ?></td>
                    <td><?php echo htmlspecialchars($usr['rol']); ?></td>
                    <td>
                        <a href="dashboard.php?eliminar=<?php echo $usr['id']; ?>" onclick="return confirm('¿Seguro?')" style="color:red;">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="form-add">
        <h3>Agregar Nuevo Usuario</h3>
        <form action="dashboard.php" method="POST">
            <input type="text" name="nuevo_user" required placeholder="Email o Username">
            <input type="password" name="nuevo_pass" required placeholder="Contraseña">
            <select name="nuevo_rol">
                <option value="cliente">Cliente</option>
                <option value="admin">Admin</option>
            </select>
            <button type="submit" name="agregar" style="width:auto; background:green; padding:5px 15px; color:white; border:none; cursor:pointer;">Guardar</button>
        </form>
    </div>

</body>
</html>