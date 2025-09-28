<?php
ini_set('memory_limit', '8192M');
/**
*  Ndayizeye Eric
69245250 
*/
class Utilisateurs extends Ci_Controller
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
 $this->load->view('Utilisateurs_list', $data);


}

// recupere les informations dans la base
public function listing()
{
 $var_search= !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
 $var_search=str_replace("'","\'",$var_search);

 $query_principal="SELECT 
 id,
 NOM,
 PRENOM,
 email,
 is_active,
 mobile,
 sf_guard_user_profile.PROFIL_ID,
 profiles.DESCRIPTION,
 IF(SEXE_ID = 1, 'Masculin', 'Féminin') AS SEXE,
 IF(is_active = 1, 'Actif', 'Inactif') AS ETAT
 FROM sf_guard_user_profile left join profiles on profiles.PROFIL_ID= sf_guard_user_profile.PROFIL_ID
 WHERE 1";
 ;
 $limit = '';
 if (isset($_POST['length']) && $_POST['length'] != -1)
 {
  $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
}

$order_by=' ORDER BY id desc';
$order_column=array(1,'PRENOM',
  'email',
  1,
  1);

if ($order_by)
{
  $order_by = isset($_POST['order']) ? ' ORDER BY '.$order_column[$_POST['order']['0']['column']] .'  '.$_POST['order']['0']['dir'] : ' ORDER BY id desc';
}

$search = !empty($_POST['search']['value']) ? (" AND (NOM LIKE '%$var_search%' OR PRENOM LIKE '%$var_search%' OR `email` LIKE '%$var_search%') ") : '';

$critaire = '';
$order_by=' ORDER BY id desc';
$query_secondaire=$query_principal.' '.$critaire.' '.$search.' '.$order_by.' '.$limit;
$query_filter = $query_principal.' '.$critaire.' '.$search;

$fetch_users = $this->Model->datatable($query_secondaire);
$data = array();
$u=0;
foreach ($fetch_users as $row)
{
  $u++; 
  $sub_array=array(); 
  $sub_array[]='<font color="#000000" size=2><label>'.$u.'</label></font>';
  $sub_array[]='<font color="#000000" size=2><label>'.$row->NOM.' '.$row->PRENOM.'</label></font> ';
  // $sub_array[]='<font color="#000000" size=2><label>'.$row->email.'</label></font> ';
  // $sub_array[]='<font color="#000000" size=2><label>'.$row->mobile.'</label></font> ';     
  $sub_array[]='<font color="#000000" size=2><label>'.$row->DESCRIPTION.'</label></font> ';     
  
  // $IS_ACTIVE =($row->is_active==1) ? '<i class="fa fa-check-square-o" style="color:blue;font-size:20px" title="Activé"></i>' : '<i class="fa fa-window-close text-danger" aria-hidden="true" style="font-size:20px" title="Desactivé"></i>';

  // $sub_array[]='<font color="#000000" size=2><label>'.$IS_ACTIVE.'</label></font> '; 
  $USER='';
  $USER= $row->DESCRIPTION.', '. $row->NOM. ' '.$row->PRENOM;
  $action ="";
  // $action .='
  // <a data-toggle="modal" onclick="get_traiter('.$row->id .',\''.$USER.'\')"> 
  // <label>&nbsp;<span class="fa fa-lock" style="font-size:20px;color:red" title= "Activer/Désactiver"></span></label>
  // </a>
  // ';    

  // ' . base_url('utilisateurs/employe/Details/' . md5($row->id)) . '  

  $action .= '<span data-toggle="tooltip" data-placement="top" class="actionCust" title="Détails">
    <a href="' . base_url('utilisateurs/Utilisateurs/Details/' . md5($row->id)) . '">
        <i class="fa fa-bars" style="font-size:20px;color:black"></i>
    </a>
</span>';      
  $sub_array[]=$action;
  $data[] = $sub_array;
}
$output = array(
  "draw" => intval($_POST['draw']),
  "recordsTotal" =>$this->Model->all_data($query_principal),
  "recordsFiltered" => $this->Model->filtrer($query_filter),
  "data" => $data
);
echo json_encode($output);
}

public function activer_desactiver($id='')
{
 $is_active=$this->input->post('is_active');
 // historique_desactivation_utilisateurs
 $this->Model->update("sf_guard_user_profile", array('is_active' =>$is_active , ),array('id' =>$id , ));
}


public function Details($cond=0)
{
$contrat = $this->input->post('contrat');
 $rq=$this->Model->getRequeteOne("SELECT 
 sf_guard_user_profile.id id,
 NOM,
 PRENOM,
 email,
 is_active,
 mobile,
 countries.name,
 sf_guard_user_profile.PROFIL_ID,
 profiles.DESCRIPTION,
 IF(SEXE_ID = 1, 'Masculin', 'Féminin') AS SEXE,
 IF(is_active = 1, 'Actif', 'Inactif') AS ETAT
 FROM sf_guard_user_profile left join profiles on profiles.PROFIL_ID= sf_guard_user_profile.PROFIL_ID
 LEFT join countries on countries.id=sf_guard_user_profile.country_code
 WHERE  md5(sf_guard_user_profile.id)=
'".$cond."' ");
 ;

$data["data"] = $rq;

 $this->load->view('Utilisateurs_Details', $data);

}

function secureOutput($text) {
    return htmlspecialchars(strip_tags($text ?? ''), ENT_QUOTES, 'UTF-8');
}



function nouveau()
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
 redirect(base_url('utilisateurs/Utilisateurs'));
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

}
?>
