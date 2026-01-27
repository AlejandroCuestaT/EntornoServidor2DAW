<?php
$con = mysqli_connect("localhost", "alex", "1234", "jardineria");
if (mysqli_connect_errno()) {
printf("Conexión fallida: %s\n", mysqli_connect_error());
exit();
}
$query = "SELECT CURRENT_USER();";
$query .= "SELECT distinct NombreCliente from Clientes natural Join Pedidos
WHERE FechaEntrega > FechaEsperada";
if (mysqli_multi_query($con, $query)) {
do { /* almacenar primer juego de resultados */
if ($result = mysqli_store_result($con)) { // recorre los diferentes conjuntos Result
while ($row = mysqli_fetch_row($result)) { // recorre las filas de cada conjunto Result
printf("%s\n", $row[0]);
}
mysqli_free_result($result);
}/* mostrar divisor */
if (mysqli_more_results($con)) {
printf("-----------------\n");
}
} while (mysqli_next_result($con));
}
mysqli_close($con);
?>
