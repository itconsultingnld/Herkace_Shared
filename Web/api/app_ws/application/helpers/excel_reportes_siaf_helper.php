<?php
include_once 'xlsxwriter.class.php';

function excel_reportes_siaf($datos)
{
    date_default_timezone_set('America/Matamoros');

    $fecha = date('d-m-Y');

    $CI = &get_instance();
    $CI->load->database();
    // $num_orden = $datos['num_orden'];
    // $params = array($num_orden);
    $query = $CI->db->query("select * from vw_reporte_anual");

    // $queryCoor = $CI->db->query($queryLabel, $params);
    // $queryCoor = $CI->db->query('select * from vw_ordenes_servicios where num_orden = '.$num_orden.' && activo = 1');

    header('Content-disposition: attachment; filename="' . XLSXWriter::sanitize_filename('reporte_servicios_ordenes.xlsx') . '"');
    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
    header('Content-Transfer-Encoding: binary');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    $headerVacio = array(
        "NÚMERO DE UNIDAD DE VERIFICACIÓN" => 'string',
        'NÚMERO DE FOLIO DE CERTIFICADO' => 'string',
        'FECHA DE VERIFICACIÓN' => 'string',
        'FECHA DE VERIFICACIÓN ANTERIOR' => 'string',
        'LECTURA ODÓMETRO' => 'string',
        'DATOS DEL PROPIETARIO DEL VEHÍCULO' => 'string',
        'NOMBRE, RAZÓN O DENOMINACIÓN SOCIAL' => 'string',
        'TIPO DE VEHÍCULO (1)' => 'string',
        'NÚMERO DE SERIE O NIV' => 'string',
        'AÑO MODELO' => 'string',
        'MARCA' => 'string',
        'CAPACIDAD' => 'string',
        '' => 'string',
        '' => 'string',
        '',
        'NÚMERO DE EJES' => 'string',
        'PLACAS' => 'string',
        'FOLIO DE LA TARJETA DE CIRCULACIÓN' => 'string',
        'TIPO DE SERVICIO QUE PRESTA (3)' => 'string',
        'EL VEHÍCULO SE PRESENTÓ (4)' => 'string',
        'NOMBRE DEL TÉCNICO QUE VERIFICÓ' => 'string',
        'RESULTADO (5)' => 'string',
    );

    $tpovehiculoString = 'a';
    $header2 = array(
        "nada" => 'string',
        'nada' => 'string',
        'nada' => 'string',
        'nada' => 'string',
        'nada' => 'string',
        "NOMBRE, RAZÓN O DENOMINACIÓN SOCIAL",
        "RFC",
        $tpovehiculoString => 'string',
        "nada1",
        'NOMBRE, RAZÓN O DENOMINACIÓN SOCIAL',
        'RFC',
        'B 2 = Autobús de dos ejes,
        B 3 = Autobús de tres ejes,
        B 4 = Autobús de cuatro ejes,
        C 2 = Camión de dos ejes,
        C 3 = Camión de tres ejes,
        C 4 = Camión de cuatro ejes,
        T 2 = Tractocamión de dos ejes,
        T 3 = Tractocamión de tres ejes,
        S 1 = Semirremolque de un eje,
        S 2 = Semirremolque de dos ejes,
        S 3 = Semirremolque de tres ejes,
        S 4 = Semirremolque de cuatro ejes,
        S 5 = Semirremolque de cinco ejes,
        S 6 = Semirremolque de seis ejes,
        R 2 = Remolque de dos ejes,
        R 3 = Remolque de tres ejes,
        R 4 = Remolque de cuatro eje,s
        R 5 = Remolque de cinco ejes,
        R 6 = Remolque de seis ejes,
        D 1 = Dolly de un eje,
        D 2 = Dolly de dos ejes,
        G A = Grúa Tipo A,
        G B = Grúa Tipo B,
        G C = Grúa Tipo C,
        G D = Grúa Tipo D,
        G I = Grúa Industrial,
        VAGONETA,
        AUTOMOVIL,
        MIDIBUS,
        CAMIONETA',
        'nada ~1',
        'nada ~2',
        'nada ~3',
        'En Kilogramos',
        'En Litros',
        'Pasajeros (sin incluir el conductor)',
        '' => 'string',
        '' => 'string',
        '',
        '',
        'CG = Carga General,
        P = Pasaje,
        T = Turismo,
        PQ = Paquetería,
        MP = Carga Especializada (Materiales Peligrosos),
        M = Carga Especializada (Automóviles si rodar),
        FV = Carga Especializada (Fondos y Valores),
        G =  Grúas de Arrastre y/o salvamento',
        'C = Cargado
        V = Vacío',
        '',
        'A = Aprobado
        R = Rechazado
        C = Cancelado',
    );

    $header3 = array(
        'Alfanumérico', 'Alfanumérico', 'Fecha (dd/mm/aaaa)', 'Fecha (dd/mm/aaaa)', 'Numérico (Sin Comas, ni puntos)', 'Alfanumerico (No debe contener comillas (") y/o apostrofes (\'))', 'Alfanumerico (12 ó 13 caracteres)', 'Alfanumerico (No se deben incluir guión (-), y/o puntos, en el caso de tener 2 caracteres el dato a incluir deberá separse por un espacio, solo deben ingresarse los datos del catalogo arriba descrito)', 'Alfanumérico', 'Numérico (De longitud 4)', 'Alfanumérico', 'Numérico (Sin Comas, ni puntos)', 'Numérico (Sin Comas, ni puntos)', 'Numérico (Sin Comas, ni puntos)', 'Numérico (Sin Comas, ni puntos)', 'Alfanumérico', 'Numérico (Sin Comas, ni puntos)', 'Alfanumérico', 'Alfanumérico', 'Alfanumerico (No debe contener comillas (") y/o apostrofes (\'))', 'Alfanumérico'
    );

    $writer = new XLSXWriter();
    $sheet_name = 'SIAF';
    $stylesHeader = array(
        'font' => 'Arial', 'font-size' => 10, 'font-style' => 'bold', 'border' => 'left,right,top,bottom', 'border-style' => 'thin', 'wrap_text' => true, 'halign' => 'center', 'valign' => 'center'
    );

    $stalysRow2 = array('font' => 'Arial', 'font-size' => 10, 'font-style' => 'bold', 'border' => 'left,right,top,bottom', 'wrap_text' => true, 'halign' => 'center', 'valign' => 'center');
    $stalysRow22 = array('font' => 'Arial', 'font-size' => 10, 'font-style' => 'bold', 'border' => 'left,right,top,bottom', 'wrap_text' => true, 'align-text' => 'left', 'halign' => 'left', 'valign' => 'left');
    $stalysRow3 = array('font' => 'Arial', 'font-size' => 10, 'font-style' => 'bold', 'border' => 'left,right,top,bottom', 'wrap_text' => true, 'halign' => 'center', 'valign' => 'center');


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

    $writer->writeSheetHeader($sheet_name, $headerVacio, ['widths' => [18, 18, 18, 18, 18, 35, 35, 18, 35, 35, 20, 20, 20, 20, 20, 20, 20, 25, 25, 25, 25, 25, 25, 25], $stylesHeader, $stylesHeader, $stylesHeader, $stylesHeader, $stylesHeader, $stylesHeader, $stylesHeader, $stylesHeader, $stylesHeader, $stylesHeader, $stylesHeader, $stylesHeader, '', '', $stylesHeader, $stylesHeader, $stylesHeader, $stylesHeader, $stylesHeader, $stylesHeader, $stylesHeader, $stylesHeader, $stylesHeader, $stylesHeader]);
    $writer->writeSheetRow($sheet_name, $header2, [['height' => 530, $stalysRow22], $stalysRow22, $stalysRow2, $stalysRow2, $stalysRow2, $stalysRow2, $stalysRow2, $stalysRow22, $stalysRow22, $stalysRow22, $stalysRow22, $stalysRow2, $stalysRow2, $stalysRow2, $stalysRow2, $stalysRow2, $stalysRow2, $stalysRow2, $stalysRow2, $stalysRow2, $stalysRow2, $stalysRow2, $stalysRow2, $stalysRow2, $stalysRow2, $stalysRow2, $stalysRow2]);
    $writer->markMergedCell($sheet_name, $start_row = 0, $start_col = 0, $end_row = 1, $end_col = 0);
    $writer->markMergedCell($sheet_name, $start_row = 0, $start_col = 1, $end_row = 1, $end_col = 1);
    $writer->markMergedCell($sheet_name, $start_row = 0, $start_col = 2, $end_row = 1, $end_col = 2);
    $writer->markMergedCell($sheet_name, $start_row = 0, $start_col = 3, $end_row = 1, $end_col = 3);
    $writer->markMergedCell($sheet_name, $start_row = 0, $start_col = 4, $end_row = 1, $end_col = 4);
    $writer->markMergedCell($sheet_name, $start_row = 0, $start_col = 5, $end_row = 0, $end_col = 6);
    $writer->markMergedCell($sheet_name, $start_row = 0, $start_col = 6, $end_row = 0, $end_col = 6);
    $writer->markMergedCell($sheet_name, $start_row = 0, $start_col = 8, $end_row = 1, $end_col = 8);
    $writer->markMergedCell($sheet_name, $start_row = 0, $start_col = 8, $end_row = 1, $end_col = 8);
    $writer->markMergedCell($sheet_name, $start_row = 0, $start_col = 9, $end_row = 1, $end_col = 9);
    $writer->markMergedCell($sheet_name, $start_row = 0, $start_col = 10, $end_row = 1, $end_col = 10);
    $writer->markMergedCell($sheet_name, $start_row = 0, $start_col = 11, $end_row = 0, $end_col = 13);
    $writer->markMergedCell($sheet_name, $start_row = 0, $start_col = 11, $end_row = 1, $end_col = 11);
    $writer->markMergedCell($sheet_name, $start_row = 0, $start_col = 12, $end_row = 1, $end_col = 12);
    $writer->markMergedCell($sheet_name, $start_row = 0, $start_col = 14, $end_row = 1, $end_col = 14);
    $writer->markMergedCell($sheet_name, $start_row = 0, $start_col = 15, $end_row = 1, $end_col = 15);
    $writer->markMergedCell($sheet_name, $start_row = 0, $start_col = 16, $end_row = 1, $end_col = 16);
    $writer->markMergedCell($sheet_name, $start_row = 0, $start_col = 19, $end_row = 1, $end_col = 19);

    $writer->writeSheetRow($sheet_name, $header3, $stalysRow3, $stalysRow3, $stalysRow3, $stalysRow3, $stalysRow3, $stalysRow3, $stalysRow3, $stalysRow3, $stalysRow3, $stalysRow3, $stalysRow3, $stalysRow3, $stalysRow3, $stalysRow3, $stalysRow3, $stalysRow3, $stalysRow3, $stalysRow3, $stalysRow3, $stalysRow3, $stalysRow3, $stalysRow3);
    $writer->writeSheetRow($sheet_name, $row_vacio);

    $array = array();

    foreach ($query->result() as $row) {
        $array[0] = '';
        $array[1] = $row->folio;
        $array[2] = $row->fecha;
        $array[3] = $row->fecha_ant;
        $array[4] = $row->kilometraje;
        $array[5] = $row->cliente;
        $array[6] = $row->rfc;
        $array[7] = $row->tipo_vehiculo;
        $array[8] = $row->num_serie;
        $array[9] = $row->anio;
        $array[10] = $row->marca;
        $array[11] = $row->peso;
        $array[12] = $row->litros;
        $array[13] = $row->pasajeros;
        $array[14] = $row->tipo_vehiculo;
        $array[15] = $row->num_placas;
        $array[16] = $row->tarjeta_circ;
        $array[17] = $row->tipo_servicio;
        $array[18] = $row->estatus_unidad;
        $array[19] = $row->tecnico;
        $array[20] = $row->estatus;
        $writer->writeSheetRow($sheet_name, $array);
    }

    $writer->writeToStdOut();
    exit();
}
