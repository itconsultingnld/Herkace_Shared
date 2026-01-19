<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: POST, GET, PUT, OPTIONS");
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Prefacturas extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        /* Se agregar la conexion a la base de datos a toda la clase */
        $this->load->database();
        $this->load->model("Prefacturas_model");
    }

    public function generar_post()
    {
        $respuesta = $this->Prefacturas_model->generar($this->post());
        if ($respuesta["error"] === false) {
            $this->response($respuesta, 200);
        } else {
            $this->response($respuesta, 400);
        }
    }

    /* PUT - Modificar datos en la tabla */
    public function modificar_put()
    {
        $datos = $this->put();
        $this->form_validation->set_data($datos);
        if ($this->form_validation->run('prefacturas_modificar_put')) {
            $respuesta = $this->Prefacturas_model->modificar($datos);
            if ($respuesta["error"] === false) {
                $this->response($respuesta, 200);
            } else {
                $this->response($respuesta, 400);
            }
        } else {
            $this->response($this->form_validation->get_errores_objeto(), "ERROR_VALIDACION_FORMULARIO");
        }
    }

    public function listado_vw_get()
    {
        $respuesta = $this->Prefacturas_model->listado_vw();
        if ($respuesta["error"] === false) {
            $this->response($respuesta['registros'], 200);
        } else {
            $this->response($respuesta['registros'], 400);
        }
    }

    public function facturar_put()
    {
        $respuesta = $this->Prefacturas_model->facturar($this->put());
        if ($respuesta["error"] === false) {
            $this->response($respuesta, 200);
        } else {
            $this->response($respuesta, 400);
        }
    }
    public function razones_cancelacion_put()
    {
        $respuesta = $this->Prefacturas_model->razones_cancelacion($this->put());
        if ($respuesta["error"] === false) {
            $this->response($respuesta, 200);
        } else {
            $this->response($respuesta, 400);
        }
    }
    public function prefactura_por_id_get()
    {
        $respuesta = $this->Prefacturas_model->prefactura_por_id($this->get());
        if ($respuesta["error"] === false) {
            $this->response($respuesta['datos'], 200);
        } else {
            $this->response($respuesta, 400);
        }
    }

    public function pdf_prefactura_post()
    {
        $this->load->helper('pdf_prefactura');
        pdf_prefactura($this->post());
    }
    public function pdf_factura_post()
    {
        $this->Prefacturas_model->pdf_factura($this->post());
    }
    public function xml_factura_post()
    {
        $this->Prefacturas_model->xml_factura($this->post());
    }
    public function enviar_factura_post()
    {
        $respuesta = $this->Prefacturas_model->enviar_factura($this->post());
        if ($respuesta["error"] === false) {
            $this->response($respuesta, 200);
        } else {
            $this->response($respuesta, 400);
        }
    }

}

