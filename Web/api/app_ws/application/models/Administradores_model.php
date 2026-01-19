<?php
class Administradores_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function listado()
    {
        $where = array('rol_id' => 1);
        $query = $this->db->select("*")->from("usuarios")->where($where)->get();
        $registros = array();
        if ($query->num_rows() >= 0) {
            $registros = $query->result();
            foreach ($registros as $row) {
                $row->usuario_id = (int) $row->usuario_id;
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

    public function desactivar($datos)
    {
        $usuario_id = (int)$datos["usuario_id"];
        $data_limpia = array(
            'activo' => (int)$datos["activo"],
        );
        $this->db->trans_begin();

        /* se actualiza la tabla */

        $this->db->where('usuario_id', $usuario_id)->set($data_limpia)->update('usuarios');
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

    public function agregar($datos)
    {
        $usuario = $datos['username'];
        $correo = $datos['correo'];
        $whereCorreo = array('correo' => $correo);
        $queryCorreo = $this->db->select("correo")->from("usuarios")->where($whereCorreo)->get();
        if ($queryCorreo->num_rows() > 0) {
            $respuesta = array(
                'registrado' => false,
                'error' => false,
                'mensaje' => 'Este correo ya está en uso'
            );
            return $respuesta;
        }
        $where = array('username' => $usuario);
        $query = $this->db->select("username")->from("usuarios")->where($where)->get();
        if ($query->num_rows() > 0) {
            $respuesta = array(
                'registrado' => false,
                'error' => false,
                'mensaje' => 'Este nombre de usuario ya está en uso'
            );
            return $respuesta;
        }
        $data_limpia = array(
            'nombre' => $datos['nombre'],
            'ape_pat' => $datos['ape_pat'],
            'ape_mat' =>  $datos['ape_mat'],
            'correo' => $correo,
            'username' => $usuario,
            'password' => pass_hash($datos['password']),
            'rol_id' => 1
        );
        $this->db->trans_begin();
        $this->db->insert('usuarios', $data_limpia);
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

    public function modificar($datos_admin, $id){
        $usuario = $datos_admin['username'];
        $correo = $datos_admin['correo'];
        $whereCorreo = array('correo' => $correo, 'usuario_id !=' => $id);
        $queryCorreo = $this->db->select("correo")->from("usuarios")->where($whereCorreo)->get();
        if ($queryCorreo->num_rows() > 0) {
            $respuesta = array(
                'registrado' => false,
                'error' => false,
                'mensaje' => 'Este correo ya está en uso'
            );
            return $respuesta;
        }
        $where = array('username' => $usuario, 'usuario_id !=' => $id);
        $query = $this->db->select("username")->from("usuarios")->where($where)->get();
        if ($query->num_rows() > 0) {
            $respuesta = array(
                'registrado' => false,
                'error' => false,
                'mensaje' => 'Este nombre de usuario ya está en uso'
            );
            return $respuesta;
        }
        $data_limpia = array(
            'nombre' => $datos_admin['nombre'],
            'ape_pat' => $datos_admin['ape_pat'],
            'ape_mat' =>  $datos_admin['ape_mat'],
            'correo' => $correo,
            'username' => $usuario,
        );
        $this->db->trans_begin();
        $this->db->where('usuario_id', $id)->set($data_limpia)->update('usuarios');
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
                'mensaje' => 'Se actualizo el registro'
            );
        }
        return $respuesta;
    }
}
