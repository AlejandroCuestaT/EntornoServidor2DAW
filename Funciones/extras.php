<?php
    date("d/m/Y");              // 18/02/2026
    date("d/m/Y H:i:s");        // 18/02/2026 15:30:00
    date("Y-m-d");              // 2026-02-18 (para MySQL)
    time();                    // timestamp actual
    strtotime("2026-01-01");  // string a timestamp
    mktime(0,0,0, 12,25,2026); // timestamp de fecha específica

    // Formatear caracteres de fecha
    // d=día, m=mes, Y=año 4dig, y=año 2dig
    // H=hora 24h, i=minutos, s=segundos
    // N=día semana (1=lun, 7=dom), l=nombre día
?>