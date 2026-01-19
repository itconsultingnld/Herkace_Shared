<?php
class Configuracion_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function listado_vw()
    {
        $query = $this->db->select("*")->from("vw_configuracion")->get();
        $registros = array();
        if ($query->num_rows() >= 0) {
            $registros = $query->result();
            foreach ($registros as $row) {
                $row->configuracion_id = (int) $row->configuracion_id;
            }
            $respuesta = array(
                'registros' => $registros,
                'error' => false
            );
        } else {
            $respuesta = array(
                'registros' => $registros,
                'error' => true
            );
        }
        return $respuesta;
    }

    public function obtener_por_id_vw($configuracion_id)
    {
        $query = $this->db->select("*")->from("vw_configuracion")->where('configuracion_id', $configuracion_id)->get();
        if ($query->num_rows() >= 0) {
            $registro = $query->row();
            $registro->configuracion_id = (int) $registro->configuracion_id;
            $respuesta = array(
                'registro' => $query->row(),
                'error' => false
            );
        } else {
            $respuesta = array(
                'registro' => array(),
                'error' => false
            );
        }
        return $respuesta;
    }

    public function modificar($datos)
    {
        $data_usuario = array(
            'valor' => $datos['valor'],
        );
        $this->db->trans_begin();
        /* se actualiza la tabla */
        $this->db->where('configuracion_id', (int)$datos['configuracion_id'])->set($data_usuario)->update('configuracion');
        if ($this->db->trans_status() === false) {
            $respuesta = array(
                'mensaje' => 'Error en actualizacion',
                'registrado' => false,
                'error' => true
            );
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
            $respuesta = array(
                'mensaje' => 'Se actualizo el registro',
                'registrado' => true,
                'error' => false
            );
        }
        return $respuesta;
    }
}
