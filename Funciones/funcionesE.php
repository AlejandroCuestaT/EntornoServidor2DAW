<?php
    
    //Función para conectar con base de datos
    function conectar($db, $usr, $pass){
        $con = new PDO("mysql:host=localhost;dbname=$db;charset=utf8","$usr","$pass");
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $con;
    }

    //Crear cookies
    function crearCookies($nombre, $valor, $expiracion, $ruta){
        setcookie($nombre, $valor, $expiracion, $ruta);
    }

    //Leer cookies
    function leerCookie($nombreCookie){
        if(isset($_COOKIE["{$nombreCookie}"])){
            return "El valor de la cookie es: ". $_COOKIE["{$nombreCookie}"];
        }else{
            return "No hay ningún valor guardado";
        }
    }

    //Eliminar cookies
    function eliminarCookies($nombreCookie){
        setcookie($nombreCookie, "", time() - 3600, "/");
    }

    //Funcion login con PDO y sesiones      //Depende de la base de datos
    function login ($usuario, $password, $conexion){
        $usuario = trim($usuario);
        $password = trim($password);
        $stmt = $conexion -> prepare("select usuario, contraseña from admin");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);       
        foreach($result as $r){
            if($r['usuario']==$usuario && $r['contraseña']==$password){
                $_SESSION['usuario'] = $r['usuario'];
                return true;
            }
        } 
        return false;
    }

    //Función para verificar si el usuario está autenticado
    function autenticado(){
        session_start();
        if(!isset($_SESSION['usuario'])){
            header("Location: login.php");
            exit();
        }
    }

    //Función para cerrar sesión
    function logout(){
       session_start();
        session_unset();  
        session_destroy();  
        setcookie("sesion_expira", "", time() - 3600, "/");
        header("Location: login.php");
        exit();
    }

    function paginacion($conexion, $tabla, $resultPorPagina){      
        $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        //La página inicial no puede ser inferior a 1 
        if($pagina <1){
            $pagina=1;
        }
        $paginaInicial = ($pagina-1) * $resultPorPagina;
        try{
            //Contamos los resultados totales
            $stmtRegistrosTotales = $conexion->query("Select count(*) as total from solicitudes;");
            $totalRegistros = $stmtRegistrosTotales->fetchColumn();
            //Dividimos los resultados totales entre los que queremos ver por páginas
            $totalPaginas = ceil($totalRegistros/$resultPorPagina);
            //Preparamos la consulta a la tabla que queramos hacer y por seguridad protegemos los valores y les damos valor más tarde
            //para poder prevenir una posible futura inyección sql
            $preparedStatement = "SELECT * FROM $tabla limit :inicio, :resultadoPorPagina";
            $stmt = $conexion->prepare($preparedStatement);
            $stmt->bindValue(':inicio', $paginaInicial, PDO::PARAM_INT);
            $stmt->bindValue(':resultadoPorPagina', $resultPorPagina, PDO::PARAM_INT);
            $stmt->execute();
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return [
                'datos' => $resultados,
                'totalPaginas' => $totalPaginas,
                'paginaActual' => $pagina
            ]; 
        }catch(PDOException $e){
            die("Error en la paginación: ". $e->getMessage());
        }      
    }   
   
?>