<?php

function pdf_certificado_arrastre($verificacion_id)
{
    $CI = &get_instance();
    $CI->load->database();

    $query = $CI->db->get_where('vw_verificaciones', array('verificacion_id' => $verificacion_id));
    $verificacion = $query->row();

    $params = array($verificacion_id);
    $query_sql = "SELECT * FROM vw_clientes WHERE cliente_id = (SELECT cliente_id FROM verificaciones WHERE verificacion_id = ?)";
    $query_cliente = $CI->db->query($query_sql, $params);
    $cliente = $query_cliente->row();
    $cliente_domicilio = $cliente->calle . " " . $cliente->numero;

    $params = array($verificacion->vehiculo_id);
    $query_sql = "SELECT * FROM vehiculos WHERE vehiculo_id = ?";
    $query_vehiculo = $CI->db->query($query_sql, $params);
    $vehiculo = $query_vehiculo->row();

    $params = array($vehiculo->vehiculo_id);
    $query_sql = "SELECT * FROM vw_vehiculos WHERE vehiculo_id = ?";
    $query_vehiculo_vw = $CI->db->query($query_sql, $params);
    $vehiculo_vw = $query_vehiculo_vw->row();

    $query_sql = "SELECT * FROM configuracion";
    $query_config = $CI->db->query($query_sql);
    $config = array();
    foreach ($query_config->result() as $con) {
        $config[$con->nombre] = $con->valor;
    }

    $CI->load->library('F_pdf');
    $CI->F_pdf = new F_pdf('P', 'mm', 'legal');
    $CI->F_pdf->Open();
    $CI->F_pdf->SetAutoPageBreak(false);
    $CI->F_pdf->AddPage('P', 'legal');

    $margenes = 0;

    $CI->F_pdf->SetFont('Arial', '', 7);

    #region SICT

    $set_y = 24;

    $CI->F_pdf->SetXY(11, $set_y);
    $CI->F_pdf->Cell(30, 6, $config['No. DE APROBACIÓN'], $margenes, 0, 'C', false);
    $CI->F_pdf->Cell(25, 6, $config['No. DE ACREDITACIÓN'], $margenes, 0, 'C', false);
    $CI->F_pdf->Cell(12, 6, '1', $margenes, 0, 'C', false);
    $CI->F_pdf->Cell(20, 6, $verificacion->estatus, $margenes, 0, 'C', false);
    $CI->F_pdf->SetFont('Arial', '', 6);
    $CI->F_pdf->MultiCell(29, 2.5, $vehiculo_vw->tipo_servicio, $margenes, 'C', false);
    $CI->F_pdf->SetFont('Arial', '', 7);
    $CI->F_pdf->SetXY(127, $set_y);
    $CI->F_pdf->Cell(27, 6, fecha_formato_dma($verificacion->fecha), $margenes, 0, 'C', false);
    $set_y += 1;
    $CI->F_pdf->SetXY(154, $set_y);
    $CI->F_pdf->Cell(10, 5, hora_formato_hm($verificacion->hora_inicio), $margenes, 0, 'C', false);
    $CI->F_pdf->Cell(12, 5, hora_formato_hm($verificacion->hora_final), $margenes, 0, 'C', false);
    $set_y -= 1;
    $CI->F_pdf->SetXY(176, $set_y);
    $CI->F_pdf->Cell(35, 6, fecha_formato_dma($verificacion->fecha_ant), $margenes, 0, 'C', false);

    $set_y += 12;

    $CI->F_pdf->SetXY(12, $set_y);
    $CI->F_pdf->MultiCell(69, 7, utf_decode($verificacion->cliente), $margenes, 'L', false);
    $CI->F_pdf->SetXY(81, $set_y);
    $CI->F_pdf->Cell(49, 7, $cliente->rfc, $margenes, 0, 'L', false);
    $CI->F_pdf->Cell(80, 7, utf_decode($cliente_domicilio), $margenes, 0, 'L', false);

    $set_y += 10;

    $CI->F_pdf->SetXY(81, $set_y);
    $CI->F_pdf->Cell(49, 7, utf_decode($cliente->municipio), $margenes, 0, 'C', false);
    $set_y += 1;
    $CI->F_pdf->SetXY(130, $set_y);
    $CI->F_pdf->Cell(50, 7, utf_decode($cliente->estado), $margenes, 0, 'L', false);
    $CI->F_pdf->Cell(30, 7, $cliente->codigo_postal, $margenes, 0, 'C', false);

    $set_y += 14;

    $CI->F_pdf->SetXY(12, $set_y);
    $CI->F_pdf->Cell(29, 6, $verificacion->num_placas, $margenes, 0, 'C', false);
    $CI->F_pdf->Cell(61, 6, $vehiculo->num_serie, $margenes, 0, 'L', false);
    $set_y += 1;
    $CI->F_pdf->SetXY(102, $set_y);
    $CI->F_pdf->Cell(27, 5, $verificacion->tipo_unidad_verificacion, $margenes, 0, 'C', false);
    $CI->F_pdf->Cell(50, 5, utf_decode($verificacion->marca), $margenes, 0, 'C', false);
    $CI->F_pdf->Cell(30, 5, $vehiculo->anio, $margenes, 0, 'C', false);

    $set_y += 9;

    $CI->F_pdf->SetXY(12, $set_y);
    $CI->F_pdf->Cell(90, 6, $vehiculo->tarjeta_circ, $margenes, 0, 'C', false);
    $CI->F_pdf->Cell(27, 6, utf_decode($verificacion->estatus_unidad), $margenes, 0, 'L', false);

    $set_y += 13;

    $CI->F_pdf->SetXY(90, $set_y);
    $CI->F_pdf->Cell(119, 6, utf_decode($verificacion->tecnico), $margenes, 0, 'L', false);

    #endregion

    #region UNIDAD DE INSPECCION

    $set_y += 52;

    $CI->F_pdf->SetXY(12, $set_y);
    $CI->F_pdf->Cell(29, 6, $config['No. DE APROBACIÓN'], $margenes, 0, 'C', false);
    $CI->F_pdf->Cell(26, 6, $config['No. DE ACREDITACIÓN'], $margenes, 0, 'C', false);
    $CI->F_pdf->Cell(12, 6, '1', $margenes, 0, 'C', false);
    $CI->F_pdf->Cell(18, 6, $verificacion->estatus, $margenes, 0, 'C', false);
    $CI->F_pdf->SetFont('Arial', '', 6);
    $set_y += 1;
    $CI->F_pdf->SetXY(97, $set_y);
    $CI->F_pdf->MultiCell(30, 2.5, $vehiculo_vw->tipo_servicio, $margenes, 'C', false);
    $CI->F_pdf->SetFont('Arial', '', 7);
    $CI->F_pdf->SetXY(127, $set_y);
    $CI->F_pdf->Cell(25, 6, fecha_formato_dma($verificacion->fecha), $margenes, 0, 'C', false);
    $set_y += 1;
    $CI->F_pdf->SetXY(152, $set_y);
    $CI->F_pdf->Cell(13, 4, hora_formato_hm($verificacion->hora_inicio), $margenes, 0, 'C', false);
    $CI->F_pdf->Cell(11, 4, hora_formato_hm($verificacion->hora_final), $margenes, 0, 'C', false);
    $set_y -= 2;
    $CI->F_pdf->SetXY(176, $set_y);
    $CI->F_pdf->Cell(35, 6, fecha_formato_dma($verificacion->fecha_ant), $margenes, 0, 'C', false);

    $set_y += 12;

    $CI->F_pdf->SetXY(12, $set_y);
    $CI->F_pdf->MultiCell(68, 7, utf_decode($verificacion->cliente), $margenes, 'L', false);
    $set_y += 1;
    $CI->F_pdf->SetXY(80, $set_y);
    $CI->F_pdf->Cell(49, 7, $cliente->rfc, $margenes, 0, 'L', false);
    $CI->F_pdf->Cell(81, 7, utf_decode($cliente_domicilio), $margenes, 0, 'L', false);

    $set_y += 9;

    $CI->F_pdf->SetXY(80, $set_y);
    $CI->F_pdf->Cell(49, 6, utf_decode($cliente->municipio), $margenes, 0, 'C', false);
    $CI->F_pdf->SetXY(129, $set_y);
    $CI->F_pdf->Cell(51, 7, utf_decode($cliente->estado), $margenes, 0, 'L', false);
    $CI->F_pdf->Cell(30, 7, $cliente->codigo_postal, $margenes, 0, 'C', false);

    $set_y += 16;

    $CI->F_pdf->SetXY(12, $set_y);
    $CI->F_pdf->Cell(29, 6, $verificacion->num_placas, $margenes, 0, 'C', false);
    $CI->F_pdf->Cell(60, 6, $vehiculo->num_serie, $margenes, 0, 'L', false);
    $CI->F_pdf->Cell(27, 6, $verificacion->tipo_unidad_verificacion, $margenes, 0, 'C', false);

    $set_y += 10;

    $CI->F_pdf->SetXY(12, $set_y);
    $CI->F_pdf->Cell(52, 6, $vehiculo->tarjeta_circ, $margenes, 0, 'C', false);
    $CI->F_pdf->Cell(23, 6, utf_decode($verificacion->marca), $margenes, 0, 'C', false);
    $CI->F_pdf->Cell(14, 6, $vehiculo->anio, $margenes, 0, 'C', false);
    $CI->F_pdf->Cell(27, 6, utf_decode($verificacion->estatus_unidad), $margenes, 0, 'L', false);

    $set_y += 13;

    $CI->F_pdf->SetXY(90, $set_y);
    $CI->F_pdf->Cell(39, 6, utf_decode($verificacion->tecnico), $margenes, 0, 'L', false);

    #endregion

    #region PROPIETARIO

    $set_y += 53;

    $CI->F_pdf->SetXY(11, $set_y);
    $CI->F_pdf->Cell(29, 6, $config['No. DE APROBACIÓN'], $margenes, 0, 'C', false);
    $CI->F_pdf->Cell(26, 6, $config['No. DE ACREDITACIÓN'], $margenes, 0, 'C', false);
    $CI->F_pdf->Cell(12, 6, '1', $margenes, 0, 'C', false);
    $CI->F_pdf->Cell(19, 6, $verificacion->estatus, $margenes, 0, 'C', false);
    $CI->F_pdf->SetFont('Arial', '', 6);
    $set_y += 1;
    $CI->F_pdf->SetXY(97, $set_y);
    $CI->F_pdf->MultiCell(29, 2.5, $vehiculo_vw->tipo_servicio, $margenes, 'C', false);
    $CI->F_pdf->SetFont('Arial', '', 7);
    $set_y -= 1;
    $CI->F_pdf->SetXY(126, $set_y);
    $CI->F_pdf->Cell(25, 7, fecha_formato_dma($verificacion->fecha), $margenes, 0, 'C', false);
    $set_y += 3;
    $CI->F_pdf->SetXY(151, $set_y);
    $CI->F_pdf->Cell(12, 4, hora_formato_hm($verificacion->hora_inicio), $margenes, 0, 'C', false);
    $CI->F_pdf->Cell(12, 4, hora_formato_hm($verificacion->hora_final), $margenes, 0, 'C', false);
    $set_y -= 2;
    $CI->F_pdf->SetXY(175, $set_y);
    $CI->F_pdf->Cell(34, 6, fecha_formato_dma($verificacion->fecha_ant), $margenes, 0, 'C', false);

    $set_y += 13;

    $CI->F_pdf->SetXY(11, $set_y);
    $CI->F_pdf->MultiCell(68, 7, utf_decode($verificacion->cliente), $margenes, 'L', false);
    $CI->F_pdf->SetXY(79, $set_y);
    $CI->F_pdf->Cell(49, 7, $cliente->rfc, $margenes, 0, 'L', false);
    $CI->F_pdf->Cell(81, 7, utf_decode($cliente_domicilio), $margenes, 0, 'L', false);

    $set_y += 10;

    $CI->F_pdf->SetXY(79, $set_y);
    $CI->F_pdf->Cell(49, 7, utf_decode($cliente->municipio), $margenes, 0, 'C', false);
    $CI->F_pdf->Cell(52, 7, utf_decode($cliente->estado), $margenes, 0, 'L', false);
    $CI->F_pdf->Cell(30, 7, $cliente->codigo_postal, $margenes, 0, 'C', false);

    $set_y += 14;

    $CI->F_pdf->SetXY(11, $set_y);
    $CI->F_pdf->Cell(29, 6, $verificacion->num_placas, $margenes, 0, 'C', false);
    $CI->F_pdf->Cell(60, 6, $vehiculo->num_serie, $margenes, 0, 'L', false);
    $CI->F_pdf->Cell(27, 6, $verificacion->tipo_unidad_verificacion, $margenes, 0, 'C', false);
    $CI->F_pdf->Cell(51, 6, utf_decode($verificacion->marca), $margenes, 0, 'C', false);
    $CI->F_pdf->Cell(30, 5, $vehiculo->anio, $margenes, 0, 'C', false);

    $set_y += 10;

    $CI->F_pdf->SetXY(11, $set_y);
    $CI->F_pdf->Cell(89, 5, $vehiculo->tarjeta_circ, $margenes, 0, 'C', false);
    $CI->F_pdf->Cell(27, 5, utf_decode($verificacion->estatus_unidad), $margenes, 0, 'L', false);

    $set_y += 13;

    $CI->F_pdf->SetXY(89, $set_y);
    $CI->F_pdf->Cell(119, 6, utf_decode($verificacion->tecnico), $margenes, 0, 'L', false);

    #endregion

    return $CI->F_pdf->Output("reporte_Inspeccion.pdf", 'I', false);
}
