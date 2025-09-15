<?php 
/**
* @author Nadvaxe2024
* created on the 29th april 2024
* DEMANDE DES AUDIENCES
* advaxe@mediabox.bi
*/
class Rendez_vous extends CI_Controller
{

        function __construct()
        {
          # code...
          parent::__construct();
          require('fpdf184/fpdf.php');
        }

        //Fonction principale
        function index()
        {
                $data['types_demandeur']=$this->Model->getRequete('SELECT `PROCESS_ID`, `DESCRIPTION_PROCESS` FROM `pms_process` WHERE  IS_ACTIVE=1 and PROCESS_ID not in (19)');
                $data['types_visiteur']=$this->Model->getRequete('SELECT `ID_TYPE_VISITE`, `DESC_TYPE_VISITE` FROM `pms_type_demandeur_visite` WHERE TYPE_INITIATION_DEMANDE!=1');
                $data['professions']=$this->Model->getRequete('SELECT `ID_PROFESSION`, `DESCR_PROFESSION` FROM `profession` WHERE 1');
                $data['genre']=$this->Model->getRequete('SELECT `GENRE_ID`, `GENRE` FROM `genre` WHERE 1');
                $data['cathegories']=$this->Model->getRequete('SELECT `id`, `name`, `description`FROM `sf_guard_user_categories` WHERE 1 AND id IN(1,5)');
                $data['info_physique']="style='display:block;'";
                $data['info_morale']="style='display:none;'";
                $data['info_titre']="style='display:none;'";
                $data['choix'] = 0;
                $this->load->view('Rendez_vous_view',$data);
        }

        function changeDate()
         {    
          $SAMEDI = '2024-08-04';
          $LUNDI = '2024-07-12';
          $formattedDate = date("Y-m-d", strtotime($SAMEDI));
          $formattedLundi = date("Y-m-d", strtotime($LUNDI));

          $data = $this->Model->getRequete('SELECT ID_TRAITEMENT_AUDIENCE, JOUR_AUDIENCE FROM pms_traitement_audience WHERE JOUR_AUDIENCE > "'.$formattedDate.'" LIMIT 1');

         $start_time = '9:20';
        $time_increment = 10; // in minutes

        foreach ($data as $key => $value) {
          $id_update = $value['ID_TRAITEMENT_AUDIENCE'];

            // Convert the start time to a DateTime object
          $start_time_obj = DateTime::createFromFormat('H:i', $start_time);

            // Add the time increment to the start time, but only for subsequent rows
          if ($key > 0) {
            $start_time_obj->modify('+' . ($key * $time_increment) . ' minutes');
          }

            // Format the updated time back to a string
          $updated_time = $start_time_obj->format('H:i');

          $array_toUpdate = array(
            'JOUR_AUDIENCE' => $formattedLundi,
            'HEURE_AUDIENCE' => $updated_time,
            'STATUT_MAIL' => 1
          );

           $updating = $this->Model->update('pms_traitement_audience', array('ID_TRAITEMENT_AUDIENCE' => $id_update), $array_toUpdate);
              $req = $this->Model->getRequeteOne('SELECT pms_demandeur_audience.NOM_PRENOM,pms_traitement_audience.ID_TRAITEMENT_AUDIENCE,pms_demandeur_audience.RAISON_SOCIALE,pms_demandeur_audience.CATHEGORIE_DEMANDEUR,pms_traitement_audience.JOUR_AUDIENCE,pms_traitement_audience.HEURE_AUDIENCE, pms_demandeur_audience.EMAIL FROM pms_demandeur_audience JOIN pms_traitement_audience ON pms_traitement_audience.ID_DEMANDEUR_AUDEINCE=pms_demandeur_audience.ID_DEMANDEUR_AUDIENCE WHERE pms_traitement_audience.ID_TRAITEMENT_AUDIENCE='.$id_update.'');
                if ($req['CATHEGORIE_DEMANDEUR']==5) 
                {
                  $nom=$req['RAISON_SOCIALE'];
                } 
                else 
                {
                  $nom=$req['NOM_PRENOM'];
                }
                $ID_TRAITEMENT_AUDIENCE=$req['ID_TRAITEMENT_AUDIENCE'];
              $subject = "Confirmation de votre demande de rendez-vous";
              $message = 'Monsieur/Madame <b>'.trim($nom).'</b>,<br><br>
              Votre rendez-vous a été programmé pour le '.date('d-m-Y', strtotime($req['JOUR_AUDIENCE'])).' à '.$req['HEURE_AUDIENCE'].'<br><br>
              Il vous est demandé de vous présenter physiquement aux bureaux du secrétariat de la Direction des Titres Foncier et du Cadastre National, en apportant vos documents en rapport avec votre demande.<br><br>
              Veuillez télécharger votre certificat de demande d’audience en cliquant sur le <a href="'.base_url('administration/Liste_Demande_Rdv/Document_Pdf/'.md5($ID_TRAITEMENT_AUDIENCE)).'">Document à télécharger</a>.<br><br>
              Cordialement.';
              $mailTo = $req['EMAIL'];
              $sending = $this->notifications->send_mail($mailTo, $subject, [], $message, []);
          }
         }

         //la fonction qui gere l'attribution des RDV et AUDIENCES
        
        function save_data()
        {
           $titre=$this->input->post('STATUS_TITRE');
           $cath=$this->input->post('CATHEGORIE');
           $objet=$this->input->post('OBJET');
           $this->form_validation->set_rules('CATHEGORIE', '', 'required',array("required"=>"<font color='red'>Ce champs est requis</font>"));
           $this->form_validation->set_rules('TEL2', '', 'required',array("required"=>"<font color='red'>Ce champs est requis</font>"));
           $this->form_validation->set_rules('EMAIL','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
           //CATH 1 signifie personne physique else veut dire personne morale
           if ($cath==1) 
           {
              $this->form_validation->set_rules('NOM', '', 'required',array("required"=>"<font color='red'>Ce champs est requis</font>"));
              $this->form_validation->set_rules('PERE','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
              $this->form_validation->set_rules('MERE','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
              $this->form_validation->set_rules('CNI','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
              $this->form_validation->set_rules('GENRE','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
           }else
           {
              $this->form_validation->set_rules('ENTREPRISE','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
              $this->form_validation->set_rules('RC','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
              $this->form_validation->set_rules('REPRESENTANT','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
           }
           $this->form_validation->set_rules('STATUS_TITRE','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
           $this->form_validation->set_rules('OBJET','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
           //titre ==1 signifie que la personne possede un titre de propriete
           if ($titre==1) 
           {
              $this->form_validation->set_rules('VOLUME','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
              $this->form_validation->set_rules('FOLIO','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
              $this->form_validation->set_rules('PARCELLE','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
           }

           //la gestion des retours si des donnees ne sont pas valides
        
           if ($this->form_validation->run() == FALSE)
           {  
               $data['types_demandeur']=$this->Model->getRequete('SELECT `PROCESS_ID`, `DESCRIPTION_PROCESS` FROM `pms_process` WHERE  IS_ACTIVE=1 and PROCESS_ID not in (19)');
              $data['types_visiteur']=$this->Model->getRequete('SELECT `ID_TYPE_VISITE`, `DESC_TYPE_VISITE` FROM `pms_type_demandeur_visite` WHERE TYPE_INITIATION_DEMANDE!=1');
              $data['professions']=$this->Model->getRequete('SELECT `ID_PROFESSION`, `DESCR_PROFESSION` FROM `profession` WHERE 1');
              $data['cathegories']=$this->Model->getRequete('SELECT `id`, `name`, `description`FROM `sf_guard_user_categories` WHERE 1 AND id IN(1,5)');
              $data['genre']=$this->Model->getRequete('SELECT `GENRE_ID`, `GENRE` FROM `genre` WHERE 1');

              if ($cath==1) 
              {
                 $data['info_physique']="style='display:block;'";
                 $data['info_morale']="style='display:none;'";
              }
              else if ($cath==5) 
              {
                $data['info_physique']="style='display:none;'";
                $data['info_morale']="style='display:block;'";
              }
              else
              {
                $data['info_physique']="style='display:block;'";
                $data['info_morale']="style='display:none;'";
              }

              if ($titre==1) 
              {
                $data['info_titre']="style='display:block;'";
              }
              else
              {
                $data['info_titre']="style='display:none;'";
              }
              $data['choix'] = $titre;
              $this->load->view('Rendez_vous_view',$data);
           }
           else
           {
             if ($objet != 0) 
             {   
               $TYPE_INITIATION_DEMANDE=2;
             }
             else 
             {
               $TYPE_INITIATION_DEMANDE=1;
             }
               
             $DOC_PDF_TITRE= $this->upload_file_titre('PDF');

             if ($DOC_PDF_TITRE != '') 
             {
               $DOC_PDF_TITRE=$DOC_PDF_TITRE;
             } 
             else 
             {
               $DOC_PDF_TITRE = null;
             }
                  
             //datas sont des données relatives au demandeur et sont inserées dans la table pms_demandeur_audience
             $datas=array(
               'ID_FONCTION'=>$this->input->post('ID_PROFESSION'),
               'CATHEGORIE_DEMANDEUR'=>$this->input->post('CATHEGORIE'),
               'NOM_PRENOM'=>$this->input->post('NOM'),
               'SEXE_ID'=>$this->input->post('GENRE'),
               'PERE_NOMCOMPLET'=>$this->input->post('PERE'),
               'MERE_NOMCOMPLET'=>$this->input->post('MERE'),
               'RAISON_SOCIALE'=>$this->input->post('ENTREPRISE'),
               'RC'=>$this->input->post('RC'),
               'MOTIF_URGENCE'=>$this->input->post('MOTIF_AUDIENCE'),
               'NOM_REPRESENTANT'=>$this->input->post('REPRESENTANT'),
               'TELEPHONE'=>$this->input->post('TEL2'),
               'EMAIL'=>$this->input->post('EMAIL'),
               'NUM_CNI'=>$this->input->post('CNI'),
               'ID_TYPE_DEMANDEUR_AUDIENCE'=>$this->input->post('TYPE_DEMANDEUR'),
               'ID_OBJET_VISITE'=>$this->input->post('OBJET'),
               'DISPOSITION_TITRE'=>$this->input->post('STATUS_TITRE'),
               'VOLUME'=>$this->input->post('VOLUME'),
               'FOLIO'=>$this->input->post('FOLIO'),
               'NUMERO_PARCELLE'=>$this->input->post('PARCELLE'),
               'TYPE_INITIATION_DEMANDE'=>$TYPE_INITIATION_DEMANDE,
               'DOC_PDF_TITRE'=>$DOC_PDF_TITRE
             );
              //for ($i=0; $i < 1500 ; $i++) {                   
             $insertion=$this->Model->insert_last_id('pms_demandeur_audience',$datas);  

                //objet egal 0 est pris pour audiences         
               if($objet == 0) 
               {
                   //calcul des jours des audiences et fixation des heures de rendez-vous
                   $today = date('Y-m-d');
                   $dateTime = new DateTime($today);
                   $dayOfWeek = $dateTime->format('N');
                   // Si aujourd'hui est un mardi, ajouter 7 jours pour obtenir le prochain mardi
                   if ($dayOfWeek == 2) 
                   {
                     $daysUntilTuesday = 7;
                   } 
                   else 
                   {
                     $daysUntilTuesday = (9 - $dayOfWeek) % 7;
                   }
                   // Ajouter le nombre de jours pour obtenir le prochain mardi
                   $nextTuesday = $dateTime->modify('+' . $daysUntilTuesday . ' day');
                   $to_tuesday = $nextTuesday->format('Y-m-d');

                   //advaxe1
                   //cette requete nous retourne le dernier rendez vous superieur à aujiourd'hui
                    $lastDate = $this->Model->getRequeteOne('SELECT MAX(JOUR_AUDIENCE) JOUR_AUDIENCE,ID_TRAITEMENT_AUDIENCE,STATUT_SCANNER,pms_traitement_audience.HEURE_AUDIENCE FROM pms_traitement_audience JOIN pms_demandeur_audience ON pms_demandeur_audience.ID_DEMANDEUR_AUDIENCE=pms_traitement_audience.ID_DEMANDEUR_AUDEINCE WHERE pms_demandeur_audience.ID_OBJET_VISITE=0 AND JOUR_AUDIENCE="'.$to_tuesday.'" AND pms_traitement_audience.STATUT_SCANNER=0 GROUP BY ID_TRAITEMENT_AUDIENCE,STATUT_SCANNER ORDER BY ID_TRAITEMENT_AUDIENCE DESC LIMIT 1');
                  $max=$lastDate['JOUR_AUDIENCE'];

                  //la condition est là pour attribuer l'audience au prochain mardi ($to_tuesday) si c'est pas deja pris

                  if (!empty($max)) 
                  {
                      $dateCible=$lastDate['JOUR_AUDIENCE'];
                      $LastHour=$lastDate['HEURE_AUDIENCE'];
                  }
                  else
                  {
                    $dateCible = $to_tuesday;
                    $LastHour='08:00'; 
                  }

                   //jusqu'ici le jour est deja obtenu ($dateCible) on procede a la recherche de l'heure exacte.
                    // Convertir l'heure en objet DateTime
                    $lastHourDateTime = DateTime::createFromFormat('H:i', $LastHour);
                    $dateCibleDateTime = DateTime::createFromFormat('Y-m-d', $dateCible);
                    // Vérifier si l'heure est avant 15h30
                   if((new DateTime($dateCible))->format('N')==5){
                    $heure_cl= '13:20';
                    $minpre=90;    
                    } else{
                     $heure_cl= '15:00';
                     $minpre=150; 
                    }
                    if ($lastHourDateTime->format('H:i') < '15:30') 
                    {

                          if( $lastHourDateTime->format('H:i') >= ''.$heure_cl.'' && $lastHourDateTime->format('H:i') < '12:00')
                          {
                          $nextHourDateTime = clone $lastHourDateTime;
                          $nextHourDateTime->modify('+'.$heure_cl.' minutes');
                          }
                          else
                          {
                           // Ajouter 10 minutes et incrementer
                            $nextHourDateTime = clone $lastHourDateTime;
                            $nextHourDateTime->modify('+3 minutes');
                          }
                    } 
                    else  
                    {
                        // Ajouter 7 jours (prochain $to_tuesday) et fixer l'heure à 8h00 si on est deja arrivé à 15h30
                      $nextHourDateTime = clone $lastHourDateTime;
                      $dateCibleDateTime = clone $nextHourDateTime;
                      $dateCibleDateTime->modify('+7 day');

                      $DateFermee = $this->Model->getRequete('SELECT DATE_CONGE FROM `pms_date_fermees` WHERE  STATUS=1');
                      $DateFermeeListe = array_column($DateFermee, 'DATE_CONGE');
                      if (in_array($dateCibleDateTime->format('Y-m-d'), $DateFermeeListe)) 
                            {
                              $dateCibleDateTime->modify('+7 day');
                            } 
                      $nextHourDateTime->setTime(8, 0);
                      $dateCible = $dateCibleDateTime->format('Y-m-d');
                    }

                    // Formater la nouvelle heure en chaîne de caractères
                    //le jour reste $dateCible et le last_id est $insertion
                    $nextHour = $nextHourDateTime->format('H:i');
                    $array_tosave = array(
                                'ID_DEMANDEUR_AUDEINCE' => $insertion,
                                'JOUR_AUDIENCE' => $dateCible,
                                'STATUT_MAIL' => 1,
                                'STATUT_SCANNER' => 0,
                                'HEURE_AUDIENCE' => $nextHour
                               );
                    $rendezvous = $this->Model->insert_last_id('pms_traitement_audience', $array_tosave);  
               }
               //Transfert de titre de propriété[20 minutes]
              else if ($objet == 19)  
              {
                    //la reference est today du demandeur
                    $today = date('Y-m-d');
                    $dateTime = new DateTime($today);
                    $dateCible = $dateTime->modify('+1 day')->format('Y-m-d');
                    //ici on veut retourner le joyur max si ca existe apres today
                    $lastDate = $this->Model->getRequeteOne('SELECT MAX(JOUR_AUDIENCE) JOUR_AUDIENCE,ID_TRAITEMENT_AUDIENCE,STATUT_SCANNER,pms_traitement_audience.HEURE_AUDIENCE FROM pms_traitement_audience JOIN pms_demandeur_audience ON pms_demandeur_audience.ID_DEMANDEUR_AUDIENCE=pms_traitement_audience.ID_DEMANDEUR_AUDEINCE WHERE pms_demandeur_audience.ID_OBJET_VISITE=19 AND JOUR_AUDIENCE>"'.$today.'" AND pms_traitement_audience.STATUT_SCANNER=0 GROUP BY ID_TRAITEMENT_AUDIENCE,STATUT_SCANNER ORDER BY ID_TRAITEMENT_AUDIENCE DESC LIMIT 1');
                  $max=$lastDate['JOUR_AUDIENCE'];

                  //si trouvé, on va commencer ce jour sinon on donne today + 1
                  if (!empty($max)) 
                  {
                      $dateCible=$lastDate['JOUR_AUDIENCE'];
                      $LastHour=$lastDate['HEURE_AUDIENCE'];
                  }
                  else
                  {
                    $today = date('Y-m-d');
                    $dateTime = new DateTime($today);
                    $dateCible = $dateTime->modify('+1 day')->format('Y-m-d');
                    $dayOfWeek = (new DateTime($dateCible))->format('N');

                    //si today est vendredi, on risque de donner le weekend (today+1=dayofWeek)
                    if ($dayOfWeek == 6) 
                      { // samedi
                        $dateCible = (new DateTime($dateCible))->modify('+2 day')->format('Y-m-d'); // Lundi
                      }  
                      elseif ($dayOfWeek == 7) 
                      { 
                         // dimanche
                        $dateCible = (new DateTime($dateCible))->modify('+1 day')->format('Y-m-d'); // Lundi
                      } 
                      else
                      {
                        $dateCible = $dateCible; // jour +1 
                      }
                      $LastHour='08:00'; 
                  }
                    // Convertir l'heure en objet DateTime
                    $lastHourDateTime = DateTime::createFromFormat('H:i', $LastHour);
                    $dateCibleDateTime = DateTime::createFromFormat('Y-m-d', $dateCible);
                    // print_r($dateCibleDateTime);die();
                    // Vérifier si l'heure est avant 15h30
                   if((new DateTime($dateCible))->format('N')==5){
                    $heure_cl= '13:20';
                    $minpre=90;    
                    } else{
                     $heure_cl= '15:00';
                     $minpre=150; 
                    }

                    if ($lastHourDateTime->format('H:i') < ''.$heure_cl.'') 
                    {
                     


                        if( $lastHourDateTime->format('h:i') >= '11:55' && $lastHourDateTime->format('h:i') < '12:00')
                          {

                          $nextHourDateTime = clone $lastHourDateTime;
                          $nextHourDateTime->modify('+150 minutes');
                          }
                          else
                          {// Ajouter 20 minutes
                            $nextHourDateTime = clone $lastHourDateTime;
                            $nextHourDateTime->modify('+'.$minpre.' minutes');
                          }
                    } 
                    else  
                    {
                        // Ajouter 1 jour et fixer l'heure à 8h00
                      $nextHourDateTime = clone $lastHourDateTime;
                      $dateCibleDateTime = clone $nextHourDateTime;
                      $dateCibleDateTime->modify('+1 day');

                      $DateFermee = $this->Model->getRequete('SELECT DATE_CONGE FROM `pms_date_fermees` WHERE  STATUS=1');
                      $DateFermeeListe = array_column($DateFermee, 'DATE_CONGE');

                          // Éviter les week-ends et les jours fériés
                       while (true) 
                      {
                             $dayOfWeek = $dateCibleDateTime->format('N');
                             if ($dayOfWeek == 6) 
                            { // samedi
                              $dateCibleDateTime->modify('+2 day'); // Lundi
                            } 
                            elseif ($dayOfWeek == 7) 
                            { // dimanche
                              $dateCibleDateTime->modify('+1 day'); // Lundi
                            }
                             elseif (in_array($dateCibleDateTime->format('Y-m-d'), $DateFermeeListe)) 
                            {
                              $dateCibleDateTime->modify('+1 day');
                            } 
                            else 
                            {
                              break;
                            }
                      }

                      // Si le congé etait vendredi, on passe au lundi suivant
                      $dayOfWeek = $dateCibleDateTime->format('N');
                      if ($dayOfWeek == 6) 
                      {
                        $dateCibleDateTime->modify('+2 day');
                      }
                      $nextHourDateTime->setTime(8, 0);
                      $dateCible = $dateCibleDateTime->format('Y-m-d');
                    }

                    // Formater la nouvelle heure en chaîne de caractères
                    $nextHour = $nextHourDateTime->format('H:i');
                      // print_r($nextHour);die(); 
                        $array_tosave = array(
                                'ID_DEMANDEUR_AUDEINCE' => $insertion,
                                'JOUR_AUDIENCE' => $dateCible,
                                'STATUT_MAIL' => 1,
                                'STATUT_SCANNER' => 0,
                                'HEURE_AUDIENCE' => $nextHour
                               );
                    $rendezvous = $this->Model->insert_last_id('pms_traitement_audience', $array_tosave);   
              }
               //Enregistrement [20 minutes]
               else if ($objet == 30 )  
               {
                     $today = date('Y-m-d');
                    $dateTime = new DateTime($today);
                    $dateCible = $dateTime->modify('+1 day')->format('Y-m-d');
                     $lastDate = $this->Model->getRequeteOne('SELECT MAX(JOUR_AUDIENCE) JOUR_AUDIENCE,ID_TRAITEMENT_AUDIENCE,STATUT_SCANNER,pms_traitement_audience.HEURE_AUDIENCE FROM pms_traitement_audience JOIN pms_demandeur_audience ON pms_demandeur_audience.ID_DEMANDEUR_AUDIENCE=pms_traitement_audience.ID_DEMANDEUR_AUDEINCE WHERE pms_demandeur_audience.ID_OBJET_VISITE=30 AND JOUR_AUDIENCE>"'.$today.'" AND pms_traitement_audience.STATUT_SCANNER=0 GROUP BY ID_TRAITEMENT_AUDIENCE,STATUT_SCANNER ORDER BY ID_TRAITEMENT_AUDIENCE DESC LIMIT 1');

                    $max='';
                    if ($lastDate) {
                    $max=$lastDate['JOUR_AUDIENCE'];
                     }

                if (!empty($max)) 
                {
                    $dateCible=$lastDate['JOUR_AUDIENCE'];
                    $LastHour=$lastDate['HEURE_AUDIENCE'];
                }
                else
                  {
                    $today = date('Y-m-d');
                    $dateTime = new DateTime($today);
                    $dateCible = $dateTime->modify('+1 day')->format('Y-m-d');
                    $dayOfWeek = (new DateTime($dateCible))->format('N');
                    if ($dayOfWeek == 6) 
                      { // samedi
                        $dateCible = (new DateTime($dateCible))->modify('+2 day')->format('Y-m-d'); // Lundi
                      }  
                      elseif ($dayOfWeek == 7) 
                      { // dimanche
                        $dateCible = (new DateTime($dateCible))->modify('+1 day')->format('Y-m-d'); // Lundi
                      } 
                      else
                      {
                        $dateCible = $dateCible; // jour +1 
                      }
                      $LastHour='08:00'; 
                  }

                  // Convertir l'heure en objet DateTime
                  $lastHourDateTime = DateTime::createFromFormat('H:i', $LastHour);
                  $dateCibleDateTime = DateTime::createFromFormat('Y-m-d', $dateCible);
                  // Vérifier si l'heure est avant 15h30

                 if((new DateTime($dateCible))->format('N')==5){
                    $heure_cl= '13:20';
                    $minpre=90;    
                    } else{
                     $heure_cl= '15:00';
                     $minpre=150; 
                    }
                  if ($lastHourDateTime->format('H:i') < ''.$heure_cl.'') 
                  {
                       if( $lastHourDateTime->format('h:i') >= '11:55' && $lastHourDateTime->format('h:i') < '12:00')
                        {
                        $nextHourDateTime = clone $lastHourDateTime;
                        $nextHourDateTime->modify('+'.$minpre.' minutes');
                        }
                        else
                        {// Ajouter 30 minutes
                          $nextHourDateTime = clone $lastHourDateTime;
                          $nextHourDateTime->modify('+5 minutes');
                        }
                  } 
                  else  
                  {

                        // Ajouter 1 jour et fixer l'heure à 8h00
                      $nextHourDateTime = clone $lastHourDateTime;
                      $dateCibleDateTime = clone $dateCibleDateTime;
                      $dateCibleDateTime->modify('+1 day');
                      $DateFermee = $this->Model->getRequete('SELECT DATE_CONGE FROM `pms_date_fermees` WHERE  STATUS=1');
                      $DateFermeeListe = array_column($DateFermee, 'DATE_CONGE');
                          // Éviter les week-ends et les jours fériés
                       while (true) 
                      {
                             $dayOfWeek = $dateCibleDateTime->format('N');
                             if ($dayOfWeek == 6) 
                            { // samedi
                              $dateCibleDateTime->modify('+2 day'); // Lundi
                            } 
                            elseif ($dayOfWeek == 7) 
                            { // dimanche
                              $dateCibleDateTime->modify('+1 day'); // Lundi
                            }
                             elseif (in_array($dateCibleDateTime->format('Y-m-d'), $DateFermeeListe)) 
                            {
                              $dateCibleDateTime->modify('+1 day');
                            } 
                            else 
                            {
                              break;
                            }
                      }
                      // Si le congé etait vendredi, on passe au lundi suivant
                      $dayOfWeek = $dateCibleDateTime->format('N');
                      if ($dayOfWeek == 6) 
                      {
                        $dateCibleDateTime->modify('+2 day');
                      }
                      
                      $nextHourDateTime->setTime(8, 0);
                      $dateCible = $dateCibleDateTime->format('Y-m-d');
                        // print_r($dateCible);die();
                  }
                  // Formater la nouvelle heure en chaîne de caractères
                  $nextHour = $nextHourDateTime->format('H:i');
                    // print_r($nextHour);die(); 

                      $array_tosave = array(
                              'ID_DEMANDEUR_AUDEINCE' => $insertion,
                              'JOUR_AUDIENCE' => $dateCible,
                              'STATUT_MAIL' => 1,
                              'STATUT_SCANNER' => 0,
                              'HEURE_AUDIENCE' => $nextHour
                             );
                         // print_r($array_tosave);die();
                 $rendezvous = $this->Model->insert_last_id('pms_traitement_audience', $array_tosave);   
               }
               //Attestations DE POSSESSION [5 minutes]
               else if ($objet == 20)  
               {
                 $today = date('Y-m-d');
                 $dateTime = new DateTime($today);
                 $dateCible = $dateTime->modify('+1 day')->format('Y-m-d');
                $lastDate = $this->Model->getRequeteOne('SELECT MAX(JOUR_AUDIENCE) JOUR_AUDIENCE,ID_TRAITEMENT_AUDIENCE,STATUT_SCANNER,pms_traitement_audience.HEURE_AUDIENCE FROM pms_traitement_audience JOIN pms_demandeur_audience ON pms_demandeur_audience.ID_DEMANDEUR_AUDIENCE=pms_traitement_audience.ID_DEMANDEUR_AUDEINCE WHERE pms_demandeur_audience.ID_OBJET_VISITE=20 AND JOUR_AUDIENCE>"'.$today.'" AND pms_traitement_audience.STATUT_SCANNER=0 GROUP BY ID_TRAITEMENT_AUDIENCE,STATUT_SCANNER ORDER BY ID_TRAITEMENT_AUDIENCE DESC LIMIT 1');
                  $max='';
                    if ($lastDate) {
                    $max=$lastDate['JOUR_AUDIENCE'];
                     }
                if (!empty($max)) 
                {
                    $dateCible=$lastDate['JOUR_AUDIENCE'];
                    $LastHour=$lastDate['HEURE_AUDIENCE'];
                }
                else
                  {
                    $today = date('Y-m-d');
                    $dateTime = new DateTime($today);
                    $dateCible = $dateTime->modify('+1 day')->format('Y-m-d');
                    $dayOfWeek = (new DateTime($dateCible))->format('N');
                    if ($dayOfWeek == 6) 
                      { // samedi
                        $dateCible = (new DateTime($dateCible))->modify('+2 day')->format('Y-m-d'); // Lundi
                      }  
                      elseif ($dayOfWeek == 7) 
                      { // dimanche
                        $dateCible = (new DateTime($dateCible))->modify('+1 day')->format('Y-m-d'); // Lundi
                      } 
                      else
                      {
                        $dateCible = $dateCible; // jour +1 
                      }
                      $LastHour='08:00'; 
                  }
                  // Convertir l'heure en objet DateTime
                  $lastHourDateTime = DateTime::createFromFormat('H:i', $LastHour);
                  $dateCibleDateTime = DateTime::createFromFormat('Y-m-d', $dateCible);
                  // Vérifier si l'heure est avant 15h30



                 if((new DateTime($dateCible))->format('N')==5){
                    $heure_cl= '13:20';
                    $minpre=90;    
                    } else{
                     $heure_cl= '15:00';
                     $minpre=150; 
                    }
                    
                  if ($lastHourDateTime->format('H:i') < ''.$heure_cl.'') 
                  {
                   if( $lastHourDateTime->format('h:i') >= '11:55' && $lastHourDateTime->format('h:i') < '12:00')
                        {
                        $nextHourDateTime = clone $lastHourDateTime;
                        $nextHourDateTime->modify('+'.$minpre.' minutes');
                        }
                        else
                        {// Ajouter 30 minutes
                          $nextHourDateTime = clone $lastHourDateTime;
                          $nextHourDateTime->modify('+5 minutes');
                        }
                  } 
                  else  
                  {

                        // Ajouter 1 jour et fixer l'heure à 8h00
                      $nextHourDateTime = clone $lastHourDateTime;
                      $dateCibleDateTime = clone $dateCibleDateTime;
                      $dateCibleDateTime->modify('+1 day');
                      $DateFermee = $this->Model->getRequete('SELECT DATE_CONGE FROM `pms_date_fermees` WHERE  STATUS=1');
                      $DateFermeeListe = array_column($DateFermee, 'DATE_CONGE');
                          // Éviter les week-ends et les jours fériés
                       while (true) 
                      {
                             $dayOfWeek = $dateCibleDateTime->format('N');
                             if ($dayOfWeek == 6) 
                            { // samedi
                              $dateCibleDateTime->modify('+2 day'); // Lundi
                            } 
                            elseif ($dayOfWeek == 7) 
                            { // dimanche
                              $dateCibleDateTime->modify('+1 day'); // Lundi
                            }
                             elseif (in_array($dateCibleDateTime->format('Y-m-d'), $DateFermeeListe)) 
                            {
                              $dateCibleDateTime->modify('+1 day');
                            } 
                            else 
                            {
                              break;
                            }
                      }
                      // Si le congé etait vendredi, on passe au lundi suivant
                      $dayOfWeek = $dateCibleDateTime->format('N');
                      if ($dayOfWeek == 6) {
                        $dateCibleDateTime->modify('+2 day');
                      }
                      
                      $nextHourDateTime->setTime(8, 0);
                      $dateCible = $dateCibleDateTime->format('Y-m-d');
                        // print_r($dateCible);die();
                  }
                  // Formater la nouvelle heure en chaîne de caractères
                  $nextHour = $nextHourDateTime->format('H:i');
                    // print_r($nextHour);die(); 

                      $array_tosave = array(
                              'ID_DEMANDEUR_AUDEINCE' => $insertion,
                              'JOUR_AUDIENCE' => $dateCible,
                              'STATUT_MAIL' => 1,
                              'STATUT_SCANNER' => 0,
                              'HEURE_AUDIENCE' => $nextHour
                             );
                         // print_r($array_tosave);die();
                 $rendezvous = $this->Model->insert_last_id('pms_traitement_audience', $array_tosave);   
               }
               //Attestations DE NON POSSESSION [5 minutes]

                 // code...
               
               else if ($objet==21 )  
               {
                // for ($i=0; $i < 100; $i++) { 
                 $today = date('Y-m-d');
                 $dateTime = new DateTime($today);
                 $dateCible = $dateTime->modify('+1 day')->format('Y-m-d');
                $lastDate = $this->Model->getRequeteOne('SELECT MAX(JOUR_AUDIENCE) JOUR_AUDIENCE,ID_TRAITEMENT_AUDIENCE,STATUT_SCANNER,pms_traitement_audience.HEURE_AUDIENCE FROM pms_traitement_audience JOIN pms_demandeur_audience ON pms_demandeur_audience.ID_DEMANDEUR_AUDIENCE=pms_traitement_audience.ID_DEMANDEUR_AUDEINCE WHERE  pms_demandeur_audience.ID_OBJET_VISITE=21 AND JOUR_AUDIENCE>"'.$today.'" AND pms_traitement_audience.STATUT_SCANNER=0 GROUP BY ID_TRAITEMENT_AUDIENCE,STATUT_SCANNER ORDER BY ID_TRAITEMENT_AUDIENCE DESC LIMIT 1');
                  $max=$lastDate['JOUR_AUDIENCE'];
                if (!empty($max)) 
                {
                    $dateCible=$lastDate['JOUR_AUDIENCE'];
                    $LastHour=$lastDate['HEURE_AUDIENCE'];
                }
                else
                  {
                    $today = date('Y-m-d');
                    $dateTime = new DateTime($today);
                    $dateCible = $dateTime->modify('+1 day')->format('Y-m-d');
                    $dayOfWeek = (new DateTime($dateCible))->format('N');
                    if ($dayOfWeek == 6) 
                      { // samedi
                        $dateCible = (new DateTime($dateCible))->modify('+2 day')->format('Y-m-d'); // Lundi
                      }  
                      elseif ($dayOfWeek == 7) 
                      { // dimanche
                        $dateCible = (new DateTime($dateCible))->modify('+1 day')->format('Y-m-d'); // Lundi
                      } 
                      else
                      {
                        $dateCible = $dateCible; // jour +1 
                      }
                      $LastHour='08:00'; 
                  }
                  // Convertir l'heure en objet DateTime
                  $lastHourDateTime = DateTime::createFromFormat('H:i', $LastHour);
                  $dateCibleDateTime = DateTime::createFromFormat('Y-m-d', $dateCible);
                  $dayOfWeek = (new DateTime($dateCible))->format('N');
                 
                  if((new DateTime($dateCible))->format('N')==5){
                    $heure_cl= '13:20';
                    $minpre=90;    
                    } else{
                     $heure_cl= '15:00';
                     $minpre=150; 
                    }

// print_r($heure_cl);die();
                  if ($lastHourDateTime->format('H:i') < ''.$heure_cl.'') 
                  {
                      if( $lastHourDateTime->format('h:i') >= '11:55' && $lastHourDateTime->format('h:i') < '12:00')
                        {
                        $nextHourDateTime = clone $lastHourDateTime;
                        $nextHourDateTime->modify('+'.$minpre.' minutes');
                        }
                        else
                        {// Ajouter 30 minutes
                          $nextHourDateTime = clone $lastHourDateTime;
                          $nextHourDateTime->modify('+5 minutes');
                        }
                  } 
                  else  
                  {

                        // Ajouter 1 jour et fixer l'heure à 8h00
                      $nextHourDateTime = clone $lastHourDateTime;
                      $dateCibleDateTime = clone $dateCibleDateTime;
                      $dateCibleDateTime->modify('+1 day');
                      $DateFermee = $this->Model->getRequete('SELECT DATE_CONGE FROM `pms_date_fermees` WHERE  STATUS=1');
                      $DateFermeeListe = array_column($DateFermee, 'DATE_CONGE');
                          // Éviter les week-ends et les jours fériés
                       while (true) 
                      {
                             $dayOfWeek = $dateCibleDateTime->format('N');
                             if ($dayOfWeek == 6) 
                            { // samedi
                              $dateCibleDateTime->modify('+2 day'); // Lundi
                            } 
                            elseif ($dayOfWeek == 7) 
                            { // dimanche
                              $dateCibleDateTime->modify('+1 day'); // Lundi
                            }
                             elseif (in_array($dateCibleDateTime->format('Y-m-d'), $DateFermeeListe)) 
                            {
                              $dateCibleDateTime->modify('+1 day');
                            } 
                            else 
                            {
                              break;
                            }
                      }
                      // Si le congé etait vendredi, on passe au lundi suivant
                      $dayOfWeek = $dateCibleDateTime->format('N');
                      if ($dayOfWeek == 6) {
                        $dateCibleDateTime->modify('+2 day');
                      }
                      
                      $nextHourDateTime->setTime(8, 0);
                      $dateCible = $dateCibleDateTime->format('Y-m-d');
                        // print_r($dateCible);die();
                  }
                  // Formater la nouvelle heure en chaîne de caractères
                  $nextHour = $nextHourDateTime->format('H:i');
                    // print_r($nextHour);die(); 

                      $array_tosave = array(
                              'ID_DEMANDEUR_AUDEINCE' => $insertion,
                              'JOUR_AUDIENCE' => $dateCible,
                              'STATUT_MAIL' => 1,
                              'STATUT_SCANNER' => 0,
                              'HEURE_AUDIENCE' => $nextHour
                             );
                         // print_r($array_tosave);die();
                 $rendezvous = $this->Model->insert_last_id('pms_traitement_audience', $array_tosave);  
                  
               }
               //Inscription de l'hypothèque [10 minutes]
               else if ($objet == 13 )  
               {
                    $today = date('Y-m-d');
                    $dateTime = new DateTime($today);
                    $dateCible = $dateTime->modify('+1 day')->format('Y-m-d');
                     $lastDate = $this->Model->getRequeteOne('SELECT MAX(JOUR_AUDIENCE) JOUR_AUDIENCE,ID_TRAITEMENT_AUDIENCE,STATUT_SCANNER,pms_traitement_audience.HEURE_AUDIENCE FROM pms_traitement_audience JOIN pms_demandeur_audience ON pms_demandeur_audience.ID_DEMANDEUR_AUDIENCE=pms_traitement_audience.ID_DEMANDEUR_AUDEINCE WHERE pms_demandeur_audience.ID_OBJET_VISITE=13 AND JOUR_AUDIENCE>"'.$today.'" AND pms_traitement_audience.STATUT_SCANNER=0 GROUP BY ID_TRAITEMENT_AUDIENCE,STATUT_SCANNER ORDER BY ID_TRAITEMENT_AUDIENCE DESC LIMIT 1');
                     // print_r($lastDate);die();
                   $max=$lastDate['JOUR_AUDIENCE'];
                if (!empty($max)) 
                {
                    $dateCible=$lastDate['JOUR_AUDIENCE'];
                    $LastHour=$lastDate['HEURE_AUDIENCE'];
                  }
                  else
                  {
                    $today = date('Y-m-d');
                    $dateTime = new DateTime($today);
                    $dateCible = $dateTime->modify('+1 day')->format('Y-m-d');
                    $dayOfWeek = (new DateTime($dateCible))->format('N');
                    if ($dayOfWeek == 6) 
                      { // samedi
                        $dateCible = (new DateTime($dateCible))->modify('+2 day')->format('Y-m-d'); // Lundi
                      }  
                      elseif ($dayOfWeek == 7) 
                      { // dimanche
                        $dateCible = (new DateTime($dateCible))->modify('+1 day')->format('Y-m-d'); // Lundi
                      } 
                      else
                      {
                        $dateCible = $dateCible; // jour +1 
                      }
                      $LastHour='08:00'; 
                  }
                  // Convertir l'heure en objet DateTime
                  $lastHourDateTime = DateTime::createFromFormat('H:i', $LastHour);
                  $dateCibleDateTime = DateTime::createFromFormat('Y-m-d', $dateCible);
                  // Vérifier si l'heure est avant 15h30
                 if((new DateTime($dateCible))->format('N')==5){
                    $heure_cl= '13:20';
                    $minpre=90;    
                    } else{
                     $heure_cl= '15:00';
                     $minpre=150; 
                    }
                  if ($lastHourDateTime->format('H:i') < ''.$heure_cl.'') 
                  {
                      if( $lastHourDateTime->format('h:i') >= '11:55' && $lastHourDateTime->format('h:i') < '12:00')
                        {
                        $nextHourDateTime = clone $lastHourDateTime;
                        $nextHourDateTime->modify('+'.$minpre.' minutes');
                        }
                        else
                        {// Ajouter 30 minutes
                          $nextHourDateTime = clone $lastHourDateTime;
                          $nextHourDateTime->modify('+10 minutes');
                        }
                  } 
                  else  
                  {
                        // Ajouter 1 jour et fixer l'heure à 8h00
                      $nextHourDateTime = clone $lastHourDateTime;
                      $dateCibleDateTime = clone $dateCibleDateTime;
                      $dateCibleDateTime->modify('+1 day');
                      $DateFermee = $this->Model->getRequete('SELECT DATE_CONGE FROM `pms_date_fermees` WHERE  STATUS=1');
                      $DateFermeeListe = array_column($DateFermee, 'DATE_CONGE');
                          // Éviter les week-ends et les jours fériés
                       while (true) 
                      {
                             $dayOfWeek = $dateCibleDateTime->format('N');
                             if ($dayOfWeek == 6) 
                            { // samedi
                              $dateCibleDateTime->modify('+2 day'); // Lundi
                            } 
                            elseif ($dayOfWeek == 7) 
                            { // dimanche
                              $dateCibleDateTime->modify('+1 day'); // Lundi
                            }
                             elseif (in_array($dateCibleDateTime->format('Y-m-d'), $DateFermeeListe)) 
                            {
                              $dateCibleDateTime->modify('+1 day');
                            } 
                            else 
                            {
                              break;
                            }
                      }
                      // Si le congé etait vendredi, on passe au lundi suivant
                      $dayOfWeek = $dateCibleDateTime->format('N');
                      if ($dayOfWeek == 6) {
                        $dateCibleDateTime->modify('+2 day');
                      }
                      
                      $nextHourDateTime->setTime(8, 0);
                      $dateCible = $dateCibleDateTime->format('Y-m-d');
                        // print_r($dateCible);die();
                  }
                  // Formater la nouvelle heure en chaîne de caractères
                  $nextHour = $nextHourDateTime->format('H:i');
                    // print_r($nextHour);die(); 

                      $array_tosave = array(
                              'ID_DEMANDEUR_AUDEINCE' => $insertion,
                              'JOUR_AUDIENCE' => $dateCible,
                              'STATUT_MAIL' => 1,
                              'STATUT_SCANNER' => 0,
                              'HEURE_AUDIENCE' => $nextHour
                             );
                         // print_r($array_tosave);die();
                 $rendezvous = $this->Model->insert_last_id('pms_traitement_audience', $array_tosave);   
               }
                //Autres processus [5 minutes]
               else 
               {
                    $today = date('Y-m-d');
                    $dateTime = new DateTime($today);
                    $dateCible = $dateTime->modify('+1 day')->format('Y-m-d');
                 $lastDate = $this->Model->getRequeteOne('SELECT MAX(JOUR_AUDIENCE) JOUR_AUDIENCE,ID_TRAITEMENT_AUDIENCE,STATUT_SCANNER,pms_traitement_audience.HEURE_AUDIENCE FROM pms_traitement_audience JOIN pms_demandeur_audience ON pms_demandeur_audience.ID_DEMANDEUR_AUDIENCE=pms_traitement_audience.ID_DEMANDEUR_AUDEINCE WHERE pms_demandeur_audience.ID_OBJET_VISITE NOT IN (0,13, 19, 20, 21, 30) AND JOUR_AUDIENCE>"'.$today.'" AND pms_traitement_audience.STATUT_SCANNER=0 GROUP BY ID_TRAITEMENT_AUDIENCE,STATUT_SCANNER ORDER BY ID_TRAITEMENT_AUDIENCE DESC LIMIT 1');
                  $max=$lastDate['JOUR_AUDIENCE'];

                if (!empty($max)) 
                {
                    $dateCible=$lastDate['JOUR_AUDIENCE'];
                    $LastHour=$lastDate['HEURE_AUDIENCE'];
                }

                else
                  {
                    $today = date('Y-m-d');
                    $dateTime = new DateTime($today);
                    $dateCible = $dateTime->modify('+1 day')->format('Y-m-d');
                    $dayOfWeek = (new DateTime($dateCible))->format('N');
                    if ($dayOfWeek == 6) 
                      { // samedi
                        $dateCible = (new DateTime($dateCible))->modify('+2 day')->format('Y-m-d'); // Lundi
                      }  
                      elseif ($dayOfWeek == 7) 
                      { // dimanche
                        $dateCible = (new DateTime($dateCible))->modify('+1 day')->format('Y-m-d'); // Lundi
                      } 
                      else
                      {
                        $dateCible = $dateCible; // jour +1 
                      }
                      $LastHour='08:00'; 
                  }
                  // Convertir l'heure en objet DateTime
                  $lastHourDateTime = DateTime::createFromFormat('H:i', $LastHour);
                  $dateCibleDateTime = DateTime::createFromFormat('Y-m-d', $dateCible);

                  // Vérifier si l'heure est avant 15h30

                 if((new DateTime($dateCible))->format('N')==5){
                    $heure_cl= '13:20';
                    $minpre=90;    
                    } else{
                     $heure_cl= '15:00';
                     $minpre=150; 
                    }
                  if ($lastHourDateTime->format('H:i') < ''.$heure_cl.'') 
                  {
                      if( $lastHourDateTime->format('h:i') >= '11:55' && $lastHourDateTime->format('h:i') < '12:00')
                        {
                        $nextHourDateTime = clone $lastHourDateTime;
                        $nextHourDateTime->modify('+'.$minpre.' minutes');
                        }
                        else
                        {// Ajouter 30 minutes
                          $nextHourDateTime = clone $lastHourDateTime;
                          $nextHourDateTime->modify('+5 minutes');
                        }
                  } 
                  else  
                  {    // Ajouter 1 jour et fixer l'heure à 8h00
                      $nextHourDateTime = clone $lastHourDateTime;
                      $dateCibleDateTime = clone $dateCibleDateTime;
                      $dateCibleDateTime->modify('+1 day');
                      $DateFermee = $this->Model->getRequete('SELECT DATE_CONGE FROM `pms_date_fermees` WHERE  STATUS=1');
                      $DateFermeeListe = array_column($DateFermee, 'DATE_CONGE');
                          // Éviter les week-ends et les jours fériés
                       while (true) 
                      {
                             $dayOfWeek = $dateCibleDateTime->format('N');
                             if ($dayOfWeek == 6) 
                            { // samedi
                              $dateCibleDateTime->modify('+2 day'); // Lundi
                            } 
                            elseif ($dayOfWeek == 7) 
                            { // dimanche
                              $dateCibleDateTime->modify('+1 day'); // Lundi
                            }
                             elseif (in_array($dateCibleDateTime->format('Y-m-d'), $DateFermeeListe)) 
                            {
                              $dateCibleDateTime->modify('+1 day');
                            } 
                            else 
                            {
                              break;
                            }
                      }
                      // Si le congé etait vendredi, on passe au lundi suivant
                      $dayOfWeek = $dateCibleDateTime->format('N');
                      if ($dayOfWeek == 6) {
                        $dateCibleDateTime->modify('+2 day');
                      }
                      
                      $nextHourDateTime->setTime(8, 0);
                      $dateCible = $dateCibleDateTime->format('Y-m-d');
                  }
                  // Formater la nouvelle heure en chaîne de caractères
                  $nextHour = $nextHourDateTime->format('H:i');
                  
                      $array_tosave = array(
                              'ID_DEMANDEUR_AUDEINCE' => $insertion,
                              'JOUR_AUDIENCE' => $dateCible,
                              'STATUT_MAIL' => 1,
                              'STATUT_SCANNER' => 0,
                              'HEURE_AUDIENCE' => $nextHour
                             );
                      // print_r($array_tosave);die();
                 $rendezvous = $this->Model->insert_last_id('pms_traitement_audience', $array_tosave);   
               }
            // }

            //envoi des messages de succès
               //objet ==1 veut dire toujours audiences
            if ($objet != 0) 
            {
              $req = $this->Model->getRequeteOne('SELECT NOM_PRENOM, EMAIL,CATHEGORIE_DEMANDEUR,RAISON_SOCIALE,SEXE_ID FROM pms_demandeur_audience  WHERE ID_DEMANDEUR_AUDIENCE='.$insertion.'');

              if ($req['SEXE_ID']==1) 
              {
                $genre="Madame";
              }
              else if ($req['SEXE_ID']==2)
              {
               $genre="Monsieur"; 
              }
              else
              {
               $genre="Cher responsable de"; 
              }
              if ($req['CATHEGORIE_DEMANDEUR']==5) 
              {
                $nom=$req['RAISON_SOCIALE'];
              } else 
              {
                $nom=$req['NOM_PRENOM'];
              }
              $greeting=$genre.' '.$nom;
              $req1 = $this->Model->getRequeteOne('SELECT `JOUR_AUDIENCE`,`HEURE_AUDIENCE` FROM `pms_traitement_audience`  WHERE  ID_DEMANDEUR_AUDEINCE = '.$insertion.'');
              $subject = "Confirmation de votre demande de rendez-vous";
              $message = ' <b>'.$greeting.'</b>,<br><br>
              Votre rendez-vous a été programmé pour le '.date('d-m-Y', strtotime($req1['JOUR_AUDIENCE'])).' à '.$req1['HEURE_AUDIENCE'].'<br><br>
              Il vous est demandé de vous présenter physiquement aux bureaux du secrétariat de la Direction des Titres Foncier et du Cadastre National, en apportant vos documents en rapport avec votre demande.<br><br>
              Veuillez télécharger votre certificat de demande d’audience en cliquant sur le <a href="'.base_url('administration/Liste_Demande_Rdv/Document_Pdf/'.md5($rendezvous)).'">Document à télécharger</a>.<br><br>
              Cordialement.'; 
              
              $mailTo =$req['EMAIL'];
              $sending = $this->notifications->send_mail($mailTo, $subject, [], $message, []);
            }
            else
            {
              $req = $this->Model->getRequeteOne('SELECT NOM_PRENOM,SEXE_ID,EMAIL,RAISON_SOCIALE,CATHEGORIE_DEMANDEUR FROM pms_demandeur_audience WHERE ID_DEMANDEUR_AUDIENCE='.$insertion.'');
              if ($req['SEXE_ID']==1) 
              {
                $genre="Madame";
              }
              else if ($req['SEXE_ID']==2)
              {
               $genre="Monsieur"; 
              }
              else
              {
               $genre="Cher responsable de"; 
              }

               if ($req['CATHEGORIE_DEMANDEUR']==5) 
              {
                $nom=$req['RAISON_SOCIALE'];
              } else 
              { 
                $nom=$req['NOM_PRENOM'];
              }
              $greeting=$genre.''.$nom;
              $req1 = $this->Model->getRequeteOne('SELECT `JOUR_AUDIENCE`,`HEURE_AUDIENCE` FROM `pms_traitement_audience` WHERE  ID_DEMANDEUR_AUDEINCE = '.$insertion.'');
              
              $subject = "Confirmation de votre demande de rendez-vous";
              $message = '<b>'.trim($greeting).'</b>,<br><br>
              Votre rendez-vous a été programmé pour le '.date('d-m-Y', strtotime($req1['JOUR_AUDIENCE'])).' à '.$req1['HEURE_AUDIENCE'].'<br><br>
              Il vous est demandé de vous présenter physiquement aux bureaux du secrétariat de la Direction des Titres Foncier et du Cadastre National, en apportant vos documents en rapport avec votre demande.<br><br>
              Veuillez télécharger votre certificat de demande d’audience en cliquant sur le <a href="'.base_url('administration/Liste_Demande_Rdv/Document_Pdf/'.md5($rendezvous)).'">Document à télécharger</a>.<br><br>
              Cordialement.';
              $mailTo = $req['EMAIL'];
              $sending = $this->notifications->send_mail($mailTo, $subject, [], $message, []);
            }

            //on affiche les messages de succès si les deux tables ont enregistré les informations
            if ($insertion == 1 && $audience ==1) 
            {
              $message = "<div class='alert alert-success text-center'>Votre demande d'audience a été transmise avec succès. Un message de confirmation vous sera envoyé par e-mail.</div>";
            } 
            else if($insertion && $rendezvous) 
            {
              $message = "<div class='alert alert-success text-center'>Votre demande de rendez-vous a été transmise avec succès. Un message de confirmation vous sera envoyé par e-mail.</div>";
            } 
            else 
            {
              $message = "<div class='alert alert-danger text-center'>Une erreur s'est produite, la demande n'a pas été envoyée.</div>";
            }

            $this->session->set_flashdata(array('message'=>$message));
                redirect(base_url('Audiences/messaging'));  
           }
        }

        public function absolete()
        {
          $this->load->view('Absolete_view');
        }

        public function messaging()
        {
          $this->load->view('Audiences_redirect_view');
        }
  
        //PERMET L'UPLOAD DE L'IMAGE CNI / PASSEPORT
        public function upload_file_titre($input_name)
   {
    $nom_file = $_FILES[$input_name]['tmp_name'];
    $nom_champ = $_FILES[$input_name]['name'];
    $ext=pathinfo($nom_champ, PATHINFO_EXTENSION);
    $repertoire_fichier = FCPATH . 'uploads/doc_scanner/';
    $code=uniqid();
    $name=$code . 'TITRE.' .$ext;
    $file_link = $repertoire_fichier . $name;
    if (!is_dir($repertoire_fichier)) {
        mkdir($repertoire_fichier, 0777, TRUE);
    }
    move_uploaded_file($nom_file, $file_link);
    return $name;
}

        //certificat de demande de rdv
        public function Document_Pdf($id)
        {
          $req_infos=$this->Model->getRequeteOne('SELECT pms_demandeur_audience.ID_DEMANDEUR_AUDIENCE,genre.GENRE, pms_demandeur_audience.NOM_PRENOM,pms_demandeur_audience.TELEPHONE,pms_demandeur_audience.EMAIL,pms_traitement_audience.JOUR_AUDIENCE ,pms_traitement_audience.HEURE_AUDIENCE,pms_demandeur_audience.TYPE_INITIATION_DEMANDE,pms_traitement_audience.STATUT_SCANNER FROM `pms_demandeur_audience` join pms_traitement_audience on pms_traitement_audience.ID_DEMANDEUR_AUDEINCE=pms_demandeur_audience.ID_DEMANDEUR_AUDIENCE JOIN genre ON genre.GENRE_ID=pms_demandeur_audience.SEXE_ID WHERE md5(pms_traitement_audience.ID_TRAITEMENT_AUDIENCE)="'.$id.'"');

          if (empty($req_infos))
          {
           redirect(base_url('Rendez_vous/absolete'));
          }
          else
          {
             $dateString = $req_infos['JOUR_AUDIENCE'];
             $date = DateTime::createFromFormat('Y-m-d', $dateString);
             // $formattedDate = date_format($date, 'd-m-Y');
             $formattedDate = date_format($date, 'd-m-Y').' à '.$req_infos['HEURE_AUDIENCE'];
             // $formattedDate = "2024-05-14";

             $pdf = new FPDF();
             $pdf->AddPage();
          
             $src_file = 'uploads/rdv/';
             
             if(!is_dir($src_file))
             {
               mkdir($src_file ,0777 ,TRUE);
             }
          
          
             if ($req_infos['STATUT_SCANNER'] == 0 && $req_infos['TYPE_INITIATION_DEMANDE'] == 1)
             {
               //nvlle audiance
               $pdf->Image(base_url().'uploads/logo/certificat_dtfcn_aud.jpg',0,0,210, 297);
             } 
             else if($req_infos['STATUT_SCANNER'] == 2 && $req_infos['TYPE_INITIATION_DEMANDE'] == 1) 
             {
               $pdf->Image(base_url().'uploads/logo/certificat_dtfcn_report_aud.jpg',0,0,210, 297);
               //report audiance
             } 
             else if ($req_infos['STATUT_SCANNER'] == 0 && $req_infos['TYPE_INITIATION_DEMANDE'] == 2) 
             {
               $pdf->Image(base_url().'uploads/logo/certificat_dtfcn_rdv.jpg',0,0,210, 297);
               //nvlle rdv
             } 
             else 
             {
               $pdf->Image(base_url().'uploads/logo/certificat_dtfcn_report_rdv.jpg',0,0,210, 297);
               //report rdv
             }

             $pdf->Ln(5);
             $pdf->SetFont('Times','B',12);
             $pdf->Cell(175,6,'Bujumbura le,'.date('d/m/Y') ,0,1,'R');
              //,strtotime($passport['datecreation'])
             $pdf->SetFont('Times','B',12);
             $pdf->Ln(40);
             $pdf->SetTextColor(255,255,255);
             
             $pdf->SetTextColor(0,0,0);
             $pdf->SetFont('Times','',10);
          
          
             $pdf->Ln(80);
             
             $pdf->SetFont('Times','B',14);
             $pdf->Cell(14,50,utf8_decode(""),0,'C');
             $pdf->MultiCell(300,-55,utf8_decode("".$req_infos['NOM_PRENOM'].""),'C',false);
          
             $pdf->Ln(26);
          
             $pdf->SetFont('Times','B',14);
             $pdf->Cell(95,7,utf8_decode(""),0,'C');
             $pdf->MultiCell(300,2,utf8_decode("RDV-".$req_infos['ID_DEMANDEUR_AUDIENCE'].""),'C',false);
          
             $pdf->Ln(26);
             $pdf->SetFont('Times','B',14);
             $pdf->Cell(14,7,utf8_decode(""),0,'C');
             $pdf->MultiCell(305,2,utf8_decode("".$req_infos['GENRE'].""),'C',false);
             $pdf->Ln(-16);

             $pdf->SetFont('Times','B',14);
             $pdf->Cell(14,7,utf8_decode(""),0,'C');
             $pdf->MultiCell(305,2,utf8_decode("".$req_infos['EMAIL'].""),'C',false);

             $pdf->Ln(25);
             $i=0;
             $info_qrcode='NOM ET PRENOM : '.$req_infos['NOM_PRENOM']."\n".'E-MAIL : '.$req_infos['EMAIL']."\n".'CODE DEMANDE :  '.$req_infos['ID_DEMANDEUR_AUDIENCE']."\n".' '.'DATE RENDEZ VOUS :  '.$req_infos['JOUR_AUDIENCE'].'  '.'HEURE:'.$req_infos['HEURE_AUDIENCE'].'';

             $val= $req_infos['ID_DEMANDEUR_AUDIENCE'];
             $this->notifications->generateQrcode($info_qrcode,$val);
              // $val= $val++;
             $qrcode_name = $val.'.png';
             if(file_exists(FCPATH . 'uploads/qrcode/'.$qrcode_name))
             {
               $pdf->Image(FCPATH . 'uploads/qrcode/'.$qrcode_name,90,160,41,0);
             }
             $pdf->Ln(-28);
          
             $pdf->SetFont('Times','B',14);
             $pdf->Cell(94,7,utf8_decode(""),0,'C');
             $pdf->MultiCell(300,5,utf8_decode("".$req_infos['TELEPHONE'].""),'C',false);

             $pdf->Ln(132);
          
             $pdf->SetFont('Times','B',14);
             $pdf->Cell(94,7,utf8_decode(""),0,'C');
             $pdf->MultiCell(300,5,utf8_decode("".$req_infos['ID_DEMANDEUR_AUDIENCE']."-"."".$req_infos['JOUR_AUDIENCE'].""),'C',false);
          
             $name_file = "AUD-" . $req_infos['ID_DEMANDEUR_AUDIENCE'] . "confirmed.pdf";
             $this->Model->update('pms_traitement_audience',array('md5(ID_TRAITEMENT_AUDIENCE)'=>$id),array('DOC_CERTIFICAT_RENDEZ_VOUS'=>$name_file));
             //  $pdf->Output($src_file.'/'.$name_file, 'F');
          

             $pdf->Output('I'); 
          }
        }
}
