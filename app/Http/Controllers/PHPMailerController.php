<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer; 
use PHPMailer\PHPMailer\SMTP; 
use PHPMailer\PHPMailer\Exception;


class PHPMailerController extends Controller
{
    // =============== [ Email ] ===================
    public function email() {
        return view("email");
    }
 
 
    // ========== [ Compose Email ] ================
    public function composeEmail(Request $request) {
        // return response("LLEGO");
        require base_path("vendor/autoload.php");
        $mail = new PHPMailer(true);     // Passing `true` enables exceptions
        
        // Email server settings
            $mail->SMTPDebug = 1;
            $mail->isSMTP();
            $mail->Host = 'c1402801.ferozo.com';             //  smtp host
            $mail->SMTPAuth = true;
            $mail->Username = 'no-reply@tributosaragua.com.ve';   //  sender username
            $mail->Password = '*7WA2oO5wY';       // sender password
            $mail->SMTPSecure = 'tls';                  // encryption - ssl/tls
            $mail->Port = 465;   

            $mail->setFrom('no-reply@tributosaragua.com.ve', 'Tributos Aragua');
            $mail->addAddress('itrequena09@gmail.com');
            $mail->addReplyTo('no-reply@tributosaragua.com.ve', 'Tributos Aragua');

            $mail->isHTML(true);

            $mail->Subject = 'Recuperación de Contraseña - Sistema MNM SETA';
            $mail->Body    = 'Si lo hizo';

            $mail->send();
            

        // try {
 
        //     // Email server settings
        //     $mail->SMTPDebug = 0;
        //     $mail->isSMTP();
        //     $mail->Host = 'c1402801.ferozo.com';             //  smtp host
        //     $mail->SMTPAuth = true;
        //     $mail->Username = 'no-reply@tributosaragua.com.ve';   //  sender username
        //     $mail->Password = '*7WA2oO5wY';       // sender password
        //     $mail->SMTPSecure = 'tls';                  // encryption - ssl/tls
        //     $mail->Port = 465;                          // port - 587/465
 
        //     $mail->setFrom('no-reply@tributosaragua.com.ve', 'Tributos Aragua');
        //     $mail->addAddress($request->post('email'));
        //     // $mail->addCC($request->emailCc);
        //     // $mail->addBCC($request->emailBcc);
 
        //     $mail->addReplyTo('no-reply@tributosaragua.com.ve', 'Tributos Aragua');
 
        //     // if(isset($_FILES['emailAttachments'])) {
        //     //     for ($i=0; $i < count($_FILES['emailAttachments']['tmp_name']); $i++) {
        //     //         $mail->addAttachment($_FILES['emailAttachments']['tmp_name'][$i], $_FILES['emailAttachments']['name'][$i]);
        //     //     }
        //     // }
 
 
        //     $mail->isHTML(true);                // Set email content format to HTML
 
        //     // $mail->Subject = $request->emailSubject;
        //     // $mail->Body    = $request->emailBody;

        //     $mail->Subject = 'Recuperación de Contraseña - Sistema MNM | SETA';
        //     $mail->Body    = 'Si lo hizo';
 
        //     // $mail->AltBody = plain text version of email body;
 
        //     if( !$mail->send() ) {
        //         return back()->with("failed", "Email not sent.")->withErrors($mail->ErrorInfo);
        //     }
            
        //     else {
        //         return back()->with("success", "Email has been sent.");
        //     }
 
        // } catch (Exception $e) {
        //      return back()->with('error','Message could not be sent.');
        // }
    }
}
