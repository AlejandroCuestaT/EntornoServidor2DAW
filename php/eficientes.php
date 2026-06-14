<?php
    include 'funciones.php';
    session_start();

    if(!isset($_SESSION['email'])){
        header('Location: gestionaProyectos.php');
    }
    
    $email = $_SESSION['email'];
    $proyectos = recogeProyectos();
    
    $maxEficiencia = 0;

    foreach ($proyectos as $key => $p) {
        $horasTotales = 0;
        $arrayHoras = recogeHoras($p['id_proyecto']);
        
        foreach ($arrayHoras as $ah) {
            $horasTotales += $ah['num_horas'];
        }

        $proyectos[$key]['horas_calculadas'] = $horasTotales;

        if ($p['presupuesto'] > 0) {
            $eficiencia = $horasTotales / $p['presupuesto'];
        } else {
            $eficiencia = 0;
        }

        $proyectos[$key]['eficiencia'] = $eficiencia;

        if ($eficiencia > $maxEficiencia) {
            $maxEficiencia = $eficiencia;
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
    <TABLE border=1>
        <tr>
            <th>Nombre</th>
            <th>Cliente</th>
            <th>Descripcion</th>
            <th>Fecha Inicio</th>
            <th>Fecha Fin</th>
            <th>Presupuesto</th>
            <th>Horas Totales</th>
            <th>Es el mas Eficiente</th>
        </tr>
        <?php
            foreach($proyectos as $p){
                $horasTotales = 0;
                echo '<tr>';
                echo '<td>' . $p['nombre'] . '</td>';
                echo '<td>' . $p['cliente'] . '</td>';
                echo '<td>' . $p['descripcion'] . '</td>';
                echo '<td>' . $p['fecha_inicio'] . '</td>';
                echo '<td>' . $p['fecha_fin'] . '</td>';
                echo '<td>' . $p['presupuesto'] . '</td>';
                
                
                echo '<td>' . $p['horas_calculadas'] . '</td>';

                if ($p['eficiencia'] == $maxEficiencia && $maxEficiencia > 0) {
                    echo '<td style="background-color: #d4edda; color: #155724; font-weight: bold;">SÍ</td>';
                } else {
                    echo '<td>No</td>';
                }
                
                echo '</tr>';
            }
        ?>
    </TABLE>
</body>
</html>