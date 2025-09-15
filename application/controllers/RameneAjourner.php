<?php 
/**
* @author Edmond
* Tel 61774954
* DEMANDE DES AUDIENCES
* edmond@mediabox.bi
*/
class RameneAjourner extends CI_Controller
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

    $jrne =$this->Model->getRequete("SELECT ID_TRAITEMENT_AUDIENCE,`ID_DEMANDEUR_AUDEINCE`,`JOUR_AUDIENCE`,`HEURE_AUDIENCE` FROM `pms_traitement_audience` JOIN pms_demandeur_audience ON pms_demandeur_audience.ID_DEMANDEUR_AUDIENCE=pms_traitement_audience.ID_DEMANDEUR_AUDEINCE WHERE pms_demandeur_audience.ID_OBJET_VISITE=30 AND STATUT_SCANNER=0 AND date_format( pms_traitement_audience.`JOUR_AUDIENCE`,'%Y-%m-%d') > '2024-12-19' ORDER BY ID_TRAITEMENT_AUDIENCE ASC");
    
    $premierTour = true;
    foreach ($jrne as  $value) {
    $today = date('Y-m-d');
    $dateTime = new DateTime($today);
    $dateCible = $dateTime->modify('+1 day')->format('Y-m-d'); 
    $lastDate = $this->Model->getRequeteOne('SELECT `ID_TRAITEMENT_AUDIENCE`, `ID_DEMANDEUR_AUDEINCE`, `JOUR_AUDIENCE`, `HEURE_AUDIENCE` FROM `pms_traitement_audience`JOIN pms_demandeur_audience ON pms_demandeur_audience.ID_DEMANDEUR_AUDIENCE=pms_traitement_audience.ID_DEMANDEUR_AUDEINCE WHERE pms_demandeur_audience.ID_OBJET_VISITE=30 AND STATUT_SCANNER=0 AND ID_TRAITEMENT_AUDIENCE < '.$value['ID_TRAITEMENT_AUDIENCE'].'  ORDER BY ID_TRAITEMENT_AUDIENCE DESC LIMIT 1');


    $max='';

    if ($lastDate) {
    $max=$lastDate['JOUR_AUDIENCE'];
    }
 

    if (!$premierTour) 
    {
    $dateCible=$lastDate['JOUR_AUDIENCE'];
    $LastHour=$lastDate['HEURE_AUDIENCE'];
    }
    else
    {
    $premierTour = false;
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
    $heure_cl= '15:30';
    $minpre=150; 
    }
     if ($lastHourDateTime->format('H:i') < ''.$heure_cl.'') 
    {
    if( $lastHourDateTime->format('H:i') >= '11:30' && $lastHourDateTime->format('H:i') < '12:00')
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
   
    }
    // Formater la nouvelle heure en chaîne de caractères
    $nextHour = $nextHourDateTime->format('H:i');
    $array_tosave = array(
    'JOUR_AUDIENCE' => $dateCible,
    'HEURE_AUDIENCE' => $nextHour
    );


    $updating = $this->Model->update('pms_traitement_audience', array('ID_TRAITEMENT_AUDIENCE' => $value['ID_TRAITEMENT_AUDIENCE']), $array_tosave);

    $req = $this->Model->getRequeteOne('SELECT NOM_PRENOM, EMAIL,CATHEGORIE_DEMANDEUR,RAISON_SOCIALE,SEXE_ID FROM pms_demandeur_audience  WHERE ID_DEMANDEUR_AUDIENCE='.$value['ID_DEMANDEUR_AUDEINCE'].'');


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
    $req1 = $this->Model->getRequeteOne('SELECT `JOUR_AUDIENCE`,`HEURE_AUDIENCE` FROM `pms_traitement_audience`  WHERE  ID_DEMANDEUR_AUDEINCE = '.$value['ID_DEMANDEUR_AUDEINCE'].'');
    $subject = "Confirmation de votre demande de rendez-vous";
    $message = ' <b>'.$greeting.'</b>,<br><br>
    Votre rendez-vous a été programmé pour le '.date('d-m-Y', strtotime($req1['JOUR_AUDIENCE'])).' à '.$req1['HEURE_AUDIENCE'].'<br><br>
    Il vous est demandé de vous présenter physiquement aux bureaux du secrétariat de la Direction des Titres Foncier et du Cadastre National, en apportant vos documents en rapport avec votre demande.<br><br>
    Veuillez télécharger votre certificat de demande d’audience en cliquant sur le <a href="'.base_url('administration/Liste_Demande_Rdv/Document_Pdf/'.md5($value['ID_TRAITEMENT_AUDIENCE'])).'">Document à télécharger</a>.<br><br>
    Cordialement.'; 

    $mailTo =$req['EMAIL'];
    $sending = $this->notifications->send_mail($mailTo, $subject, [], $message, []);
    
    }
  }
}