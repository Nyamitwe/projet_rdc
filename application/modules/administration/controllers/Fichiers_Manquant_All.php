<?php
/**
 *Raoul
 *projet: pms
 *Le 26/03/2026
 *Upload des fichier manquant lors de la demande tout les process
 */
   if (!defined('BASEPATH')) exit('No direct script access allowed');

   class Fichiers_Manquant_All  extends CI_Controller 
   {

    function __construct()
    {
      parent::__construct();   
    } 
    

  
    
    public function index()
    {                                                                           $data['html']='';
    $data['process']=$this->Model->getRequete('SELECT * FROM pms_process order by DESCRIPTION_PROCESS');
    $this->load->view('Fichiers_Manquant_All_View',$data);
    }


    function get_doc()
    {
      
     $CODE_DEMANDE=$this->input->post('CODE_DEMANDE');
     $PROCESS_ID=$this->input->post('PROCESS_ID');

     $one_data=$this->Model->getRequeteOne('SELECT `ID_TYPE_TRANSFERT`,`CATEGORIE_DECLARANT_ID`,`TYPE_ACHETEUR` FROM `pms_traitement_demande` WHERE 1 and PROCESS_ID='.$PROCESS_ID.' and `CODE_DEMANDE`="'.$CODE_DEMANDE.'"');

     if (!empty($one_data)) {

     if ($PROCESS_ID==19) {
   
     

     
      
   

     $ID_TYPE_TRANSFERT=$one_data['ID_TYPE_TRANSFERT'];
     $TYPE_ACHETEUR=$one_data['TYPE_ACHETEUR'];
     $CATEGO=$one_data['CATEGORIE_DECLARANT_ID'];


     $crit=' and CODE_TRAITEMENT="'.$CODE_DEMANDE.'"';


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
    }else{
    
     $doc=$this->Model->getRequete('SELECT pms_documents.ID_DOCUMENT,pms_documents.DESC_DOCUMENT,pms_documents.PATH_FILE FROM pms_documents JOIN pms_document_process ON pms_document_process.ID_DOCUMENT=pms_documents.ID_DOCUMENT WHERE pms_documents.ID_TYPE_DOCUMENT=1 AND pms_documents.ID_DOCUMENT!=24 AND pms_document_process.PROCESS_ID='.$PROCESS_ID.' order by DESC_DOCUMENT');

    }


    $html='';
    $i=0;
    foreach ($doc as $key => $value) {
    $i++;

    $test_val=$this->Model->getOne('pms_documents_demande',array('ID_DOCUMENT'=>$value['ID_DOCUMENT'],'PROCESS_ID'=>$PROCESS_ID,'CODE_TRAITEMENT'=>$CODE_DEMANDE));
   

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
    
    $typ = $this->Model->getRequeteOne('SELECT ID_TYPE_TRANSFERT,CATEGORIE_DECLARANT_ID from pms_traitement_demande where `CODE_DEMANDE`="'.$this->input->post('CODE_DEMANDE').'" and PROCESS_ID='.$this->input->post('PROCESS_ID').'');

      //Recuperation de ID du trasfert et du categorie/
    $trans=0;
    $categ=0;

    if ($this->input->post('PROCESS_ID')==19) {
    
   
    if (!empty($typ)) {
      $trans=$typ['ID_TYPE_TRANSFERT'];
      $categ=$typ['CATEGORIE_DECLARANT_ID'];
    }

  


     $crit='';


     if (!empty($trans)) {
     $crit.=' and pms_transfert_document_vs_requerant.ID_TYPE_TRANSFERT='.$trans.'';
     }

   
     if (!empty($categ)) {
     $crit.=' and pms_transfert_document_vs_requerant.ID_CATEGORIE_TRANSFERT='.$categ.'';
     }


   
    $file=$this->Model->getRequete('SELECT pms_documents.* from pms_documents JOIN pms_transfert_document_vs_requerant on pms_documents.`ID_DOCUMENT`=pms_transfert_document_vs_requerant.DOCUMENT_TRANSFERT_ID where ID_TYPE_DOCUMENT=1 and SCAN_TRAITEMENT=0 '.$crit.' GROUP BY ID_DOCUMENT order by DESC_DOCUMENT');
     }else{

    $file=$this->Model->getRequete('SELECT pms_documents.ID_DOCUMENT,pms_documents.DESC_DOCUMENT,pms_documents.PATH_FILE FROM pms_documents JOIN pms_document_process ON pms_document_process.ID_DOCUMENT=pms_documents.ID_DOCUMENT WHERE pms_documents.ID_TYPE_DOCUMENT=1 AND pms_documents.ID_DOCUMENT!=24 AND pms_document_process.PROCESS_ID='.$this->input->post('PROCESS_ID').' order by DESC_DOCUMENT');
    }

  
   foreach ($file as $key => $value) 
    {

      $test_val=$this->Model->getOne('pms_documents_demande',array('ID_DOCUMENT'=>$value['ID_DOCUMENT'],'PROCESS_ID'=>$this->input->post('PROCESS_ID'),'CODE_TRAITEMENT'=>$this->input->post('CODE_DEMANDE')));
   

    if (empty($test_val)) {
     $sub_array = array(
        'PATH_DOC'=>$this->upload_file1(''.$value['PATH_FILE'].''),
        'ID_DOCUMENT'=>$value['ID_DOCUMENT'],
        'PROCESS_ID'=>$this->input->post('PROCESS_ID'),
        'CODE_TRAITEMENT'=>$this->input->post('CODE_DEMANDE'),
      );
    $id=$this->Model->insert_last_id('pms_documents_demande',$sub_array);
    }else if (!empty($test_val)) {
     
    

      $filePath=''.FCPATH.'/uploads/doc_scanner/'.$test_val['PATH_DOC'].'';
      
    if (!$this->isFileValid($filePath)) {
    $this->Model->delete('pms_documents_demande',array('ID_DOCUMENT'=>$value['ID_DOCUMENT'],'PROCESS_ID'=>$this->input->post('PROCESS_ID'),'CODE_TRAITEMENT'=>$this->input->post('CODE_DEMANDE')));
     $sub_array = array(
        'PATH_DOC'=>$this->upload_file1(''.$value['PATH_FILE'].''),
        'ID_DOCUMENT'=>$value['ID_DOCUMENT'],
        'PROCESS_ID'=>$this->input->post('PROCESS_ID'),
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
    redirect(base_url('administration/Fichiers_Manquant_All'));
  }


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


   
  }

  ?>