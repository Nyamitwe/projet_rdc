<?php
/**
 *Raoul
 *projet: pms
 *Le 19/01/2023
 *Enregistrement du menu selon les menus et profils
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Enregistrement_Menus  extends CI_Controller 
{

  function __construct()
  {
    parent::__construct();   
  } 




  public function index()
  {    

    $data['type_menu']=$this->Model->getList('pms_type_menu');


    $this->load->view('Enregistrement_Menus_View',$data);                                                                                             


  }


  function save()
  {



   $menu=$this->input->post('ID_PMS_MENU');
   $link=$this->input->post('LINK');
   $TYPE_MENU=$this->input->post('TYPE_MENU');


   

   $val_test=$this->Model->getRequeteOne('SELECT * FROM pms_menus where MENU_LINK="'.$link.'"');

   // print_r($val_test);die();



   if (empty($val_test)) {

     $array_tosave=array('DESC_MENU'=>$menu,
      'MENU_LINK'=>$link,'ID_TYPE_MENU'=>$TYPE_MENU);


     $this->Model->create('pms_menus',$array_tosave);

     $data['message']='<div class="alert alert-success text-center" id="message">L\'enregistrement du menu faite avec succés</div>';
     $this->session->set_flashdata($data);


     redirect(base_url('administration/Enregistrement_Menus/liste'));

   }
   else{


     $data['message']='<div class="alert alert-danger text-center" id="message">Le lien pour le menu existe deja !!</div>';
     $this->session->set_flashdata($data);

     redirect(base_url('administration/Enregistrement_Menus'));

   }






 }


 function liste()
 {


   $this->load->view('Menus_List_View');

 }


 function get_liste()
 {




  $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
  $var_search=str_replace("'", "\'", $var_search);
  $limit='LIMIT 0,10';

  if($_POST['length'] != -1) 
  {
    $limit='LIMIT '.$_POST["start"].','.$_POST["length"];
  }


  $query_principal="SELECT * from pms_menus join pms_type_menu on pms_menus.ID_TYPE_MENU=pms_type_menu.ID_TYPE_MENU";


    //print_r($query_principal);die();




  $order_by='';

  $order_column=array('DESC_MENU','MENU_LINK','ID_PMS_MENU');

  $order_by = isset($_POST['order']) ? ' ORDER BY '.$order_column[$_POST['order']['0']['column']] .'  '.$_POST['order']['0']['dir'] : ' ORDER  BY ID_PMS_MENU  ASC';


  $search = !empty($_POST['search']['value']) ? (" AND (MENU_LINK LIKE '%$var_search%' or DESC_MENU LIKE '%$var_search%' or DESC_TYPE_MENU LIKE '%$var_search%')") : '';


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
   $sub_array[]='<center><font color="#000000" size=2><label>'.$row->DESC_MENU.'</label></font> </center>';
   $sub_array[]='<center><font color="#000000" size=2><label>'.$row->DESC_TYPE_MENU.'</label></font> </center>';

   $sub_array[]='<font color="#000000" size=2><label>'.$row->MENU_LINK.'</label></font>';



   

   $option = '<a  href="#"  data-toggle="modal" data-target="#mystatut'.$row->ID_PMS_MENU.'" title="Supprimer"  class="btn btn-danger"> <span class="fa fa-trash"></span></a>

   <a  href="#"  data-toggle="modal" data-target="#mystatut2'.$row->ID_PMS_MENU.'" title="Modifier"  class="btn btn-warning"> <span class="fa fa-pencil"></span></a>




   <div class="modal fade" id="mystatut' . $row->ID_PMS_MENU . '" >
   <div class="modal-dialog modal-lg">
   <div class="modal-content">
   <div class="modal-body">
   <h5>Supprimer le menu '.$row->DESC_MENU.' ?</h5> 
   </div>


   <div class="modal-footer">
   <a class="" href="' . base_url('administration/Enregistrement_Menus/delete/'.$row->ID_PMS_MENU) . '"><span class="mode mode_on">SUPPRIMER</span></a>
   <a class="" href="#" class="close" data-dismiss="modal"><span class="mode mode_process">QUITTER</span></a>
   </div>

   </div>
   </div>
   </div>


   <div class="modal fade" id="mystatut2' . $row->ID_PMS_MENU . '" >
   <div class="modal-dialog modal-lg">
   <div class="modal-content">
   <div class="modal-body">
   <h5>Modifier le menu '.$row->DESC_MENU.' ?</h5> 
   </div>


   <div class="modal-footer">
   <a class="" href="' . base_url('administration/Enregistrement_Menus/get_one_element/'.$row->ID_PMS_MENU) . '"><span class="mode mode_on">Modifier</span></a>
   <a class="" href="#" class="close" data-dismiss="modal"><span class="mode mode_process">QUITTER</span></a>
   </div>

   </div>
   </div>
   </div>


   ';



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


function get_one_element($id)
{

  $val=$this->Model->getOne('pms_menus',array('ID_PMS_MENU'=>$id));

  $data['val']=$val;
  $data['type_menu']=$this->Model->getList('pms_type_menu');


  $this->load->view('Menus_Modify_View',$data);

}


public function modify($value='')
{


 $menu=$this->input->post('ID_PMS_MENU');
 $link=$this->input->post('LINK');
 $id=$this->input->post('id');
 $type_menu=$this->input->post('type_menu');

 $val_test=$this->Model->getRequeteOne('SELECT * FROM pms_menus where ID_PMS_MENU!='.$id.' and MENU_LINK="'.$link.'"');

 if (empty($val_test)) {

   $array_tosave=array('DESC_MENU'=>$menu,
    'MENU_LINK'=>$link,'ID_TYPE_MENU'=>$type_menu);


   $this->Model->update('pms_menus',array('ID_PMS_MENU'=>$id),$array_tosave);

   $data['message']='<div class="alert alert-success text-center" id="message">La Modification du menu faite avec succés</div>';
   $this->session->set_flashdata($data);

   redirect(base_url('administration/Enregistrement_Menus/liste'));

 }else{


   $data['message']='<div class="alert alert-danger text-center" id="message">Le lien pour le menu existe deja !!</div>';
   $this->session->set_flashdata($data);

   redirect(base_url('administration/Enregistrement_Menus/get_one_element/'.$id.''));
 }


 
}

public function delete($id)
{
 $this->Model->delete('pms_menus',array('ID_PMS_MENU'=>$id));

 $data['message']='<div class="alert alert-success text-center" id="message">La suppression du menu faite avec succés</div>';
 $this->session->set_flashdata($data);





 redirect(base_url('administration/Enregistrement_Menus/liste'));
}






}

?>