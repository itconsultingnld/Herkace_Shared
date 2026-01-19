<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: POST, GET, PUT, OPTIONS");
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Reportes extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        /* Se agregar la conexion a la base de datos a toda la clase */
        $this->load->database();
    }

    public function excel_reportes_ordenes_verificaciones_post()
    {
        $this->load->helper('excel_reportes_ordenes_verificaciones');
        excel_reportes_ordenes_verificaciones($this->post());
    }

    public function excel_reportes_verificaciones_post()
    {
        $this->load->model("Verificaciones_model");
        $respuesta = $this->Verificaciones_model->listado_vw_filtrado($this->post());
        $this->load->helper('excel_reportes_verificaciones');
        excel_reportes_verificaciones($respuesta['registros']);
    }

    public function excel_reporte_anual_post()
    {
        $this->load->helper('excel_reporte_anual');
        excel_reporte_anual($this->post());
    }

    public function excel_reportes_siaf_post()
    {
        $this->load->model("Verificaciones_model");
        $respuesta = $this->Verificaciones_model->listado_vw_filtrado($this->post());
        $this->load->helper('excel_reportes_siaf');
        excel_reportes_siaf($respuesta['registros']);
    }
}
