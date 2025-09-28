<?php
ini_set('memory_limit', '8192M');
/**
*  Ndayizeye Eric
69245250 
*/
class Profile extends Ci_Controller
{

 public function __construct()
 {
  parent::__construct();
  $this->isAuth();
  require('fpdf184/fpdf.php'); 
}


//CHECK AUTHENTIFICATION 
public function isAuth() 
{
  if(empty($this->get_utilisateur()))
  {
   redirect(base_url('Login'));
 }
}

//RECUPERATION DU LOGIN DE LA PERSONNE CONNECTEE
public function get_utilisateur()
{
  return $this->session->userdata('PMS_USER_ID');
}

public function index($value='')
{
 $data ="";
 $this->load->view('Profile_View', $data);


}


//Enregistrement des donnees dans la base
function save()
{

 $password_input = $this->input->post('PASSWORD1');
$password_hashed = password_hash($password_input, PASSWORD_DEFAULT);
$user_id = $this->session->userdata('PMS_USER_ID');

// Récupérer le mot de passe actuel
$get_password = $this->Model->getRequeteOne('SELECT password FROM sf_guard_user_profile WHERE id = ' . $user_id);

if (!password_verify($password_input, $get_password['password'])) {
    // Nouveau mot de passe → mise à jour
    $this->Model->update('sf_guard_user_profile', ['id' => $user_id], ['password' => $password_hashed]);

    $sms = '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <center><strong>Mot de passe modifié avec succès</strong></center>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div>';
} else {
    // Mot de passe identique
    $sms = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        <center><strong>Mot de passe existe déjà !</strong></center>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div>';
}

// Message et redirection
$this->session->set_flashdata('message', $sms);
redirect(base_url('utilisateurs/Profile'));
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

}
?>
