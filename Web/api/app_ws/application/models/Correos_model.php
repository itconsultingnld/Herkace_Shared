<?php
class Correos_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function mail_recover_pass($correo, $nueva_pass)
    {
        $this->load->helper('envio_correo');
        $asunto = 'Reestablecimiento de contraseña';
        $mensaje = 'Estimado usuario:';
        $mensaje .= "\r\n";
        $mensaje .= "\r\n";
        $mensaje .= 'A continuación podrá visualizar la nueva contraseña de su cuenta:';
        $mensaje .= "\r\n";
        $mensaje .= "\r\n";
        $mensaje .= $nueva_pass;
        $mensaje .= "\r\n";
        $mensaje .= "\r\n";
        $mensaje .= 'Se recomienda guardar su contraseña en un lugar seguro y no compartirla con nadie.';
        return envio_correo_mensaje_unico($correo, $asunto, $mensaje);
    }
}
