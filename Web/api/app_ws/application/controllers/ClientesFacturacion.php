<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: POST, GET, PUT, OPTIONS");
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class ClientesFacturacion extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        /* Se agregar la conexion a la base de datos a toda la clase */
        $this->load->database();
        $this->load->model("ClientesFacturacion_model");
    }

    /* GET - Listado */
    public function listado_get()
    {
        $respuesta = $this->ClientesFacturacion_model->listado();
        if ($respuesta["error"] === false) {
            $this->response($respuesta['registros'], 200);
        } else {
            $this->response($respuesta['registros'], 400);
        }
    }

    public function listado_vw_get()
    {
        $respuesta = $this->ClientesFacturacion_model->listado_vw();
        if ($respuesta["error"] === false) {
            $this->response($respuesta['registros'], 200);
        } else {
            $this->response($respuesta['registros'], 400);
        }
    }

    public function desactivar_put()
    {
        /* Obtiene parámetros */
        $respuesta = $this->ClientesFacturacion_model->desactivar($this->put());
        if ($respuesta["error"] === false) {
            $this->response($respuesta, 200);
        } else {
            $this->response($respuesta, 400);
        }
    }

    /* GET por ID */
    public function get_por_id_get()
    {
        $idusuario = $this->uri->segment(3);
        $respuesta = $this->ClientesFacturacion_model->get_por_id($idusuario);
        if ($respuesta["error"] === false) {
            $this->response($respuesta['registro'], 200);
        } else {
            $this->response($respuesta['registro'], 400);
        }
    }

    /* PUT - Modificar datos en la tabla */
    public function modificar_put()
    {
        $datos = $this->put();
        $this->form_validation->set_data($datos);
        if ($this->form_validation->run('clientes_facturacion_modificar_put')) {
            $respuesta = $this->ClientesFacturacion_model->modificar($datos);
            if ($respuesta["error"] === false) {
                $this->response($respuesta, 200);
            } else {
                $this->response($respuesta, 400);
            }
        } else {
            $this->response($this->form_validation->get_errores_objeto(), "ERROR_VALIDACION_FORMULARIO");
        }
    }

    public function excel_post()
    {
        $this->load->helper('excel_clientes_facturacion');
        excel_clientes_facturacion();
    }
}
