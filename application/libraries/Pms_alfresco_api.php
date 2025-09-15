  <?php

/**
 * 
 */
class Pms_alfresco_api extends CI_Controller
{
  protected $CI;
  private $ip_port_serveur = "192.168.0.25";
  private $ip_port_serveur_alfresco = "192.168.0.25:1620";

  public function __construct()
  {
    $this->CI = &get_instance();
    $this->CI->load->library('email');
    $this->CI->load->model('Model');
  }

  //Authentication API
  function login()
  {

    $username = "admin";
    $password = "2024BbiSkalfr&SC0";
    $data = array(
      'username' => $username,
      'password' => $password
    );

    $url = "http://" . $this->ip_port_serveur_alfresco . "/alfresco/s/api/login";

    $reponse =  $this->execute($url, json_encode($data));

    // return $reponse;
    return $reponse->data->ticket;
  }

  //Execute request 
  function execute_alfresco($url, $data = '', $method = 'POST')
  {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_ENCODING, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    if ($method == 'POST')
      curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8', 'Accept: application/json', 'Accept-Encoding: deflate'));
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
    curl_setopt($ch, CURLOPT_USERPWD, "admin:al2023fr&SC0");
    if (!empty($data))
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    curl_close($ch);

    // $donne_cn = str_replace("cm:", "cm_", $output);
    // $donne_op = str_replace("sys:", "sys_", $donne_cn);

    // return $output;
    return json_decode($output);
  }

  //API CREATE FOLDER
  public function create_folder($ticket, $data = array(), $storage)
  {
    // $data = array('name' => "Alfresco Folder",'title' => "Folder belong to Mr Nandou", 'description' => "Folder for testing API");

    $url = "http://" . $this->ip_port_serveur_alfresco . "/alfresco/s/api/node/folder/workspace/SpacesStore/" . $storage . "?alf_ticket=" . $ticket;

    $return = $this->execute($url, json_encode($data));
    // $this->save_data('json_bps_pms_return', array('json_data'=>json_encode($return), 'application'=>'BPS|PMS','action'=>'CREATE_FOLDER'));

    return $return;
  }

  //COLLER UN DOSSIER DANS UN AUTRE DOSSIER
  public function move_file($ticket, $folder_original, $folder_destination)
  {
    // $document = '040a4179-a67f-43bf-890d-2c7ae19b7e42';
    $data = '
      {
        "nodeRefs": [   
                "workspace://SpacesStore/' . $folder_original . '",
        ]
      }';

    // $folder_destination = "9353b275-8d56-4be9-96e2-a537ec4cfaf0";
    $url = "http://" . $this->ip_port_serveur_alfresco . "/alfresco/s/slingshot/doclib/action/move-to/node/workspace/SpacesStore/$folder_destination?alf_ticket=$ticket";

    $return = $this->execute($url, $data);
    // $this->save_data('json_bps_pms_return',['json_data'=>json_encode($return), 'application'=>'BPS|PMS', 'action'=>'MOVE_FILE', 'document'=>$folder_original]);
    return $return;
  }

  // Envoi un fichier a alfresco
  public function send_file_to_alfresco($file_name, $url_file, $token_repertoire, $description)
  {
    $ticket = $this->login();
    $ticket_basic = base64_encode($ticket);


    $cmd = 'curl -X POST -F "filedata=@/var/www/html/pmsv2/uploads/' . $url_file . '/' . $file_name . '" -F "name=' . $description . '" -F "nodeType=cm:content" -F "cm:description=' . $description . '" -F "autoRename=true" -H "Authorization: Basic ' . $ticket_basic . '" http://' . $this->ip_port_serveur_alfresco . '/alfresco/api/-default-/public/alfresco/versions/1/nodes/' . $token_repertoire . '/children';

    $output = shell_exec($cmd);
    $out =  json_decode($output, true);
    $out1 =  $out['entry'];
    // return $out;
    // $result=$out;
    // $results=$out->entry;
    // $resultss=$results->id;
    // print_r($out['entry']['id']);
    // exit();
    // print_r($out);
    // exit();
    // return $out['entry']['id'];
    return $out1['id'];
  }

  //fonction pour recuperer les fichiers generer,scanner et facturation    
  public function envoyer_ficher($code_demande)
  {
    $les_docs = '';

    $document_contenu = $this->CI->Model->getRequete('SELECT pms_documents.ID_DOCUMENT,pms_documents_demande.PATH_DOC,pms_documents.ID_TYPE_DOCUMENT FROM `pms_documents_demande` JOIN pms_documents on pms_documents.ID_DOCUMENT=pms_documents_demande.ID_DOCUMENT WHERE CODE_TRAITEMENT="' . $code_demande . '" ');

    $document_facturation = $this->CI->Model->getRequeteOne('SELECT pms_facturation.PATH_FACTURE,pms_facturation.PATH_QUITTANCE FROM `pms_facturation` WHERE CODE_TRAITEMENT="' . $code_demande . '"  ');

    foreach ($document_contenu as $donnee) {
      $path_file = '';
      if ($donnee['ID_TYPE_DOCUMENT'] == 1) {
        $path_file = 'doc_scanner';
      } else {
        $path_file = 'doc_generer';
      }
      $les_docs .= base_url('uploads/' . $path_file . '/' . $donnee['PATH_DOC']) . '#' . $donnee['ID_DOCUMENT'] . '<>';
    }

    if (!empty($document_facturation['PATH_FACTURE'])) {
      $path_facture = 'doc_generer/' . $document_facturation['PATH_FACTURE'];
      $les_docs .= base_url('uploads/' . $path_facture) . '#1000<>';
    }

    if (!empty($document_facturation['PATH_QUITTANCE'])) {
      $path_facture_quittance = 'doc_scanner/' . $document_facturation['PATH_QUITTANCE'];

      $les_docs .= base_url('uploads/' . $path_facture_quittance) . '#2000<>@';
    }

    return $les_docs;
  }

  // Function pour commence les processus pour un utilisateur
  public function start_process($all_token_file, $province_id)
  {
    $return = array();
    if (!empty($all_token_file)) {
      $all_token = explode(',', $all_token_file);
      $noderef = "";
      $items = "";
      for ($i = 0; $i < count($all_token); $i++) {
        if (!empty($all_token[$i])) {
          $noderef .= '"nodeRef" : "workspace://SpacesStore/' . $all_token[$i] . '",';
          $items .= '"workspace://SpacesStore/' . $all_token[$i] . '",';
        }
      }
      $items = $items . "##";
      $items = str_replace(',##', '', $items);

      $datauser = $this->CI->Model->getRequete("SELECT edrms_user_edrms_circonscriptions.user_name_edrms FROM edrms_repertoire_province_processus JOIN edrms_user_edrms_circonscriptions ON edrms_user_edrms_circonscriptions.circonscriptions_id=edrms_repertoire_province_processus.circonscriptions_id WHERE edrms_repertoire_province_processus.province_id=" . $province_id);
      // $datauser=Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAssoc($sqldatauser);
      $user = '';
      foreach ($datauser as $key) {
        $user .= '"' . $key['user_name_edrms'] . '",';
      }
      $user = $user . "##";
      $user = str_replace(',##', '', $user);
      $data = '{"processDefinitionKey": "activitiParallelReview",
        "variables":
        {
          "bpm_assignees":[' . $user . '],      
          ' . $noderef . '        
          "message": "Please review it"
          },
          "items":
          [
          ' . $items . '
          ]
        }';
      $url = "http://" . $this->ip_port_serveur_alfresco . "/alfresco/api/-default-/public/workflow/versions/1/processes";

      $return = $this->execute($url, $data);
    }
    return $return;
  }


  public function send_metedata_file_bordereau($ticket, $token_file, $author, $numerobordereau, $objectfile, $datedemande, $muneroparcelle, $form_entry_id, $application_id, $title_file, $description_file)
  {
    $data = array(
      "properties" =>
      [
        "cm:author" => $author,
        "cm:title" => $title_file,
        "cm:description" => $description_file,
        "edrms_file_bordereau:numero_file_bordereau" => $numerobordereau,
        "edrms_file_bordereau:objetfile" => $objectfile,
        "edrms_file_bordereau:stysmeenvoie" => "PMS",
        "edrms_file_bordereau:date_demande" => $datedemande,
        "edrms_file_bordereau:numeroparcelle" => $muneroparcelle,
        "edrms_file_bordereau:numerodemande" => $form_entry_id,
        "edrms_file_bordereau:codeapplication" => $application_id
      ]
    );
    $url = "http://" . $this->ip_port_serveur_alfresco . "/alfresco/s/api/metadata/node/workspace/SpacesStore/$token_file?alf_ticket=" . $ticket;
    $return = $this->execute($url, json_encode($data));
    return  $return;
  }


  //format d'archivage pour les donnees correspondant a PMS
  public function send_metedata_file_upload_pms($ticket, $token_file, $code_demande, $title_file, $description_file, $doc_id, $author)
  {
    //REQUETE POUR RECUPERER LES METADONNER D\'UN DOCUMENT

    $metadas_valeur = $this->CI->Model->getRequeteOne('SELECT pms_metadonnees.META_DESC,pms_metadonnees_demandes.VALEUR,pms_metadonnees.VARIABLE_METADONNER_EDRMS FROM `pms_metadonnees_demandes` JOIN pms_metadonnees ON pms_metadonnees.ID_METADONNEES=pms_metadonnees_demandes.ID_METADONNEES JOIN pms_documents on pms_documents.ID_DOCUMENT=pms_metadonnees_demandes.ID_DOCUMENT WHERE pms_metadonnees_demandes.CODE_DEMANDE="' . $code_demande . '" AND pms_metadonnees_demandes.ID_DOCUMENT=' . $doc_id);

    if (!empty($metadas_valeur)) {
      $data = array(
        "properties" =>
        [
          "cm:author" => $author,
          "cm:title" => $title_file,
          "cm:description" => $description_file,
          "" . $metadas_valeur['VARIABLE_METADONNER_EDRMS'] . "" => $metadas_valeur['VALEUR']
        ]
      );
    } else {
      $data = array(
        "properties" =>
        [
          "cm:author" => $author,
          "cm:title" => $title_file,
          "cm:description" => $description_file,
        ]
      );
    }


    $url = "http://" . $this->ip_port_serveur_alfresco . "/alfresco/s/api/metadata/node/workspace/SpacesStore/$token_file?alf_ticket=" . $ticket;

    $return = $this->execute($url, json_encode($data));

    return  $return;
  }



  // Send metadata file ulpoad par un requerant
  public function send_metedata_file_upload($ticket, $token_file, $author, $codefile, $objectfile, $form_entry_id, $datedemande, $application_id, $muneroparcelle, $localite, $superficie, $usage, $title_file, $description_file)
  {
    $data = array(
      "properties" =>
      [
        "cm:author" => $author,
        "cm:title" => $title_file,
        "cm:description" => $description_file,
        "edrms_file_upload:codedocument" => $codefile,
        "edrms_file_upload:objetdocument" => $objectfile,
        "edrms_file_upload:numerodemande" => $form_entry_id,
        "edrms_file_upload:datedemande" => $datedemande,
        "edrms_file_upload:stysmeenvoie" => "PMS",
        "edrms_file_upload:codeapplication" => $application_id,
        "edrms_file_upload:numeroparcelle" => $muneroparcelle,
        "edrms_file_upload:localite" => $localite,
        "edrms_file_upload:surfaceparcelle" => $superficie,
        "edrms_file_upload:usage" => $usage
      ]
    );
    $url = "http://" . $this->ip_port_serveur_alfresco . "/alfresco/s/api/metadata/node/workspace/SpacesStore/$token_file?alf_ticket=" . $ticket;
    $return = $this->execute($url, json_encode($data));
    return  $return;
  }

  /**
   * Cette fonction est chargée de créer des dossiers et de stocker des fichiers pour le morcellement en fonction de la demande de code
   * et du jeton fournis. Elle se connecte à une base de données, récupère des données, les traite, puis envoie les fichiers pour le stockage.
   * Elle renvoie un message indiquant le succès ou l'échec du processus d'archivage des fichiers pour le morcellement.
   */
  public function save_create_folders_stockes_files_morcellement($code_demande, $token)
  {
    // Appelle une méthode pour se connecter à une base de données. 
    $this->connexion();
    $data = $this->envoyer_ficher($code_demande);
    $message = '';

    if (!empty($data)) {
      $donnees_get = str_replace('@', '', $data);
      $get_index_datas = explode('<>', $donnees_get);

      for ($i = 0; $i < count($get_index_datas) - 1; $i++) {
        $tab_doc_id = explode('#', $get_index_datas[$i]);
        $tab_doc_id1 = explode('/', $tab_doc_id[0]);

        $getnom_doc = $this->CI->Model->getOne('pms_documents', ['ID_DOCUMENT' => $tab_doc_id[1]]);
        $desc_nom_doc = (!empty($getnom_doc['DESC_DOCUMENT'])) ? $getnom_doc['DESC_DOCUMENT'] : '';

        $this->send_file($tab_doc_id1[5], $tab_doc_id1[4], $token, 'PMS', $desc_nom_doc, $tab_doc_id[0]);
      }
      $message = '<div class="alert alert-success text-center" id="message">Archivage effectué avec succès</div>';
    } else {
      $message = `<div class="alert alert-danger text-center" id="message">LES FICHIERS SONT INEXISTANT, archivage échoué</div>`;
    }
    return $message;
  }
}
