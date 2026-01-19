<?php
include_once 'xlsxwriter.class.php';

function excel_numero_ordenes($nums)
{
    $CI = &get_instance();
    $CI->load->database();

    if ($nums == '') {
        $nums = '0';
    }

    $queryNums = $CI->db->query('select * from vw_numero_ordenes where num_orden in (' . $nums . ')');

    header('Content-disposition: attachment; filename="' . XLSXWriter::sanitize_filename('Número de órdenes.xlsx') . '"');
    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
    header('Content-Transfer-Encoding: binary');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');

    $header = array(
        'ORDEN DE SERVICIO' => 'integer',
        'CLIENTE' => 'string',
        'TOTAL' => 'string',
        'E.C' => 'string',
        'CFM' => 'string',
        'A' => 'string',
        'ALTA EC' => 'string',
        'ALTA CFM' => 'string',
        'ALTA A' => 'string',
    );
    $writer = new XLSXWriter();

    $style = array('font' => 'Arial', 'font-size' => 10, 'border' => 'left,right,top,bottom', 'border-style' => 'thin');

    $style_h = $style;
    $style_h['wrap_text'] = true;
    $style_h['font-style'] = 'bold';

    $style_h_c = $style_h;
    $style_h_c['halign'] = 'center';

    $colores = ['', '', '#a29f9c', '#b2aeab', '#928e8c', '#817d7e', '#aaa6a7', '#8b868c', '#817d7e'];

    $styles = [
        $style, $style
    ];

    $styles_totales = $styles;

    for ($i = 2; $i <= 8; $i++) {
        $style_color = $style;
        $style_color['fill'] = $colores[$i];
        $style['halign'] = 'right';
        $style_color['halign'] = 'center';
        array_push($styles, $style_color);
        array_push($styles_totales, $style);
    }

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

    $writer->writeSheetHeader('Número de órdenes', $header, ['widths' => [11, 38, 8, 8, 8, 8, 8, 8, 8], $style_h, $style_h, $style_h, $style_h, $style_h, $style_h, $style_h_c, $style_h_c, $style_h_c]);

    $array = array();
    $orden_ant = 0;
    $total_orden = 0;
    $totales = array(0, 0, 0, 0, 0, 0, 0);

    $rows_cant = 0;

    foreach ($queryNums->result() as $row) {
        $orden = $row->num_orden;
        if ($orden != $orden_ant || $orden_ant == 0) {
            if ($orden_ant != 0) {
                $array[2] = $total_orden;
                $totales[0] = $totales[0] + $total_orden;
                $writer->writeSheetRow('Número de órdenes', $array, $styles);
                $rows_cant++;
            }
            $orden_ant = $orden;
            $total_orden = 0;
            $array[0] = $row->num_orden;
            $array[1] = $row->cliente;
            $array[2] = '0';
            $array[3] = '0';
            $array[4] = '0';
            $array[5] = '0';
            $array[6] = '0';
            $array[7] = '0';
            $array[8] = '0';
        }
        if ($row->servicio_id > 0) {
            $total_orden += $row->total;
        }
        switch ($row->servicio_id) {
            case 1:
                $array[4] = $row->total;
                $totales[2] = $totales[2] + $row->total;
                break;
            case 2:
                $array[3] = $row->total;
                $totales[1] = $totales[1] + $row->total;
                break;
            case 3:
                $array[5] = $row->total;
                $totales[3] = $totales[3] + $row->total;
                break;
            case 4:
                $array[7] = $row->total;
                $totales[5] = $totales[5] + $row->total;
                break;
            case 5:
                $array[8] = $row->total;
                $totales[6] = $totales[6] + $row->total;
                break;
            case 6:
                $array[6] = $row->total;
                $totales[4] = $totales[4] + $row->total;
                break;
        }
    }

    $array[2] = $total_orden;
    $totales[0] = $totales[0] + $total_orden;
    $writer->writeSheetRow('Número de órdenes', $array, $styles);
    $rows_cant++;

    $array[0] = '';
    $array[1] = '';
    $array[2] = '';
    $array[3] = '';
    $array[4] = '';
    $array[5] = '';
    $array[6] = '';
    $array[7] = '';
    $array[8] = '';

    for ($i = 1; $i <= 3; $i++) {
        $writer->writeSheetRow('Número de órdenes', array('', '', '', '', '', '', '', '', ''), $styles);
    }

    $array = array('', 'TOTAL');
    for ($i = 0; $i < count($totales); $i++) {
        array_push($array, $totales[$i]);
    }

    $writer->writeSheetRow('Número de órdenes', $array, $styles_totales);

    $array = array('', 'PORCENTAJE', '');
    $total = $totales[0];
    for ($i = 1; $i < count($totales); $i++) {
        if ($total == 0) {
            $pctj = 0;
        } else {
            $pctj = $totales[$i] * 100 / $total;
        }
        array_push($array, number_format($pctj, 2));
    }

    $writer->writeSheetRow('Número de órdenes', $array, $styles_totales);

    $writer->writeToStdOut();
    exit();
}
