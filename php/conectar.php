<?php
    function conectar(){
        $conn = new PDO("mysql:host=localhost;dbname=consultoria_db;charset=utf8","root","");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    }
?>