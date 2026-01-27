<?php
$con = new mysqli("localhost","alex","1234");
$con->select_db("jardineria");
$strsql="SELECT * FROM clientes";
if ($resu=$con->query($strsql)){
while($fila=$resu->fetch_row()){
foreach($fila as $valor){
echo $valor.' ';

}
echo '<br>';
}
$resu->close();
$con->close();
}
?>