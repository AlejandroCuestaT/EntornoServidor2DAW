<?php 
$host = $_SERVER['HTTP_HOST'];
        $uri = rtrim(dirname($_SERVER['PHP_SELF']));
        $extra = '13_procesa.php';

        /**
         * Este codigo es para que el cliente se descargue un archivo
         * //Para ver que es tipo pdf
         * header('Content-type: application/pdf');
         * //El nombre que va a tener cuando se lo descargue el cliente
         * header('Content-Disposition: attachment; filename"downloaded.pdf"');
         * //La ruta del pdf a leer
         * readfile('original.pdf');
        */
        
        header('Content-type: application/pdf');
        header('Content-Disposition: attachment; filename"downloaded.pdf"');
        readfile('img/1760944396-hoja1');

        echo $_SERVER['HTTP_HOST']; 
        echo '<br>';
        //header('X-Powered-By: adivina-adivinanza');

        //Con el refresh espera en este caso 5 segundos y luego cambia de url
        //header("Refresh:5; url=http://$host$uri/$extra");
        
        //Redireciona directamente a esa url
        //header("Location: http://$host$uri/$extra");

        //Esto redirige a una pagina 
        //header('Location: https://academia.org.mx/consultas/consultas-frecuentes/item/enhorabuena');
        
?>