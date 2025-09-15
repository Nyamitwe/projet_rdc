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
    mobile,
    IF(SEXE_ID = 1, 'Masculin', 'Féminin') AS SEXE
FROM sf_guard_user_profile
WHERE 1";
;

 // print_r($query_principal);die();

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
  $sub_array[]='<center><font color="#000000" size=2><label>'.$row->NOM.' '.$row->PRENOM.'</label></font> </center>';
  $sub_array[]='<center><font color="#000000" size=2><label>'.$row->email.'</label></font> </center>';
  $sub_array[]='<center><font color="#000000" size=2><label>'.$row->mobile.'</label></font> </center>';     
  $sub_array[]='<center><font color="#000000" size=2><label>'.$row->SEXE.'</label></font> </center>';     


  // if ($get_hist) {
  //  $btn_historique= '<a href="'.base_url('/administration/Numeriser_New/historique_proprietaires/'.md5($row->id)) .'" 
  //  class="btn btn-outline-primary btn-sm px-3" title="Historique des propriétaires">
  //  <i class="fa fa-list"></i>
  //  </a>';
  // }

  // $btn_modif ="";
  // if ($row->statut_bps==1) {
  //  $btn_modif =  '<a href="'.base_url('/administration/Numeriser_New/Modifier/'.md5($row->id)) .'" 
  //  class="btn btn-outline-danger btn-sm px-3" title="Changement du propriétaire">
  //  <i class="fa fa-user"></i>
  //  </a>';
  // }


  // $button='<div class="d-flex justify-content-center gap-2">
  // <a href="'.base_url('/administration/Numerisation/info_parcelle/'.md5($row->id)).'"  
  // class="btn btn-outline-secondary btn-sm px-3" title="'.lang('ajout_parcelle').'">
  // <i class="fa fa-plus-circle me-2"></i>
  // </a>
  // '.$btn_modif.'
  // '.$btn_historique.'
  // </div>';            
  // $sub_array[]=$button;
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

}
?>
