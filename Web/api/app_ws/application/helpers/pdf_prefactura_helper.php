<?php

include_once 'NumeroALetras.php';

use Luecano\NumeroALetras\NumeroALetras;

function pdf_prefactura($datos)
{
    $CI = &get_instance();
    $CI->load->database();

    $prefactura_id = (int)$datos['prefactura_id'];
    $num_prefactura = $datos['num_prefactura'];

    $params = array($prefactura_id);
    $query_sql = "SELECT * FROM vw_verificaciones_prefactura WHERE prefactura_id = ? AND (estatus = 'APROBADO' OR estatus = 'RECHAZADO')";
    $query = $CI->db->query($query_sql, $params);
    $verificaciones_db = $query->result_array();

    $verificaciones_grupos = array();
    foreach ($verificaciones_db as $key => $item) {
        // // $verificaciones_grupos[$item['tipo_verificacion']][$key] = $item;
        // $verificaciones_grupos[$item['subservicio']][$key] = $item;
        $group_key = $item['orden'] . '_' . $item['subservicio'] . '_' . $item['precio'];
        $verificaciones_grupos[$group_key][$key] = $item;
    }

    $params = array($prefactura_id);
    $query_sql = "SELECT * FROM vw_clientes WHERE cliente_id = (SELECT cliente_id FROM prefacturas WHERE prefactura_id = ?)";
    $query_cliente = $CI->db->query($query_sql, $params);
    $cliente = $query_cliente->row();
    if ($cliente == null) {
        $cliente = new stdClass();
        $cliente->regimen = '';
        $cliente->calle = '';
        $cliente->numero = '';
        $cliente->colonia = '';
        $cliente->codigo_postal = '';
        $cliente->municipio = '';
        $cliente->estado = '';
        $cliente->numero_cliente = '';
        $cliente->rfc = '';
        $cliente->nombre = '';
    }
    $datos_cliente = utf_decode("RÉGIMEN FISCAL: " . $cliente->regimen . "\n" . $cliente->calle . " " . $cliente->numero . ", " . $cliente->colonia . "\nC.P. " . $cliente->codigo_postal . " " . $cliente->municipio . ", " . $cliente->estado . "\n ");

    $params = array($prefactura_id);
    $query_sql = "SELECT * FROM vw_prefacturas WHERE prefactura_id = ?";
    $query_prefactura = $CI->db->query($query_sql, $params);
    $prefactura = $query_prefactura->row();

    $dt = datetimeMatamoros();
    $fecha = $dt->format("Y-m-d");

    $CI->load->library('F_pdf');
    $CI->F_pdf = new F_pdf('P', 'mm', 'letter');
    $CI->F_pdf->Open();
    $CI->F_pdf->SetAutoPageBreak(false);
    $CI->F_pdf->AddPage();

    $CI->F_pdf->Image(rutaBase() . 'assets' . rutaDivisor() . 'images' . rutaDivisor() . 'herkace_logo.png', 11, 11, 20, 20);

    $CI->F_pdf->SetXY(75, 11);
    $CI->F_pdf->SetFont('Arial', '', 8);
    $CI->F_pdf->MultiCell(0, 4, "GESTORES AMBIENTALES HERKACE\nCarretera Aeropuerto Km 3 # S/N Los Fresnos\nNuevo Laredo, TAM, MEX\nC.P:88290 Tel:(867)1751550\nRFC. GAH150217821", '0', 'L', false);

    $CI->F_pdf->SetXY(145, 10);
    $CI->F_pdf->SetFont('Arial', '', 8);
    $CI->F_pdf->SetTextColor(255, 255, 255);
    $CI->F_pdf->Cell(12, 5, "SERIE", 'L,R,T,B', 0, 'C', true);
    $CI->F_pdf->SetXY(161, 10);
    $CI->F_pdf->Cell(38, 5, "NO. DE FACTURA", 'L,R,T,B', 0, 'C', true);
    $CI->F_pdf->SetTextColor(0, 0, 0);
    $CI->F_pdf->SetXY(145, 15);
    $CI->F_pdf->Cell(12, 5, "A", 'L,R,T,B', 0, 'C', false);
    $CI->F_pdf->SetXY(161, 15);
    $CI->F_pdf->Cell(38, 5, $num_prefactura, 'L,R,T,B', 0, 'C', false);

    $CI->F_pdf->SetXY(145, 21);
    $CI->F_pdf->SetTextColor(255, 255, 255);
    $CI->F_pdf->Cell(54, 5, "EXPEDIDO EN:", 'L,R,T,B', 0, 'C', true);
    $CI->F_pdf->SetTextColor(0, 0, 0);
    $CI->F_pdf->SetXY(145, 26);
    $CI->F_pdf->MultiCell(54, 4, "NUEVO LAREDO, TAMAULIPAS", 'L,R,T', 'C', false);
    $CI->F_pdf->SetXY(145, 30);
    $CI->F_pdf->MultiCell(54, 3, utf_decode("Fecha Emisión: " . $fecha), 'L,R,B', 'L', false);

    $CI->F_pdf->SetXY(10, 34);
    $CI->F_pdf->SetTextColor(255, 255, 255);
    $CI->F_pdf->Cell(24, 5, "NO. CLIENTE:", 'L,R,T,B', 0, 'C', true);
    $CI->F_pdf->SetTextColor(0, 0, 0);
    $CI->F_pdf->Cell(70, 5, $cliente->numero_cliente, 'L,R,T,B', 0, 'C', false);
    $CI->F_pdf->SetTextColor(255, 255, 255);
    $CI->F_pdf->Cell(24, 5, "RFC:", 'L,R,T,B', 0, 'C', true);
    $CI->F_pdf->SetTextColor(0, 0, 0);
    $CI->F_pdf->Cell(71, 5, $cliente->rfc, 'L,R,T,B', 0, 'C', false);
    $CI->F_pdf->SetXY(10, 39);
    $CI->F_pdf->SetFont('Arial', 'B', 10);
    $CI->F_pdf->MultiCell(189, 4, utf_decode($cliente->nombre), 'L,R', 'L', false);
    $CI->F_pdf->SetFont('Arial', '', 8);
    $CI->F_pdf->MultiCell(189, 4, $datos_cliente, 'L,R,B', 'L', false);

    $w = array(6, 119, 0, 16, 0, 2, 16, 8, 2, 20);

    $pos_y = 60;

    $CI->F_pdf->SetXY(10, $pos_y);
    $CI->F_pdf->SetTextColor(255, 255, 255);
    $CI->F_pdf->Cell(94, 5, "CONDICIONES", 'L,R,T,B', 0, 'C', true);
    $CI->F_pdf->SetXY(105, $pos_y);
    $CI->F_pdf->Cell(94, 5, "VENDEDOR", 'L,R,T,B', 0, 'C', true);

    $pos_y += 5;
    $CI->F_pdf->SetXY(10, $pos_y);
    $CI->F_pdf->SetTextColor(0, 0, 0);
    $CI->F_pdf->Cell(94, 5, utf_decode($prefactura->condiciones), 'L,R,T,B', 0, 'C', false);
    $CI->F_pdf->SetXY(105, $pos_y);
    $CI->F_pdf->Cell(94, 5, utf_decode($prefactura->vendedor), 'L,R,T,B', 0, 'C', false);

    $pos_y += 8;
    $CI->F_pdf->SetXY(10, $pos_y);
    $CI->F_pdf->SetTextColor(255, 255, 255);
    $CI->F_pdf->Cell($w[0], 5, "", 'L,R,T,B', 0, 'L', true);
    $CI->F_pdf->Cell($w[1] + $w[2], 5, utf_decode("DESCRIPCIÓN DEL SERVICIO"), 'L,R,T,B', 0, 'L', true);
    $CI->F_pdf->Cell($w[3], 5, "CANTIDAD", 'L,R,T,B', 0, 'C', true);
    $CI->F_pdf->Cell($w[5] + $w[6], 5, "PRECIO U.", 'L,R,T,B', 0, 'C', true);
    $CI->F_pdf->Cell($w[7], 5, "IVA", 'L,R,T,B', 0, 'C', true);
    $CI->F_pdf->Cell($w[8] + $w[9], 5, "IMPORTE", 'L,R,T,B', 0, 'C', true);

    $pos_y += 5;
    $CI->F_pdf->SetTextColor(0, 0, 0);
    $CI->F_pdf->SetXY(10, $pos_y);

    $contador = 1;
    $subtotal = 0;

    $num_orden_ant = '';

    foreach ($verificaciones_grupos as $verificaciones_grupo) {
        $cantidad = 0;
        $folios = "";

        $servicio = '';
        $precio_u = 0;
        $servicio_id = '';

        foreach ($verificaciones_grupo as $verificacion) {
            $folios .= $verificacion['folio'] . ", ";
            $cantidad++;
            $servicio = $verificacion['servicio'];
            $precio_u = $verificacion['precio'];
            $servicio_id = $verificacion['servicio_id'];
            $num_orden = $verificacion['orden'];
        }

        $importe = $cantidad * $precio_u;
        $subtotal += $importe;
        $folios = rtrim($folios, ", ");

        $CI->F_pdf->SetXY(10, $pos_y);
        $CI->F_pdf->SetFont('Arial', '', 9);

        if ($num_orden != $num_orden_ant) {
            $CI->F_pdf->Cell(189, 5, 'ORDEN: ' . $num_orden, 0, 0, 'C', false);
            $pos_y += 5;
            $CI->F_pdf->SetXY(10, $pos_y);
            $num_orden_ant = $num_orden;
        }

        $CI->F_pdf->Cell($w[0], 5, $contador, 0, 0, 'R', false);
        // $CI->F_pdf->Cell($w[1], 5, "10 - " . $key_grupo, 0, 0, 'L', false);
        $CI->F_pdf->Cell($w[1], 5, $servicio_id . " - " . utf_decode(mb_strtoupper($servicio, 'UTF-8')), 0, 0, 'L', false);
        $CI->F_pdf->Cell($w[3], 5, number_format($cantidad, 3), 0, 0, 'R', false);
        $CI->F_pdf->Cell($w[5], 5, "$", 0, 0, 'L', false);
        $CI->F_pdf->Cell($w[6], 5, number_format($precio_u, 2), 0, 0, 'R', false);
        $CI->F_pdf->Cell($w[7], 5, "8%", 0, 0, 'L', false);
        $CI->F_pdf->Cell($w[8], 5, "$", 0, 0, 'L', false);
        $CI->F_pdf->Cell($w[9], 5, number_format($importe, 2), 0, 0, 'R', false);

        $pos_y += 5;

        $CI->F_pdf->SetXY(22 + $w[0], $pos_y);
        $CI->F_pdf->SetFont('Arial', '', 7);
        $CI->F_pdf->MultiCell($w[1] - 20, 3, $folios, 0, 'T', false);

        $pos_y = $CI->F_pdf->GetY();

        $contador++;
    }

    $subtotal_iva = $subtotal * 0.08;
    $total = $subtotal + $subtotal_iva;
    $formatter = new NumeroALetras();
    $letra = ucwords(strtolower($formatter->toInvoice($total, 2, ""))) . "M.N.";
    $letra = str_replace("Y", "y", $letra);

    $pos_y = 78;

    $CI->F_pdf->SetXY(10, $pos_y);
    $CI->F_pdf->Cell(167, 191, "", 'L,R,T,B', 0, 'L', false);
    $CI->F_pdf->Cell(22, 191, "", 'R,T,B', 0, 'L', false);

    $CI->F_pdf->SetTextColor(0, 0, 0);

    $pos_y += 174;

    $CI->F_pdf->SetXY(10, $pos_y);
    $CI->F_pdf->SetFont('Arial', 'B', 9);
    $CI->F_pdf->SetFillColor(192, 192, 192);
    $CI->F_pdf->Cell(10, 6, "", 0, 0, 'L', true);
    $CI->F_pdf->Cell(135, 6, "IMPORTE CON LETRA", 0, 0, 'L', true);
    $CI->F_pdf->SetFillColor(0, 0, 0);

    $pos_y += 7;

    $CI->F_pdf->SetXY(20, $pos_y);
    $CI->F_pdf->SetFont('Arial', '', 8);
    $CI->F_pdf->Cell(140, 7, $letra, 0, 0, 'L', false);

    $pos_y -= 8;

    $CI->F_pdf->SetXY(161, $pos_y);
    $CI->F_pdf->SetFont('Arial', '', 9);
    $CI->F_pdf->Cell(20, 5, "SUBTOTAL   $", 0, 0, 'R', false);
    $CI->F_pdf->Cell(18, 5, number_format($subtotal, 2), 0, 0, 'R', false);

    $pos_y += 5;

    $CI->F_pdf->SetXY(161, $pos_y);
    $CI->F_pdf->Cell(20, 5, "8% I.V.A.   $", 0, 0, 'R', false);
    $CI->F_pdf->Cell(18, 5, number_format($subtotal_iva, 2), 0, 0, 'R', false);


    $pos_y += 5;

    $CI->F_pdf->SetXY(161, $pos_y);
    $CI->F_pdf->Cell(20, 5, "TOTAL   $", 0, 0, 'R', false);
    $CI->F_pdf->Cell(18, 5, number_format($total, 2), 0, 0, 'R', false);

    return $CI->F_pdf->Output("reporte_Inspeccion.pdf", 'I', false);
}
