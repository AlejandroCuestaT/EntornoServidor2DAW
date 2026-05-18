<?php
require_once('fpdf.php');

function generarPDF($pedidoID) {
    global $conn;
    $stmt = $conn->prepare("SELECT p.pedidoID, c.nombre, c.email, c.direccion, c.ciudad, c.cp, p.fechaPedido, p.totalPedido, p.fechaEntregaEstimada 
                            FROM PEDIDOS p JOIN CLIENTES c ON p.email = c.email WHERE p.pedidoID = ?");
    $stmt->execute([$pedidoID]);
    $pedido = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmtItems = $conn->prepare("SELECT pr.nombre, ip.unidades, ip.precio_unitario 
                                 FROM ITEMPEDIDO ip JOIN PRODUCTOS pr ON ip.productoID = pr.productoID WHERE ip.pedidoID = ?");
    $stmtItems->execute([$pedidoID]);
    $items = $stmtItems->fetchAll(PDO::FETCH_ASSOC);

    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',16);
    $pdf->Cell(0,10,'ALBARAN DE PEDIDO',0,1,'C');
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(0,10,'Jabones Scarlatti',0,1);
    $pdf->Cell(0,10,'Pedido Nº: ' . $pedido['pedidoID'],0,1);
    $pdf->Cell(0,10,'Cliente: ' . $pedido['nombre'],0,1);
    $pdf->Cell(0,10,'Email: ' . $pedido['email'],0,1);
    $pdf->Cell(0,10,'Direccion: ' . $pedido['direccion'] . ', ' . $pedido['ciudad'] . ' (' . $pedido['cp'] . ')',0,1);
    $pdf->Cell(0,10,'Fecha del pedido: ' . $pedido['fechaPedido'],0,1);
    $pdf->Cell(0,10,'Fecha estimada de entrega: ' . $pedido['fechaEntregaEstimada'],0,1);
    $pdf->Ln(5);
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(80,10,'Producto',1);
    $pdf->Cell(30,10,'Cantidad',1);
    $pdf->Cell(40,10,'Precio unitario',1);
    $pdf->Cell(40,10,'Subtotal',1,1);
    $pdf->SetFont('Arial','',12);
    $total = 0;
    foreach($items as $row) {
        $subtotal = $row['unidades'] * $row['precio_unitario'];
        $total += $subtotal;
        $pdf->Cell(80,10,utf8_decode($row['nombre']),1);
        $pdf->Cell(30,10,$row['unidades'],1);
        $pdf->Cell(40,10,$row['precio_unitario'] . ' €',1);
        $pdf->Cell(40,10,$subtotal . ' €',1,1);
    }
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(150,10,'TOTAL PEDIDO:',1);
    $pdf->Cell(40,10,$total . ' €',1,1);
    $ruta = sys_get_temp_dir() . "/albaran_$pedidoID.pdf";
    $pdf->Output('F', $ruta);
    return $ruta;
}
?>