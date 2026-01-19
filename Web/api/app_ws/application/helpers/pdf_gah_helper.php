<?php

function pdf_gah($datos)
{
    $CI = &get_instance();
    $CI->load->database();

    $verificacion_id = (int)$datos['verificacion_id'];

    $query = $CI->db->get_where('vw_verificaciones', array('verificacion_id' => $verificacion_id));
    $verificacion = $query->row();
    $tipo_verificacion = $verificacion->tipo_verificacion;

    $params = array($verificacion_id);
    $query_sql = "SELECT * FROM vw_clientes WHERE cliente_id = (SELECT cliente_id FROM verificaciones WHERE verificacion_id = ?)";
    $query_cliente = $CI->db->query($query_sql, $params);
    $cliente = $query_cliente->row();
    $datos_cliente = $cliente->nombre . "\n" . $cliente->calle . " " . $cliente->numero . ", " . $cliente->colonia . "\n" . $cliente->municipio . " " . $cliente->estado;

    $params = array($verificacion->vehiculo_id);
    $query_sql = "SELECT * FROM vehiculos WHERE vehiculo_id = ?";
    $query_vehiculo = $CI->db->query($query_sql, $params);
    $vehiculo = $query_vehiculo->row();

    $params = array($vehiculo->vehiculo_id);
    $query_sql = "SELECT * FROM vw_vehiculos WHERE vehiculo_id = ?";
    $query_vehiculo_vw = $CI->db->query($query_sql, $params);
    $vehiculo_vw = $query_vehiculo_vw->row();

    $CI->load->library('F_pdf');
    $CI->F_pdf = new F_pdf('P', 'mm', 'letter');
    $CI->F_pdf->Open();
    $CI->F_pdf->SetAutoPageBreak(false);
    $CI->F_pdf->AddPage();

    $margenes = 0;

    $CI->F_pdf->SetFont('Arial', '', 8);

    $set_y = 48;

    $CI->F_pdf->SetXY(8, $set_y);
    $CI->F_pdf->Cell(30, 8, fecha_formato_dma($verificacion->fecha), $margenes, 0, 'C', false);
    $CI->F_pdf->Cell(30, 8, $verificacion->tipo_unidad_verificacion, $margenes, 0, 'C', false);

    $CI->F_pdf->SetFont('Arial', '', 6);
    $CI->F_pdf->SetXY(68, $set_y);
    $CI->F_pdf->MultiCell(102, 2.5, utf_decode($datos_cliente), $margenes, 'L', false);

    $CI->F_pdf->SetFont('Arial', '', 8);
    $CI->F_pdf->SetXY(170, $set_y);
    $CI->F_pdf->Cell(37, 8, $cliente->rfc, $margenes, 0, 'C', false);

    $set_y += 8.5;

    if ($tipo_verificacion == 'NOM-EM-167') {
        $CI->F_pdf->Image('C:\\ruta\\Herkace_Shared\\Web\\assets\\images\\fa_check.png', 78, $set_y, 3, 3);
    } elseif ($tipo_verificacion == 'FISICO-MECANICO') {
        $CI->F_pdf->Image('C:\\ruta\\Herkace_Shared\\Web\\assets\\images\\fa_check.png', 203, $set_y, 3, 3);
    }

    $set_y += 5.5;

    $CI->F_pdf->SetXY(50, $set_y);
    $CI->F_pdf->Cell(100, 5, $verificacion->folio_ant, $margenes, 0, 'L', false);
    $CI->F_pdf->Cell(27, 5, fecha_formato_dma($verificacion->fecha_ant), $margenes, 0, 'C', false);

    $set_y += 14;

    $CI->F_pdf->SetXY(8, $set_y);
    $CI->F_pdf->SetFont('Arial', '', 6);
    $CI->F_pdf->MultiCell(27, 4, utf_decode($vehiculo_vw->tipo_vehiculo), $margenes, 'C', false);
    $CI->F_pdf->SetXY(35, $set_y - 1);
    $CI->F_pdf->SetFont('Arial', '', 8);
    $CI->F_pdf->Cell(38, 9, utf_decode($verificacion->marca), $margenes, 0, 'C', false);
    $CI->F_pdf->Cell(30, 9, $vehiculo->anio, $margenes, 0, 'C', false);
    $CI->F_pdf->Cell(40, 9, $verificacion->num_placas, $margenes, 0, 'C', false);

    $CI->F_pdf->SetFont('Arial', '', 6);

    $CI->F_pdf->MultiCell(37, 4, utf_decode($vehiculo_vw->tipo_servicio), $margenes, 'C', false);

    $CI->F_pdf->SetFont('Arial', '', 6.5);

    $CI->F_pdf->SetXY(180, $set_y - 1);
    $CI->F_pdf->Cell(29, 8, $vehiculo->num_serie, $margenes, 0, 'R', false);

    return $CI->F_pdf->Output("reporte_Inspeccion.pdf", 'I', false);
}
