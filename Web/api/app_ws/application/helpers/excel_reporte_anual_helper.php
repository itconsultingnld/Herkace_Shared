<?php

require_once(APPPATH . '/third_party/Psr/autoloader.php');
require_once(APPPATH . '/third_party/PhpSpreadsheet-1.8.2/autoloader.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

function excel_reporte_anual($filtros)
{
    $CI = &get_instance();
    $CI->load->database();

    $where = array('fecha LIKE' => $filtros['anio'] . '%');
    $CI->db->select('*');
    $CI->db->from('vw_reporte_anual');
    $CI->db->where($where);
    $query = $CI->db->get();

    $header = array(
        'Numero_Unidad_Verificadora',
        'Folio_Certificado',
        'Fecha_Verificacion',
        'Fecha_Verificacion_Anterior',
        'Lectura_Odometro',
        'Cliente',
        'RFC',
        'NomenclaturaTipoVehiculo',
        'NumeroSerie',
        'Modelo',
        'Marca',
        'Peso',
        'Litros',
        'Pasajeros',
        'numeroejes',
        'Placas',
        'TarjetaCirculacion',
        'NomenclaturaTipoServicio',
        'VacioCargado',
        'Tecnico',
        'Resultado',
        'Hora',
        'HoraFinal',
        'NumeroControl',
    );

    $spreadsheet = new Spreadsheet();

    $style_header = [
        'font' => [
            'name' => 'Arial',
            'size'  => 10,
            'bold' => true,
        ],
        'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        ],
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
        ],
    ];
    $style = [
        'font' => [
            'name' => 'Arial',
            'size'  => 10,
            'bold' => false,
        ],
        'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
        ],
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
        ],
    ];

    $myWorkSheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'ANUAL');
    $spreadsheet->addSheet($myWorkSheet, 0);
    $spreadsheet->removeSheetByIndex(1);

    $activeWorksheet = $spreadsheet->getActiveSheet();

    $activeWorksheet->getColumnDimension('A')->setWidth(30);
    $activeWorksheet->getColumnDimension('B')->setWidth(19);
    $activeWorksheet->getColumnDimension('C')->setWidth(20);
    $activeWorksheet->getColumnDimension('D')->setWidth(29);
    $activeWorksheet->getColumnDimension('E')->setWidth(20);
    $activeWorksheet->getColumnDimension('F')->setWidth(10);
    $activeWorksheet->getColumnDimension('G')->setWidth(7);
    $activeWorksheet->getColumnDimension('H')->setWidth(28);
    $activeWorksheet->getColumnDimension('I')->setWidth(15);
    $activeWorksheet->getColumnDimension('J')->setWidth(10);
    $activeWorksheet->getColumnDimension('K')->setWidth(9);
    $activeWorksheet->getColumnDimension('L')->setWidth(8);
    $activeWorksheet->getColumnDimension('M')->setWidth(8);
    $activeWorksheet->getColumnDimension('N')->setWidth(12);
    $activeWorksheet->getColumnDimension('O')->setWidth(14);
    $activeWorksheet->getColumnDimension('P')->setWidth(9);
    $activeWorksheet->getColumnDimension('Q')->setWidth(19);
    $activeWorksheet->getColumnDimension('R')->setWidth(27);
    $activeWorksheet->getColumnDimension('S')->setWidth(16);
    $activeWorksheet->getColumnDimension('T')->setWidth(10);
    $activeWorksheet->getColumnDimension('U')->setWidth(13);
    $activeWorksheet->getColumnDimension('V')->setWidth(7);
    $activeWorksheet->getColumnDimension('W')->setWidth(12);
    $activeWorksheet->getColumnDimension('X')->setWidth(17);


    $activeWorksheet->fromArray($header, null, 'A1');

    $activeWorksheet->getStyle('A1:X1')->applyFromArray($style_header);

    $array = array();

    $numero_row = 0;

    foreach ($query->result() as $row) {
        $numero_row_xlsx = $numero_row + 2;
        $numero_ejes = $row->tipo_vehiculo;
        if (preg_match('/^[A-Z] \d$/', $numero_ejes)) {
            $numero_ejes = substr($numero_ejes, 2, 1);
        }
        $array[0] = $row->num_unidad_verificadora;
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
        $array[14] = $numero_ejes;
        $array[15] = $row->num_placas;
        $array[16] = $row->tarjeta_circ;
        $array[17] = $row->tipo_servicio;
        $array[18] = $row->estatus_unidad;
        $array[19] = $row->tecnico;
        $array[20] = $row->estatus;
        $array[21] = hora_formato_hm($row->hora_inicio);
        $array[22] = hora_formato_hm($row->hora_final);
        $array[23] = $row->orden;
        if ($row->estatus == 'C') {
            for ($i = 2; $i <= 23; $i++) {
                $array[$i] = 'CANCELADO';
            }
        }

        $activeWorksheet->fromArray($array, null, "A$numero_row_xlsx");
        $numero_row++;
    }

    $activeWorksheet->getStyle('A2:X' . ($numero_row + 1))->applyFromArray($style);

    $activeWorksheet->setSelectedCells('A1');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
}
