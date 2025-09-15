<?php

class Mylibrary
{
      protected $CI;
	function __construct()
	{
	    $this->CI = & get_instance();
      $this->CI->load->library('upload');
      $this->CI->load->library('email');
      $this->CI->load->model('Model');
	}

	public function getOne($table, $array)
	{
		return $this->CI->Model->getOne($table,$array);
	}

  public function get_droit_menu($nom_menu='')
  {
    // $this->CI->load->helper('url');

    // $uri = uri_string();
    // $segments = explode('/', $uri);

    // $menu='';

    // $ct=count($segments);

    // for ($i=0; $i <$ct ; $i++) { 
    // $menu.=$segments[$i].'/';
    // }

    // $menu.='@';

    // $menu=str_replace('/@','', $menu);


    $request_to_verify=$this->CI->Model->getRequeteOne('SELECT * FROM pms_menus_profiles JOIN pms_menus on pms_menus.ID_PMS_MENU=pms_menus_profiles.ID_PMS_MENU WHERE pms_menus_profiles.ID_PROFILE='.$this->CI->session->userdata('PMS_POSTE_ID').' and pms_menus.DESC_MENU="'.$nom_menu.'"');
 
    if (!empty($request_to_verify)) {
     return true;
    }else
    {
      return false;
    }

  }


    public function get_droit_sous_menu($link='')
  {
    $request_to_verify=$this->CI->Model->getRequeteOne('SELECT * FROM pms_menus_profiles JOIN pms_menus on pms_menus.ID_PMS_MENU=pms_menus_profiles.ID_PMS_MENU WHERE pms_menus_profiles.ID_PROFILE='.$this->CI->session->userdata('PMS_POSTE_ID').' and pms_menus.MENU_LINK="'.$link.'"');

    if (!empty($request_to_verify)) {
     return true;
    }else
    {
      return false;
    }

  }



  function Statut_possession($table_action = '',$ACTION_ID='', $PROCESS_ID = '', $ID_TRAITEMENT_DEMANDE = '', $ETAT_TROUVE)
 {
  //  print_r($ETAT_TROUVE);die();
  $msg_info = '';

  $get_next_stage=$this->CI->Model->getOne($table_action,['ACTION_ID'=>$ACTION_ID]);

  if(!empty($get_next_stage)) {

    $get_process_stage_id=$this->CI->Model->getRequeteOne('SELECT * FROM `pms_process_stage` WHERE PROCESS_ID='.$PROCESS_ID.' AND STAGE_ID='.$get_next_stage['NEXT_STAGE']);
    // print_r($get_process_stage_id);die();
    
    if(!empty($get_process_stage_id))
    {
      $get_poste_stage=$this->CI->Model->getOne('pms_process_service',array('ID_PROCESS_STAGE'=>$get_process_stage_id['ID_PROCESS_STAGE']));
    // print_r($get_poste_stage);die();

      if(!empty($get_poste_stage)) {

        $get_poste_actual_service=$this->CI->Model->getOne('pms_poste_service',array('ID_POSTE'=>$get_poste_stage['ID_POSTE']));
        // print_r($get_poste_actual_service);die();

        $pms_user_poste=$this->CI->Model->getOne('pms_user_poste',array('ID_USER'=>$this->CI->session->userdata('PMS_USER_ID')));

        if(!empty($get_poste_actual_service)){

          // $data_save=array('STAGE_ID'=>$get_next_stage['NEXT_STAGE']);
          $data_save=array('STATUT_POSSESSION'=>$ETAT_TROUVE);
          // print_r($data_save);die();

          $this->CI->Model->update('pms_traitement_demande',
            array(
              'ID_TRAITEMENT_DEMANDE'=>$ID_TRAITEMENT_DEMANDE
            ),
            $data_save);

          if($get_next_stage['NEXT_STAGE']>0){

            $data_historique=array(
              'ID_TRAITEMENT_DEMANDE'=>$ID_TRAITEMENT_DEMANDE,
              'STAGE_ID'=>$get_next_stage['STAGE_ID'],
              'ACTION_ID'=>$ACTION_ID,
              'DATE_TRAITEMENT'=>date('Y-m-d'),     
              'UTILISATEUR_ID'=>$this->CI->session->userdata('PMS_USER_ID'),
              'SERVICE_EXPEDITEUR'=>$this->CI->session->userdata('PMS_SERVICE_ID'),
              'SERVICE_DESTINATEUR'=>$get_poste_actual_service['ID_SERVICE'],
              'POSTE_EXPEDITEUR'=>$pms_user_poste['ID_POSTE'],
              'POSTE_DESTINATEUR'=>$get_poste_actual_service['ID_POSTE']
            );

            $this->CI->Model->create('pms_historique_traitement_demande',$data_historique);
            $msg_info = 'Succées';

          }

        }else{

          $msg_info = 'ID process stage ne pas connu';

        }


      }else{

        $msg_info = 'ID process stage ne pas connu';
      }


    }else{

      $msg_info = 'Next stage ne pas connu comme stage dans la table stage ou l\'ID du process ne pas connu';

    }

  }else{

    $msg_info = 'Probleme avec l\'action utilisee';

  }

  return $msg_info;
}


















 function Registre_rec_trans($table_action = '',$ACTION_ID='', $PROCESS_ID = '', $ID_TRAITEMENT_DEMANDE = '')
 {
  $msg_info = '';

  $get_next_stage=$this->CI->Model->getOne($table_action,['ACTION_ID'=>$ACTION_ID]);
  // print_r($table_action.'-'.$ACTION_ID.'-'.$PROCESS_ID.'-'.$ID_TRAITEMENT_DEMANDE);
  // exit();
  if(!empty($get_next_stage)) {

    $get_process_stage_id=$this->CI->Model->getRequeteOne('SELECT * FROM `pms_process_stage` WHERE PROCESS_ID='.$PROCESS_ID.' AND STAGE_ID='.$get_next_stage['NEXT_STAGE']);
    // print_r($get_process_stage_id);
    // exit();
    
    if(!empty($get_process_stage_id))
    {
      $get_poste_stage=$this->CI->Model->getOne('pms_process_service',array('ID_PROCESS_STAGE'=>$get_process_stage_id['ID_PROCESS_STAGE']));
    // print_r($get_poste_stage);die();

     // print_r($get_poste_stage);die();

      if(!empty($get_poste_stage)) {

        $get_poste_actual_service=$this->CI->Model->getOne('pms_poste_service',array('ID_POSTE'=>$get_poste_stage['ID_POSTE']));
        // print_r($get_poste_actual_service);die();

        $pms_user_poste=$this->CI->Model->getOne('pms_user_poste',array('ID_USER'=>$this->CI->session->userdata('PMS_USER_ID')));

        if(!empty($get_poste_actual_service)){

          $data_save=array('STAGE_ID'=>$get_next_stage['NEXT_STAGE']);

          $this->CI->Model->update('pms_traitement_demande',
            array(
              'ID_TRAITEMENT_DEMANDE'=>$ID_TRAITEMENT_DEMANDE
            ),
            $data_save);

          $dmd_irq=$this->CI->Model->getRequeteOne('SELECT  `ID_REQUERANT`,CODE_DEMANDE FROM `pms_traitement_demande` WHERE  ID_TRAITEMENT_DEMANDE='.$ID_TRAITEMENT_DEMANDE); 
          $dmd_etap=$this->CI->Model->getRequeteOne('SELECT `STAGE_ID`, `DESCRIPTION_STAGE` FROM `pms_stage` WHERE STAGE_ID='.$get_next_stage['NEXT_STAGE']); 
          $result1 = $this->CI->pms_api->info_requerant($dmd_irq['ID_REQUERANT']);
       $fullname = $result1->data[0]->fullname;
       $mobile= $result1->data[0]->mobile;
       $mailTo= $result1->data[0]->email;
       // $mailTo="kwzrdmnd@gmail.com";
       $subject='Etat d\'avacencement';

       $message="Bonjour ".$fullname.", suite à votre demande inscrit sur le numéro ".$dmd_irq['CODE_DEMANDE'].", est maintenant sur l etape de ".$dmd_etap['DESCRIPTION_STAGE'].".";


       $data_notification=array('MESSAGE'=>$message,
        'EMAIL'=>$mailTo,
        'TELEPHONE'=>$mobile,
        'CIBLE'=>2,
        'USER_NOTIFIE'=>$this->CI->session->userdata('PMS_USER_ID'),
        'PROCESS_ID'=>$PROCESS_ID,
        'STAGE_ID'=>$get_next_stage['NEXT_STAGE'],
        'CIBLE'=>2
      );


       $this->CI->Model->create('pms_notifications',$data_notification);

       $this->CI->notifications->send_mail($mailTo,$subject,$cc_emails=array(),$message,$attach=array());

          // $this->CI->notifications->send_sms_smpp($smsTo,$message);

          if($get_next_stage['NEXT_STAGE']>0){

            $data_historique=array(
              'ID_TRAITEMENT_DEMANDE'=>$ID_TRAITEMENT_DEMANDE,
              'STAGE_ID'=>$get_next_stage['STAGE_ID'],
              'ACTION_ID'=>$ACTION_ID,
              'DATE_TRAITEMENT'=>date('Y-m-d'),     
              'UTILISATEUR_ID'=>$this->CI->session->userdata('PMS_USER_ID'),
              'SERVICE_EXPEDITEUR'=>$this->CI->session->userdata('PMS_SERVICE_ID'),
              'SERVICE_DESTINATEUR'=>$get_poste_actual_service['ID_SERVICE'],
              'POSTE_EXPEDITEUR'=>$pms_user_poste['ID_POSTE'],
              'POSTE_DESTINATEUR'=>$get_poste_actual_service['ID_POSTE']
            );

            $id_historique=$this->CI->Model->insert_last_id('pms_historique_traitement_demande',$data_historique);
            $msg_info = 'Succées|'.$id_historique.'';
            return $msg_info;

          }
        }else{

          $msg_info = 'ID process stage ne pas connu';

        }

      }else{

        $msg_info = 'ID process stage ne pas connu';
      }


    }else{

      $msg_info = 'Next stage ne pas connu comme stage dans la table stage ou l\'ID du process ne pas connu';

    }

  }else{

    $msg_info = 'Probleme avec l\'action utilisee';

  }

  return $msg_info;
}


  public function Registre_rec_trans_perte($table_action = '',$ACTION_ID='', $PROCESS_ID = '', $ID_TRAITEMENT_DEMANDE = '')
  {
   
    $msg_info = '';

    $get_next_stage=$this->CI->Model->getOne($table_action,['ID'=>$ACTION_ID]);

    if(!empty($get_next_stage)) {

      $get_process_stage_id=$this->CI->Model->getRequeteOne('SELECT * FROM `pms_process_stage` WHERE PROCESS_ID='.$PROCESS_ID.' AND STAGE_ID='.$get_next_stage['NEXT_STAGE']);

      if(!empty($get_process_stage_id))
      {

        $get_poste_stage=$this->CI->Model->getOne('pms_process_service',array('ID_PROCESS_STAGE'=>$get_process_stage_id['ID_PROCESS_STAGE']));

        if(!empty($get_poste_stage)) {

          $get_poste_actual_service=$this->CI->Model->getOne('pms_poste_service',array('ID_POSTE'=>$get_poste_stage['ID_POSTE']));

          $pms_user_poste=$this->CI->Model->getOne('pms_user_poste',array('ID_USER'=>$this->CI->session->userdata('PMS_USER_ID')));


          if(!empty($get_poste_actual_service)){

            $data_save=array('STAGE_ID'=>$get_next_stage['NEXT_STAGE']);

            $this->CI->Model->update('pms_traitement_demande',
              array(
                'ID_TRAITEMENT_DEMANDE'=>$ID_TRAITEMENT_DEMANDE
              ),
              $data_save);

            if($get_next_stage['NEXT_STAGE']>0){

              $data_historique=array(
                'ID_TRAITEMENT_DEMANDE'=>$ID_TRAITEMENT_DEMANDE,
                'STAGE_ID'=>$get_next_stage['STAGE_ID'],
                'ACTION_ID'=>$ACTION_ID,
                'DATE_TRAITEMENT'=>date('Y-m-d'),     
                'UTILISATEUR_ID'=>$this->CI->session->userdata('PMS_USER_ID'),
                'SERVICE_EXPEDITEUR'=>$this->CI->session->userdata('PMS_SERVICE_ID'),
                'SERVICE_DESTINATEUR'=>$get_poste_actual_service['ID_SERVICE'],
                'POSTE_EXPEDITEUR'=>$pms_user_poste['ID_POSTE'],
                'POSTE_DESTINATEUR'=>$get_poste_actual_service['ID_POSTE']
              );

              $this->CI->Model->create('pms_historique_traitement_demande',$data_historique);
              $msg_info = 'Succées';

            }

          }else{

            $msg_info = 'ID process stage ne pas connu';

          }

        }else{

          $msg_info = 'ID process stage ne pas connu';
        }


      }else{

        $msg_info = 'Next stage ne pas connu comme stage dans la table stage ou l\'ID du process ne pas connu';

      }

    }else{

      $msg_info = 'Probleme avec l\'action utilisee';

    }

    return $msg_info;
  }


	public function get_permission($url)
	{
		//echo $url;
		$autorised = 0;
		if(empty($this->CI->Model->getOne('admin_fonctionnalites',array('FONCTIONNALITE_URL'=>$url)))){
          $autorised =1;
		}else{
			$data = $this->CI->Model->get_permission($url);

		  if(!empty($data))
		  	{
		  		$autorised =1;
		  	}
	  }

	  return $autorised;
	}

  public function built_steps($step)
  {
   $etapes = array(
                   '1'=>''.lang("personel_info").'',
                   '2'=>'Documents Medicaux',
                   '3'=>''.lang("bank_data").'',
                   '4'=>"Contacts",
                   '5'=>''.lang('Relation_familiale').'',
                   '6'=>''.lang('title_personne_reference').'',
                   '7'=>"Documents"
                 );
    $html_etapes = "";
    foreach ($etapes as $key => $value) {
      //#337ab7, ,  ffeb99
      $step_bg = ($step ==$key)?'#d2ff4d':(($step > $key)?'#5cb85c':'white');
      $step_txt = ($step <= $key)?'#111':"#FFF";
     
      $variable = "<center><div class='col-md-2'>"; 
      if($key == 7 || $key == 4){
        $variable = "<center><div class='col-md-1'>";
      }
      $html_etapes .= $variable.
                      "<div class='img-circle' style='width:20px;height:20px;background-color:".$step_bg.";border:1px solid #d9d9d9'>
                      <span style='color:".$step_txt."'>".$key."</span>
                      </div>".$value."</div></center>";
    }

    return $html_etapes;
  }
   public function built_steps2($step)
  {
   $etapes = array(
                   '1'=>'Identification',
                   '2'=>'Affectation',
                  
                 );
    $html_etapes = "";
    foreach ($etapes as $key => $value) {
      //#337ab7, ,  ffeb99
      $step_bg = ($step ==$key)?'#d2ff4d':(($step > $key)?'#5cb85c':'white');
      $step_txt = ($step <= $key)?'#111':"#FFF";
     
      $variable = "<center><div class='col-md-2'>"; 
     
      $html_etapes .= $variable.
                      "<div class='img-circle' style='width:20px;height:20px;background-color:".$step_bg.";border:1px solid #d9d9d9'>
                      <span style='color:".$step_txt."'>".$key."</span>
                      </div>".$value."</div></center>";
    }

    return $html_etapes;
  }

  public function upload_file($post_file,$folder_dest,$name_file,$file_typs="*")
  {
        if(!is_dir(FCPATH.$folder_dest)){
            mkdir(FCPATH.$folder_dest, 0777, TRUE);
        }

        $config['upload_path']          = '.'.$folder_dest;
        $config['allowed_types']        = $file_typs;
        $config['max_height']           = 2048;
        $config['file_name']           = $name_file.'_'.$_FILES[$post_file]['name'];
        $config['max_size']             = 1000;
        $config['overwrite']           = TRUE;

        $this->CI->upload->initialize($config);

        if (!$this->CI->upload->do_upload($post_file))
        {
          //return $this->CI->upload->display_errors();
          return '';
        }
        else
        {
          return $config['upload_path'].  $config['file_name'];
        }
  }

public function built_steps3($step)
  {
   $etapes = array(
                   '1'=>'Identification',
                   '2'=>'Ajout membre(s)',
                   '3'=>'Lieu d\'Affectation',
                   '4'=>'Ajout matériel(s)',
                  
                 );
    $html_etapes = "";
    foreach ($etapes as $key => $value) {
      //#337ab7, ,  ffeb99
      $step_bg = ($step ==$key)?'#d2ff4d':(($step > $key)?'#5cb85c':'white');
      $step_txt = ($step <= $key)?'#111':"#FFF";
     
      $variable = "<center><div class='col-md-2'>"; 
     
      $html_etapes .= $variable.
                      "<div class='img-circle' style='width:20px;height:20px;background-color:".$step_bg.";border:1px solid #d9d9d9'>
                      <span style='color:".$step_txt."'>".$key."</span>
                      </div>".$value."</div></center>";
    }

    return $html_etapes;
  }
  public function upload_document($post_file,$folder_dest,$file_typs="*")
  {
    if(!is_dir(FCPATH.$folder_dest)){
        mkdir(FCPATH.$folder_dest, 0777, TRUE);
    }

    $config['upload_path']          = '.'.$folder_dest;
    $config['allowed_types']        = $file_typs;
    $config['max_height']           = 2048;
    $config['file_name']            = $_FILES[$post_file]['name'];
    $config['max_size']             = 1000;
    $config['overwrite']            = TRUE;

    $this->CI->upload->initialize($config);

    if (!$this->CI->upload->do_upload($post_file))
    {
      return FALSE;
    }
    else
    {
      return TRUE;
    }
  }



   public function get_signature($user_id)
  {
   
   // $query = $this->CI->Model->getRequeteOne('SELECT element_5 FROM `ap_form_11589` JOIN mf_user_profile ON ap_form_11589.id=mf_user_profile.entry_id WHERE 1 AND user_id='.$user_id.'');
   $query ='';
    
     $images='';
   
    if (!empty($query)) 
    {
     // $images='https://bps.gov.bi/asset_data/form_11589/files/'.$query['element_5'];
     $images='/var/www/html/cpv2.7p2/web/asset_data/form_11589/files/'.$query['element_5'];
    }
  
    return $images;
   }




   //Lire les dates en lettres 

public function dateenlitterale($str,$format=1) 
    {
    $year=date('Y',strtotime($str));
    if (intval($year)<1960) {
        # code...
        return $str;
    }else{
    // Récupère la date dans des variables
    list($annee, $mois, $jour) = explode("-", $str);
    // Retire le 0 des jours
    if ($jour=="00") $jour="";
    elseif (substr($jour, 0, 1)=="0") $jour=substr($jour, 1, 1);
    // Met le mois en littéral
    $moisli[1] =  "janvier";
    $moisli[2] =  "février";
    $moisli[3] =  "mars";
    $moisli[4] =  "avril";
    $moisli[5] =  "mai";
    $moisli[6] =  "juin";
    $moisli[7] =  "juillet";
    $moisli[8] =  "août";
    $moisli[9] =  "septembre";
    $moisli[10] =  "octobre";
    $moisli[11] =  "novembre";
    $moisli[12] =  "décembre";


    $jourli[1] =  "premier";
    $jourli[2] =  "deuxième";
    $jourli[3] =  "troisième";
    $jourli[4] =  "quatrième";
    $jourli[5] =  "cinquième";
    $jourli[6] =  "sixième";
    $jourli[7] =  "septième";
    $jourli[8] =  "huitième";
    $jourli[9] =  "neuvième";
    $jourli[10] =  "dixième";
    $jourli[11] =  "onzième";
    $jourli[12] =  "douzième";
    $jourli[13] =  "treizième";
    $jourli[14] =  "quatorzième";
    $jourli[15] =  "quinzième";
    $jourli[16] =  "seizième";
    $jourli[17] =  "dix-septième";
    $jourli[18] =  "dix-huitième";
    $jourli[19] =  "dix-neuvième";
    $jourli[20] =  "vingtième";
    $jourli[21] =  "vingt unième";
    $jourli[22] =  "vingt deuxième";
    $jourli[23] =  "vingt troisième";
    $jourli[24] =  "vingt quatrième";
    $jourli[25] =  "vingt cinquième";
    $jourli[26] =  "vingt sixième";
    $jourli[27] =  "vingt septième";
    $jourli[28] =  "vingt huitième";
    $jourli[29] =  "vingt neuvième";
    $jourli[30] =  "trentième";
    $jourli[31] =  "le trente-et-unième";

//1960
    $anneeli[1960]="Mille-neuf-cent-soixante";
    $anneeli[1961]="Mille-neuf-cent-soixante-et-un";
    $anneeli[1962]="Mille-neuf-cent-soixante-deux";
    $anneeli[1963]="Mille-neuf-cent-soixante-trois";
    $anneeli[1964]="Mille-neuf-cent-soixante-quatre";
    $anneeli[1965]="Mille-neuf-cent-soixante-cinq";
    $anneeli[1966]="Mille-neuf-cent-soixante-six";
    $anneeli[1967]="Mille-neuf-cent-soixante-sept";
    $anneeli[1968]="Mille-neuf-cent-soixante-huit";
    $anneeli[1969]="Mille-neuf-cent-soixante-neuf";
    
//1970
    $anneeli[1970]="Mille-neuf-cent-soixante-dix";
    $anneeli[1971]="Mille-neuf-cent-soixante-et-onze";
    $anneeli[1972]="Mille-neuf-cent-soixante-douze";
    $anneeli[1973]="Mille-neuf-cent-soixante-treize";
    $anneeli[1974]="Mille-neuf-cent-soixante-quatorze";
    $anneeli[1975]="Mille-neuf-cent-soixante-quinze";
    $anneeli[1976]="Mille-neuf-cent-soixante-seize";
    $anneeli[1977]="Mille-neuf-cent-soixante-dix-sept";
    $anneeli[1978]="Mille-neuf-cent-soixante-dix-huit";
    $anneeli[1979]="Mille-neuf-cent-soixante-dix-neuf";
//1980
    $anneeli[1980]="Mille-neuf-cent-quatre-vingts";
    $anneeli[1981]="Mille-neuf-cent-quatre-vingt-un";
    $anneeli[1982]="Mille-neuf-cent-quatre-vingt-deux";
    $anneeli[1983]="Mille-neuf-cent-quatre-vingt-trois";
    $anneeli[1984]="Mille-neuf-cent-quatre-vingt-quatre";
    $anneeli[1985]="Mille-neuf-cent-quatre-vingt-cinq";
    $anneeli[1986]="Mille-neuf-cent-quatre-vingt-six";
    $anneeli[1987]="Mille-neuf-cent-quatre-vingt-sept";
    $anneeli[1988]="Mille-neuf-cent-quatre-vingt-huit";
    $anneeli[1989]="Mille-neuf-cent-quatre-vingt-neuf";  
//1990
    $anneeli[1990]="Mille-neuf-cent-quatre-vingt-dix";
    $anneeli[1991]="Mille-neuf-cent-quatre-vingt-onze";
    $anneeli[1992]="Mille-neuf-cent-quatre-vingt-douze";
    $anneeli[1993]="Mille-neuf-cent-quatre-vingt-treize";
    $anneeli[1994]="Mille-neuf-cent-quatre-vingt-quatorze";
    $anneeli[1995]="Mille-neuf-cent-quatre-vingt-quinze";
    $anneeli[1996]="Mille-neuf-cent-quatre-vingt-seize";
    $anneeli[1997]="Mille-neuf-cent-quatre-vingt-dix-sept";
    $anneeli[1998]="Mille-neuf-cent-quatre-vingt-dix-huit";
    $anneeli[1999]="Mille-neuf-cent-quatre-vingt-dix-neuf";     
//2000
    $anneeli[2000]="Deux-mille";
    $anneeli[2001]="Deux-mille-un";
    $anneeli[2002]="Deux-mille-deux";
    $anneeli[2003]="Deux-mille-trois";
    $anneeli[2004]="Deux-mille-quatre";
    $anneeli[2005]="Deux-mille-cinq";
    $anneeli[2006]="Deux-mille-six";
    $anneeli[2007]="Deux-mille-sept";
    $anneeli[2008]="Deux-mille-huit";
    $anneeli[2009]="Deux-mille-neuf";

    $anneeli[2010]="Deux-mille-dix";
    $anneeli[2011]="Deux-mille-onze";
    $anneeli[2012]="Deux-mille-douze";
    $anneeli[2013]="Deux-mille-treize";
    $anneeli[2014]="Deux-mille-quatorze";
    $anneeli[2015]="Deux-mille-quinze";
    $anneeli[2016]="Deux-mille-seize";
    $anneeli[2017]="Deux-mille-dix-sept";
    $anneeli[2018]="Deux-mille-dix-huit";
    $anneeli[2019]="Deux-mille-dix-neuf";

    $anneeli[2020] =  "deux mille vingt";
    $anneeli[2021] =  "deux mille vingt-un";
    $anneeli[2022] =  "deux mille vingt deux ";
    $anneeli[2023] =  "deux mille vingt trois ";
    $anneeli[2024] =  "deux mille vingt quatre ";
    $anneeli[2025] =  "deux mille vingt cinq ";
    $anneeli[2026] =  "deux mille vingt six ";
    $anneeli[2027] =  "deux mille vingt sept ";
    $anneeli[2028] =  "deux mille vingt huit ";
    $anneeli[2029] =  "deux mille vingt neuf ";
    $anneeli[2030] =  "deux mille trente";
    $anneeli[2031] =  "deux mille trente-un";
    $anneeli[2032] =  "deux mille trente deux";
    $anneeli[2033] =  "deux mille trente trois";
    $anneeli[2034] =  "deux mille trente quatre";
    $anneeli[2035] =  "deux mille trente cinq ";
    $anneeli[2036] =  "deux mille trente six";
    $anneeli[2037] =  "deux mille trente sept";
    $anneeli[2038] =  "deux mille trente huit";
    $anneeli[2039] =  "deux mille trente neuf";
    $anneeli[2040] =  "deux mille quarante";
    $anneeli[2041] =  "deux mille quarante un";
    $anneeli[2042] =  "deux mille quarante deux";
    $anneeli[2043] =  "deux mille quarante trois";
    $anneeli[2044] =  "deux mille quarante quatre";
    $anneeli[2045] =  "deux mille quarante cinq";
    $anneeli[2046] =  "deux mille quarante six";
    $anneeli[2047] =  "deux mille quarante sept";
    $anneeli[2048] =  "deux mille quarante huit";
    $anneeli[2049] =  "deux mille quarante neuf ";
    $anneeli[2050] =  "deux mille cinquante";

    $anneeli[2051] =  "deux mille cinquante un";
    $anneeli[2052] =  "deux mille cinquante deux";
    $anneeli[2053] =  "deux mille cinquante trois";
    $anneeli[2054] =  "deux mille cinquante quatre";
    $anneeli[2055] =  "deux mille cinquante cinq";
    $anneeli[2056] =  "deux mille cinquante six";
    $anneeli[2057] =  "deux mille cinquante sept";
    $anneeli[2058] =  "deux mille cinquante huit";
    $anneeli[2059] =  "deux mille cinquante neuf ";

    $anneeli[2060] =  "deux mille soixante";
    $anneeli[2061] =  "deux mille soixante un";
    $anneeli[2062] =  "deux mille soixante deux";
    $anneeli[2063] =  "deux mille soixante trois";
    $anneeli[2064] =  "deux mille soixante quatre";
    $anneeli[2065] =  "deux mille soixante cinq";
    $anneeli[2066] =  "deux mille soixante six";
    $anneeli[2067] =  "deux mille soixante sept";
    $anneeli[2068] =  "deux mille soixante huit";
    $anneeli[2069] =  "deux mille soixante neuf ";

    $anneeli[2070] =  "deux mille soixante-dix";
    $anneeli[2071] =  "deux mille soixante-dix un";
    $anneeli[2072] =  "deux mille soixante-dix deux";
    $anneeli[2073] =  "deux mille soixante-dix trois";
    $anneeli[2074] =  "deux mille soixante-dix quatre";
    $anneeli[2075] =  "deux mille soixante-dix cinq";
    $anneeli[2076] =  "deux mille soixante-dix six";
    $anneeli[2077] =  "deux mille soixante-dix sept";
    $anneeli[2078] =  "deux mille soixante-dix huit";
    $anneeli[2079] =  "deux mille soixante-dix neuf ";

    $anneeli[2080] =  "deux mille quatre-vingt";
    $anneeli[2081] =  "deux mille quatre-vingt un";
    $anneeli[2082] =  "deux mille quatre-vingt deux";
    $anneeli[2083] =  "deux mille quatre-vingt trois";
    $anneeli[2084] =  "deux mille quatre-vingt quatre";
    $anneeli[2085] =  "deux mille quatre-vingt cinq";
    $anneeli[2086] =  "deux mille quatre-vingt six";
    $anneeli[2087] =  "deux mille quatre-vingt sept";
    $anneeli[2088] =  "deux mille quatre-vingt huit";
    $anneeli[2089] =  "deux mille quatre-vingt neuf ";
    $anneeli[2089] =  "deux mille quatre-vingt neuf ";

    $anneeli[2099] =  "deux mille quatre-vingt-dix";
    $anneeli[2091] =  "deux mille quatre-vingt-dix un";
    $anneeli[2092] =  "deux mille quatre-vingt-dix deux";
    $anneeli[2093] =  "deux mille quatre-vingt-dix trois";
    $anneeli[2094] =  "deux mille quatre-vingt-dix quatre";
    $anneeli[2095] =  "deux mille quatre-vingt-dix cinq";
    $anneeli[2096] =  "deux mille quatre-vingt-dix six";
    $anneeli[2097] =  "deux mille quatre-vingt-dix sept";
    $anneeli[2098] =  "deux mille quatre-vingt-dix huit";
    $anneeli[2099] =  "deux mille quatre-vingt-dix neuf ";
    $anneeli[20100] =  "deux mille cent ";



    if (substr($mois, 0, 1)=="0") $mois=substr($mois, 1, 1);
    $mois = $moisli[$mois];

    if (substr($jour, 0, 1)=="0") $jour=substr($jour, 1, 1);
    $jour = $jourli[$jour];

    if (substr($annee, 0, 1)=="0") $annee=substr($annee, 1, 1);
    $annee = $anneeli[$annee];

    $str="";
    // $str_anne="";

    if ($format==1) {
        # code...
        //Date de signature lettre:L’an deux mille-VINGT-DEUX, le jour du mois…………..,
         
        $str = 'L\'an '.$annee.' le '.$jour.' jour du mois '.$mois;
    }
    return $str;
   }

    }    

    public function getannee($str) 
    {
    $year=date('Y');
    $mois=date('m');
    $jour=date('d');
 
    $moisli[1] =  "janvier";
    $moisli[2] =  "février";
    $moisli[3] =  "mars";
    $moisli[4] =  "avril";
    $moisli[5] =  "mai";
    $moisli[6] =  "juin";
    $moisli[7] =  "juillet";
    $moisli[8] =  "août";
    $moisli[9] =  "septembre";
    $moisli[10] =  "octobre";
    $moisli[11] =  "novembre";
    $moisli[12] =  "décembre";


    $jourli[1] =  "premier";
    $jourli[2] =  "deuxième";
    $jourli[3] =  "troisième";
    $jourli[4] =  "quatrième";
    $jourli[5] =  "cinquième";
    $jourli[6] =  "sixième";
    $jourli[7] =  "septième";
    $jourli[8] =  "huitième";
    $jourli[9] =  "neuvième";
    $jourli[10] =  "dixième";
    $jourli[11] =  "onzième";
    $jourli[12] =  "douzième";
    $jourli[13] =  "treizième";
    $jourli[14] =  "quatorzième";
    $jourli[15] =  "quinzième";
    $jourli[16] =  "seizième";
    $jourli[17] =  "dix-septième";
    $jourli[18] =  "dix-huitième";
    $jourli[19] =  "dix-neuvième";
    $jourli[20] =  "vingtième";
    $jourli[21] =  "vingt unième";
    $jourli[22] =  "vingt deuxième";
    $jourli[23] =  "vingt troisième";
    $jourli[24] =  "vingt quatrième";
    $jourli[25] =  "vingt cinquième";
    $jourli[26] =  "vingt sixième";
    $jourli[27] =  "vingt septième";
    $jourli[28] =  "vingt huitième";
    $jourli[29] =  "vingt neuvième";
    $jourli[30] =  "trentième";
    $jourli[31] =  "le trente-et-unième"; 

    $anneeli[1990]="Mille-neuf-cent-quatre-vingt-dix";
    $anneeli[1991]="Mille-neuf-cent-quatre-vingt-onze";
    $anneeli[1992]="Mille-neuf-cent-quatre-vingt-douze";
    $anneeli[1993]="Mille-neuf-cent-quatre-vingt-treize";
    $anneeli[1994]="Mille-neuf-cent-quatre-vingt-quatorze";
    $anneeli[1995]="Mille-neuf-cent-quatre-vingt-quinze";
    $anneeli[1996]="Mille-neuf-cent-quatre-vingt-seize";
    $anneeli[1997]="Mille-neuf-cent-quatre-vingt-dix-sept";
    $anneeli[1998]="Mille-neuf-cent-quatre-vingt-dix-huit";
    $anneeli[1999]="Mille-neuf-cent-quatre-vingt-dix-neuf";     
//2000
    $anneeli[2000]="Deux-mille";
    $anneeli[2001]="Deux-mille-un";
    $anneeli[2002]="Deux-mille-deux";
    $anneeli[2003]="Deux-mille-trois";
    $anneeli[2004]="Deux-mille-quatre";
    $anneeli[2005]="Deux-mille-cinq";
    $anneeli[2006]="Deux-mille-six";
    $anneeli[2007]="Deux-mille-sept";
    $anneeli[2008]="Deux-mille-huit";
    $anneeli[2009]="Deux-mille-neuf";

    $anneeli[2010]="Deux-mille-dix";
    $anneeli[2011]="Deux-mille-onze";
    $anneeli[2012]="Deux-mille-douze";
    $anneeli[2013]="Deux-mille-treize";
    $anneeli[2014]="Deux-mille-quatorze";
    $anneeli[2015]="Deux-mille-quinze";
    $anneeli[2016]="Deux-mille-seize";
    $anneeli[2017]="Deux-mille-dix-sept";
    $anneeli[2018]="Deux-mille-dix-huit";
    $anneeli[2019]="Deux-mille-dix-neuf";

    $anneeli[2020] =  "deux mille vingt";
    $anneeli[2021] =  "deux mille vingt-un";
    $anneeli[2022] =  "deux mille vingt deux ";
    $anneeli[2023] =  "deux mille vingt trois ";
    $anneeli[2024] =  "deux mille vingt quatre ";
    $anneeli[2025] =  "deux mille vingt cinq ";
    $anneeli[2026] =  "deux mille vingt six ";
    $anneeli[2027] =  "deux mille vingt sept ";
    $anneeli[2028] =  "deux mille vingt huit ";
    $anneeli[2029] =  "deux mille vingt neuf ";
    $anneeli[2030] =  "deux mille trente";
    $anneeli[2031] =  "deux mille trente-un";
    $anneeli[2032] =  "deux mille trente deux";
    $anneeli[2033] =  "deux mille trente trois";
    $anneeli[2034] =  "deux mille trente quatre";
    $anneeli[2035] =  "deux mille trente cinq ";
    $anneeli[2036] =  "deux mille trente six";
    $anneeli[2037] =  "deux mille trente sept";
    $anneeli[2038] =  "deux mille trente huit";
    $anneeli[2039] =  "deux mille trente neuf";
    $anneeli[2040] =  "deux mille quarante";
    $anneeli[2041] =  "deux mille quarante un";
    $anneeli[2042] =  "deux mille quarante deux";
    $anneeli[2043] =  "deux mille quarante trois";
    $anneeli[2044] =  "deux mille quarante quatre";
    $anneeli[2045] =  "deux mille quarante cinq";
    $anneeli[2046] =  "deux mille quarante six";
    $anneeli[2047] =  "deux mille quarante sept";
    $anneeli[2048] =  "deux mille quarante huit";
    $anneeli[2049] =  "deux mille quarante neuf ";
    $anneeli[2050] =  "deux mille cinquante";
  
    $anneeli[2051] =  "deux mille cinquante un";
    $anneeli[2052] =  "deux mille cinquante deux";
    $anneeli[2053] =  "deux mille cinquante trois";
    $anneeli[2054] =  "deux mille cinquante quatre";
    $anneeli[2055] =  "deux mille cinquante cinq";
    $anneeli[2056] =  "deux mille cinquante six";
    $anneeli[2057] =  "deux mille cinquante sept";
    $anneeli[2058] =  "deux mille cinquante huit";
    $anneeli[2059] =  "deux mille cinquante neuf ";

    $anneeli[2060] =  "deux mille soixante";
    $anneeli[2061] =  "deux mille soixante un";
    $anneeli[2062] =  "deux mille soixante deux";
    $anneeli[2063] =  "deux mille soixante trois";
    $anneeli[2064] =  "deux mille soixante quatre";
    $anneeli[2065] =  "deux mille soixante cinq";
    $anneeli[2066] =  "deux mille soixante six";
    $anneeli[2067] =  "deux mille soixante sept";
    $anneeli[2068] =  "deux mille soixante huit";
    $anneeli[2069] =  "deux mille soixante neuf ";

    $anneeli[2070] =  "deux mille soixante-dix";
    $anneeli[2071] =  "deux mille soixante-dix un";
    $anneeli[2072] =  "deux mille soixante-dix deux";
    $anneeli[2073] =  "deux mille soixante-dix trois";
    $anneeli[2074] =  "deux mille soixante-dix quatre";
    $anneeli[2075] =  "deux mille soixante-dix cinq";
    $anneeli[2076] =  "deux mille soixante-dix six";
    $anneeli[2077] =  "deux mille soixante-dix sept";
    $anneeli[2078] =  "deux mille soixante-dix huit";
    $anneeli[2079] =  "deux mille soixante-dix neuf ";

    $anneeli[2080] =  "deux mille quatre-vingt";
    $anneeli[2081] =  "deux mille quatre-vingt un";
    $anneeli[2082] =  "deux mille quatre-vingt deux";
    $anneeli[2083] =  "deux mille quatre-vingt trois";
    $anneeli[2084] =  "deux mille quatre-vingt quatre";
    $anneeli[2085] =  "deux mille quatre-vingt cinq";
    $anneeli[2086] =  "deux mille quatre-vingt six";
    $anneeli[2087] =  "deux mille quatre-vingt sept";
    $anneeli[2088] =  "deux mille quatre-vingt huit";
    $anneeli[2089] =  "deux mille quatre-vingt neuf ";
    $anneeli[2089] =  "deux mille quatre-vingt neuf ";

    $anneeli[2099] =  "deux mille quatre-vingt-dix";
    $anneeli[2091] =  "deux mille quatre-vingt-dix un";
    $anneeli[2092] =  "deux mille quatre-vingt-dix deux";
    $anneeli[2093] =  "deux mille quatre-vingt-dix trois";
    $anneeli[2094] =  "deux mille quatre-vingt-dix quatre";
    $anneeli[2095] =  "deux mille quatre-vingt-dix cinq";
    $anneeli[2096] =  "deux mille quatre-vingt-dix six";
    $anneeli[2097] =  "deux mille quatre-vingt-dix sept";
    $anneeli[2098] =  "deux mille quatre-vingt-dix huit";
    $anneeli[2099] =  "deux mille quatre-vingt-dix neuf ";
    $anneeli[20100] =  "deux mille cent ";

    if (substr($year, 0, 1)=="0") $year=substr($year, 1, 1);
    $years = $anneeli[$year];
    
     if (substr($mois, 0, 1)=="0") $mois=substr($mois, 1, 1);
    $manth = $moisli[$mois];

    if (substr($jour, 0, 1)=="0") $jour=substr($jour, 1, 1);
    $jours = $jourli[$jour];

 $str="";
if ($year=date('Y')) {
  # code...
   $str='L\'an '.$years.' le '.$jours.' jour du mois '.$manth;
}elseif ($mois=date('m')) {
  # code...
   $str=$mois;
}elseif ($jour=date('d')) {
  # code...
       $str= $jour;
}else{
  $str='L\'an '.$year.' le '.$jour.' jour du mois '.$mois;
}
    return $str;
   

    }

    //GENERATION DU NIF 
    public function generate_nif($user_id)
    {
      $id="";
      $commune="";
      $registeras="";
      $country_code="";
      $sexe="";
      $num_doc="";
      $type_document="";

      $info_user=$this->CI->Model->getRequeteOne("SELECT id,registeras,country_code,commune_id as commune,provence_id,cni,sexe_id,type_demandeur,type_document.type_document_id,type_document.code_type_document FROM sf_guard_user_profile join type_document on type_document.type_document_id=sf_guard_user_profile.type_document_id WHERE user_id=".$user_id);

        $id=$info_user['id'];
        $commune=$info_user['commune'];
        $provence=$info_user['provence_id'];
        $registeras=$info_user['registeras'];
        $country_code=$info_user['country_code'];
        $sexe=$info_user['sexe_id'];
        $num_doc=$info_user['cni'];
        $type_document=$info_user['code_type_document'];

      
      $strcommune="000";
      $nif="";

      //PERSONNE PHYSIQUE
      if($info_user['registeras']==1)
      {
        //Debut commune
        $strcommune="000";

        if($info_user['type_demandeur']==1)
        {
          if(!empty($info_user['commune']))
          {
            if($info_user['commune']<10)
            {
              $strcommune="00".$info_user['commune'];
            }

            if($info_user['commune']>9 && $info_user['commune']<100)
            {
              $strcommune="0".$commune;
            }

            if($info_user['commune']>99)
            {
              $strcommune="".$info_user['commune'];
            }
          }
        }
        else
        {
         $strcommune=999; 
        }
        //fin commune
        
        //recuperer le sexe 
        $sexe_id="";
        $num_docs="";
        $type_documents="";

        if($sexe==1)
        {
          $sexe_id="H";
        }

        if($sexe==2)
        {
          $sexe_id="F";
        }


        $num_docs="".$num_doc;
        $type_documents=$type_document;

        $nif=$strcommune."-".$type_documents."-".$sexe_id."-".$num_docs;

        $this->CI->Model->update('sf_guard_user_profile',array('id'=>$info_user['id']),array('nif'=>$nif));


        return $nif.'_'.$provence;
      }
    }

    //POUR CREER LE NIF D'UNE PERSONNE INSCRITE ET AU FINAL SAUVEGARDER SES FICHIERS
    public function create_folder_nif($user_id)
    {
      // echo " ".$this->generate_nif($user_id);
      $nif=$this->generate_nif($user_id);

      $nif=explode('_',$nif);

      $provence=$nif[1];
      $nif_recuperer=$nif[0];

      // $avoid_slashes=$numeroparcelle;   
      $avoid_slashes=str_replace('"',"-",$nif_recuperer);
      $avoid_slashes=str_replace('/',"-",$nif_recuperer);
      $avoid_slashes=str_replace("'","-",$nif_recuperer);
      $avoid_slashes=str_replace("*","-",$nif_recuperer);
      $avoid_slashes=str_replace('<','-',$nif_recuperer);
      $avoid_slashes=str_replace('>','-',$nif_recuperer);
      $avoid_slashes=str_replace('|','-',$nif_recuperer);
      $avoid_slashes=str_replace(':','-',$nif_recuperer);
      $avoid_slashes=str_replace('?','-',$nif_recuperer);

      // echo " ".$provence;

      $info_user=$this->CI->Model->getRequeteOne("SELECT fullname,nif FROM sf_guard_user_profile WHERE user_id=".$user_id);

      $result=$this->CI->Model->getOne('edrms_repertoire_province_processus',array('province_id'=>$provence));

      $ticket=$this->CI->alfresco_lib->login();
      // echo " ".$ticket;

      $data=array('name'=>$avoid_slashes,
                  'title'=>$info_user['fullname'],
                  'description'=>'');

      $storage=$result['token_province_inscription'];

      $data_nif=$this->CI->alfresco_lib->create_folder($ticket,$data,$storage);

      $data_nif=$data_nif->nodeRef;

      $data_nif = explode("SpacesStore/", $data_nif);


       $id_inscription=$this->CI->Model->insert_last_id('edrms_repertoire_inscription',array('province_id'=>$provence,'nom_repertoire_inscription'=>$avoid_slashes,'token_repertoire_inscription'=>$data_nif[1],'nif'=>$info_user['nif']));


         return $id_inscription;
    }

    //POUR ENREGISTRER LE FICHIER DANS ALFRESCO ET ENSUITE DANS LA TABLE EDRMS_FILE_INSCR 
    public function save_edrmsFile($id,$file_name='')
    {
      $token_inscription=$this->CI->Model->getOne('edrms_repertoire_inscription',array('id'=>$id));

      $fileName =$file_name;
      $fileSrc =  "https://pms.mediabox.bi/uploads/requerant/".$file_name;
      $deScription =$file_name;
      $numero =  "72222075";
      $folders =  "workspace://SpacesStore/".$token_inscription['token_repertoire_inscription']; 

      $dataFile = array('fileName' => $fileName, 'fileSrc' => $fileSrc , 'deScription' => $deScription  , 'numero' => $numero ,'folders' => $folders);

      // $fileName =  "LETTRE_DESIGNATION632d789e553ac66.pdf";
      // $fileSrc =  "https://pms.mediabox.bi/uploads/doc_generer/LETTRE_DESIGNATION632d789e553ac66.pdf";
      // $deScription =  "contrant du parcelle numero 20";
      // $numero =  "72222075";
      // $folders =  "workspace://SpacesStore/".$token_inscription['token_repertoire_inscription']; 
     
      // $dataFile = array('fileName' => $fileName, 'fileSrc' => $fileSrc , 'deScription' => $deScription  , 'numero' => $numero ,'folders' => $folders);



      if (!empty($dataFile)) {

         $url = "https://app.mediabox.bi/auto_rapport/Api_Edrms/sendFile_request";

        if(is_array($dataFile)){ $dataFile = json_encode($dataFile);}
        $options = stream_context_create(['http' => [
          'method'  => 'POST',
          'header'  => 'Content-type: application/json',
          'content' => $dataFile
        ]]);

        $response = file_get_contents($url,false,$options);

        $out =  json_decode($response);

        $data_token=$out->idFiles;

        $data_token_recuperer = explode("SpacesStore/", $data_token);

        $result=$this->CI->Model->create('edrms_file_inscription',array('nif'=>$token_inscription['nif'],'nom_file'=>$file_name,'desc_file'=>$file_name,'token_file'=>$data_token_recuperer[1],'status_envoye'=>0));

        return $result; 
      }
    } 



    public function getDocument($parcelle)
    {
      $parcelle_id=$this->Model->getOne('parcelle_attribution',array('NUMERO_PARCELLE'=>$parcelle));

      return $parcelle_id;
    }

  //Fonction pour la generation des folios et volume

    function generate_Volume_folio()
    {

      $val_volume=$this->CI->Model->getRequeteOne('SELECT max(ID_VOLUME) as volume from pms_volume where 1');


      $crit=' and ID_VOLUME IS NOT NULL';

      $D=0;
      
      if($val_volume['volume']!=NULL)
      {
        $crit=' and ID_VOLUME='.$val_volume["volume"].'';
      }

      $val_folio=$this->CI->Model->getRequeteOne('SELECT max(VALEUR_FOLIO) as nb_folio_from_one  from pms_folio where 1 '.$crit.'');

      $folio=1;
      $volume=$this->arabicToRoman(1);

      $val_test=0;

      if($val_folio['nb_folio_from_one']!=NULL)
      {
        $val_test=$val_folio['nb_folio_from_one'];
      }



      if ($val_test==200 || $val_test==0)
      {

        $valeur_romain=$this->arabicToRoman($val_volume["volume"]+1);



        $array_volume=array('VALEUR_ROMAIN'=>$valeur_romain);


        $val_new_volume=$this->CI->Model->insert_last_id('pms_volume',$array_volume);
        $volume=$this->arabicToRoman($val_new_volume);

        $array_folio=array('ID_VOLUME'=>$val_new_volume,'VALEUR_FOLIO'=>$folio);


        $val_new_folio=$this->CI->Model->insert_last_id('pms_folio',$array_folio);

        $D=$val_new_folio;
      }
      else
      {


        $folio=$val_test+1;

        $array_folio=array('ID_VOLUME'=>$val_volume["volume"],'VALEUR_FOLIO'=>$folio);

        $val_new_folio=$this->CI->Model->insert_last_id('pms_folio',$array_folio);
        $D=$val_new_folio;



      }


      $data['folio']=$folio;
      $data['volume']=$volume;
      $data['D']=$D;

      return $data;

    }

  function arabicToRoman($num=102) {
    $roman = "";
    $map = array(
      'M'  => 1000,
      'CM' => 900,
      'D'  => 500,
      'CD' => 400,
      'C'  => 100,
      'XC' => 90,
      'L'  => 50,
      'XL' => 40,
      'X'  => 10,
      'IX' => 9,
      'V'  => 5,
      'IV' => 4,
      'I'  => 1
    );
    while ($num > 0) {
      foreach ($map as $romanNumeral => $arabicNumeral) {
        if ($num >= $arabicNumeral) {
          $roman .= $romanNumeral;
          $num -= $arabicNumeral;
          break;
        }
      }
    }
    return $roman;
  }

}
?>
