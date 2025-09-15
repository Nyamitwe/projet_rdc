<?php 
	
	/**
	 * Ir raoul 
	   Creation des comptes, connexion des utilisateurs, chargement des sessions
	   Le 18/02/2022
	 */
	class Compte extends CI_Controller
	{
		
		function __construct()
		{
			# code...
			parent::__construct();
		}

        //Fonction principale
        
		function index()
		{
	    $data['provinces']=$this->Model->getRequete('SELECT * FROM provinces');
	    //$data['provinces']=array();
        $data['PROVINCE_ID']='';
		$this->load->view('Compte_View',$data);
		}
        
        //recherche des communes a partir de la province
		function get_commune()
        {
         $commune= $this->Model->getList("communes",array('PROVINCE_ID'=>$this->input->post('PROVINCE_ID')));

            $datas= '<select type="text" class="form-control" name="COMMUNE_ID" id="COMMUNE_ID">  <option value="">Sélectionner</option>';



           foreach($commune as $commun){


              $datas.= '<option value="'.$commun["COMMUNE_ID"].'">'.$commun["COMMUNE_NAME"].'</option>';
           }

            $datas.= '</select>';

            echo $datas;

      }

      //recherche des zones a partir de la commune
     function get_zone()
     {

        $commune= $this->Model->getList("pms_zones",array('COMMUNE_ID'=>$this->input->post('COMMUNE_ID')));

            $datas= '<select type="text" class="form-control" name="ZONE_ID" id="ZONE_ID">  <option value="">Sélectionner</option>';

           foreach($commune as $commun)
           {


              $datas.= '<option value="'.$commun["ZONE_ID"].'">'.$commun["ZONE_NAME"].'</option>';
           }

            $datas.= '</select>';

            echo $datas;

      }


      //recherche des collines a partir de la province
     function get_colline()
     {

        $commune= $this->Model->getList("collines",array('ZONE_ID'=>$this->input->post('ZONE_ID')));

            $datas= '<select type="text" class="form-control" name="ZONE_ID" id="ZONE_ID"  >
             <option value="">Sélectionner</option>';

           foreach($commune as $commun){


              $datas.= '<option value="'.$commun["COLLINE_ID"].'">'.$commun["COLLINE_NAME"].'</option>';
           }

            $datas.= '</select>';

            echo $datas;

      }

      //Enregistrement des donnees dans la base
     function save()
     {
      //$get_parcelle = $this->Model->getRequeteOne('SELECT * FROM  pms_parcelle WHERE EST_OCCUPE=0'); 
      //print_r($get_parcelle['NUM_PARCELLE']);exit();



       $this->form_validation->set_rules('PROFIL1', '', 'required',array("required"=>"<font color='red'>Le profil est requis</font>"));
       $this->form_validation->set_rules('NOM', '', 'required',array("required"=>"<font color='red'>Le nom est requis</font>"));
       $this->form_validation->set_rules('PRENOM', '', 'required',array("required"=>"<font color='red'>Le nom est requis</font>"));
       $this->form_validation->set_rules('CNI', '', 'required',array("required"=>"<font color='red'>Le nom est requis</font>"));

       $this->form_validation->set_rules('PROVINCE_ID', '', 'required',array("required"=>"<font color='red'>La province est requise</font>"));

       $this->form_validation->set_rules('COMMUNE_ID', '', 'required',array("required"=>"<font color='red'>La commune est requise</font>"));

       $this->form_validation->set_rules('ZONE_ID', '', 'required',array("required"=>"<font color='red'>La zone est requise</font>"));
       $this->form_validation->set_rules('COLLINE_ID', '', 'required',array("required"=>"<font color='red'>La colline est requise</font>"));
       $this->form_validation->set_rules('USERNAME1', '', 'required',array("required"=>"<font color='red'>Le nom d'utilisateur est requis</font>"));

       $this->form_validation->set_rules('PASSWORD1', '', 'required',array("required"=>"<font color='red'>Le mot de passe est requis</font>"));

       $this->form_validation->set_rules('TEL1', '', 'required',array("required"=>"<font color='red'>Le numéro de télephone est requis</font>"));

      $this->form_validation->set_rules('PASSWORD2', '', 'required',array("required"=>"<font color='red'>Confirmer le mot de passe</font>"));
      $this->form_validation->set_rules('DATE_NAISSANCE', '', 'required',array("required"=>"<font color='red'>La date de naissance est obligatoire</font>"));
      $this->form_validation->set_rules('SEXE_ID', '', 'required',array("required"=>"<font color='red'>Le genre est obligatoire</font>"));


        if ($this->form_validation->run() == FALSE)
            {
                
                $data['provinces']=$this->Model->getList('provinces');
                $data['PROVINCE_ID']=$this->input->post('PROVINCE_ID');
                $this->load->view('Login_view',$data);
            }

            else
            {
             if ($this->input->post('PROFIL1')==1) {
             $profil=$this->Model->getRequeteOne('SELECT * FROM pms_sys_profil WHERE PROFIL_DESCRIPTION LIKE "%Requerant%"');
             }
             else if ($this->input->post('PROFIL1')==2){

             $profil=$this->Model->getRequeteOne('SELECT * FROM pms_sys_profil  WHERE PROFIL_DESCRIPTION LIKE "%Notaire%"'); 
             }
           
             $array=array('PROFIL_ID'=>$profil['PROFIL_ID'],
                          'NOM'=>$this->input->post('NOM'),
                          'PRENOM'=>$this->input->post('PRENOM'),
                          'CNI'=>$this->input->post('CNI'),
                          'TELEPHONE'=>$this->input->post('TEL1'),
                          'TELEPHONE2'=>$this->input->post('TEL2'),
                          'CNI'=>$this->input->post('CNI'),
                          'NIF'=>$this->input->post('NIF'),
                          'RC'=>$this->input->post('RC'),
                          'EMAIL'=>$this->input->post('EMAIL'),
                          'PROVINCE_ID'=>$this->input->post('PROVINCE_ID'),
                          'COMMUNE_ID'=>$this->input->post('COMMUNE_ID'),
                          'ZONE_ID'=>$this->input->post('ZONE_ID'),
                          'COLLINE_ID'=>$this->input->post('COLLINE_ID'),
                          'USERNAME'=>$this->input->post('USERNAME1'),
                          'MOT_DE_PASSE'=>md5($this->input->post('PASSWORD1')),
                          'DATE_NAISSANCE'=>$this->input->post('DATE_NAISSANCE'),
                          'SEXE_ID'=>$this->input->post('SEXE_ID'),
                        );
                  $user_id = $this->Model->insert_last_id('pms_utilisateurs',$array);

                  $IDENTIFICATION_FONCIER="IF-".$this->input->post('PROVINCE_ID').$this->input->post('COMMUNE_ID').$this->input->post('ZONE_ID').$this->input->post('COLLINE_ID').$user_id;

                  $this->Model->update('pms_utilisateurs',array('UTILISATEUR_ID'=>$user_id),array('IDENTIFICATION_FONCIER'=>$IDENTIFICATION_FONCIER));

      
              if ($this->input->post('PROFIL1')==1) {

                $titre_users = $this->Model->getRequeteOne('SELECT * FROM pms_bps_info  WHERE ID =1'); 
                $get_parcelle = $this->Model->getRequeteOne('SELECT * FROM pms_parcelle WHERE EST_OCCUPE=0'); 

                if (!empty($get_parcelle)) {
                    if ($get_parcelle['EST_OCCUPE'] == 0) {
                        $status = 1;
                    }
                }
                $this->Model->update('pms_parcelle',array('NUM_PARCELLE'=>$get_parcelle['NUM_PARCELLE']),array('EST_OCCUPE'=>$status));

                $array=array(
                          'NOM'=>$this->input->post('NOM'),
                          'PRENOM'=>$this->input->post('PRENOM'),
                          'CNI'=>$this->input->post('CNI'),
                          'PROVINCE_ID'=>$this->input->post('PROVINCE_ID'),
                          'COMMUNE_ID'=>$this->input->post('COMMUNE_ID'),
                          'ZONE_ID'=>$this->input->post('ZONE_ID'),
                          'COLLINE_ID'=>$this->input->post('COLLINE_ID'),
                          'SUPERFICIE_HA'=>$get_parcelle['SUPERFICIE_HECTARE'],
                          'SUPERFICIE_A'=>$get_parcelle['SUPERFICIE_ARE'],
                          'SUPERFICIE_CA'=>$get_parcelle['SUPERFICIE_CA'],
                          'PATH_LETTRE_ATTRIBUTION'=>'lettre_attribution'.$user_id,
                          'PATH_CONTRAT_LOCATION'=>'contrat_location'.$user_id,
                          'PATH_TITRE_PROPRIETE'=>'titre_propriete'.$user_id,
                          'PATH_EXTRAIT_CADASTRAL'=>'extrait_cadastral'.$user_id,
                          'PATH_AUTORISATION_PAIEMENT'=>'autorisation_payment'.$user_id,
                          'PATH_PAIEMENT_FRAIS_VIABILISATION'=>'frais_viablisation'.$user_id,
                          'PATH_PAIEMENT_FRAIS_CONTRAT_LOCATION'=>'frais_contrat_location'.$user_id,
                          'PATH_PV_ARPENTAGE'=>'pv_arpentage'.$user_id,
                          'PATH_CONFORMITE_MV'=>'conformite_mv'.$user_id,
                          'NUM_PARCELLE'=>$get_parcelle['NUM_PARCELLE'],
                          'NUMERO_TITRE'=>'TITRE-'.$user_id,
                          'UTILISATEUR_ID'=>$user_id,
                        );

               $this->Model->create('pms_bps_info',$array);
               }

                      


                 $message = "<div class='alert alert-success text-center'>Enregistrement fait avec succes</div><br><div class='alert alert-warning text-center'>Il faut passer au bureau du DTF pour pouvoir activer votre compte.</div>";
                 $this->session->set_flashdata(array('message'=>$message));
                 redirect(base_url('Login'));

            }
  

     }

     public function insert_data($value='')
     {
         $donne=$this->Model->getRequete('SELECT * from pms_process_stage_new order by NUMEROTATION');

         foreach ($donne as $key => $value) {
            $array_to=('PROCESS_ID'=>19,'STAGE_ID'=>$value['STAGE_ID'],'IS_TASK'=>$value['IS_TASK'],'NUMEROTATION'=>$value['NUMEROTATION']);

            $this->Model->create('pms_process_stage_new',$array_to);
         }

         print_r('Fini !!');exit();
     }

	}
 ?>