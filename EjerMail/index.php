<?php
$conexion = mysqli_connect("localhost", "alex", "1234", "ejercicio_mail");

$query = "SELECT id, nombre, apellidos FROM clientes";
$res = mysqli_query($conexion, $query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Envío de Postales</title>
    
</head>
<body>

    <div class="form-container">
        <table class="tabla-imagenes">
            <th>
                <td><img src="IMG/puebloBlanco.jpg" width="60" alt="Pueblo"><br>Pueblo blanco</td>
                <td><img src="IMG/papaNoel.jpg" width="60" alt="Papa Noel"><br>Papa Noel</td>
                <td><img src="IMG/arbolIluminado.jpg" width="60" alt="Arbol"><br>Arbol iluminado</td>
            </th>
        </table>

        <form action="enviar.php" method="POST">
            
            <div class="campo">
                <label>Destinatario:</label>
                <select name="idCliente">
                    <?php while($fila = mysqli_fetch_assoc($res)): ?>
                        <option value="<?php echo $fila['id']; ?>">
                            <?php echo $fila['nombre'] . " " . $fila['apellidos']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="campo">
                <label>Mensaje:</label>
                <input type="text" name="mensaje" size="40">
            </div>

            <div class="campo">
                <label>Tema:</label>
                <input type="text" name="tema" size="40">
            </div>

            <div class="campo">
                <label></label> <select name="foto">
                    <option value="">-- Sin foto --</option>
                    <option value="IMG/puebloBlanco.jpg">puebloBlanco.jpg</option>
                    <option value="IMG/papaNoel.jpg">papaNoel.jpg</option>
                    <option value="IMG/arbolIluminado.jpg">arbolIluminado.jpg</option>
                </select>
            </div>

            <div class="campo">
                <label></label>
                <input type="submit" value="Enviar">
            </div>

        </form>
    </div>

</body>
</html>