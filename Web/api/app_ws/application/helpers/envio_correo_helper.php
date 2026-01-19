<?php
set_time_limit(120);

function envio_correo_mensaje_unico($destinatario, $asunto, $mensaje)
{
    $destinatarios = array($destinatario);
    return envio_correo_mensaje($destinatarios, $asunto, $mensaje, array());
}

function envio_correo_mensaje($destinatarios, $asunto, $mensaje, $adjuntos)
{
    require APPPATH . '/third_party/PHPMailer/Exception.php';
    require APPPATH . '/third_party/PHPMailer/PHPMailer.php';
    require APPPATH . '/third_party/PHPMailer/SMTP.php';

    $mail = new PHPMailer\PHPMailer\PHPMailer(true); // Passing `true` enables exceptions
    try {
        //Server settings
        // $mail->SMTPDebug = 2; // Enable verbose debug output

        $mail->isSMTP(); // Set mailer to use SMTP
        $mail->Host = 'mail.midominio.com'; // Specify main and backup SMTP servers
        $mail->SMTPAuth = true; // Enable SMTP authentication
        $mail->Username = 'correo@midominio.com'; // SMTP username
        $mail->Password = 'PASSWORD'; // SMTP password
        $mail->SMTPSecure = 'ssl'; // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 465; // TCP port to connect to

        //Recipients
        $mail->setFrom('correo@midominio.com', 'SISTEMA HERKACE');

        foreach ($destinatarios as $des) {
            $mail->addAddress($des);
        }

        foreach ($adjuntos as $nom=>$adj) {
            $mail->addAttachment($adj, $nom);
        }

        $mail->Subject = utf_decode($asunto);

        $mail->Body  = utf_decode($mensaje);

        $mail->send();

        return true;
        //echo 'Message has been sent';
    } catch (Exception) {
        //   echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        return false;
    }
}
