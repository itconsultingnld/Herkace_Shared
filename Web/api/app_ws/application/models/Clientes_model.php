<?php
class Clientes_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function clientes($filtros)
    {
        $where = array('activo' => 1);
        if (array_key_exists('tipo', $filtros)) {
            $where['tipo_cliente LIKE'] = '%' . $filtros['tipo'] . '%';
        }
        $query = $this->db->select("*")->from("clientes")->where($where)->get();
        if ($query->num_rows() >= 0) {
            $registros = $query->result();
            foreach ($registros as $row) {
                $row->cliente_id = (int) $row->cliente_id;
                $row->activo = (int) $row->activo;
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

    public function listado_vw()
    {
        $query = $this->db->select("*")->from("vw_clientes")->get();
        $registros = array();
        if ($query->num_rows() >= 0) {
            $registros = $query->result();
            foreach ($registros as $row) {
                $row->cliente_id = (int) $row->cliente_id;
                $row->activo = boolval((int) $row->activo);
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

    public function InsertarClientes($datos)
    {
        $numero_cliente = (int)$datos['numero_cliente'];
        $where = array('numero_cliente' => $numero_cliente);
        $query = $this->db->select("numero_cliente")->from("clientes")->where($where)->get();
        if ($query->num_rows() > 0) {
            $respuesta = array(
                'registrado' => false,
                'error' => false,
                'mensaje' => 'Este número de cliente ya está en uso'
            );
            return $respuesta;
        }
        $data_limpia = array(
            'numero_cliente' => $numero_cliente,
            'tipo_cliente' => $datos['tipo_cliente'],
            'nombre' => $datos['nombre'],
            'rfc' => $datos['rfc'],
            'curp' => $datos['curp'],
            'calle' => $datos['calle'],
            'numero' => $datos['numero'],
            'colonia' => $datos['colonia'],
            'municipio' => $datos['municipio'],
            'estado' => $datos['estado'],
            'codigo_postal' => $datos['codigo_postal'],
        );
        $this->db->trans_begin();
        $this->db->insert('clientes', $data_limpia);
        $item_id = $this->db->insert_id();
        unset($data_limpia['tipo_cliente']);
        $data_limpia['cliente_facturacion_id'] = $item_id;
        $data_limpia['razon_social'] = $data_limpia['nombre'];
        unset($data_limpia['nombre']);
        $data_limpia['numero_ext'] = $data_limpia['numero'];
        unset($data_limpia['numero']);
        $this->db->insert('clientes_facturacion', $data_limpia);
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

    public function clientePorID($idusuario)
    {
        $query = $this->db->select("*")->from("clientes")->where('cliente_id', $idusuario)->get();
        if ($query->num_rows() >= 0) {
            $registro = $query->row();
            $tipo_cliente = $registro->tipo_cliente;
            $registro->tipo_empresa = contiene($tipo_cliente, 'E');
            $registro->tipo_gestor = contiene($tipo_cliente, 'G');
            $respuesta = array(
                'registros' => $registro,
                'error' => false
            );
        } else {
            $respuesta = array(
                'registros' => array(),
                'error' => false
            );
        }
        return $respuesta;
    }

    public function actualizarClientes($datos, $idusuario)
    {
        $numero_cliente = (int)$datos['numero_cliente'];
        $where = array('numero_cliente' => $numero_cliente, 'cliente_id !=' => $idusuario);
        $query = $this->db->select("numero_cliente")->from("clientes")->where($where)->get();
        if ($query->num_rows() > 0) {
            $respuesta = array(
                'registrado' => false,
                'error' => false,
                'mensaje' => 'Este número de cliente ya está en uso'
            );
            return $respuesta;
        }
        $data_usuario = array(
            'numero_cliente' => $numero_cliente,
            'tipo_cliente' => $datos['tipo_cliente'],
            'nombre' => $datos['nombre'],
            'rfc' => $datos['rfc'],
            'curp' => $datos['curp'],
            'calle' => $datos['calle'],
            'numero' => $datos['numero'],
            'colonia' => $datos['colonia'],
            'municipio' => $datos['municipio'],
            'estado' => $datos['estado'],
            'codigo_postal' => $datos['codigo_postal'],
        );
        $this->db->trans_begin();
        /* se actualiza la tabla */
        $this->db->where('cliente_id', $idusuario)->set($data_usuario)->update('clientes');
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

    public function cliente_desactivar($datos)
    {
        $ClienteID = (int)$datos['cliente_id'];
        $activo = (int)$datos['activo'];
        $data_device = array(
            'activo' => $activo,
        );
        $this->db->trans_begin();

        /* se actualiza la tabla */

        $this->db->where('cliente_id', $ClienteID)->set($data_device)->update('clientes');
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

    public function clientes_pop($empresa_id)
    {
        $query = $this->db->query("SELECT t.*, COUNT(ins.inspeccionID) AS conteo FROM clientes t LEFT JOIN inspecciones ins ON t.ClienteID = ins.ClienteID WHERE t.activo = 1 AND t.empresa_id = " . $empresa_id . " GROUP BY t.ClienteID ORDER BY conteo DESC, empresaCliente");
        if ($query->num_rows() >= 0) {
            $registros = $query->result();
            foreach ($registros as $row) {
                $row->ClienteID = (int) $row->ClienteID;
                $row->Activo = (int) $row->Activo;
            }
            $respuesta = array(
                'registros' => $registros,
                'error' => false
            );
        } else {
            $respuesta = array(
                'mensaje' => 'Error en datos',
                'error' => true
            );
        }
        return $respuesta;
    }
}
