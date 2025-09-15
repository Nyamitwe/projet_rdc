<?php
// ERIEL MBONIHANKUYE
// eriel@mediabox.bi
//07-11-2022
if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Pms_alfresco_lib
{
  protected $CI;
  private $ip_port_serveur="192.168.0.25";
  private $ip_port_serveur_alfresco="192.168.0.25:1620";

  public function __construct()
  {
    $this->CI = &get_instance();
    $this->CI->load->library('Pms_api');
    $this->CI->load->library('email');
    $this->CI->load->model('Model');
  }

  //Authentication API
  function login()
  {

    $username = "pms";
    $password = "PH#7mj0WNv%Uya8t";
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
  function execute($url, $data = '', $method = 'POST')
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
    curl_setopt($ch, CURLOPT_USERPWD, "admin:2024BbiSkalfr&SC0");
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

  //FONCTION POUR RECUPERER TOKEN DU SOUS-REPERTOIRE
  public function get_parcelle_token($parcelle)
  {
    $parcelle_id = $this->CI->Model->getOne('parcelle_attribution', array('NUMERO_PARCELLE' => $parcelle));

    //recuperer clé primaire de la table edrms_repertoire_processus_parcelle_new
    $recuperer_id = $this->CI->Model->getOne('edrms_repertoire_processus_parcelle_new', array('parcelle_id' => $parcelle_id['ID_PARCELLE'], 'numero_parcelle' => $parcelle_id['NUMERO_PARCELLE']));

    $recuperer_token_sous_repertoire = $this->CI->Model->getOne('edrms_repertoire_processus_sous_repertoire_new', array('dossier_processus_parcelle_id' => $recuperer_id['id']));

    $ticket = $this->login();

    $folder_id = $recuperer_token_sous_repertoire['token_sous_repertoire'];


    $url = "http://" . $this->ip_port_serveur_alfresco . "/alfresco/s/slingshot/doclib2/doclist/documents/node/workspace/SpacesStore/" . $folder_id . "?alf_ticket=" . $ticket;

    return $this->execute($url, '', 'GET');

    // return $recuperer_token_sous_repertoire;
  }

  //GET DATA FORM A FOLDER
  public function get_data_of_folder($folder_id)
  {
    $ticket = $this->login();

    $url = "http://" . $this->ip_port_serveur_alfresco . "/alfresco/s/slingshot/doclib2/doclist/documents/node/workspace/SpacesStore/" . $folder_id . "?alf_ticket=" . $ticket;

    // return $this->execute($ticket);
    return $this->execute($url, '', 'GET');
  }

  //function pour acceder au fichier
  public function get_acces_to_files($get_data_json)
  {
    $get_data_json_metadata = $get_data_json->metadata;

    $get_data_json_parent = $get_data_json_metadata->parent;

    $get_data_json_properties = $get_data_json_parent->properties;

    $get_data_json_itemCounts = $get_data_json_metadata->itemCounts;

    $get_data_json_items = $get_data_json->items;

    $data['ticket'] = $this->login();
    $nombre_dossiers = $get_data_json_itemCounts->folders;
    $nombre_fichiers = $get_data_json_itemCounts->documents;
    $total_donnees = ($nombre_dossiers + $nombre_fichiers);

    $htmls = '<table class="table table-sm table-bordered table-hover table-striped"><thead><th>Nom doc</th><th>View</th></thead><tbody>';

    for ($i = 0; $i < $nombre_fichiers; $i++) {
      $get_data_json_items_array = $get_data_json_items[$i];
      $get_data_json_items_node = $get_data_json_items_array->node;
      $get_data_json_items_node_ref = $get_data_json_items_node->nodeRef;

      //recuperation token
      $get_data_json_items_node_ref_explode = explode('workspace://SpacesStore/', $get_data_json_items_node_ref);
      $get_data_json_items_node_ref_explode_token = $get_data_json_items_node_ref_explode[1];
      $ticket = $this->login();

      //recuperation du nom du fichier 
      $get_data_json_items_properties = $get_data_json_items_node->properties;
      $properties_encode = json_encode($get_data_json_items_properties);
      $properties_resultat = str_replace("cm:", "cm_", $properties_encode);
      $properties_decode = json_decode($properties_resultat);
      $properties_cm_name = $properties_decode->cm_name;

      $htmls .= '<tr><td>' . $properties_cm_name . '</td><td><a onclick=\'geturl("' . $get_data_json_items_node_ref_explode_token . '")\'>Voir</a></td></tr>';
    }

    $htmls .= '</tbody></table>';

    return ($htmls);
  }


  //fonction statique de test pour enregistrer dans le dossier correspondant au token en parametre
  public function enregistrer_fichier($sous_repertoire_new_token = "")
  {
    $code_demande = "INSHYP-0256";
    $document_contenu = $this->CI->Model->getOne('pms_documents_demande', array('CODE_TRAITEMENT' => $code_demande, 'ID_DOCUMENT' => 26));

    $doc_name = $this->CI->Model->getOne('pms_documents', array('ID_DOCUMENT' => $document_contenu['ID_DOCUMENT']));

    $fileName = "INSCRIPTION-HYPHOTECAIRE2022101411395563492e6b24840257.pdf";


    $src = base_url() . "uploads/doc_generer/" . $fileName;

    $token_file = array($token_repertoire = $sous_repertoire_new_token, $fileName, $fileSrc = $src, $deScription = $doc_name['DESC_DOCUMENT'], $numero = "78282828");

    return $token_file;
  }

  //fonction dynamique pour enregistrer dans le dossier correspondant au token en parametre    
  public function save_edrmsFile($token_repertoire, $fileName, $fileSrc, $deScription, $numero)
  {
    $folders =  "workspace://SpacesStore/" . $token_repertoire;

    // $replace=str_replace('-', '', subject)
    $ticket = $this->login();

    $dataFile = array('fileName' => $fileName, 'fileSrc' => $fileSrc, 'deScription' => $deScription, 'numero' => "8899989", 'folders' => $folders, 'ticket' => $ticket);

    if (!empty($dataFile)) {

      $url = "https://app.mediabox.bi/auto_rapport/Api_Edrms/sendFile_request_new";

      if (is_array($dataFile)) {
        $dataFile = json_encode($dataFile);
      }
      $options = stream_context_create(['http' => [
        'method'  => 'POST',
        'header'  => 'Content-type: application/json',
        'content' => $dataFile
      ]]);

      // $response = file_get_contents($url,false,$options);

      $response = $this->execute($url, json_encode($dataFile));


      $out =  json_decode($response);

      // $data_token=$out->idFiles;


      // $data_token_recuperer = explode("SpacesStore/", $data_token);

      // $result=$this->CI->Model->create('edrms_file_inscription',array('nif'=>$token_inscription['nif'],'nom_file'=>$file_name,'desc_file'=>$file_name,'token_file'=>$data_token_recuperer[1],'status_envoye'=>1));

      // return $data_token; 
      return $response;
      // return $return; 
    }
  }


  public function send_filetoday($token_repertoire, $fileName, $fileSrc, $deScription, $numero)
  {
    $ticket = $this->login();

    $ticket_hasher = base64_encode($ticket);

    $cmd = 'curl -X POST -F \'http://".$this->ip_port_serveur_alfresco."/alfresco/s/api/upload?alf_ticket=' . $ticket . '\' \
      --header \'Content-Type:application/json\'\
      --form \'filedata=@"' . $fileSrc . '"\' \
      --form \'filename="' . $fileName . '"\' \
      --form \'destination="' . $fold_token . '"\' \
      --form \'description="' . $deScription . '"\' \
      --form \'autoRename=""\' ';

    // $cmd = 'curl -X POST -F \'filedata=@"'./var/www/html/cpv2.7p2/web/asset_data/form_14345/files/element_2_023e2184dfe7c6efb292ee32829c0f50-387-FACTURE.pdf.'" \'\
    //  -F "name=element_2_023e2184dfe7c6efb292ee32829c0f50-387-FACTURE.pdf"        
    //   -F "autoRename=true"
    //   -H "Authorization: Basic VElDS0VUX2QxMWRhM2QyMTVkZmRhNGQwYjFhMGFmYmNmOWFjODA3Mzg3NDNhMGM=" http://192.168.0.25:1620/alfresco/api/-default-/public/alfresco/versions/1/nodes/-root-/children'
  }

  // Copy to folder
  public function copy_folder_to_alfresco($folder_origine, $folder_destination)
  {
    $ticket = $this->login();
    $ticket_basic = base64_encode($ticket);

    $data = array(
      'targetParentId' => $folder_destination
    );
    
    $url_file = 'http://51.83.236.148:1620/alfresco/api/-default-/public/alfresco/versions/1/nodes/' . $folder_origine . '/copy';

    $data_string = json_encode($data);

    $cmd = 'curl -X POST -H "Content-Type: application/json" -H "Authorization: Basic ' . $ticket_basic . '" -d \'' . $data_string . '\' ' . $url_file;

    $output = shell_exec($cmd);
    $out = json_decode($output, true);
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

  //function qui permet de retourner le contenue d'un dossier dans alfresco
  public function get_folder_content22012024($folder_id)
  {
    $ticket = $this->login();

    $url = "http://" . $this->ip_port_serveur_alfresco . "/alfresco/api/-default-/public/alfresco/versions/1/nodes/" . $folder_id . "/children?alf_ticket=" . $ticket;

    $resultat = $this->execute($url, '', 'GET');

    return $resultat;
  }

  // Function to fetch the content of a folder in Alfresco
  public function get_folder_content($folder_id)
  {
    $ticket = $this->login();
    $baseUrl = "http://" . $this->ip_port_serveur_alfresco . "/alfresco/api/-default-/public/alfresco/versions/1/nodes/";

    $maxItems = 200;  // Maximum number of items per request
    $skipCount = 0;   // Starting index of the results
    $allFolders = array();  // Array to store all the folders

    do {
      $url = $baseUrl . $folder_id . "/children?alf_ticket=" . $ticket . "&maxItems=" . $maxItems . "&skipCount=" . $skipCount;
      $result = $this->execute($url, '', 'GET');

      // Check if the API request was successful
      if (!isset($result->list) || !isset($result->list->entries) || !isset($result->list->pagination)) {
        $errorMessage = "Error: Invalid API response";
        return ['error' => $errorMessage];
      }

      // Extract the folders from the API response and append to the $allFolders array
      $entries = $result->list->entries;
      foreach ($entries as $entry) {
        if ($entry->entry->isFolder) {
          $folder = [
            'id' => $entry->entry->id,
            'name' => $entry->entry->name
          ];
          $allFolders[] = $folder;
        }
      }

      $skipCount += $maxItems;
    } while ($result->list->pagination->totalItems > $skipCount);

    return $allFolders;
  }

  function get_file_extension($file_path)
  {
    // Get the file extension using pathinfo()
    $file_extension = pathinfo($file_path, PATHINFO_EXTENSION);

    // Check if the file is a TIFF file
    if (strtolower($file_extension) === 'tif' || strtolower($file_extension) === 'tiff') {
        return 'tiff';
    }

    // Check if the file has any other extension
    if (!empty($file_extension)) {
        return $file_extension;
    }

    // If no extension is found, try to determine the file type using finfo_open()
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $file_type = finfo_file($finfo, $file_path);
    finfo_close($finfo);

    if (strpos($file_type, 'image/tiff') !== false) {
        return 'tiff';
    } else {
        return 'unknown';
    }
  }

  public  function dossier_initial($numero_parcelle)
  {
    // $this->load->library('pms_api'); // Charger la bibliothèque pms_api
    $ticket = $this->login();
    $htmls = '<div class="alert alert-warning text-center" id="message">Veuillez contactez votre admnistrateur système</div>';
    if (!empty($numero_parcelle)) {
      $data = $this->CI->pms_api->parcelle($numero_parcelle);
      if ($data->success == 1 && !empty($data->data->ALF_TOKEN) && !empty($data->data->ALF_REF_TOKEN)) {
        $url = "http://" . $this->ip_port_serveur_alfresco . "/alfresco/s/slingshot/doclib2/doclist/documents/node/workspace/SpacesStore/" . $data->data->ALF_REF_TOKEN . "?alf_ticket=" . $ticket;
        // $url = "http://".$this->ip_port_serveur_alfresco."/alfresco/s/slingshot/doclib2/doclist/documents/node/workspace/SpacesStore/".$data->data->ALF_REF_TOKEN."?alf_ticket=".$ticket;

        if (!empty($url)) {
          $get_data_json = $this->get_data_of_folder($data->data->ALF_REF_TOKEN);

          $resultat = $this->execute($url, '', 'GET');
          // print_r($resultat);
          // exit();
          if (!empty($resultat) && property_exists($resultat, 'metadata')) {
            $get_data_json_metadata = $resultat->metadata;

            $get_data_json_parent = $get_data_json_metadata->parent;

            $get_data_json_properties = $get_data_json_parent->properties;

            $get_data_json_itemCounts = $get_data_json_metadata->itemCounts;

            $get_data_json_items = $get_data_json->items;


            $nombre_dossiers = $get_data_json_itemCounts->folders;
            $nombre_fichiers = $get_data_json_itemCounts->documents;
            $total_donnees = ($nombre_dossiers + $nombre_fichiers);

            $htmls = '<div style="overflow:scroll;height:200px;width:100%"><table class="table table-sm table-bordered table-hover table-striped">
                <tr>
                <th colspan="2">
                Dossier parcelle:' . $numero_parcelle . '
                </th>
                </tr>
                <tr>
                <th>Nom doc</th>
                <th>View</th>
                </tr>
                <tbody>';

            for ($i = 0; $i < $nombre_fichiers; $i++) {
              $get_data_json_items_array = $get_data_json_items[$i];
              $get_data_json_items_node = $get_data_json_items_array->node;
              $get_data_json_items_node_ref = $get_data_json_items_node->nodeRef;

              //recuperation token
              $get_data_json_items_node_ref_explode = explode('workspace://SpacesStore/', $get_data_json_items_node_ref);
              $get_data_json_items_node_ref_explode_token = $get_data_json_items_node_ref_explode[1];
              $ticket = $this->login();

              //recuperation du nom du fichier 
              $get_data_json_items_properties = $get_data_json_items_node->properties;
              $properties_encode = json_encode($get_data_json_items_properties);
              $properties_resultat = str_replace("cm:", "cm_", $properties_encode);
              $properties_decode = json_decode($properties_resultat);
              $properties_cm_name = $properties_decode->cm_name;
             
              $file_extension = pathinfo($properties_cm_name, PATHINFO_EXTENSION);

              if(!empty($file_extension) && $file_extension != 'tif' && $file_extension != 'TIFF')
              {
               $htmls .= '<tr><td>' . $properties_cm_name . '</td><td><a onclick=\'geturl("' . $get_data_json_items_node_ref_explode_token . '", "'.$file_extension.'")\'>Voir</a></td></tr>';                
              }
              else
              // elseif(empty($file_extension) || ($file_extension == 'tif' || $file_extension == 'TIFF'))
              {
               $htmls .= '<tr><td>' . $properties_cm_name . '</td><td><button id="myBtn'.$i.'" onclick="afficheTiff(\'' . $get_data_json_items_node_ref_explode_token . '\','.$i.')">Voir</button></td></tr>';
              }

            }
            $htmls .= '</tbody></table></div>';
          } elseif (!empty($resultat) && property_exists($resultat, 'status')) {
            $htmls = '<div class="alert alert-warning text-center" id="message">Veuillez contactez votre admnistrateur système</div>';
          } else {
            $htmls = '<div class="alert alert-warning text-center" id="message">Veuillez contactez votre admnistrateur système</div>';
          }
        } else {
          $htmls = '<div class="alert alert-warning text-center" id="message">Resultat de url inexistant</div>';
        }
      }
    } else {
      $htmls = '<div class="alert alert-warning text-center" id="message">Info parcelle inexistant</div>';
    }
    return $htmls;
  }

  public  function recherche_rapide($token_sous_repertoire,$numero_parcelle)
  {
    // $this->load->library('pms_api'); // Charger la bibliothèque pms_api
    $ticket = $this->login();
    $url = "http://" . $this->ip_port_serveur_alfresco . "/alfresco/s/slingshot/doclib2/doclist/documents/node/workspace/SpacesStore/" . $token_sous_repertoire . "?alf_ticket=" . $ticket;

    $htmls = '<div class="alert alert-warning text-center" id="message">Veuillez contactez votre admnistrateur système</div>';
    if (!empty($token_sous_repertoire)) {


          $get_data_json = $this->get_data_of_folder($token_sous_repertoire);

          $resultat = $this->execute($url, '', 'GET');
          // print_r($resultat);
          // exit();
          if (!empty($resultat) && property_exists($resultat, 'metadata')) {
            $get_data_json_metadata = $resultat->metadata;

            $get_data_json_parent = $get_data_json_metadata->parent;

            $get_data_json_properties = $get_data_json_parent->properties;

            $get_data_json_itemCounts = $get_data_json_metadata->itemCounts;

            $get_data_json_items = $get_data_json->items;


            $nombre_dossiers = $get_data_json_itemCounts->folders;
            $nombre_fichiers = $get_data_json_itemCounts->documents;
            $total_donnees = ($nombre_dossiers + $nombre_fichiers);

            $htmls = '<div style="overflow:scroll;height:200px;width:100%"><table class="table table-sm table-bordered table-hover table-striped">
                <tr>
                <th colspan="2">
                Dossier parcelle:' . $numero_parcelle . '
                </th>
                </tr>
                <tr>
                <th>Nom doc</th>
                <th>View</th>
                </tr>
                <tbody>';

            for ($i = 0; $i < $nombre_fichiers; $i++) {
              $get_data_json_items_array = $get_data_json_items[$i];
              $get_data_json_items_node = $get_data_json_items_array->node;
              $get_data_json_items_node_ref = $get_data_json_items_node->nodeRef;

              //recuperation token
              $get_data_json_items_node_ref_explode = explode('workspace://SpacesStore/', $get_data_json_items_node_ref);
              $get_data_json_items_node_ref_explode_token = $get_data_json_items_node_ref_explode[1];
              $ticket = $this->login();

              //recuperation du nom du fichier 
              $get_data_json_items_properties = $get_data_json_items_node->properties;
              $properties_encode = json_encode($get_data_json_items_properties);
              $properties_resultat = str_replace("cm:", "cm_", $properties_encode);
              $properties_decode = json_decode($properties_resultat);
              $properties_cm_name = $properties_decode->cm_name;
             
              $file_extension = pathinfo($properties_cm_name, PATHINFO_EXTENSION);

              if(!empty($file_extension) && $file_extension != 'tif' && $file_extension != 'TIFF')
              {
               $htmls .= '<tr><td>' . $properties_cm_name . '</td><td><a onclick=\'geturl("' . $get_data_json_items_node_ref_explode_token . '", "'.$file_extension.'")\'>Voir</a></td></tr>';                
              }
              else
              // elseif(empty($file_extension) || ($file_extension == 'tif' || $file_extension == 'TIFF'))
              {
               $htmls .= '<tr><td>' . $properties_cm_name . '</td><td><button id="myBtn'.$i.'" onclick="afficheTiff(\'' . $get_data_json_items_node_ref_explode_token . '\','.$i.')">Voir</button></td></tr>';
              }

            }
            $htmls .= '</tbody></table></div>';
          } elseif (!empty($resultat) && property_exists($resultat, 'status')) {
            $htmls = '<div class="alert alert-warning text-center" id="message">Veuillez contactez votre admnistrateur système</div>';
          } else {
            $htmls = '<div class="alert alert-warning text-center" id="message">Veuillez contactez votre admnistrateur système</div>';
          }
        
      
    } else {
      $htmls = '<div class="alert alert-warning text-center" id="message">Info parcelle inexistant</div>';
    }
    return $htmls;
  }


  //FONCTION POUR EFFECTUER LA DEMANDE DU DOSSIER INITIAL    
  public function dossier_inital($num_parcelle)
  {
    $parcelle_province = $this->CI->Model->getOne('parcelle_attribution', array('NUMERO_PARCELLE' => $num_parcelle));

    $token_sous_repertoire = '';
    $message = '';
    $htmls = '';
    $get_data_json_items_properties = '';
    $resultat = '';


    if (!empty($num_parcelle))
    // if(!empty($parcelle_province)) 
    {
      $token_sous_repertoire = $this->CI->Model->getOne('edrms_repertoire_processus_sous_repertoire_new', array('parcelle_id' => $parcelle_province['ID_PARCELLE'], 'statut_actualisation' => 1));


      // print_r($token_sous_repertoire);
      // exit();


      if (!empty($token_sous_repertoire)) {
        $folder_id = $token_sous_repertoire['token_sous_repertoire'];

        $ticket = $this->login();

        $url = "http://" . $this->ip_port_serveur_alfresco . "/alfresco/s/slingshot/doclib2/doclist/documents/node/workspace/SpacesStore/" . $token_sous_repertoire['token_sous_repertoire'] . "?alf_ticket=" . $ticket;

        if (!empty($url)) {
          $get_data_json = $this->get_data_of_folder($folder_id);

          $resultat = $this->execute($url, '', 'GET');
          // print_r($resultat);
          // exit();
          if (!empty($resultat) && property_exists($resultat, 'metadata')) {
            $get_data_json_metadata = $resultat->metadata;

            $get_data_json_parent = $get_data_json_metadata->parent;

            $get_data_json_properties = $get_data_json_parent->properties;

            $get_data_json_itemCounts = $get_data_json_metadata->itemCounts;

            $get_data_json_items = $get_data_json->items;


            $nombre_dossiers = $get_data_json_itemCounts->folders;
            $nombre_fichiers = $get_data_json_itemCounts->documents;
            $total_donnees = ($nombre_dossiers + $nombre_fichiers);

            $htmls = '<div style="overflow:scroll;height:200px;width:100%"><table class="table table-sm table-bordered table-hover table-striped">
                <tr>
                <th colspan="2">
                Dossier parcelle:' . $num_parcelle . '
                </th>
                </tr>
                <tr>
                <th>Nom doc</th>
                <th>View</th>
                </tr>
                <tbody>';

            for ($i = 0; $i < $nombre_fichiers; $i++) {
              $get_data_json_items_array = $get_data_json_items[$i];
              $get_data_json_items_node = $get_data_json_items_array->node;
              $get_data_json_items_node_ref = $get_data_json_items_node->nodeRef;

              //recuperation token
              $get_data_json_items_node_ref_explode = explode('workspace://SpacesStore/', $get_data_json_items_node_ref);
              $get_data_json_items_node_ref_explode_token = $get_data_json_items_node_ref_explode[1];
              $ticket = $this->login();

              //recuperation du nom du fichier 
              $get_data_json_items_properties = $get_data_json_items_node->properties;
              $properties_encode = json_encode($get_data_json_items_properties);
              $properties_resultat = str_replace("cm:", "cm_", $properties_encode);
              $properties_decode = json_decode($properties_resultat);
              $properties_cm_name = $properties_decode->cm_name;

              $htmls .= '<tr><td>' . $properties_cm_name . '</td><td><a onclick=\'geturl("' . $get_data_json_items_node_ref_explode_token . '")\'>Voir</a></td></tr>';
            }
            $htmls .= '</tbody></table></div>';
          } elseif (!empty($resultat) && property_exists($resultat, 'status')) {
            $htmls = '<div class="alert alert-warning text-center" id="message">Veuillez contactez votre admnistrateur système</div>';
          } else {
            $htmls = '<div class="alert alert-warning text-center" id="message">Veuillez contactez votre admnistrateur système</div>';
          }
        } else {
          $htmls = '<div class="alert alert-warning text-center" id="message">Resultat de url inexistant</div>';
        }
      } else {
        $htmls = '<div class="alert alert-warning text-center" id="message">TOKEN INEXISTANT</div>';
      }
    } else {
      $htmls = '<div class="alert alert-warning text-center" id="message">Info parcelle inexistant</div>';
    }
    return $htmls;
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

  //fonction qui fait l'archivage pour les process AU NIVEAU DE EDRMS:HYPOTHEQUE,DEMANDE INFO/SERVICE,ATTESTATION,REQUISITION D'EXPERT
  public function archivage_fichier($code_demande)
  {
    $donnees = $this->envoyer_ficher($code_demande);

    $desc_nom_doc = '';
    $resultat = '';
    $ticket = $this->login();

    // $donnees_get  = explode('@', $donnees);

    $message = '';
    $message1 = '';
    $data_token = '';
    $token_repertoire = '';
    $id_parcelle = '';
    $code_de_parcelle = '';
    $all_token_file = '';
    if (!empty($donnees)) {
      $code_de_parcelle = $this->CI->Model->getOne('pms_traitement_demande', array('CODE_DEMANDE' => $code_demande));




      if (!empty($code_de_parcelle)) {
        $id_parcelle = $this->CI->Model->getOne('parcelle_attribution', array('NUMERO_PARCELLE' => $code_de_parcelle['NUMERO_PARCELLE'], 'STATUT_ID' => 3));
        if (!empty($id_parcelle)) {

          $id_processus_parcelle = $this->CI->Model->getRequeteOne("SELECT id,dossiers_processus_province_id,parcelle_id,numero_parcelle,nom_repertoire_parcelle,token_dossiers_parcelle_processus,menu_id,dossier_id FROM edrms_repertoire_processus_parcelle_new WHERE numero_parcelle='" . $id_parcelle['NUMERO_PARCELLE'] . "' ORDER BY id DESC");

          $token_repertoire = $this->CI->Model->getOne('edrms_repertoire_processus_sous_repertoire_new', array('dossier_processus_parcelle_id' => $id_processus_parcelle['id'], 'statut_actualisation' => 1));

          // $token_repertoire=$this->CI->Model->getOne('edrms_repertoire_processus_sous_repertoire_new',array('parcelle_id'=>$id_parcelle['ID_PARCELLE'],'statut_actualisation'=>1)); 




          if (!empty($token_repertoire)) {

            $donnees_get = str_replace('@', '', $donnees);
            $index_donnees_get = explode('<>', $donnees_get);
            // print_r($index_donnees_get);
            // exit();
            for ($j = 0; $j < count($index_donnees_get) - 1; $j++) {
              $tab_doc_id = $index_donnees_get[$j];
              $tab_doc_id = explode('#', $tab_doc_id);
              $tab_doc_id1 = explode('/', $tab_doc_id[0]);


              $getnom_doc = $this->CI->Model->getOne('pms_documents', ['ID_DOCUMENT' => $tab_doc_id[1]]);


              if (empty($getnom_doc['DESC_DOCUMENT'])) {
                $desc_nom_doc = '';

                // echo 'Path : '.$tab_doc_id[0].' / Id doc : PROFORMA / BORDEREAU <br>';
              } else {
                $desc_nom_doc = $getnom_doc['DESC_DOCUMENT'];

                // echo 'Path : '.$tab_doc_id[0].' / Id doc : '.$desc_nom_doc.' <br>';

              }

              // print_r($tab_doc_id1);
              // exit();

              // $message1=$this->save_edrmsFile($token_repertoire['token_sous_repertoire'],$tab_doc_id1[5],$tab_doc_id[0],$desc_nom_doc,$numero=''); 

              //  $send_file_to_alfresco='file_name: '.$tab_doc_id1[6].'url_file '.$tab_doc_id1[5].'token repertoire'.$token_repertoire['token_sous_repertoire'].' description '.$desc_nom_doc,$ticket)
              //  $send_file_to_alfresco='file_name: '.$desc_nom_doc.' url_file: '.$tab_doc_id1[5].' token repertoire'.$token_repertoire['token_sous_repertoire'].' description '.$desc_nom_doc;
              //  print_r($send_file_to_alfresco);
              //  exit();

              // $message1=$this->send_file_to_alfresco($tab_doc_id1[6],$tab_doc_id1[5],$token_repertoire['token_sous_repertoire'],$tab_doc_id1[6]);
              $message1 = $this->send_file_to_alfresco($tab_doc_id1[5], $tab_doc_id1[4], $token_repertoire['token_sous_repertoire'], $desc_nom_doc);

              $all_token_file .= $message1 . ',';
              // $message2 =  json_decode($message1);

              // echo "<pre>";
              // print_r($tab_doc_id);
              // exit();
              // echo "</pre>";

              // $data_token=$message2->idFiles;


              // $data_token_recuperer = explode("workspace://SpacesStore/", $data_token);




              if ($message1 != '')
              // if($data_token_recuperer[1]!='')
              {

                //pour verifcation si ID DOCUMENT EST ENVOYER ET SAVOIR SI C'EST SCANNER OU GENERER
                if ($tab_doc_id[1] != 1000 && $tab_doc_id[1] != 2000) {
                  $getnom_doc = $this->CI->Model->getOne('pms_documents', ['ID_DOCUMENT' => $tab_doc_id[1]]);

                  // echo "<pre>";
                  // print_r($getnom_doc);
                  // exit();
                  // echo "</pre>";

                  if ($getnom_doc['ID_TYPE_DOCUMENT'] == 1) {
                    // $message='doc_scanner'; 
                    $checking_meta_doc = $this->CI->Model->getRequeteOne('SELECT ID_DOCUMENT FROM `pms_metadonnee_documents` WHERE pms_metadonnee_documents.ID_DOCUMENT=' . $tab_doc_id[1]);

                    // echo "<pre>";
                    // print_r($checking_meta_doc);
                    // exit();
                    // echo "</pre>";

                    if (!empty($checking_meta_doc)) {
                      //Send metadata uploaded par un requerant

                      $resultat = $this->CI->Model->getRequeteOne('SELECT pms_documents_demande.ID_DOCUMENT_DEMANDE,pms_documents.ID_DOCUMENT,pms_documents.DESC_DOCUMENT, pms_documents_demande.CODE_TRAITEMENT, pms_documents_demande.PATH_DOC, pms_documents_demande.DATE_INSERTION FROM pms_documents_demande JOIN pms_documents on pms_documents.ID_DOCUMENT=pms_documents_demande.ID_DOCUMENT WHERE pms_documents_demande.PATH_DOC="' . $tab_doc_id1[5] . '" AND pms_documents_demande.CODE_TRAITEMENT="' . $code_demande . '" ');

                      // echo "<pre>5";
                      // print_r($resultat);
                      // exit();
                      // echo "</pre>";

                      if (!empty($resultat)) {
                        $token_file = $message1;

                        $title_file = !empty($resultat['DESC_DOCUMENT']) ? $resultat['DESC_DOCUMENT'] : '';

                        $description_file = !empty($resultat['DESC_DOCUMENT']) ? $resultat['DESC_DOCUMENT'] : '';

                        $doc_id = $tab_doc_id[1];

                        $author = '';

                        $this->send_metedata_file_upload_pms($ticket, $token_file, $code_demande, $title_file, $description_file, $doc_id, $author);
                      }
                    } else {
                      $resultat = $this->CI->Model->getRequeteOne('SELECT pms_documents_demande.ID_DOCUMENT_DEMANDE, pms_type_documents.DESCRIPTION, pms_documents.ID_DOCUMENT, pms_documents.DESC_DOCUMENT, pms_documents_demande.CODE_TRAITEMENT, pms_documents_demande.PATH_DOC, pms_documents_demande.DATE_INSERTION FROM pms_documents_demande JOIN pms_documents on pms_documents.ID_DOCUMENT=pms_documents_demande.ID_DOCUMENT JOIN pms_type_documents on pms_type_documents.ID_TYPE_DOCUMENT=pms_documents.ID_TYPE_DOCUMENT WHERE pms_documents_demande.PATH_DOC="' . $tab_doc_id1[5] . '" AND pms_documents_demande.CODE_TRAITEMENT="' . $code_demande . '" ');

                      // echo "<pre>1";
                      // print_r($resultat);
                      // echo "</pre>";
                      // exit();

                      if (!empty($resultat)) {
                        $information_demande = $this->CI->Model->getOne('pms_traitement_demande', array('CODE_DEMANDE' => $code_demande));



                        $information_parcelle = $this->CI->Model->getOne('parcelle_attribution', array('NUMERO_PARCELLE' => $information_demande['NUMERO_PARCELLE'], 'STATUT_ID' => 3));

                        $information_localite = $this->CI->Model->getRequeteOne('SELECT provinces.PROVINCE_NAME,communes.COMMUNE_NAME,collines.COLLINE_NAME,pms_zones.ZONE_NAME FROM `parcelle_attribution` JOIN provinces on provinces.PROVINCE_ID=parcelle_attribution.PROVINCE_ID JOIN communes on communes.COMMUNE_ID=parcelle_attribution.COMMUNE_ID JOIN collines on collines.COLLINE_ID=parcelle_attribution.COLLINE_ID JOIN pms_zones on pms_zones.ZONE_ID=parcelle_attribution.ZONE_ID where parcelle_attribution.NUMERO_PARCELLE="' . $information_demande["NUMERO_PARCELLE"] . '" AND STATUT_ID=3');

                        $recuperation_desc_usage = $this->CI->Model->getOne('usager_propriete', array('ID_USAGER_PROPRIETE' => $information_parcelle['USAGE_ID']));

                        $recuperation_desc_process = $this->CI->Model->getOne('pms_process', array('PROCESS_ID' => $information_demande['PROCESS_ID']));

                        // echo "<pre>4";
                        // print_r($information_demande);
                        // echo "<br>6";                          
                        // print_r($information_parcelle);
                        // echo "<br>7";                                                    
                        // print_r($recuperation_desc_usage);
                        // echo "<br>8"; 
                        // print_r($recuperation_desc_process);                                                                            
                        // echo "</pre>";
                        // exit();

                        $author = '';
                        $codefile = !empty($resultat['ID_DOCUMENT_DEMANDE']) ? $resultat['ID_DOCUMENT_DEMANDE'] : '';
                        $token_file = $message1;
                        $objectfile = !empty($recuperation_desc_process) ? $recuperation_desc_process['DESCRIPTION_PROCESS'] : '';
                        $datedemande = !empty($resultat['DATE_INSERTION']) ? $resultat['DATE_INSERTION'] : '';
                        $muneroparcelle = !empty($information_demande['NUMERO_PARCELLE']) ? $information_demande['NUMERO_PARCELLE'] : '';

                        $form_entry_id = !empty($information_demande['ID_TRAITEMENT_DEMANDE']) ? $information_demande['ID_TRAITEMENT_DEMANDE'] : '';

                        $application_id = !empty($information_demande['CODE_DEMANDE']) ? $information_demande['CODE_DEMANDE']  : '';

                        $title_file = !empty($resultat['DESC_DOCUMENT']) ? $resultat['DESC_DOCUMENT'] : '';

                        $localite = $information_localite['PROVINCE_NAME'] . '-' . $information_localite['COMMUNE_NAME'] . '-' . $information_localite['ZONE_NAME'] . '-' . $information_localite['COLLINE_NAME'];

                        $superficie = $information_parcelle['SUPERFICIE_HA'] . '-' . $information_parcelle['SUPERFICIE_ARE'] . '-' . $information_parcelle['SUPERFICIE_CA'];

                        $usage = !empty($recuperation_desc_usage['DESCRIPTION_USAGER_PROPRIETE']) ? $recuperation_desc_usage['DESCRIPTION_USAGER_PROPRIETE'] : '';

                        $description_file = !empty($resultat['DESC_DOCUMENT']) ? $resultat['DESC_DOCUMENT'] : '';

                        // Send metadata uploaded par un requerant
                        $this->send_metedata_file_upload($ticket, $token_file, $author, $codefile, $objectfile, $form_entry_id, $datedemande, $application_id, $muneroparcelle, $localite, $superficie, $usage, $title_file, $description_file);
                      }
                    }
                  } else {
                    $message = 'doc_generer';
                  }
                } //ici dans le cadre ou c'est une facture proforma et que id document inexistant
                elseif ($tab_doc_id[1] == 1000) {
                  $resultat = $this->CI->Model->getRequeteOne('SELECT sf_guard_user_profile.fullname,pms_facturation.MENTION,pms_facturation.DATE_PAIEMENT,pms_traitement_demande.NUMERO_PARCELLE,pms_facturation.CODE_TRAITEMENT,pms_traitement_demande.ID_TRAITEMENT_DEMANDE,pms_facturation.DATE_INSERTION  FROM pms_facturation JOIN pms_traitement_demande on pms_traitement_demande.CODE_DEMANDE=pms_facturation.CODE_TRAITEMENT JOIN sf_guard_user_profile on sf_guard_user_profile.user_id=pms_traitement_demande.ID_REQUERANT WHERE 1 AND PATH_FACTURE="' . $tab_doc_id1[5] . '" AND pms_traitement_demande.CODE_DEMANDE="' . $code_demande . '" ');

                  // echo "<pre>2";
                  // print_r($resultat);
                  // echo "</pre>";
                  // exit();

                  if (!empty($resultat)) {
                    $author = !empty($resultat['fullname']) ? $resultat['fullname'] : '';
                    $token_file = $message1;
                    $numerobordereau = !empty($resultat['MENTION']) ? $resultat['MENTION'] : '';
                    $objectfile = !empty($resultat['MENTION']) ? $resultat['MENTION'] : '';
                    $datedemande = !empty($resultat['DATE_INSERTION']) ? $resultat['DATE_INSERTION'] : '';
                    $muneroparcelle = !empty($resultat['NUMERO_PARCELLE']) ? $resultat['NUMERO_PARCELLE'] : '';
                    $form_entry_id = !empty($resultat['ID_TRAITEMENT_DEMANDE']) ? $resultat['ID_TRAITEMENT_DEMANDE'] : '';
                    $application_id = !empty($resultat['CODE_TRAITEMENT']) ? $resultat['CODE_TRAITEMENT'] : '';
                    $title_file = 'PROFORMA';
                    $description_file = 'LE PROFORMA APPARTENANT AU REQUERANT';


                    // Send metadata bordereau un requerant
                    $this->send_metedata_file_bordereau($ticket, $token_file, $author, $numerobordereau, $objectfile, $datedemande, $muneroparcelle, $form_entry_id, $application_id, $title_file, $description_file);
                  }
                } //ici c'est le bloc reserver au bordereau
                elseif ($tab_doc_id[1] == 2000) {
                  $resultat = $this->CI->Model->getRequeteOne('SELECT sf_guard_user_profile.fullname,pms_facturation.NUMERO_QUITTANCE,pms_facturation.DATE_PAIEMENT,pms_traitement_demande.NUMERO_PARCELLE,pms_facturation.CODE_TRAITEMENT,pms_traitement_demande.ID_TRAITEMENT_DEMANDE,pms_facturation.MENTION  FROM pms_facturation JOIN pms_traitement_demande on pms_traitement_demande.CODE_DEMANDE=pms_facturation.CODE_TRAITEMENT JOIN sf_guard_user_profile on sf_guard_user_profile.user_id=pms_traitement_demande.ID_REQUERANT WHERE 1 AND PATH_QUITTANCE="' . $tab_doc_id1[5] . '" AND pms_traitement_demande.CODE_DEMANDE="' . $code_demande . '" ');

                  // echo "<pre>3";
                  // print_r($resultat);
                  // echo "</pre>";
                  // exit();

                  if (!empty($resultat)) {
                    $author = !empty($resultat['fullname']) ? $resultat['fullname'] : '';
                    $token_file = $message1;
                    $numerobordereau = !empty($resultat['NUMERO_QUITTANCE']) ? $resultat['NUMERO_QUITTANCE'] : '';
                    $objectfile = !empty($resultat['MENTION']) ? $resultat['MENTION'] : '';
                    $datedemande = !empty($resultat['DATE_PAIEMENT']) ? $resultat['DATE_PAIEMENT'] : '';
                    $muneroparcelle = !empty($resultat['NUMERO_PARCELLE']) ? $resultat['NUMERO_PARCELLE'] : '';
                    $form_entry_id = !empty($resultat['ID_TRAITEMENT_DEMANDE']) ? $resultat['ID_TRAITEMENT_DEMANDE'] : '';
                    $application_id = !empty($resultat['CODE_TRAITEMENT']) ? $resultat['CODE_TRAITEMENT'] : '';
                    $title_file = 'BORDERAU';
                    $description_file = 'UN BORDERAU DE PAIEMENT';


                    // Send metadata bordereau un requerant
                    $this->send_metedata_file_bordereau($ticket, $token_file, $author, $numerobordereau, $objectfile, $datedemande, $muneroparcelle, $form_entry_id, $application_id, $title_file, $description_file);
                  }
                } else {
                  $message = 'Aucune metadata archiver suite au manque de ficher';
                }
              } else {
                $message = 'aucun token retourner';
              }
            }

            $message = '<div class="alert alert-success text-center" id="message">Archivage éffectué avec succés</div>';
            $this->start_process($all_token_file, $id_parcelle['PROVINCE_ID']);
          } else {
            $message = '<div class="alert alert-danger text-center" id="message">LE TOKEN EST INEXISTANT,archivage echoué</div>';
          }
        } else {
          $message = '<div class="alert alert-danger text-center" id="message">Les informations de la parcelle n\'existe pas dans la table,archivage echoué</div>';
        }
      } else {
        $message = '<div class="alert alert-danger text-center" id="message">Aucune donnée existe dans la table de traitement sur  ce code,archivage echoué</div>';
      }
    } else {
      $message = '<div class="alert alert-danger text-center" id="message">Aucun fichier existant,archivage echoué</div>';
    }
    return $message;

    // return $message1;
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


  //MOVE COPY OF FILE
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



  //fonction qui fait l'archivage pour les process aun niveau de EDRMS:ACTUALISATION A ET B
  public function archivage_actualisation_fichier($code_demande)
  {
    $donnees = $this->envoyer_ficher($code_demande);

    // print_r($donnees);
    // exit();
    $ticket = $this->login();
    $desc_nom_doc = '';
    $resultat = '';

    // $donnees_get  = explode('@', $donnees);

    $message = '';
    $message1 = '';
    $data_token = '';
    $token_repertoire = '';
    $id_parcelle = '';
    $code_de_parcelle = '';
    $token_repertoire = '';
    $all_token_file = '';
    if (!empty($donnees)) {
      $code_de_parcelle = $this->CI->Model->getOne('pms_traitement_demande', array('CODE_DEMANDE' => $code_demande));


      if (!empty($code_de_parcelle)) {
        $id_parcelle = $this->CI->Model->getOne('parcelle_attribution', array('NUMERO_PARCELLE' => $code_de_parcelle['NUMERO_PARCELLE'], 'STATUT_ID' => 3));


        if (!empty($id_parcelle)) {

          $id_processus_parcelle = $this->CI->Model->getRequeteOne("SELECT id,dossiers_processus_province_id,parcelle_id,numero_parcelle,nom_repertoire_parcelle,token_dossiers_parcelle_processus,menu_id,dossier_id FROM edrms_repertoire_processus_parcelle_new WHERE numero_parcelle='" . $id_parcelle['NUMERO_PARCELLE'] . "' ORDER BY id DESC");

          $token_repertoire = $this->CI->Model->getOne('edrms_repertoire_processus_sous_repertoire_new', array('dossier_processus_parcelle_id' => $id_processus_parcelle['id'], 'statut_actualisation' => 1));


          if (!empty($token_repertoire)) {
            $donnees_get = str_replace('@', '', $donnees);
            $index_donnees_get = explode('<>', $donnees_get);
            for ($j = 0; $j < count($index_donnees_get) - 1; $j++) {
              $tab_doc_id = $index_donnees_get[$j];
              $tab_doc_id = explode('#', $tab_doc_id);
              $tab_doc_id1 = explode('/', $tab_doc_id[0]);


              $getnom_doc = $this->CI->Model->getOne('pms_documents', ['ID_DOCUMENT' => $tab_doc_id[1]]);


              if (empty($getnom_doc['DESC_DOCUMENT'])) {
                $desc_nom_doc = '';

                // echo 'Path : '.$tab_doc_id[0].' / Id doc : PROFORMA / BORDEREAU <br>';

              } else {
                $desc_nom_doc = $getnom_doc['DESC_DOCUMENT'];

                // echo 'Path : '.$tab_doc_id[0].' / Id doc : '.$desc_nom_doc.' <br>';

              }

              // $message1=$this->save_edrmsFile($token_repertoire['token_sous_repertoire'],$tab_doc_id1[5],$tab_doc_id[0],$desc_nom_doc,$numero=''); 

              //  $message1=$this->send_file_to_alfresco($tab_doc_id1[6],$tab_doc_id1[5],$token_repertoire['token_sous_repertoire'],$tab_doc_id1[6]);
              $message1 = $this->send_file_to_alfresco($tab_doc_id1[5], $tab_doc_id1[4], $token_repertoire['token_sous_repertoire'], $desc_nom_doc);

              $all_token_file .= $message1 . ',';

              // $message2 =  json_decode($message1);



              // $data_token=$message2->idFiles;



              // $data_token_recuperer = explode("workspace://SpacesStore/", $data_token);


              if ($message1 != '')
              // if($data_token_recuperer[1]!='')
              {

                //pour verifcation si ID DOCUMENT EST ENVOYER ET SAVOIR SI C'EST SCANNER OU GENERER
                if ($tab_doc_id[1] != 1000 && $tab_doc_id[1] != 2000) {
                  $getnom_doc = $this->CI->Model->getOne('pms_documents', ['ID_DOCUMENT' => $tab_doc_id[1]]);

                  // echo "<pre>";
                  // print_r($getnom_doc);
                  // exit();
                  // echo "</pre>";

                  if ($getnom_doc['ID_TYPE_DOCUMENT'] == 1) {
                    // $message='doc_scanner';
                    // $message='doc_scanner'; 
                    $checking_meta_doc = $this->CI->Model->getRequeteOne('SELECT ID_DOCUMENT FROM `pms_metadonnee_documents` WHERE pms_metadonnee_documents.ID_DOCUMENT=' . $tab_doc_id[1]);

                    if (!empty($checking_meta_doc)) {
                      //Send metadata uploaded par un requerant

                      $resultat = $this->CI->Model->getRequeteOne('SELECT pms_documents_demande.ID_DOCUMENT_DEMANDE,pms_documents.ID_DOCUMENT,pms_documents.DESC_DOCUMENT, pms_documents_demande.CODE_TRAITEMENT, pms_documents_demande.PATH_DOC, pms_documents_demande.DATE_INSERTION FROM pms_documents_demande JOIN pms_documents on pms_documents.ID_DOCUMENT=pms_documents_demande.ID_DOCUMENT WHERE pms_documents_demande.PATH_DOC="' . $tab_doc_id1[5] . '" AND pms_documents_demande.CODE_TRAITEMENT="' . $code_demande . '" ');

                      if (!empty($resultat)) {
                        $token_file = $message1;

                        $title_file = $resultat['DESC_DOCUMENT'];

                        $description_file = !empty($resultat['DESC_DOCUMENT']) ? $resultat['DESC_DOCUMENT'] : '';

                        $doc_id = $tab_doc_id[1];

                        $author = '';

                        $this->send_metedata_file_upload_pms($ticket, $token_file, $code_demande, $title_file, $description_file, $doc_id, $author);
                      }
                    } else {
                      $resultat = $this->CI->Model->getRequeteOne('SELECT pms_documents_demande.ID_DOCUMENT_DEMANDE, pms_type_documents.DESCRIPTION, pms_documents.ID_DOCUMENT, pms_documents.DESC_DOCUMENT, pms_documents_demande.CODE_TRAITEMENT, pms_documents_demande.PATH_DOC, pms_documents_demande.DATE_INSERTION FROM pms_documents_demande JOIN pms_documents on pms_documents.ID_DOCUMENT=pms_documents_demande.ID_DOCUMENT JOIN pms_type_documents on pms_type_documents.ID_TYPE_DOCUMENT=pms_documents.ID_TYPE_DOCUMENT WHERE pms_documents_demande.PATH_DOC="' . $tab_doc_id1[5] . '" AND pms_documents_demande.CODE_TRAITEMENT="' . $code_demande . '" ');

                      if (!empty($resultat)) {
                        $information_demande = $this->CI->Model->getOne('pms_traitement_demande', array('CODE_DEMANDE' => $code_demande));

                        $information_parcelle = $this->CI->Model->getOne('parcelle_attribution', array('NUMERO_PARCELLE' => $information_demande['NUMERO_PARCELLE'], 'STATUT_ID' => 3));

                        $information_localite = $this->CI->Model->getRequeteOne('SELECT provinces.PROVINCE_NAME,communes.COMMUNE_NAME,collines.COLLINE_NAME,pms_zones.ZONE_NAME FROM `parcelle_attribution` JOIN provinces on provinces.PROVINCE_ID=parcelle_attribution.PROVINCE_ID JOIN communes on communes.COMMUNE_ID=parcelle_attribution.COMMUNE_ID JOIN collines on collines.COLLINE_ID=parcelle_attribution.COLLINE_ID JOIN pms_zones on pms_zones.ZONE_ID=parcelle_attribution.ZONE_ID where parcelle_attribution.NUMERO_PARCELLE="' . $information_demande["NUMERO_PARCELLE"] . '" AND STATUT_ID=3');

                        $recuperation_desc_usage = $this->CI->Model->getOne('usager_propriete', array('ID_USAGER_PROPRIETE' => $information_parcelle['USAGE_ID']));

                        $recuperation_desc_process = $this->CI->Model->getOne('pms_process', array('PROCESS_ID' => $information_demande['PROCESS_ID']));


                        $author = '';
                        $codefile = !empty($resultat['ID_DOCUMENT_DEMANDE']) ? $resultat['ID_DOCUMENT_DEMANDE'] : '';
                        $token_file = $message1;
                        $objectfile = !empty($recuperation_desc_process) ? $recuperation_desc_process['DESCRIPTION_PROCESS'] : '';
                        $datedemande = !empty($resultat['DATE_INSERTION']) ? $resultat['DATE_INSERTION'] : '';
                        $muneroparcelle = $information_demande['NUMERO_PARCELLE'];

                        $form_entry_id = $information_demande['ID_TRAITEMENT_DEMANDE'];

                        $application_id = $information_demande['CODE_DEMANDE'];

                        $title_file = $resultat['DESC_DOCUMENT'];

                        $localite = $information_localite['PROVINCE_NAME'] . '-' . $information_localite['COMMUNE_NAME'] . '-' . $information_localite['ZONE_NAME'] . '-' . $information_localite['COLLINE_NAME'];

                        $superficie = $information_parcelle['SUPERFICIE_HA'] . '-' . $information_parcelle['SUPERFICIE_ARE'] . '-' . $information_parcelle['SUPERFICIE_CA'];

                        $usage = !empty($recuperation_desc_usage['DESCRIPTION_USAGER_PROPRIETE']) ? $recuperation_desc_usage['DESCRIPTION_USAGER_PROPRIETE'] : '';

                        $description_file = !empty($resultat['DESC_DOCUMENT']) ? $resultat['DESC_DOCUMENT'] : '';

                        //Send metadata uploaded par un requerant
                        $this->send_metedata_file_upload($ticket, $token_file, $author, $codefile, $objectfile, $form_entry_id, $datedemande, $application_id, $muneroparcelle, $localite, $superficie, $usage, $title_file, $description_file);
                      }
                    }
                  } else {
                    $message = 'doc_generer';
                  }
                } //ici dans le cadre ou c'est une facture proforma et que id document inexistant
                elseif ($tab_doc_id[1] == 1000) {
                  $resultat = $this->CI->Model->getRequeteOne('SELECT sf_guard_user_profile.fullname,pms_facturation.MENTION,pms_facturation.DATE_PAIEMENT,pms_traitement_demande.NUMERO_PARCELLE,pms_facturation.CODE_TRAITEMENT,pms_traitement_demande.ID_TRAITEMENT_DEMANDE,pms_facturation.DATE_INSERTION  FROM pms_facturation JOIN pms_traitement_demande on pms_traitement_demande.CODE_DEMANDE=pms_facturation.CODE_TRAITEMENT JOIN sf_guard_user_profile on sf_guard_user_profile.user_id=pms_traitement_demande.ID_REQUERANT WHERE 1 AND PATH_FACTURE="' . $tab_doc_id1[6] . '" AND pms_traitement_demande.CODE_DEMANDE="' . $code_demande . '" ');

                  if (!empty($resultat)) {
                    $author = $resultat['fullname'];
                    $token_file = $message1;
                    $numerobordereau = $resultat['MENTION'];
                    $objectfile = $resultat['MENTION'];
                    $datedemande = $resultat['DATE_INSERTION'];
                    $muneroparcelle = $resultat['NUMERO_PARCELLE'];
                    $form_entry_id = $resultat['ID_TRAITEMENT_DEMANDE'];
                    $application_id = $resultat['CODE_TRAITEMENT'];
                    $title_file = 'PROFORMA';
                    $description_file = 'LE PROFORMA APPARTENANT AU REQUERANT';


                    // Send metadata bordereau un requerant
                    $this->send_metedata_file_bordereau($ticket, $token_file, $author, $numerobordereau, $objectfile, $datedemande, $muneroparcelle, $form_entry_id, $application_id, $title_file, $description_file);
                  }
                } //ici c'est le bloc reserver au bordereau
                elseif ($tab_doc_id[1] == 2000) {
                  $resultat = $this->CI->Model->getRequeteOne('SELECT sf_guard_user_profile.fullname,pms_facturation.NUMERO_QUITTANCE,pms_facturation.DATE_PAIEMENT,pms_traitement_demande.NUMERO_PARCELLE,pms_facturation.CODE_TRAITEMENT,pms_traitement_demande.ID_TRAITEMENT_DEMANDE,pms_facturation.MENTION  FROM pms_facturation JOIN pms_traitement_demande on pms_traitement_demande.CODE_DEMANDE=pms_facturation.CODE_TRAITEMENT JOIN sf_guard_user_profile on sf_guard_user_profile.user_id=pms_traitement_demande.ID_REQUERANT WHERE 1 AND PATH_QUITTANCE="' . $tab_doc_id1[6] . '" AND pms_traitement_demande.CODE_DEMANDE="' . $code_demande . '" ');

                  if (!empty($resultat)) {
                    $author = $resultat['fullname'];
                    $token_file = $message1;
                    $numerobordereau = $resultat['NUMERO_QUITTANCE'];
                    $objectfile = $resultat['MENTION'];
                    $datedemande = $resultat['DATE_PAIEMENT'];
                    $muneroparcelle = $resultat['NUMERO_PARCELLE'];
                    $form_entry_id = $resultat['ID_TRAITEMENT_DEMANDE'];
                    $application_id = $resultat['CODE_TRAITEMENT'];
                    $title_file = 'BORDERAU';
                    $description_file = 'UN BORDERAU DE PAIEMENT';


                    // Send metadata bordereau un requerant
                    $this->send_metedata_file_bordereau($ticket, $token_file, $author, $numerobordereau, $objectfile, $datedemande, $muneroparcelle, $form_entry_id, $application_id, $title_file, $description_file);
                  }
                } else {
                  $message = 'Aucune metadata archiver suite au manque de ficher';
                }
              } else {
                $message = 'aucun token retourner';
              }
            }

            $message = '<div class="alert alert-success text-center" id="message">Archivage éffectué avec succés</div>';

            $this->start_process($all_token_file, $id_parcelle['PROVINCE_ID']);
          } else {
            $message = '<div class="alert alert-danger text-center" id="message">LE TOKEN EST INEXISTANT,archivage echoué</div>';
          }
        } else {
          $message = '<div class="alert alert-danger text-center" id="message">Les informations de la parcelle n\'existe pas dans la table,archivage echoué</div>';
        }
      } else {
        $message = '<div class="alert alert-danger text-center" id="message">Aucune donnée existe dans la table de traitement sur  ce code,archivage echoué</div>';
      }
    } else {
      $message = '<div class="alert alert-danger text-center" id="message">Aucun fichier existant,archivage echoué</div>';
    }
    return $message;
  }


  //fonction qui fait l'archivage pour les process aun niveau de EDRMS:ACTUALISATION A ET B
  public function archivage_actualisation_fichier_morcellement($code_demande)
  {
    $donnees = $this->envoyer_ficher($code_demande);

    // print_r($donnees);
    // exit();
    $ticket = $this->login();
    $desc_nom_doc = '';
    $resultat = '';

    // $donnees_get  = explode('@', $donnees);

    $message = '';
    $message1 = '';
    $data_token = '';
    $token_repertoire = '';
    $id_parcelle = '';
    $code_de_parcelle = '';
    $token_repertoire = '';
    $all_token_file = '';
    if (!empty($donnees)) {
      $code_de_parcelle = $this->CI->Model->getOne('pms_traitement_demande', array('CODE_DEMANDE' => $code_demande));


      if (!empty($code_de_parcelle)) {
        // $id_parcelle=$this->CI->Model->getOne('parcelle_attribution',array('ID_TRAITEMENT_DEMANDE'=>$code_de_parcelle['ID_TRAITEMENT_DEMANDE']));

        $id_parcelle = $this->CI->Model->getRequete('SELECT * from parcelle_attribution where ID_TRAITEMENT_DEMANDE=' . $code_de_parcelle['ID_TRAITEMENT_DEMANDE']);

        if (!empty($id_parcelle)) {

          foreach ($id_parcelle as $parcel_morceller) {
            $num_parcelle = $parcel_morceller['NUMERO_PARCELLE'];

            $id_processus_parcelle = $this->CI->Model->getRequeteOne("SELECT id,dossiers_processus_province_id,parcelle_id,numero_parcelle,nom_repertoire_parcelle,token_dossiers_parcelle_processus,menu_id,dossier_id FROM edrms_repertoire_processus_parcelle_new WHERE numero_parcelle='" . $parcel_morceller['NUMERO_PARCELLE'] . "' ORDER BY id DESC");

            $token_repertoire = $this->CI->Model->getOne('edrms_repertoire_processus_sous_repertoire_new', array('dossier_processus_parcelle_id' => $id_processus_parcelle['id'], 'statut_actualisation' => 1));

            if (!empty($token_repertoire)) {
              $donnees_get = str_replace('@', '', $donnees);
              $index_donnees_get = explode('<>', $donnees_get);
              for ($j = 0; $j < count($index_donnees_get) - 1; $j++) {
                $tab_doc_id = $index_donnees_get[$j];
                $tab_doc_id = explode('#', $tab_doc_id);
                $tab_doc_id1 = explode('/', $tab_doc_id[0]);


                $getnom_doc = $this->CI->Model->getOne('pms_documents', ['ID_DOCUMENT' => $tab_doc_id[1]]);


                if (empty($getnom_doc['DESC_DOCUMENT'])) {
                  $desc_nom_doc = '';

                  // echo 'Path : '.$tab_doc_id[0].' / Id doc : PROFORMA / BORDEREAU <br>';

                } else {
                  $desc_nom_doc = $getnom_doc['DESC_DOCUMENT'];

                  // echo 'Path : '.$tab_doc_id[0].' / Id doc : '.$desc_nom_doc.' <br>';

                }

                // $message1=$this->save_edrmsFile($token_repertoire['token_sous_repertoire'],$tab_doc_id1[5],$tab_doc_id[0],$desc_nom_doc,$numero=''); 

                //  $message1=$this->send_file_to_alfresco($tab_doc_id1[6],$tab_doc_id1[5],$token_repertoire['token_sous_repertoire'],$tab_doc_id1[6]);
                $message1 = $this->send_file_to_alfresco($tab_doc_id1[5], $tab_doc_id1[4], $token_repertoire['token_sous_repertoire'], $desc_nom_doc);

                $all_token_file .= $message1 . ',';

                // $message2 =  json_decode($message1);



                // $data_token=$message2->idFiles;



                // $data_token_recuperer = explode("workspace://SpacesStore/", $data_token);


                if ($message1 != '')
                // if($data_token_recuperer[1]!='')
                {
                  //pour verifcation si ID DOCUMENT EST ENVOYER ET SAVOIR SI C'EST SCANNER OU GENERER
                  if ($tab_doc_id[1] != 1000 && $tab_doc_id[1] != 2000) {
                    $getnom_doc = $this->CI->Model->getOne('pms_documents', ['ID_DOCUMENT' => $tab_doc_id[1]]);

                    // echo "<pre>";
                    // print_r($getnom_doc);
                    // exit();
                    // echo "</pre>";

                    if ($getnom_doc['ID_TYPE_DOCUMENT'] == 1) {
                      // $message='doc_scanner';
                      // $message='doc_scanner'; 
                      $checking_meta_doc = $this->CI->Model->getRequeteOne('SELECT ID_DOCUMENT FROM `pms_metadonnee_documents` WHERE pms_metadonnee_documents.ID_DOCUMENT=' . $tab_doc_id[1]);

                      if (!empty($checking_meta_doc)) {
                        //Send metadata uploaded par un requerant

                        $resultat = $this->CI->Model->getRequeteOne('SELECT pms_documents_demande.ID_DOCUMENT_DEMANDE,pms_documents.ID_DOCUMENT,pms_documents.DESC_DOCUMENT, pms_documents_demande.CODE_TRAITEMENT, pms_documents_demande.PATH_DOC, pms_documents_demande.DATE_INSERTION FROM pms_documents_demande JOIN pms_documents on pms_documents.ID_DOCUMENT=pms_documents_demande.ID_DOCUMENT WHERE pms_documents_demande.PATH_DOC="' . $tab_doc_id1[5] . '" AND pms_documents_demande.CODE_TRAITEMENT="' . $code_demande . '" ');

                        if (!empty($resultat)) {
                          $token_file = $message1;

                          $title_file = $resultat['DESC_DOCUMENT'];

                          $description_file = !empty($resultat['DESC_DOCUMENT']) ? $resultat['DESC_DOCUMENT'] : '';

                          $doc_id = $tab_doc_id[1];

                          $author = '';

                          $this->send_metedata_file_upload_pms($ticket, $token_file, $code_demande, $title_file, $description_file, $doc_id, $author);
                        }
                      } else {
                        $resultat = $this->CI->Model->getRequeteOne('SELECT pms_documents_demande.ID_DOCUMENT_DEMANDE, pms_type_documents.DESCRIPTION, pms_documents.ID_DOCUMENT, pms_documents.DESC_DOCUMENT, pms_documents_demande.CODE_TRAITEMENT, pms_documents_demande.PATH_DOC, pms_documents_demande.DATE_INSERTION FROM pms_documents_demande JOIN pms_documents on pms_documents.ID_DOCUMENT=pms_documents_demande.ID_DOCUMENT JOIN pms_type_documents on pms_type_documents.ID_TYPE_DOCUMENT=pms_documents.ID_TYPE_DOCUMENT WHERE pms_documents_demande.PATH_DOC="' . $tab_doc_id1[5] . '" AND pms_documents_demande.CODE_TRAITEMENT="' . $code_demande . '" ');

                        if (!empty($resultat)) {
                          $information_demande = $this->CI->Model->getOne('pms_traitement_demande', array('CODE_DEMANDE' => $code_demande));

                          $information_parcelle = $this->CI->Model->getOne('parcelle_attribution', array('ID_TRAITEMENT_DEMANDE' => $information_demande['ID_TRAITEMENT_DEMANDE']));



                          $information_localite = $this->CI->Model->getRequeteOne('SELECT provinces.PROVINCE_NAME,communes.COMMUNE_NAME,collines.COLLINE_NAME,pms_zones.ZONE_NAME FROM `parcelle_attribution` JOIN provinces on provinces.PROVINCE_ID=parcelle_attribution.PROVINCE_ID JOIN communes on communes.COMMUNE_ID=parcelle_attribution.COMMUNE_ID JOIN collines on collines.COLLINE_ID=parcelle_attribution.COLLINE_ID JOIN pms_zones on pms_zones.ZONE_ID=parcelle_attribution.ZONE_ID where parcelle_attribution.ID_TRAITEMENT_DEMANDE=' . $information_demande["ID_TRAITEMENT_DEMANDE"]);

                          $recuperation_desc_usage = $this->CI->Model->getOne('usager_propriete', array('ID_USAGER_PROPRIETE' => $information_parcelle['USAGE_ID']));

                          $recuperation_desc_process = $this->CI->Model->getOne('pms_process', array('PROCESS_ID' => $information_demande['PROCESS_ID']));


                          $author = '';
                          $codefile = !empty($resultat['ID_DOCUMENT_DEMANDE']) ? $resultat['ID_DOCUMENT_DEMANDE'] : '';
                          $token_file = $message1;
                          $objectfile = !empty($recuperation_desc_process) ? $recuperation_desc_process['DESCRIPTION_PROCESS'] : '';
                          $datedemande = !empty($resultat['DATE_INSERTION']) ? $resultat['DATE_INSERTION'] : '';
                          $muneroparcelle = $information_demande['NUMERO_PARCELLE'];

                          $form_entry_id = $information_demande['ID_TRAITEMENT_DEMANDE'];

                          $application_id = $information_demande['CODE_DEMANDE'];

                          $title_file = $resultat['DESC_DOCUMENT'];

                          $localite = $information_localite['PROVINCE_NAME'] . '-' . $information_localite['COMMUNE_NAME'] . '-' . $information_localite['ZONE_NAME'] . '-' . $information_localite['COLLINE_NAME'];

                          $superficie = $information_parcelle['SUPERFICIE_HA'] . '-' . $information_parcelle['SUPERFICIE_ARE'] . '-' . $information_parcelle['SUPERFICIE_CA'];

                          $usage = !empty($recuperation_desc_usage['DESCRIPTION_USAGER_PROPRIETE']) ? $recuperation_desc_usage['DESCRIPTION_USAGER_PROPRIETE'] : '';

                          $description_file = !empty($resultat['DESC_DOCUMENT']) ? $resultat['DESC_DOCUMENT'] : '';

                          //Send metadata uploaded par un requerant
                          $this->send_metedata_file_upload($ticket, $token_file, $author, $codefile, $objectfile, $form_entry_id, $datedemande, $application_id, $muneroparcelle, $localite, $superficie, $usage, $title_file, $description_file);
                        }
                      }
                    } else {
                      $message = 'doc_generer';
                    }
                  } //ici dans le cadre ou c'est une facture proforma et que id document inexistant
                  elseif ($tab_doc_id[1] == 1000) {
                    $resultat = $this->CI->Model->getRequeteOne('SELECT sf_guard_user_profile.fullname,pms_facturation.MENTION,pms_facturation.DATE_PAIEMENT,pms_traitement_demande.NUMERO_PARCELLE,pms_facturation.CODE_TRAITEMENT,pms_traitement_demande.ID_TRAITEMENT_DEMANDE,pms_facturation.DATE_INSERTION  FROM pms_facturation JOIN pms_traitement_demande on pms_traitement_demande.CODE_DEMANDE=pms_facturation.CODE_TRAITEMENT JOIN sf_guard_user_profile on sf_guard_user_profile.user_id=pms_traitement_demande.ID_REQUERANT WHERE 1 AND PATH_FACTURE="' . $tab_doc_id1[6] . '" AND pms_traitement_demande.CODE_DEMANDE="' . $code_demande . '" ');

                    if (!empty($resultat)) {
                      $author = $resultat['fullname'];
                      $token_file = $message1;
                      $numerobordereau = $resultat['MENTION'];
                      $objectfile = $resultat['MENTION'];
                      $datedemande = $resultat['DATE_INSERTION'];
                      $muneroparcelle = $resultat['NUMERO_PARCELLE'];
                      $form_entry_id = $resultat['ID_TRAITEMENT_DEMANDE'];
                      $application_id = $resultat['CODE_TRAITEMENT'];
                      $title_file = 'PROFORMA';
                      $description_file = 'LE PROFORMA APPARTENANT AU REQUERANT';


                      // Send metadata bordereau un requerant
                      $this->send_metedata_file_bordereau($ticket, $token_file, $author, $numerobordereau, $objectfile, $datedemande, $muneroparcelle, $form_entry_id, $application_id, $title_file, $description_file);
                    }
                  } //ici c'est le bloc reserver au bordereau
                  elseif ($tab_doc_id[1] == 2000) {
                    $resultat = $this->CI->Model->getRequeteOne('SELECT sf_guard_user_profile.fullname,pms_facturation.NUMERO_QUITTANCE,pms_facturation.DATE_PAIEMENT,pms_traitement_demande.NUMERO_PARCELLE,pms_facturation.CODE_TRAITEMENT,pms_traitement_demande.ID_TRAITEMENT_DEMANDE,pms_facturation.MENTION  FROM pms_facturation JOIN pms_traitement_demande on pms_traitement_demande.CODE_DEMANDE=pms_facturation.CODE_TRAITEMENT JOIN sf_guard_user_profile on sf_guard_user_profile.user_id=pms_traitement_demande.ID_REQUERANT WHERE 1 AND PATH_QUITTANCE="' . $tab_doc_id1[6] . '" AND pms_traitement_demande.CODE_DEMANDE="' . $code_demande . '" ');

                    if (!empty($resultat)) {
                      $author = $resultat['fullname'];
                      $token_file = $message1;
                      $numerobordereau = $resultat['NUMERO_QUITTANCE'];
                      $objectfile = $resultat['MENTION'];
                      $datedemande = $resultat['DATE_PAIEMENT'];
                      $muneroparcelle = $resultat['NUMERO_PARCELLE'];
                      $form_entry_id = $resultat['ID_TRAITEMENT_DEMANDE'];
                      $application_id = $resultat['CODE_TRAITEMENT'];
                      $title_file = 'BORDERAU';
                      $description_file = 'UN BORDERAU DE PAIEMENT';


                      // Send metadata bordereau un requerant
                      $this->send_metedata_file_bordereau($ticket, $token_file, $author, $numerobordereau, $objectfile, $datedemande, $muneroparcelle, $form_entry_id, $application_id, $title_file, $description_file);
                    }
                  } else {
                    $message = 'Aucune metadata archiver suite au manque de ficher';
                  }
                } else {
                  $message = 'aucun token retourner';
                }
              }

              $message = '<div class="alert alert-success text-center" id="message">Archivage éffectué avec succés</div>';

              $this->start_process($all_token_file, $parcel_morceller['PROVINCE_ID']);
            } else {
              $message = '<div class="alert alert-danger text-center" id="message">LE TOKEN EST INEXISTANT,archivage echoué</div>';
            }
          }
        } else {
          $message = '<div class="alert alert-danger text-center" id="message">Les informations de la parcelle n\'existe pas dans la table,archivage echoué</div>';
        }
      } else {
        $message = '<div class="alert alert-danger text-center" id="message">Aucune donnée existe dans la table de traitement sur  ce code,archivage echoué</div>';
      }
    } else {
      $message = '<div class="alert alert-danger text-center" id="message">Aucun fichier existant,archivage echoué</div>';
    }
    return $message;
  }



  //function pour la creation des dossier et sous dossier au  niveau de la base de donneees pour les process:ACTUALISATION,DETERIORATION,PERTE,MORCELLEMENT
  public function archive_dossier_actualisation($code_demande)
  {
    $message = '';
    $province_id = '';
    $info_parcelle = '';
    $parcelle_dossier_id = 0;
    $ticket = $this->login();

    $info_parcelle = $this->CI->Model->getOne('pms_traitement_demande', array('CODE_DEMANDE' => $code_demande));

    $name_sous_dossier = "";
    $get_recuperer_d = $this->CI->Model->getOne("pms_farde", array("ID_TRAITEMENT_DEMANDE" => $info_parcelle["ID_TRAITEMENT_DEMANDE"]));
    if (!empty($get_recuperer_d)) {
      $name_sous_dossier = "D" . $get_recuperer_d["FARDE_PRECEDENTE"];
    }
    // print_r($info_parcelle);
    // exit();

    if (!empty($info_parcelle)) {

      $num_parcelle = $info_parcelle['NUMERO_PARCELLE'];


      $token = $this->CI->Model->getRequeteOne("SELECT id,dossiers_processus_province_id,parcelle_id,numero_parcelle,nom_repertoire_parcelle,token_dossiers_parcelle_processus,menu_id,dossier_id FROM edrms_repertoire_processus_parcelle_new WHERE numero_parcelle='" . $num_parcelle . "' AND dossier_id=9 ORDER BY id DESC");

      if (empty($token)) {
        $token = $this->CI->Model->getRequeteOne("SELECT id,dossiers_processus_province_id,parcelle_id,numero_parcelle,nom_repertoire_parcelle,token_dossiers_parcelle_processus,menu_id,dossier_id FROM edrms_repertoire_processus_parcelle_new WHERE numero_parcelle='" . $num_parcelle . "' ORDER BY id DESC");
      }

      $province_id = $this->CI->Model->getOne('parcelle_attribution', array('NUMERO_PARCELLE' => $num_parcelle, 'STATUT_ID' => 3));

      if (!empty($province_id)) {

        $info_dossier = $this->CI->Model->getRequeteOne('SELECT token_dossiers_processus_province,id,dossier_processus_id FROM edrms_dossiers_processus_province WHERE province_id=' . $province_id['PROVINCE_ID'] . ' and dossier_processus_id=9');

        //$info_parcelle=$this->CI->Model->getOne('pms_traitement_demande',array('NUMERO_PARCELLE'=>$num_parcelle));

        $info_proprietaire = $this->CI->Model->getOne('sf_guard_user_profile', array('user_id' => $info_parcelle['ID_REQUERANT']));
        //print_r($token);
        //exit();

        if (!empty($token) && $token['dossier_id'] == 9) {
          // echo "<pre>";
          // print_r($token);
          // exit();
          // echo "</pre>";
          if (!empty($token['token_dossiers_parcelle_processus'])) {
            //creation du nouveau sous-dossier  dans le dossier parcelle
            // $name_sous_dossier="D".$info_parcelle['ID_TRAITEMENT_DEMANDE'];

            $data = array('name' => $name_sous_dossier, 'title' => "Folder belong to " . $info_proprietaire['fullname'], 'description' => "Dossier D");
            // print_r($data);
            // exit();

            $recuperer_resultat_token_dossier_creer = $this->create_folder($ticket, $data, $token['token_dossiers_parcelle_processus']);
            // echo "<pre>";
            // print_r($recuperer_resultat_token_dossier_creer);
            // exit();
            // echo "</pre>";

            if (!empty($recuperer_resultat_token_dossier_creer->nodeRef)) {
              //recuperation du token du nouveau DOSSIER D CREER
              $resultat_token_dossier_creer = $recuperer_resultat_token_dossier_creer->nodeRef;

              $token_destination = explode('workspace://SpacesStore/', $resultat_token_dossier_creer);

              $parcelle_dossier_id = $token['id'];



              //recuperation du token de l'ancien dossier
              $token_sous_dossier_existant = $this->CI->Model->getOne('edrms_repertoire_processus_sous_repertoire_new', array('dossier_processus_parcelle_id' => $parcelle_dossier_id, 'parcelle_id' => $province_id['ID_PARCELLE'], 'statut_actualisation' => 1));

              $message = '<div class="alert alert-success text-center" id="message">Archivage éffectué avec succés</div>';


              $token_sous_dossier_new_id = $this->CI->Model->insert_last_id('edrms_repertoire_processus_sous_repertoire_new', array('dossier_processus_parcelle_id' => $parcelle_dossier_id, 'parcelle_id' => $province_id['ID_PARCELLE'], 'form_entry_id' => $info_parcelle['ID_TRAITEMENT_DEMANDE'], 'numero_dossier' => $info_parcelle['CODE_DEMANDE'], 'nom_sous_repertoire' => 'D' . $info_parcelle['ID_TRAITEMENT_DEMANDE'], 'token_sous_repertoire' => $token_destination[1], 'statut_actualisation' => 1));

              // echo "<pre>";
              // print_r($token_sous_dossier_new_id);
              // exit();
              // echo "</pre>";

              if (!empty($token_sous_dossier_existant)) {
                if (!empty($token_sous_dossier_existant['token_sous_repertoire'])) {
                  //deplacement de l'ancien dossier dans le nouveau dossier
                  $this->move_file($ticket, $token_sous_dossier_existant['token_sous_repertoire'], $token_destination[1]);

                  //mise à jour de l'ancien dossier à 0 
                  $this->CI->Model->update('edrms_repertoire_processus_sous_repertoire_new', array('id' => $token_sous_dossier_existant['id']), array('statut_actualisation' => 0));
                }
              }

              $code_demande = $info_parcelle['CODE_DEMANDE'];
              $result = $this->archivage_actualisation_fichier($code_demande);
            } else {
              $message = '<div class="alert alert-warning text-center" id="message">token du sous dossier retourner, inexistant lors de l\'update</div>';
            }
          } else {
            $message = '<div class="alert alert-warning text-center" id="message">token de la parcelle existant introuvée</div>';
          }
        } else {
          //creation du nouveau dossier  dans la table repertoire parcelle

          $special_caractere = array('/', '.', '"', "'", "*", '<', '>', '|', ':', '?');
          $avoid_slashes = str_replace($special_caractere, "-", $info_parcelle['NUMERO_PARCELLE']);
          $name = $avoid_slashes;

          $data = array('name' => $name, 'title' => "Folder belong to " . $info_proprietaire['fullname'], 'description' => "Dossier parcelle");

          $recuperer_resultat_token_dossier_creer = $this->create_folder($ticket, $data, $info_dossier['token_dossiers_processus_province']);

          if (!empty($recuperer_resultat_token_dossier_creer)) {
            //recuperation du token du nouveau DOSSIER PARCELLE CREER
            $resultat_token_dossier_creer = $recuperer_resultat_token_dossier_creer->nodeRef;

            $token_destination = explode('workspace://SpacesStore/', $resultat_token_dossier_creer);

            //materisalisation dans la base
            $parcelle_dossier_id = $this->CI->Model->insert_last_id('edrms_repertoire_processus_parcelle_new', array('dossiers_processus_province_id' => $info_dossier['id'], 'parcelle_id' => $province_id['ID_PARCELLE'], 'numero_parcelle' => $info_parcelle['NUMERO_PARCELLE'], 'nom_repertoire_parcelle' => $name, 'token_dossiers_parcelle_processus' => $token_destination[1], 'menu_id' => '', 'dossier_id' => $info_dossier['dossier_processus_id']));

            //creation du sous dossier 
            // $name_sous_dossier="D".$info_parcelle['ID_TRAITEMENT_DEMANDE'];

            $data = array('name' => $name_sous_dossier, 'title' => "Folder belong to " . $info_proprietaire['fullname'], 'description' => "Dossier parcelle");


            $recuperer_resultat_token_sous_dossier_creer = $this->create_folder($ticket, $data, $token_destination[1]);

            if (!empty($recuperer_resultat_token_sous_dossier_creer)) {
              $resultat_token_sous_dossier_creer = $recuperer_resultat_token_sous_dossier_creer->nodeRef;

              $token_sous_dossier_destination = explode('workspace://SpacesStore/', $resultat_token_sous_dossier_creer);

              //materialisation dans la table sous_repertoire_new
              $this->CI->Model->insert_last_id('edrms_repertoire_processus_sous_repertoire_new', array('dossier_processus_parcelle_id' => $parcelle_dossier_id, 'parcelle_id' => $province_id['ID_PARCELLE'], 'form_entry_id' => $info_parcelle['ID_TRAITEMENT_DEMANDE'], 'numero_dossier' => $info_parcelle['CODE_DEMANDE'], 'nom_sous_repertoire' => $name_sous_dossier, 'token_sous_repertoire' => $token_sous_dossier_destination[1], 'statut_actualisation' => 1));

              $code_demande = $info_parcelle['CODE_DEMANDE'];
              $result = $this->archivage_actualisation_fichier($code_demande);

              $message = '<div class="alert alert-success text-center" id="message">archiVAGE effecTUEE aveC succCESS</div>';
            } else {
              $message = '<div class="alert alert-warning text-center" id="message">token du sous dossier D crée est inexistant</div>';
            }
          } else {
            $message = '<div class="alert alert-warning text-center" id="message">token du dossier de la parcelle est inexistant</div>';
          }
        }
      } else {
        $message = '<div class="alert alert-warning text-center" id="message">La parcelle n\'est pas attribuée</div>';
      }
    } else {
      $message = '<div class="alert alert-warning text-center" id="message">La parcelle est inexistante</div>';
    }

    return $message;
  }

  //function pour archiver pour le process:PERTE
  public function archive_dossier_perte25052023($code_demande)
  {
    $message = '';
    $province_id = '';
    $info_parcelle = '';
    $parcelle_dossier_id = 0;

    $ticket = $this->login();

    $info_parcelle = $this->CI->Model->getOne('pms_traitement_demande', array('CODE_DEMANDE' => $code_demande));



    if (!empty($info_parcelle)) {

      $num_parcelle = $info_parcelle['NUMERO_PARCELLE'];

      $token = $this->CI->Model->getRequeteOne("SELECT id,dossiers_processus_province_id,parcelle_id,numero_parcelle,nom_repertoire_parcelle,token_dossiers_parcelle_processus,menu_id,dossier_id FROM edrms_repertoire_processus_parcelle_new WHERE numero_parcelle='" . $num_parcelle . "' AND dossier_id=9 ORDER BY id DESC");

      if (empty($token)) {
        $token = $this->CI->Model->getRequeteOne("SELECT id,dossiers_processus_province_id,parcelle_id,numero_parcelle,nom_repertoire_parcelle,token_dossiers_parcelle_processus,menu_id,dossier_id FROM edrms_repertoire_processus_parcelle_new WHERE numero_parcelle='" . $num_parcelle . "' ORDER BY id DESC");
      }

      $province_id = $this->CI->Model->getOne('parcelle_attribution', array('NUMERO_PARCELLE' => $num_parcelle));

      $info_dossier = $this->CI->Model->getRequeteOne('SELECT token_dossiers_processus_province,id,dossier_processus_id FROM edrms_dossiers_processus_province WHERE province_id=' . $province_id['PROVINCE_ID'] . ' and dossier_processus_id=9');

      //$info_parcelle=$this->CI->Model->getOne('pms_traitement_demande',array('NUMERO_PARCELLE'=>$num_parcelle));

      $info_proprietaire = $this->CI->Model->getOne('sf_guard_user_profile', array('user_id' => $info_parcelle['ID_REQUERANT']));

      if (!empty($token) && $token['dossier_id'] == 9) {
        if (!empty($token['token_dossiers_parcelle_processus'])) {
          //creation du nouveau sous-dossier  dans le dossier parcelle
          $name_sous_dossier = "DP" . $info_parcelle['ID_TRAITEMENT_DEMANDE'];

          $data = array('name' => $name_sous_dossier, 'title' => "Folder belong to " . $info_proprietaire['fullname'], 'description' => "Sous dossier DP");

          $recuperer_resultat_token_dossier_creer = $this->create_folder($ticket, $data, $token['token_dossiers_parcelle_processus']);

          if (!empty($recuperer_resultat_token_dossier_creer)) {
            //recuperation du token du nouveau DOSSIER D CREER
            $resultat_token_dossier_creer = $recuperer_resultat_token_dossier_creer->nodeRef;

            $token_destination = explode('workspace://SpacesStore/', $resultat_token_dossier_creer);

            $parcelle_dossier_id = $token['id'];

            //recuperation du token de l'ancien dossier
            $token_sous_dossier_existant = $this->CI->Model->getOne('edrms_repertoire_processus_sous_repertoire_new', array('dossier_processus_parcelle_id' => $parcelle_dossier_id, 'parcelle_id' => $province_id['ID_PARCELLE'], 'statut_actualisation' => 1));

            $message = 'Archivage éffectué avec succés';

            $token_sous_dossier_new_id = $this->CI->Model->insert_last_id('edrms_repertoire_processus_sous_repertoire_new', array('dossier_processus_parcelle_id' => $parcelle_dossier_id, 'parcelle_id' => $province_id['ID_PARCELLE'], 'form_entry_id' => $info_parcelle['ID_TRAITEMENT_DEMANDE'], 'numero_dossier' => $info_parcelle['CODE_DEMANDE'], 'nom_sous_repertoire' => 'DP' . $info_parcelle['ID_TRAITEMENT_DEMANDE'], 'token_sous_repertoire' => $token_destination[1], 'statut_actualisation' => 1));

            if (!empty($token_sous_dossier_existant)) {
              if (!empty($token_sous_dossier_existant['token_sous_repertoire'])) {
                //deplacement de l'ancien dossier dans le nouveau dossier
                $this->move_file($ticket, $token_sous_dossier_existant['token_sous_repertoire'], $token_destination[1]);

                //mise à jour de l'ancien dossier à 0 
                $this->CI->Model->update('edrms_repertoire_processus_sous_repertoire_new', array('id' => $token_sous_dossier_existant['id']), array('statut_actualisation' => 0));
              }
            }

            $code_demande = $info_parcelle['CODE_DEMANDE'];
            $result = $this->archivage_actualisation_fichier($code_demande);
          } else {
            $message = 'token du sous dossier retourner,est inexistant lors de l\'update';
          }
        } else {
          $message = 'token de la parcelle existant introuvée';
        }
      } else // bloc dediée à la creation d'une parcelle et son sous dossier
      {
        //creation du nouveau dossier  dans la table repertoire parcelle

        $special_caractere = array('/', '.', '"', "'", "*", '<', '>', '|', ':', '?');
        $avoid_slashes = str_replace($special_caractere, "-", $info_parcelle['NUMERO_PARCELLE']);
        $name = $avoid_slashes;

        $data = array('name' => $name, 'title' => "Folder belong to " . $info_proprietaire['fullname'], 'description' => "Dossier parcelle");

        $recuperer_resultat_token_dossier_creer = $this->create_folder($ticket, $data, $info_dossier['token_dossiers_processus_province']);

        if (!empty($recuperer_resultat_token_dossier_creer)) {
          //recuperation du token du nouveau DOSSIER PARCELLE CREER
          $resultat_token_dossier_creer = $recuperer_resultat_token_dossier_creer->nodeRef;

          $token_destination = explode('workspace://SpacesStore/', $resultat_token_dossier_creer);

          //materisalisation dans la base
          $parcelle_dossier_id = $this->CI->Model->insert_last_id('edrms_repertoire_processus_parcelle_new', array('dossiers_processus_province_id' => $info_dossier['id'], 'parcelle_id' => $province_id['ID_PARCELLE'], 'numero_parcelle' => $info_parcelle['NUMERO_PARCELLE'], 'nom_repertoire_parcelle' => $name, 'token_dossiers_parcelle_processus' => $token_destination[1], 'menu_id' => '', 'dossier_id' => $info_dossier['dossier_processus_id']));

          //creation du sous dossier 
          $name_sous_dossier = "DP" . $info_parcelle['ID_TRAITEMENT_DEMANDE'];

          $data = array('name' => $name_sous_dossier, 'title' => "Folder belong to " . $info_proprietaire['fullname'], 'description' => "Dossier parcelle");

          $recuperer_resultat_token_sous_dossier_creer = $this->create_folder($ticket, $data, $token_destination[1]);

          if (!empty($recuperer_resultat_token_sous_dossier_creer)) {
            $resultat_token_sous_dossier_creer = $recuperer_resultat_token_sous_dossier_creer->nodeRef;

            $token_sous_dossier_destination = explode('workspace://SpacesStore/', $resultat_token_sous_dossier_creer);

            //materialisation dans la table sous_repertoire_new
            $this->CI->Model->insert_last_id('edrms_repertoire_processus_sous_repertoire_new', array('dossier_processus_parcelle_id' => $parcelle_dossier_id, 'parcelle_id' => $province_id['ID_PARCELLE'], 'form_entry_id' => $info_parcelle['ID_TRAITEMENT_DEMANDE'], 'numero_dossier' => $info_parcelle['CODE_DEMANDE'], 'nom_sous_repertoire' => $name_sous_dossier, 'token_sous_repertoire' => $token_sous_dossier_destination[1], 'statut_actualisation' => 1));

            $code_demande = $info_parcelle['CODE_DEMANDE'];

            $result = $this->archivage_actualisation_fichier($code_demande);

            $message = '<div class="alert alert-success text-center" id="message">archiVAGE effecTUEE aveC succCESS</div>';
          } else {
            $message = '<div class="alert alert-warning text-center" id="message">token du sous dossier DP crée est inexistant</div>';
          }
        } else {
          $message = '<div class="alert alert-warning text-center" id="message">token du dossier de la parcelle est inexistant</div>';
        }
      }
    } else {
      $message = '<div class="alert alert-warning text-center" id="message">La parcelle est inexistante</div>';
    }

    return $message;
  }


  //function pour archiver pour le process:PERTE
  public function archive_dossier_perte($code_demande)
  {
    $message = '';
    $province_id = '';
    $info_parcelle = '';
    $token = '';
    $parcelle_dossier_id = 0;
    $ticket = $this->login();

    $info_parcelle = $this->CI->Model->getOne('pms_traitement_demande', array('CODE_DEMANDE' => $code_demande));

    if (!empty($info_parcelle)) {
      $num_parcelle = $info_parcelle['NUMERO_PARCELLE'];

      $token = $this->CI->Model->getRequeteOne("SELECT id,dossiers_processus_province_id,parcelle_id,numero_parcelle,nom_repertoire_parcelle,token_dossiers_parcelle_processus,menu_id,dossier_id FROM edrms_repertoire_processus_parcelle_new WHERE numero_parcelle='" . $num_parcelle . "' AND dossier_id=9 ORDER BY id DESC");
      if (empty($token)) {
        $token = $this->CI->Model->getRequeteOne("SELECT id,dossiers_processus_province_id,parcelle_id,numero_parcelle,nom_repertoire_parcelle,token_dossiers_parcelle_processus,menu_id,dossier_id FROM edrms_repertoire_processus_parcelle_new WHERE numero_parcelle='" . $num_parcelle . "' ORDER BY id DESC");
      }
      $province_id = $this->CI->Model->getOne('parcelle_attribution', array('NUMERO_PARCELLE' => $num_parcelle));

      if (!empty($province_id)) {
        $info_dossier = $this->CI->Model->getRequeteOne('SELECT token_dossiers_processus_province,id,dossier_processus_id FROM edrms_dossiers_processus_province WHERE province_id=' . $province_id['PROVINCE_ID'] . ' and dossier_processus_id=9');

        $info_proprietaire = $this->CI->Model->getOne('sf_guard_user_profile', array('user_id' => $info_parcelle['ID_REQUERANT']));
        if (!empty($token) && $token['dossier_id'] == 9) {
          if (!empty($token['token_dossiers_parcelle_processus'])) {
            //creation du nouveau sous-dossier  dans le dossier parcelle
            $name_sous_dossier = "DP" . $info_parcelle['ID_TRAITEMENT_DEMANDE'];

            $data = array('name' => $name_sous_dossier, 'title' => "Folder belong to " . $info_proprietaire['fullname'], 'description' => "Sous dossier DP");

            $recuperer_resultat_token_dossier_creer = $this->create_folder($ticket, $data, $token['token_dossiers_parcelle_processus']);

            if (!empty($recuperer_resultat_token_dossier_creer->nodeRef)) {
              //recuperation du token du nouveau DOSSIER D CREER
              $resultat_token_dossier_creer = $recuperer_resultat_token_dossier_creer->nodeRef;

              $token_destination = explode('workspace://SpacesStore/', $resultat_token_dossier_creer);

              $parcelle_dossier_id = $token['id'];

              //recuperation du token de l'ancien dossier
              $token_sous_dossier_existant = $this->CI->Model->getOne('edrms_repertoire_processus_sous_repertoire_new', array('dossier_processus_parcelle_id' => $parcelle_dossier_id, 'parcelle_id' => $province_id['ID_PARCELLE'], 'statut_actualisation' => 1));

              $message = '<div class="alert alert-success text-center" id="message">Archivage éffectué avec succés</div>';

              $token_sous_dossier_new_id = $this->CI->Model->insert_last_id('edrms_repertoire_processus_sous_repertoire_new', array('dossier_processus_parcelle_id' => $parcelle_dossier_id, 'parcelle_id' => $province_id['ID_PARCELLE'], 'form_entry_id' => $info_parcelle['ID_TRAITEMENT_DEMANDE'], 'numero_dossier' => $info_parcelle['CODE_DEMANDE'], 'nom_sous_repertoire' => 'DP' . $info_parcelle['ID_TRAITEMENT_DEMANDE'], 'token_sous_repertoire' => $token_destination[1], 'statut_actualisation' => 1));

              if (!empty($token_sous_dossier_existant)) {
                if (!empty($token_sous_dossier_existant['token_sous_repertoire'])) {
                  //deplacement de l'ancien dossier dans le nouveau dossier
                  $this->move_file($ticket, $token_sous_dossier_existant['token_sous_repertoire'], $token_destination[1]);

                  //mise à jour de l'ancien dossier à 0 
                  $this->CI->Model->update('edrms_repertoire_processus_sous_repertoire_new', array('id' => $token_sous_dossier_existant['id']), array('statut_actualisation' => 0));
                }
              }
              $code_demande = $info_parcelle['CODE_DEMANDE'];

              $result = $this->archivage_actualisation_fichier($code_demande);
            } else {
              $message = '<div class="alert alert-warning text-center" id="message">token du sous dossier retourner, inexistant lors de l\'update</div>';
            }
          } else {
            $message = '<div class="alert alert-warning text-center" id="message">Token de la parcelle existant introuvée</div>';
          }
        } else //bloc dediée à la creation d'une parcelle et son sous dossier
        {
          //creation du nouveau dossier  dans la table repertoire parcelle
          $special_caractere = array('/', '.', '"', "'", "*", '<', '>', '|', ':', '?');

          $avoid_slashes = str_replace($special_caractere, "-", $info_parcelle['NUMERO_PARCELLE']);

          $name = $avoid_slashes;

          $data = array('name' => $name, 'title' => "Folder belong to " . $info_proprietaire['fullname'], 'description' => "Dossier parcelle");

          $recuperer_resultat_token_dossier_creer = $this->create_folder($ticket, $data, $info_dossier['token_dossiers_processus_province']);

          if (!empty($recuperer_resultat_token_dossier_creer)) {
            //recuperation du token du nouveau DOSSIER PARCELLE CREER
            $resultat_token_dossier_creer = $recuperer_resultat_token_dossier_creer->nodeRef;

            $token_destination = explode('workspace://SpacesStore/', $resultat_token_dossier_creer);

            //materisalisation dans la base
            $parcelle_dossier_id = $this->CI->Model->insert_last_id('edrms_repertoire_processus_parcelle_new', array('dossiers_processus_province_id' => $info_dossier['id'], 'parcelle_id' => $province_id['ID_PARCELLE'], 'numero_parcelle' => $info_parcelle['NUMERO_PARCELLE'], 'nom_repertoire_parcelle' => $name, 'token_dossiers_parcelle_processus' => $token_destination[1], 'menu_id' => '', 'dossier_id' => $info_dossier['dossier_processus_id']));

            //creation du sous dossier 
            $name_sous_dossier = "DP" . $info_parcelle['ID_TRAITEMENT_DEMANDE'];

            $data = array('name' => $name_sous_dossier, 'title' => "Folder belong to " . $info_proprietaire['fullname'], 'description' => "Dossier parcelle");

            $recuperer_resultat_token_sous_dossier_creer = $this->create_folder($ticket, $data, $token_destination[1]);

            if (!empty($recuperer_resultat_token_sous_dossier_creer)) {
              $resultat_token_sous_dossier_creer = $recuperer_resultat_token_sous_dossier_creer->nodeRef;

              $token_sous_dossier_destination = explode('workspace://SpacesStore/', $resultat_token_sous_dossier_creer);

              //materialisation dans la table sous_repertoire_new
              $this->CI->Model->insert_last_id('edrms_repertoire_processus_sous_repertoire_new', array('dossier_processus_parcelle_id' => $parcelle_dossier_id, 'parcelle_id' => $province_id['ID_PARCELLE'], 'form_entry_id' => $info_parcelle['ID_TRAITEMENT_DEMANDE'], 'numero_dossier' => $info_parcelle['CODE_DEMANDE'], 'nom_sous_repertoire' => $name_sous_dossier, 'token_sous_repertoire' => $token_sous_dossier_destination[1], 'statut_actualisation' => 1));

              $code_demande = $info_parcelle['CODE_DEMANDE'];

              $result = $this->archivage_actualisation_fichier($code_demande);

              $message = '<div class="alert alert-success text-center" id="message">archiVAGE effecTUEE aveC succCESS</div>';
            } else {
              $message = '<div class="alert alert-warning text-center" id="message">token du sous dossier DP crée est inexistant</div>';
            }
          } else {
            $message = '<div class="alert alert-warning text-center" id="message">Token du dossier de la parcelle est inexistant</div>';
          }
        }
      } else {
        $message = '<div class="alert alert-warning text-center" id="message">La parcelle n\'est pas attribuée</div>';
      }
    } else {
      $message = '<div class="alert alert-warning text-center" id="message">La parcelle est inexistante</div>';
    }
  }


  //function pour archiver pour le process:MORCELLEMENT
  public function archivage_dossier_morcellement($code_demande)
  {
    $message = '';
    $province_id = '';
    $num_parcelle = '';
    $info_parcelle = '';
    $parcelle_dossier_id = 0;

    $ticket = $this->login();



    $info_parcelles = $this->CI->Model->getOne('pms_traitement_demande', array('CODE_DEMANDE' => $code_demande));

    // print_r($info_parcelles);
    // exit();
    $name_sous_dossier = "";
    $get_recuperer_d = $this->CI->Model->getOne("pms_farde", array("ID_TRAITEMENT_DEMANDE" => $info_parcelles["ID_TRAITEMENT_DEMANDE"]));
    if (!empty($get_recuperer_d)) {
      $name_sous_dossier = "D" . $get_recuperer_d["FARDE_PRECEDENTE"];
    }

    $info_parcelle = $this->CI->Model->getRequete('SELECT * from parcelle_attribution where ID_TRAITEMENT_DEMANDE=' . $info_parcelles['ID_TRAITEMENT_DEMANDE']);


    if (!empty($info_parcelle)) {
      $recuperer_parcelle_morceller = $this->CI->Model->getRequete('SELECT * from parcelle_attribution where ID_TRAITEMENT_DEMANDE=' . $info_parcelles['ID_TRAITEMENT_DEMANDE']);

      foreach ($recuperer_parcelle_morceller as $parcel_morceller) {
        $num_parcelle = $parcel_morceller['NUMERO_PARCELLE'];
        // $token=$this->CI->Model->getRequeteOne("SELECT id,dossiers_processus_province_id,parcelle_id,numero_parcelle,nom_repertoire_parcelle,token_dossiers_parcelle_processus,menu_id,dossier_id FROM edrms_repertoire_processus_parcelle_new WHERE numero_parcelle='".$num_parcelle."' AND dossier_id=9");

        // if (empty($token))
        // {
        //   $token=$this->CI->Model->getRequeteOne("SELECT id,dossiers_processus_province_id,parcelle_id,numero_parcelle,nom_repertoire_parcelle,token_dossiers_parcelle_processus,menu_id,dossier_id FROM edrms_repertoire_processus_parcelle_new WHERE numero_parcelle='".$num_parcelle."' ORDER BY id DESC");
        // }
        $province_id = $this->CI->Model->getOne('parcelle_attribution', array('NUMERO_PARCELLE' => $num_parcelle));

        $info_dossier = $this->CI->Model->getRequeteOne('SELECT token_dossiers_processus_province,id,dossier_processus_id FROM edrms_dossiers_processus_province WHERE province_id=' . $province_id['PROVINCE_ID'] . ' and dossier_processus_id=9');

        $info_proprietaire = $this->CI->Model->getOne('sf_guard_user_profile', array('user_id' => $province_id['ID_REQUERANT']));
        //creation du nouveau dossier  dans la table repertoire parcelle

        $special_caractere = array('/', '.', '"', "'", "*", '<', '>', '|', ':', '?');
        $avoid_slashes = str_replace($special_caractere, "-", $province_id['NUMERO_PARCELLE']);
        $name = $avoid_slashes;

        $data = array('name' => $name, 'title' => "Folder belong to " . $info_proprietaire['fullname'], 'description' => "Dossier parcelle");

        $recuperer_resultat_token_dossier_creer = $this->create_folder($ticket, $data, $info_dossier['token_dossiers_processus_province']);

        if (!empty($recuperer_resultat_token_dossier_creer)) {
          //recuperation du token du nouveau DOSSIER PARCELLE CREER
          $resultat_token_dossier_creer = $recuperer_resultat_token_dossier_creer->nodeRef;

          $token_destination = explode('workspace://SpacesStore/', $resultat_token_dossier_creer);

          //materisalisation dans la base
          $parcelle_dossier_id = $this->CI->Model->insert_last_id('edrms_repertoire_processus_parcelle_new', array('dossiers_processus_province_id' => $info_dossier['id'], 'parcelle_id' => $province_id['ID_PARCELLE'], 'numero_parcelle' => $province_id['NUMERO_PARCELLE'], 'nom_repertoire_parcelle' => $name, 'token_dossiers_parcelle_processus' => $token_destination[1], 'menu_id' => '', 'dossier_id' => $info_dossier['dossier_processus_id']));

          //creation du sous dossier 
          // $name_sous_dossier="D".$info_parcelles['ID_TRAITEMENT_DEMANDE'];

          $data = array('name' => $name_sous_dossier, 'title' => "Folder belong to " . $info_proprietaire['fullname'], 'description' => "Dossier parcelle");

          $recuperer_resultat_token_sous_dossier_creer = $this->create_folder($ticket, $data, $token_destination[1]);

          if (!empty($recuperer_resultat_token_sous_dossier_creer)) {
            $resultat_token_sous_dossier_creer = $recuperer_resultat_token_sous_dossier_creer->nodeRef;

            $token_sous_dossier_destination = explode('workspace://SpacesStore/', $resultat_token_sous_dossier_creer);

            //materialisation dans la table sous_repertoire_new
            $this->CI->Model->insert_last_id('edrms_repertoire_processus_sous_repertoire_new', array('dossier_processus_parcelle_id' => $parcelle_dossier_id, 'parcelle_id' => $province_id['ID_PARCELLE'], 'form_entry_id' => $province_id['ID_TRAITEMENT_DEMANDE'], 'numero_dossier' => $code_demande, 'nom_sous_repertoire' => $name_sous_dossier, 'token_sous_repertoire' => $token_sous_dossier_destination[1], 'statut_actualisation' => 1));

            // $code_demande=$info_parcelles['CODE_DEMANDE'];

            // $result=$this->archivage_actualisation_fichier_morcellement($code_demande); 

            $result = $this->test($code_demande);



            $message = '<div class="alert alert-success text-center" id="message">archiVAGE effecTUEE aveC succCESS</div>';
          } else {
            $message = 'token du sous dossier D crée ,token inexistant';
          }
        } else {
          $message = 'token du dossier de la parcelle est inexistant';
        }
      }
      // $info_parcelle=$this->CI->Model->getOne('parcelle_attribution',array('NUMERO_PARCELLE'=>$num_parcelle));                  
    } else {
      $message = 'PARCELLE INEXISTANTE';
    }

    return $message;
  }

  public function test($code_demande)
  {
    // $donnees=$this->envoyer_ficher($code_demande);
    $ticket = $this->login();
    $desc_nom_doc = '';
    $resultat = '';
    $message = '';
    $message1 = '';
    $data_token = '';
    $token_repertoire = '';
    $id_parcelle = '';
    $code_de_parcelle = '';
    $token_repertoire = '';
    $all_token_file = '';

    $code_de_parcelle = $this->CI->Model->getOne('pms_traitement_demande', array('CODE_DEMANDE' => $code_demande));

    if (!empty($code_de_parcelle)) {
      $id_parcelle = $this->CI->Model->getRequete('SELECT * from parcelle_attribution where ID_TRAITEMENT_DEMANDE=' . $code_de_parcelle['ID_TRAITEMENT_DEMANDE']);
      if (!empty($id_parcelle)) {
        foreach ($id_parcelle as $parcel_morceller) {
          $num_parcelle = $parcel_morceller['NUMERO_PARCELLE'];

          $id_processus_parcelle = $this->CI->Model->getRequeteOne("SELECT id,dossiers_processus_province_id,parcelle_id,numero_parcelle,nom_repertoire_parcelle,token_dossiers_parcelle_processus,menu_id,dossier_id FROM edrms_repertoire_processus_parcelle_new WHERE numero_parcelle='" . $parcel_morceller['NUMERO_PARCELLE'] . "' ORDER BY id DESC");

          $token_repertoire = $this->CI->Model->getOne('edrms_repertoire_processus_sous_repertoire_new', array('dossier_processus_parcelle_id' => $id_processus_parcelle['id'], 'statut_actualisation' => 1));

          $donnees = $this->envoyer_ficher($code_demande);
          if (!empty($token_repertoire)) {
            $donnees_get = str_replace('@', '', $donnees);
            $index_donnees_get = explode('<>', $donnees_get);
            for ($j = 0; $j < count($index_donnees_get) - 1; $j++) {
              $tab_doc_id = $index_donnees_get[$j];
              $tab_doc_id = explode('#', $tab_doc_id);
              $tab_doc_id1 = explode('/', $tab_doc_id[0]);

              $getnom_doc = $this->CI->Model->getOne('pms_documents', ['ID_DOCUMENT' => $tab_doc_id[1]]);

              if (empty($getnom_doc['DESC_DOCUMENT'])) {
                $desc_nom_doc = '';
                // echo 'Path : '.$tab_doc_id[0].' / Id doc : PROFORMA / BORDEREAU <br>';
              } else {
                $desc_nom_doc = $getnom_doc['DESC_DOCUMENT'];
                // echo 'Path : '.$tab_doc_id[0].' / Id doc : '.$desc_nom_doc.' <br>';
              }
              $message1 = $this->send_file_to_alfresco($tab_doc_id1[6], $tab_doc_id1[5], $token_repertoire['token_sous_repertoire'], $tab_doc_id1[6]);
              $message1 = $this->send_file_to_alfresco($tab_doc_id1[5], $tab_doc_id1[4], $token_repertoire['token_sous_repertoire'], $desc_nom_doc);

              $all_token_file .= $message1 . ',';
              if ($message1 != '') {
                //pour verifcation si ID DOCUMENT EST ENVOYER ET SAVOIR SI C'EST SCANNER OU GENERER
                if ($tab_doc_id[1] != 1000 && $tab_doc_id[1] != 2000) {
                  $getnom_doc = $this->CI->Model->getOne('pms_documents', ['ID_DOCUMENT' => $tab_doc_id[1]]);

                  if ($getnom_doc['ID_TYPE_DOCUMENT'] == 1) {
                    //doc_scanner
                    $checking_meta_doc = $this->CI->Model->getRequeteOne('SELECT ID_DOCUMENT FROM `pms_metadonnee_documents` WHERE pms_metadonnee_documents.ID_DOCUMENT=' . $tab_doc_id[1]);
                    if (!empty($checking_meta_doc)) {
                      //Send metadata uploaded par un requerant
                      $resultat = $this->CI->Model->getRequeteOne('SELECT pms_documents_demande.ID_DOCUMENT_DEMANDE,pms_documents.ID_DOCUMENT,pms_documents.DESC_DOCUMENT, pms_documents_demande.CODE_TRAITEMENT, pms_documents_demande.PATH_DOC, pms_documents_demande.DATE_INSERTION FROM pms_documents_demande JOIN pms_documents on pms_documents.ID_DOCUMENT=pms_documents_demande.ID_DOCUMENT WHERE pms_documents_demande.PATH_DOC="' . $tab_doc_id1[5] . '" AND pms_documents_demande.CODE_TRAITEMENT="' . $code_demande . '" ');
                      if (!empty($resultat)) {
                        $token_file = $message1;
                        $title_file = $resultat['DESC_DOCUMENT'];

                        $description_file = !empty($resultat['DESC_DOCUMENT']) ? $resultat['DESC_DOCUMENT'] : '';

                        $doc_id = $tab_doc_id[1];

                        $author = '';

                        $this->send_metedata_file_upload_pms($ticket, $token_file, $code_demande, $title_file, $description_file, $doc_id, $author);
                      }
                    } else {
                      $resultat = $this->CI->Model->getRequeteOne('SELECT pms_documents_demande.ID_DOCUMENT_DEMANDE, pms_type_documents.DESCRIPTION, pms_documents.ID_DOCUMENT, pms_documents.DESC_DOCUMENT, pms_documents_demande.CODE_TRAITEMENT, pms_documents_demande.PATH_DOC, pms_documents_demande.DATE_INSERTION FROM pms_documents_demande JOIN pms_documents on pms_documents.ID_DOCUMENT=pms_documents_demande.ID_DOCUMENT JOIN pms_type_documents on pms_type_documents.ID_TYPE_DOCUMENT=pms_documents.ID_TYPE_DOCUMENT WHERE pms_documents_demande.PATH_DOC="' . $tab_doc_id1[5] . '" AND pms_documents_demande.CODE_TRAITEMENT="' . $code_demande . '" ');

                      if (!empty($resultat)) {
                        $information_demande = $this->CI->Model->getOne('pms_traitement_demande', array('CODE_DEMANDE' => $code_demande));

                        $information_parcelle = $this->CI->Model->getOne('parcelle_attribution', array('ID_TRAITEMENT_DEMANDE' => $information_demande['ID_TRAITEMENT_DEMANDE']));



                        $information_localite = $this->CI->Model->getRequeteOne('SELECT provinces.PROVINCE_NAME,communes.COMMUNE_NAME,collines.COLLINE_NAME,pms_zones.ZONE_NAME FROM `parcelle_attribution` JOIN provinces on provinces.PROVINCE_ID=parcelle_attribution.PROVINCE_ID JOIN communes on communes.COMMUNE_ID=parcelle_attribution.COMMUNE_ID JOIN collines on collines.COLLINE_ID=parcelle_attribution.COLLINE_ID JOIN pms_zones on pms_zones.ZONE_ID=parcelle_attribution.ZONE_ID where parcelle_attribution.ID_TRAITEMENT_DEMANDE=' . $information_demande["ID_TRAITEMENT_DEMANDE"]);

                        $recuperation_desc_usage = $this->CI->Model->getOne('usager_propriete', array('ID_USAGER_PROPRIETE' => $information_parcelle['USAGE_ID']));

                        $recuperation_desc_process = $this->CI->Model->getOne('pms_process', array('PROCESS_ID' => $information_demande['PROCESS_ID']));


                        $author = '';
                        $codefile = !empty($resultat['ID_DOCUMENT_DEMANDE']) ? $resultat['ID_DOCUMENT_DEMANDE'] : '';
                        $token_file = $message1;
                        $objectfile = !empty($recuperation_desc_process) ? $recuperation_desc_process['DESCRIPTION_PROCESS'] : '';
                        $datedemande = !empty($resultat['DATE_INSERTION']) ? $resultat['DATE_INSERTION'] : '';
                        $muneroparcelle = $information_demande['NUMERO_PARCELLE'];

                        $form_entry_id = $information_demande['ID_TRAITEMENT_DEMANDE'];

                        $application_id = $information_demande['CODE_DEMANDE'];

                        $title_file = $resultat['DESC_DOCUMENT'];

                        $localite = $information_localite['PROVINCE_NAME'] . '-' . $information_localite['COMMUNE_NAME'] . '-' . $information_localite['ZONE_NAME'] . '-' . $information_localite['COLLINE_NAME'];

                        $superficie = $information_parcelle['SUPERFICIE_HA'] . '-' . $information_parcelle['SUPERFICIE_ARE'] . '-' . $information_parcelle['SUPERFICIE_CA'];

                        $usage = !empty($recuperation_desc_usage['DESCRIPTION_USAGER_PROPRIETE']) ? $recuperation_desc_usage['DESCRIPTION_USAGER_PROPRIETE'] : '';

                        $description_file = !empty($resultat['DESC_DOCUMENT']) ? $resultat['DESC_DOCUMENT'] : '';

                        //Send metadata uploaded par un requerant
                        $this->send_metedata_file_upload($ticket, $token_file, $author, $codefile, $objectfile, $form_entry_id, $datedemande, $application_id, $muneroparcelle, $localite, $superficie, $usage, $title_file, $description_file);
                      }
                    }
                  } else {
                    $message = 'doc_generer';
                  }
                } //ici dans le cadre ou c'est une facture proforma et que id document inexistant
                elseif ($tab_doc_id[1] == 1000) {
                  $resultat = $this->CI->Model->getRequeteOne('SELECT sf_guard_user_profile.fullname,pms_facturation.MENTION,pms_facturation.DATE_PAIEMENT,pms_traitement_demande.NUMERO_PARCELLE,pms_facturation.CODE_TRAITEMENT,pms_traitement_demande.ID_TRAITEMENT_DEMANDE,pms_facturation.DATE_INSERTION  FROM pms_facturation JOIN pms_traitement_demande on pms_traitement_demande.CODE_DEMANDE=pms_facturation.CODE_TRAITEMENT JOIN sf_guard_user_profile on sf_guard_user_profile.user_id=pms_traitement_demande.ID_REQUERANT WHERE 1 AND PATH_FACTURE="' . $tab_doc_id1[6] . '" AND pms_traitement_demande.CODE_DEMANDE="' . $code_demande . '" ');

                  if (!empty($resultat)) {
                    $author = $resultat['fullname'];
                    $token_file = $message1;
                    $numerobordereau = $resultat['MENTION'];
                    $objectfile = $resultat['MENTION'];
                    $datedemande = $resultat['DATE_INSERTION'];
                    $muneroparcelle = $resultat['NUMERO_PARCELLE'];
                    $form_entry_id = $resultat['ID_TRAITEMENT_DEMANDE'];
                    $application_id = $resultat['CODE_TRAITEMENT'];
                    $title_file = 'PROFORMA';
                    $description_file = 'LE PROFORMA APPARTENANT AU REQUERANT';


                    //Send metadata bordereau un requerant
                    $this->send_metedata_file_bordereau($ticket, $token_file, $author, $numerobordereau, $objectfile, $datedemande, $muneroparcelle, $form_entry_id, $application_id, $title_file, $description_file);
                  }
                } //ici c'est le bloc reserver au bordereau
                elseif ($tab_doc_id[1] == 2000) {
                  $resultat = $this->CI->Model->getRequeteOne('SELECT sf_guard_user_profile.fullname,pms_facturation.NUMERO_QUITTANCE,pms_facturation.DATE_PAIEMENT,pms_traitement_demande.NUMERO_PARCELLE,pms_facturation.CODE_TRAITEMENT,pms_traitement_demande.ID_TRAITEMENT_DEMANDE,pms_facturation.MENTION  FROM pms_facturation JOIN pms_traitement_demande on pms_traitement_demande.CODE_DEMANDE=pms_facturation.CODE_TRAITEMENT JOIN sf_guard_user_profile on sf_guard_user_profile.user_id=pms_traitement_demande.ID_REQUERANT WHERE 1 AND PATH_QUITTANCE="' . $tab_doc_id1[6] . '" AND pms_traitement_demande.CODE_DEMANDE="' . $code_demande . '" ');

                  if (!empty($resultat)) {
                    $author = $resultat['fullname'];
                    $token_file = $message1;
                    $numerobordereau = $resultat['NUMERO_QUITTANCE'];
                    $objectfile = $resultat['MENTION'];
                    $datedemande = $resultat['DATE_PAIEMENT'];
                    $muneroparcelle = $resultat['NUMERO_PARCELLE'];
                    $form_entry_id = $resultat['ID_TRAITEMENT_DEMANDE'];
                    $application_id = $resultat['CODE_TRAITEMENT'];
                    $title_file = 'BORDERAU';
                    $description_file = 'UN BORDERAU DE PAIEMENT';


                    //Send metadata bordereau un requerant
                    $this->send_metedata_file_bordereau($ticket, $token_file, $author, $numerobordereau, $objectfile, $datedemande, $muneroparcelle, $form_entry_id, $application_id, $title_file, $description_file);
                  }
                }
              } else {
                $msg = 'Les fichiers manquent de token';
              }
            }
            $message = '<div class="alert alert-success text-center" id="message">Archivage éffectué avec succés</div>';
            $this->start_process($all_token_file, $parcel_morceller['PROVINCE_ID']);
          } else {
            $msg = 'le token est inexistant,archivage echoué';
          }
        }
      } else {
        $msg = 'informations indisponible dans la table attribution,archivage echoué';
      }
    } else {
      $msg = 'informations dans la table de traitement,archivage echoué';
    }
    return $message;
  }
}
