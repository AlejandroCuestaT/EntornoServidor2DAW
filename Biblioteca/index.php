<?php require_once 'conexion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Biblioteca</title>
    <style>
        body { font-family: sans-serif; margin: 20px; color: #333; }
        .flex-container { display: flex; gap: 40px; margin-bottom: 30px; }
        .form-section { border: 1px solid #ccc; padding: 20px; width: 50%; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #999; padding: 10px; text-align: left; }
        th { background: #eee; }
        .btn { padding: 8px 12px; cursor: pointer; }
        .hidden { display: none; }
    </style>
</head>
<body>

    <h1>Administración de Biblioteca</h1>

    <div class="flex-container">
        <div class="form-section">
            <h3>Nuevo Usuario</h3>
            <form action="procesar.php" method="POST">
                <input type="hidden" name="accion" value="nuevo_usuario">
                <p>DNI: <input type="text" name="dni" required></p>
                <p>Nombre: <input type="text" name="nombre" required></p>
                <p>Tipo: 
                    <select name="tipo_usuario">
                        <option value="Socio">Socio</option>
                        <option value="Ocasional">Ocasional</option>
                    </select>
                </p>
                <button type="submit" class="btn">Registrar Usuario</button>
            </form>
        </div>

        <div class="form-section">
            <h3>Nuevo Documento</h3>
            <form action="procesar.php" method="POST">
                <input type="hidden" name="accion" value="nuevo_documento">
                <p>Código: <input type="text" name="codigo" required></p>
                <p>Título: <input type="text" name="titulo" required></p>
                <p>Tipo: 
                    <select name="tipo_documento" onchange="document.getElementById('divAnio').style.display = (this.value === 'Libro') ? 'block' : 'none';">
                        <option value="Libro">Libro</option>
                        <option value="Revista">Revista</option>
                    </select>
                </p>
                <div id="divAnio">
                    <p>Año de Publicación: <input type="number" name="anio_publicacion" value="2024"></p>
                </div>
                <button type="submit" class="btn">Registrar Documento</button>
            </form>
        </div>
    </div>

    <h2>Listado de Usuarios</h2>
    <table>
        <thead>
            <tr>
                <th>DNI</th>
                <th>Nombre</th>
                <th>Tipo</th>
                <th>Préstamos</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $resU = $conn->query("SELECT * FROM usuarios");
            while ($u = $resU->fetch()) {
                echo "<tr>
                        <td>{$u['dni']}</td>
                        <td>{$u['nombre']}</td>
                        <td>{$u['tipo_usuario']}</td>
                        <td>{$u['num_prestamos']} / {$u['max_prestamos']}</td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>

    <h2>Inventario de Documentos</h2>
    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Título</th>
                <th>Tipo</th>
                <th>Año</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sqlD = "SELECT d.*, l.anio_publicacion FROM documentos d 
                     LEFT JOIN libros l ON d.codigo = l.codigo_documento";
            $resD = $conn->query($sqlD);
            while ($d = $resD->fetch()) {
                $anio = ($d['tipo_documento'] == 'Libro') ? $d['anio_publicacion'] : "N/A";
                $estado = ($d['dni_prestado_a']) ? "Prestado (DNI: ".$d['dni_prestado_a'].")" : "Disponible";
                echo "<tr>
                        <td>{$d['codigo']}</td>
                        <td>{$d['titulo']}</td>
                        <td>{$d['tipo_documento']}</td>
                        <td>{$anio}</td>
                        <td>{$estado}</td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>

</body>
</html>