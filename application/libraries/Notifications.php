<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Notifications
{
    protected $CI;

    public function __construct()
    {
        $this->CI = & get_instance();
      $this->CI->load->library('email');
      $this->CI->load->model('Model');
    }

    public function phpMailerLib($value='')
    {
        require_once(APPPATH.'third_party/phpmailer/src/PHPMailer.php');
        require_once(APPPATH.'third_party/phpmailer/src/SMTP.php');
        require_once(APPPATH.'third_party/phpmailer/src/Exception.php');

        $objMail = new PHPMailer\PHPMailer\PHPMailer();
        return $objMail;      
    }

    #Nouveau fonction pour envoi des email en utilisant PHPMailer
    #Added by eriel@mediabox.bi le 06-02-2024 proposed by jules@mediabox.bi le 3-2-2024
    #modified by eriel@mediabox.bi le 21-06-2024
    public function send_mail($to, $subject,$cc_email=array(), $message,$attach = array()) {


        #$this->email = new PHPMailer(true);
        $this->email = $this->phpMailerLib();
        $this->email->isSMTP();
        $this->email->SMTPDebug = 0; // Mettez à 2 pour afficher les erreurs
        $this->email->Host = 'ssl://pongo.afriregister.com'; // Remplacez par votre serveur SMTP
        $this->email->SMTPAuth = true;
        $this->email->Username = 'pms@edrms.gov.bi'; // Remplacez par votre adresse email
        $this->email->Password = 'Pmsmail@2024'; // Remplacez par votre mot de passe
        $this->email->SMTPSecure = 'tls';
        $this->email->Port = 465;        
        try {
            // Destinataire
            $this->email->setFrom('pms@pms.gov.bi', 'Property Management System (PMS)');
            $this->email->addAddress($to);
            if (!empty($cc_email)) {
                foreach ($cc_email as $kcc => $emailc) {
                  if (!empty($emailc)) {
                    // code...
                    $this->email->addCC($emailc);
                  }
                    
                }                
            }
            // Contenu du message
            $this->email->isHTML(true);
            $this->email->CharSet = "UTF-8";

            $this->email->Subject = $subject;
            $this->email->Body    = $message;
            if (!empty($attach)) {
                foreach ($attach as $keyatt => $att)
                #  echo $att;
                $this->email->addAttachment($att);
            }
            // Envoi du message
            $this->email->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    // public function send_mail($to, $subject,$cc_email=array(), $message,$attach = array()) {


    //     #$this->email = new PHPMailer(true);
    //     $this->email = $this->phpMailerLib();
    //     $this->email->isSMTP();
    //     $this->email->SMTPDebug = 0; // Mettez à 2 pour afficher les erreurs http://tausi.afriregister.com:2096
    //     // $this->email->Host = 'ssl://mamba.afriregister.com'; // Remplacez par votre serveur SMTP
    //     $this->email->Host = 'ssl://tausi.afriregister.com'; // Remplacez par votre serveur SMTP
    //     $this->email->SMTPAuth = true;
    //     $this->email->Username = 'pms@pms.gov.bi'; // Remplacez par votre adresse email
    //     $this->email->Password = 'O5TPa+CUrG+q'; // Remplacez par votre mot de passe
    //     $this->email->SMTPSecure = 'tls';
    //     $this->email->Port = 465;        
    //     try {
    //         // Destinataire
    //         $this->email->setFrom('pms@pms.gov.bi', 'Property Management System (PMS)');
    //         $this->email->addAddress($to);
    //         if (!empty($cc_email)) {
    //             foreach ($cc_email as $kcc => $emailc) {
    //               if (!empty($emailc)) {
    //                 // code...
    //                 $this->email->addCC($emailc);
    //               }
                    
    //             }                
    //         }
    //         // Contenu du message
    //         $this->email->isHTML(true);
    //         $this->email->CharSet = "UTF-8";

    //         $this->email->Subject = $subject;
    //         $this->email->Body    = $message;
    //         if (!empty($attach)) {
    //             foreach ($attach as $keyatt => $att)
    //             #  echo $att;
    //             $this->email->addAttachment($att);
    //         }
    //         // Envoi du message
    //         $this->email->send();
    //         return true;
    //     } catch (Exception $e) {
    //         return false;
    //     }
    // }

function send_mail06022024($emailTo = array(), $subjet, $cc_emails = array(), $message, $attach = array()) {

        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'ssl://pongo.afriregister.com';
        $config['smtp_port'] = 465;
        $config['smtp_user'] = 'pms@mediabox.bi';
        $config['smtp_pass'] = 'Medi@@pms!2022';
        $config['mailtype'] = 'html';
        $config['charset'] = 'UTF-8';
        $config['wordwrap'] = TRUE;
        $config['smtp_timeout'] = 20;
        $config['newline'] = "\r\n";
        $this->CI->email->initialize($config);
        $this->CI->email->set_mailtype("html");

    
        $this->CI->email->from('pms@mediabox.bi', 'Property Management System (PMS)');
        $this->CI->email->to($emailTo);
        if (!empty($cc_emails)) {
            foreach ($cc_emails as $key => $value) {
                $this->CI->email->cc($value);
            }
        }
        $this->CI->email->subject($subjet);
        $this->CI->email->message($message);

        if (!empty($attach)) {
            foreach ($attach as $att)
                $this->CI->email->attach($att);
        }
        if (!$this->CI->email->send()) {
            show_error('L\'email n\'a pas été envoyé.');
            // show_error($this->CI->email->print_debugger());
        } 
            else;
       // echo $this->CI->email->print_debugger();
    }




     // function send_mail($emailTo = array(), $subjet, $cc_emails = array(), $message, $attach = array()) {

     //      $config['protocol'] = 'smtp';
     //      $config['smtp_host'] = 'ssl://mamba.afriregister.com';
     //      $config['smtp_port'] = 465;
     //      $config['smtp_user'] = 'iccm@mediabox.bi';
     //      $config['smtp_pass'] = 'iccmcount@2021';
     //      $config['mailtype'] = 'html';
     //      $config['charset'] = 'UTF-8';
     //      $config['wordwrap'] = TRUE;
     //      $config['smtp_timeout'] = 20;
     //      $config['newline'] = "\r\n";
     //      $this->CI->email->initialize($config);
     //      $this->CI->email->set_mailtype("html");


     //      $this->CI->email->from('noc@mediabox.bi', 'PMS');
     //      $this->CI->email->to($emailTo);
     //     // $this->CI->email->bcc('ismael@mediabox.bi');
     //      if (!empty($cc_emails)) {
     //          foreach ($cc_emails as $key => $value) {
     //              $this->CI->email->cc($value);
     //          }
     //      }
     //      $this->CI->email->subject($subjet);
     //      $this->CI->email->message($message);
     //      if (!empty($attach)) {
     //          foreach ($attach as $att)
     //            //print_r($att);die();
     //              $this->CI->email->attach($att);
     //      }
     //      //$this->CI->email->send();
     //      if (!$this->CI->email->send()) {
     //         //show_error($this->CI->email->print_debugger());
     //        return 0;

     //      }else{

     //        return 1;
     //      }
     //      // else;
     //     // echo $this->CI->email->print_debugger();
     //  }










    


   public function smtp_mail($emailTo,$subjet,$cc_emails=NULL,$message,$attach=NULL)
   {     
        $this->CI = & get_instance();
        $this->CI->load->library('email');
        $config['protocol'] = 'smtp';
        //$config['smtp_crypto'] = 'tls';
        $config['smtp_host'] = 'ssl://twiga.afriregister.co.ke';
        $config['smtp_port'] = 465;
        $config['smtp_user'] = 'helpdesk_comesa@mediabox.bi';
        $config['smtp_pass'] = 'mediabox@comesa2018';
        $config['mailtype'] = 'html';
        $config['charset'] = 'UTF-8';
        $config['wordwrap'] = TRUE;
        $config['smtp_timeout'] = 20;
       // $config['priority'] = '1';


        $this->CI->email->initialize($config);
        $this->CI->email->set_mailtype("html");

        // Load email library and passing configured values to email library 
        $this->CI->load->library('email', $config);
        $this->CI->email->set_newline("\r\n");

        $this->CI->email->from('helpdesk_comesa@mediabox.bi', 'MIFA Projet');
        $this->CI->email->to($emailTo);
        //$this->CI->email->bcc('ismael@mediabox.bi');

          if (!empty($cc_emails)) {
          foreach ($cc_emails as $key => $value) {
          $this->CI->email->cc($value);
          }
          }
         
        $this->CI->email->subject($subjet);
        $this->CI->email->message($message);
        
        if(!empty($attach))
          {
            $this->email->attach($attach);
         }

        if (!$this->CI->email->send()) {
            show_error($this->CI->email->print_debugger());
        } else
            echo $this->CI->email->print_debugger();
   }

   public function send_sms($string_tel = NULL,$string_msg)
   {
        $data = '{"urns": ["' . $string_tel . '"],"text":"' . $string_msg . '"}';

        $header = array();
        $header [0] = 'Authorization:Token 8ae3e567ec75aeac4fab42a43c64edf52f0eb736';  //pas d'espace entre Authori et : et Token
        $header [1] = 'Content-Type:application/json';
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, 'https://sms.ubuviz.com/api/v2/broadcasts.json');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        $result = curl_exec($curl);
       // $result = json_decode($result);

        return $result;
   }


   public function generate_UIID($taille)
   {
     $Caracteres = 'ABCDEFGHIJKLMOPQRSTUVXWYZ0123456789'; 
      $QuantidadeCaracteres = strlen($Caracteres); 
      $QuantidadeCaracteres--; 

      $Hash=NULL; 
        for($x=1;$x<=$taille;$x++){ 
            $Posicao = rand(0,$QuantidadeCaracteres); 
            $Hash .= substr($Caracteres,$Posicao,1); 
        }

        return $Hash; 
   }

    public function generate_password($taille)
   {
     $Caracteres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMOPQRSTUVXWYZ0123456789,.@{-_/#'; 
      $QuantidadeCaracteres = strlen($Caracteres); 
      $QuantidadeCaracteres--; 

      $Hash=NULL; 
        for($x=1;$x<=$taille;$x++){ 
            $Posicao = rand(0,$QuantidadeCaracteres); 
            $Hash .= substr($Caracteres,$Posicao,1); 
        }
        return $Hash; 
   }


   //notification sur whatsapp
   public function whatsapp($phone,$message)
   {
// {
//   "created": true,
//   "message": null,
//   "chatId": "25769176202-1585228756@g.us",
//   "groupInviteLink": "https://chat.whatsapp.com/Jwrl92pPGqCJNCafwiZZWl"
// }
    $data = [
    'phone' =>"'".$phone."'", // Receivers phone
    'body' => "".$message."" // Message
            ];

    $json = json_encode($data); // Encode data to JSON
    // URL for request POST /message
    $url = 'https://api.chat-api.com/instance110613/sendMessage?token=44k8xwmfiveo2h53';

    // Make a POST request
    $options = stream_context_create(['http' => [
        'method'  => 'POST',
        'header'  => 'Content-type: application/json',
        'content' => $json
        ]
        ]);
     // Send a request
     $result = file_get_contents($url, false, $options);


   }


   function generatenumber($taille){

     $Caracteres = '0123456789'; 
      $QuantidadeCaracteres = strlen($Caracteres); 
      $QuantidadeCaracteres--; 

      $Hash=NULL; 
        for($x=1;$x<=$taille;$x++){ 
            $Posicao = rand(0,$QuantidadeCaracteres); 
            $Hash .= substr($Caracteres,$Posicao,1); 
        }

        return $Hash; 
   }


    public function generateQrcode($data,$name)
   {
      if(!is_dir('uploads/qrcode')) //create the folder if it does not already exists   
       {
          mkdir('uploads/qrcode',0777,TRUE);
       }

      $Ciqrcode = new Ciqrcode();
      $params['data'] = $data;
      $params['level'] = 'H';
      $params['size'] = 10;
      $params['overwrite'] = TRUE;
      $params['savename'] = FCPATH . 'uploads/qrcode/' . $name . '.png';
      $Ciqrcode->generate($params);
   }
//79588624


   public function send_sms_smpp($string_tel = NULL,$string_msg)
      {
           $data = '{"phone":'. $string_tel . ',"txt_message":"' . $string_msg . '"}';

           $header = array();
           $header [1] = 'Content-Type:application/json';

           $curl = curl_init();
           curl_setopt($curl, CURLOPT_URL, 'http://51.83.236.148:3030/sms');
           curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
           curl_setopt($curl, CURLOPT_POST, true);
           curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
           curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
           $result = curl_exec($curl);
          // $result = json_decode($result);

           return $result;
}





//Fonction pour la generation des folios et volume

    function generate_Volume_folio()
    {

        $val_volume=$this->CI->Model->getRequeteOne('SELECT max(ID_VOLUME) as volume from pms_volume where 1');
      

        $crit=' and ID_VOLUME IS NOT NULL';

        $D=0;
        
        if($val_volume['volume']!=NULL)
        {
            $crit=' and ID_VOLUME='.$val_volume["volume"].'';
        }

        $val_folio=$this->CI->Model->getRequeteOne('SELECT max(VALEUR_FOLIO) as nb_folio_from_one  from pms_folio where 1 '.$crit.'');

        $folio=1;
        $volume=$this->arabicToRoman(1);

        $val_test=0;

        if($val_folio['nb_folio_from_one']!=NULL)
        {
            $val_test=$val_folio['nb_folio_from_one'];
        }



        if ($val_test==200 || $val_test==0)
        {

            $valeur_romain=$this->arabicToRoman($val_volume["volume"]+1);



            $array_volume=array('VALEUR_ROMAIN'=>$valeur_romain);


            $val_new_volume=$this->CI->Model->insert_last_id('pms_volume',$array_volume);
            $volume=$this->arabicToRoman($val_new_volume);

            $array_folio=array('ID_VOLUME'=>$val_new_volume,'VALEUR_FOLIO'=>$folio);


            $val_new_folio=$this->CI->Model->insert_last_id('pms_folio',$array_folio);

            $D=$val_new_folio;
        }
        else
        {


            $folio=$val_test+1;

            $array_folio=array('ID_VOLUME'=>$val_volume["volume"],'VALEUR_FOLIO'=>$folio);

            $val_new_folio=$this->CI->Model->insert_last_id('pms_folio',$array_folio);
            $D=$val_new_folio;

        }


        $data['folio']=$folio;
        $data['volume']=$volume;
        $data['D']=$D;


        return $data;



    }

  
  function arabicToRoman($num=102) {

    $roman = "";
    $map = array(
        'M'  => 1000,
        'CM' => 900,
        'D'  => 500,
        'CD' => 400,
        'C'  => 100,
        'XC' => 90,
        'L'  => 50,
        'XL' => 40,
        'X'  => 10,
        'IX' => 9,
        'V'  => 5,
        'IV' => 4,
        'I'  => 1
    );
    while ($num > 0) {
        foreach ($map as $romanNumeral => $arabicNumeral) {
            if ($num >= $arabicNumeral) {
                $roman .= $romanNumeral;
                $num -= $arabicNumeral;
                break;
            }
        }
    }
    return $roman;
}


}

?>