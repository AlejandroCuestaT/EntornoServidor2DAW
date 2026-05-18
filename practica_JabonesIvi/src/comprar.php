<?php
require '../func/sesiones.php';
require '../func/bdlogic.php';
require '../func/formulario.php';

validarLogueado();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productosAComprar = obtenerDatos('itemcesta', ['cestaID' => $_SESSION['usuarioLogin']['carritoLogin']['cestaID']]);
    if ($productosAComprar->rowCount() > 2) {
        // NO SE PUEDE COMPRAR POR QUE YA VAN MAS DE DOS
        header("Location: ../views/vistaUsuario.php?");
        exit();
    } else {
        // COMPROBAR SI HA REALIZADO COMPRAR
        $compras = obtenerDatos('pedidos', ['email' => $_SESSION['usuarioLogin']['email']]);
        if ($compras->rowCount() > 0) {
            $ultimaCompra = $compras->fetchAll();
            usort($ultimaCompra, function ($a, $b) {
                return $b['FechaPedido'] <=> $a['FechaPedido'];
            });
            $ultimaFecha = new DateTime($ultimaCompra[0]['FechaPedido']);
            $intervalo = $ultimaFecha->diff(new DateTime());
            if ($intervalo->m >= 1 || $intervalo->y > 0) {
                // echo "a psasado un mes desde la ultima compra";
                $ultimaCantidad = obtenerDatos('itemPedido', ['pedidoID' => $ultimaCompra[0]['pedidoID']], 'sum(unidades)');
                try {
                    //code...
                    $cone = conexionBBDD();
                    $sql = " Select SUM(unidades) as unidades from itempedido where productoID = " . $ultimaCompra[0]['pedidoID'] . " group by pedidoID limit 1";
                    $stmt = $cone->prepare($sql);
                    $stmt->execute();
                    if ($stmt->rowCount() == 0) {
                        echo "hola";
                        insertarDatos('pedidos', ["email" => $_SESSION['usuarioLogin']['email'], "Entregado" => 0, "FechaEntrega" => '2023-02-22', "FechaPedido" => '2023-02-22', "TotalPedido" => $productosAComprar->rowCount()]);
                        $sql1 = "Select pedidoID from pedidos where email =" . $_SESSION['usuarioLogin']['email'] . " order by FechaPedido limit 1";
                        $stmt1 = $cone->prepare($sql1);
                        $stmt1->execute();
                        echo ($stmt1->rowCount());
                        var_dump($idPedido[0]);
                        // insertarDatos('itemPedido', );
                    }
                } catch (Exception $th) {
                    echo $th->getMessage();
                }
            } else {
                echo "has superado el limite de productos por mes";
                // header("Location: ../views/vistaUsuario.php?");
                // exit();
            }
        }
        // SI NO PUES REALIZAR LA COMPRA Y ASJUTAR PEDIDO
    }
}