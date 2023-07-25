<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use League\OAuth2\Client\Provider\Google;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\OAuth;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class MailController extends Controller
{
    private $email;
    private $name;
    private $client_id;
    private $client_secret;
    private $token;
    private $provider;

    public function __construct()
    {
     
        $this->client_id        = env('GOOGLE_API_CLIENT_ID');
        $this->client_secret    = env('GOOGLE_API_CLIENT_SECRET');
        $this->provider         = new Google(
            [
                'clientId'      => $this->client_id,
                'clientSecret'  => $this->client_secret
            ]
        );

    }

    public function sendcredentials(Request $request){
        $receiver = $request->email;
        $name = $request->name;
        $pass = $request->password;
        $this->token = '1//0e35DqS4PoQcQCgYIARAAGA4SNwF-L9IrNMkS7-eOy0BfmD7vJGfEokDDLgKRbJemH82uz6P9_k6EbfhBVvFi4YW0-KcB85_hKew';
        $mail = new PHPMailer(true);

       try {
           $mail->isSMTP();
           $mail->SMTPDebug = SMTP::DEBUG_OFF;
           $mail->Host = 'smtp.gmail.com';
           $mail->Port = 465;
           $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
           $mail->SMTPAuth = true;
           $mail->AuthType = 'XOAUTH2';
           $mail->setOAuth(
               new OAuth(
                   [
                       'provider'          => $this->provider,
                       'clientId'          => $this->client_id,
                       'clientSecret'      => $this->client_secret,
                       'refreshToken'      => '1//0e35DqS4PoQcQCgYIARAAGA4SNwF-L9IrNMkS7-eOy0BfmD7vJGfEokDDLgKRbJemH82uz6P9_k6EbfhBVvFi4YW0-KcB85_hKew',
                       'userName'          => 'capstone0223@gmail.com'
                   ]
               )
           );

           $mail->setFrom('capstone0223@gmail.com','NoReply@Ed-detection');
           $mail->addAddress('reenjie17@gmail.com','Reenjay');
           $mail->Subject = 'ONE TIME PIN';
           $mail->CharSet = PHPMailer::CHARSET_UTF8;
           $body = '<!DOCTYPE html>
           <html lang="en">
           
           <head>
               <meta charset="UTF-8">
               <meta name="viewport" content="width=device-width, initial-scale=1.0">
               <meta http-equiv="X-UA-Compatible" content="ie=edge">
               <title></title>
           </head>
           
           <body >
           
           
                   <h4>Your one-Time-pin is</h4>
           
           
                       
                        <h1>462123</h1>
                
                   <br>
                   <h5>
                       Do not share this to anyone.
                       <br>
           
                       All rights Reserved &middot; 2022
           
                   </h5>
                   <p><br><br><br></p>
           
           </body>
           
           </html>
           
           ';
           $mail->msgHTML($body);
           $mail->AltBody = 'This is a plain text message body';
           if( $mail->send() ) 
           {
            echo 'send';
           } else {
            echo 'not send';
             //  return redirect()->back()->with('error', 'Unable to send email.');
           }
       } catch(Exception $e) {
            return $e;
        //   return redirect()->back()->with('error', 'Exception: ' . $e->getMessage());
       }  

    }
}
