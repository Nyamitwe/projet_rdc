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
  $sub_array[]='<font color="#000000" size=2><label>'.$row->email.'</label></font> ';
  $sub_array[]='<font color="#000000" size=2><label>'.$row->mobile.'</label></font> ';     
  $sub_array[]='<font color="#000000" size=2><label>'.$row->DESCRIPTION.'</label></font> ';     
      
$IS_ACTIVE =($row->is_active==1) ? '<i class="fa fa-check-square-o" style="color:blue;font-size:20px" title="Activé"></i>' : '<i class="fa fa-window-close text-danger" aria-hidden="true" style="font-size:20px" title="Desactivé"></i>';

$sub_array[]='<font color="#000000" size=2><label>'.$IS_ACTIVE.'</label></font> '; 
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

}
?>
