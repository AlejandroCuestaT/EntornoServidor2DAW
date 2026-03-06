<?php
    include 'funcionesE.php';
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    // Recomendable meter las consultas por try catch

    // INSERT con PDO version ortega
    try {
        $con = conectar($db, $usr, $pass);
        // tabla (nombre de las celdas en la base de datos) values (los valores del execute)

        $stmt = $con->prepare("INSERT INTO usuarios (nombreUsuario, nombre, apellidos, Contrasena) VALUES (:usuario, :nombre, :apellidos, :contrasena)");
        $stmt->execute([
            'usuario' => trim($usuario),
            'nombre'=> trim($nombre),
            'apellidos' => trim($apellido),
            'contrasena' => trim($contrasena)
        ]);
    } catch (PDOException $e) {
        echo "Ha ocurrido el siguiente error: " . $e->getMessage();
    }

    //INSERT CON PDO version victor
    function insertarSolicitud($DNI, $codigoCurso, $fecha,$admitido, $con){
        try{
            $consulta = "Insert into solicitudes values (?, ?, ?, ?)";
            $stmt = $con->prepare($consulta);
            return $stmt->execute([$DNI, $codigoCurso, $fecha,$admitido]);
        }catch(PDOException $e){
            echo "Ha ocurrido el siguiente error: " . $e->getMessage();
        }   
    }

    
    //SELECTS con PDO
    // Todos los registros
    $stmt = $con->query("SELECT * FROM usuarios");
    $usuarios = $stmt->fetchAll(); // array de arrays

    // Recorrer resultados
    foreach ($stmt as $fila) {
        echo $fila['nombre'];
    }

    // Con parametros (PREPARED STATEMENT)
    $stmt = $con->prepare("SELECT * FROM usuarios WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $usuario = $stmt->fetch(); // un registro

    // Imprimir contenido
    echo $usuario['nombre'];

    

    // UPDATE CON PDO V1
    function update1($nombre, $id, $con){
        try{//UPDATE CON PDO V2
    function update2($nombre, $id, $con){
        try{
            $consulta = "UPDATE usuarios SET nombre = ? WHERE id = ?";
            $stmt = $con->prepare($consulta);
            return $stmt->execute([$nombre, $id]);
        }catch(PDOException $e){
            echo "Ha ocurrido el siguiente error: " . $e->getMessage();
        }   
    }
            $stmt = $con->prepare(
                "UPDATE usuarios SET nombre = :nombre WHERE id = :id"
            );
            $stmt->execute(['nombre' => $nombre, 'id' => $id]);
            echo $stmt->rowCount() . " filas afectadas";
        }catch(PDOException $e){
                echo "Ha ocurrido el siguiente error: " . $e->getMessage();
            }   
        }
    
    //UPDATE CON PDO V2
    function update2($nombre, $id, $con){
        try{
            $consulta = "UPDATE usuarios SET nombre = ? WHERE id = ?";
            $stmt = $con->prepare($consulta);
            return $stmt->execute([$nombre, $id]);
        }catch(PDOException $e){
            echo "Ha ocurrido el siguiente error: " . $e->getMessage();
        }   
    }
    

    // DELETE CON PDO V1
    function delete1($id, $con){
        try{
            $stmt = $con->prepare("DELETE FROM usuarios WHERE id = :id");
            return $stmt->execute(['id' => $id]);
        }catch(PDOException $e){
            echo "Ha ocurrido el siguiente error: " . $e->getMessage();
        }
    }


    //DELETE CON PDO V2
    function delete2($id, $con){
        try{
            $consulta = "DELETE FROM usuarios WHERE id = ?";
            $stmt = $con->prepare($consulta);
            return $stmt->execute([$id]);
        }catch(PDOException $e){
            echo "Ha ocurrido el siguiente error: " . $e->getMessage();
        }   
    }
    
        


?>