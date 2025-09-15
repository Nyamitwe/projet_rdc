<?php
/**
 *Raoul
 *projet: pms
 *Le 05/05/2022
 *Upload des fichier manquant lors de la demande
 */
   if (!defined('BASEPATH')) exit('No direct script access allowed');

   class Upload_Fichier_Manquant  extends CI_Controller 
   {

    function __construct()
    {
      parent::__construct();   
    } 
    

  
    
    public function index()
    {                                                                                        $data['html']='';
    $this->load->view('Upload_Fichier_Manquant_View',$data);
    }


    function get_doc()
    {
      
     $CODE_DEMANDE=$this->input->post('CODE_DEMANDE');

     $one_data=$this->Model->getRequeteOne('SELECT `ID_TYPE_TRANSFERT`,`CATEGORIE_DECLARANT_ID`,`TYPE_ACHETEUR` FROM `pms_traitement_demande` WHERE 1 and `CODE_DEMANDE`="'.$CODE_DEMANDE.'"');

     if (!empty($one_data)) {
       # code...
   

     $ID_TYPE_TRANSFERT=$one_data['ID_TYPE_TRANSFERT'];
     $TYPE_ACHETEUR=$one_data['TYPE_ACHETEUR'];
     $CATEGO=$one_data['CATEGORIE_DECLARANT_ID'];


     $crit='';


     if (!empty($ID_TYPE_TRANSFERT)) {
     $crit.=' and pms_transfert_document_vs_requerant.ID_TYPE_TRANSFERT='.$ID_TYPE_TRANSFERT.'';
     }

     //  if (!empty($ID_TYPE_TRANSFERT)) {
     // $crit.=' and pms_transfert_document_vs_requerant.TYPE_ACHETEUR='.$TYPE_ACHETEUR.'';
     // }

     if (!empty($CATEGO)) {
     $crit.=' and pms_transfert_document_vs_requerant.ID_CATEGORIE_TRANSFERT='.$CATEGO.'';
     }


   
    $doc=$this->Model->getRequete('SELECT pms_documents.* from pms_documents JOIN pms_transfert_document_vs_requerant on pms_documents.`ID_DOCUMENT`=pms_transfert_document_vs_requerant.DOCUMENT_TRANSFERT_ID where ID_TYPE_DOCUMENT=1 and SCAN_TRAITEMENT=0 '.$crit.' GROUP BY ID_DOCUMENT order by DESC_DOCUMENT');

    $html='';
    $i=0;
    foreach ($doc as $key => $value) {
    $i++;

    $test_val=$this->Model->getOne('pms_documents_demande',array('ID_DOCUMENT'=>$value['ID_DOCUMENT'],'PROCESS_ID'=>19,'CODE_TRAITEMENT'=>$CODE_DEMANDE));
   

    if (empty($test_val)) {
    $html.='<div class="form-group col-lg-6">
    <label>'.$value['DESC_DOCUMENT'].' </label><br>
    <input type="file" class="form-control" value="" name="'.$value['PATH_FILE'].'" >
     </div>';
    }else if (!empty($test_val)) {

     $filePath=''.FCPATH.'/uploads/doc_scanner/'.$test_val['PATH_DOC'].'';
      
    if ($this->isFileValid($filePath)) {
    // print_r($filePath);die();
     }
    else{ 
      
    $html.='<div class="form-group col-lg-6">
    <label>'.$value['DESC_DOCUMENT'].' </label><br>
    <input type="file" required class="form-control" value="" name="'.$value['PATH_FILE'].'" >
     </div>';
    }
    }else{
   
     
    }
   }
   if ($html=='') {
    $html='<div class="form-group col-lg-12">
    <div class="alert alert-danger text-center" id="message"><h2>Pas de document manquant !!</h2></div>
    </div>';
   }
  }else{
   $html='<div class="form-group col-lg-12">
    <div class="alert alert-danger text-center" id="message"><h2>Votre demande est introuvable !!</h2></div>
    </div>';
  }
   echo $html; 
  }

    //ajout du nouveau requérant
  function update_doc()
  {
    
    $typ = $this->Model->getRequeteOne('SELECT ID_TYPE_TRANSFERT,CATEGORIE_DECLARANT_ID from pms_traitement_demande where `CODE_DEMANDE`="'.$this->input->post('CODE_DEMANDE').'" ');

      //Recuperation de ID du trasfert et du categorie/
    $trans=0;
    $categ=0;

    if (!empty($typ)) {
      $trans=$typ['ID_TYPE_TRANSFERT'];
      $categ=$typ['CATEGORIE_DECLARANT_ID'];
    }

  


     $crit='';


     if (!empty($trans)) {
     $crit.=' and pms_transfert_document_vs_requerant.ID_TYPE_TRANSFERT='.$trans.'';
     }

     //  if (!empty($ID_TYPE_TRANSFERT)) {
     // $crit.=' and pms_transfert_document_vs_requerant.TYPE_ACHETEUR='.$TYPE_ACHETEUR.'';
     // }

     if (!empty($categ)) {
     $crit.=' and pms_transfert_document_vs_requerant.ID_CATEGORIE_TRANSFERT='.$categ.'';
     }


   
    $file=$this->Model->getRequete('SELECT pms_documents.* from pms_documents JOIN pms_transfert_document_vs_requerant on pms_documents.`ID_DOCUMENT`=pms_transfert_document_vs_requerant.DOCUMENT_TRANSFERT_ID where ID_TYPE_DOCUMENT=1 and SCAN_TRAITEMENT=0 '.$crit.' GROUP BY ID_DOCUMENT order by DESC_DOCUMENT');
  
   foreach ($file as $key => $value) 
    {

      $test_val=$this->Model->getOne('pms_documents_demande',array('ID_DOCUMENT'=>$value['ID_DOCUMENT'],'PROCESS_ID'=>19,'CODE_TRAITEMENT'=>$this->input->post('CODE_DEMANDE')));
   

    if (empty($test_val)) {
     $sub_array = array(
        'PATH_DOC'=>$this->upload_file1(''.$value['PATH_FILE'].''),
        'ID_DOCUMENT'=>$value['ID_DOCUMENT'],
        'PROCESS_ID'=>19,
        'CODE_TRAITEMENT'=>$this->input->post('CODE_DEMANDE'),
      );
    $id=$this->Model->insert_last_id('pms_documents_demande',$sub_array);
    }else if (!empty($test_val)) {
     
    

    // $filePath=''.base_url('uploads/doc_scanner/'.$test_val['PATH_DOC'].'').'';

      $filePath=''.FCPATH.'/uploads/doc_scanner/'.$test_val['PATH_DOC'].'';
      
    if (!$this->isFileValid($filePath)) {
    $this->Model->delete('pms_documents_demande',array('ID_DOCUMENT'=>$value['ID_DOCUMENT'],'PROCESS_ID'=>19,'CODE_TRAITEMENT'=>$this->input->post('CODE_DEMANDE')));
     $sub_array = array(
        'PATH_DOC'=>$this->upload_file1(''.$value['PATH_FILE'].''),
        'ID_DOCUMENT'=>$value['ID_DOCUMENT'],
        'PROCESS_ID'=>19,
        'CODE_TRAITEMENT'=>$this->input->post('CODE_DEMANDE'),
      );
    $id=$this->Model->insert_last_id('pms_documents_demande',$sub_array);
    }
    }
     

      $metadonnees=$this->Model->getRequete('SELECT pms_metadonnees.ID_METADONNEES,pms_metadonnees.META_DESC,pms_metadonnees.NOM_CHAMP,pms_metadonnee_documents.ID_DOCUMENT,pms_metadonnees.ID_TYPE_META FROM pms_metadonnees JOIN pms_metadonnee_documents ON pms_metadonnee_documents.ID_METADONNEE=pms_metadonnees.ID_METADONNEES WHERE pms_metadonnee_documents.ID_DOCUMENT='.$value['ID_DOCUMENT']);

      foreach ($metadonnees as $key) 
      {
        $VALEUR=$this->input->post(''.$key['NOM_CHAMP'].'');

        $array_metadonnes=array(
          'ID_DOCUMENT'=>$value['ID_DOCUMENT'],
          'CODE_DEMANDE'=>$NUMERO_APPLICATION,
          'ID_METADONNEES'=>$key['ID_METADONNEES'],
          'VALEUR'=>$VALEUR,
          'ID_TYPE_META'=>$key['ID_TYPE_META']);

        $this->Model->create('pms_metadonnees_demandes',$array_metadonnes);
      }
    }

      //Fin send les document du personne physique

  $data['message']='<div class="alert alert-success text-center" id="message">'.lang('msg_demande_suces').'</div>';
    $this->session->set_flashdata($data);
    redirect(base_url('administration/Upload_Fichier_Manquant'));
  }


 // upload des fichiers
      //    public function upload_file1($input_name)
      //    {
      //     $nom_file=$_FILES[$input_name]['tmp_name'];
      //     $nom_champ=$_FILES[$input_name]['name']; 
      //     $repertoire_fichier =FCPATH.'uploads/doc_scanner/';
      //     $code="MYPDF".uniqid();
      //     $ext='.pdf';
      //     $fichier=basename($code.$ext);

      // if(!is_dir($repertoire_fichier)) //create the folder if it does not already exists   
      // {
      //   mkdir($repertoire_fichier,0777,TRUE);                                                         
      // }  
      // move_uploaded_file($nom_file, $repertoire_fichier.$fichier);
      // return $fichier;
      //  }

  public function upload_file1($input_name)
{
    if (!isset($_FILES[$input_name]) || $_FILES[$input_name]['error'] != UPLOAD_ERR_OK) {
        log_message('error', "File upload error: " . $_FILES[$input_name]['error']);
        return false;
    }

    $nom_file = $_FILES[$input_name]['tmp_name'];
    $nom_champ = $_FILES[$input_name]['name'];
    $repertoire_fichier = FCPATH . 'uploads/doc_scanner/';
    $code = uniqid();
    $ext = '.pdf';
    $fichier = basename($code . $ext);

    if (!is_dir($repertoire_fichier)) {
        mkdir($repertoire_fichier, 0777, true);
    }

    if (move_uploaded_file($nom_file, $repertoire_fichier . $fichier)) {
        return $fichier;
    } else {
        log_message('error', "Failed to move uploaded file: $nom_file to $repertoire_fichier$fichier");
        return false;
    }
}



   public function isFileValid($filePath) {
    //Check if the file exists and has a size greater than 0KB
    return file_exists($filePath) && filesize($filePath) > 0;
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
      $SERVICE_ID=$this->input->post('SERVICE_ID');
      $POSTE_ID=$this->input->post('ID_POSTE');
      $STAGE_ID=$this->input->post('STAGE_ID');
      $ID_TYPE_TRANSFERT=$this->input->post('ID_TYPE_TRANSFERT');
      $CATEGORIE=$this->input->post('CATEGORIE');



      //print_r($CATEGORIE);die();



     $doc=$this->Model->getRequete('SELECT * from pms_documents where ID_TYPE_DOCUMENT=1 order by DESC_DOCUMENT');




      //print_r($test);die();

      $i=0;


      foreach ($doc as $key => $value) 
      {
      $i++;

      if ($this->input->post('document'.$i.'')!=null) 
      {

      $pro=$this->Model->getOne('pms_documents_stage_transferts' ,array('ID_DOCUMENT'=>$this->input->post('doc'.$i.''),'ID_POSTE'=>$POSTE_ID,'PROCESS_ID'=>$PROCESS_ID,'STAGE_ID'=>$STAGE_ID,'ID_TYPE_TRANSFERT'=>$ID_TYPE_TRANSFERT));

      if (empty($pro)) 
      {

      $data_arr=array('ID_DOCUMENT'=>$this->input->post('doc'.$i.''),
                      'PROCESS_ID'=>$PROCESS_ID,
                      'ID_POSTE'=>$POSTE_ID,
                      'STAGE_ID'=>$STAGE_ID,
                      'SERVICE_ID'=>$SERVICE_ID,
                      'ID_TYPE_TRANSFERT'=>$ID_TYPE_TRANSFERT,
                      'CATEGORIE_DECLARANT_ID'=>$CATEGORIE,);

       $this->Model->create('pms_documents_stage_transferts' ,$data_arr);
     
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





      redirect(base_url('administration/Affect_document_transferts/liste'));
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

  }

  ?>