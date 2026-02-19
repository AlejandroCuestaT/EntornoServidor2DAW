<?php
    session_start();
    include 'funcionesE.php';
    include 'enviarMail.php';
    
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $correo = $_POST['correo'];
        $asunto = $_POST['asunto'];
        $cuerpo = $_POST['cuerpo'];
        $attach = $_POST['attach'];
        if(enviarEmail('victor','12345678','victor@informaticascarlatti.es',$correo, $asunto, $cuerpo, '')){
            echo "El correo ha sido enviado con éxito";
        }   
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Document</title>
</head>
<body>
    <?php
        $conn = conectar('cursoscp','victor','1234');
        $paginar = paginacion($conn,'solicitudes', 3);
        $resultados = $paginar['datos'];
        $totalPaginas  = $paginar['totalPaginas'];
        $paginaActual = $paginar['paginaActual'];
        echo "<table>";
        echo "
                <thead>
                    <tr>
                        <th>DNI</th>
                        <th>codigocurso</th>
                        <th>fechasolicitud</th>
                        <th>admitido</th>
                    </tr>
                </thead>
            </tr>";    
        foreach($resultados as $r){
            echo "<tr>
                    <td>{$r['dni']}</td>
                    <td>{$r['codigo']}</td>
                    <td>{$r['fechasolicitud']}</td>
                    <td>{$r['admitido']}</td>
                    <td>
                        <form action='eliminar.php' method='post'>
                            <input type='hidden' name='dni' value='". $r['dni']."'>
                            <input type='submit' value='Eliminar'>
                        </form>
                    </td>
                  </tr>";
        }          
        echo "</table>";
        echo "<div id='botonesPag'>";
            if($paginaActual>1){
                echo "<button class='botonPagina'><a href='?pagina=".($paginaActual-1)."' style='text-decoration: none; color: white;'>Anterior</a></button>";
            }
            for ($i=1; $i<=$totalPaginas; $i++){
                echo "<button class='botonPagina''><a href='?pagina=$i' style='text-decoration: none; color: white;'>$i</a></button>";
            }
            if($paginaActual<$totalPaginas){
                echo "<button class='botonPagina'><a href='?pagina=".($paginaActual+1)."' style='text-decoration: none;  color: white;'>Siguiente</a></button>";
            }
        echo "</div>";
    ?>
    <div id="formulario">
        <h3>Insertar datos</h3>;
        <form action="insertarActualizar.php" method="post">
            <div class="form-group">
                <label>DNI</label><br>
                <input type="text" name="dni"><br>
            </div>
            <div class="form-group">
                <label>CodigoCurso</label><br>
                <input type="text" name="codigocurso">
            </div>
            <div class="form-group">
                <label>Fecha solicitud</label><br>
                <input type="date" name="fechasolicitud">
            </div>
            <div class="form-group">
                <label>Admitido</label><br>
                <input type="text" name="admitido">
            </div>
            <?php
                if(isset($errores['insertar'])){
                    echo $errores['insertar'];
                }
            ?>
        <input type="submit" value="Insertar datos" id="insertar">
    </form>
    </div>
    <div id="formulario">
        <h3>Actualizar DNI</h3>
        <form action="insertarActualizar.php" method="post">
            <div class="form-group">
                <label for="">DNI Antiguo</label>
                <input type="text" name="dniAntiguo"><br>
            </div>
            <div class="form-group">
                <label for="">Dni nuevo</label>
                <input type="text" name="dniNuevo"><br>               
            </div>
            <input type="submit" value="Actualizar DNI" id="insertar">
        </form>
    </div>
    <div id="formulario">
        <h3>Enviar correos</h3>;
        <form action="inicio.php" method="post">
            <div class="form-group">
                <label>Correo</label><br>
                <input type="email" name="correo"><br>
            </div>
            <div class="form-group">
                <label>Asunto</label><br>
                <input type="text" name="asunto">
            </div>
            <div class="form-group">
                <label>Cuerpo</label><br>
                <input type="text" name="cuerpo">
            </div>
            <div class="form-group">
                <label>Attach</label><br>
                <input type="text" name="attach">
            </div>
            <?php
                if(isset($errores['insertar'])){
                    echo $errores['insertar'];
                }
            ?>
        <input type="submit" value="Insertar datos" id="insertar">
    </form>
</body>
</html>