<?php 
    function muestraNombre($apel, $titulo="Sr.")
    {
        echo "Estimado $titulo $apel: <br>";
    }
    muestraNombre("Fernandez");
    muestraNombre("Fernandez", "Prof.");
?>