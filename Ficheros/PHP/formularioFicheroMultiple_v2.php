<html><body>
Inserción de la fotografía del usuario:
<form action="subeFicheroMultiple_v2.php" method="post" enctype="multipart/form-data">
<?php
echo "Nombre álbum:<input type='text' name='album'/><br/><br>";
echo "Fichero con su fotografía:<input type='file' name='foto1'/><br/><br>";
echo "Fichero con su fotografía:<input type='file' name='foto2'/><br/><br>";
echo "Fichero con su fotografía:<input type='file' name='foto3'/><br/><br>";
?>
<input type="submit" value="Enviar">
</form></body></html>
