<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: POST, GET, PUT, OPTIONS");
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class OrdenesServicios extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        /* Se agregar la conexion a la base de datos a toda la clase */
        $this->load->database();
        $this->load->model("OrdenesServicios_model");
    }

    /* GET - Listado de Ordenes  */
    public function listado_get()
    {
        $respuesta = $this->OrdenesServicios_model->listado($this->get());
        if ($respuesta["error"] === false) {
            $this->response($respuesta['registros'], 200);
        } else {
            $this->response($respuesta['registros'], 400);
        }
    }

    /* POST - Inserta registro en Tabla Ordenes */
    public function agregar_modificar_post()
    {
        $datos_orden = $this->post();
        $respuesta = $this->OrdenesServicios_model->agregar_modificar($datos_orden);
        if ($respuesta["error"] === false) {
            $this->response($respuesta, 200);
        } else {
            $this->response($respuesta, 400);
        }
    }

    public function desactivar_put()
    {
        /* Obtiene parámetros */
        $orden_servicio_id = $this->put("orden_servicio_id");
        $respuesta = $this->OrdenesServicios_model->desactivar($orden_servicio_id);
        if ($respuesta["error"] === false) {
            $this->response($respuesta, 200);
        } else {
            $this->response($respuesta, 400);
        }
    }

    public function excel_reportes_servicios_ordenes_post()
    {
        $this->load->helper('excel_reportes_servicios_ordenes');
        excel_reportes_servicios_ordenes($this->post());
    }

    public function excel_reporte_numero_servicios_post()
    {
        $this->load->helper('excel_numero_servicios');
        excel_reporte_numero_servicios($this->post());
    }
}
