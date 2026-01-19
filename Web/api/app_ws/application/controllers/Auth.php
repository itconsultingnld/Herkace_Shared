<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: POST, GET, PUT, OPTIONS");
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
include APPPATH . '/third_party/jwt/JWT.php';
include APPPATH . '/third_party/jwt/BeforeValidException.php';
include APPPATH . '/third_party/jwt/ExpiredException.php';
include APPPATH . '/third_party/jwt/SignatureInvalidException.php';

use Firebase\JWT\JWT;

class Auth extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        /* Se agregar la conexion a la base de datos a toda la clase */
        $this->load->database();
    }

    public function authenticateUsuInspEmp_post()
    {
        $time = time();
        $key = 'heymynameismohamedaymen';

        $username = $this->post('username');
        $password = $this->post('password');

        $where = array('username' => $username);
        $this->db->select('*');
        $this->db->from('usuarios');
        $this->db->where($where);
        $query = $this->db->get();
        if ($query && $query->num_rows() >= 1) {
            $registro = $query->row();
            if (pass_verify($password, $registro->password)) {
                $activo = boolval((int) $registro->activo);
                if ($activo) {
                    $nombre_completo = $registro->nombre . ' ' . $registro->ape_pat . ' ' . $registro->ape_mat;
                    $token = array(
                        'check' => true,
                        'iat' => $time, /* Tiempo que inició el token */
                        'exp' => $time + 1440, /* Duracion del token */
                        'datos' => array(
                            'message' => 'Autentificado',
                            'nombre' => $nombre_completo,
                            'correo' => $registro->correo,
                            'activo' => $activo,
                            'idusuario' => (int) $registro->usuario_id,
                            'rol_id' => (int) $registro->rol_id
                        )
                    );
                    $token = JWT::encode($token, $key);
                    $respuesta = array(
                        'token' => $token
                    );
                    $status = 200;
                } else {
                    $respuesta = array(
                        'message' => 'El usuario no está activo',
                    );
                    $status = 401;
                }
            } else {
                $respuesta = array(
                    'message' => 'Revise sus credenciales',
                );
                $status = 401;
            }
        } else {
            $respuesta = array(
                'message' => 'Revise sus credenciales',
            );
            $status = 401;
        }
        $this->response($respuesta, $status);
    }

    public function recover_pass_post()
    {
        $username = $this->post('username');
        $where = array('username' => $username);
        $this->db->select('usuario_id, correo');
        $this->db->from('usuarios');
        $this->db->where($where);
        $query = $this->db->get();
        if ($query && $query->num_rows() >= 1) {
            $nueva_pass = randomPassword();
            $reg = $query->row();
            $datos_cambio_pass = array(
                'password' => $nueva_pass
            );
            $idusuario = $reg->usuario_id;
            $this->load->model("Coordinadores_model");
            $respuesta_pass = $this->Coordinadores_model->coordinador_pass($datos_cambio_pass, $idusuario);
            if ($respuesta_pass["error"] === false) {
                $this->load->model("Correos_model");
                $enviado = $this->Correos_model->mail_recover_pass($reg->correo, $nueva_pass);
                if ($enviado) {
                    $respuesta = array(
                        'error' => false,
                        'encontrado' => true,
                        'enviado' => $enviado,
                        'mensaje' => 'Correo enviado exitosamente'
                    );
                } else {
                    $respuesta = array(
                        'error' => false,
                        'encontrado' => true,
                        'enviado' => $enviado,
                        'mensaje' => 'El correo no se ha podido enviar'
                    );
                }
            } else {
                $respuesta = array(
                    'error' => true,
                    'encontrado' => true,
                    'enviado' => false,
                    'mensaje' => 'No se ha realizado el proceso. Intente nuevamente.'
                );
            }
        } else {
            /* Error = false y Enviado = true, ya que no debe indicar si el usuario/correo no existe */
            $respuesta = array(
                'error' => false,
                'encontrado' => false,
                'enviado' => true,
                'mensaje' => 'No se encontró correo'
            );
        }
        if ($respuesta["error"] === false) {
            $this->response($respuesta, 200);
        } else {
            $this->response($respuesta, 400);
        }
    }
}
