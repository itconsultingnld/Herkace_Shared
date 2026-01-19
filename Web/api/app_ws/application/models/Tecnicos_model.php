<?php
class Tecnicos_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function tecnicos()
    {
        $query = $this->db->select("*")->from("tecnicos")->get();
        if ($query->num_rows() >= 0) {
            $registros = $query->result();
            foreach ($registros as $row) {
                $row->tecnico_id = (int) $row->tecnico_id;
                $row->activo = boolval((int) $row->activo);
            }
            $respuesta = array(
                'error' => false,
                'registros' => $registros,
            );
        } else {
            $respuesta = array(
                'mensaje' => 'Error en datos',
                'error' => true
            );
        }
        return $respuesta;
    }

    public function insertar_tecnico($datos)
    {
        $data_limpia = array(
            'nombre' => $datos['nombre'],
            'ape_pat' => $datos['ape_pat'],
            'ape_mat' => $datos['ape_mat'],
            'telefono' => $datos['telefono'],
            'num_control' => $datos['num_control'],
            'activo' => 1
        );
        $this->db->trans_begin();
        $insercion = $this->db->insert('tecnicos', $data_limpia);
        $item_id = $this->db->insert_id();
        /* verificacion de la transaccion */
        if ($this->db->trans_status() === false) {
            $respuesta = array(
                'mensaje' => 'Error en insercion.',
                'id' => 0,
                'registrado' => false,
                'error' => true
            );
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
            $respuesta = array(
                'mensaje' => 'Se inserto el registro',
                'id' => $item_id,
                'registrado' => true,
                'error' => false
            );
        }
        return $respuesta;
    }

    public function tecnico_por_id($tecnico_id)
    {
        $query = $this->db->select("*")->from("tecnicos")->where('tecnico_id', $tecnico_id)->get();
        if ($query->num_rows() >= 0) {
            $respuesta = array(
                'registro' => $query->row(),
                'error' => false
            );
        } else {
            $respuesta = array(
                'mensaje' => 'Error al cargar la consulta',
                'error' => true
            );
        }
        return $respuesta;
    }

    public function actualizar_tecnico($datos, $tecnico_id)
    {
        $data_usuario = array(
            'nombre' => $datos['nombre'],
            'ape_pat' => $datos['ape_pat'],
            'ape_mat' => $datos['ape_mat'],
            'telefono' => $datos['telefono'],
            'num_control' => $datos['num_control']
        );
        $this->db->trans_begin();
        /* se actualiza la tabla */
        $this->db->where('tecnico_id', $tecnico_id)->set($data_usuario)->update('tecnicos');
        if ($this->db->trans_status() === false) {
            $respuesta = array(
                'mensaje' => 'Error en actualizacion',
                'error' => true
            );
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
            $respuesta = array(
                'mensaje' => 'Se actualizo el registro',
                'error' => false
            );
        }
        return $respuesta;
    }

    public function desactivar_tecnico($datos)
    {
        $tecnico_id = (int) $datos['tecnico_id'];
        $activo = (int) $datos['activo'];
        $data_device = array(
            'activo' => $activo,
        );
        $this->db->trans_begin();

        /* se actualiza la tabla */

        $this->db->where('tecnico_id', $tecnico_id)->set($data_device)->update('tecnicos');
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();

            $respuesta = array(
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
