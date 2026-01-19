<?php
class TiposServicios_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function listado($filtros)
    {
        $query = $this->db->select("*")->from("tipos_servicios")->where($filtros)->get();
        $registros = array();
        if ($query->num_rows() >= 0) {
            $registros = $query->result();
            foreach ($registros as $row) {
                $row->tipo_servicio_id = (int) $row->tipo_servicio_id;
                $row->activo = boolval((int)$row->activo);
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

    public function agregar($datos)
    {
        $nombre = $datos['nombre'];
        $where = array('nombre' => $nombre);
        $query = $this->db->select("nombre")->from("tipos_servicios")->where($where)->get();
        if ($query->num_rows() > 0) {
            $respuesta = array(
                'error' => false,
                'registrado' => false,
                'mensaje' => 'Este tipo de servicio ya está registrado'
            );
            return $respuesta;
        }
        $data_limpia = array(
            'nomenclatura' => $datos['nomenclatura'],
            'nombre' => $nombre
        );
        $this->db->trans_begin();
        $this->db->insert('tipos_servicios', $data_limpia);
        /* verificacion de la transaccion */
        if ($this->db->trans_status() === false) {
            $respuesta = array(
                'error' => true,
                'registrado' => false,
                'mensaje' => 'Error en insercion.'
            );
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
            $respuesta = array(
                'error' => false,
                'registrado' => true,
                'mensaje' => 'Se inserto el registro'
            );
        }
        return $respuesta;
    }

    public function modificar($datos)
    {
        $nombre = $datos['nombre'];
        $tipo_servicio_id = (int)$datos['tipo_servicio_id'];
        $where = array('nombre' => $nombre, 'tipo_servicio_id !=' => $tipo_servicio_id);
        $query = $this->db->select("nombre")->from("tipos_servicios")->where($where)->get();
        if ($query->num_rows() > 0) {
            $respuesta = array(
                'error' => false,
                'registrado' => false,
                'mensaje' => 'Esta tipo de servicio ya está registrado'
            );
            return $respuesta;
        }
        $data_limpia = array(
            'nomenclatura' => $datos['nomenclatura'],
            'nombre' => $nombre
        );
        $this->db->trans_begin();
        /* se actualiza la tabla */
        $this->db->where('tipo_servicio_id', $tipo_servicio_id)->set($data_limpia)->update('tipos_servicios');
        if ($this->db->trans_status() === false) {
            $respuesta = array(
                'error' => true,
                'registrado' => false,
                'mensaje' => 'Error en actualizacion'
            );
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
            $respuesta = array(
                'error' => false,
                'registrado' => true,
                'mensaje' => 'Se actualizo el registro'
            );
        }
        return $respuesta;
    }

    public function desactivar($datos)
    {
        $tipo_servicio_id = (int)$datos["tipo_servicio_id"];
        $data_limpia = array(
            'activo' => (int)$datos["activo"],
        );
        $this->db->trans_begin();
        /* se actualiza la tabla */
        $this->db->where('tipo_servicio_id', $tipo_servicio_id)->set($data_limpia)->update('tipos_servicios');
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $respuesta = array(
                'cambio' => false,
                'error' => true,
                'mensaje' => 'Error en actualizacion',
            );
        } else {
            $this->db->trans_commit();
            $respuesta = array(
                'cambio' => true,
                'error' => false,
                'mensaje' => 'Actualizado correctamente',
            );
        }
        return $respuesta;
    }
}
