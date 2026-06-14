<?php
    require_once 'conectar.php';


    function login($email, $pass){
        $conn = conectar();
        $email = trim($email);
        $pass = trim($pass);
        $stmt = $conn -> prepare("select email, pass from empleado");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);       
        foreach($result as $r){
            if($r['email']==$email && $r['pass']==$pass){
                $_SESSION['email'] = $r['email'];
                return true;
            }
        } 
        return false;
    }

    function recogeRol($email){
        $conn = conectar();
        $email = trim($email);

        $stmt = $conn -> prepare("select tipo_empleado from empleado where email = ?");
        $stmt->execute([$email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    function recogeProyectosEmpleado($email){
        $conn = conectar();
        $email = trim($email);

        $stmt = $conn -> prepare("select id_proyecto from trabajar where id_empleado in(select id_empleado from empleado where email = ?)");
        $stmt->execute([$email]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    function recogeProyectosNombre($id_proyecto){
        $conn = conectar();

        $stmt = $conn -> prepare("select nombre from proyectos where id_proyecto = ?");
        $stmt->execute([$id_proyecto]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    function recogeProyectos(){
        $conn = conectar();

        $stmt = $conn -> prepare("select * from proyectos where estado = ?");
        $stmt->execute(['ACTIVO']);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    function recogeGastos($id_proyecto){
        $conn = conectar();

        $stmt = $conn -> prepare("select importe from gastos where id_proyecto = ? and estado_aprobacion = ?");
        $stmt->execute([$id_proyecto, 'APROBADO']);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    function recogeHoras($id_proyecto){
        $conn = conectar();

        $stmt = $conn -> prepare("select num_horas from trabajar where id_proyecto = ?");
        $stmt->execute([$id_proyecto]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

?>