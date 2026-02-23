<?php
        //Cambiar user y password a gusto
        $conn = new PDO('mysql:host=localhost;dbname=gestion_turnos;charset=utf8', 'alex', '1234');
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>