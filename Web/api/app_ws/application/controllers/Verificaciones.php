<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: POST, GET, PUT, OPTIONS");
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
include APPPATH . '/third_party/jwt/JWT.php';
include APPPATH . '/third_party/jwt/BeforeValidException.php';
include APPPATH . '/third_party/jwt/ExpiredException.php';
include APPPATH . '/third_party/jwt/SignatureInvalidException.php';

class Verificaciones extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        /* Se agregar la conexion a la base de datos a toda la clase */
        $this->load->database();
        $this->load->model("Verificaciones_model");
    }

    public function listado_agregar_to_orden_get()
    {
        $cliente_id = (int) $this->uri->segment(3);
        $respuesta = $this->Verificaciones_model->listado_agregar_to_orden($cliente_id);
        if ($respuesta["error"] === false) {
            $this->response($respuesta['registros'], 200);
        } else {
            $this->response($respuesta['registros'], 400);
        }
    }

    public function listado_vw_prefactura_agregar_to_get()
    {
        $respuesta = $this->Verificaciones_model->listado_vw_prefactura_agregar_to();
        if ($respuesta["error"] === false) {
            $this->response($respuesta['registros'], 200);
        } else {
            $this->response($respuesta['registros'], 400);
        }
    }

    public function listado_vw_prefactura_por_prefactura_id_get()
    {
        $prefactura_id = (int) $this->uri->segment(3);
        $respuesta = $this->Verificaciones_model->listado_vw_prefactura_por_prefactura_id($prefactura_id);
        if ($respuesta["error"] === false) {
            $this->response($respuesta['registros'], 200);
        } else {
            $this->response($respuesta['registros'], 400);
        }
    }

    public function listado_vw_get()
    {
        $respuesta = $this->Verificaciones_model->listado_vw($this->get());
        if ($respuesta["error"] === false) {
            $this->response($respuesta['registros'], 200);
        } else {
            $this->response($respuesta['registros'], 400);
        }
    }

    public function listado_vw_prefactura_get()
    {
        $respuesta = $this->Verificaciones_model->listado_vw_prefactura($this->get());
        if ($respuesta["error"] === false) {
            $this->response($respuesta['registros'], 200);
        } else {
            $this->response($respuesta['registros'], 400);
        }
    }

    public function listado_vw_excepto_get()
    {
        $respuesta = $this->Verificaciones_model->listado_vw_excepto($this->get());
        if ($respuesta["error"] === false) {
            $this->response($respuesta['registros'], 200);
        } else {
            $this->response($respuesta['registros'], 400);
        }
    }

    public function listado_vw_filtrado_post()
    {
        $respuesta = $this->Verificaciones_model->listado_vw_filtrado($this->post());
        if ($respuesta["error"] === false) {
            $this->response($respuesta['registros'], 200);
        } else {
            $this->response($respuesta['registros'], 400);
        }
    }

    public function obtener_folio_ant_get()
    {
        $respuesta = $this->Verificaciones_model->obtener_folio_ant($this->get());
        if ($respuesta["error"] === false) {
            $this->response($respuesta, 200);
        } else {
            $this->response($respuesta, 400);
        }
    }

    public function obtener_por_id_get()
    {
        $verificacion_id = (int) $this->uri->segment(3);
        $respuesta = $this->Verificaciones_model->obtener_por_id($verificacion_id);
        if ($respuesta["error"] === false) {
            $this->response($respuesta['registro'], 200);
        } else {
            $this->response($respuesta['registro'], 400);
        }
    }

    public function obtener_por_id_vw_get()
    {
        $verificacion_id = (int) $this->uri->segment(3);
        $respuesta = $this->Verificaciones_model->obtener_por_id_vw($verificacion_id);
        if ($respuesta["error"] === false) {
            $this->response($respuesta['registro'], 200);
        } else {
            $this->response($respuesta['registro'], 400);
        }
    }

    public function agregar_post()
    {
        $datos = $this->post();
        $this->form_validation->set_data($datos);
        if ($this->form_validation->run('verificaciones_agregar_post')) {
            $respuesta = $this->Verificaciones_model->agregar($datos);
            if ($respuesta["error"] === false) {
                $this->response($respuesta, 200);
            } else {
                $this->response($respuesta, 400);
            }
        } else {
            $this->response($this->form_validation->get_errores_objeto(), "ERROR_VALIDACION_FORMULARIO");
        }
    }

    public function autorizar_verificaciones_post()
    {
        $datos = $this->post();
        $respuesta = $this->Verificaciones_model->autorizar_verificaciones($datos);
        if ($respuesta["error"] === false) {
            $this->response($respuesta, 200);
        } else {
            $this->response($respuesta, 400);
        }
    }

    public function agregar_desde_orden_servicio_post()
    {
        $datos = $this->post();
        $respuesta = $this->Verificaciones_model->agregar_desde_orden_servicio($datos);
        if ($respuesta["error"] === false) {
            $this->response($respuesta, 200);
        } else {
            $this->response($respuesta, 400);
        }
    }

    public function modificar_put()
    {
        $datos = $this->put();
        $this->form_validation->set_data($datos);
        if ($this->form_validation->run('verificaciones_modificar_put')) {
            $respuesta = $this->Verificaciones_model->modificar($datos);
            if ($respuesta["error"] === false) {
                $this->response($respuesta, 200);
            } else {
                $this->response($respuesta, 400);
            }
        } else {
            $this->response($this->form_validation->get_errores_objeto(), "ERROR_VALIDACION_FORMULARIO");
        }
    }

    public function asignar_orden_put()
    {
        $respuesta = $this->Verificaciones_model->asignar_orden($this->put());
        if ($respuesta["error"] === false) {
            $this->response($respuesta, 200);
        } else {
            $this->response($respuesta, 400);
        }
    }

    public function asignar_prefactura_put()
    {
        $respuesta = $this->Verificaciones_model->asignar_prefactura($this->put());
        if ($respuesta["error"] === false) {
            $this->response($respuesta, 200);
        } else {
            $this->response($respuesta, 400);
        }
    }

    public function desactivar_put()
    {
        $respuesta = $this->Verificaciones_model->desactivar($this->put());
        if ($respuesta["error"] === false) {
            $this->response($respuesta, 200);
        } else {
            $this->response($respuesta, 400);
        }
    }

    public function excel_post()
    {
        $this->load->helper('excel_verificaciones');
        excel_verificaciones();
    }

    public function pdf_gah_post()
    {
        $this->load->helper('pdf_gah');
        pdf_gah($this->post());
    }

    public function pdf_certificado_post()
    {
        $verificacion_id = (int)$this->post('verificacion_id');
        $respuesta = $this->Verificaciones_model->obtener_por_id($verificacion_id);
        $tipo_unidad_verificacion_id = (int)$respuesta['registro']->tipo_unidad_verificacion_id;
        if (in_array($tipo_unidad_verificacion_id, [2, 4, 5, 6])) {
            $this->load->helper('pdf_certificado_arrastre');
            pdf_certificado_arrastre($verificacion_id);
        } else {
            $this->load->helper('pdf_certificado_camion');
            pdf_certificado_camion($verificacion_id);
        }
    }
}
