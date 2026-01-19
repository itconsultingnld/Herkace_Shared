<?php
include_once 'xlsxwriter.class.php';

function excel_clientes_facturacion()
{
    date_default_timezone_set('America/Matamoros');

    $fecha = date('d-m-Y');

    $CI = &get_instance();
    $CI->load->database();
    
    $query = $CI->db->query('select * from vw_clientes_facturacion where activo = 1');

    header('Content-disposition: attachment; filename="' . XLSXWriter::sanitize_filename('ClientesFacturacion.xlsx') . '"');
    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
    header('Content-Transfer-Encoding: binary');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    $header = array(
        'N°',
        'Razón social',
        'RFC',
        'CURP',
        'Calle',
        'Número exterior',
        'Número interior',
        'Colonia',
        'Localidad',
        'Municipio',
        'Estado',
        'Código postal',
        'País',
        'Correo 1',
        'Correo 2',
        'Correo 3',
        'Correo 4',
        'Correo 5',
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

    $writer->writeSheetRow('Clientes Facturación', array('Clientes Facturación'), $styles2);
    $writer->writeSheetRow('Clientes Facturación', $row_vacio);
    $writer->writeSheetRow('Clientes Facturación', array('','Fecha: ' . $fecha));
    $writer->writeSheetRow('Clientes Facturación', $row_vacio);
    $writer->writeSheetRow('Clientes Facturación', $header, $styles);
    $array = array();

    foreach ($query->result() as $row) {
        $array[0] = $row -> numero_cliente;
        $array[1] = $row->razon_social;
        $array[2] = $row->tipo_persona;
        $array[3] = $row->rfc;
        $array[4] = $row->curp;
        $array[5] = $row->calle;
        $array[6] = $row->numero_ext;
        $array[7] = $row->numero_int;
        $array[8] = $row->colonia;
        $array[9] = $row->localidad;
        $array[10] = $row->municipio;
        $array[11] = $row->estado;
        $array[12] = $row->codigo_postal;
        $array[13] = $row->pais;
        $array[14] = $row->correo1;
        $array[15] = $row->correo2;
        $array[16] = $row->correo3;
        $array[17] = $row->correo4;
        $array[18] = $row->correo5;
        $array[19] = $row->regimen;
        $writer->writeSheetRow('Clientes Facturación', $array);
    }

    $writer->writeToStdOut();
    exit();
}
