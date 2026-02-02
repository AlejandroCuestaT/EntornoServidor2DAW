<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Envío de Postales</title>
    <style>
        body { font-family: sans-serif; text-align: center; }
        .galeria img { width: 100px; height: 100px; margin: 5px; border: 1px solid #ccc; }
        form { margin-top: 20px; display: inline-block; text-align: left; }
        label { display: block; margin-top: 10px; font-weight: bold; }
        input, select, textarea { width: 300px; padding: 5px; }
    </style>
</head>
<body>

    <div class="galeria">
        <h3>Imágenes Disponibles</h3>
        <img src="img/navidad1.jpg" alt="Navidad 1">
        <img src="img/navidad2.jpg" alt="Navidad 2">
        <img src="img/arbol.jpg" alt="Árbol">
    </div>

    <h1>ENVIO DE POSTALES</h1>

    <form action="enviar.php" method="POST">
        
        <label>Destinatario:</label>
        <select name="destinatario_email" required>
            <?php
            // Paso 1: Conexión básica a la BD
            $conexion = mysqli_connect("localhost", "root", "", "ejercicio_mail");

            // Paso 2: Pedimos nombre y email de los clientes
            $sql = "SELECT nombre, apellidos, email FROM clientes";
            $resultado = mysqli_query($conexion, $sql);

            // Paso 3: Rellenamos el desplegable con un bucle
            while ($fila = mysqli_fetch_assoc($resultado)) {
                // En el 'value' ponemos el email (lo que necesitamos para enviar)
                // En el texto visible ponemos Nombre y Apellidos (para que el usuario sepa quién es)
                echo "<option value='" . $fila['email'] . "'>" . $fila['nombre'] . " " . $fila['apellidos'] . "</option>";
            }
            ?>
        </select>

        <label>Tema (Asunto):</label>
        <select name="tema">
            <option value="Felicitación de Navidad">Navidad</option>
            <option value="Ofertas de la Empresa">Novedades</option>
            <option value="Feliz Cumpleaños">Cumpleaños</option>
        </select>

        <label>Mensaje:</label>
        <textarea name="mensaje" placeholder="Escribe tu felicitación aquí..."></textarea>

        <label>Imagen a incluir:</label>
        <select name="imagen">
            <option value="">-- Sin imagen --</option> <option value="navidad1.jpg">Navidad 1</option>
            <option value="navidad2.jpg">Navidad 2</option>
            <option value="arbol.jpg">Árbol Iluminado</option>
        </select>

        <br><br>
        <input type="submit" value="Enviar Correo">
    </form>

</body>
</html>