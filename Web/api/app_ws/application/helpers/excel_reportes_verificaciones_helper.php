<?php

require_once(APPPATH . "/third_party/Psr/autoloader.php");
require_once(APPPATH . "/third_party/PhpSpreadsheet-1.8.2/autoloader.php");

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

function excel_reportes_verificaciones($verificaciones)
{
    $dt = datetimeMatamoros();
    $fecha = $dt->format("Y-m-d");
    $hora = $dt->format("H:i");

    $CI = &get_instance();
    $CI->load->database();

    $header = array(
        'No.',
        'CLIENTE',
        'UNIDAD',
        'SERIE',
        'PLACA',
        'TARJETA',
        'EC',
        'FM',
        'No. ORDEN'
    );

    $spreadsheet = new Spreadsheet();

    $style_titulo = [
        'font' => [
            'name' => 'Arial',
            'size'  => 14,
            'bold' => true,
        ],
        'borders' => [
            'left' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
            'right' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
            'bottom' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
            'top' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
        ],
    ];
    $style_fh = [
        'font' => [
            'name' => 'Arial',
            'size'  => 10,
            'bold' => true,
        ],
    ];
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
    $style_center = [
        'font' => [
            'name' => 'Arial',
            'size'  => 10,
            'bold' => false,
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
    $style_nada = [
        'borders' => [
            'left' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_NONE,
            ],
            'right' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_NONE,
            ],
            'bottom' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_NONE,
            ],
            'inside' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_NONE,
            ],
        ],
    ];
    $style_nada_ext = [
        'borders' => [
            'left' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_NONE,
            ],
            'right' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_NONE,
            ],
            'bottom' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_NONE,
            ],
            'top' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_NONE,
            ],
        ],
    ];

    $myWorkSheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'Reportes órdenes');
    $spreadsheet->addSheet($myWorkSheet, 0);
    $spreadsheet->removeSheetByIndex(1);

    $activeWorksheet = $spreadsheet->getActiveSheet();

    $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(4);
    $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(22);
    $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(9);
    $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(19);
    $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(8);
    $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(11);
    $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(3);
    $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(4);
    $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(14);

    $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
    $drawing->setName('Logo');
    $drawing->setDescription('Logo');
    $drawing->setPath(rutaBase() . 'assets' . rutaDivisor() . 'images' . rutaDivisor() . 'herkace_logo.png');
    $drawing->setCoordinates('A1');
    $drawing->setOffsetX(3);
    $drawing->setOffsetY(3);
    $drawing->setHeight(135);
    $drawing->setWorksheet($activeWorksheet);

    $spreadsheet->getActiveSheet()->mergeCells('C3:I3');
    $spreadsheet->getActiveSheet()->mergeCells('C5:I5');

    $activeWorksheet->setCellValue('C3', 'GESTORES AMBIENTALES HERKACE SA DE CV');
    $activeWorksheet->setCellValue('C5', 'LISTA DE VERIFICACIONES EN INICIO');

    $activeWorksheet->getStyle('C3:I5')->applyFromArray($style_titulo);

    $activeWorksheet->setCellValue('F8', 'FECHA:');
    $activeWorksheet->setCellValue('I8', '✓');

    $activeWorksheet->setCellValue('F9', 'HORA:');

    $activeWorksheet->getStyle('F8:I9')->applyFromArray($style_fh);

    $activeWorksheet->fromArray($header, null, 'A11');

    $activeWorksheet->getStyle('A11:I19')->applyFromArray($style_header);

    $array = array();

    $numero_row = 0;

    foreach ($verificaciones as $row) {
        $numero_row_xlsx = $numero_row + 12;
        if ($row->tipo_verificacion == 'NOM-EM-167') {
            $ec = '✓';
        } else {
            $ec = '';
        }
        if ($row->tipo_verificacion == 'FISICO-MECANICO') {
            $fm = '✓';
        } else {
            $fm = '';
        }
        $array[0] = $row->folio;
        $array[1] = $row->cliente;
        $array[2] = $row->tipo_unidad_verificacion;
        $array[3] = $row->num_serie;
        $array[4] = $row->num_placas;
        $array[5] = $row->tarjeta_circ;
        $array[6] = $ec;
        $array[7] = $fm;
        $array[8] = $row->orden;
        $activeWorksheet->fromArray($array, null, "A$numero_row_xlsx");
        $numero_row++;
    }

    $activeWorksheet->getStyle('A12:I' . ($numero_row + 12))->applyFromArray($style);
    $activeWorksheet->getStyle('G12:H' . ($numero_row + 12))->applyFromArray($style_center);

    $orden_ant = $spreadsheet->getActiveSheet()->getCell('I12')->getValue();
    for ($i = 11; $i <= $numero_row + 12; $i++) {
        $cell_act = "I$i";
        $orden_act = $spreadsheet->getActiveSheet()->getCell($cell_act)->getValue();
        if ($orden_act == $orden_ant) {
            $activeWorksheet->setCellValue($cell_act, '');
            $activeWorksheet->getStyle($cell_act)->applyFromArray($style_nada_ext);
        } else {
            $orden_ant = $orden_act;
        }
    }

    $activeWorksheet->getStyle('I' . ($numero_row + 12))->applyFromArray($style_nada_ext);
    $activeWorksheet->getStyle('A' . ($numero_row + 12) . ':I' . ($numero_row + 100))->applyFromArray($style_nada);

    $activeWorksheet->setSelectedCells('A1');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
}
