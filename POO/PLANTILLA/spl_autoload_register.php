<?php

spl_autoload_register(function ($clase) {
    $fullpath = strtolower($clase).".php";

    if(file_exists($fullpath)){
        require_once($fullpath);
    }
});

?>