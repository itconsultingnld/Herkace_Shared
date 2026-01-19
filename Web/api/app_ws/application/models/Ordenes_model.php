<?php
$GLOBALS['consecutivo'] = 0;
class Ordenes_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
   
    public function cliente_to_orden($datos)
    {
        $data_limpia = array(
            'cliente_id' => (int)$datos['cliente_id'],
        );
        $this->db->trans_begin();
        $this->db->where('orden_id', $datos['orden_id'])->set($data_limpia)->update('ordenes');
        /* verificacion de la transaccion */
        if ($this->db->trans_status() === false) {
            $respuesta = array(
                'registrado' => false,
                'error' => true,
                'mensaje' => 'Error en insercion.'
            );
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
            $respuesta = array(
                'registrado' => true,
                'error' => false,
                'mensaje' => 'Se inserto el registro'
            );
        }
        return $respuesta;
    }

    public function generarNumOrden($datos){
        $fecha = datetimeMatamoros();
        $fecha_chida = $fecha->format('Y-m-d');
        $hora = $fecha->format('H:i:s');
        $fechaMatamoros = $fecha->format('ym');
        $consecutivo = $this->obtenerConsecutivo();
        $numOrden = $fechaMatamoros . $consecutivo;
        $query = $this->db->query('select num_orden from ordenes order by num_orden desc limit 1');
        if ($query) {
            if ($query->num_rows() > 0) {
                $num_orden = $query->row();
                $num_orden = $num_orden->num_orden;
                $num_orden_fecha = substr($num_orden,0,4);
                $num_orden_consecutivo = (int) substr($num_orden,4);
                if($fechaMatamoros == $num_orden_fecha){
                    $num_orden_consecutivo++;
                    $numOrden = $num_orden_fecha . sprintf('%03d',$num_orden_consecutivo);
                } else {
                    $numOrden = $fechaMatamoros . sprintf('%03d',0);
                }
            } else {
                $numOrden = $fechaMatamoros . sprintf('%03d',0);
            }
        } else {
            $respuesta = array(
                'orden_id' => 0,
                'num_orden' => "",
                'mensaje' => 'Error en insercion.',
                'error' => true
            );
            return $respuesta;
        }
        
        $obj = array(
            'num_orden' => $numOrden,
            'fecha' => $fecha_chida,
            'hora'=> $hora,
            'usuario_id' => $datos['usuario_id'],
        );
        $this->db->trans_begin();
        $this->db->insert('ordenes',$obj);
       
        if ($this->db->trans_status() === false) { 
            
            $respuesta = array(
                'orden_id' => 0,
                'num_orden' => "",
                'mensaje' => 'Error en insercion.',
                'error' => true
            );
            $this->db->trans_rollback();
        } else {
            $orden_id = $this->db->insert_id();
            $this->db->trans_commit();
            $respuesta = array(
                'orden_id' => $orden_id,
                'num_orden' => $numOrden,
                'fecha' => $fecha_chida,
                'hora' => $hora,
                'usuario_id'=> $datos['usuario_id'],
                'mensaje' => 'Se genero el trans',
                'error' => false
            );
        }
        return $respuesta;

    }

    function obtenerConsecutivo() {
        $numero = sprintf('%03d',$GLOBALS['consecutivo']);
        $GLOBALS['consecutivo']++;
        return $numero;
    }

    public function listado()
    {
        $query = $this->db->select("*")->from("ordenes")->order_by('num_orden','desc')->get();
        if ($query->num_rows() >= 0) {
            $registros = $query->result();
            foreach ($registros as $row) {
                $row->orden_id = (int) $row->orden_id;
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
        $query = $this->db->select("*")->from("vw_ordenes")->order_by('num_orden','desc')->get();
        if ($query->num_rows() >= 0) {
            $registros = $query->result();
            foreach ($registros as $row) {
                $row->orden_id = (int) $row->orden_id;
                $row->cliente_id = (int) $row->cliente_id;
                $row->usuario_id_vendedor = (int) $row->usuario_id_vendedor;
                $row->cerrada = boolval((int) $row->cerrada);
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

    public function listado_vw_filtrado($datos)
    {
        $where = array();
        $fecha_inicial = $datos['fecha_inicial'];
        if ($fecha_inicial != '') {
            $where['fecha >='] = $fecha_inicial;
        }
        $fecha_final = $datos['fecha_final'];
        if ($fecha_final != '') {
            $where['fecha <='] = $fecha_final;
        }
        $num_inicial = $datos['num_inicial'];
        if ($num_inicial != '') {
            $where['num_orden >='] = $num_inicial;
        }
        $num_final = $datos['num_final'];
        if ($num_final != '') {
            $where['num_orden <='] = $num_final;
        }
        $cliente = $datos['cliente'];
        if ($cliente != '') {
            $where['nombre'] = $cliente;
        }
        $query = $this->db->select("*")->from("vw_ordenes")->where($where)->order_by('num_orden','asc')->get();
        $registros = array();
        if ($query->num_rows() >= 0) {
            $registros = $query->result();
            foreach ($registros as $row) {
                $row->orden_id = (int) $row->orden_id;
                $row->cliente_id = (int) $row->cliente_id;
                $row->cerrada = boolval((int) $row->cerrada);
            }
            $respuesta = array(
                'registros' => $registros,
                'error' => false,
            );
        } else {
            $respuesta = array(
                'registros' => $registros,
                'error' => true,
            );
        }
        return $respuesta;
    }

    public function agregar($datos)
    {
        $data_limpia = array(
            'num_orden' => $datos['num_orden']
        );
        $this->db->trans_begin();
        $this->db->insert('ordenes', $data_limpia);
        /* verificacion de la transaccion */
        if ($this->db->trans_status() === false) {
            $respuesta = array(
                'mensaje' => 'Error en insercion.',
                'error' => true
            );
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
            $respuesta = array(
                'mensaje' => 'Se inserto el registro',
                'error' => false
            );
        }
        return $respuesta;
    }

    public function orden_por_id($idusuario)
    {
        $query = $this->db->select("*")->from("ordenes")->where('cliente_id', $idusuario)->get();
        if ($query->num_rows() >= 0) {
            $respuesta = array(
                'registros' => $query->row(),
                'error' => false
            );
        } else {
            $respuesta = array(
                'registros' => $query->row(),
                'error' => false
            );
        }
        return $respuesta;
    }

    public function modificar($datos)
    {
        $data_limpia = array(
            'cliente_id' => (int)$datos['cliente_id'],
            'condiciones' => $datos['condiciones'],
            'usuario_id_vendedor' => (int)$datos['usuario_id_vendedor'],
        );
        $this->db->trans_begin();
        /* se actualiza la tabla */
        $this->db->where('orden_id', (int)$datos['orden_id'])->set($data_limpia)->update('ordenes');
        /* verificacion de la transaccion */
        if ($this->db->trans_status() === false) {
            $respuesta = array(
                'mensaje' => 'Error en actualizacion',
                'error' => true,
                'registrado' => false,
            );
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
            $respuesta = array(
                'mensaje' => 'Se actualizo el registro',
                'error' => false,
                'registrado' => true,
            );
        }
        return $respuesta;
    }

    public function cerrar($orden_id)
    {
        $data_limpia = array(
            'cerrada' => 1
        );
        $this->db->trans_begin();
        /* se actualiza la tabla */
        $this->db->where('orden_id', $orden_id)->set($data_limpia)->update('ordenes');
        /* verificacion de la transaccion */
        if ($this->db->trans_status() === false) {
            $respuesta = array(
                'mensaje' => 'Error en actualizacion',
                'error' => true,
                'registrado' => false,
            );
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
            $respuesta = array(
                'mensaje' => 'Orden cerrada correctamente',
                'error' => false,
                'registrado' => true,
            );
        }
        return $respuesta;
    }

    public function desactivar($orden_id)
    {
        $data_device = array(
            'activo' => 0,
        );
        $this->db->trans_begin();

        /* se actualiza la tabla */

        $this->db->where('orden_id', $orden_id)->set($data_device)->update('ordenes');
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
