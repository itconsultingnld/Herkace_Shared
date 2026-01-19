<?php
include_once 'xlsxwriter.class.php';

function excel_vehiculos()
{
    date_default_timezone_set('America/Matamoros');

    $fecha = date('d-m-Y');

    $CI = &get_instance();
    $CI->load->database();

    $queryCoor = $CI->db->query('select * from vw_vehiculos where activo = 1');

    header('Content-disposition: attachment; filename="' . XLSXWriter::sanitize_filename('Vehiculos.xlsx') . '"');
    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
    header('Content-Transfer-Encoding: binary');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    $header = array(
        'Cliente',
        'Marca de vehículo',
        'Tipo de unidad',
        'Tipo de servicio',
        'Modelo',
        'Número de serie',
        'Año',
        'Número de placas',
        'Tarjeta de circulación',
        'Capacidad'
    );
    $writer = new XLSXWriter();
    $styles = array( 'font'=>'Arial','font-size'=>10,'font-style'=>'bold', 'fill'=>'#eee', 'halign'=>'center', 'border'=>'left,right,top,bottom');
    $styles2 = array( 'font'=>'Arial','font-size'=>14,'font-style'=>'bold');
    
    $row_vacio = array();
    $row_vacio[0] =  '';
    $row_vacio[1] = '';
    $row_vacio[2] = '';
    $row_vacio[3] = '';
    $row_vacio[4] = '';
    $row_vacio[5]= '';
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

    $writer->writeSheetRow('Vehiculos', array('Vehículos'), $styles2);
    $writer->writeSheetRow('Vehiculos', $row_vacio);
    $writer->writeSheetRow('Vehiculos', array('','Fecha:', $fecha));
    $writer->writeSheetRow('Vehiculos', $row_vacio);
    $writer->writeSheetRow('Vehiculos', $header, $styles);
    $array = array();

    foreach ($queryCoor->result() as $row) {
        $array[0] = $row->cliente;
        $array[1] = $row->marca_vehiculo;
        $array[2] = $row->tipo_vehiculo;
        $array[3] = $row->tipo_unidad;
        $array[4] = $row->tipo_servicio;
        $array[5] = $row->num_serie;
        $array[6] = $row->anio;
        $array[7] = $row->num_placas;
        $array[8] = $row->tarjeta_circ;
        $capacidad = $row->capacidad . ' ';
        switch ($row->capacidad_unidad) {
            case 'K':
                $capacidad .= 'kilogramos';
                break;
            case 'L':
                $capacidad .= 'litros';
                break;
            case 'P':
                $capacidad .= 'personas';
                break;
            default:
                break;
        }
        $array[9] = $capacidad;
        $writer->writeSheetRow('Vehiculos', $array);
    }

    $writer->writeToStdOut();
    exit();
}
