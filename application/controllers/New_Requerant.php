<?php 

  /**
Eric ndayizeye
   */
      class New_Requerant extends CI_Controller
      {  

          function __construct()
          {
      # code...
             parent::__construct();
         }

        //Fonction principale

         function index()
         {
          
           $data['nationalites']=$this->Model->getRequete('SELECT * FROM countries');
           $data['profiles']=$this->Model->getRequete('SELECT * FROM profiles');
           $this->load->view('New_Requerant_View',$data);
       }

      //Enregistrement des donnees dans la base
function save()
{

   $fullname=$this->input->post('NOM').' '.$this->input->post('PRENOM');
  $ids = $this->input->post('nationalite_id');

   $password = password_hash($this->input->post('PASSWORD1'), PASSWORD_DEFAULT);
   $codepays=$this->Model->getRequeteOne('SELECT CODE_TEL FROM countries WHERE id = '.$ids.' ');
$codepays = (isset($codepays['CODE_TEL'])) ?$codepays['CODE_TEL']: '';
    $data_sf_guard_user_profile=array(
        'email'=>$this->input->post('EMAIL'),
        'username'=>$this->input->post('EMAIL'),   
        'sexe_id'=>$this->input->post('SEXE_ID'),                           
        'NOM'=>$this->input->post('NOM'),
        'PRENOM'=>$this->input->post('PRENOM'),
        'mobile'=>$codepays.$this->input->post('TEL1'),
        'country_code'=>$this->input->post('nationalite_id'),
        'password'=>$password,
        'PROFIL_ID'=>$this->input->post('PROFIL_ID'),
        'is_active'=>1,
        
    );
    
    $id= $this->Model->insert_last_id('sf_guard_user_profile',$data_sf_guard_user_profile);

    $SEXE_ID = ($this->input->post('SEXE_ID')==1) ? "Monsieur" : "Madame";

    $name= $SEXE_ID.' '.$this->input->post('NOM').' '.$this->input->post('PRENOM').'';
 
 $message="Bonjour ".$fullname.",<br>
 Votre compte a été creé avec succès,
 vos identifiants de connexion sont:<br><br>
    - Nom d'utilisateur:".$this->input->post('EMAIL')."<br>
    - Mot de passe:".$this->input->post('PASSWORD1')."<br><br>

 Veuillez cliquez sur le lien suivant pour vous connecter:<br>
 ".base_url('Login')."<br><br>
 Cordialement.";

 $mailTo=$this->input->post('EMAIL');
 $subject='Identifiants de connexion';

 $this->notifications->send_mail($mailTo,$subject,$cc_emails=array(),$message,$attach=array());

 $message = "<div class='alert alert-success text-center'>Enregistrement fait avec succes</div>";
 $this->session->set_flashdata(array('message'=>$message));
 redirect(base_url('Utilisateurs'));
}


function verify_email()
{

 $email=$this->input->post('email');
 $result=$this->Model->getRequeteOne('SELECT email from sf_guard_user_profile where email="'.$email.'" ');

$statut=0;
 if (!empty($result)) 
 {
  $statut=1;
 }
 echo json_decode($statut);
}


    //PERMET L'UPLOAD DE LA SIGNATURE
public function upload_file_signature($input_name)
{
    $nom_file = $_FILES[$input_name]['tmp_name'];
    $nom_champ = $_FILES[$input_name]['name'];
    $ext=pathinfo($nom_champ, PATHINFO_EXTENSION);
    $repertoire_fichier = FCPATH . 'uploads/doc_scanner/';  
    $code=uniqid();
    $name=$code . 'SIGNATURE.' .$ext;
    $file_link = $repertoire_fichier . $name;


        // $fichier = basename($nom_champ);
    if (!is_dir($repertoire_fichier)) {
        mkdir($repertoire_fichier, 0777, TRUE);
    }
    move_uploaded_file($nom_file, $file_link);
    return $name;
}



    //PERMET L'UPLOAD DE L'IMAGE CNI / PASSEPORT
public function upload_file_cni($input_name)
{
    $nom_file = $_FILES[$input_name]['tmp_name'];
    $nom_champ = $_FILES[$input_name]['name'];
    $ext=pathinfo($nom_champ, PATHINFO_EXTENSION);
    $repertoire_fichier = FCPATH . 'uploads/doc_scanner/';
    $code=uniqid();
    $name=$code . 'IMAGE_CNI.' .$ext;
    $file_link = $repertoire_fichier . $name;


        // $fichier = basename($nom_champ);
    if (!is_dir($repertoire_fichier)) {
        mkdir($repertoire_fichier, 0777, TRUE);
    }
    move_uploaded_file($nom_file, $file_link);
    return $name;
}


}
?>
