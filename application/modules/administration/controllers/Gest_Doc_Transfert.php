<?php
/**
 *Raoul
 *projet: pms
 *Le 05/05/2022
 *Enregistrement des droits selon les stages/process et stages
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Gest_Doc_Transfert  extends CI_Controller 
{

  function __construct()
  {
    parent::__construct();   
  } 


  

  function test_mail_et_sms(){

   $this->notifications->send_mail('martinkabezya@gmail.com', 'Test info',NULL, 'Test send mail', null);

   $info = $this->notifications->send_sms_smpp('79588624','Bonjour chef');

   echo "Data : ".$info;

 }


 public function index()
 {                                                                                                
  $data['process']=$this->Model->getRequete('SELECT * from pms_process where PROCESS_ID=19 order by DESCRIPTION_PROCESS');

  $data['service']=$this->Model->getRequete('SELECT * from pms_service order by DESCRIPTION');

  $data['types']=$this->Model->getRequete('SELECT * from pms_type_transfert order by DESCRIPTION_TRANSFERT');


  $doc=$this->Model->getRequete('SELECT pms_documents.* from pms_documents where ID_TYPE_DOCUMENT=1 and SCAN_TRAITEMENT=0 GROUP BY ID_DOCUMENT order by DESC_DOCUMENT');

  $html='';
  $i=0;
  foreach ($doc as $key => $value) {
    $i++;
    $html.='<div class="form-group col-lg-6"><input type="checkbox" value="1" name="document'.$i.'" >&nbsp;<label>'.$value['DESC_DOCUMENT'].' </label>
    <input type="hidden" value="'.$value['ID_DOCUMENT'].'" name="doc'.$i.'" >
    </div>';
  }
  $data['html']=$html;                                                                             
  $data['titre']="Affectation des documents";


  $this->load->view('Gest_Doc_Transfert_Views',$data);
}


function get_doc()
{


 $ID_TYPE_TRANSFERT=$this->input->post('ID_TYPE_TRANSFERT');
 $TYPE_ACHETEUR=$this->input->post('TYPE_ACHETEUR');
 $CATEGO=$this->input->post('CATEGO');


 $crit='';


 if (!empty($ID_TYPE_TRANSFERT)) {
   $crit.=' and pms_transfert_document_vs_requerant.ID_TYPE_TRANSFERT='.$ID_TYPE_TRANSFERT.'';
 }

 if (!empty($ID_TYPE_TRANSFERT)) {
   $crit.=' and pms_transfert_document_vs_requerant.TYPE_ACHETEUR='.$TYPE_ACHETEUR.'';
 }

 if (!empty($CATEGO)) {
   $crit.=' and pms_transfert_document_vs_requerant.CATEGORIE_DECLARANT_ID='.$CATEGO.'';
 }



 $doc=$this->Model->getRequete('SELECT pms_documents.* from pms_documents JOIN pms_transfert_document_vs_requerant on pms_documents.`ID_DOCUMENT`=pms_transfert_document_vs_requerant.DOCUMENT_TRANSFERT_ID where ID_TYPE_DOCUMENT=1 and SCAN_TRAITEMENT=0 '.$crit.' GROUP BY ID_DOCUMENT order by DESC_DOCUMENT');

 $html='';
 $i=0;
 foreach ($doc as $key => $value) {
  $i++;
  $html.='<div class="form-group col-lg-6"><input type="checkbox" value="1" name="document'.$i.'" >&nbsp;<label>'.$value['DESC_DOCUMENT'].' </label>
  <input type="hidden" value="'.$value['ID_DOCUMENT'].'" name="doc'.$i.'" >
  </div>';
}
    //$data['html']=$html;  


echo $html; 

}


function get_input()
{
  $PROCESS_ID=$this->input->post('PROCESS_ID');

  if (empty($PROCESS_ID)) 
  {

   $stages=$this->Model->getRequete('SELECT * from pms_stage join pms_process_stage on pms_stage.STAGE_ID=pms_process_stage.STAGE_ID join pms_process on pms_process_stage.PROCESS_ID=pms_process.PROCESS_ID order by DESCRIPTION_STAGE');

 }
 else
 {

   $stages=$this->Model->getRequete('SELECT * from pms_stage join pms_process_stage on pms_stage.STAGE_ID=pms_process_stage.STAGE_ID join pms_process on pms_process_stage.PROCESS_ID=pms_process.PROCESS_ID where 1 and pms_process_stage.PROCESS_ID='.$PROCESS_ID.'  order by DESCRIPTION_STAGE');
 }



 $html='';
 $i=0;
 foreach ($stages as $key => $value) {
  $i++;
  $html.='<div class="form-group col-lg-12">
  <input type="checkbox" value="1" name="stage'.$i.'">&nbsp;<label>'.$value['DESCRIPTION_STAGE'].' (<b style="font-weight: 900; color:#454545"> '.$value['DESCRIPTION_PROCESS'].'</b>)</label>
  <input type="hidden" value="'.$value['ID_PROCESS_STAGE'].'" name="stg'.$i.'" ></div>';
}


echo $html;    

}



public function get_poste($value='')
{
  $ID_SERVICE=$this->input->post('SERVICE_ID');
    //   $PROCESS_ID=$this->input->post('PROCESS_ID');
  
  $poste=$this->Model->getRequete('SELECT * from pms_poste_service where ID_SERVICE='.$ID_SERVICE.' order by POSTE_DESCR');

  $html='<option>Séléctionner</option>';

  foreach ($poste as $key => $value) 
  {

    $html.='<option value="'.$value['ID_POSTE'].'">'.$value['POSTE_DESCR'].'</option>';
  }
  echo $html;
}




public function get_catego($value='')
{
  $ID_TYPE_TRANSFERT=$this->input->post('ID_TYPE_TRANSFERT');
    //   $PROCESS_ID=$this->input->post('PROCESS_ID');
  
  $catego=$this->Model->getRequete('SELECT * from pms_categorie_declarant where ID_TYPE_TRANSFERT='.$ID_TYPE_TRANSFERT.' order by DESCRIPTION_CATEG');

  $html='<option value="">Séléctionner</option>';

  foreach ($catego as $key => $value) 
  {

    $html.='<option value="'.$value['CATEGORIE_DECLARANT_ID'].'">'.$value['DESCRIPTION_CATEG'].'</option>';
  }
  echo $html;
}




public function get_stage($value='')
{
  $ID_POSTE=$this->input->post('ID_POSTE');
  $PROCESS_ID=$this->input->post('PROCESS_ID');

  if (empty($PROCESS_ID)) {
   $PROCESS_ID=0;
 }


 if (empty($ID_POSTE)) {
   $ID_POSTE=0;
 }


 // print_r($ID_POSTE);die();

 $poste=$this->Model->getRequete("SELECT pms_stage.STAGE_ID,DESCRIPTION_STAGE FROM pms_stage join pms_process_stage on pms_stage.STAGE_ID=pms_process_stage.STAGE_ID JOIN pms_process_service on pms_process_stage.ID_PROCESS_STAGE=pms_process_service.ID_PROCESS_STAGE  WHERE pms_process_stage.PROCESS_ID = ".$PROCESS_ID." and pms_process_service.ID_POSTE=".$ID_POSTE." ORDER BY `DESCRIPTION_STAGE` ASC");

 
 $html='<option>Séléctionner</option>';

 foreach ($poste as $key => $value) 
 {

  $html.='<option value="'.$value['STAGE_ID'].'">'.$value['DESCRIPTION_STAGE'].'</option>';
}
echo $html;
}


public function traite_($PROCESS_ID)
{



 $stages=$this->Model->getRequete('SELECT * from pms_stage join pms_process_stage on pms_stage.STAGE_ID=pms_process_stage.STAGE_ID join pms_process on pms_process_stage.PROCESS_ID=pms_process.PROCESS_ID join pms_process_service on pms_process_service.STAGE_ID=pms_process_stage.STAGE_ID  where 1 and pms_process_service.ID_POSTE=1  order by DESCRIPTION_STAGE');




 $html='';
 $i=0;

 foreach ($stages as $key => $value) {
  $i++;
  $service=$this->Model->getRequete('SELECT * from pms_service where 1  order by DESCRIPTION');
  $check='';
  foreach ($service as $key => $val) 
  {
    $test_active=$this->Model->getRequeteOne('SELECT '.$val['CODE_SERVICE'].' from pms_process_service where 1  and STAGE_ID='.$value['STAGE_ID'].'');
    
    $html.='  <div class="form-group col-lg-12"><input type="checkbox" '.$check.' value="1" name="stage'.$i.'" >&nbsp;<label>'.$value['DESCRIPTION_STAGE'].' (<b style="font-weight: 900; color:#454545"> '.$value['DESCRIPTION_PROCESS'].'</b>)</label>
    <input type="hidden" value="'.$value['STAGE_ID'].'" name="stg'.$i.'" >
    </div>';


  }
}
$data['html']=$html;
$data['PROCESS_ID']=$PROCESS_ID;
$data['SERVICE_ID']=$SERVICE_ID;                                                                             
$data['titre']="Enregistrement des droits";


$this->load->view('Droits_Update_View',$data);
}


public function save()
{

  $sub_array = array();

  $PROCESS_ID=$this->input->post('PROCESS_ID');
  // $SERVICE_ID=$this->input->post('SERVICE_ID');
  // $POSTE_ID=$this->input->post('ID_POSTE');
  // $STAGE_ID=$this->input->post('STAGE_ID');
  $ID_TYPE_TRANSFERT=$this->input->post('ID_TYPE_TRANSFERT');
  $CATEGORIE=$this->input->post('ID_CATEGORIE_TRANSFERT');



      //print_r($CATEGORIE);die();



  $doc=$this->Model->getRequete('SELECT * from pms_documents where ID_TYPE_DOCUMENT=1 and SCAN_TRAITEMENT=0 GROUP BY ID_DOCUMENT order by DESC_DOCUMENT');




      //print_r($test);die();

  $i=0;


  foreach ($doc as $key => $value) 
  {
    $i++;

    if ($this->input->post('document'.$i.'')!=null) 
    {

      $pro=$this->Model->getOne('pms_transfert_document_vs_requerant' ,array('DOCUMENT_TRANSFERT_ID'=>$this->input->post('doc'.$i.''),'ID_CATEGORIE_TRANSFERT'=>$CATEGORIE,'ID_TYPE_TRANSFERT'=>$ID_TYPE_TRANSFERT));

      if (empty($pro)) 
      {

        $data_arr=array('DOCUMENT_TRANSFERT_ID'=>$this->input->post('doc'.$i.''),
          'ID_CATEGORIE_TRANSFERT'=>$CATEGORIE,
          'ID_TYPE_TRANSFERT'=>$ID_TYPE_TRANSFERT);
          // 'STAGE_ID'=>$STAGE_ID,
          // 'SERVICE_ID'=>$SERVICE_ID,
          // 'ID_TYPE_TRANSFERT'=>$ID_TYPE_TRANSFERT,
          // 'CATEGORIE_DECLARANT_ID'=>$CATEGORIE,);

        $this->Model->create('pms_transfert_document_vs_requerant' ,$data_arr);

      }

      else

      {


       $this->Model->update('pms_documents_stage_transferts' ,array('ID_DOCUMENT'=>$this->input->post('doc'.$i.''),'ID_POSTE'=>$POSTE_ID,'PROCESS_ID'=>$PROCESS_ID,'STAGE_ID'=>$STAGE_ID,'ID_TYPE_TRANSFERT'=>$ID_TYPE_TRANSFERT),array('ID_DOCUMENT'=>$this->input->post('doc'.$i.''),
        'PROCESS_ID'=>$PROCESS_ID,
        'ID_POSTE'=>$POSTE_ID,
        'STAGE_ID'=>$STAGE_ID,
        'SERVICE_ID'=>$SERVICE_ID,
        'ID_TYPE_TRANSFERT'=>$ID_TYPE_TRANSFERT,
        'CATEGORIE_DECLARANT_ID'=>$CATEGORIE,));

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





 redirect(base_url('administration/Gest_Doc_Transfert'));
}


function liste()
{
 $data['process']=$this->Model->getRequete('SELECT * from pms_process order by DESCRIPTION_PROCESS');

 $data['service']=$this->Model->getRequete('SELECT * from pms_service order by DESCRIPTION');


 $this->load->view('Affect_document_transferts_list_view',$data);

}


function get_liste()
{
 $SERVICE_ID=$this->input->post('SERVICE_ID');

 $crit='';


 if (!empty($SERVICE_ID))
 {
  $crit=' and pms_poste_service.ID_SERVICE='.$SERVICE_ID.'';
}



$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
$var_search=str_replace("'", "\'", $var_search);
$limit='LIMIT 0,10';

if($_POST['length'] != -1) 
{
  $limit='LIMIT '.$_POST["start"].','.$_POST["length"];
}


$query_principal="SELECT pms_documents_stage_transferts.ID_DOC_STAGE_TRANSFERTS,pms_documents.DESC_DOCUMENT,pms_process.DESCRIPTION_PROCESS,pms_service.DESCRIPTION,pms_stage.DESCRIPTION_STAGE, pms_poste_service.POSTE_DESCR FROM pms_documents_stage_transferts join pms_process on pms_process.PROCESS_ID=pms_documents_stage_transferts.PROCESS_ID JOIN pms_stage on pms_stage.STAGE_ID=pms_documents_stage_transferts.STAGE_ID join pms_documents on pms_documents.ID_DOCUMENT=pms_documents_stage_transferts.ID_DOCUMENT join pms_poste_service on pms_documents_stage_transferts.ID_POSTE=pms_poste_service.ID_POSTE join pms_service on pms_documents_stage_transferts.SERVICE_ID=pms_service.SERVICE_ID WHERE 1 ".$crit."";




$order_by='';

$order_column=array('pms_poste_service.POSTE_DESCR','pms_process.DESCRIPTION_PROCESS','pms_service.DESCRIPTION','pms_stage.DESCRIPTION_STAGE');

$order_by = isset($_POST['order']) ? ' ORDER BY '.$order_column[$_POST['order']['0']['column']] .'  '.$_POST['order']['0']['dir'] : ' ORDER  BY pms_stage.DESCRIPTION_STAGE  ASC';


$search = !empty($_POST['search']['value']) ? (" AND (pms_poste_service.POSTE_DESCR LIKE '%$var_search%' or pms_process.DESCRIPTION_PROCESS LIKE '%$var_search%' or pms_service.DESCRIPTION LIKE '%$var_search%' or pms_stage.DESCRIPTION_STAGE LIKE '%$var_search%' or pms_documents.DESC_DOCUMENT LIKE '%$var_search%' )") : '';


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
 $sub_array[]='<center><font color="#000000" size=2><label>'.$row->DESCRIPTION_PROCESS.'</label></font> </center>';
 $sub_array[]='<center><font color="#000000" size=2><label>'.$row->DESCRIPTION_STAGE.'</label></font> </center>';
 $sub_array[]='<center><font color="#000000" size=2>'.$row->POSTE_DESCR.'</font><center>';

 $sub_array[]='<center><font color="#000000" size=2>'.$row->DESC_DOCUMENT.'</font><center>';



 $option = '<a  href="#"  data-toggle="modal" data-target="#mystatut'.$row->ID_DOC_STAGE_TRANSFERTS.'" title="Supprimer"  class="btn btn-danger"> <span class="fa fa-trash"></span></a>


 <div class="modal fade" id="mystatut' . $row->ID_DOC_STAGE_TRANSFERTS . '" >
 <div class="modal-dialog modal-lg">
 <div class="modal-content">
 <div class="modal-body">
 <h5>Voulez-vous supprimer cette ligne?</h5> 
 </div>


 <div class="modal-footer">
 <a class="" href="' . base_url('administration/Affect_document_transferts/delete/'.$row->ID_DOC_STAGE_TRANSFERTS) . '"><span class="mode mode_on">SUPPRIMER</span></a>
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
 $this->Model->delete('pms_documents_stage_transferts',array('ID_DOC_STAGE_TRANSFERTS'=>$id));

 $data['message']='<div class="alert alert-success text-center" id="message">La suppression est faite avec succés</div>';
 $this->session->set_flashdata($data);

 redirect(base_url('administration/Affect_document_transferts/liste'));
}



function get_categ(){

 $categorie= $this->Model->getList("categorie_transfert",array('ID_TYPE_TRANSFERT'=>$this->input->post('ID_TYPE_TRANSFERT')));

 $datas= '<option  value="">Sélectionner</option>';

 foreach($categorie as $categ){


   $datas.= '<option value="'.$categ["ID_CATEGORIE_TRANSFERT"].'">'.$categ["DESC_CATEGORIE_TRANSF"].'</option>'; }


   echo $datas;

 }


}

?>