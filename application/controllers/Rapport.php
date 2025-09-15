<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Rapport extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index() {


$data['PATH']=$this->input->post('PATH');

		$this->load->view('Rapport_View',$data);

	}


	public function upload($id=''){
  $data['id']=$id;

  $this->load->view('Rapport_View',$data);

	 }  


	 public function upload1()
	 {


     $id=$this->input->post('id');


                $PATH=$this->input->post('PATH_FILE');
				$photoreperatoire =FCPATH.'/uploads/docs';
				$photo_avatar="FACTURE_TELEVERSE".date('Ymdis').uniqid();
				$PATH= $_FILES['PATH_FILE']['name'];
				$config['upload_path'] ='./uploads/docs/';
				$config['allowed_types'] = '*';
				//print_r($PATH);die();
				$test = explode('.', $PATH);


				$ext = end($test);
				$name = $photo_avatar.'.'.$ext;
				$config['file_name'] =$name;

            if(!is_dir($photoreperatoire)) //create the folder if it does not already exists   
            {
            	mkdir($photoreperatoire,0777,TRUE);  

            } 

            $this->upload->initialize($config);
            $this->upload->do_upload('PATH_FILE');
            $PATH=$config['file_name'];
            $data_image=$this->upload->data();


		// if (!empty($_FILES['PATH_FILE']['name'])) 
  //       {

  //          $path_rapp=$this->upload_document1($_FILES['PATH_FILE']['tmp_name'],$_FILES['PATH_FILE']['name']);
  //         //    $PREUVE_TRANSACTION=$config['file_name'];

  //       }else
  //       {
  //           $path_rapp=NULL;
  //       }


        // print_r($path_rapp);die();



	$uploade=$this->Model->update('pms_transfert_titre_propriete',array('md5(TRANSFER_TITRE_PROPRIETE_ID)'=>$id),array('PATH_ATTESTATION_NRDV_MAIRIE'=>$PATH));


	 }



public function upload_document1($nom_file,$nom_champ)
{
  # code...

  $rep_doc =FCPATH.'uploads/docs_upload/';
  $code=date("YmdHis");
  $fichier=basename($code."piece".uniqid());
  $file_extension = pathinfo($nom_champ, PATHINFO_EXTENSION);
  $file_extension = strtolower($file_extension);
  $valid_ext = array('png','jpeg','jpg','pdf');

      if(!is_dir($rep_doc)) //create the folder if it does not already exists   
      {
        mkdir($rep_doc,0777,TRUE);
        
      }  

      move_uploaded_file($nom_file, $rep_doc.$fichier.".".$file_extension);
      $pathfile=$fichier.".".$file_extension;
      return $pathfile;

    }


	 



}
