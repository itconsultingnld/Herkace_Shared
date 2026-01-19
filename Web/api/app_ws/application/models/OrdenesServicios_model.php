<?php
class OrdenesServicios_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function listado($filtros)
    {
        $query = $this->db->select("*")->from("ordenes_servicios")->where($filtros)->order_by('orden_servicio_id', 'asc')->get();
        $registros = array();
        if ($query->num_rows() >= 0) {
            $registros = $query->result();
            foreach ($registros as $row) {
                $row->orden_servicio_id = (int) $row->orden_servicio_id;
                $row->orden_id = (int) $row->orden_id;
                $row->vehiculo_id = (int) $row->vehiculo_id;
                $row->tipo_unidad_verificacion_id = (int) $row->tipo_unidad_verificacion_id;
                // $row->servicio_id = (int) $row->servicio_id;
                $row->ec = boolval((int) $row->ec);
                $row->fm = boolval((int) $row->fm);
                // $row->precio_id = (int) $row->precio_id;
                $row->precio_id_ec = (int) $row->precio_id_ec;
                $row->precio_id_fm = (int) $row->precio_id_fm;
                $row->verif_creada = boolval((int)$row->verif_creada);
                $row->activo = boolval((int) $row->activo);
            }
            $respuesta = array(
                'error' => false,
                'registros' => $registros,
            );
        } else {
            $respuesta = array(
                'registros' => $registros,
                'error' => true
            );
        }
        return $respuesta;
    }

    public function agregar_modificar($datos)
    {
        $orden_id = (int) $datos['orden_id'];
        $this->db->trans_begin();
        foreach ($datos['servicios'] as $dato) {
            $ec = datoToBoolean($dato['ec']);
            if ($ec) {
                $precio_id_ec = (int) $dato['select5'];
            } else {
                $precio_id_ec = 0;
            }
            $fm = datoToBoolean($dato['fm']);
            if ($fm) {
                $precio_id_fm = (int) $dato['select6'];
            } else {
                $precio_id_fm = 0;
            }
            $data_limpia = array(
                'tipo_unidad_verificacion_id' => (int) $dato['select1'],
                'vehiculo_id' => (int) $dato['select2'],
                'ec' => (int)$ec,
                'fm' => (int)$fm,
                'precio_id_ec' => $precio_id_ec,
                'precio_id_fm' => $precio_id_fm,
                'orden_id' => $orden_id
            );
            $orden_servicio_id = (int) $dato['orden_servicio_id'];
            if ($orden_servicio_id == 0) {
                $this->db->insert('ordenes_servicios', $data_limpia);
            } else {
                $this->db->where('orden_servicio_id', $orden_servicio_id)->set($data_limpia)->update('ordenes_servicios');
            }
        }
        /* verificacion de la transaccion */
        if ($this->db->trans_status() === false) {
            $respuesta = array(
                'estatus' => false,
                'mensaje' => 'Error al guardar datos',
                'error' => true
            );
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
            $respuesta = array(
                'estatus' => true,
                'mensaje' => 'Los servicios se han guardado correctamente',
                'error' => false
            );
        }
        return $respuesta;
    }

    public function desactivar($orden_servicio_id)
    {
        $data_device = array(
            'activo' => 0,
        );
        $this->db->trans_begin();

        /* se actualiza la tabla */

        $this->db->where('orden_servicio_id', $orden_servicio_id)->set($data_device)->update('ordenes_servicios');
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
