<?php
    include 'funciones.php';
    session_start();

    if(!isset($_SESSION['email'])){
        header('Location: gestionaProyectos.php');
    }
    
    $email = $_SESSION['email'];
    $proyectos = recogeProyectos();
    
    

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <TABLE border=1>
        <tr>
            <th>Nombre</th>
            <th>Cliente</th>
            <th>Descripcion</th>
            <th>Fecha Inicio</th>
            <th>Fecha Fin</th>
            <th>Presupuesto</th>
            <th>Gastos Totales</th>
            <th>Tiene Sobrecoste</th>
        </tr>
        <?php
            foreach($proyectos as $p){
                $gastosTotales = 0;
                echo '<tr>';
                echo '<td>' . $p['nombre'] . '</td>';
                echo '<td>' . $p['cliente'] . '</td>';
                echo '<td>' . $p['descripcion'] . '</td>';
                echo '<td>' . $p['fecha_inicio'] . '</td>';
                echo '<td>' . $p['fecha_fin'] . '</td>';
                echo '<td>' . $p['presupuesto'] . '</td>';
                
                $arrayGastos = recogeGastos($p['id_proyecto']);
                foreach($arrayGastos as $ag){
                    $gastosTotales += $ag['importe'];
                }
                
                echo '<td>' . $gastosTotales . '</td>';
                if($gastosTotales > $p['presupuesto']){
                    echo '<td>SI</td>';
                }else{
                    echo '<td>NO</td>';
                }
                echo '</tr>';
            }
        ?>
    </TABLE>
</body>
</html>