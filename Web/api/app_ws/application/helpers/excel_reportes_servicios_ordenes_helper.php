<?php
include_once 'xlsxwriter.class.php';

function excel_reportes_servicios_ordenes($datos)
{
    date_default_timezone_set('America/Matamoros');

    $fecha = date('d-m-Y');

    $CI = &get_instance();
    $CI->load->database();
    $num_orden = $datos['num_orden'];
    $params = array($num_orden);
    $queryLabel = "select * from vw_ordenes_servicios where num_orden = ? AND activo = 1";

    $queryCoor = $CI->db->query($queryLabel, $params);
    // $queryCoor = $CI->db->query('select * from vw_ordenes_servicios where num_orden = '.$num_orden.' && activo = 1');

    header('Content-disposition: attachment; filename="' . XLSXWriter::sanitize_filename('reporte_servicios_ordenes.xlsx') . '"');
    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
    header('Content-Transfer-Encoding: binary');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    $headerVacio = array(
        "servicios de orden $num_orden" => 'string',
        '' => 'string',
        '' => 'string',
        '' => 'string',
        '' => 'string',
        '' => 'string',
        '' => 'string',
    );
    $header = array(
        'Cliente',
        'Tipo de unidad',
        'Número de serie',
        'Número de placas',
        'Tarjeta de circulación',
        'Tipo de servicio (EC)',
        'Tipo de servicio (FM)',
    );
    $writer = new XLSXWriter();
    $styles = array('font' => 'Arial', 'font-size' => 10, 'font-style' => 'bold', 'fill' => '#eee', 'border' => 'left,right,top,bottom', 'wrap_text' => true, 'halign' => 'center','valign' => 'center');
    $styles2 = array('font' => 'Arial', 'font-size' => 14, 'font-style' => 'bold');

    $row_vacio = array();
    $row_vacio[0] =  '';
    $row_vacio[1] = '';
    $row_vacio[2] = '';
    $row_vacio[3] = '';
    $row_vacio[4] = '';
    $row_vacio[5] = '';
    $row_vacio[6] = '';
    $row_vacio[7] = '';
    $row_vacio[8] = '';
    $row_vacio[9] = '';
    $row_vacio[10] = '';
    $row_vacio[11] = '';
    $row_vacio[12] = '';
    $row_vacio[13] = '';
    $row_vacio[14] = '';
    $row_vacio[15] = '';
    $row_vacio[16] = '';
    $row_vacio[17] = '';
    $row_vacio[18] = '';
    $row_vacio[19] = '';
    $row_vacio[20] = '';
    $row_vacio[21] = '';
    $row_vacio[22] = '';
    $row_vacio[23] = '';
    $row_vacio[24] = '';
    $row_vacio[25] = '';
    $row_vacio[26] = '';
    $row_vacio[27] = '';
    $row_vacio[28] = '';
    $row_vacio[29] = '';
    $row_vacio[30] = '';
    $row_vacio[31] = '';
    $row_vacio[32] = '';
    $row_vacio[33] = '';
    $row_vacio[34] = '';
    $row_vacio[35] = '';
    $row_vacio[36] = '';
    $row_vacio[37] = '';
    $row_vacio[38] = '';
    $row_vacio[39] = '';
    $row_vacio[40] = '';
    $row_vacio[41] = '';

    $writer->writeSheetHeader('Servicios de órdenes', $headerVacio, ['widths' => [40, 12, 30, 30, 30, 35, 35],$styles2,$styles2,$styles2,$styles2,$styles2,$styles2,$styles2]);

    $writer->writeSheetRow('Servicios de órdenes', $row_vacio);
    $writer->writeSheetRow('Servicios de órdenes', array('','Fecha:', $fecha));
    $writer->writeSheetRow('Servicios de órdenes', $row_vacio);
    $writer->writeSheetRow('Servicios de órdenes', $header, $styles);


    $array = array();

    foreach ($queryCoor->result() as $row) {
        $array[0] = $row->nombre_cliente;
        $array[1] = $row->nombre_tipo_unidad_verif;
        $array[2] = $row->num_serie;
        $array[3] = $row->num_placas;
        $array[4] = $row->tarjeta_circ;
        $array[5] = $row->nombre_servicio_ec;
        $array[6] = $row->nombre_servicio_fm;
        $writer->writeSheetRow('Servicios de órdenes', $array);
    }

    $writer->writeToStdOut();
    exit();
}
