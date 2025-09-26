<?php
ini_set('memory_limit', '8192M');
/**
*  Ndayizeye Eric
69245250 
*/
class Employe extends Ci_Controller
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
 
 $data['type_diplome']=$this->Model->getRequete('SELECT * FROM type_diplome');
 $data['nationalites']=$this->Model->getRequete('SELECT * FROM countries');
 $data['type_contrat']=$this->Model->getRequete('SELECT * FROM type_contrat');
 $data['poste_occupe']=$this->Model->getRequete('SELECT * FROM poste_occupe');
 
 $data['profiles']=$this->Model->getRequete('SELECT * FROM profiles');
 $this->load->view('Employe_list_View', $data);


}

// recupere les informations dans la base
public function listing()
{
 $var_search= !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
 $var_search=str_replace("'","\'",$var_search);
$contrat = $this->input->post('contrat');
$SEXE_ID = $this->input->post('SEXE_ID');
$PAYS = $this->input->post('PAYS');
$POSTE_ID = $this->input->post('POSTE_ID');
$cond ="";
if(!empty($SEXE_ID)){
$cond .=' AND u.sexe_id='.$SEXE_ID;
}

if(!empty($PAYS)){
$cond .=' AND u.country_code ='.$PAYS;
}
if(!empty($POSTE_ID)){
$cond .=' AND employes.POSTE_ID='.$POSTE_ID;
}

if(!empty($contrat)){
$cond .=' AND employes.TYPE_CONTRAT_ID='.$contrat;
}
 $query_principal="SELECT 
  u.id,
  u.NOM,
  u.PRENOM,
  u.email,
  u.is_active,
  u.mobile,
  employes.TYPE_CONTRAT_ID,
  employes.POSTE_ID,
  po.DESCRIPTION AS POSTE,
  employes.AUTRE_POSTE,
  u.PROFIL_ID,
  profiles.DESCRIPTION ,
  co.DESCRIPTION AS CONTRAT,
  employes.DATE_EXPIRATION,
  employes.DATE_RECRUTEMENT,
  IF(u.sexe_id = 1, 'Masculin', 'Féminin') AS SEXE,
  IF(u.is_active = 1, 'Actif', 'Inactif') AS ETAT
FROM sf_guard_user_profile u
LEFT JOIN profiles ON profiles.PROFIL_ID = u.PROFIL_ID
JOIN employes ON employes.UTILISATEUR_ID = u.id
LEFT JOIN poste_occupe po ON po.POSTE_ID = employes.POSTE_ID
LEFT JOIN type_contrat co ON co.TYPE_CONTRAT_ID = employes.TYPE_CONTRAT_ID
WHERE 1
".$cond."";
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

$search = !empty($_POST['search']['value']) ? (" AND (u.NOM LIKE '%$var_search%' OR u.PRENOM LIKE '%$var_search%' OR po.DESCRIPTION LIKE '%$var_search%' OR AUTRE_POSTE LIKE '%$var_search%' OR co.DESCRIPTION LIKE '%$var_search%' OR DATE_RECRUTEMENT LIKE '%$var_search%' OR DATE_EXPIRATION LIKE '%$var_search%'  OR mobile LIKE '%$var_search%'OR co.DESCRIPTION LIKE '%$var_search%' OR u.`email` LIKE '%$var_search%') ") : '';

$critaire = ''; 
$order_by=' ORDER BY u.id desc';
$query_secondaire=$query_principal.' '.$critaire.' '.$search.' '.$order_by.' '.$limit;
$query_filter = $query_principal.' '.$critaire.' '.$search;

$fetch_users = $this->Model->datatable($query_secondaire);
$data = array();
$u=0;
foreach ($fetch_users as $row)
{
  $u++; 
  $sub_array=array(); 
  $sub_array[]='<font color="#000000" ><label>'.$u.'</label></font>';
  $sub_array[]='<font color="#000000" ><label>'.$row->NOM.' '.$row->PRENOM.'</label></font> ';
  $sub_array[]='<font color="#000000" ><label>
'.$row->email.'</label></font> '.'<br>'.'<font color="#000000" ><label>
'.$row->mobile.'</label></font> ';

$rowfetch = ($row->POSTE_ID!=0 ? $row->POSTE : $row->AUTRE_POSTE);
$rowfetchcount=str_replace('/','',$rowfetch);
$rowcount=strlen($rowfetchcount);
if ($rowcount>30) {
          $sub_array[] = '<span data-toggle="tooltip" data-placement="top" title="'.$rowfetch .'">'.substr($rowfetch ,0,25).'<b>...</b> </span>'; 

        }else {
          $sub_array[] = $rowfetch;
          
        }


  // $sub_array[]='<font color="#000000" ><label>'.($row->POSTE_ID!=0 ? $row->POSTE : $row->AUTRE_POSTE) .'</label></font> ';

  $sub_array[]='<font color="#000000" ><label>'.$row->CONTRAT.($row->TYPE_CONTRAT_ID==1 ? "<br>Expire le ". date('d/m/Y', strtotime($row->DATE_EXPIRATION)) : "" ).'<br>Recru :'.date('d/m/Y', strtotime($row->DATE_RECRUTEMENT)).'</label></font> ';     
  // $sub_array[]='<font color="#000000" ><label>'.date('d/m/Y', strtotime($row->DATE_RECRUTEMENT)). '</label></font> ';     
  
  $IS_ACTIVE =($row->is_active==1) ? '<i class="fa fa-check-square-o" style="color:blue;font-size:20px" title="Activé"></i>' : '<i class="fa fa-window-close text-danger" aria-hidden="true" style="font-size:20px" title="Desactivé"></i>';

  // $sub_array[]='<font color="#000000" ><label>'.$IS_ACTIVE.'</label></font> '; 
  $USER='';
  $USER= $row->DESCRIPTION.', '. $row->NOM. ' '.$row->PRENOM;
  $action ="";
  $action .='
  <a data-toggle="modal" onclick="get_traiter('.$row->id .',\''.$USER.'\')"> 
  <label>&nbsp;<span class="fa fa-lock" style="font-size:20px;color:red" title= "Activer/Désactiver"></span></label>
  </a>
  ';            
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



function nouveau()
{
 $data['type_diplome']=$this->Model->getRequete('SELECT * FROM type_diplome');
 $data['nationalites']=$this->Model->getRequete('SELECT * FROM countries');
 $data['type_contrat']=$this->Model->getRequete('SELECT * FROM type_contrat');
 $data['poste_occupe']=$this->Model->getRequete('SELECT * FROM poste_occupe');
 
 $data['profiles']=$this->Model->getRequete('SELECT * FROM profiles');
 $this->load->view('Employe_Add_View', $data);
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

 $data = array(
      'NOM'=>$this->input->post('NOM'), 
      'PRENOM'=>$this->input->post('PRENOM'), 
      'DATE_NAISSANCE'=>$this->input->post('PRENOM'), 
      'TYPE_DIPLOME'=>$this->input->post('DIPLOME_ID'), 
      'AUTRE_TYPE_DIPLOME'=>$this->input->post('AUTRE_DIPLOME'), 
      'TYPE_CONTRAT_ID'=>$this->input->post('TYPE_CONTRAT_ID'), 
      'DATE_EXPIRATION'=>$this->input->post('DATE_EXPIRATION'), 
      'POSTE_ID'=>$this->input->post('POSTE_ID'), 
      'AUTRE_POSTE'=>$this->input->post('AUTRE_POSTE'), 
      //'PAYS_ID'=>$this->input->post('PRENOM'), 
      'DATE_RECRUTEMENT'=>$this->input->post('DATE_RECRUTEMENT'), 
      'ETAT_CIVIL'=>$this->input->post('ETAT_CIVIL'), 
      // 'RESPONSABLE_ID'=>0, 
      'PATH_CV'=>$this->upload_document('CV'), 
      'PATH_DIPLOME'=>$this->upload_document('DIPLOME'), 
      'UTILISATEUR_ID'=>$id, 
);
 $this->Model->create('employes',$data);

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
 redirect(base_url('utilisateurs/Employe'));
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
public function upload_document($input_name)
{
  $nom_file = $_FILES[$input_name]['tmp_name'];
  $nom_champ = $_FILES[$input_name]['name'];
  $ext=pathinfo($nom_champ, PATHINFO_EXTENSION);
  $repertoire_fichier = FCPATH . 'uploads/doc_scanner/';  
  $code=uniqid();
  $name=$code . 'doc' .$ext;
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
