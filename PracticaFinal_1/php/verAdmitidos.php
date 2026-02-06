<?php
session_start();
include_once("conexion.php");

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

$idCurso = $_GET['id'];

try {
    // 1. Obtener datos del curso (nombre y número de plazas)
    $stmtCurso = $conn->prepare("SELECT nombre, numeroplazas FROM cursos WHERE codigo = :id");
    $stmtCurso->execute([':id' => $idCurso]);
    $curso = $stmtCurso->fetch(PDO::FETCH_ASSOC);

    if (!$curso) {
        die("Curso no encontrado.");
    }

    // 2. Tu consulta lógica: 
    // Ordena primero por quienes tienen 0 cursos admitidos, luego 1, etc.
    // Y dentro de ese grupo, por puntos de mayor a menor.
    $sql = "SELECT s.dni, s.nombre, s.apellidos, s.puntos, 
            (SELECT COUNT(*) 
             FROM solicitudes solicitud 
             WHERE solicitud.dni = s.dni 
             AND solicitud.admitido = 1 AND solicitud.codigocurso != :codigo) as admitidosPrev
            FROM solicitantes s 
            WHERE s.dni IN (SELECT dni FROM solicitudes WHERE codigocurso = :codigo) 
            ORDER BY admitidosPrev ASC, s.puntos DESC 
            LIMIT :limite";

    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':codigo', $idCurso, PDO::PARAM_INT);
    $stmt->bindValue(':limite', $curso['numeroplazas'], PDO::PARAM_INT);
    $stmt->execute();
    $listaAdmitidos = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Error en la base de datos: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Selección</title>
    <style>
        body { font-family: sans-serif; margin: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px; border: 1px solid black; text-align: left; }
        th { background-color: #f2f2f2; }
        .info { margin-bottom: 15px; border: 1px solid #ccc; padding: 10px; }
    </style>
</head>
<body>

    <h1>Selección de Candidatos</h1>
    
    <div class="info">
        <strong>Curso:</strong> <?php echo htmlspecialchars($curso['nombre']); ?><br>
        <strong>Plazas disponibles:</strong> <?php echo $curso['numeroplazas']; ?>
    </div>

    <a href="admin.php" style="display:inline-block; margin-bottom:10px;">← Volver al Panel</a>

    <table>
        <thead>
            <tr>
                <th>DNI</th>
                <th>Apellidos, Nombre</th>
                <th>Puntos</th>
                <th>Otros cursos admitido</th>
                <th>Estado Sugerido</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($listaAdmitidos) > 0): ?>
                <?php foreach ($listaAdmitidos as $row): ?>
                <tr>
                    <td><?php echo $row['dni']; ?></td>
                    <td><?php echo htmlspecialchars($row['apellidos'] . ", " . $row['nombre']); ?></td>
                    <td><?php echo $row['puntos']; ?></td>
                    <td><?php echo $row['admitidosPrev']; ?></td>
                    <td><span style="color: blue; font-weight: bold;">Candidato Admitido</span></td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No hay solicitudes para este curso.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <p><small>* Esta lista muestra a los candidatos que entran en el cupo según baremación y plazas.</small></p>

    <form action="confirmarAdmitidos.php" method="POST">
    <input type="hidden" name="idCurso" value="<?php echo $idCurso; ?>">
    <?php foreach ($listaAdmitidos as $row): ?>
        <input type="hidden" name="dnis[]" value="<?php echo $row['dni']; ?>">
    <?php endforeach; ?>
    
    <br>
    <button type="submit" class="btn" style="background-color: #ddd; padding: 10px;">
        Confirmar y Notificar Admitidos
    </button>
</form>

</body>
</html>