<?php
include_once 'xlsxwriter.class.php';

function excel_clientes()
{
    date_default_timezone_set('America/Matamoros');

    $fecha = date('d-m-Y');

    $CI = &get_instance();
    $CI->load->database();
    
    $query = $CI->db->query('select * from vw_clientes where activo = 1');

    header('Content-disposition: attachment; filename="' . XLSXWriter::sanitize_filename('Clientes.xlsx') . '"');
    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
    header('Content-Transfer-Encoding: binary');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    $header = array(
        'N°',
        'Tipo cliente',
        'Nombre del cliente',
        'RFC',
        'CURP',
        'Calle',
        'Colonia',
        'Número',
        'Municipio',
        'Estado',
        'Código postal',
        'Correo',
        'Régimen fiscal'
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

    $writer->writeSheetRow('Clientes', array('Clientes'), $styles2);
    $writer->writeSheetRow('Clientes', $row_vacio);
    $writer->writeSheetRow('Clientes', array('','Fecha: ' . $fecha));
    $writer->writeSheetRow('Clientes', $row_vacio);
    $writer->writeSheetRow('Clientes', $header, $styles);
    $array = array();

    foreach ($query->result() as $row) {
        $array[0] = $row -> numero_cliente;
        $array[1] = chrToStr($row->tipo_cliente);
        $array[2] = $row->nombre;
        $array[3] = $row->rfc;
        $array[4] = $row->curp;
        $array[5] = $row->calle;
        $array[6] = $row->colonia;
        $array[7] = $row->numero;
        $array[8] = $row->municipio;
        $array[9] = $row->estado;
        $array[10] = $row->codigo_postal;
        $array[11] = $row->correo;
        $array[12] = $row->regimen;
        $writer->writeSheetRow('Clientes', $array);
    }

    $writer->writeToStdOut();
    exit();
}
