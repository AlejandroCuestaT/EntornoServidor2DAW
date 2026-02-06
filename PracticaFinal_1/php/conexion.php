<?php

        $conn = new PDO('mysql:host=localhost;dbname=cursoscp;charset=utf8', 'alex', '1234');
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>