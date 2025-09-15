<?php
ini_set('memory_limit', '8192M');
/**
*  Ndayizeye Eric
69245250 
*/
class Numeriser_New extends Ci_Controller
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

 public function verifie_mail()
 {
  // $email=$this->input->post('email');
  $email=$this->input->post('EMAIL_PROP');

  $verify_email = $this->Model->getRequeteOne('SELECT `id`, `email` FROM `sf_guard_user_profile` WHERE `email`="'.$email.'" ');

  $data=$this->pms_api->login($email);
  if ($data && isset($data->data) && isset($data->data->email)) {
   $email_api = $data->data->email;
   if ($email_api === $EMAIL) {
    $statu = 1;
   }
  }

  $statut= 2;
  if ($verify_email) {
   $statut= 1;
  }
  echo $statut;
 }

 public function index()
 {   

  $infos_cart='';
  $data['infos_cart'] = $infos_cart;
  $data['message'] = $this->session->flashdata('message');

  $id = $this->uri->segment(4);

  $data['types_requerants']=$this->Model->getRequete('SELECT id,name FROM sf_guard_user_categories WHERE id in(1,5) ORDER BY name ASC');

  $data['nationalites']=$this->Model->getRequete('SELECT id,name FROM countries ORDER BY name ASC');

  $data['sexes']=$this->Model->getRequete('SELECT SEXE_ID,DESCRIPTION_SEXE FROM pms_sexe ORDER BY DESCRIPTION_SEXE ASC');

  $data['provinces_naissance']=$this->Model->getList('syst_provinces');

  $data['info_physique']="style='display:block;'";

  $data['info_nationalite']="style='display:block;'";


  $data['info_morale']="style='display:none;'";

  $data['info_prov_naissance']="style='display:block;'";

  $data['info_com_naissance']="style='display:block;'";

  $data['info_zon_naissance']="style='display:block;'";

  $data['info_col_naissance']="style='display:block;'";

  $data['info_copropriete']="style='display:none;'";

  $data['type_nature_docs']=$this->Model->getRequete('SELECT ID_DOSSIER,DOSSIER FROM `edrms_dossiers_processus` ORDER BY `DOSSIER` ASC');
  $data['usagers_proprietes']=$this->Model->getRequete('SELECT ID_USAGER_PROPRIETE,DESCRIPTION_USAGER_PROPRIETE FROM usager_propriete  ORDER BY DESCRIPTION_USAGER_PROPRIETE ASC');

  $data['provinces']=$this->Model->getList('syst_provinces');
  $this->cart->destroy();

  $this->load->view('Numeriser_New_View',$data); 
 }



// recuperation dynamique des communes par rapport a la province
 public  function get_commune_naissance($PROVINCE_ID=0)
 {
  $communes=$this->Model->getRequete('SELECT COMMUNE_ID,COMMUNE_NAME FROM communes WHERE PROVINCE_ID='.$PROVINCE_ID.' ORDER BY COMMUNE_NAME ASC');
  $html='<option value="">Sélectionner</option>';
  foreach ($communes as $commune)
  {
   $html.='<option value="'.$commune['COMMUNE_ID'].'">'.$commune['COMMUNE_NAME'].'</option>';

  }
  echo json_encode($html);
 }


// recuperation dynamique des communes par rapport a la province
 public  function get_commune_parcelle($PROVINCE_ID=0)
 {
  $communes=$this->Model->getRequete('SELECT COMMUNE_ID,COMMUNE_NAME FROM communes WHERE PROVINCE_ID='.$PROVINCE_ID.' ORDER BY COMMUNE_NAME ASC');
  $html='<option value="">Sélectionner</option>';
  foreach ($communes as $commune)
  {
   $html.='<option value="'.$commune['COMMUNE_ID'].'">'.$commune['COMMUNE_NAME'].'</option>';

  }
  echo json_encode($html);
 }

// recuperation dynamique des zones par rapport a la commune
 public function get_zone_parcelle($COMMUNE_ID=0)
 {
  $zones=$this->Model->getRequete('SELECT ZONE_ID,ZONE_NAME FROM pms_zones WHERE COMMUNE_ID='.$COMMUNE_ID.' ORDER BY ZONE_NAME ASC');


  $html='<option value="">Sélectionner</option>';
  foreach ($zones as $key)
  {
   $html.='<option value="'.$key['ZONE_ID'].'">'.$key['ZONE_NAME'].'</option>';

  }
  echo json_encode($html);
 }

// recuperation dynamique des collines par rapport a la zone
 public function get_colline_parcelle($ZONE_ID=0)
 {
  $collines=$this->Model->getRequete('SELECT COLLINE_ID,COLLINE_NAME FROM collines WHERE ZONE_ID='.$ZONE_ID.' ORDER BY COLLINE_NAME ASC');

  $html='<option value="">Sélectionner</option>';
  foreach ($collines as $key)
  {
   $html.='<option value="'.$key['COLLINE_ID'].'">'.$key['COLLINE_NAME'].'</option>';

  }
  echo json_encode($html);
 }


//PERMET L'UPLOAD DE LA SIGNATURE
 public function upload_file_signature($input_name)
 {
  $nom_file = $_FILES[$input_name]['tmp_name'];
  $nom_champ = $_FILES[$input_name]['name'];
  $ext=pathinfo($nom_champ, PATHINFO_EXTENSION);
  $repertoire_fichier = FCPATH . 'uploads/doc_scanner/';  
  $code=uniqid();
  $name=$code . 'doc_num.' .$ext;
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


//PERMET L'UPLOAD DE L'IMAGE CNI / PASSEPORT
 public function upload_file_sign_morale($input_name)
 {
  $nom_file = $_FILES[$input_name]['tmp_name'];
  $nom_champ = $_FILES[$input_name]['name'];
  $ext=pathinfo($nom_champ, PATHINFO_EXTENSION);
  $repertoire_fichier = FCPATH . 'uploads/signatures/';
  $code=uniqid();
  $name=$code . 'MORALE_SIGINATURE.' .$ext;
  $file_link = $repertoire_fichier . $name;


// $fichier = basename($nom_champ);
  if (!is_dir($repertoire_fichier)) {
   mkdir($repertoire_fichier, 0777, TRUE);
  }
  move_uploaded_file($nom_file, $file_link);
  return $name;
 }



  // function d'enregistrement des info d'un requerant
 public function add_info_requerant()
 {
  ob_start();
  $PROVINCE_ID1 = $this->input->post('PROVINCE_ID1');
  $COMMUNE_ID1 = $this->input->post('COMMUNE_ID1');
  $ZONE_ID1 = $this->input->post('ZONE_ID1');
  $COLLINE_ID1 = $this->input->post('COLLINE_ID1');
  $redirection = "administration/Numeriser_New/";
  $message = '<div class="alert alert-danger text-center" id="message">L\'adresse e-mail existe déjà dans notre système</div>';

  // Conversion factors
  $haToSqM = 10000;
  $acresToSqM = 100;
  $centiaresToSqM = 0.01;
  $pourcentage = 1;

  $ha = $this->input->post('SUPER_HA');
  $acres = $this->input->post('SUPER_ARE');
  $centiares = $this->input->post('SUPER_CA');
  $POUR100 = $this->input->post('POUR100');
   // $POUR100 = $POUR100 * $pourcentage;

  // Convert values to square meters
  $haSqM = $ha * $haToSqM;
  $acresSqM = $acres * $acresToSqM;
  $centiaresSqM = $centiares * $centiaresToSqM;

   // Calculate total area
  $totalAreaSqM = $haSqM + $acresSqM + $centiaresSqM + $POUR100;
   // Generation pwd
  $mot_de_passe = $this->password_generer();
  $mot_de_passe2 = $this->password_generer();
  $hashedPassword = password_hash($mot_de_passe, PASSWORD_DEFAULT);
  $hashedPassword2 = password_hash($mot_de_passe2, PASSWORD_DEFAULT);

  $special_caractere = array('/', '-', '.', '"', "'", "*", '<', '>', '|', ':', '?');
  $avoid_slashes = str_replace($special_caractere, "-", $this->input->post('NUM_PARCEL'));
  $netoyage_avoid_slashes = preg_replace('/[^A-Za-z0-9\-]/', '', $avoid_slashes);

  $get_province_token = $this->Model->getOne(
   'edrms_dossiers_processus_province', 
   array(
    'province_id' => $this->input->post('PROVINCE_ID1'),
    'dossier_processus_id' => $this->input->post('NATURE_DOC')
   )
  );

  $result_alf = $this->pms_alfresco_lib->get_folder_content($get_province_token['token_dossiers_processus_province']);
  $result = $this->pms_api->get_folder_content($this->input->post('NUM_PARCEL'));

  $token_repertoire_doc_box = '';
  $nom_sous_repertoire_doc_box = '';
  $token_sous_repertoire_doc_box = '';
  $response = json_decode($result, true);  

  if (isset($response['detail_fold']) && isset($response['detail_fold']['nom_folder'])) {
   if ($response['detail_fold']['nom_folder'] == $this->input->post('NUM_PARCEL')) {
    $token_repertoire_doc_box = json_decode($result)->detail_fold->fold_parrent_token; 
    $nom_sous_repertoire_doc_box = json_decode($result)->data->dossier[0]->nom_folder;
    $token_sous_repertoire_doc_box = json_decode($result)->data->dossier[0]->token;
   }
  } else {
   $token_repertoire_doc_box = '';
   $nom_sous_repertoire_doc_box = '';
   $token_sous_repertoire_doc_box = '';
  } 

  $token_repertoire_doc_box = '';
  $nom_sous_repertoire_doc_box = '';
  $token_sous_repertoire_doc_box = '';

  $var = '';
  $id = '';
  $name = '';
  $foundMatchRepertoire = false;
  $foundMatchSousRepertoire = false;

  foreach ($result_alf as $entry) {
   $entryName = isset($entry['name']) ? $entry['name'] : "";
// Remove special characters and spaces
   $cleanedEntryName = preg_replace('/[^A-Za-z0-9\-]/', '', $entryName);
   if (strcasecmp($cleanedEntryName, $netoyage_avoid_slashes) == 0) {
    $id = $entry['id'];
    $name = $entry['name'];
    $foundMatchRepertoire = true;
    break; 
   }
  }

  $result_token_sous_repertoire = $this->pms_alfresco_lib->get_folder_content($id); 
  $nom_sous_repertoire_alf = '';
  $token_sous_repertoire_alf = '';

  if ($result_token_sous_repertoire) {
   foreach ($result_token_sous_repertoire as $entry) {
    $entryName = $entry['name'];
    // Remove special characters and spaces
    $token_sous_repertoire_alf = $entry['id'];
    $nom_sous_repertoire_alf = $entry['name'];
    $foundMatchSousRepertoire = true;
   break; 
   }
  }

if (($response['status'] == 200) || ($foundMatchRepertoire == true && $foundMatchSousRepertoire == true)) {              
 $madantaire = $this->input->post('mandataire');
 $province = $this->Model->getOne('syst_provinces', array('PROVINCE_ID' => $this->input->post('PROVINCE_ID1')));
 $communes = $this->Model->getRequeteOne('SELECT COMMUNE_NAME FROM communes WHERE COMMUNE_ID='.$this->input->post('COMMUNE_ID1').' ');
 $numParcel = $this->input->post('NUM_PARCEL');
 $provinceName = $province['PROVINCE_NAME'];
 $communeName = $communes['COMMUNE_NAME'];
 $loginLink = '<a href="' . base_url('/Login') . '" target="_blank">Cliquez-ici</a>';

 $IS_MANDATAIRE = 0;
 if ($madantaire == 1) {
  $IS_MANDATAIRE = 1;
  $NOM_PRENOM_PROP = $this->input->post('NOM_PRENOM_PROP');
  $SEXE_ID = $this->input->post('SEXE_ID');
  $NUM_CNI_PROP = $this->input->post('NUM_CNI_PROP');
  $EMAIL_PROP = $this->input->post('EMAIL_PROP');
  $NUM_TEL_PROP = $this->input->post('NUM_TEL_PROP');

  $PHOTO_PASSEPORT_PROP = $this->upload_file_signature('PHOTO_PASSEPORT_PROP');
  $SIGNATURE_PROP = $this->upload_file_signature('SIGNATURE_PROP');
  $CNI_IMAGE_PROP = $this->upload_file_signature('CNI_IMAGE_PROP');
  $CNI_IMAGE_PROP2 = $this->upload_file_signature('CNI_IMAGE_PROP2');

  $check_user = $this->Model->getRequeteOne("SELECT `id`,`email` FROM `sf_guard_user_profile` WHERE `email` = '".$EMAIL_PROP."' and registeras = 9 ");

  $data = array(
   'fullname' => $NOM_PRENOM_PROP,
   'sexe_id' => $SEXE_ID, 
   'cni' => $NUM_CNI_PROP,
   'email' => $EMAIL_PROP,
   'mobile' => $NUM_TEL_PROP,
   'profile_pic' => $PHOTO_PASSEPORT_PROP,
   'path_signature' => $SIGNATURE_PROP,
   'path_cni' => $CNI_IMAGE_PROP,
   'password' => $hashedPassword,
   'username' => $EMAIL_PROP,
   'numerise' => 1,
   'systeme_id' => 2,
   'registeras' => 9,
  );

  if (empty($check_user)) {
   $sf_guard_user_last_id = $this->Model->insert_last_id("sf_guard_user_profile", $data);

    // envoyer un message au mandataire
   $messageM = "Madame/Monsieur $NOM_PRENOM_PROP,<br><br>
   Bienvenue sur le Système Électronique de Transfert de Titres de Propriété (PMS).<br><br>
   La Direction des Titres Fonciers et du Cadastre National (DTFCN) vous informe que vous avez été désigné(e) comme mandataire dans le cadre d’une procédure de mise à jour, d’actualisation, de demande de service ou de transfert de propriété liée à la parcelle n° $numParcel, située à $provinceName dans la commune $communeName.<br>
   En tant que mandataire, vous êtes habilité(e) à :<br>
   - Initier ou suivre une demande au nom du propriétaire<br>
   - Déposer les documents requis pour l’opération<br>
   - Suivre l’état d’avancement du dossier en ligne<br><br>
   Vos identifiants d’accès :<br>
   Lien de connexion : $loginLink<br>
   Nom d'utilisateur : $EMAIL_PROP<br>
   Mot de passe : $mot_de_passe<br><br>
   Nous vous invitons à vous connecter dès maintenant afin de consulter les dossiers qui vous ont été délégués.<br>
   Pour toute information complémentaire ou assistance, veuillez contacter notre support technique ou vous rendre à la DTFCN.<br><br>
   Cordialement,<br>
   Direction des Titres Fonciers et du Cadastre National (DTFCN)";

   $this->notifications->send_mail($EMAIL_PROP, 'Activation de votre accès en tant que mandataire – Système PMS', [], $messageM, []);
  } else {
   $sf_guard_user_last_id = $check_user["id"];
  }
 }
//fin mandataire

 $count = count($this->cart->contents());
 $val_attribution = '';
 $mailTo2 = "";
 $nom2 = "";
 $sf_guard_user_last_id2 = null;
 $TYPE_PARCELLE = null;
 $firstProcessed = false; 

foreach ($this->cart->contents() as $item) {
 if (preg_match('/FILE/', $item['typecartitem'])) {
  $currentEmail = ($item['type_requerant_id'] == 1) 
  ? $item['EMAIL_PROP'] 
  : $item['EMAIL_REPRESENTANT'];

  if (!$firstProcessed && !empty($currentEmail)) {
   $data_sf_guard_user_profile = [
    'email' => $currentEmail,
    'fullname' => ($item['type_requerant_id'] == 1) 
    ? $item['NOM_PRENOM_PROP'] 
    : $item['NOM_REPRESENTANT'],
    'nom_entreprise' => ($item['type_requerant_id'] == 5) 
    ? $item['NOM_ENTREPRISE'] 
    : "",
    'username' => $currentEmail,
    'password' => $hashedPassword2,
    'date_naissance' => ($item['type_requerant_id'] == 1) 
    ? $item['DATE_NAISSANCE'] 
    : '',
    'mobile' => ($item['type_requerant_id'] == 1) 
    ? $item['NUM_TEL_PROP'] 
    : $item['TELEPHONE_REPRESENTANT'],
    'registeras' => $item['type_requerant_id'],
    'date_delivrance' => ($item['type_requerant_id'] == 1) 
    ? $item['DATE_DELIVRANCE'] 
    : "",
    'country_code' => $item['nationalite_id'],
    'lieu_delivrance_cni' => ($item['type_requerant_id'] == 1) 
    ? $item['LIEU_DELIVRANCE'] 
    : "",
    'systeme_id' => 2,
    'cni' => ($item['type_requerant_id'] == 1) 
    ? $item['NUM_CNI_PROP'] 
    : "",
    'rc' => ($item['type_requerant_id'] == 5) 
    ? $item['NIF_RC'] 
    : "",
    'sexe_id' => ($item['type_requerant_id'] == 1) 
    ? $item['SEXE_ID'] 
    : "",
    'path_cni' => ($item['type_requerant_id'] == 1) 
    ? $item['CNI_IMAGE_PROP'] 
    : "",
    'profile_pic' => ($item['type_requerant_id'] == 1) 
    ? $item['PHOTO_PASSEPORT_PROP'] 
    : "",
    'numerise' => 1,
    'father_fullname' => ($item['type_requerant_id'] == 1) 
    ? $item['NOM_PRENOM_PERE'] 
    : '',
    'path_signature' => ($item['type_requerant_id'] == 5) 
    ? $item['SIGNATURE_REPRESENTANT']
    : $item['SIGNATURE_PROP'],
    'provence_id' => $item['PROVINCE_ID'],
    'mother_fullname' => ($item['type_requerant_id'] == 1) 
    ? $item['NOM_PRENOM_MERE'] 
    : '',
    'commune_id' => $item['COMMUNE_ID'],
    'zone_id' => $item['ZONE_ID'],
    'colline_id' => $item['COLLINE_ID']
   ];

   $mailTo2 = $currentEmail;
   $nom2 = ($item['type_requerant_id'] == 1) 
   ? $item['NOM_PRENOM_PROP'] 
   : $item['NOM_REPRESENTANT'];

   $critere = "email = ''";
   $this->Model->delete('sf_guard_user_profile', $critere);

   $sf_guard_user_last_id2 = $this->Model->insert_last_id('sf_guard_user_profile', $data_sf_guard_user_profile);
   $firstProcessed = true;
  }

  $TYPE_PARCELLE = $item['TYPE_PARCELLE'] ?? $this->input->post('type_parcelle');

// Sortir après le premier élément traité
  if ($firstProcessed) break;
 }
}

$critere = "email = ''";
// Suppression des utilisateurs mal enregistrés
$this->Model->delete('sf_guard_user_profile', $critere);

// Enregistrement pour type personnel et succession
$TYPE_PARCELLE = $this->input->post('type_parcelle');
if ($TYPE_PARCELLE != 2) {
 $NOM_PRENOM_PROP = $this->input->post('NOM_PRENOM_PROP2');      
 $SEXE_ID = $this->input->post('SEXE_ID2');
 $nationalite_id = $this->input->post('nationalite_id');      
 $PROVINCE_ID = $this->input->post('PROVINCE_ID');
 $COMMUNE_ID = $this->input->post('COMMUNE_ID');
 $ZONE_ID = $this->input->post('ZONE_ID');
 $COLLINE_ID = $this->input->post('COLLINE_ID');
 $NUM_CNI_PROP = $this->input->post('NUM_CNI_PROP3');
 $DATE_NAISSANCE = $this->input->post('DATE_NAISSANCE');
 $DATE_DELIVRANCE = $this->input->post('DATE_DELIVRANCE');
 $LIEU_DELIVRANCE = $this->input->post('LIEU_DELIVRANCE');
 $EMAIL_PROP = $this->input->post('EMAIL_PROP2');
 $NUM_TEL_PROP = $this->input->post('NUM_TEL_PROP2');
 $NOM_PRENOM_PERE = $this->input->post('NOM_PRENOM_PERE');
 $NOM_PRENOM_MERE = $this->input->post('NOM_PRENOM_MERE');
 $TYPE_PARCELLE = $this->input->post('type_parcelle');

 $SIGNATURE_REPRESENTANT = $this->upload_file_signature('SIGNATURE_REPRESENTANT');
 $type_requerant_id = $this->input->post('type_requerant_id');
 $NOM_ENTREPRISE = $this->input->post('NOM_ENTREPRISE');      
 $NOM_REPRESENTANT = $this->input->post('NOM_REPRESENTANT');
 $EMAIL_REPRESENTANT = $this->input->post('EMAIL_REPRESENTANT');
 $NUM_CNI_PROP = "";

 $TELEPHONE_REPRESENTANT = $this->input->post('TELEPHONE_REPRESENTANT');
 $NIF_RC = $this->input->post('NIF_RC');

 $PROVINCE_ID = $this->input->post('PROVINCE_ID');
 $COMMUNE_ID = $this->input->post('COMMUNE_ID');
 $ZONE_ID = $this->input->post('ZONE_ID');
 $COLLINE_ID = $this->input->post('COLLINE_ID');
 $CNI_IMAGE_PROP = $this->upload_file_signature('CNI_IMAGE_PROP3');
 $PHOTO_PASSEPORT_PROP = $this->upload_file_signature('PHOTO_PASSEPORT_PROP2');
 $SIGNATURE_PROP = $this->upload_file_signature('SIGNATURE_PROP2');

// Utilisateurs des parcelles de type personnel et succession
 $data_sf_guard_user_profile = array(
  'email' => ($EMAIL_PROP) ? $EMAIL_PROP : $EMAIL_REPRESENTANT,
  'fullname' => ($NOM_PRENOM_PROP) ? $NOM_PRENOM_PROP : $NOM_REPRESENTANT,
  'nom_entreprise' => ($NOM_ENTREPRISE) ? $NOM_ENTREPRISE : "",
  'username' => ($EMAIL_PROP) ? $EMAIL_PROP : $EMAIL_REPRESENTANT,
  'password' => $hashedPassword2,
  'date_naissance' => ($DATE_NAISSANCE) ? $DATE_NAISSANCE : '',
  'mobile' => ($NUM_TEL_PROP) ? $NUM_TEL_PROP : $TELEPHONE_REPRESENTANT,
  'registeras' => $type_requerant_id,
  'date_delivrance' => ($DATE_DELIVRANCE) ? $DATE_DELIVRANCE : "",
  'country_code' => ($nationalite_id) ? $nationalite_id : $nationalite_id,
  'lieu_delivrance_cni' => ($LIEU_DELIVRANCE) ? $LIEU_DELIVRANCE : "",
  'systeme_id' => 2,
  'cni' => ($NUM_CNI_PROP) ? $NUM_CNI_PROP : "",
  'rc' => ($NIF_RC) ? $NIF_RC : "",
  'sexe_id' => ($SEXE_ID) ? $SEXE_ID : "",
  'path_cni' => ($CNI_IMAGE_PROP) ? $CNI_IMAGE_PROP : "",
  'profile_pic' => ($PHOTO_PASSEPORT_PROP) ? $PHOTO_PASSEPORT_PROP : "",
  'numerise' => 1,
  'father_fullname' => ($NOM_PRENOM_PERE) ? $NOM_PRENOM_PERE : '',
  'path_signature' => ($SIGNATURE_REPRESENTANT) ? $SIGNATURE_REPRESENTANT : $SIGNATURE_PROP,
  'provence_id' => $PROVINCE_ID,         
  'mother_fullname' => ($NOM_PRENOM_MERE) ? $NOM_PRENOM_MERE : '',
  'commune_id' => $COMMUNE_ID,
  'zone_id' => $ZONE_ID,
  'colline_id' => $COLLINE_ID,
 );
 $sf_guard_user_last_id3 = $this->Model->insert_last_id('sf_guard_user_profile', $data_sf_guard_user_profile);       
}

if ($madantaire == 1) {
 $data = array(
  'ID_MANDATAIRE' => $sf_guard_user_last_id,
  'NUMERO_PARCELLE' => $this->input->post('NUM_PARCEL'),
  'STATUT_MANDATAIRE' => 1, 
 );

 $this->Model->create('relation_mandataire_proprietaire', $data);
}

$data_parcelle = array(
 'NUMERO_PARCELLE' => $this->input->post('NUM_PARCEL'),
 'SUPERFICIE' => $totalAreaSqM,
 'PRIX' => 1000000,
 'STATUT_ID' => 3,
 'PROVINCE_ID' => $this->input->post('PROVINCE_ID1'),
 'COMMUNE_ID' => $this->input->post('COMMUNE_ID1'),
 'ZONE_ID' => $this->input->post('ZONE_ID1'),
 'COLLINE_ID' => $this->input->post('COLLINE_ID1'),
);

$check_parcel = $this->Model->getRequeteOne("SELECT `ID_PARCELLE`,`NUMERO_PARCELLE` FROM `parcelle` WHERE `NUMERO_PARCELLE`='".$this->input->post('NUM_PARCEL')."' ");

if (empty($check_parcel)) {
 $parcelle_last_id = $this->Model->insert_last_id('parcelle', $data_parcelle);
} else {
 $this->Model->update('parcelle', array('ID_PARCELLE' => $check_parcel['ID_PARCELLE']), $data_parcelle);
 $parcelle_last_id = $check_parcel['ID_PARCELLE'];
}

$TYPE_PARCELLE = (isset($item['TYPE_PARCELLE'])) ? $item['TYPE_PARCELLE'] : $this->input->post('type_parcelle');
$sf_guard_user_last_id2 = (isset($sf_guard_user_last_id2) ? $sf_guard_user_last_id2 : $sf_guard_user_last_id3);

$data_parcelle_attribution = array(
 'POURCENTAGE'=>$POUR100 ,
 'ID_PARCELLE' => $parcelle_last_id,
 'ID_REQUERANT' => $sf_guard_user_last_id2,
 'NUMERO_PARCELLE' => $this->input->post('NUM_PARCEL'),
 'SUPERFICIE' => $totalAreaSqM,
 'PRIX' => 1000000,
 'STATUT_ID' => 3,
 'SUPERFICIE_HA' => $this->input->post('SUPER_HA'),
 'SUPERFICIE_ARE' => $this->input->post('SUPER_ARE'),
 'SUPERFICIE_CA' => $this->input->post('SUPER_CA'),
 'PROVINCE_ID' => $this->input->post('PROVINCE_ID1'),
 'COMMUNE_ID' => $this->input->post('COMMUNE_ID1'),
 'ZONE_ID' => $this->input->post('ZONE_ID1'),
 'COLLINE_ID' => $this->input->post('COLLINE_ID1'),
 'NUMERO_CADASTRAL' => $this->input->post('NUM_CADASTRE'),
 'USAGE_ID' => $this->input->post('USAGE'),
 'VOLUME' => $this->input->post('VOLUME'),
 'FOLIO' => $this->input->post('FOLIO'),
 'NUMERO_ORDRE_SPECIAL' => $this->input->post('NUMERO_SPECIAL'),
 'TYPE_PARCELLE' => $TYPE_PARCELLE,
 'IS_MANDATAIRE' => $IS_MANDATAIRE,
 'NOM_CEDANT' => (isset($item['SUCCENDANT'])) ? $item['SUCCENDANT'] : $this->input->post('SUCCENDANT'),
); 

$check_parcel2 = $this->Model->getRequeteOne("SELECT `ID_ATTRIBUTION`,`NUMERO_PARCELLE` FROM `parcelle_attribution` WHERE `NUMERO_PARCELLE`='".$this->input->post('NUM_PARCEL')."' ");

if (empty($check_parcel2)) {
 $result_parcelle_attribution = $this->Model->insert_last_id('parcelle_attribution', $data_parcelle_attribution);
} else {
 $this->Model->update('parcelle_attribution', array('ID_ATTRIBUTION' => $check_parcel2['ID_ATTRIBUTION']), $data_parcelle_attribution);
 $result_parcelle_attribution = $check_parcel2['ID_ATTRIBUTION'];
}    

// Enregistrement des membres de copropriété
$i = 0;
$nom_copropr = "";
foreach ($this->cart->contents() as $item) {
 if (preg_match('/FILE/', $item['typecartitem'])) {
  $i++; 
  $data_copro_success = array(
   'id_attribution' => $result_parcelle_attribution,
   'email' => ($item['type_requerant_id'] == 1) ? $item['EMAIL_PROP'] : $item['EMAIL_REPRESENTANT'],
   'fullname' => ($item['type_requerant_id'] == 1) ? $item['NOM_PRENOM_PROP'] : $item['NOM_REPRESENTANT'],
   'nom_entreprise' => ($item['type_requerant_id'] == 5) ? $item['NOM_ENTREPRISE'] : "",
   'mobile' => ($item['type_requerant_id'] == 1) ? $item['NUM_TEL_PROP'] : $item['TELEPHONE_REPRESENTANT'],
   'rc' => ($item['type_requerant_id'] == 5) ? $item['NIF_RC'] : "",
   'profile_pic' => ($item['type_requerant_id'] == 1) ? $item['PHOTO_PASSEPORT_PROP'] : "",
   'path_signature' => ($item['type_requerant_id'] == 5) ? $item['SIGNATURE_REPRESENTANT'] : $item['SIGNATURE_PROP'],
   'path_cni' => ($item['type_requerant_id'] == 1) ? $item['CNI_IMAGE_PROP'] : "",
   'cni' => ($item['type_requerant_id'] == 1) ? $item['NUM_CNI_PROP'] : "",
   'lieu_delivrance_cni' => ($item['type_requerant_id'] == 1) ? $item['LIEU_DELIVRANCE'] : "",
   'provence_id' => $item['PROVINCE_ID'],   
   'commune_id' => $item['COMMUNE_ID'],
   'zone_id' => $item['ZONE_ID'],
   'colline_id' => $item['COLLINE_ID'],
   'zone_id' => $item['ZONE_ID'],
   'date_naissance' => ($item['type_requerant_id'] == 1) ? $item['DATE_NAISSANCE'] : '',
   'sexe_id' => ($item['type_requerant_id'] == 1) ? $item['SEXE_ID'] : "",
   'father_fullname' => ($item['type_requerant_id'] == 1) ? $item['NOM_PRENOM_PERE'] : '',
   'mother_fullname' => ($item['type_requerant_id'] == 1) ? $item['NOM_PRENOM_MERE'] : '',
   'IS_CHEF' => 0,
   'password' => $hashedPassword2,
   'country_code' => $item['nationalite_id'],
   'registeras' => $item['type_requerant_id'],
  );

  $TYPE_PARCELLE = (isset($item['TYPE_PARCELLE'])) ? $item['TYPE_PARCELLE'] : $this->input->post('type_parcelle');
  $nom_copropr .= ($item['type_requerant_id'] == 1) ? $item['NOM_PRENOM_PROP'] : $item['NOM_REPRESENTANT'].",";

  $this->Model->create("pms_copropriete_succession", $data_copro_success);
 }   
}

$chef = $this->Model->getRequeteOne("SELECT MIN(id_copropriete_succession) id_copropriete_succession FROM pms_copropriete_succession WHERE id_attribution=".$result_parcelle_attribution." ");

if ($chef) {
 $this->Model->update(
  "pms_copropriete_succession",
  array('id_copropriete_succession' => $chef['id_copropriete_succession']),
  array('IS_CHEF' => 1)
 );  
}   

if ($TYPE_PARCELLE != 2 && $madantaire == 1) {
 $data_copro_success = array(
  'id_attribution' => $result_parcelle_attribution,
  'email' => ($EMAIL_PROP) ? $EMAIL_PROP : $EMAIL_REPRESENTANT,
  'fullname' => ($NOM_PRENOM_PROP) ? $NOM_PRENOM_PROP : $NOM_REPRESENTANT,
  'nom_entreprise' => ($NOM_ENTREPRISE) ? $NOM_ENTREPRISE : "",
  'mobile' => ($NUM_TEL_PROP) ? $NUM_TEL_PROP : $TELEPHONE_REPRESENTANT,
  'rc' => ($NIF_RC) ? $NIF_RC : "",
  'profile_pic' => ($PHOTO_PASSEPORT_PROP) ? $PHOTO_PASSEPORT_PROP : "",
  'path_signature' => ($SIGNATURE_REPRESENTANT) ? $SIGNATURE_REPRESENTANT : $SIGNATURE_PROP,
  'path_cni' => ($CNI_IMAGE_PROP) ? $CNI_IMAGE_PROP : "",
  'cni' => ($NUM_CNI_PROP) ? $NUM_CNI_PROP : "",
  'lieu_delivrance_cni' => ($LIEU_DELIVRANCE) ? $LIEU_DELIVRANCE : "",
  'provence_id' => $PROVINCE_ID,   
  'commune_id' => $COMMUNE_ID,
  'zone_id' => $ZONE_ID,
  'colline_id' => $COLLINE_ID,
  'zone_id' => $ZONE_ID,
  'date_naissance' => ($DATE_NAISSANCE) ? $DATE_NAISSANCE : '',
  'sexe_id' => ($SEXE_ID) ? $SEXE_ID : "",
  'father_fullname' => ($NOM_PRENOM_PERE) ? $NOM_PRENOM_PERE : '',
  'mother_fullname' => ($NOM_PRENOM_MERE) ? $NOM_PRENOM_MERE : '',
  'country_code' => ($nationalite_id) ? $nationalite_id : $nationalite_id,
  'IS_CHEF' => 1,
  'password' => $hashedPassword,
 );
 $this->Model->create("pms_copropriete_succession", $data_copro_success);
}

if ($TYPE_PARCELLE != 2) {
 if ($madantaire == 1) {
  $SEXE_ID = $this->input->post('SEXE_ID');
  $mailTo = $this->input->post('EMAIL_PROP');
  $nom = $this->input->post('NOM_PRENOM_PROP') . " ";
 } else {
  $mailTo = ($EMAIL_PROP) ? $EMAIL_PROP : $EMAIL_REPRESENTANT; 
  $nom = ($NOM_PRENOM_PROP) ? $NOM_PRENOM_PROP : $NOM_REPRESENTANT;
 } 
} else {
 if ($madantaire == 1) {
  $SEXE_ID = $this->input->post('SEXE_ID');
  $mailTo = $this->input->post('EMAIL_PROP');
  $nom = $this->input->post('NOM_PRENOM_PROP') . " le mandataire";
 } else {
  $mailTo = $mailTo2;
  $nom = $nom2;
 }
}

$mailTo3 = ($EMAIL_PROP) ? $EMAIL_PROP : $EMAIL_REPRESENTANT;
$nom3 = ($NOM_PRENOM_PROP) ? $NOM_PRENOM_PROP : $NOM_REPRESENTANT;

$mailTo4 = ($mailTo2) ? $mailTo2 : $mailTo3;
$nom4 = ($nom2) ? $nom2 : $nom3;
$mailToM = $this->input->post('EMAIL_PROP');
$nomM = $this->input->post('NOM_PRENOM_PROP');
$parcel = $this->input->post('NUM_PARCEL');
$succedant = $this->input->post('SUCCENDANT');

$messages = "Bonjour Mr/Mme $nom4,<br><br>
Bienvenue sur le système électronique de transfert de titres de propriété (PMS).<br><br>
La Direction des Titres Fonciers et Cadastre National (DTFCN) reconnait votre enregistrement en tant que propriétaire de la parcelle numéro $numParcel sise à $provinceName dans la commune $communeName.<br><br>
Vous aurez la possibilité d’effectuer des demandes de transfert, des mises à jour ou tout autre service en cas de besoin.<br><br>
Vos identifiants de connexion :<br>
Lien : $loginLink<br>
Nom d'utilisateur : $mailTo4<br>
Mot de passe : $mot_de_passe2";

// 2. Copropriété
if ($nom_copropr) {
 $messages = "Madame/Messieurs $nom4,<br><br>
 Bienvenue sur le Système Électronique de Transfert de Titres de Propriété (PMS).<br><br>
 La Direction des Titres Fonciers et du Cadastre National (DTFCN) vous informe que vous êtes en copropriété sur la parcelle numéro $numParcel, sise à $provinceName dans la commune $communeName, avec $nom_copropr.<br><br>
 En tant que délégué(e) de cette copropriété, vous êtes habilité(e) à effectuer des demandes de transfert, des mises à jour ou tout autre service lié à cette parcelle.<br><br>
 Vous trouverez ci-dessous vos identifiants de connexion :<br>
 Lien : $loginLink<br>
 Nom d'utilisateur : $mailTo4<br>
 Mot de passe : $mot_de_passe2<br><br>
 Nous vous invitons à vous connecter dès maintenant afin de consulter les dossiers qui vous ont été délégués.<br>
 Pour toute assistance, veuillez contacter notre support technique ou vous rendre à la DTFCN.<br><br>
 Cordialement,<br>
 Direction des Titres Fonciers et du Cadastre National (DTFCN)";
} 

// 4. Héritier (succession)
if ($succedant) {
 $messages = "Bonjour Mr/Mme $nom4,<br><br>
 Bienvenue sur le Système Électronique de Transfert de Titres de Propriété (PMS).<br><br>
 La Direction des Titres Fonciers et du Cadastre National (DTFCN) vous informe que vous êtes désigné(e) sur la parcelle n° $numParcel sise à $provinceName dans la commune $communeName, dans le cadre de la succession de $succedant.<br><br>
 En tant que représentant(e) de cette succession, vous êtes habilité(e) à effectuer les démarches liées à cette parcelle :<br>
 - Demande de transfert<br>
 - Mise à jour des informations<br>
 - Tout autre service disponible<br><br>
 Vos identifiants de connexion :<br>
 Lien : $loginLink<br>
 Nom d'utilisateur : $mailTo4<br>
 Mot de passe : $mot_de_passe2<br><br>
 Nous vous invitons à vous connecter dès maintenant pour consulter les dossiers.<br>
 Pour toute assistance, veuillez contacter notre support technique ou vous rendre à la DTFCN.<br><br>
 Cordialement,<br>
 Direction des Titres Fonciers et du Cadastre National (DTFCN)";
}

$this->notifications->send_mail($mailTo4, 'Activation de votre accès au système PMS', [], $messages, []);

$result_parcelle_new = $this->Model->insert_last_id(
 'edrms_repertoire_processus_parcelle_new',
 array(
  'dossiers_processus_province_id' => $get_province_token['id'],
  'parcelle_id' => $parcelle_last_id,
  'numero_parcelle' => $this->input->post('NUM_PARCEL'),
  'nom_repertoire_parcelle' => $name,
  'token_dossiers_parcelle_processus' => $id,
  'DOC_TOKEN' => $token_repertoire_doc_box,
  'dossier_id' => $this->input->post('NATURE_DOC')
 )
);

$this->Model->create(
 'edrms_repertoire_processus_sous_repertoire_new',
 array(
  'dossier_processus_parcelle_id' => $result_parcelle_new,
  'parcelle_id' => $parcelle_last_id,
  'nom_sous_repertoire' => $nom_sous_repertoire_alf,
  'nom_sous_repertoire_doc' => $nom_sous_repertoire_doc_box,
  'token_sous_repertoire' => $token_sous_repertoire_alf,
  'DOC_REF_TOKEN' => $token_sous_repertoire_doc_box,
  'statut_actualisation' => 1
 )
);

$message = '<div class="alert alert-success text-center" id="message">'.lang('enregistrement_succes').'</div>';
$redirection = "administration/Numeriser_New/list";
$this->session->set_flashdata('message', $message);
}
// Si parcelle n'existe pas dans edrms
else {
 $message = '<div class="alert alert-danger text-center" id="message">La parcelle n\'existe ni dans DocBox ou Alfresco</div>'; 
 $redirection = "administration/Numeriser_New/";
 $this->session->set_flashdata('message', $message);
} 

$this->session->set_flashdata('message', $message);
redirect(base_url($redirection));
ob_end_flush();
}

public function exist_mail2($value = '')
{
 $EMAIL = $this->input->post('email');
 $data = $this->pms_api->login($EMAIL);

$statu = 2; // Valeur par défaut
if (!empty($EMAIL)) {
 $EMAIL2 = $this->Model->getRequeteOne('SELECT `email` FROM `sf_guard_user_profile` WHERE `email`="' . $EMAIL . '" ');

 $statu = 0;
 if ($EMAIL2) {
  $statu = 1;
 }
}

// Vérification correcte du retour de l'API
if ($data && isset($data->data) && isset($data->data->email)) {
 $email_api = $data->data->email;
// Par exemple, on pourrait vérifier si cet email est égal à celui reçu :
 if ($email_api === $EMAIL) {
  $statu = 1;
 }
}
// Vérification du numéro de parcelle
$NUM_PARCEL = $this->input->post('NUM_PARCEL');
$num_parcel = 2;
if (!empty($NUM_PARCEL)) {
 $parcelle = $this->Model->getRequeteOne('SELECT `NUMERO_PARCELLE` FROM `parcelle` WHERE `NUMERO_PARCELLE`="' . $NUM_PARCEL . '" ');
 $num_parcel = ($parcelle) ? 1 : 0;
}

$datas = array('statut' => $statu, 'parcelle' => $num_parcel);
echo json_encode($datas);
}



// fonction qui appel la view qui affiche le formulaire
public function info_parcelle($user_id)
{
 if(empty($user_id))
 {
  redirect(base_url('administration/Numeriser_New/list'));
 }
 else
 {
  $data['user_id']=$user_id;
  $data['type_nature_docs']=$this->Model->getRequete('SELECT ID_DOSSIER,DOSSIER FROM `edrms_dossiers_processus` ORDER BY `DOSSIER` ASC');
  $data['usagers_proprietes']=$this->Model->getRequete('SELECT ID_USAGER_PROPRIETE,DESCRIPTION_USAGER_PROPRIETE FROM usager_propriete  ORDER BY DESCRIPTION_USAGER_PROPRIETE ASC');

  $data['provinces']=$this->Model->getList('syst_provinces');
  $this->load->view('Parcelle_info_add_view',$data);
 }
}

//fonction qui genere le mot de passe
public function password_generer()
{
 $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_=+';
 $length = 10;
 $password = '';

 $charCount = strlen($characters);
 for ($i = 0; $i < $length; $i++) {
  $password .= $characters[rand(0, $charCount - 1)];
 }
 return $password;
}


// verification et enregistrement des informations saisie
public function add_info_parcelle()
{
 $user_id=$this->input->post('user_id');

 $PROVINCE_ID=$this->input->post('PROVINCE_ID');
 $COMMUNE_ID=$this->input->post('COMMUNE_ID');
 $ZONE_ID=$this->input->post('ZONE_ID');
 $COLLINE_ID=$this->input->post('COLLINE_ID');

 $this->form_validation->set_rules('NUM_PARCEL','', 'trim|required|is_unique[parcelle.NUMERO_PARCELLE]',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
 $this->form_validation->set_rules('NATURE_DOC','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
 $this->form_validation->set_rules('NUMERO_SPECIAL','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
 $this->form_validation->set_rules('VOLUME','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
 $this->form_validation->set_rules('FOLIO','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));

 $this->form_validation->set_rules('SUPER_HA','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
 $this->form_validation->set_rules('SUPER_ARE','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
 $this->form_validation->set_rules('SUPER_CA','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));

 $this->form_validation->set_rules('PROVINCE_ID','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
 $this->form_validation->set_rules('COMMUNE_ID','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
 $this->form_validation->set_rules('ZONE_ID','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
 $this->form_validation->set_rules('COLLINE_ID','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));

 $this->form_validation->set_rules('USAGE','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
 $this->form_validation->set_rules('NUM_CADASTRE','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
 if($this->form_validation->run()==FALSE)
 {
  $data['user_id']=$this->input->post('user_id');
  $data['type_nature_docs']=$this->Model->getRequete('SELECT ID_DOSSIER,DOSSIER FROM `edrms_dossiers_processus` ORDER BY `DOSSIER` ASC');
  $data['usagers_proprietes']=$this->Model->getRequete('SELECT ID_USAGER_PROPRIETE,DESCRIPTION_USAGER_PROPRIETE FROM usager_propriete  ORDER BY DESCRIPTION_USAGER_PROPRIETE ASC');



  $data['provinces']=$this->Model->getList('syst_provinces');

  if(!empty($this->input->post('PROVINCE_ID')))
  {
   $data['communes']=$this->Model->getList('communes',array('PROVINCE_ID'=>$PROVINCE_ID));     
  }
  else
  {
   $data['communes']=array();
  }



  if(!empty($this->input->post('COMMUNE_ID')))
  {
   $data['zones']=$this->Model->getList('pms_zones',array('COMMUNE_ID'=>$COMMUNE_ID));     
  }
  else
  {
   $data['zones']=array();
  }



  if(!empty($this->input->post('COLLINE_ID')))
  {
   $data['collines']=$this->Model->getList('collines',array('COLLINE_ID'=>$COLLINE_ID));     
  }
  else
  {
   $data['collines']=array();
  }
  $this->load->view('Parcelle_info_add_view',$data);
 }
 else
 {
  $message='';
// Conversion factors
  $haToSqM = 10000;
  $acresToSqM = 100;
  $centiaresToSqM = 0.01;

  $ha = $this->input->post('SUPER_HA');
  $acres = $this->input->post('SUPER_ARE');
  $centiares = $this->input->post('SUPER_CA');

// Convert values to square meters
  $haSqM = $ha * $haToSqM;
  $acresSqM = $acres * $acresToSqM;
  $centiaresSqM = $centiares * $centiaresToSqM;

// Calculate total area
  $totalAreaSqM = $haSqM + $acresSqM + $centiaresSqM;


  $special_caractere=array('/','-','.','"',"'","*",'<','>','|',':','?');
  $avoid_slashes=str_replace($special_caractere,"-",$this->input->post('NUM_PARCEL'));
  $netoyage_avoid_slashes = preg_replace('/[^A-Za-z0-9\-]/', '', $avoid_slashes);

  $get_province_token=$this->Model->getOne('edrms_dossiers_processus_province',array('province_id'=>$this->input->post('PROVINCE_ID'),'dossier_processus_id'=>$this->input->post('NATURE_DOC')));

  $result_alf=$this->pms_alfresco_lib->get_folder_content($get_province_token['token_dossiers_processus_province']);


  $result=$this->pms_api->get_folder_content($this->input->post('NUM_PARCEL'));


$token_repertoire_doc_box='';//le token du dossier de la parcelle
$nom_sous_repertoire_doc_box='';
$token_sous_repertoire_doc_box='';

$response = json_decode($result, true); // Pass true to get an associative array instead of an object
if(isset($response['detail_fold']) && isset($response['detail_fold']['nom_folder']))
{
 if ($response['detail_fold']['nom_folder'] == $this->input->post('NUM_PARCEL')) 
 {
$token_repertoire_doc_box= json_decode($result)->detail_fold->fold_parrent_token; //le token du dossier de la parcelle
$nom_sous_repertoire_doc_box= json_decode($result)->data->dossier[0]->nom_folder;
$token_sous_repertoire_doc_box= json_decode($result)->data->dossier[0]->token;
}
}
else
{
// Handle the case where the expected properties don't exist in the response
// You can log the error, display a user-friendly message, or perform another action
// echo "The expected data structure is not present in the response.";
$token_repertoire_doc_box='';//le token du dossier de la parcelle
$nom_sous_repertoire_doc_box='';
$token_sous_repertoire_doc_box='';
}

$var='';
$id='';
$name='';
$foundMatchRepertoire = false;
$foundMatchSousRepertoire = false;

foreach ($result_alf as $entry)
{
 $entryName = $entry['name'];
// Remove special characters and spaces
 $cleanedEntryName = preg_replace('/[^A-Za-z0-9\-]/', '', $entryName);

 if (strcasecmp($cleanedEntryName, $netoyage_avoid_slashes) == 0)
 {
  $id = $entry['id'];
  $name = $entry['name'];
  $foundMatchRepertoire = true;
break; // Exit the loop after finding the matching entry
}
}

$result_token_sous_repertoire=$this->pms_alfresco_lib->get_folder_content($id); 

$nom_sous_repertoire_alf='';
$token_sous_repertoire_alf='';

foreach ($result_token_sous_repertoire as $entry)
{
 $entryName = $entry['name'];
// Remove special characters and spaces

 $token_sous_repertoire_alf = $entry['id'];
 $nom_sous_repertoire_alf = $entry['name'];
 $foundMatchSousRepertoire = true;
break; // Exit the loop after finding the matching entry
}

if(($response['status']==200) || ($foundMatchRepertoire==true && $foundMatchSousRepertoire==true))
{

 $sf_guard_user_last_id=$this->Model->getOne('sf_guard_user_profile',array('md5(id)'=>$this->input->post('user_id')));

 $data_parcelle=array('NUMERO_PARCELLE'=>$this->input->post('NUM_PARCEL'),
  'SUPERFICIE'=>40,
  'PRIX'=>1000000,
  'STATUT_ID'=>3,
  'PROVINCE_ID'=>$this->input->post('PROVINCE_ID'),
  'COMMUNE_ID'=>$this->input->post('COMMUNE_ID'),
  'ZONE_ID'=>$this->input->post('ZONE_ID'),
  'COLLINE_ID'=>$this->input->post('COLLINE_ID')
 );

 $parcelle_last_id=$this->Model->insert_last_id('parcelle',$data_parcelle);

 $data_parcelle_attribution=array('ID_PARCELLE'=>$parcelle_last_id,
  'ID_REQUERANT'=>$sf_guard_user_last_id['id'],
  'NUMERO_PARCELLE'=>$this->input->post('NUM_PARCEL'),
  'SUPERFICIE'=>40,
  'PRIX'=>1000000,
  'STATUT_ID'=>3,
  'SUPERFICIE_HA'=>$this->input->post('SUPER_HA'),
  'SUPERFICIE_ARE'=>$this->input->post('SUPER_ARE'),
  'SUPERFICIE_CA'=>$this->input->post('SUPER_CA'),
  'PROVINCE_ID'=>$this->input->post('PROVINCE_ID'),
  'COMMUNE_ID'=>$this->input->post('COMMUNE_ID'),
  'ZONE_ID'=>$this->input->post('ZONE_ID'),
  'COLLINE_ID'=>$this->input->post('COLLINE_ID'),
  'NUMERO_CADASTRAL'=>$this->input->post('NUM_CADASTRE'),
  'USAGE_ID'=>$this->input->post('USAGE'),
  'VOLUME'=>$this->input->post('VOLUME'),
  'FOLIO'=>$this->input->post('FOLIO'),
  'NUMERO_ORDRE_SPECIAL'=>$this->input->post('NUMERO_SPECIAL')
 );

 $result_parcelle_attribution=$this->Model->insert_last_id('parcelle_attribution',$data_parcelle_attribution);

 $result_parcelle_new=$this->Model->insert_last_id('edrms_repertoire_processus_parcelle_new',array('dossiers_processus_province_id'=>$get_province_token['id'],'parcelle_id'=>$parcelle_last_id,'numero_parcelle'=>$this->input->post('NUM_PARCEL'),'nom_repertoire_parcelle'=>$name,'token_dossiers_parcelle_processus'=>$id,'DOC_TOKEN'=>$token_repertoire_doc_box,'dossier_id'=>$this->input->post('NATURE_DOC')));

 $this->Model->create('edrms_repertoire_processus_sous_repertoire_new',array('dossier_processus_parcelle_id'=>$result_parcelle_new,'parcelle_id'=>$parcelle_last_id,'nom_sous_repertoire'=>$nom_sous_repertoire_alf,'nom_sous_repertoire_doc'=>$nom_sous_repertoire_doc_box,'token_sous_repertoire'=>$token_sous_repertoire_alf,'DOC_REF_TOKEN'=>$token_sous_repertoire_doc_box,'statut_actualisation'=>1));

 $province=$this->Model->getOne('syst_provinces',array('PROVINCE_ID'=>$this->input->post('PROVINCE_ID')));

 $communes=$this->Model->getRequeteOne('SELECT COMMUNE_NAME FROM communes WHERE COMMUNE_ID='.$this->input->post('COMMUNE_ID').' ');


 $check_existence_requerant=$this->Model->getRequeteOne('SELECT COUNT(ID_PARCELLE) as value FROM parcelle_attribution WHERE md5(ID_REQUERANT)="'.$this->input->post('user_id').'"');

 $subject='Information';

 $messages="Bonjour Mr/Mme ".$sf_guard_user_last_id['fullname'].".Bienvenue sur le système électronique de transfert de titres de propriété (PMS).<br>
 La Direction des Titres Fonciers et Cadastre National (DTFCN) reconnait votre enregistrement en tant que
 propriétaire de la parcelle numéro ".$this->input->post('NUM_PARCEL')." sise à ".$province['PROVINCE_NAME']." dans la commune ".$communes['COMMUNE_NAME'].".<br>Vous aurez, ainsi, la possibilité d’effectuer des demandes de transfert, des mises à jour ou tout autre service en cas de besoin.
 <br>Veuillez-vous connecter dans votre espace personnel et acceder aux informations relatives à vos parcelles.
 <br>Lien :<a href=".base_url('/Login')." target='_blank'>Cliquez-ici</a>";

 $this->notifications->send_mail($sf_guard_user_last_id['email'],$subject,$cc_emails=array(),$messages,$attach=array()); 
 $num_parcelle=$this->Model->getOne('parcelle_attribution',array('ID_REQUERANT'=>$result['id']));

 $message='<div class="alert alert-danger text-center" id="message">'.lang('enregistrement_succes').'</div>';     
}
else
{
 $message='<div class="alert alert-danger text-center" id="message">La parcelle n\'existe ni dans DocBox ou Alfresco</div>';                 
}
$this->session->set_flashdata('message',$message);
redirect(base_url('administration/Numeriser_New/list'));
}    
}

public function getOne($user,$num_parcelle)
{
 $data['user_id']=$user;
 $data['num_parcelle1']=$num_parcelle;
 $data['info']=$this->Model->getRequeteOne('SELECT parcelle_attribution.NUMERO_PARCELLE,
  edrms_repertoire_processus_parcelle_new.dossier_id,
  parcelle_attribution.VOLUME,
  parcelle_attribution.FOLIO,
  parcelle_attribution.NUMERO_ORDRE_SPECIAL,
  parcelle_attribution.SUPERFICIE_HA,
  parcelle_attribution.SUPERFICIE_ARE,
  parcelle_attribution.SUPERFICIE_CA,
  parcelle_attribution.PROVINCE_ID,
  parcelle_attribution.COMMUNE_ID,
  parcelle_attribution.COLLINE_ID,
  parcelle_attribution.ZONE_ID,
  parcelle_attribution.USAGE_ID,
  parcelle_attribution.NUMERO_CADASTRAL
  FROM `sf_guard_user_profile` 
  LEFT JOIN parcelle_attribution on parcelle_attribution.ID_REQUERANT=sf_guard_user_profile.id 
  LEFT JOIN edrms_repertoire_processus_parcelle_new ON edrms_repertoire_processus_parcelle_new.parcelle_id=parcelle_attribution.ID_PARCELLE
  LEFT JOIN edrms_dossiers_processus on edrms_dossiers_processus.ID_DOSSIER=edrms_repertoire_processus_parcelle_new.dossier_id
  WHERE md5(sf_guard_user_profile.id)="'.$user.'" AND md5(parcelle_attribution.NUMERO_PARCELLE)="'.$num_parcelle.'" ');

 $data['type_nature_docs']=$this->Model->getRequete('SELECT ID_DOSSIER,DOSSIER FROM `edrms_dossiers_processus` ORDER BY `DOSSIER` ASC');
 $data['usagers_proprietes']=$this->Model->getRequete('SELECT ID_USAGER_PROPRIETE,DESCRIPTION_USAGER_PROPRIETE FROM usager_propriete  ORDER BY DESCRIPTION_USAGER_PROPRIETE ASC');

 $data['provinces']=$this->Model->getList('syst_provinces');
 $data['communes']=$this->Model->getList('communes',array('PROVINCE_ID'=>$data['info']['PROVINCE_ID']));
 $data['zones']=$this->Model->getList('pms_zones',array('COMMUNE_ID'=>$data['info']['COMMUNE_ID']));
 $data['collines']=$this->Model->getList('collines',array('ZONE_ID'=>$data['info']['ZONE_ID']));
 $this->load->view('Parcelle_info_update_view',$data);
}

// modification des informations saisie
public function update()
{
 $user_id=$this->input->post('user_id');

 $PROVINCE_ID=$this->input->post('PROVINCE_ID');
 $COMMUNE_ID=$this->input->post('COMMUNE_ID');
 $ZONE_ID=$this->input->post('ZONE_ID');
 $COLLINE_ID=$this->input->post('COLLINE_ID');



 $this->form_validation->set_rules('NUM_PARCEL','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
 $this->form_validation->set_rules('NATURE_DOC','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
 $this->form_validation->set_rules('NUMERO_SPECIAL','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
 $this->form_validation->set_rules('VOLUME','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
 $this->form_validation->set_rules('FOLIO','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));

 $this->form_validation->set_rules('SUPER_HA','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
 $this->form_validation->set_rules('SUPER_ARE','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
 $this->form_validation->set_rules('SUPER_CA','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));

 $this->form_validation->set_rules('PROVINCE_ID','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
 $this->form_validation->set_rules('COMMUNE_ID','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
 $this->form_validation->set_rules('ZONE_ID','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
 $this->form_validation->set_rules('COLLINE_ID','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));



 $this->form_validation->set_rules('USAGE', '', 'required', array('required' => 'Le champ est obligatoire.'));

 $this->form_validation->set_rules('NUM_CADASTRE','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));

 if($this->form_validation->run()==FALSE)
 {
  $data['user_id']=$this->input->post('user_id');
  $data['num_parcelle1']=$this->input->post('num_parcelle');
  $data['type_nature_docs']=$this->Model->getRequete('SELECT ID_DOSSIER,DOSSIER FROM `edrms_dossiers_processus` ORDER BY `DOSSIER` ASC');
  $data['usagers_proprietes']=$this->Model->getRequete('SELECT ID_USAGER_PROPRIETE,DESCRIPTION_USAGER_PROPRIETE FROM usager_propriete  ORDER BY DESCRIPTION_USAGER_PROPRIETE ASC');

  $data['info']=$this->Model->getRequeteOne('SELECT parcelle_attribution.NUMERO_PARCELLE,
   edrms_repertoire_processus_parcelle_new.dossier_id,
   parcelle_attribution.VOLUME,
   parcelle_attribution.FOLIO,
   parcelle_attribution.NUMERO_ORDRE_SPECIAL,
   parcelle_attribution.SUPERFICIE_HA,
   parcelle_attribution.SUPERFICIE_ARE,
   parcelle_attribution.SUPERFICIE_CA,
   parcelle_attribution.PROVINCE_ID,
   parcelle_attribution.COMMUNE_ID,
   parcelle_attribution.COLLINE_ID,
   parcelle_attribution.ZONE_ID,
   parcelle_attribution.USAGE_ID,
   parcelle_attribution.NUMERO_CADASTRAL
   FROM `sf_guard_user_profile` 
   LEFT JOIN parcelle_attribution on parcelle_attribution.ID_REQUERANT=sf_guard_user.id 
   LEFT JOIN edrms_repertoire_processus_parcelle_new ON edrms_repertoire_processus_parcelle_new.parcelle_id=parcelle_attribution.ID_PARCELLE
   LEFT JOIN edrms_dossiers_processus on edrms_dossiers_processus.ID_DOSSIER=edrms_repertoire_processus_parcelle_new.dossier_id
   WHERE md5(sf_guard_user_profile.id)="'.$this->input->post('user_id').'" AND md5(parcelle_attribution.NUMERO_PARCELLE)="'.$this->input->post('num_parcelle').'" ');


  $data['provinces']=$this->Model->getList('syst_provinces');

  if(!empty($this->input->post('PROVINCE_ID')))
  {
   $data['communes']=$this->Model->getList('communes',array('PROVINCE_ID'=>$PROVINCE_ID));     
  }
  else
  {
   $data['communes']=array();
  }



  if(!empty($this->input->post('COMMUNE_ID')))
  {
   $data['zones']=$this->Model->getList('pms_zones',array('COMMUNE_ID'=>$COMMUNE_ID));     
  }
  else
  {
   $data['zones']=array();
  }



  if(!empty($this->input->post('COLLINE_ID')))
  {
   $data['collines']=$this->Model->getList('collines',array('COLLINE_ID'=>$COLLINE_ID));     
  }
  else
  {
   $data['collines']=array();
  }

  $this->load->view('Parcelle_info_update_view',$data);
 }
 else
 {
  $message ='<div class="alert alert-success text-center" id="message">La parcelle est déjà attribuée à une autre personne.</div>';

  $check_existence_parcelle=$this->Model->getOne('parcelle_attribution',array('md5(NUMERO_PARCELLE)'=>$this->input->post('NUM_PARCEL'),'md5(ID_REQUERANT)'=>!$this->input->post('user_id')));

  $info=$this->Model->getRequeteOne('SELECT parcelle_attribution.NUMERO_PARCELLE,
   edrms_repertoire_processus_parcelle_new.dossier_id,
   parcelle_attribution.VOLUME,
   parcelle_attribution.FOLIO,
   parcelle_attribution.NUMERO_ORDRE_SPECIAL,
   parcelle_attribution.SUPERFICIE_HA,
   parcelle_attribution.SUPERFICIE_ARE,
   parcelle_attribution.SUPERFICIE_CA,
   parcelle_attribution.PROVINCE_ID,
   parcelle_attribution.COMMUNE_ID,
   parcelle_attribution.COLLINE_ID,
   parcelle_attribution.ZONE_ID,
   parcelle_attribution.USAGE_ID,
   parcelle_attribution.NUMERO_CADASTRAL
   FROM `sf_guard_user_profile` 
   LEFT JOIN parcelle_attribution on parcelle_attribution.ID_REQUERANT=sf_guard_user_profile.id 
   LEFT JOIN edrms_repertoire_processus_parcelle_new ON edrms_repertoire_processus_parcelle_new.parcelle_id=parcelle_attribution.ID_PARCELLE
   LEFT JOIN edrms_dossiers_processus on edrms_dossiers_processus.ID_DOSSIER=edrms_repertoire_processus_parcelle_new.dossier_id
   WHERE md5(sf_guard_user_profile.id)="'.$this->input->post('user_id').'" AND md5(parcelle_attribution.NUMERO_PARCELLE)="'.$this->input->post('num_parcelle').'" ');  

  $var=$this->pms_api->get_folder_content($this->input->post('NUM_PARCEL'));        

  if(empty($check_existence_parcelle))
  {    
   $message='<div class="alert alert-danger text-center" id="message">La parcelle n\'existe pas dans Alfresco</div>';  

   if(json_decode($var)->status==200 && !empty($this->input->post('user_id')))
   {
    $token_parcelle='';

    $token_sous_dossier='';

    $sf_guard_user_last_id=$this->Model->getOne('sf_guard_user_profile',array('md5(id)'=>$this->input->post('user_id')));

    $message='<div class="alert alert-danger text-center" id="message">Cette parcelle n\'exste pas dans Docbox</div>';

    $result=$this->pms_api->get_folder_content($this->input->post('NUM_PARCEL'));

    if(json_decode($result)->detail_fold->nom_folder==$this->input->post('NUM_PARCEL'))
    {
     $data_historique=array('NUMERO_PARCELLE'=> $info['NUMERO_PARCELLE'],
      'DOSSIER_ID'=> $info['dossier_id'],
      'VOLUME'=> $info['VOLUME'],
      'FOLIO'=> $info['FOLIO'],
      'NUMERO_ORDRE_SPECIAL'=> $info['NUMERO_ORDRE_SPECIAL'],
      'SUPERFICIE_HA'=> $info['SUPERFICIE_HA'],
      'SUPERFICIE_ARE'=> $info['SUPERFICIE_ARE'],
      'SUPERFICIE_CA'=> $info['SUPERFICIE_CA'],
      'PROVINCE_ID'=> $info['PROVINCE_ID'],
      'COMMUNE_ID'=> $info['COMMUNE_ID'],
      'COLLINE_ID'=> $info['COLLINE_ID'],
      'ZONE_ID'=> $info['ZONE_ID'],
      'USAGE_ID'=> $info['USAGE_ID'],
      'NUMERO_CADASTRAL'=> $info['NUMERO_CADASTRAL'],
      'USER_ID_CONNECTER'=>$this->session->userdata('PMS_USER_ID')
     );

     $this->Model->create('pms_histo_info_parcelle_requerant',$data_historique);

     $sf_guard_user_last_id=$this->Model->getOne('sf_guard_user_profile',array('md5(id)'=>$this->input->post('user_id')));

     $data_parcelle=array('NUMERO_PARCELLE'=>$this->input->post('NUM_PARCEL'),
      'PROVINCE_ID'=>$this->input->post('PROVINCE_ID'),
      'COMMUNE_ID'=>$this->input->post('COMMUNE_ID'),
      'ZONE_ID'=>$this->input->post('ZONE_ID'),
      'COLLINE_ID'=>$this->input->post('COLLINE_ID')
     );


     $this->Model->update('parcelle',array('md5(NUMERO_PARCELLE)'=>$this->input->post('num_parcelle')),$data_parcelle);

     $data_repertoire_parcelle_new=array(
      'dossiers_processus_province_id'=>"",
      'dossier_id'=>$this->input->post('NATURE_DOC'),
      'parcelle_id'=>$parcelle_last_id['ID_PARCELLE'],
      'numero_parcelle'=>$this->input->post('NUM_PARCEL'),
      'nom_repertoire_parcelle'=>$this->input->post('NUM_PARCEL'),
      'token_dossiers_parcelle_processus'=>json_decode($result)->detail_fold->fold_parrent_token,
      'dossier_id'=>$this->input->post('NATURE_DOC'));

     $result_parcelle_new=$this->Model->update('edrms_repertoire_processus_parcelle_new',array('md5(numero_parcelle)'=>$this->input->post('num_parcelle')),$data_repertoire_parcelle_new);

     $data_parcelle_id=$this->getOne('edrms_repertoire_processus_parcelle_new',array('md5(num_parcelle)'=>$this->input->post('num_parcelle')));

     $data_sous_repertoire_parcelle_new=array(
      'nom_sous_repertoire'=>json_decode($result)->data->dossier[0]->nom_folder,
      'token_sous_repertoire'=>json_decode($result)->data->dossier[0]->token
     );

     if($var->message=="The response was successful")
     {

      $this->Model->update('edrms_repertoire_processus_sous_repertoire_new',array('dossier_processus_parcelle_id'=>$data_parcelle_id['id']),$data_sous_repertoire_parcelle_new);

      $message='<div class="alert alert-success text-center" id="message">Le requerant a été créee avec succès dans BPS</div>';          
     }
     else
     {
      $message='<div class="alert alert-success text-center" id="message">Le requerant n\'à pas été créee avec succès dans BPS</div>';         
     }


     $message='<div class="alert alert-success text-center" id="message">La modification a été effectuée avec succès</div>';

     $this->session->set_flashdata('message',$message);

     redirect(base_url('administration/Numeriser_New/list'));
    }
    $this->session->set_flashdata('message',$message);

    redirect(base_url('administration/Numeriser_New/list'));
   }
   $this->session->set_flashdata('message',$message);

   redirect(base_url('administration/Numeriser_New/list'));
  }
  $this->session->set_flashdata('message',$message);

  redirect(base_url('administration/Numeriser_New/list'));
 }
}

// redirige sur la page d'affichage de la liste des informations
public function list()
{
 $data['message'] = $this->session->flashdata('message');
// $this->load->view('Numerisation_Liste_view',$data);  
 $this->load->view('Numerisation_New_Liste_view',$data);
}

// recupere les informations dans la base
public function listing()
{
 $var_search= !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
 $var_search=str_replace("'","\'",$var_search);

 $query_principal="SELECT parcelle_attribution.statut_bps,NOM_CEDANT,
 parcelle_attribution.ID_ATTRIBUTION,
 sf_guard_user_profile.id,
 sf_guard_user_profile.fullname,
 sf_guard_user_profile.email,
 sf_guard_user_profile.mobile,
 sf_guard_user_profile.statut_api,
 sf_guard_user_profile.registeras,
 sf_guard_user_profile.nom_entreprise
 FROM
 `sf_guard_user_profile` join parcelle_attribution on parcelle_attribution.ID_REQUERANT = sf_guard_user_profile.id
 WHERE
 sf_guard_user_profile.numerise = 1  and sf_guard_user_profile.registeras !=9 and sf_guard_user_profile.email !='' ";
 $limit = '';
 if (isset($_POST['length']) && $_POST['length'] != -1)
 {
  $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
 }

 $order_by=' ORDER BY sf_guard_user_profile.id desc';
 $order_column=array(1,'sf_guard_user_profile.fullname',
  'sf_guard_user_profile.email',
  1,
  1);

 if ($order_by)
 {
  $order_by = isset($_POST['order']) ? ' ORDER BY '.$order_column[$_POST['order']['0']['column']] .'  '.$_POST['order']['0']['dir'] : ' ORDER BY sf_guard_user_profile.id desc';
 }

 $search = !empty($_POST['search']['value']) ? (" AND (sf_guard_user_profile.fullname LIKE '%$var_search%' OR sf_guard_user_profile.email LIKE '%$var_search%' OR `EMAIL` LIKE '%$var_search%') ") : '';

 $critaire = '';
 $order_by=' ORDER BY sf_guard_user_profile.id desc';
 $query_secondaire=$query_principal.' '.$critaire.' '.$search.' '.$order_by.' '.$limit;
 $query_filter = $query_principal.' '.$critaire.' '.$search;

 $fetch_users = $this->Model->datatable($query_secondaire);
 $data = array();
 $u=0;
 foreach ($fetch_users as $row)
 {
  $nbr=$this->Model->getRequeteOne("SELECT COUNT(`NUMERO_PARCELLE`) nbr FROM `parcelle_attribution` WHERE STATUT_ID=3 AND ID_REQUERANT=".$row->id);

  $type_requerant='Personne Physique';
  if($row->registeras==5)
  {
   $type_requerant='Personne Morale';
  }
  if($row->registeras==9)
  {
   $type_requerant='Mandataire';
  }

  $copropr =$this->Model->getRequete("SELECT fullname
   FROM `pms_copropriete_succession`
   WHERE id_attribution =".$row->ID_ATTRIBUTION." and STATUT_MODIFICATION = 0 ") ; 
$nom = '';
  if ($copropr) {
   $nom = '';
   foreach ($copropr as $key => $value) {

    $nom .= ' '.$value['fullname']."<br>";
   }
  }

  if ($row->NOM_CEDANT) {
   $nom = '<span style="">SUCC. <b>' .$row->NOM_CEDANT . '</b></span><br>Représenté(e) par <br> <b>' . $row->fullname . '</b><br>';
  }


  if (empty($nom)) {
   $nom =  $row->fullname;
  }
  $u++; 
  $sub_array=array(); 
  $sub_array[]='<font color="#000000" size=2><label>'.$u.'</label></font>';
  $sub_array[]='<center><font color="#000000" size=2><label>'.$nom.'</label></font> </center>';
  $sub_array[]='<center><font color="#000000" size=2><label>'.$row->email.'</label></font> </center>';
  $sub_array[]='<center><font color="#000000" size=2><label>'.$type_requerant.'</label></font> </center>';     
  $sub_array[] = '
  <center>
  <button 
  onclick="show_list(' . $row->id . ')" 
  style="background-color:#1b7a6c; color:white; border:1px solid #020f12; border-radius:50%; width:40px; height:40px; font-size:14px; text-align:center; padding:0;" 
  class="btn"
  title="Voir les éléments"
  >
  ' . $nbr['nbr'] . '
  </button>
  </center>';


  $btn_historique="";
  $get_hist= $this->Model->getRequeteOne("SELECT * FROM parcelle_attribution_historique where ID_ATTRIBUTION=".$row->ID_ATTRIBUTION);

  if ($get_hist) {
   $btn_historique= '<a href="'.base_url('/administration/Numeriser_New/historique_proprietaires/'.md5($row->id)) .'" 
   class="btn btn-outline-primary btn-sm px-3" title="Historique des propriétaires">
   <i class="fa fa-list"></i>
   </a>';
  }

  $btn_modif ="";
  if ($row->statut_bps==1) {
   $btn_modif =  '<a href="'.base_url('/administration/Numeriser_New/Modifier/'.md5($row->id)) .'" 
   class="btn btn-outline-danger btn-sm px-3" title="Changement du propriétaire">
   <i class="fa fa-user"></i>
   </a>';
  }


  $button='<div class="d-flex justify-content-center gap-2">
  <a href="'.base_url('/administration/Numerisation/info_parcelle/'.md5($row->id)).'"  
  class="btn btn-outline-secondary btn-sm px-3" title="'.lang('ajout_parcelle').'">
  <i class="fa fa-plus-circle me-2"></i>
  </a>
  '.$btn_modif.'
  '.$btn_historique.'
  </div>';            
  $sub_array[]=$button;
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

public function Modifier($ID_REQUERANT='')
{
 $table_attrib=$this->Model->getRequeteOne("SELECT *,communes.COMMUNE_NAME,pms_zones.ZONE_NAME,collines.COLLINE_NAME FROM `parcelle_attribution` LEFT JOIN communes on communes.COMMUNE_ID=parcelle_attribution.COMMUNE_ID LEFT JOIN pms_zones on pms_zones.ZONE_ID=parcelle_attribution.ZONE_ID JOIN collines on collines.COLLINE_ID=parcelle_attribution.COLLINE_ID WHERE md5(ID_REQUERANT)='".$ID_REQUERANT."' ");
 $data['table_attrib'] =$table_attrib;

 $info_req=$this->Model->getRequeteOne("SELECT `id`, `email`, `username`, `password`, `fullname`, `nom_entreprise`, `validate`, `created_at`, `updated_at`, `mobile`, `registeras`, `siege`, `rc`, `profile_pic`, `path_signature`, `path_cni`, `path_doc_notaire`, `path_doc_ordre_notaire`, `cni`, `lieu_delivrance_cni`, `num_doc_notaire`, `provence_id`, `commune_id`, `zone_id`, `colline_id`, `date_naissance`, `systeme_id`, `nif`, `country_code`, `type_demandeur`, `type_document_id`, `sexe_id`, `new_buyer`, `father_fullname`, `mother_fullname`, `numerise`, `date_delivrance`, `statut_api`, `statut_mail`, `boite_postale`, `avenue`, `is_active`, `lettre_nomination`, `atteste_service` FROM `sf_guard_user_profile` WHERE md5(id)='".$ID_REQUERANT."' ");
 $data['info_req'] =$info_req;

 $data['info_req2']=$this->Model->getRequete("SELECT `id_copropriete_succession`,registeras,pms_copropriete_succession.`email`, `fullname`, `nom_entreprise`, `mobile`, `rc`, `profile_pic`, `path_signature`, `path_cni`, `cni`, `lieu_delivrance_cni`, `num_doc_notaire`,  `sexe_id`, `country_code` FROM `pms_copropriete_succession` join parcelle_attribution on parcelle_attribution.ID_ATTRIBUTION =pms_copropriete_succession.id_attribution WHERE  md5(parcelle_attribution.ID_REQUERANT)='".$ID_REQUERANT."' ");

 $infos_cart='';
 $data['infos_cart'] = $infos_cart;
 $data['message'] = $this->session->flashdata('message');

 $id = $this->uri->segment(4);

 $data['types_requerants']=$this->Model->getRequete('SELECT id,name FROM sf_guard_user_categories WHERE id in(1,5) ORDER BY name ASC');

 $data['nationalites']=$this->Model->getRequete('SELECT id,name FROM countries ORDER BY name ASC');

 $data['sexes']=$this->Model->getRequete('SELECT SEXE_ID,DESCRIPTION_SEXE FROM pms_sexe ORDER BY DESCRIPTION_SEXE ASC');

 $data['provinces_naissance']=$this->Model->getList('syst_provinces');

 $data['info_physique']="style='display:block;'";

 $data['info_nationalite']="style='display:block;'";


 $data['info_morale']="style='display:none;'";

 $data['info_prov_naissance']="style='display:block;'";

 $data['info_com_naissance']="style='display:block;'";

 $data['info_zon_naissance']="style='display:block;'";

 $data['info_col_naissance']="style='display:block;'";

 $data['info_copropriete']="style='display:none;'";

 $data['type_nature_docs']=$this->Model->getRequete('SELECT ID_DOSSIER,DOSSIER FROM `edrms_dossiers_processus` ORDER BY `DOSSIER` ASC');

 $data['type_pieces'] =  $this->Model->getRequete("SELECT `PIECE_ID`, `DESCRIPTION` FROM `piece_justificatives` WHERE 1");

 $data['raison_modification'] =  $this->Model->getRequete("SELECT `RAISON_MODIF_ID`, `DESCRIPTION`
  FROM `raison_modification_infos_parcelle`
  ORDER BY (RAISON_MODIF_ID = 0) ASC, RAISON_MODIF_ID desc;
  ;
  ");
// print_r($data['raison_modification']);die();

 $data['usagers_proprietes']=$this->Model->getRequete('SELECT ID_USAGER_PROPRIETE,DESCRIPTION_USAGER_PROPRIETE FROM usager_propriete  ORDER BY DESCRIPTION_USAGER_PROPRIETE ASC');

 $data['provinces']=$this->Model->getList('syst_provinces');
 $this->cart->destroy();
 $this->load->view("ModifierProprietaire_view",$data);

}

public function historique_proprietaires($ID_REQUERANT='')
{
 $get_id =$this->Model->getRequeteOne("SELECT ID_REQUERANT,ID_ATTRIBUTION from parcelle_attribution where md5(ID_REQUERANT)='".$ID_REQUERANT."'");

 $data['ID_REQUERANT'] = $get_id['ID_REQUERANT'] ;
 $data['ID_ATTRIBUTION'] = $get_id['ID_ATTRIBUTION'] ;
 $this->load->view("HistoriqueProrietaire_view",$data);
}

public function listing_historique($ID_REQUERANT='')
{
 $var_search= !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
 $var_search=str_replace("'","\'",$var_search);
 $ID_REQUERANT = $this->input->post('ID_REQUERANT');
 $ID_ATTRIBUTION = $this->input->post('ID_ATTRIBUTION');

 $query_principal="SELECT 
 sf_guard_user_profile.fullname,
 sf_guard_user_profile.email,
 sf_guard_user_profile.mobile,
 sf_guard_user_profile.cni,
 sf_guard_user_profile.rc,
 parcelle_attribution.ID_ATTRIBUTION,
 parcelle_attribution.ID_PARCELLE,
 `ID_REQUERANT`,
 `NUMERO_PARCELLE`,
 `SUPERFICIE`,
 `DATE_INSERTION`,
 `DATE_ATTRIBUTION`,
 `VOLUME`,
 `FOLIO`,
 DESCRIPTION_USAGER_PROPRIETE,
 `TYPE_PARCELLE`,
 `NOM_CEDANT`,
 `USER_ID`,
 `RAISON_MODIF_ID`,
 `AUTRE_RAISON_MODIF`,
 `DATE_MODIFICATION`
 FROM
 `parcelle_attribution`
 LEFT JOIN sf_guard_user_profile ON sf_guard_user_profile.id = parcelle_attribution.ID_REQUERANT
 LEFT JOIN usager_propriete ON usager_propriete.ID_USAGER_PROPRIETE = parcelle_attribution.USAGE_ID
 WHERE parcelle_attribution.ID_ATTRIBUTION ='".$ID_ATTRIBUTION."' ";

 $limit = '';
 if (isset($_POST['length']) && $_POST['length'] != -1)
 {
  $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
 }

 $order_by=' ORDER BY ID_HISTORIQUE ASC';
 $order_column=array(1,'sf_guard_user_profile.fullname',
  'sf_guard_user_profile.email',
  1,
  1);

 if ($order_by)
 {
  $order_by = isset($_POST['order']) ? ' ORDER BY '.$order_column[$_POST['order']['0']['column']] .'  '.$_POST['order']['0']['dir'] : ' ORDER BY sf_guard_user_profile.id desc';
 }

 $search = !empty($_POST['search']['value']) ? (" AND (sf_guard_user_profile.fullname LIKE '%$var_search%' OR sf_guard_user_profile.email LIKE '%$var_search%') ") : '';

 $critaire = '';
 $order_by=' ORDER BY sf_guard_user_profile.id desc';
 $query_secondaire=$query_principal.' '.$critaire.' '.$search.' '.$order_by.' '.$limit;
 $query_filter = $query_principal.' '.$critaire.' '.$search;

 $fetch_users = $this->Model->datatable($query_secondaire);
 $data = array();
 $u=0; 
 foreach ($fetch_users as $row)
 { 
  $nomSucc ="";
  if ($row->TYPE_PARCELLE ==3) {
   $nomSucc ="SUCC.".$row->NOM_CEDANT."<br>"."Représenté(e) par<br>".$row->fullname;
  }

  $get_proprietaire_copropriete = $this->Model->getRequete("SELECT fullname from pms_copropriete_succession JOIN parcelle_attribution on parcelle_attribution.ID_ATTRIBUTION = pms_copropriete_succession.id_attribution where STATUT_MODIFICATION = 0 AND  parcelle_attribution.ID_REQUERANT =".$row->ID_REQUERANT);

  $nomP ="";
  if ($get_proprietaire_copropriete) {
   foreach ($get_proprietaire_copropriete as $value) {
    $nomP .=$value['fullname']."<br>";
   }
  }

  $NOMS = "" ;
  if (!empty($nomSucc)) {
   $NOMS = $nomSucc ;
  }
  if (!empty($nomP)) {
   $NOMS = $nomP ;
  }
  if (empty($NOMS)) {
   $NOMS = $row->fullname ;
  }

  $u++; 
  $sub_array=array(); 

  $sub_array[]='<font color="#000000" size=2><label>'.$u.'</label></font>';
  $sub_array[]='<center><font color="#000000" size=2><label>'.$row->NUMERO_PARCELLE.'</label></font> </center>';
  $sub_array[]='<center><font color="#000000" size=2><label>'.$NOMS.'</label></font> </center>';
  $type_parcel ="Personnelle";
  if ($row->TYPE_PARCELLE==2) {
   $type_parcel ="Copropriété";
  }
  if ($row->TYPE_PARCELLE==3) {
   $type_parcel ="Succession";
  }
  $sub_array[]='<center><font color="#000000" size=2><label>'.$type_parcel.'</label></font> </center>';
//nature
  $sub_array[]='<center><font color="#000000" size=2><label>'.$row->DESCRIPTION_USAGER_PROPRIETE .'</label></font> </center>';

  $sub_array[]='<center><font color="#000000" size=2><label>'.$row->VOLUME.'</label></font> </center>';     
  $sub_array[]='<center><font color="#000000" size=2><label>'.$row->FOLIO.'</label></font> </center>';

  $nbr = $this->Model->getRequeteOne('SELECT COUNT(`ID_ATTRIBUTION`) nbr FROM `parcelle_attribution_historique` WHERE `ID_ATTRIBUTION` ='.$row->ID_ATTRIBUTION);
  $sub_array[] = '
  <center>
  <button 
  onclick="show_list(' . $row->ID_ATTRIBUTION . ')" 
  style="background-color:#1b7a6c; color:white; border:1px solid #020f12; border-radius:50%; width:40px; height:40px; font-size:14px; text-align:center; padding:0;" 
  class="btn"
  title="Voir les éléments"
  >
  ' . $nbr['nbr'] . '
  </button>
  </center>'; 
// listing_historique_ancien
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

//modal; liste des anciens proprietaires
public function listing_historique_ancien($ID_ATTRIBUTION='')
{
 $var_search= !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
 $var_search=str_replace("'","\'",$var_search);

 $query_principal="SELECT `ID_HISTORIQUE`,
 sf_guard_user_profile.fullname,
 sf_guard_user_profile.email,
 sf_guard_user_profile.mobile,
 sf_guard_user_profile.cni,
 sf_guard_user_profile.rc,
 `ID_REQUERANT`,
 raison_modification_infos_parcelle.DESCRIPTION,
 `NUMERO_PARCELLE`,
 `SUPERFICIE`,
 `DATE_INSERTION`,
 `DATE_ATTRIBUTION`,
 `VOLUME`,
 `FOLIO`,
 `USAGE_ID`,
 `TYPE_PARCELLE`,
 `NOM_CEDANT`,
 `USER_ID`,
 parcelle_attribution_historique.RAISON_MODIF_ID,
 `AUTRE_RAISON_MODIF`,
 `DATE_MODIFICATION`
 FROM
 `parcelle_attribution_historique`
 JOIN sf_guard_user_profile ON sf_guard_user_profile.id = parcelle_attribution_historique.ID_REQUERANT
 LEFT join raison_modification_infos_parcelle on raison_modification_infos_parcelle.RAISON_MODIF_ID = parcelle_attribution_historique.RAISON_MODIF_ID
 WHERE parcelle_attribution_historique.ID_ATTRIBUTION ='".$ID_ATTRIBUTION."' ";

 $limit = '';
 if (isset($_POST['length']) && $_POST['length'] != -1)
 {
  $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
 }

 $order_by=' ORDER BY ID_HISTORIQUE ASC';
 $order_column=array(1,'sf_guard_user_profile.fullname',
  'sf_guard_user_profile.email',
  1,
  1);

 if ($order_by)
 {
  $order_by = isset($_POST['order']) ? ' ORDER BY '.$order_column[$_POST['order']['0']['column']] .'  '.$_POST['order']['0']['dir'] : ' ORDER BY sf_guard_user_profile.id desc';
 }

 $search = !empty($_POST['search']['value']) ? (" AND (sf_guard_user_profile.fullname LIKE '%$var_search%' OR sf_guard_user_profile.email LIKE '%$var_search%') ") : '';

 $critaire = '';
 $order_by=' ORDER BY sf_guard_user_profile.id desc';
 $query_secondaire=$query_principal.' '.$critaire.' '.$search.' '.$order_by.' '.$limit;
 $query_filter = $query_principal.' '.$critaire.' '.$search;

 $fetch_users = $this->Model->datatable($query_secondaire);
 $data = array();
 $u=0; 
//  echo "<pre>";
// print_r($fetch_users);die();
 foreach ($fetch_users as $row)
 { 
  $cni_rc = !empty($row->cni) ? $row->cni : $row->rc;
  $nom ="";
  if ($row->NOM_CEDANT) {
   $nom ="SUCC.".$row->NOM_CEDANT."<br>"."Représenté(e) par<br>".$row->fullname;
  }

  $get_proprietaire_copropriete = $this->Model->getRequete("SELECT STATUT_MODIFICATION,fullname,cni,rc,nom_entreprise,email,mobile from pms_copropriete_succession JOIN parcelle_attribution_historique on parcelle_attribution_historique.ID_ATTRIBUTION = pms_copropriete_succession.id_attribution where STATUT_MODIFICATION = 0 AND parcelle_attribution_historique.ID_REQUERANT =".$row->ID_REQUERANT);

  if ($get_proprietaire_copropriete) {
   foreach ($get_proprietaire_copropriete as $value) {
    $nom .=$value['fullname']."<br>";
    // $cni_rc .= !empty($value['cni']) ?? $value['rc'] ;
   }
  }

  if(empty($nom)){
   $nom = $row->fullname;
  }

  $u++; 
  $sub_array=array(); 

  $sub_array[]=$u;
  $sub_array[]= '<font color="#000000" class="text-left" ><label>'.$nom. 
  '</label></font>';
  $sub_array[] = $cni_rc;
  $sub_array[]=$row->VOLUME;     
  $sub_array[]=$row->FOLIO;
  $sub_array[] = ($row->RAISON_MODIF_ID != "0" ? $row->DESCRIPTION : $row->AUTRE_RAISON_MODIF);

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


public function add_in_cart_piece()
{
 $PIECE = $this->upload_file_signature('PIECE');
 $TYPE_PIECE = $this->input->post('TYPE_PIECE');

//  1. Vérification si TYPE_PIECE déjà présent dans le panier
 foreach ($this->cart->contents() as $item) {
  if (
   isset($item['TYPE_PIECE']) &&
   $item['TYPE_PIECE'] == $TYPE_PIECE &&
   isset($item['typecartitem']) &&
   $item['typecartitem'] == 'DATA_CART_FOR_PIECE'
  ) {
// Si déjà présent, on retourne le HTML actuel sans insertion
return $this->generate_cart_html(); // Fonction séparée plus bas
}
}

//  2. Ajout dans le panier
$file_data = array(
 'id' => uniqid(),
 'qty' => 1,
 'price' => 1,
 'name' => 'CI',
 'PIECE' => $PIECE,
 'TYPE_PIECE' => $TYPE_PIECE,
 'typecartitem' => 'DATA_CART_FOR_PIECE'
);

$this->cart->insert($file_data);

//  3. Génération du HTML
return $this->generate_cart_html();
}


private function generate_cart_html()
{
 $html = '';
 $i = 0;

 $html .= '
 <table class="table table-bordered table-hover" style="">
 <thead class="bg-dark text-white">
 <tr>
 <th>Type</th>
 <th>Documents</th>
 <th>Option</th>
 </tr>
 </thead>
 <tbody>'; 

 foreach ($this->cart->contents() as $items) {
  if (strpos($items['typecartitem'], 'DATA_CART_FOR_PIECE') !== false) {
   $i++;
   $type = $this->Model->getRequeteOne("SELECT `DESCRIPTION` FROM `piece_justificatives` WHERE PIECE_ID = " . intval($items['TYPE_PIECE']));

   $html .= '
   <tr>
   <td>' . $type['DESCRIPTION'] . '</td>
   <td>
   <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#show_lett' . $i . '">
   <i class="fa fa-eye"></i> Visualiser
   </a>

   <div class="modal fade" id="show_lett' . $i . '" tabindex="-1" role="dialog" aria-labelledby="modalLabel' . $i . '">
   <div class="modal-dialog modal-lg" role="document">
   <div class="modal-content">
   <div class="modal-header">' . $type['DESCRIPTION'] . '
   <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
   <span aria-hidden="true">&times;</span>
   </button>
   <h4 class="modal-title" id="modalLabel' . $i . '"></h4>
   </div>
   <div class="modal-body">
   <embed src="' . base_url('uploads/doc_scanner/' . $items['PIECE']) . '#toolbar=0" type="application/pdf" width="100%" height="500px" />
   </div>
   <div class="modal-footer">
   <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
   </div>
   </div>
   </div>
   </div>
   </td>
   <td>
   <a class="btn btn-danger btn-sm" title="Supprimer" onclick="remove_documentpiece(\'' . $items['rowid'] . '\')"><i class="fa fa-trash"></i></a>
   </td>
   </tr>';
  }
 }

 $html .= '</tbody></table>';
 echo $html;

}



//suppimer les donnees du panirer
function remove_documentpiece()
{
 $rowid = $this->input->post('rowid');
 $this->cart->remove($rowid);
 $html = "";
 $j = 1;
 $i = 0;
 $html .= '
 <table class="table table-bordered" style="background-color:dark,color:white">
 <thead class="bg-dark text-white">
 <tr>

 <th>Type</th>
 <th>Documents</th>
 <th>Option</th>
 </tr>
 </thead>
 <tbody>';
 foreach ($this->cart->contents() as $items) :
  if (preg_match('/DATA_CART_FOR_PIECE/', $items['typecartitem'])) {
   $psgetrequete = "CALL getRequete(?,?,?,?);";
   $i++;
   $type =  $this->Model->getRequeteOne("SELECT `PIECE_ID`, `DESCRIPTION` FROM `piece_justificatives` WHERE PIECE_ID =".$items['TYPE_PIECE']);
   $html .= '
   <tr>
   <td>' . $type['DESCRIPTION'] . '</td>
   <td>
   <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#show_lett' . $i . '">
   <i class="fa fa-eye"></i> Visualiser
   </a>

   <div class="modal fade" id="show_lett' . $i . '" tabindex="-1" role="dialog" aria-labelledby="modalLabel' . $i . '">
   <div class="modal-dialog modal-lg" role="document">
   <div class="modal-content">
   <div class="modal-header">'.$type['DESCRIPTION'].'
   <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
   <span aria-hidden="true">&times;</span>
   </button>
   <h4 class="modal-title" id="modalLabel' . $i . '">Document de preuve</h4>
   </div>
   <div class="modal-body">
   <embed src="' . base_url('uploads/doc_scanner/' . $items['PIECE']) . '#toolbar=0" type="application/pdf" width="100%" height="500px" />
   </div>
   <div class="modal-footer">
   <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
   </div>
   </div>
   </div>
   </div>
   </td>
   <td>
   <a class="btn btn-danger btn-sm" title="Supprimer" onclick="remove_documentpiece(\'' . $items['rowid'] . '\')"><i class="fa fa-trash"></i></a>
   </td>
   </tr>';
  }
  $j++;
  $i++;
 endforeach;
 $html .= ' </tbody>
 </table>';
 if ($i > 0) {
  $output = array('status' => TRUE, 'cart' => $html);
  echo json_encode($output);
  exit;
 } else {
  $html = '';
  $output = array('status' => TRUE, 'cart' => $html);
  echo json_encode($output);
// exit;
 }

}

public function modifier_info_requerant()
{
 ob_start();
 $PROVINCE_ID1 = $this->input->post('PROVINCE_ID1');
 $COMMUNE_ID1 = $this->input->post('COMMUNE_ID1');
 $ZONE_ID1 = $this->input->post('ZONE_ID1');
 $COLLINE_ID1 = $this->input->post('COLLINE_ID1');
 $redirection = "administration/Numeriser_New/";
 $message = '<div class="alert alert-danger text-center" id="message">L\'adresse e-mail existe déjà dans notre système</div>';

// bbbbbbbbbbbbb
 $ID_REQUERANT = $this->input->post('ancien_requerant');
 $table_attrib=$this->Model->getRequeteOne("SELECT *  FROM `parcelle_attribution` WHERE ID_REQUERANT='".$ID_REQUERANT."' ");
 if (empty($table_attrib['NUMERO_PARCELLE'])) {
  //empecher l'utilisateur de continuer à enregistrer un proprietaire sur une parcelle inexistant
  echo "<span class='text_danger'> Votre parcelle n'existe pas car elle est vide</span>";
  die();
 }

 $datas = array(
  'POURCENTAGE'=>$table_attrib['POURCENTAGE'],
  "USER_ID"=>($table_attrib['USER_ID']) ?? "",
  'ID_ATTRIBUTION'=>($table_attrib['ID_ATTRIBUTION']) ?? '', 
  'ID_PARCELLE'=>($table_attrib['ID_PARCELLE'])?? '', 
  'ID_REQUERANT'=>$table_attrib['ID_REQUERANT'], 
  'NUMERO_PARCELLE'=>$table_attrib['NUMERO_PARCELLE'], 
  'SUPERFICIE'=>$table_attrib['SUPERFICIE'], 
  'PRIX'=>$table_attrib['PRIX'], 
  'STATUT_ID'=>$table_attrib['STATUT_ID'], 
  'PROVINCE_ID'=>$table_attrib['PROVINCE_ID'], 
  'COMMUNE_ID'=>$table_attrib['COMMUNE_ID'], 
  'ZONE_ID'=>$table_attrib['ZONE_ID'], 
  'COLLINE_ID'=>$table_attrib['COLLINE_ID'], 
  'DATE_INSERTION'=>$table_attrib['DATE_INSERTION'], 
  'DATE_ATTRIBUTION'=>$table_attrib['DATE_INSERTION'], 
  'NUMERO_CADASTRAL'=>$table_attrib['NUMERO_CADASTRAL'], 
  'SUPERFICIE_HA'=>$table_attrib['SUPERFICIE_HA'], 
  'SUPERFICIE_ARE'=>$table_attrib['SUPERFICIE_ARE'], 
  'SUPERFICIE_CA'=>$table_attrib['SUPERFICIE_CA'], 
  'COMMENTAIRE'=>$table_attrib['COMMENTAIRE'], 
  'IS_DISPACH'=>$table_attrib['IS_DISPACH'], 
  'VOLUME'=>$table_attrib['VOLUME'], 
  'FOLIO'=>$table_attrib['FOLIO'], 
  'STATUT_PROPRIETAIRE_PARCELLE'=>$table_attrib['STATUT_PROPRIETAIRE_PARCELLE'], 
  'STATUT_FICHE'=>$table_attrib['STATUT_FICHE'], 
  'USAGE_ID'=>$table_attrib['USAGE_ID'], 
  'NUMERO_ORDRE_GENERAL'=>$table_attrib['NUMERO_ORDRE_GENERAL'], 
  'NUMERO_ORDRE_SPECIAL'=>$table_attrib['NUMERO_ORDRE_SPECIAL'], 
  'ID_TRAITEMENT_DEMANDE'=>$table_attrib['ID_TRAITEMENT_DEMANDE'], 
  'STATUT_GENERER_PV'=>$table_attrib['STATUT_GENERER_PV'], 
  'SIGN_TITRE'=>$table_attrib['SIGN_TITRE'], 
  'SIGN_PV_CHEF_CADASTRE'=>$table_attrib['SIGN_PV_CHEF_CADASTRE'], 
  'SIGN_PV_CONSERVATEUR'=>$table_attrib['SIGN_PV_CONSERVATEUR'], 
  'STATUT_LIVRE_ATTRIBUE'=>$table_attrib['STATUT_LIVRE_ATTRIBUE'], 
  'STATUT_GENERER'=>$table_attrib['STATUT_GENERER'], 
  'STATUT_CROQUIS'=>$table_attrib['STATUT_CROQUIS'], 
  'STATUT_ENVOI_BPS'=>$table_attrib['STATUT_ENVOI_BPS'], 
  'FICHE_GENERER'=>$table_attrib['FICHE_GENERER'], 
  'DATE_DELIVRANCE'=>$table_attrib['DATE_DELIVRANCE'], 
  'statut_bps'=>$table_attrib['statut_bps'], 
  'TYPE_PARCELLE'=>$table_attrib['TYPE_PARCELLE'], 
  'IS_MANDATAIRE'=>$table_attrib['IS_MANDATAIRE'],   
  'NOM_CEDANT'=>$table_attrib['NOM_CEDANT'],
  'RAISON_MODIF_ID'=>($table_attrib['RAISON_MODIF_ID']) ?? "",
  'AUTRE_RAISON_MODIF'=>($table_attrib['AUTRE_RAISON_MODIF']) ?? "",
 );

 $this->Model->create('parcelle_attribution_historique',$datas);
 //initialiser les anciens coproprietaires
  $this->Model->update('pms_copropriete_succession', 
   array('id_attribution' =>$table_attrib['ID_ATTRIBUTION']), 
   array('STATUT_MODIFICATION'=>1)
  );


 $info_req=$this->Model->getRequeteOne("SELECT * FROM `sf_guard_user_profile` WHERE id='".$ID_REQUERANT."' ");
// bbbbbbbbbbbbb

// Conversion factors
 $haToSqM = 10000;
 $acresToSqM = 100;
 $centiaresToSqM = 0.01;
 $pourcentage = 1;

 $ha = $this->input->post('SUPER_HA');
 $acres = $this->input->post('SUPER_ARE');
 $centiares = $this->input->post('SUPER_CA');
 $POUR100 = $this->input->post('POUR100');
 $POUR100 = $POUR100 * $pourcentage;

// Convert values to square meters
 $haSqM = $ha * $haToSqM;
 $acresSqM = $acres * $acresToSqM;
 $centiaresSqM = $centiares * $centiaresToSqM;

// Calculate total pourcentage
 $totalAreaSqM = $haSqM + $acresSqM + $centiaresSqM + $POUR100;

// Generation pwd
 $mot_de_passe = $this->password_generer();
 $hashedPassword = password_hash($mot_de_passe, PASSWORD_DEFAULT);
 $special_caractere = array('/', '-', '.', '"', "'", "*", '<', '>', '|', ':', '?');
 $avoid_slashes = str_replace($special_caractere, "-", $this->input->post('NUM_PARCEL'));
 $netoyage_avoid_slashes = preg_replace('/[^A-Za-z0-9\-]/', '', $avoid_slashes);


 $numParcel = $this->input->post('NUM_PARCEL');

 $loginLink = '<a href="' . base_url('/Login') . '" target="_blank">Cliquez-ici</a>';

 $count = count($this->cart->contents());
 $val_attribution = '';
 $mailTo2 = "";
 $nom2 = "";
 $sf_guard_user_last_id2 = null;
 $TYPE_PARCELLE = null;
$firstProcessed = false; // Flag pour suivre le traitement
$currentEmail ="";
//compte du representant de la coproprieté
foreach ($this->cart->contents() as $item) {
 if (preg_match('/FILE/', $item['typecartitem'])) {
  $currentEmail = ($item['type_requerant_id'] == 1) 
  ? $item['EMAIL_PROP'] 
  : $item['EMAIL_REPRESENTANT'];

  if (!$firstProcessed && !empty($currentEmail)) {
   $data_sf_guard_user_profile = [
    'email' => $currentEmail,
    'fullname' => ($item['type_requerant_id'] == 1) 
    ? $item['NOM_PRENOM_PROP'] 
    : $item['NOM_REPRESENTANT'],
    'nom_entreprise' => ($item['type_requerant_id'] == 5) 
    ? $item['NOM_ENTREPRISE'] 
    : "",
    'username' => $currentEmail,
    'password' => $hashedPassword,
    'date_naissance' => ($item['type_requerant_id'] == 1) 
    ? $item['DATE_NAISSANCE'] 
    : '',
    'mobile' => ($item['type_requerant_id'] == 1) 
    ? $item['NUM_TEL_PROP'] 
    : $item['TELEPHONE_REPRESENTANT'],
    'registeras' => $item['type_requerant_id'],
    'date_delivrance' => ($item['type_requerant_id'] == 1) 
    ? $item['DATE_DELIVRANCE'] 
    : "",
    'country_code' => $item['nationalite_id'],
    'lieu_delivrance_cni' => ($item['type_requerant_id'] == 1) 
    ? $item['LIEU_DELIVRANCE'] 
    : "",
    'systeme_id' => 2,
    'cni' => ($item['type_requerant_id'] == 1) 
    ? $item['NUM_CNI_PROP'] 
    : "",
    'rc' => ($item['type_requerant_id'] == 5) 
    ? $item['NIF_RC'] 
    : "",
    'sexe_id' => ($item['type_requerant_id'] == 1) 
    ? $item['SEXE_ID'] 
    : "",
    'path_cni' => ($item['type_requerant_id'] == 1) 
    ? $item['CNI_IMAGE_PROP'] 
    : "",
    'profile_pic' => ($item['type_requerant_id'] == 1) 
    ? $item['PHOTO_PASSEPORT_PROP'] 
    : "",
    'numerise' => 1,
    'father_fullname' => ($item['type_requerant_id'] == 1) 
    ? $item['NOM_PRENOM_PERE'] 
    : '',
    'path_signature' => ($item['type_requerant_id'] == 5) 
    ? $item['SIGNATURE_REPRESENTANT']
    : $item['SIGNATURE_PROP'],
    'provence_id' => $item['PROVINCE_ID'],
    'mother_fullname' => ($item['type_requerant_id'] == 1) 
    ? $item['NOM_PRENOM_MERE'] 
    : '',
    'commune_id' => $item['COMMUNE_ID'],
    'zone_id' => $item['ZONE_ID'],
    'colline_id' => $item['COLLINE_ID']
   ];

   $mailTo2 = $currentEmail;
   $nom2 = ($item['type_requerant_id'] == 1) 
   ? $item['NOM_PRENOM_PROP'] 
   : $item['NOM_REPRESENTANT'];

   $critere = "email = ''";
   $this->Model->delete('sf_guard_user_profile', $critere);

   $sf_guard_user_last_id2 = $this->Model->insert_last_id('sf_guard_user_profile', $data_sf_guard_user_profile);
   $firstProcessed = true;
  }

  $TYPE_PARCELLE = $item['TYPE_PARCELLE'] ?? $this->input->post('type_parcelle');

// Sortir après le premier élément traité
  if ($firstProcessed) break;
 }
}

$critere = "email = ''";
// Suppression des utilisateurs mal enregistrés
$this->Model->delete('sf_guard_user_profile', $critere);

// Enregistrement pour type personnel et succession
$TYPE_PARCELLE = $this->input->post('type_parcelle');
$sf_guard_user_last_id3 =0;
if ($TYPE_PARCELLE != 2) {
 $NOM_PRENOM_PROP = $this->input->post('NOM_PRENOM_PROP2');      
 $SEXE_ID = $this->input->post('SEXE_ID2');
 $nationalite_id = $this->input->post('nationalite_id');      
 $PROVINCE_ID = $this->input->post('PROVINCE_ID');
 $COMMUNE_ID = $this->input->post('COMMUNE_ID');
 $ZONE_ID = $this->input->post('ZONE_ID');
 $COLLINE_ID = $this->input->post('COLLINE_ID');
 $NUM_CNI_PROP = $this->input->post('NUM_CNI_PROP3');
 $DATE_NAISSANCE = $this->input->post('DATE_NAISSANCE');
 $DATE_DELIVRANCE = $this->input->post('DATE_DELIVRANCE');
 $LIEU_DELIVRANCE = $this->input->post('LIEU_DELIVRANCE');
 $EMAIL_PROP = $this->input->post('EMAIL_PROP2');
 $NUM_TEL_PROP = $this->input->post('NUM_TEL_PROP2');
 $NOM_PRENOM_PERE = $this->input->post('NOM_PRENOM_PERE');
 $NOM_PRENOM_MERE = $this->input->post('NOM_PRENOM_MERE');
 $TYPE_PARCELLE = $this->input->post('type_parcelle');

 $SIGNATURE_REPRESENTANT = $this->upload_file_signature('SIGNATURE_REPRESENTANT');
 $type_requerant_id = $this->input->post('type_requerant_id');
 $NOM_ENTREPRISE = $this->input->post('NOM_ENTREPRISE');      
 $NOM_REPRESENTANT = $this->input->post('NOM_REPRESENTANT');
 $EMAIL_REPRESENTANT = $this->input->post('EMAIL_REPRESENTANT');
 $NUM_CNI_PROP = "";

 $TELEPHONE_REPRESENTANT = $this->input->post('TELEPHONE_REPRESENTANT');
 $NIF_RC = $this->input->post('NIF_RC');

 $PROVINCE_ID = $this->input->post('PROVINCE_ID');
 $COMMUNE_ID = $this->input->post('COMMUNE_ID');
 $ZONE_ID = $this->input->post('ZONE_ID');
 $COLLINE_ID = $this->input->post('COLLINE_ID');
 $CNI_IMAGE_PROP = $this->upload_file_signature('CNI_IMAGE_PROP3');
 $PHOTO_PASSEPORT_PROP = $this->upload_file_signature('PHOTO_PASSEPORT_PROP2');
 $SIGNATURE_PROP = $this->upload_file_signature('SIGNATURE_PROP2');

// Utilisateurs de parcel personnel et succession
 $data_sf_guard_user_profile = array(
  'email' => ($EMAIL_PROP) ? $EMAIL_PROP : $EMAIL_REPRESENTANT,
  'fullname' => ($NOM_PRENOM_PROP) ? $NOM_PRENOM_PROP : $NOM_REPRESENTANT,
  'nom_entreprise' => ($NOM_ENTREPRISE) ? $NOM_ENTREPRISE : "",
  'username' => ($EMAIL_PROP) ? $EMAIL_PROP : $EMAIL_REPRESENTANT,
  'password' => $hashedPassword,
  'date_naissance' => ($DATE_NAISSANCE) ? $DATE_NAISSANCE : '',
  'mobile' => ($NUM_TEL_PROP) ? $NUM_TEL_PROP : $TELEPHONE_REPRESENTANT,
  'registeras' => $type_requerant_id,
  'date_delivrance' => ($DATE_DELIVRANCE) ? $DATE_DELIVRANCE : "",
  'country_code' => ($nationalite_id) ? $nationalite_id : $nationalite_id,
  'lieu_delivrance_cni' => ($LIEU_DELIVRANCE) ? $LIEU_DELIVRANCE : "",
  'systeme_id' => 2,
  'cni' => ($NUM_CNI_PROP) ? $NUM_CNI_PROP : "",
  'rc' => ($NIF_RC) ? $NIF_RC : "",
  'sexe_id' => ($SEXE_ID) ? $SEXE_ID : "",
  'path_cni' => ($CNI_IMAGE_PROP) ? $CNI_IMAGE_PROP : "",
  'profile_pic' => ($PHOTO_PASSEPORT_PROP) ? $PHOTO_PASSEPORT_PROP : "",
  'numerise' => 1,
  'father_fullname' => ($NOM_PRENOM_PERE) ? $NOM_PRENOM_PERE : '',
  'path_signature' => ($SIGNATURE_REPRESENTANT) ? $SIGNATURE_REPRESENTANT : $SIGNATURE_PROP,
  'provence_id' => $PROVINCE_ID,         
  'mother_fullname' => ($NOM_PRENOM_MERE) ? $NOM_PRENOM_MERE : '',
  'commune_id' => $COMMUNE_ID,
  'zone_id' => $ZONE_ID,
  'colline_id' => $COLLINE_ID,
 );
 if ($TYPE_PARCELLE !=2) {
  $sf_guard_user_last_id3 = $this->Model->insert_last_id('sf_guard_user_profile', $data_sf_guard_user_profile);     
 }
}


// mettre à jour les infos de la table attribution
$TYPE_PARCELLE = (isset($item['TYPE_PARCELLE'])) ? $item['TYPE_PARCELLE'] : $this->input->post('type_parcelle');


$id_nouveau_requera = ($sf_guard_user_last_id2) ?? $sf_guard_user_last_id3 ;
// echo $id_nouveau_requera ;

$data_parcelle_attribution = array(
 'ID_REQUERANT' => $id_nouveau_requera,
 'USAGE_ID' => ($this->input->post('USAGE')) ?? $table_attrib['USAGE_ID'] ,
 'VOLUME' => ($this->input->post('VOLUME')) ?? $table_attrib['VOLUME'],
 'FOLIO' => ($this->input->post('FOLIO')) ?? $table_attrib['FOLIO'],
 'NUMERO_ORDRE_SPECIAL' => ($this->input->post('NUMERO_SPECIAL')) ?? $table_attrib['NUMERO_ORDRE_SPECIAL'] ,
 'TYPE_PARCELLE' => ($TYPE_PARCELLE) ??  $table_attrib['TYPE_PARCELLE'],
 'NOM_CEDANT' => ($this->input->post('SUCCENDANT')) ?? $table_attrib['NOM_CEDANT'],
 'USER_ID'=>$this->session->userdata('PMS_USER_ID'),
  'RAISON_MODIF_ID'=>$this->input->post('RAISON'),
  'AUTRE_RAISON_MODIF'=>$this->input->post('AUTRE_RAISON'),
  'NOM_CEDANT'=>$this->input->post('SUCCENDANT')
); 

$this->Model->update('parcelle_attribution', 
 array('NUMERO_PARCELLE' =>$table_attrib['NUMERO_PARCELLE'],'ID_REQUERANT' =>$table_attrib['ID_REQUERANT']), 
 $data_parcelle_attribution);

$result_parcelle_attribution = $table_attrib['ID_ATTRIBUTION'];

// Enregistrement des membres de copropriété
$i = 0;
$nom_copropr = "";
foreach ($this->cart->contents() as $item) {
 if (preg_match('/FILE/', $item['typecartitem'])) {
  $i++; 
  $data_copro_success = array(
   'id_attribution' => $result_parcelle_attribution,
   'email' => ($item['type_requerant_id'] == 1) ? $item['EMAIL_PROP'] : $item['EMAIL_REPRESENTANT'],
   'fullname' => ($item['type_requerant_id'] == 1) ? $item['NOM_PRENOM_PROP'] : $item['NOM_REPRESENTANT'],
   'nom_entreprise' => ($item['type_requerant_id'] == 5) ? $item['NOM_ENTREPRISE'] : "",
   'mobile' => ($item['type_requerant_id'] == 1) ? $item['NUM_TEL_PROP'] : $item['TELEPHONE_REPRESENTANT'],
   'rc' => ($item['type_requerant_id'] == 5) ? $item['NIF_RC'] : "",
   'profile_pic' => ($item['type_requerant_id'] == 1) ? $item['PHOTO_PASSEPORT_PROP'] : "",
   'path_signature' => ($item['type_requerant_id'] == 5) ? $item['SIGNATURE_REPRESENTANT'] : $item['SIGNATURE_PROP'],
   'path_cni' => ($item['type_requerant_id'] == 1) ? $item['CNI_IMAGE_PROP'] : "",
   'cni' => ($item['type_requerant_id'] == 1) ? $item['NUM_CNI_PROP'] : "",
   'lieu_delivrance_cni' => ($item['type_requerant_id'] == 1) ? $item['LIEU_DELIVRANCE'] : "",
   'provence_id' => $item['PROVINCE_ID'],   
   'commune_id' => $item['COMMUNE_ID'],
   'zone_id' => $item['ZONE_ID'],
   'colline_id' => $item['COLLINE_ID'],
   'zone_id' => $item['ZONE_ID'],
   'date_naissance' => ($item['type_requerant_id'] == 1) ? $item['DATE_NAISSANCE'] : '',
   'sexe_id' => ($item['type_requerant_id'] == 1) ? $item['SEXE_ID'] : "",
   'father_fullname' => ($item['type_requerant_id'] == 1) ? $item['NOM_PRENOM_PERE'] : '',
   'mother_fullname' => ($item['type_requerant_id'] == 1) ? $item['NOM_PRENOM_MERE'] : '',
   'IS_CHEF' => 0,
   'password' => $hashedPassword2,
   'country_code' => $item['nationalite_id'],
   'registeras' => $item['type_requerant_id'],
  );

  $TYPE_PARCELLE = (isset($item['TYPE_PARCELLE'])) ? $item['TYPE_PARCELLE'] : $this->input->post('type_parcelle');
  $nom_copropr .= ($item['type_requerant_id'] == 1) ? $item['NOM_PRENOM_PROP'] : $item['NOM_REPRESENTANT'].",";

  $this->Model->create("pms_copropriete_succession", $data_copro_success);
 } 
}

$chef = $this->Model->getRequeteOne("SELECT MIN(id_copropriete_succession) id_copropriete_succession FROM pms_copropriete_succession WHERE id_attribution=".$result_parcelle_attribution." ");

if ($chef) {
 $this->Model->update(
  "pms_copropriete_succession",
  array('id_copropriete_succession' => $chef['id_copropriete_succession']),
  array('IS_CHEF' => 1)
 );  
} 
// enregistrement des pieces justificatives
$i = 0;
$nom_copropr = "";
foreach ($this->cart->contents() as $item) {
 if (preg_match('/DATA_CART_FOR_PIECE/', $item['typecartitem'])) {
  $i++; 
  $data = array(
   'ID_ATTRIBUTION' =>$table_attrib['ID_ATTRIBUTION'],
   'PIECE_ID' => $item['TYPE_PIECE'],
   'DOCUMENT' => $item['PIECE']  
  );

  $this->Model->create("piece_modification_infos_parcelle", $data);
 } 
}

// bbbbbbbbbbbbb
$mailTo3 = ($EMAIL_PROP) ? $EMAIL_PROP : $EMAIL_REPRESENTANT;
$nom3 = ($NOM_PRENOM_PROP) ? $NOM_PRENOM_PROP : $NOM_REPRESENTANT;

$mailTo4 = ($mailTo2) ? $mailTo2 : $mailTo3;

$nom4 = ($nom2) ? $nom2 : $nom3;
$succedant = $this->input->post('SUCCENDANT');
$numParcel = $this->input->post('NUM_PARCEL');

$ancien_email = $info_req['email'] ;
$ancien_nom = $info_req['fullname'] ;

$RAISON = $this->input->post('RAISON');
$AUTRE_RAISON_MODIF=$this->input->post('AUTRE_RAISON');
$rezo = $this->Model->getRequeteOne(" SELECT `RAISON_MODIF_ID`, `DESCRIPTION` FROM `raison_modification_infos_parcelle` WHERE `RAISON_MODIF_ID`=".$RAISON);

 $RAISON =($rezo['RAISON_MODIF_ID'] ==0) ? $AUTRE_RAISON_MODIF : $rezo['DESCRIPTION'];

$localite = $this->Model->getRequeteOne(" SELECT NUMERO_PARCELLE, collines.COLLINE_NAME,communes.COMMUNE_NAME,provinces.PROVINCE_NAME FROM `parcelle` LEFT JOIN collines on collines.COLLINE_ID = parcelle.COLLINE_ID LEFT JOIN communes on communes.COMMUNE_ID= parcelle.COMMUNE_ID LEFT JOIN provinces on provinces.PROVINCE_ID = parcelle.PROVINCE_ID WHERE parcelle.ID_PARCELLE =".$table_attrib['ID_PARCELLE'] );

// notification du proprietaire actuel
$messages = "Madame/Monsieur $nom4,<br><br>
Bienvenue sur le Système Électronique de Transfert de Titres de Propriété (PMS).<br><br>
La Direction des Titres Fonciers et du Cadastre National (DTFCN) vous informe que vous êtes désormais enregistré(e) comme propriétaire de la parcelle numéro ".$localite['NUMERO_PARCELLE'].", sise à ".$localite['COLLINE_NAME'].", commune ".$localite['COMMUNE_NAME'].", suite à une opération de $RAISON.<br><br>
Vous êtes habilité(e) à accéder aux services liés à cette parcelle, notamment la demande de transfert, la mise à jour des informations, ou tout autre service foncier.<br><br>
Veuillez trouver ci-dessous vos identifiants de connexion pour accéder à votre espace personnel :<br><br>
•   Lien : $loginLink <br>
•   Nom d'utilisateur : $mailTo4 <br>
•   Mot de passe : $mot_de_passe <br><br>
Nous vous invitons à vous connecter dès maintenant pour consulter les informations liées à votre titre de propriété.<br>
Pour toute assistance, veuillez contacter ou vous rendre à la DTFCN.<br><br>
Cordialement,
Direction des Titres Fonciers et du Cadastre National (DTFCN)";

$this->notifications->send_mail($mailTo4, 'Activation de votre accès au système PMS', [], $messages, []);

//notification d'ancien proprietaire
$messages = "Madame/Monsieur $ancien_nom,<br><br>
La Direction des Titres Fonciers et du Cadastre National (DTFCN) vous informe que la parcelle numéro ".$localite['NUMERO_PARCELLE'].", sise à ".$localite['COLLINE_NAME'].", commune ".$localite['COMMUNE_NAME'].", dont vous étiez précédemment propriétaire, a été transférée à $nom4 dans le cadre d'une opération de $RAISON.<br><br>
Cette mise à jour a été enregistrée dans le Système Électronique de Transfert de Titres de Propriété (PMS), conformément aux pièces justificatives validées.<br><br>
Vous pouvez consulter l’historique des propriétaires via votre espace personnel :<br><br>
•   Lien : $loginLink <br>
•   Nom d'utilisateur : $ancien_email <br><br>
Pour toute information complémentaire ou réclamation, veuillez contacter ou vous rendre à la DTFCN.<br><br>
Cordialement,
Direction des Titres Fonciers et du Cadastre National (DTFCN)";

$this->notifications->send_mail($ancien_email, 'Mise à jour du système PMS', [], $messages, []);

$message = '<div class="alert alert-success text-center" id="message">'.lang('enregistrement_succes').'</div>';
$redirection = "administration/Numeriser_New/list";
$this->session->set_flashdata('message', $message);

$this->session->set_flashdata('message', $message);
redirect(base_url($redirection));
ob_end_flush();
}

// recuperer les informations qui vont servir dans le modal precis des parcelle par rapport au requerant
public function listing1($id)
{
 $var_search= !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
 $var_search=str_replace("'","\'",$var_search);
 $query_principal="SELECT
 syst_provinces.PROVINCE_NAME,
 communes.COMMUNE_NAME,
 pms_zones.ZONE_NAME,
 collines.COLLINE_NAME,
 parcelle_attribution.TYPE_PARCELLE,
 usager_propriete.DESCRIPTION_USAGER_PROPRIETE,
 parcelle_attribution.NUMERO_PARCELLE,
 parcelle_attribution.ID_ATTRIBUTION,
 parcelle_attribution.ID_REQUERANT,
 parcelle_attribution.statut_bps
 FROM
 parcelle_attribution
 LEFT JOIN syst_provinces ON syst_provinces.PROVINCE_ID = parcelle_attribution.PROVINCE_ID
 LEFT JOIN communes ON communes.COMMUNE_ID = parcelle_attribution.COMMUNE_ID
 LEFT JOIN pms_zones ON pms_zones.ZONE_ID = parcelle_attribution.ZONE_ID
 LEFT JOIN collines ON collines.COLLINE_ID = parcelle_attribution.COLLINE_ID
 LEFT JOIN usager_propriete ON usager_propriete.ID_USAGER_PROPRIETE = parcelle_attribution.USAGE_ID
 WHERE
 parcelle_attribution.STATUT_ID=3 
 AND
 parcelle_attribution.ID_REQUERANT =".$id;

 $limit='LIMIT 0,10';
 if(isset($_POST['length']) AND $_POST['length'] != -1)
 {
  $limit='LIMIT '.$_POST["start"].','.$_POST["length"];
 }
 {
  $limit='LIMIT '.$_POST["start"].','.$_POST["length"];
 }
 $order_by='';
 $order_column=array(1,1,1);

 if ($order_by)
 {
  $order_by = isset($_POST['order']) ? ' ORDER BY '.$order_column[$_POST['order']['0']['column']] .'  '.$_POST['order']['0']['dir'] : ' ORDER BY parcelle_attribution.ID_ATTRIBUTION ASC';
 }

 $search = !empty($_POST['search']['value']) ? (" AND (parcelle_attribution.NUMERO_PARCELLE LIKE '%$var_search%') ") : '';

 $critaire = '';

 $query_secondaire=$query_principal.' '.$critaire.' '.$search.' '.$order_by.' '.$limit;
 $query_filter = $query_principal.' '.$critaire.' '.$search;

 $fetch_users = $this->Model->datatable($query_secondaire);
 $data = array();
 $u=0;


 foreach ($fetch_users as $row)
 {   

  $get_req=$this->Model->getRequeteOne('SELECT email,statut_api from sf_guard_user_profile where id='.$row->ID_REQUERANT.'');



  $stat=1;



  if (!empty($get_req))
  {

   $result = $this->pms_api->login($get_req['email']);

// if ( $result->message == 'La ressource est introuvable')
// { 
//   $stat=0;   
// }
  }

  $u++; 
  $sub_array=array(); 

  $TYPE_PARCELLE ="Propriété personnelle";
  if ($row->TYPE_PARCELLE ==2) {
   $TYPE_PARCELLE ="Copropriété";
  }
  if ($row->TYPE_PARCELLE ==3) {
   $TYPE_PARCELLE ="Succession";
  }

  $sub_array[]='<center><font color="#000000" size=2><label>'.$u.'</label></font> </center>'; 
  $sub_array[]='<center><font color="#000000" size=2><label>'.$row->NUMERO_PARCELLE.'</label></font> </center>';
  $sub_array[]='<center><font color="#000000" size=2><label>'.$TYPE_PARCELLE.'</label></font> </center>';
  $sub_array[]='<center><font color="#000000" size=2><label>'.$row->DESCRIPTION_USAGER_PROPRIETE.'</label></font> </center>';
  $sub_array[]='<center><font color="#000000" size=2><label>'.$row->PROVINCE_NAME.'-'.$row->COMMUNE_NAME.'-'.$row->ZONE_NAME.'-'.$row->COLLINE_NAME.'</label></font> </center>';

  $sub_array[]= '             
  <span data-toggle="tooltip" data-placement="top" style=color;  class="actionCust"><a href="'. base_url('administration/Numerisation/details/'.md5($row->ID_REQUERANT)) . '"><i class="fa fa-info-circle"></i>'.lang('detail').'</a></span> 
  <br>';

// if ($stat == 0)statut_api 
  if (!empty($get_req) && ($get_req['statut_api'] == 0))
  {
   $sub_array[]= '             
   <span data-toggle="tooltip" data-placement="top" style=color;  class="actionCust"><a href="'. base_url('administration/Numeriser_New/send_info_requerant/'.md5($row->ID_REQUERANT)) . '"><i class="fa fa-info-circle"></i>Envoyer le requerant dans BPS</a></span>
   <br>';
  }else if ($row->statut_bps == 0) 
  {

   $sub_array[]= '             
   <span data-toggle="tooltip" data-placement="top" style=color;  class="actionCust"><a href="'. base_url('administration/Numerisation/add_new_parcelle_req/'.md5($row->NUMERO_PARCELLE)) . '"><i class="fa fa-info-circle"></i>Envoyer la parcelle dans BPS</a></span>
   <br>';

  }else
  {
   $btn= '             
   <span data-toggle="tooltip" data-placement="top" class="actionCust"><a href="#"><i class="fa fa-info-circle" style="background-color:#218838 !important"></i>La parcelle est déja dans BPS</a></span>
   <br>';
    $get_hist= $this->Model->getRequeteOne('SELECT * FROM parcelle_attribution_historique WHERE ID_ATTRIBUTION='.$row->ID_ATTRIBUTION);

   if ($get_hist) {
   $btn = '             
    <span data-toggle="tooltip" data-placement="top" style=color;  class="actionCust"><a href="'. base_url('administration/Numeriser_New/resend_info_requerant/'.md5($row->ID_REQUERANT)) . '"><i class="fa fa-info-circle"></i>Envoyer le requerant dans BPS</a></span>
    <br>'; 
   }
   $sub_array[]= $btn;
  }
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

// affiche la page de detail des informations d'une parcelle
public function details($id=0)
{
 $info_parcel=$this->Model->getRequeteOne("SELECT 
  VOLUME,
  FOLIO,
  NUMERO_PARCELLE,
  NUMERO_ORDRE_SPECIAL,
  SUPERFICIE_HA,
  SUPERFICIE_ARE,
  SUPERFICIE_CA,
  ID_PARCELLE,
  DATE_INSERTION,
  NUMERO_CADASTRAL,
  usager_propriete.DESCRIPTION_USAGER_PROPRIETE 
  FROM `parcelle_attribution` 
  LEFT JOIN usager_propriete on usager_propriete.ID_USAGER_PROPRIETE=parcelle_attribution.USAGE_ID WHERE md5(ID_REQUERANT)='".$id."' ");

 $ha=!empty($info_parcel['SUPERFICIE_HA']) ? $info_parcel['SUPERFICIE_HA'] : "ha";
 $are=!empty($info_parcel['SUPERFICIE_ARE']) ? $info_parcel['SUPERFICIE_ARE'].' are' : "N/A";
 $ca=!empty($info_parcel['SUPERFICIE_CA']) ? $info_parcel['SUPERFICIE_CA'].' ca' : "N/A";
 $localite=$ha."-".$are."-".$ca;

 $info_proprio=$this->Model->getRequeteOne("SELECT
  sf_guard_user_profile.id,
  sf_guard_user_profile.fullname,
  sf_guard_user_profile.registeras,
  sf_guard_user_profile.father_fullname,
  sf_guard_user_profile.mother_fullname
  FROM
  `sf_guard_user_profile`
  WHERE
  md5(sf_guard_user_profile.id)='".$id."' and numerise=1 ");
 $nature_dossier=$this->Model->getRequeteOne("SELECT edrms_dossiers_processus.DOSSIER 
  FROM `edrms_repertoire_processus_parcelle_new` 
  left JOIN parcelle_attribution on parcelle_attribution.ID_PARCELLE=edrms_repertoire_processus_parcelle_new.parcelle_id
  LEFT JOIN edrms_dossiers_processus on edrms_dossiers_processus.ID_DOSSIER=edrms_repertoire_processus_parcelle_new.dossier_id
  where edrms_repertoire_processus_parcelle_new.parcelle_id=".$info_parcel['ID_PARCELLE']);

 $numero_dossier=$this->Model->getRequeteOne("SELECT edrms_repertoire_processus_sous_repertoire_new.nom_sous_repertoire
  FROM `edrms_repertoire_processus_sous_repertoire_new` 
  LEFT JOIN parcelle_attribution on 
  parcelle_attribution.ID_PARCELLE=edrms_repertoire_processus_sous_repertoire_new.parcelle_id 
  where edrms_repertoire_processus_sous_repertoire_new.parcelle_id=".$info_parcel['ID_PARCELLE']);

 $data['date_insertion']="";
 if(!empty($info_parcel))
 {
  $date = DateTime::createFromFormat('Y-m-d H:i:s', $info_parcel['DATE_INSERTION']);
  $formatted_date = $date->format('d-m-Y');
  $data['date_insertion']=$formatted_date;
 }

 $data['info']=$id;
 $data['info_parcel']=$info_parcel;
 $data['info_proprio']=$info_proprio;
 $data['localite']=$localite;
 $data['nature_dossier']=!empty($nature_dossier) ? $nature_dossier['DOSSIER'] : "N/A";
 $data['numero_dossier']=!empty($numero_dossier) ? $numero_dossier['nom_sous_repertoire'] : "N/A";
 $this->load->view('Numerisation_detail_view',$data);    
} 

public function send_info_requerant($id)
{    
 $result=$this->Model->getRequeteOne('SELECT id, email, username, sf_guard_user_profile.password,nom_entreprise,fullname, validate, created_at, updated_at, mobile, registeras, siege, rc, profile_pic, path_signature, path_cni, path_doc_notaire, cni, lieu_delivrance_cni, num_doc_notaire, provence_id, sf_guard_user_profile.commune_id, date_naissance, systeme_id, nif, country_code, type_demandeur, type_document_id, sexe_id, new_buyer, father_fullname, mother_fullname, numerise, sf_guard_user_profile.date_delivrance,sf_guard_user_profile.zone_id,sf_guard_user_profile.colline_id,boite_postale,avenue FROM sf_guard_user_profile JOIN parcelle_attribution on parcelle_attribution.ID_REQUERANT=sf_guard_user_profile.id  WHERE md5(id)="'.$id.'"');

 $num_parcelle=$this->Model->getOne('parcelle_attribution',array('md5(ID_REQUERANT)'=>$id,'STATUT_ID'=>3));

 $check_existence_token_repertoire=$this->Model->getOne('edrms_repertoire_processus_parcelle_new',array('numero_parcelle'=>$num_parcelle['NUMERO_PARCELLE']));

 $token_repertoire_alfresco=!empty($check_existence_token_repertoire) ? $check_existence_token_repertoire['token_dossiers_parcelle_processus'] : "";

 $token_repertoire_docbox=!empty($check_existence_token_repertoire) ? $check_existence_token_repertoire['DOC_TOKEN'] : "";

 $token_sous_repertoire_alfresco="";
 $token_sous_repertoire_doc_box="";

 if(!empty($check_existence_token_repertoire))
 {
  $check_existence_token_repertoire=$this->Model->getOne('edrms_repertoire_processus_sous_repertoire_new',array('dossier_processus_parcelle_id'=>$check_existence_token_repertoire['id']));
  if(!empty($check_existence_token_repertoire))
  {
   $token_sous_repertoire_alfresco=$check_existence_token_repertoire['token_sous_repertoire'];
   $token_sous_repertoire_doc_box=$check_existence_token_repertoire['DOC_REF_TOKEN'];
  }
 }

 $var='';

 if ($num_parcelle['TYPE_PARCELLE']==2) 
 {
  $succcoprochef = $this->Model->getRequeteOne("SELECT id_attribution,password,country_code,`email`, `fullname`, `nom_entreprise`, `mobile`, `rc`, `profile_pic`, `path_signature`, `path_cni`, `cni`, `lieu_delivrance_cni`, `num_doc_notaire`, `provence_id`, `commune_id`, `zone_id`, `colline_id`, `date_naissance`, `sexe_id`, `father_fullname`, `mother_fullname` FROM `pms_copropriete_succession` WHERE id_attribution=".$num_parcelle['ID_ATTRIBUTION']." AND IS_CHEF=1 ");

  $image=$succcoprochef['profile_pic'];

$extensionsPhoto = array("jpg", "jpeg", "png", "gif"); // Extensions de photos valides

$extension = strtolower(pathinfo($image, PATHINFO_EXTENSION)); // Obtenir l'extension du fichier en minuscules

if (!in_array($extension, $extensionsPhoto) || empty($image)) 
{
 $image="use_user.png";
} 
else
{
 $image=$image;
}

$signature=$succcoprochef['path_signature'];
$signaturecad=$num_parcelle['SIGN_PV_CHEF_CADASTRE'];
$signaturecons=$num_parcelle['SIGN_PV_CONSERVATEUR'];

$extension = strtolower(pathinfo($signature, PATHINFO_EXTENSION)); // Obtenir l'extension du fichier en minuscules
$extensioncad = strtolower(pathinfo($signaturecad, PATHINFO_EXTENSION));
$extensioncons = strtolower(pathinfo($signaturecons, PATHINFO_EXTENSION));

$extension = strtolower(pathinfo($signature, PATHINFO_EXTENSION)); // Obtenir l'extension du fichier en minuscules


if (!in_array($extension, $extensionsPhoto) || empty($signature))
{
 $signature="signature_req.png";
}
else
{
 $signature=$signature;
}


if (!in_array($extensioncons, $extensionsPhoto) || empty($signaturecons))
{
 $signaturecons="signature_req.png";
}
else
{
 $signaturecons=$signaturecons;
}

if (!in_array($extensioncad, $extensionsPhoto) || empty($signaturecad))
{
 $signaturecad="signature_req.png";
} 
else
{
 $signaturecad=$signaturecad;
}

$ext_pdf=".pdf";
$cni_path=$succcoprochef['path_cni'];

$extensionsPhoto = array("jpg", "jpeg", "png", "pdf"); // Extensions de photos valides

$extension = strtolower(pathinfo($cni_path, PATHINFO_EXTENSION)); // Obtenir l'extension du fichier en minuscules


if (!in_array($extension, $extensionsPhoto) || empty($cni_path)) {
 $cni_path="blank.pdf";
} else {
 $cni_path=$cni_path;
}

$succcopro = $this->Model->getRequete("SELECT  `fullname`, `mobile`, `cni`,`country_code`, `provence_id`, `commune_id`, `zone_id`,`sexe_id`,date_naissance, sexe_id, `colline_id`, `father_fullname`, `mother_fullname`,email FROM `pms_copropriete_succession` WHERE id_attribution=".$num_parcelle['ID_ATTRIBUTION']."");


$refchef = $this->Model->getRequeteOne("SELECT  `password`, `fullname`, `registeras` FROM `sf_guard_user_profile` WHERE id=".$num_parcelle['ID_REQUERANT']."");

$dataToSend = [];

// Vérifier si des résultats existent
if (!empty($succcopro)) 
{
 foreach ($succcopro as $row) 
 {

  $dataToSend[] = [
   'fullname' => $row['fullname'] ?? '',
   'country_code' => $row['country_code'] ?? '',
   'mobile' => $row['mobile'] ?? '',
   'cni' => $row['cni'] ?? '',
   'provence_id' => $row['provence_id'] ?? '',
   'commune_id' => $row['commune_id'] ?? '',
   'provence_id' => ($row['provence_id'] < 1) ? '' : $row['provence_id'],
   'commune_id' => ($row['commune_id'] < 1) ? '' : $row['commune_id'],
   'zone_id' => ($row['zone_id'] < 1) ? '' : $row['zone_id'],
   'colline_id' => ($row['colline_id'] < 1) ? '' : $row['colline_id'],
   'father_fullname' => $row['father_fullname'] ?? '',
   'mother_fullname' => $row['mother_fullname'] ?? '',
   'date_naissance' => $row['date_naissance'] ?? '',
   'sexe_id' => ($row['sexe_id'] < 1) ? '1' : $row['sexe_id'],
   'email' => $row['email'] ?? '',         
  ]; 
 }
}  


$SEXEDED= ($succcoprochef['sexe_id'] && $succcoprochef['sexe_id']) ? $succcoprochef['id_attribution'] :1;
$PQSCODE= ($succcoprochef['password']) ? $succcoprochef['password'] :12345;


$remplacerSiVide = function($valeur)
{
// Vérifie si la valeur est vide, nulle ou inférieure à 1
 if (empty($valeur) || $valeur < 1)
 {
return 1000000; // Remplace par 10000 si la condition est vraie       
}
return $valeur; // Sinon, retourne la valeur d'origine
};

// Récupérer les valeurs en remplaçant les vides par "non défini"
$prov = $remplacerSiVide($succcoprochef['provence_id']);
$com = $remplacerSiVide($succcoprochef['commune_id']);
$zon = $remplacerSiVide($succcoprochef['zone_id']);
$col = $remplacerSiVide($succcoprochef['colline_id']);

$var=$this->pms_api->share_copropriete_succession($succcoprochef['id_attribution'],$succcoprochef['email'],$dataToSend,$refchef['password'],$refchef['fullname'],$succcoprochef['mobile'],$succcoprochef['rc'],$succcoprochef['cni'],$succcoprochef['lieu_delivrance_cni'],'',$prov,$com,$zon,$col,$succcoprochef['date_naissance'],$SEXEDED,$succcoprochef['father_fullname'],$succcoprochef['mother_fullname'],$succcoprochef['country_code'],$num_parcelle['NUMERO_PARCELLE'],$num_parcelle['TYPE_PARCELLE'],$num_parcelle['USAGE_ID'],$num_parcelle['NUMERO_CADASTRAL'],$num_parcelle['NUMERO_ORDRE_GENERAL'],$num_parcelle['NUMERO_ORDRE_SPECIAL'],$num_parcelle['SUPERFICIE'],$num_parcelle['SUPERFICIE_HA'],$num_parcelle['SUPERFICIE_ARE'],$num_parcelle['SUPERFICIE_CA'],$num_parcelle['PRIX'],$num_parcelle['VOLUME'],$num_parcelle['FOLIO'],$signaturecad,$signaturecons,$num_parcelle['STATUT_PROPRIETAIRE_PARCELLE'],$token_repertoire_docbox,$token_repertoire_alfresco,$token_sous_repertoire_doc_box,$token_sous_repertoire_alfresco,$image,$signature,$cni_path,$num_parcelle['COLLINE_ID'],$num_parcelle['DATE_ATTRIBUTION'],$refchef['registeras']);
}
// else if($result['registeras']==1)
else if($num_parcelle['TYPE_PARCELLE']==3 || $result['registeras']==1)
{
 $petiteChaine1='.png';
 $petiteChaine2='.jpg';
 $petiteChaine3='.jpeg';

 $image=$result['profile_pic'];

$extensionsPhoto = array("jpg", "jpeg", "png", "gif"); // Extensions de photos valides

$extension = strtolower(pathinfo($image, PATHINFO_EXTENSION)); // Obtenir l'extension du fichier en minuscules


if (!in_array($extension, $extensionsPhoto) || empty($image))
{
 $image="use_user.png";
} 
else
{
 $image=$image;
}



$signature=$result['path_signature'];


$extension = strtolower(pathinfo($signature, PATHINFO_EXTENSION)); // Obtenir l'extension du fichier en minuscules


if (!in_array($extension, $extensionsPhoto) || empty($signature))
{
 $signature="signature_req.png";
} 
else
{
 $signature=$signature;
}

$ext_pdf=".pdf";
$cni_path=$result['path_cni'];

$extensionsPhoto = array("jpg", "jpeg", "png", "pdf"); // Extensions de photos valides

$extension = strtolower(pathinfo($cni_path, PATHINFO_EXTENSION)); // Obtenir l'extension du fichier en minuscules


if (!in_array($extension, $extensionsPhoto) || empty($cni_path))
{
 $cni_path="blank.pdf";
} 
else
{
 $cni_path=$cni_path;
}

$var=array($result['fullname'],$result['username'],$result['email'],$result['password'],$result['mobile'],$result['registeras'],$result['country_code'],$result['provence_id'],$result['commune_id'],$result['date_naissance'],$result['father_fullname'],$result['mother_fullname'],$result['lieu_delivrance_cni'],$result['date_delivrance'],$num_parcelle['NUMERO_PARCELLE'],$image,$signature,$cni_path);






$var=$this->pms_api->share_applicant($result['fullname'],$result['username'],$result['email'],$result['password'],$result['mobile'],$result['registeras'],$result['country_code'],$result['provence_id'],$result['commune_id'],$result['date_naissance'],$result['father_fullname'],$result['mother_fullname'],$result['lieu_delivrance_cni'],$result['date_delivrance'],$num_parcelle['NUMERO_PARCELLE'],
 $num_parcelle['SUPERFICIE'],$num_parcelle['USAGE_ID'],$num_parcelle['PRIX'],$result['nif'],
 $result['zone_id'],$result['colline_id'],$result['sexe_id'],$result['boite_postale'],$result['avenue'],$image,$signature,$cni_path,$num_parcelle['COLLINE_ID'],$token_repertoire_docbox,$token_repertoire_alfresco,$token_sous_repertoire_doc_box,$token_sous_repertoire_alfresco,$result['cni'],$num_parcelle['VOLUME'],$num_parcelle['FOLIO']          
); 
}
else
{
 $volume=strval($num_parcelle['VOLUME']);
 $folio=strval($num_parcelle['FOLIO']);
 $rc=strval($result['rc']);
 $country_code=strval($result['country_code']);
 $mobile=strval($result['mobile']);
 $superficie=strval($num_parcelle['SUPERFICIE']);


 $var=$this->pms_api->shareApplicantMoral(strval($result['fullname']),strval($result['username']),strval($result['password']),strval($mobile),$result['registeras'],$country_code,strval($result['nom_entreprise']),strval($result['boite_postale']),                         
  $result['colline_id'],strval($rc),$result['provence_id'],$result['commune_id'],strval($result['email']),$num_parcelle['COLLINE_ID'],$result['zone_id'],strval($result['path_signature']),                        
  strval($num_parcelle['NUMERO_PARCELLE']),$superficie,$num_parcelle['PRIX'],strval($num_parcelle['USAGE_ID']),strval($token_repertoire_docbox),strval($token_repertoire_alfresco),strval($token_sous_repertoire_doc_box),
  strval($token_sous_repertoire_alfresco),$volume,$folio);
}
//generation pwd
$mot_de_passe=$this->password_generer();
$hashedPassword=password_hash($mot_de_passe,PASSWORD_DEFAULT);
$province=$num_parcelle['PROVINCE_ID'];


if (is_array($var))
{
 if (isset($var['response']))
 {
  $jsonArray = json_decode($var['response'], true);
  $successed=$jsonArray['success'];

 }
} 
elseif (is_object($var))
{
 if (isset($var->data->message))
 {
$successed = 2; // If "message" exists in the nested "data" object
}
elseif (isset($var->data->ID_ATTRIBUTION))
{
$successed = 1; // If "ID_ATTRIBUTION" exists in the nested "data" object
} 
else
{
$successed = 0; // Default value if neither condition is met
}
}


if($successed==1 && $result['registeras']==1)
{       
 $this->Model->update('sf_guard_user_profile',array('md5(id)' => $id),array('statut_api' => 1, 'password' => $mot_de_passe));

//MISE A JOUR DE LA PARCELLE ATTRIBUTION EN CAS DE LA PREMIERE ENREGISTREMENT DE  LA PARCELLE DANS LES ARCHIVES

 $this->Model->update('parcelle_attribution',array('NUMERO_PARCELLE' => $num_parcelle['NUMERO_PARCELLE']),array('statut_bps' => 1));

 $province=$this->Model->getOne('syst_provinces',array('PROVINCE_ID'=>$province));


 $communes=$this->Model->getRequeteOne('SELECT COMMUNE_NAME FROM communes WHERE COMMUNE_ID='.$num_parcelle['COMMUNE_ID'].' ');

 $mailTo=$result['email'];
 $subject='Information';

 $messages="Bonjour Mr/Mme ".$result['fullname'].".Bienvenue sur le système électronique de transfert de titres de propriété (PMS).<br>
 La Direction des Titres Fonciers et Cadastre National (DTFCN) reconnait votre enregistrement en tant que
 propriétaire de la parcelle numéro ".$num_parcelle['NUMERO_PARCELLE']." sise à ".$province['PROVINCE_NAME']." dans la commune ".$communes['COMMUNE_NAME'].".<br>Vous aurez, ainsi, la possibilité d’effectuer des demandes de transfert, des mises à jour ou tout autre service en cas de besoin.";  

 $this->notifications->send_mail($mailTo,$subject,$cc_emails=array(),$messages,$attach=array());

 $message='<div class="alert alert-success text-center" id="message">Le requerant a été créee avec succès dans BPS</div>';          
}
elseif($successed==1 && $result['registeras']==5)
{
 $this->Model->update('sf_guard_user_profile',array('md5(id)'=>$id),array('statut_api'=>1,'password'=>$hashedPassword));

//MISE A JOUR DE LA PARCELLE ATTRIBUTION EN CAS DE LA PREMIERE ENREGISTREMENT DE  LA PARCELLE DANS LES ARCHIVES

 $this->Model->update('parcelle_attribution',array('NUMERO_PARCELLE' => $num_parcelle['NUMERO_PARCELLE']),array('statut_bps' => 1));

 $province=$this->Model->getOne('syst_provinces',array('PROVINCE_ID'=>$num_parcelle['PROVINCE_ID']));


 $communes=$this->Model->getRequeteOne('SELECT COMMUNE_NAME FROM communes WHERE COMMUNE_ID='.$num_parcelle['COMMUNE_ID'].' ');

 $mailTo=$result['email'];
 $subject='Information';

 $messages="Bonjour Mr/Mme Representant ".$result['fullname']." de la société ".$result['nom_entreprise'].".Bienvenue sur le système électronique de transfert de titres de propriété (PMS).<br>
 La Direction des Titres Fonciers et Cadastre National (DTFCN) reconnait votre enregistrement en tant que
 propriétaire de la parcelle numéro ".$num_parcelle['NUMERO_PARCELLE']." sise à ".$province['PROVINCE_NAME']." dans la commune ".$communes['COMMUNE_NAME'].".<br>Vous aurez, ainsi, la possibilité d’effectuer des demandes de transfert, des mises à jour ou tout autre service en cas de besoin. ";  

 $this->notifications->send_mail($mailTo,$subject,$cc_emails=array(),$messages,$attach=array());

 $message='<div class="alert alert-success text-center" id="message">Le requerant a été créee avec succès dans BPS</div>';     
} 
else
{
 if ($successed==2) {
  $message='<div class="alert alert-success text-center" id="message">Désolé, ce numéro de parcelle est déjà attribué.</div>';
 }
 else  
 {
  $message = ($num_parcelle['COLLINE_ID'] < 1) ? '<div class="alert alert-success text-center" id="message">La parcelle n\' a pas de localité</div>' : '<div class="alert alert-success text-center" id="message">Le requerant n\'à pas été créee avec succès dans BPS</div>' ;
 }

}

$this->session->set_flashdata('message',$message);

redirect(base_url('administration/Numeriser_New/list'));
}

public function send_info_requerants($id)
{     
 $result=$this->Model->getRequeteOne('SELECT `id`, `email`, `username`, `password`, `fullname`, `validate`, `created_at`, `updated_at`, `mobile`, `registeras`, `siege`, `rc`, `profile_pic`, `path_signature`, `path_cni`, `path_doc_notaire`, `cni`, `lieu_delivrance_cni`, `num_doc_notaire`, `provence_id`, `commune_id`, `date_naissance`, `systeme_id`, `nif`, `country_code`, `type_demandeur`, `type_document_id`, `sexe_id`, `new_buyer`, `father_fullname`, `mother_fullname`, `numerise`, `date_delivrance`,zone_id,colline_id,boite_postale,avenue FROM `sf_guard_user_profile` WHERE md5(id)="'.$id.'"');

 $num_parcelle=$this->Model->getOne('parcelle_attribution',array('md5(ID_REQUERANT)'=>$id));


 $province=$this->Model->getOne('syst_provinces',array('PROVINCE_ID'=>$result['provence_id']));

 $communes=$this->Model->getRequeteOne('SELECT COMMUNE_NAME FROM communes WHERE COMMUNE_ID='.$result['commune_id'].' ');


 $subject='Information';

 $mailTo="erielandy673@gmail.com";
 $mot_de_passe='12345';

 $messages="Bonjour Mr/Mme ".$result['fullname'].".Bienvenue sur le système électronique de transfert de titres de propriété (PMS).<br>
 La Direction des Titres Fonciers et Cadastre National (DTFCN) reconnait votre enregistrement en tant que
 propriétaire de la parcelle numéro ".$num_parcelle['NUMERO_PARCELLE']." sise à ".$province['PROVINCE_NAME']." dans la commune ".$communes['COMMUNE_NAME'].".<br>Vous aurez, ainsi, la possibilité d’effectuer des demandes de transfert, des mises à jour ou tout autre service en cas de besoin.
 <br>Vous-trouverez ci-dessous vos identifiants de connexion vous permettant d’avoir accès à votre espace personnel et aux informations relatives à vos parcelles.
 <br>Lien :<a href=".base_url('/Login')." target='_blank'>Cliquez-ici</a>
 <br>Nom d'utilisateur : ".$result['email']."
 <br>Mot de passe : ".$mot_de_passe." ";  

 $var=$this->notifications->send_mail($mailTo,$subject,$cc_emails=array(),$messages,$attach=array());

 $message['message']='<div class="alert alert-success text-center" id="message">Le requerant a été créee avec succès dans BPS</div>';          



 $this->session->set_flashdata('message',$message);

 redirect(base_url('administration/Numeriser_New/list'));
}


public function add_new_parcelle_req($id)
{     

 $num_parcelle=$this->Model->getOne('parcelle_attribution',array('md5(NUMERO_PARCELLE)'=>$id));

 $result=$this->Model->getRequeteOne('SELECT `id`, `email`, `username`, `password`,`nom_entreprise`,`fullname`, `validate`, `created_at`, `updated_at`, `mobile`, `registeras`, `siege`, `rc`, `profile_pic`, `path_signature`, `path_cni`, `path_doc_notaire`, `cni`, `lieu_delivrance_cni`, `num_doc_notaire`, `provence_id`, `commune_id`, `date_naissance`, `systeme_id`, `nif`, `country_code`, `type_demandeur`, `type_document_id`, `sexe_id`, `new_buyer`, `father_fullname`, `mother_fullname`, `numerise`, `date_delivrance`,zone_id,colline_id,boite_postale,avenue FROM `sf_guard_user_profile` WHERE id='.$num_parcelle['ID_REQUERANT'].'');


 $check_existence_token_repertoire=$this->Model->getOne('edrms_repertoire_processus_parcelle_new',array('numero_parcelle'=>$num_parcelle['NUMERO_PARCELLE']));

 $token_repertoire_alfresco=!empty($check_existence_token_repertoire) ? $check_existence_token_repertoire['token_dossiers_parcelle_processus'] : "";

 $token_repertoire_docbox=!empty($check_existence_token_repertoire) ? $check_existence_token_repertoire['DOC_TOKEN'] : "";

 $token_sous_repertoire_alfresco="";
 $token_sous_repertoire_doc_box="";

 if(!empty($check_existence_token_repertoire))
 {
  $check_existence_token_repertoire=$this->Model->getOne('edrms_repertoire_processus_sous_repertoire_new',array('dossier_processus_parcelle_id'=>$check_existence_token_repertoire['id']));
  if(!empty($check_existence_token_repertoire))
  {
   $token_sous_repertoire_alfresco=$check_existence_token_repertoire['token_sous_repertoire'];
   $token_sous_repertoire_doc_box=$check_existence_token_repertoire['DOC_REF_TOKEN'];
  }
 }


 $var='';

 $var=$this->pms_api->storeGetEmailApplicant($result['email'],$num_parcelle['NUMERO_PARCELLE'],$num_parcelle['SUPERFICIE'],$num_parcelle['PRIX'],$num_parcelle['STATUT_ID'],$num_parcelle['COLLINE_ID'],$num_parcelle['COLLINE_ID'],$num_parcelle['USAGE_ID'],$num_parcelle['VOLUME'],$num_parcelle['FOLIO'],$token_repertoire_docbox,$token_sous_repertoire_doc_box,$token_repertoire_alfresco,$token_sous_repertoire_alfresco);



 $var=$var['response'];
 $var=json_decode($var);

//generation pwd
 $mot_de_passe=$this->password_generer();
 $hashedPassword=password_hash($mot_de_passe,PASSWORD_DEFAULT);
 $province=$num_parcelle['PROVINCE_ID'];

 if($var->success==1)
 {       
  $this->Model->update('sf_guard_user_profile',array('md5(id)' => $id),array('statut_api' => 1, 'password' => $mot_de_passe));

//MISE A JOUR DE LA PARCELLE ATTRIBUTION EN CAS DE LA PREMIERE ENREGISTREMENT DE  LA PARCELLE DANS LES ARCHIVES

  $this->Model->update('parcelle_attribution',array('NUMERO_PARCELLE' => $num_parcelle['NUMERO_PARCELLE']),array('statut_bps' => 1));


////////////////////////////////////////////////////////////////////////////

  $province=$this->Model->getOne('syst_provinces',array('PROVINCE_ID'=>$province));
  $communes=$this->Model->getRequeteOne('SELECT COMMUNE_NAME FROM communes WHERE COMMUNE_ID='.$num_parcelle['COMMUNE_ID'].' ');

  $mailTo=$result['email'];
  $subject='Information';

  $messages="Bonjour Mr/Mme ".$result['fullname'].".Bienvenue sur le système électronique de transfert de titres de propriété (PMS).<br>
  La Direction des Titres Fonciers et Cadastre National (DTFCN) reconnait votre enregistrement en tant que
  propriétaire de la parcelle numéro ".$num_parcelle['NUMERO_PARCELLE']." sise à ".$province['PROVINCE_NAME']." dans la commune ".$communes['COMMUNE_NAME'].".<br>Vous aurez, ainsi, la possibilité d’effectuer des demandes de transfert, des mises à jour ou tout autre service en cas de besoin.";  

  $this->notifications->send_mail($mailTo,$subject,$cc_emails=array(),$messages,$attach=array());

  $message='<div class="alert alert-success text-center" id="message">Le requerant a été créee avec succès dans BPS</div>';          

 } 
 else
 {
  $message='<div class="alert alert-success text-center" id="message">La parcelle a été enregistrée avec succès dans BPS</div>';         
 }

 $this->session->set_flashdata('message',$message);

 redirect(base_url('administration/Numeriser_New/list'));
}


public function insert_in_cart()
{
 $type_requerant_id = $this->input->post('type_requerant_id');
 $TYPE_PARCELLE = $this->input->post('TYPE_PARCELLE');

// Évite les doublons d'email dans le panier
 foreach ($this->cart->contents() as $item) {
  if ($item['typecartitem'] == 'FILE') {
   if (
    ($type_requerant_id == 1 && $item['EMAIL_PROP'] == $this->input->post('EMAIL_PROP')) ||
    ($type_requerant_id == 5 && $item['EMAIL_REPRESENTANT'] == $this->input->post('EMAIL_REPRESENTANT'))
   ) {
    echo json_encode(['file_html' => '', 'nombre' => count($this->cart->contents())]);
    return;
   }
  }
 }

 if ($type_requerant_id == 1) {
  $file_data = [
   'id' => uniqid(),
   'qty' => 1,
   'price' => 1,
   'name' => 'T',
   'type_requerant_id' => $type_requerant_id,
   'CNI_IMAGE_PROP' => $this->upload_file_signature('CNI_IMAGE_PROP'),
   'PHOTO_PASSEPORT_PROP' => $this->upload_file_signature('PHOTO_PASSEPORT_PROP'),
   'SIGNATURE_PROP' => $this->upload_file_signature('SIGNATURE_PROP'),
   'NOM_PRENOM_PROP' => $this->input->post('NOM_PRENOM_PROP'),
   'SEXE_ID' => $this->input->post('SEXE_ID'),
   'nationalite_id' => $this->input->post('nationalite_id'),
   'PROVINCE_ID' => $this->input->post('PROVINCE_ID'),
   'COMMUNE_ID' => $this->input->post('COMMUNE_ID'),
   'ZONE_ID' => $this->input->post('ZONE_ID'),
   'COLLINE_ID' => $this->input->post('COLLINE_ID'),
   'NUM_CNI_PROP' => $this->input->post('NUM_CNI_PROP'),
   'DATE_NAISSANCE' => $this->input->post('DATE_NAISSANCE'),
   'DATE_DELIVRANCE' => $this->input->post('DATE_DELIVRANCE'),
   'LIEU_DELIVRANCE' => $this->input->post('LIEU_DELIVRANCE'),
   'EMAIL_PROP' => $this->input->post('EMAIL_PROP'),
   'NUM_TEL_PROP' => $this->input->post('NUM_TEL_PROP'),
   'NOM_PRENOM_PERE' => $this->input->post('NOM_PRENOM_PERE'),
   'NOM_PRENOM_MERE' => $this->input->post('NOM_PRENOM_MERE'),
   'TYPE_PARCELLE' => $TYPE_PARCELLE,
   'SUCCENDANT' => $this->input->post('SUCCENDANT'),
   'typecartitem' => 'FILE'
  ];
 } elseif ($type_requerant_id == 5) {
  $file_data = [
   'id' => uniqid(),
   'qty' => 1,
   'price' => 1,
   'name' => 'T',
   'type_requerant_id' => $type_requerant_id,
   'NOM_ENTREPRISE' => $this->input->post('NOM_ENTREPRISE'),
   'NOM_REPRESENTANT' => $this->input->post('NOM_REPRESENTANT'),
   'EMAIL_REPRESENTANT' => $this->input->post('EMAIL_REPRESENTANT'),
   'TELEPHONE_REPRESENTANT' => $this->input->post('TELEPHONE_REPRESENTANT'),
   'NIF_RC' => $this->input->post('NIF_RC'),
   'SIGNATURE_REPRESENTANT' => $this->upload_file_signature('SIGNATURE_REPRESENTANT'),
   'nationalite_id' => $this->input->post('nationalite_id'),
   'PROVINCE_ID' => $this->input->post('PROVINCE_ID'),
   'COMMUNE_ID' => $this->input->post('COMMUNE_ID'),
   'ZONE_ID' => $this->input->post('ZONE_ID'),
   'COLLINE_ID' => $this->input->post('COLLINE_ID'),
   'TYPE_PARCELLE' => $TYPE_PARCELLE,
   'SUCCENDANT' => $this->input->post('SUCCENDANT'),
   'typecartitem' => 'FILE'
  ];
 }

 $this->cart->insert($file_data);

// Génération du tableau
 $file_html = '<table class="table table-bordered table-hover table-striped">';
 $file_html .= '<thead><tr><th>#</th>';

 if ($type_requerant_id == 1) {
  $file_html .= '<th>Type</th><th>Nom complet</th><th>Email</th><th>Téléphone</th><th>CNI</th><th>Action</th>';
 } else {
  $file_html .= '<th>Type</th><th>Représentant</th><th>Email</th><th>Téléphone</th><th>NIF/RC</th><th>Action</th>';
 }

 $file_html .= '</tr></thead><tbody>';

 $i = 0;
 foreach ($this->cart->contents() as $item) {
  if ($item['typecartitem'] != 'FILE') continue;

  $i++;
  $type = $item['type_requerant_id'] == 1 ? 'Physique' : 'Moral';

  $file_html .= '<tr>';
  $file_html .= '<td style="word-wrap: break-word; white-space: normal; max-width: 200px;">' . $i . '</td>';
  $file_html .= '<td style="word-wrap: break-word; white-space: normal; max-width: 200px;">' . $type . '</td>';

  if ($item['type_requerant_id'] == 1) {
   $file_html .= '<td style="word-wrap: break-word; white-space: normal; max-width: 200px;">' . htmlspecialchars($item['NOM_PRENOM_PROP']) . '</td>';
   $file_html .= '<td style="word-wrap: break-word; white-space: normal; max-width: 200px;">' . htmlspecialchars($item['EMAIL_PROP']) . '</td>';
   $file_html .= '<td style="word-wrap: break-word; white-space: normal; max-width: 200px;">' . htmlspecialchars($item['NUM_TEL_PROP']) . '</td>';
   $file_html .= '<td style="word-wrap: break-word; white-space: normal; max-width: 200px;">' . htmlspecialchars($item['NUM_CNI_PROP']) . '</td>';
  } else {
   $file_html .= '<td style="word-wrap: break-word; white-space: normal; max-width: 200px;">' . htmlspecialchars($item['NOM_REPRESENTANT']) . '</td>';
   $file_html .= '<td style="word-wrap: break-word; white-space: normal; max-width: 200px;">' . htmlspecialchars($item['EMAIL_REPRESENTANT']) . '</td>';
   $file_html .= '<td style="word-wrap: break-word; white-space: normal; max-width: 200px;">' . htmlspecialchars($item['TELEPHONE_REPRESENTANT']) . '</td>';
   $file_html .= '<td style="word-wrap: break-word; white-space: normal; max-width: 200px;">' . htmlspecialchars($item['NIF_RC']) . '</td>';
  }

  $file_html .= '<td style="word-wrap: break-word; white-space: normal; max-width: 200px;">
  <input type="hidden" id="rowid' . $i . '" value="' . $item['rowid'] . '">
  <button class="btn btn-danger btn-xs" type="button" onclick="remove_ct(' . $i . ')">x</button>
  </td>';
  $file_html .= '</tr>';
 }

 $file_html .= '</tbody></table>';

 echo json_encode([
  'file_html' => $file_html,
  'nombre' => $i
 ]);
}


public function remove_ct()
{
 $rowid = $this->input->post('rowid');
 $typereq = $this->input->post('typereq');

 $this->cart->remove($rowid);

 $file_html = '';
 $j = 1;
 $i = 0;

 $table_header = '';
 if ($typereq == 1) {
  $table_header = '
  <thead class="bg-dark text-white">
  <tr>
  <th>#</th>
  <th>' . lang('type_requerant') . '</th>
  <th>' . lang('label_nom_users') . '</th>
  <th>' . lang('email') . '</th>
  <th>' . lang('numero_telephone') . '</th>
  <th>' . lang('image_cni_passport') . '</th>
  <th>' . lang('titre_table_action') . '</th>
  </tr>
  </thead>';
 } elseif ($typereq == 5) {
  $table_header = '
  <thead class="bg-dark text-white">
  <tr>
  <th>#</th>
  <th>' . lang('type_requerant') . '</th>
  <th>Nom entreprise</th>
  <th>Nom représentant</th>
  <th>Email représentant</th>
  <th>Téléphone représentant</th>
  <th>NIF/RC</th>
  <th>Action</th>
  </tr>
  </thead>';
 }

 $file_html .= '<div class="table-responsive"><table class="table table-bordered table-striped table-hover" style="table-layout: fixed; word-wrap: break-word;">';
 $file_html .= $table_header . '<tbody>';

 foreach ($this->cart->contents() as $item) {
  if (preg_match('/FILE/', $item['typecartitem'])) {
   $type_requerant = ($item['type_requerant_id'] == 1) ? 'Physique' : 'Moral';

   if ($item['type_requerant_id'] == 1) {
    $file_html .= '
    <tr>
    <td>' . $j . '</td>
    <td>' . $type_requerant . '</td>
    <td>' . htmlspecialchars($item['NOM_PRENOM_PROP']) . '</td>
    <td>' . htmlspecialchars($item['EMAIL_PROP']) . '</td>
    <td>' . htmlspecialchars($item['NUM_TEL_PROP']) . '</td>
    <td>' . htmlspecialchars($item['NUM_CNI_PROP']) . '</td>
    <td>
    <input type="hidden" id="rowid' . $j . '" value="' . $item['rowid'] . '">
    <input type="hidden" id="typereq' . $j . '" value="' . $item['type_requerant_id'] . '">
    <button class="btn btn-danger btn-xs" type="button" onclick="remove_ct(' . $j . ')">
    <i class="fa fa-trash"></i>
    </button>
    </td>
    </tr>';
   }

   if ($item['type_requerant_id'] == 5) {
    $file_html .= '
    <tr>
    <td>' . $j . '</td>
    <td>' . $type_requerant . '</td>
    <td>' . htmlspecialchars($item['NOM_ENTREPRISE']) . '</td>
    <td>' . htmlspecialchars($item['NOM_REPRESENTANT']) . '</td>
    <td>' . htmlspecialchars($item['EMAIL_REPRESENTANT']) . '</td>
    <td>' . htmlspecialchars($item['TELEPHONE_REPRESENTANT']) . '</td>
    <td>' . htmlspecialchars($item['NIF_RC']) . '</td>
    <td>
    <input type="hidden" id="rowid' . $j . '" value="' . $item['rowid'] . '">
    <input type="hidden" id="typereq' . $j . '" value="' . $item['type_requerant_id'] . '">
    <button class="btn btn-danger btn-xs" type="button" onclick="remove_ct(' . $j . ')">
    <i class="fa fa-trash"></i>
    </button>
    </td>
    </tr>';
   }

   $j++;
   $i++;
  }
 }

 $file_html .= '</tbody></table></div>';

 $file2 = "<script>
 function remove_select(){
  $('#type_requerant_id').prop('disabled', false);
  $('#hide_suivant').hide();
 }
 remove_select();
 </script>";

 echo ($i > 0) ? $file_html : $file2;
}


// }



function verify_email()
{

 $email=$this->input->post('EMAIL');


 $result=$this->Model->getRequeteOne('SELECT email from sf_guard_user_profile where email="'.$email.'"');

 $data=$this->pms_api->login($email);
 $email_api = $data->data->email;

 if ($data && isset($data->data) && isset($data->data->email)) {
  $email_api = $data->data->email;
  if ($email_api === $email) {
   $statu = 3;
  }
 }
 $statut=0;

 if (empty($result)) 
 {
  $statut=1;
 }


 echo json_decode($statut);
}

// reenvoyer le nouveau requerant si la parcelle à changer son propriétaire
public function resend_info_requerant($id)
{    
 $result=$this->Model->getRequeteOne('SELECT id, email,path_doc_ordre_notaire, username, sf_guard_user_profile.password,nom_entreprise,fullname, validate, created_at, updated_at, mobile, registeras, siege, rc, profile_pic, path_signature, path_cni, path_doc_notaire, cni, lieu_delivrance_cni, num_doc_notaire, provence_id, sf_guard_user_profile.commune_id, date_naissance, systeme_id, nif, country_code, type_demandeur, type_document_id, sexe_id, new_buyer, father_fullname, mother_fullname, numerise, sf_guard_user_profile.date_delivrance,sf_guard_user_profile.zone_id,sf_guard_user_profile.colline_id,boite_postale,avenue FROM sf_guard_user_profile JOIN parcelle_attribution on parcelle_attribution.ID_REQUERANT=sf_guard_user_profile.id  WHERE md5(id)="'.$id.'"');

 $num_parcelle=$this->Model->getOne('parcelle_attribution',array('md5(ID_REQUERANT)'=>$id,'STATUT_ID'=>3,'statut_bps'=>1)); 

 $check_existence_token_repertoire=$this->Model->getOne('edrms_repertoire_processus_parcelle_new',array('numero_parcelle'=>($num_parcelle['NUMERO_PARCELLE']) ?? 0));

 $token_repertoire_alfresco=!empty($check_existence_token_repertoire) ? $check_existence_token_repertoire['token_dossiers_parcelle_processus'] : "";

 $token_repertoire_docbox=!empty($check_existence_token_repertoire) ? $check_existence_token_repertoire['DOC_TOKEN'] : "";

 $token_sous_repertoire_alfresco="";
 $token_sous_repertoire_doc_box="";

 if(!empty($check_existence_token_repertoire))
 {
  $check_existence_token_repertoire=$this->Model->getOne('edrms_repertoire_processus_sous_repertoire_new',array('dossier_processus_parcelle_id'=>$check_existence_token_repertoire['id']));
  if(!empty($check_existence_token_repertoire))
  {
   $token_sous_repertoire_alfresco=$check_existence_token_repertoire['token_sous_repertoire'];
   $token_sous_repertoire_doc_box=$check_existence_token_repertoire['DOC_REF_TOKEN'];
  }
 }

 $var='';
 $succcoprochef = $this->Model->getRequeteOne("SELECT IS_CHEF,id_attribution,password,country_code,`email`, `fullname`, `nom_entreprise`, `mobile`, `rc`, `profile_pic`, `path_signature`, `path_cni`, `cni`, `lieu_delivrance_cni`, `num_doc_notaire`, `provence_id`, `commune_id`, `zone_id`, `colline_id`, `date_naissance`, `sexe_id`, `father_fullname`, `mother_fullname` FROM `pms_copropriete_succession` WHERE id_attribution=".$num_parcelle['ID_ATTRIBUTION']." AND IS_CHEF=1 AND STATUT_MODIFICATION = 0 ");

 $image=!empty($succcoprochef['profile_pic']) ? $succcoprochef['profile_pic'] : $result['profile_pic'] ;

$extensionsPhoto = array("jpg", "jpeg", "png", "gif"); // Extensions de photos valides

$extension = strtolower(pathinfo($image, PATHINFO_EXTENSION)); // Obtenir l'extension du fichier en minuscules


if (!in_array($extension, $extensionsPhoto) || empty($image)) 
{
 $image="use_user.png";
} 
else
{
 $image=$image;
}

$signature=!empty($succcoprochef['path_signature']) ? $succcoprochef['path_signature'] : $result['path_signature'];
$signaturecad=$num_parcelle['SIGN_PV_CHEF_CADASTRE'];
$signaturecons=$num_parcelle['SIGN_PV_CONSERVATEUR'];

$extension = strtolower(pathinfo($signature, PATHINFO_EXTENSION)); // Obtenir l'extension du fichier en minuscules
$extensioncad = strtolower(pathinfo($signaturecad, PATHINFO_EXTENSION));
$extensioncons = strtolower(pathinfo($signaturecons, PATHINFO_EXTENSION));

$extension = strtolower(pathinfo($signature, PATHINFO_EXTENSION)); // Obtenir l'extension du fichier en minuscules

if (!in_array($extension, $extensionsPhoto) || empty($signature))
{
 $signature="signature_req.png";
}
else
{
 $signature=$signature;
}

if (!in_array($extensioncons, $extensionsPhoto) || empty($signaturecons))
{
 $signaturecons="signature_req.png";
}
else
{
 $signaturecons=$signaturecons;
}

if (!in_array($extensioncad, $extensionsPhoto) || empty($signaturecad))
{
 $signaturecad="signature_req.png";
} 
else
{
 $signaturecad=$signaturecad;
}

$ext_pdf=".pdf";
$cni_path=!empty($succcoprochef['path_cni']) ? $succcoprochef['path_cni'] : $result['path_cni'];

$extensionsPhoto = array("jpg", "jpeg", "png", "pdf"); // Extensions de photos valides

$extension = strtolower(pathinfo($cni_path, PATHINFO_EXTENSION)); // Obtenir l'extension du fichier en minuscules

if (!in_array($extension, $extensionsPhoto) || empty($cni_path)) {
 $cni_path="blank.pdf";
} else {
 $cni_path=$cni_path;
}

$succcopro = $this->Model->getRequete("SELECT  `id_attribution`,
 `email`,
 `fullname`,
 `nom_entreprise`,
 `mobile`,
 `rc`,
 `profile_pic`,
 `path_signature`,
 `path_cni`,
 `cni`,
 `lieu_delivrance_cni`,
 `num_doc_notaire`,
 `provence_id`,
 `commune_id`,
 `zone_id`,
 `colline_id`,
 `date_naissance`,
 `sexe_id`,
 `father_fullname`,
 `mother_fullname`,
 `country_code`,
 `password`,
 `IS_CHEF`,
 `registeras`,
 `STATUT_MODIFICATION` FROM `pms_copropriete_succession` WHERE id_attribution=".$num_parcelle['ID_ATTRIBUTION']." AND STATUT_MODIFICATION = 0 ");

$refchef = $this->Model->getRequeteOne("SELECT  `password`, `fullname`, `registeras` FROM `sf_guard_user_profile` WHERE id=".$num_parcelle['ID_REQUERANT']."");

$dataToSend = [];

if (!empty($succcopro)) {
 foreach ($succcopro as $row) {
  $dataToSend[] = [
   'fullname'         => $row['fullname']         ?? '',
   'country_code'     => !empty($row['country_code']) ? $row['country_code'] : '',
   'mobile'           => $row['mobile']           ?? '',
   'cni'              => $row['cni']              ?? '',
   'provence_id'      => (!empty($row['provence_id']) && $row['provence_id'] > 0) ? $row['provence_id'] : '',
   'commune_id'       => (!empty($row['commune_id']) && $row['commune_id'] > 0) ? $row['commune_id'] : '',
   'zone_id'          => (!empty($row['zone_id']) && $row['zone_id'] > 0) ? $row['zone_id'] : '',
   'colline_id'       => (!empty($row['colline_id']) && $row['colline_id'] > 0) ? $row['colline_id'] : '',
   'father_fullname'  => $row['father_fullname']  ?? '',
   'mother_fullname'  => $row['mother_fullname']  ?? '',
   'date_naissance'   => $row['date_naissance']   ?? '',
   'sexe_id'          => (!empty($row['sexe_id']) && $row['sexe_id'] > 0) ? $row['sexe_id'] : '1',
   'email'            => $row['email']            ?? '',
   'registeras'       => $row['registeras']       ?? '',
  ];
 }
}



$remplacerSiVide = function($valeur)
{
// Vérifie si la valeur est vide, nulle ou inférieure à 1
 if (empty($valeur) || $valeur < 1)
 {
return 1000000; // Remplace par 10000 si la condition est vraie       
}
return $valeur; // Sinon, retourne la valeur d'origine
};

// Récupérer les valeurs en remplaçant les vides par "non défini"
$prov = $remplacerSiVide(($succcoprochef['provence_id']) ?? $result['provence_id']);
$com = $remplacerSiVide(($succcoprochef['commune_id']) ?? $result['commune_id']);
$zon = $remplacerSiVide(($succcoprochef['zone_id']) ?? $result['zone_id']);
$col = $remplacerSiVide(($succcoprochef['colline_id']) ?? $result['colline_id']);

// API SendNewRequerant
$ID_ATTRIBUTION = $num_parcelle['NUMERO_PARCELLE'];
$fullname = $succcoprochef['fullname'] ?? $result['fullname'] ;
$email = $succcoprochef['email'] ?? $result['email'] ;
$username = $succcoprochef['username'] ?? $result['username'] ;
$password = $succcoprochef['password'] ?? $result['password'] ;
$nom_entreprise = $succcoprochef['nom_entreprise'] ?? $result['nom_entreprise'] ;
$mobile = $succcoprochef['mobile'] ?? $result['mobile'] ;
$cni = $succcoprochef['cni'] ?? $result['cni'] ;
$rc = $succcoprochef['rc'] ?? $result['rc'] ;
$registeras = $succcoprochef['registeras'] ?? $result['registeras'] ;
$path_doc_notaire =  $result['path_doc_notaire'];
$path_doc_ordre_notaire = $succcoprochef['path_doc_ordre_notaire'] ?? $result['path_doc_ordre_notaire'];
$lieu_delivrance_cni = $succcoprochef['lieu_delivrance_cni'] ?? $result['lieu_delivrance_cni'];
$provence_id = $succcoprochef['provence_id'] ?? $result['provence_id'];
$commune_id = $succcoprochef['commune_id'] ?? $result['commune_id'];
$zone_id = $succcoprochef['zone_id'] ?? $result['zone_id'];
$colline_id = $succcoprochef['colline_id'] ?? $result['colline_id'];
$date_naissance = $succcoprochef['date_naissance'] ?? $result['date_naissance'];
$nif = $succcoprochef['nif'] ?? $result['nif'];
$country_code = $succcoprochef['country_code'] ?? $result['country_code'];
$type_document_id = $succcoprochef['type_document_id'] ?? $result['type_document_id'];
$sexe_id = $succcoprochef['sexe_id'] ?? $result['sexe_id'];
$father_fullname = $succcoprochef['father_fullname'] ?? $result['father_fullname'];
$mother_fullname = $succcoprochef['mother_fullname'] ?? $result['mother_fullname'];
$date_delivrance = $succcoprochef['date_delivrance'] ?? $result['date_delivrance'];
$systeme_id = $succcoprochef['systeme_id'] ?? $result['systeme_id'];

$reseau_social = "";
$siege = $succcoprochef['siege'] ?? $result['siege'];
$num_doc_notaire = $succcoprochef['num_doc_notaire'] ?? $result['num_doc_notaire'];
$type_demandeur = $succcoprochef['type_demandeur'] ?? $result['type_demandeur'];
$new_buyer = $succcoprochef['new_buyer'] ?? $result['new_buyer'];
$boite_postale = $succcoprochef['boite_postale'] ?? $result['boite_postale'];

$ALF_TOKEN = "";
$ALF_REF_TOKEN = "";
$AUTRE_RAISON_MODIF = !empty($num_parcelle['AUTRE_RAISON_MODIF']) ?? "";
// $IS_CHEF= 0;
$IS_CHEF = ($num_parcelle['IS_CHEF']) ?? 0;
$POURCENTAGE = ($num_parcelle['POURCENTAGE']) ?? 0;
$RAISON_MODIF_ID = ($num_parcelle['RAISON_MODIF_ID']) ?? 0;
$NOM_CEDANT = ($num_parcelle['NOM_CEDANT']) ?? '';

$var = $this->pms_api->SendNewRequerant(
 $num_parcelle['USER_ID'],
 $num_parcelle['TYPE_PARCELLE'],
 $RAISON_MODIF_ID,
 $num_parcelle['NUMERO_PARCELLE'],
 $num_parcelle['STATUT_ENVOI_BPS'],
 $num_parcelle['statut_bps'],
 $IS_CHEF,
 $num_parcelle['IS_MANDATAIRE'],
 $NOM_CEDANT,
 $POURCENTAGE,
 $num_parcelle['IS_COPROPRIETE'],
 $num_parcelle['USER_ID'],
 $email,
 $username,
 $password,
 $fullname,
 $mobile,
 $provence_id,
 $commune_id,
 $zone_id,
 $colline_id,
 $systeme_id,
 $country_code,
 $registeras,
 $reseau_social,
 $siege,
 $rc,
 $cni,
 $num_doc_notaire,
 $date_naissance,
 $nif,
 $type_demandeur,
 $type_document_id,
 $sexe_id,
 $new_buyer,
 $father_fullname,
 $mother_fullname,
 $boite_postale,
 $lieu_delivrance_cni,
 $date_delivrance,
 $token_repertoire_docbox,
 $token_repertoire_alfresco,
 $token_sous_repertoire_doc_box,
 $token_sous_repertoire_alfresco,
 $AUTRE_RAISON_MODIF,
 $nom_entreprise,
 $lieu_delivrance_cni,
 $path_doc_notaire,
 $image,
 $signature,
 $cni_path,
 $num_parcelle['VOLUME'],
 $num_parcelle['FOLIO'],
 $dataToSend

);

// }
// bbbbbbbbbbbbbbbbb
$mot_de_passe=$this->password_generer();
$hashedPassword=password_hash($mot_de_passe,PASSWORD_DEFAULT);
$province=$num_parcelle['PROVINCE_ID'];


if (is_array($var))
{
 if (isset($var['response']))
 {
  $jsonArray = json_decode($var['response'], true);
  $successed=$jsonArray['success'];

 }
} 
elseif (is_object($var))
{
 if (isset($var->data->message))
 {
$successed = 2; // If "message" exists in the nested "data" object
}
elseif (isset($var->data->ID_ATTRIBUTION))
{
$successed = 1; // If "ID_ATTRIBUTION" exists in the nested "data" object
} 
else
{
$successed = 0; // Default value if neither condition is met
}
}
// bbbbbbbbbbbbbbb

if($successed==1 && $result['registeras']==1)
{       
 $this->Model->update('sf_guard_user_profile',array('md5(id)' => $id),array('statut_api' => 1, 'password' => $mot_de_passe));

//MISE A JOUR DE LA PARCELLE ATTRIBUTION EN CAS DE LA PREMIERE ENREGISTREMENT DE  LA PARCELLE DANS LES ARCHIVES

 $this->Model->update('parcelle_attribution',array('NUMERO_PARCELLE' => $num_parcelle['NUMERO_PARCELLE']),array('statut_bps' => 1));

 $province=$this->Model->getOne('syst_provinces',array('PROVINCE_ID'=>$province));


 $communes=$this->Model->getRequeteOne('SELECT COMMUNE_NAME FROM communes WHERE COMMUNE_ID='.$num_parcelle['COMMUNE_ID'].' ');

 $mailTo=$result['email'];
 $subject='Information';

 $messages="Bonjour Mr/Mme ".$result['fullname'].".Bienvenue sur le système électronique de transfert de titres de propriété (PMS).<br>
 La Direction des Titres Fonciers et Cadastre National (DTFCN) reconnait votre enregistrement en tant que
 propriétaire de la parcelle numéro ".$num_parcelle['NUMERO_PARCELLE']." sise à ".$province['PROVINCE_NAME']." dans la commune ".$communes['COMMUNE_NAME'].".<br>Vous aurez, ainsi, la possibilité d’effectuer des demandes de transfert, des mises à jour ou tout autre service en cas de besoin.";  

 $this->notifications->send_mail($mailTo,$subject,$cc_emails=array(),$messages,$attach=array());

 $message='<div class="alert alert-success text-center" id="message">Le requerant a été créee avec succès dans BPS</div>';          
}
elseif($successed==1 && $result['registeras']==5)
{
 $this->Model->update('sf_guard_user_profile',array('md5(id)'=>$id),array('statut_api'=>1,'password'=>$hashedPassword));

 $this->Model->update('parcelle_attribution',array('NUMERO_PARCELLE' => $num_parcelle['NUMERO_PARCELLE']),array('statut_bps' => 1));

 $province=$this->Model->getOne('syst_provinces',array('PROVINCE_ID'=>$num_parcelle['PROVINCE_ID']));


 $communes=$this->Model->getRequeteOne('SELECT COMMUNE_NAME FROM communes WHERE COMMUNE_ID='.$num_parcelle['COMMUNE_ID'].' ');

 $mailTo=$result['email'];
 $subject='Information';

 $messages="Bonjour Mr/Mme Representant ".$result['fullname']." de la société ".$result['nom_entreprise'].".Bienvenue sur le système électronique de transfert de titres de propriété (PMS).<br>
 La Direction des Titres Fonciers et Cadastre National (DTFCN) reconnait votre enregistrement en tant que
 propriétaire de la parcelle numéro ".$num_parcelle['NUMERO_PARCELLE']." sise à ".$province['PROVINCE_NAME']." dans la commune ".$communes['COMMUNE_NAME'].".<br>Vous aurez, ainsi, la possibilité d’effectuer des demandes de transfert, des mises à jour ou tout autre service en cas de besoin. ";  

 $this->notifications->send_mail($mailTo,$subject,$cc_emails=array(),$messages,$attach=array());

 $message='<div class="alert alert-success text-center" id="message">Le requerant a été créee avec succès dans BPS</div>';     
} 
else
{
 if ($successed==2) {
  $message='<div class="alert alert-success text-center" id="message">Désolé, ce numéro de parcelle est déjà attribué.</div>';
 }
 else  
 {
  $message = ($num_parcelle['COLLINE_ID'] < 1) ? '<div class="alert alert-success text-center" id="message">La parcelle n\' a pas de localité</div>' : '<div class="alert alert-success text-center" id="message">Le requerant n\'à pas été créee avec succès dans BPS</div>' ;
 }

}

$this->session->set_flashdata('message',$message);

redirect(base_url('administration/Numeriser_New/list'));
}

}
?>
