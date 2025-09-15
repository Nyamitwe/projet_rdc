<?php
/**
 *Raoul
 *projet: pms
 *Le 05/05/2022
 *Enregistrement des droits selon les stages/process et stages
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Menus_Profile  extends CI_Controller 
{

  function __construct()
  {
    parent::__construct();    
  } 



  public function index($p='')
  {                                                                                                
    //$data['process']=$this->Model->getRequete('SELECT * from pms_process order by DESCRIPTION_PROCESS');

    $this->load->helper('url');

    $uri = uri_string();
    $segments = explode('/', $uri);

    $menu='';

    $ct=count($segments);

    for ($i=0; $i <$ct ; $i++) { 
    $menu.=$segments[$i].'/';
    }

    $menu='@';

   // if($this->mylibrary->get();




    $data['postes']=$this->Model->getRequete('SELECT * from pms_poste_service order by POSTE_DESCR');


    //$data['menus']=$this->Model->getRequete('SELECT * from pms_menus order by DESC_MENU');

    $html='';
    $i=0;




   //  foreach ($menus as $key => $value) {
   //  $i++;

   //  $test_active=$this->Model->getOne('pms_menus_profiles',array('ID_PROCESS_STAGE'=>$value['ID_PROCESS_STAGE']));


   //  if (!empty($test_active)) 
   //  { if ($test_active['ID_POSTE']==1) 
   //    {
   //     $html.='  <div class="form-group col-lg-12"><input type="checkbox" value="1" name="stage'.$i.'" >&nbsp;<label>'.$value['DESCRIPTION_STAGE'].' (<b style="font-weight: 900; color:#454545"> '.$value['DESCRIPTION_PROCESS'].'</b>)</label>
   //    <input type="hidden" value="'.$value['ID_PROCESS_STAGE'].'" name="stg'.$i.'" >
   //  </div>';
   //    }
   //    else
   //    {

   //    $html.='  <div class="form-group col-lg-12"><span style=""><font color=red>X</font></span>&nbsp;<label>'.$value['DESCRIPTION_STAGE'].' (<b style="font-weight: 900; color:#454545"> '.$value['DESCRIPTION_PROCESS'].'</b>)</label>
   //    <input type="hidden" value="'.$value['ID_PROCESS_STAGE'].'" name="stg'.$i.'" >
   //  </div>';

   //    }

   //  }
   //  else
   //  {

   // $html.='  <div class="form-group col-lg-12"><input type="checkbox" value="1" name="stage'.$i.'" >&nbsp;<label>'.$value['DESCRIPTION_STAGE'].' (<b style="font-weight: 900; color:#454545"> '.$value['DESCRIPTION_PROCESS'].'</b>)</label>
   //    <input type="hidden" value="'.$value['ID_PROCESS_STAGE'].'" name="stg'.$i.'" >
   //  </div>';

   //  }

    $data['html']=$html;                                                                             
    $data['titre']="Enregistrement des droits";


    $this->load->view('Menu_Profile_View',$data);
  }


  function get_input()
  {

    $ID_POSTE=$this->input->post('ID_POSTE');


    // if (empty($PROCESS_ID)) 
    // {

    //    $stages=$this->Model->getRequete('SELECT * from pms_stage join pms_process_stage on pms_stage.STAGE_ID=pms_process_stage.STAGE_ID join pms_process on pms_process_stage.PROCESS_ID=pms_process.PROCESS_ID order by DESCRIPTION_STAGE');

    // }
    // else
    // {

    //  $stages=$this->Model->getRequete('SELECT * from pms_stage join pms_process_stage on pms_stage.STAGE_ID=pms_process_stage.STAGE_ID join pms_process on pms_process_stage.PROCESS_ID=pms_process.PROCESS_ID where 1 and pms_process_stage.PROCESS_ID='.$PROCESS_ID.'  order by DESCRIPTION_STAGE');
    // }

    $menus=$this->Model->getRequete('SELECT * from pms_menus join pms_type_menu on pms_menus.ID_TYPE_MENU=pms_type_menu.ID_TYPE_MENU  order by DESC_MENU');

    $html='';
    $i=0;
    foreach ($menus as $key => $value) {
      $i++;

      $test_active=$this->Model->getOne('pms_menus_profiles',array('ID_PMS_MENU'=>$value['ID_PMS_MENU'],'ID_PROFILE'=>$ID_POSTE));


      if (empty($test_active)) 
      { 


       $html.='  <div class="form-group col-lg-12"><input type="checkbox" value="1" name="stage'.$i.'" >&nbsp;<label>'.$value['DESC_MENU'].' (<b style="font-weight: 900; color:#454545">'.$value['DESC_TYPE_MENU'].'</b>) </label>
       <input type="hidden" value="'.$value['ID_PMS_MENU'].'" name="stg'.$i.'" >
       </div>';
     }
     else
     {

      $html.='  <div class="form-group col-lg-12"><span style=""><font color=red>X</font></span>&nbsp;<label>'.$value['DESC_MENU'].' (<b style="font-weight: 900; color:#454545">'.$value['DESC_TYPE_MENU'].'</b>) </label>
      <input type="hidden" value="'.$value['ID_PMS_MENU'].'" name="stg'.$i.'" >
      </div>';

    }



  }




  echo $html;    

}



public function get_poste($value='')
{
  $ID_SERVICE=$this->input->post('SERVICE_ID');

  $poste=$this->Model->getRequete('SELECT * from pms_poste_service where ID_SERVICE='.$ID_SERVICE.' order by POSTE_DESCR');

  $html='<option value="">Séléctionner</option>';

  foreach ($poste as $key => $value) 
  {

    $html.='<option value="'.$value['ID_POSTE'].'">'.$value['POSTE_DESCR'].'</option>';
  }
  echo $html;
}




public function save()
{

  $sub_array = array();


  $ID_PROFIL=$this->input->post('ID_POSTE');


  $menus=$this->Model->getRequete('SELECT * from pms_menus join pms_type_menu on pms_menus.ID_TYPE_MENU=pms_type_menu.ID_TYPE_MENU  order by DESC_MENU');




      //print_r($test);die();

  $i=0;


  foreach ($menus as $key => $value) 
  {
    $i++;

    if ($this->input->post('stage'.$i.'')!=null) 
    {

      $pro=$this->Model->getOne('pms_menus_profiles',array('ID_PMS_MENU'=>$this->input->post('stg'.$i.''),'ID_PROFILE'=>$ID_PROFIL));

      if (empty($pro)) 
      {
        $data_arr=array('ID_PMS_MENU'=>$this->input->post('stg'.$i.''),
          'ID_PROFILE'=>$ID_PROFIL);
        $this->Model->create('pms_menus_profiles',$data_arr);

      }

    }
      // else
      // {

      //  $pro=$this->Model->getOne('pms_process_service',array('ID_PROCESS_STAGE'=>$this->input->post('stg'.$i.''),'ID_POSTE'=>$POSTE_ID));

      // $this->Model->delete('pms_process_service',array('ID_PROCESS_STAGE'=>$this->input->post('stg'.$i.''),'ID_POSTE'=>$POSTE_ID));

      // }





      // $sub_array['stage'.$i.'']=$donne;
  }


  $data['message']='<div class="alert alert-success text-center" id="message">L\'enregistrement des droits faite avec succés</div>';
  $this->session->set_flashdata($data);

  redirect(base_url('administration/Menus_Profile/liste'));
}


function liste()
{
 $data['poste']=$this->Model->getRequete('SELECT * from pms_poste_service order by POSTE_DESCR');


 $this->load->view('Menu_Profile_List_View',$data);

}


function get_liste()
{


 $ID_POSTE=$this->input->post('ID_POSTE');


 $crit='';


 if (!empty($ID_POSTE))
 {
  $crit.=' and pms_menus_profiles.ID_PROFILE='.$ID_POSTE.'';
}



$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
$var_search=str_replace("'", "\'", $var_search);
$limit='LIMIT 0,10';

if($_POST['length'] != -1) 
{
  $limit='LIMIT '.$_POST["start"].','.$_POST["length"];
}


$query_principal="SELECT * FROM pms_menus_profiles JOIN pms_menus on pms_menus.ID_PMS_MENU=pms_menus_profiles.ID_PMS_MENU JOIN pms_poste_service on pms_poste_service.ID_POSTE=pms_menus_profiles.ID_PROFILE join pms_type_menu on pms_type_menu.ID_TYPE_MENU=pms_menus.ID_TYPE_MENU  WHERE 1 ".$crit."";


    //print_r($query_principal);die();




$order_by='';
 
$order_column=array('pms_poste_service.POSTE_DESCR','DESC_TYPE_MENU','pms_menus.DESC_MENU','ID_MENU_PROFILE');

$order_by = isset($_POST['order']) ? ' ORDER BY '.$order_column[$_POST['order']['0']['column']] .'  '.$_POST['order']['0']['dir'] : ' ORDER  BY ID_MENU_PROFILE  ASC';


$search = !empty($_POST['search']['value']) ? (" AND (pms_poste_service.POSTE_DESCR LIKE '%$var_search%' or pms_menus.DESC_MENU LIKE '%$var_search%' or DESC_TYPE_MENU LIKE '%$var_search%')") : '';


$critaire="";

$query_secondaire=$query_principal.' '.$critaire.' '.$search.' '.$order_by.' '.$limit;

$query_filter = $query_principal.' '.$critaire.' '.$search;

$fetch_data= $this->Model->datatable($query_secondaire);

$data = array();
$u=0;



foreach ($fetch_data as $row) 
{


 $interval = 5;



 $u++;



 $sub_array = array();

     // $proces=$this->Model->getOne('pms_process',array('PROCESS_ID'=>$row->PROCESS_ID));


      // $sub_array[]=$u; ('.$proces['DESCRIPTION_PROCESS'].')
 $sub_array[]='<center><font color="#000000" size=2><label>'.$row->POSTE_DESCR.'</label></font> </center>';
 $sub_array[]='<center><font color="#000000" size=2><label>'.$row->DESC_TYPE_MENU.'</label></font> </center>';
 $sub_array[]='<center><font color="#000000" size=2><label>'.$row->DESC_MENU.'</label></font> </center>';




 $option = '<a  href="#"  data-toggle="modal" data-target="#mystatut'.$row->ID_MENU_PROFILE.'" title="Supprimer"  class="btn btn-danger"> <span class="fa fa-trash"></span></a>


 <div class="modal fade" id="mystatut' . $row->ID_MENU_PROFILE . '" >
 <div class="modal-dialog modal-lg">
 <div class="modal-content">
 <div class="modal-body">
 <h5>Supprimer le droit '.$row->DESC_MENU.' ?</h5> 
 </div>


 <div class="modal-footer">
 <a class="" href="' . base_url('administration/Menus_Profile/delete/'.$row->ID_MENU_PROFILE) . '"><span class="mode mode_on">SUPPRIMER</span></a>
 <a class="" href="#" class="close" data-dismiss="modal"><span class="mode mode_process">QUITTER</span></a>
 </div>

 </div>
 </div>
 </div>';



 $sub_array[]=$option;

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


public function delete($id='')
{
 $this->Model->delete('pms_menus_profiles',array('ID_MENU_PROFILE'=>$id));

 $data['message']='<div class="alert alert-success text-center" id="message">La suppression du droit faite avec succés</div>';
 $this->session->set_flashdata($data);

 redirect(base_url('administration/Menus_Profile/liste'));
}


}

?>