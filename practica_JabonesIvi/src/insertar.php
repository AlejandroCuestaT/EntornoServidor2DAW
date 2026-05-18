<?php
require("../func/bdlogic.php");
session_start();

if (empty($_SESSION['token_csrf'])) {
    header("Location: ./login.php");
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $tabla = $_POST['tabla'];
        unset($_POST['token_csrf']);
        unset($_POST['tabla']);
        insertarDatos($tabla, $_POST);
    } catch (Exception $e) {
        echo $e->getMessage();
    } finally {
        header("Location: ../views/vistaAdmin.php");
    }
    // insertarDatos($_COOKIE['tabla'], $_POST);
}

