 <?php
  ini_set('memory_limit', '8192M');
  /**
   * auteur: Eriel
   * tache: Fichier utiliser pour la consommation et partaGE D'API avec le systeme BPS
   * email: eriel@mediabox.bi
   */
  if (!defined('BASEPATH'))
    exit('No direct script access allowed');
  ini_set('max_execution_time', 0);
  ini_set('memory_limit', '2048M');
  class Pms_api
  {
    protected $CI;
    // private $base_url = "192.168.0.25";
    private $base_url = "apps.mediabox.bi:27805";
    private $base_login = "devapi.mediabox.bi";

    public function __construct()
    {
      $this->CI = &get_instance();
      $this->CI->load->library('email');
      $this->CI->load->model('Model');
    }
    /**
     * APIS POUR BOCBOX
     */
    //charger d'executer les requetes vers bps
    public function execute($url, $data = '', $method = 'POST', $token = '')
    {
      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_ENCODING, 1);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
      if ($method == 'POST')
        curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8', 'Accept: application/json', 'Accept-Encoding: deflate', 'Authorization: Bearer ' . $token));
      curl_setopt($ch, CURLOPT_HEADER, 0);
      curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
      if (!empty($data))
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      $output = curl_exec($ch);
      curl_close($ch);
      return json_decode($output);
    }

    public function info_requerant($id)
    {
      $ticket_basic = $this->getToken();

      $url = 'https://' . $this->base_url . '/api/v1/applicants-details/' . $id;
      $headers = [
        'Accept: /',
        'Authorization: Bearer ' . $ticket_basic,
      ];

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

      $response = curl_exec($ch);

      $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
      curl_close($ch);

      // Handle the response as needed 
      // return $response;
      return json_decode($response);
    }

    public function new_execute($url, $data = '', $method = 'POST', $token = '')
    {

      // print_r($token);
      // exit();
      $ch = curl_init($url);

      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_ENCODING, '');
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
      if ($method == 'POST')
        curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8', 'Accept: application/json', 'Accept-Encoding: deflate', 'Authorization: Bearer ' . $token));
      curl_setopt($ch, CURLOPT_HEADER, 0);
      curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
      if (!empty($data))
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
      $output = curl_exec($ch);
      curl_close($ch);
      // return json_decode($output);

      $info = curl_getinfo($ch);
      error_log("cURL request: " . $url);
      error_log("cURL response: " . $output);
      error_log("cURL status code: " . $info['http_code']);
    }




    //charger d'executer l'envoi des informations d'un requerant vers bps
    public function executing($url, $data)
    {
      $ch = curl_init();

      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Content-Type: multipart/form-data"
      ));

      $response = curl_exec($ch);

      if (curl_errno($ch)) {
        $error_msg = curl_error($ch);
        curl_close($ch);
        return array('error' => $error_msg);
      } else {
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return array('http_code' => $http_code, 'response' => $response);
      }
    }

    //charger d'executer l'envoi des informations modifier d'un requerant vers bps
    public function executing_modify($url, $data)
    {
      $ch = curl_init();

      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      $response = curl_exec($ch);

      if (curl_errno($ch)) {
        $error_msg = curl_error($ch);
        curl_close($ch);
        return array('error' => $error_msg);
      } else {
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return array('http_code' => $http_code, 'response' => $response);
      }
    }
    

    ///edmond
    public function executingnew($url, $data)
    {
      $ch = curl_init();
      
      // Configuration de base
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      
      // Configuration SSL optimisée
      curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
      curl_setopt($ch, CURLOPT_CAINFO, '/etc/ssl/certs/ca-certificates.crt');
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
      
      // Construction manuelle du corps multipart
      $boundary = '------------------------'.md5(mt_rand().microtime());
      $payload = '';
      $eol = "\r\n";
      
      foreach ($data as $name => $content)
      {
          $payload .= '--'.$boundary.$eol;
          
          if ($content instanceof CURLFile)
          {
              $payload .= 'Content-Disposition: form-data; name="'.$name.'"; filename="'.basename($content->getFilename()).'"'.$eol;
              $payload .= 'Content-Type: '.mime_content_type($content->getFilename()).$eol.$eol;
              $payload .= file_get_contents($content->getFilename()).$eol;
          } 
          else
          {
              $payload .= 'Content-Disposition: form-data; name="'.$name.'"'.$eol.$eol;
              $payload .= $content.$eol;
          }
      }
      $payload .= '--'.$boundary.'--'.$eol;
      
      // Configuration des en-têtes et données
      curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Accept: application/json',
          'Content-Type: multipart/form-data; boundary='.$boundary,
          'Content-Length: '.strlen($payload),
          'Expect:',
          'Connection: keep-alive'
      ]);
      
      curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
      
      // Configuration réseau
      curl_setopt($ch, CURLOPT_TIMEOUT, 60);
      curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
      curl_setopt($ch, CURLOPT_TCP_NODELAY, true);
      
      // Debug
      curl_setopt($ch, CURLOPT_VERBOSE, true);
      $verbose = fopen('php://temp', 'w+');
      curl_setopt($ch, CURLOPT_STDERR, $verbose);
      
      $response = curl_exec($ch);
      $error = curl_error($ch);
      $errno = curl_errno($ch);
      $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
      
      rewind($verbose);
      $verboseLog = stream_get_contents($verbose);
      fclose($verbose);
      curl_close($ch);
      
      if ($errno || $httpCode === 0)
      {
          return [
              'error' => $error,
              'errno' => $errno,
              'http_code' => $httpCode,
              'debug' => $verboseLog
          ];
      }
      
      return [
          'http_code' => $httpCode,
          'response' => $response
      ];
    }

    // charger d'executer les request vers docbox
    public function execut_docbox($data = array(), $url)
    {
      $header = array();
      $header[0] = 'Content-Type:application/json';

      $curl = curl_init();
      curl_setopt($curl, CURLOPT_URL, $url);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_POST, true);
      curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
      curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type' => 'multipart/form-data'));
      // curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
      $result = curl_exec($curl);

      return $result;
    }

    public function execut_docbox_new($data = array(), $url)
    {
      $headers = array(
        'Content-Type: application/json',
        'Accept: application/json'
      );

      $curl = curl_init();
      curl_setopt($curl, CURLOPT_URL, $url);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_POST, true);
      curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
      // curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

      $result = curl_exec($curl);

      if (curl_errno($curl)) {
        echo 'Curl error: ' . curl_error($curl);
      }

      curl_close($curl);
      return $result;
    }







    //charger d'executer les requetes vers bps pour le data de format form_data
    public function executeFormData($url, $data = array(), $method = 'POST', $token = '')
    {
      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_ENCODING, 1);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

      if ($method == 'POST') {
        curl_setopt($ch, CURLOPT_POST, 1);
      } elseif ($method == 'PUT') {
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
      }

      // Convertir les données FormData en chaîne de requête
      if (!empty($data)) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
      }

      // curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded', 'Accept: application/json', 'Accept-Encoding: deflate', 'Authorization: Bearer ' . $token));

      curl_setopt($ch, CURLOPT_HEADER, 0);
      curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

      $response = curl_exec($ch);

      if (curl_errno($ch)) {
        $error_msg = curl_error($ch);
        curl_close($ch);
        return array('error' => $error_msg);
      } else {
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return array('http_code' => $http_code, 'response' => $response);
      }
    }

    //charger de retourner les infos pour authentification en envoyant une requete vers bps
    public function login($username)
    {
      $data = array(
        'login' => $username,
      );

      $url = "https://" . $this->base_url . "/api/v1/applicant-verify";

      $reponse =  $this->execute($url, json_encode($data), 'POST', $this->getToken());

      return $reponse;
    }

    //recuperer les info du requerant avec son id requete envoyer vers bps
    public function info_requerant0307($id)
    {
      $url = "http://" . $this->base_url . "/api/v1/applicants-details/" . $id;
      $reponse =  $this->new_execute($url, '', $method = 'GET', $this->getToken());
      return $reponse;
    }

    // recuperer les informations complet d'un requerant requete envoye vers bps
    public function data_requerant($num_parcelle)
    {
      $resultat = $this->parcelle($num_parcelle);

      $response = 'info inexistant';

      if (is_object($resultat) && isset($resultat->success) && $resultat->success != '') {
        $response = $this->info_requerant($resultat->data->id);
      }
      return $response;
    }


    // charger d'envoyer une requete de login vers docbox(EDRMS MEDIABOX)
    public function connexion()
    {
      $data = array(
        'username' => "admin@doc.bi",
        'password' => "12345678"
      );

      $url = "https://" . $this->base_login . "/classeur/Test_Archivage/login";

      $reponse =  $this->execut_docbox($data, $url);

      return $reponse;
    }

    // charger de creer un dossier dans un autre dossier vers docbox(EDRMS MEDIABOX) ENTRE AUTRE AU NIVEAU DE LA NATURE
    public function creationSousDossier($fold_token, $fold_name, $description)
    {
      $resultat = $this->connexion();

      $var = json_decode($resultat);
      $datas='';
      $url='';

      $response = "Vos identifiants ne sont pas correctes";

      if ($var->status == 200) {
        $url = "https://" . $this->base_login . "/classeur/Test_Archivage/creation_fold/" . $var->ticket;

        $datas = array(
          "token" => $var->token,
          "fold_token" => $fold_token,
          "fold_name" => $fold_name,
          "description" => $description,
          "metadata" => [
            "classeur_name" => "PMS TEST",
            "description" => $description
          ]
        );
        $response =  $this->execut_docbox($datas, $url);
      }
      return $response;
    }
    // charger de deplacer un dossier et son contenu dans un autre dossier vers docbox(EDRMS MEDIABOX)
    public function deplacerDossier($fold_token, $fold_token_dest)
    {
      $resultat = $this->connexion();
      $var = json_decode($resultat);

      $response = "Vos identifiants ne sont pas correctes";

      if ($var->status == "200") {
        $url = "https://" . $this->base_login . "/classeur/Test_Archivage/deplace_folds/" . $var->ticket;

        $datas = array(
          "token" => $var->token,
          "fold_token" => $fold_token,
          "fold_token_dest" => $fold_token_dest,
        );

        $response =  $this->execut_docbox($datas, $url);
      }
      return $response;
    }
    // charger de deplacer les fichiers d'une demande x dans un autre dossier vers docbox(EDRMS MEDIABOX) <franssen@mediabox.bi>
    public function sendFileByDemand($code_demande, $token)
    {
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

          $this->send_file($tab_doc_id1[5], $tab_doc_id1[4], $token, "PMS TEST", $desc_nom_doc, $tab_doc_id[0]);
        }
        return true;
      } else {
        return false;
      }
    }

    // charger de deplacer les fichiers d'une demande x dans un autre dossier vers docbox(EDRMS MEDIABOX) <franssen@mediabox.bi>
    public function sendFileByDemandAlfresco($code_demande, $token)
    {
      $data = $this->envoyer_ficher_alfresco($code_demande);
      $message = '';
      if (!empty($data)) {
        $donnees_get = str_replace('@', '', $data);
        $get_index_datas = explode('<>', $donnees_get);

        for ($i = 0; $i < count($get_index_datas) - 1; $i++) {
          $tab_doc_id = explode('#', $get_index_datas[$i]);
          $tab_doc_id1 = explode('/', $tab_doc_id[0]);

          $getnom_doc = $this->CI->Model->getOne('pms_documents', ['ID_DOCUMENT' => $tab_doc_id[1]]);
          $desc_nom_doc = (!empty($getnom_doc['DESC_DOCUMENT'])) ? $getnom_doc['DESC_DOCUMENT'] : '';
          $data = $this->send_file_to_alfresco($tab_doc_id1[3], $tab_doc_id1[6], $tab_doc_id1[4], $tab_doc_id1[5], $token, $desc_nom_doc);
        }
        return true;
      } else {
        return false;
      }
    }

    // charger de recuperer les informations du dossier vers docbox(EDRMS MEDIABOX)
    public function recupererInfoDossier($fold_token)
    {
      $resultat = $this->connexion();
      $var = json_decode($resultat);

      $response = "Vos identifiants ne sont pas correctes";

      if ($var->status == "200") {
        $url = "https://" . $this->base_login . "/classeur/Test_Archivage/get_content_fold/" . $var->ticket;

        $datas = array(
          "token" => $var->token,
          "fold_token" => $fold_token,
        );

        $response =  $this->execut_docbox($datas, $url);
      }
      return $response;
    }
    // charger de recuperer les informations de la province par ID de la COLLINE
    public function recupererInfoProvince($collineId)
    {
      $endroit = $this->CI->Model->getRequeteOne('SELECT syst_provinces.PROVINCE_ID,syst_provinces.PROVINCE_NAME,communes.COMMUNE_ID, communes.COMMUNE_NAME,pms_zones.ZONE_ID,pms_zones.ZONE_NAME,collines.COLLINE_ID,collines.COLLINE_NAME FROM collines JOIN pms_zones on pms_zones.ZONE_ID=collines.ZONE_ID JOIN communes ON communes.COMMUNE_ID=pms_zones.COMMUNE_ID JOIN syst_provinces ON syst_provinces.PROVINCE_ID=communes.PROVINCE_ID WHERE collines.COLLINE_ID=' . $collineId);
      return $endroit;
    }

    //la fonction qui creer un sous dossier dans le dossier parcelle,deplacer le sous dossier existant dans ce nouveau sous dossier et deplacer tous les fichiers lie a la demande donnee dans le nouveau sous dossier et update le token de sous dossier de la parcelle dans bps 
    public function send_file_actualisation($idRequerant, $idDemande, $codeDemande, $numeroParcelle)
    {
      $message = '';
      $requerant = $this->info_requerant($idRequerant);

      if ($requerant->data) {
        $getRequerant = $this->login($requerant->data[0]->email);
        // print_r($getRequerant);die();
        if ($getRequerant) {
          $parcelle = $getRequerant->data->NUMERO_PARCELLE;
          if ($parcelle) {

            for ($i = 0; $i < count($parcelle); $i++) {

              if ($parcelle[$i]->NUMERO_PARCELLE == $numeroParcelle) {

                $createSubFolder = '';
                $objetJson = '';
                $foldToken = '';
                $subFoldToken = '';
                $idParcelle = '';
                // $idParcelle = 589;
                if ($parcelle[$i]->DOC_TOKEN != null) {
                  // print_r($parcelle);
                  // die();
                  $colline = $parcelle[$i]->COLLINE_ID;
                  $fold_token = $parcelle[$i]->DOC_TOKEN;
                  // print_r($fold_token);die();

                  $subFoldToken = $parcelle[$i]->DOC_REF_TOKEN;
                  $idParcelle = $parcelle[$i]->ID_PARCELLE;
                  $fold_name = "D" . $idDemande;
                  $description = "D" . $idDemande;
                  $infoDossier = $this->recupererInfoDossier($fold_token);
                  $convertJson = json_decode($infoDossier, true);
                  $urlFolder = $convertJson['detail_fold']['url_folder'];
                  $parts = explode('/', $urlFolder);
                  $valueNature = $parts[3];
                  if ($valueNature == "D") {
                    $createSubFolder = $this->creationSousDossier($fold_token, $fold_name, $description);
                    $objetJson = json_decode($createSubFolder, true);
                    if ($objetJson['status'] == 200) {
                      $foldToken = $objetJson['fold_token'];
                      $table = 'edrms_repertoire_processus_sous_repertoire_new';
                      $dataUpdate = array(
                        'statut_actualisation' => 0
                      );
                      $UpdateOldFold = $this->CI->Model->update($table, array('token_sous_repertoire' => $subFoldToken), $dataUpdate);
                      $dataCreate = array(
                        'nom_sous_repertoire' => $fold_name,
                        'token_sous_repertoire' => $foldToken,
                        'statut_actualisation' => 1
                      );
                      $creationNewFold = $this->CI->Model->create($table, $dataCreate);
                      $moveFolder = $this->deplacerDossier($subFoldToken, $foldToken);
                      $updateTokenSubFoldParcelle = $this->modifierParcelle($idParcelle, $foldToken);
                      $sendFile = $this->sendFileByDemand($codeDemande, $foldToken);
                      if ($sendFile) {
                        $message = '<div class="alert alert-success text-center" id="message">Archivage effectué avec succès</div>';
                      } else {
                        $message = '<div class="alert alert-danger text-center" id="message">archivage echoué</div>';
                      }
                    } else {
                      $message = '<div class="alert alert-danger text-center" id="message">le dossier portant ce nom existe deja</div>';
                    }
                  } else {
                    $province = $this->recupererInfoProvince($colline);
                    $tokenD = $this->CI->Model->getRequeteOne('SELECT ID,ID_PROVINCE,ID_NATURE,TOKEN FROM edrms_docbox_province_nature WHERE ID_NATURE=9 and ID_PROVINCE=' . $province['PROVINCE_ID']);
                    if ($tokenD) {
                      $moveFolder = $this->deplacerDossier($fold_token, $tokenD['TOKEN']);
                      $createSubFolder = $this->creationSousDossier($fold_token, $fold_name, $description);

                      $objetJson = json_decode($createSubFolder, true);
                      if ($objetJson['status'] == 200) {
                        $foldToken = $objetJson['fold_token'];
                        $table = 'edrms_repertoire_processus_sous_repertoire_new';
                        $dataUpdate = array(
                          'statut_actualisation' => 0
                        );
                        $UpdateOldFold = $this->CI->Model->update($table, array('token_sous_repertoire' => $subFoldToken), $dataUpdate);
                        $dataCreate = array(
                          'nom_sous_repertoire' => $fold_name,
                          'token_sous_repertoire' => $foldToken,
                          'statut_actualisation' => 1
                        );
                        $creationNewFold = $this->CI->Model->create($table, $dataCreate);

                        $moveFolder = $this->deplacerDossier($subFoldToken, $foldToken);
                        $updateTokenSubFoldParcelle = $this->modifierParcelle($idParcelle, $foldToken);

                        $sendFile = $this->sendFileByDemand($codeDemande, $foldToken);
                        if ($sendFile) {
                          $message = '<div class="alert alert-success text-center" id="message">Archivage effectué avec succès</div>';
                        } else {
                          $message = '<div class="alert alert-danger text-center" id="message">archivage echoué</div>';
                        }
                      } else {
                        $message = '<div class="alert alert-danger text-center" id="message">le dossier portant ce nom existe deja</div>';
                      }
                    } else {
                      $message = '<div class="alert alert-danger text-center" id="message">le dossier D pour cette province n\'existe pas</div>';
                    }
                  }
                } else {
                  $message = '<div class="alert alert-danger text-center" id="message">la parcelle n\'a pas de dossier</div>';
                }
              }
            }
          } else {
            $message = '<div class="alert alert-danger text-center" id="message">Le requerant n\'a pas de parcelle</div>';
          }
        } else {
          $message = '<div class="alert alert-danger text-center" id="message">Le requerant n\'existe pas</div>';
        }
      } else {
        $message = '<div class="alert alert-danger text-center" id="message">Le requerant n\'existe pas</div>';
      }
    }
    // charger de modifier le statut de parcelle dans la table parcelle de BPS vers BPS <franssen@mediabox.bi>
    public function setParcelleAnnuler($idParcelle)
    {
      $data = array(
        "STATUT_ID" => 5,
        "_method"   => "PUT",
      );

      $url = "https://" . $this->base_url . "/api/v1/plots/" . $idParcelle;
      $res =  $this->executeFormData($url, $data, 'POST', $this->getToken());
      return $res;
    }

    // L'annulation de la parcelle dans la table parcelle_attribution cote (BPS) <franssen@mediabox.bi>
    public function setParcelleAttributionAnnuler($numParcelle)
    {
      $data = array(
        "STATUT_ID" => 5,
        "_method"   => "PUT",
      );

      $url = "https://" . $this->base_url . "/api/v1/attributionUpdate/" . $numParcelle;
      $res =  $this->executeFormData($url, $data, 'POST', $this->getToken());
      return $res;
    }

    // charger de inserrer une nouvelle parcelle dans la table parcelle de BPS vers BPS <franssen@mediabox.bi>
    public function saveParcelle($numero, $superficie, $province, $commune, $zone, $colline, $provinceName, $communeName, $zoneName, $collineName, $proprietaire, $docToken, $docRefToken, $alfToken, $alfRefToken)
    {
      $datas = array(
        'NUMERO_PARCELLE'               => $numero,
        'SUPERFICIE'                    => $superficie,
        'PRIX'                          => 0,
        'STATUT_ID'                     => 3,
        'PROVINCE_ID'                   => $province,
        'COMMUNE_ID'                    => $commune,
        'ZONE_ID'                       => $zone,
        'COLLINE_ID'                    => $colline,
        'PROVINCE'                      => $provinceName,
        'COMMUNE'                       => $communeName,
        'ZONE'                          => $zoneName,
        'COLLINE'                       => $collineName,
        'ID_TYPE_PROPRIETAIRE_PARCELLE' => $proprietaire,
        'DOC_TOKEN'                     => $docToken,
        'DOC_REF_TOKEN'                 => $docRefToken,
        'ALF_TOKEN'                     => $alfToken,
        'ALF_REF_TOKEN'                 => $alfRefToken,
        'PROVENCANCE'                   => 2,
      );
      $url = "https://" . $this->base_url . "/api/v1/parcelle/create";
      $response =  $this->executeFormData($url, $datas, 'POST', $this->getToken());
      return $response;
    }


    // charger de modifier le token de sous dossier de la parcelle dans la table parcelle de BPS vers BPS <franssen@mediabox.bi>
    public function modifierParcelle($idParcelle, $docRefToken)
    {
      $url = "https://" . $this->base_url . "/api/v1/plots/" . $idParcelle;
      $datas = array(
        "DOC_REF_TOKEN" => $docRefToken,
        "_method" => "PUT",
      );

      $response =  $this->executeFormData($url, $datas, 'POST', $this->getToken());
      return $response;
    }

    // charger de modifier l'information de la parcelle (STATUT_PARCELLE) dans la table parcelle de BPS <franssen@mediabox.bi>
    public function modifierInfoParcelleBPS($idParcelle, $statut_parcelle, $process)
    {
      $url = "https://" . $this->base_url . "/api/v1/plots/" . $idParcelle;
      $data = array("_method" => "PUT");

      switch ($process) {
        case 13:
        case 26:
          $data["STATUT_PARCELLE_HYPOTHEQUE"] = $statut_parcelle;
          break;
        case 14:
          $data["STATUT_PARCELLE_HYPOTHEQUE"] = 0;
          break;
        case 18:
          $data["STATUT_PARCELLE_OPPOSITION"] = $statut_parcelle;
          break;
        default:
          return "Invalid process code";
      }

      $res = $this->executeFormData($url, $data, 'POST', $this->getToken());
      return $res;
    }

    // Updated statut cote BPS <franssen@mediabox.bi> <franssen@mediabox.bi>
    public function setStatutParcelleAttribution($num_parcelle, $statut_parcelle, $process)
    {
      $url = "https://" . $this->base_url . "/api/v1/attributionUpdateStatut/" . $num_parcelle;
      $data = array("_method" => "PUT");

      switch ($process) {
        case 13:
        case 26:
          $data["STATUT_PARCELLE_HYPOTHEQUE"] = $statut_parcelle;
          break;
        case 14:
          $data["STATUT_PARCELLE_HYPOTHEQUE"] = 0;
          break;
        case 18:
          $data["STATUT_PARCELLE_OPPOSITION"] = $statut_parcelle;
          break;
        default:
          return "Invalid process code";
      }

      $res = $this->executeFormData($url, $data, 'POST', $this->getToken());
      return $res;
    }

    //charger de retourner les infos de la parcelle requete envoye vers bps
    public function parcelle($parcelle)
    {
      $url = "https://" . $this->base_url . "/api/v1/parcelle-detail?num=" ."$parcelle";
      $reponse =  $this->execute($url, '', 'GET', $this->getToken());
      return $reponse;
    }
    //se connecter A bps
    public function getToken()
    {
      $data = array(
        'EMAIL' => 'agentobuha@dtfobuha.bi',
        'PASSWORD' => '12345678'
      );
      $url = "https://" . $this->base_url . "/api/v1/auth/login";
      $reponse =  $this->execute($url, json_encode($data));
     
      // print_r($reponse);
      // exit();
      if (!empty($reponse)) {
        return $reponse->data->token;
        //return 'hello world';    
      } else {
        return NULL;
      }
    }
    //recuperer le contenu d'un dossier à partir de docbox
    public function get_folder_content($value)
    {
      $resultat = $this->connexion();

      $var = json_decode($resultat);

      $response = "Vos identifiants ne sont pas correctes";


      if ($var->status == "200")
      {
        $url = "https://" . $this->base_login . "/classeur/Test_Archivage/get_content_by_name/" . $var->ticket;
        https://devapi.mediabox.bi/classeur/Test_Archivage/get_content_fold_by_name/c4ca4238a0b923820dcc509a6f75849b

        $datas = array(
          "token" => "$var->token",
          "fold_name" => "$value",
        );
        $response =  $this->execut_docbox($datas, $url);
        
      }

      return $response;
    }

    //Voir dossier initial à partir de docbox (EDRMS MEDIABOX)
    public function dossier_initial($numero_parcelle)
    {
      $resultat = $this->connexion();

      $var = json_decode($resultat);

      $response = "La connexion n\'est pas bonne";
      $var1 = '';
      $datas = '';

      if (isset($var->status) && $var->status == "200") {
        $url = "https://" . $this->base_login . "/classeur/Test_Archivage/get_content_by_name/" . $var->ticket;

        $datas = array(
          "token" => "$var->token",
          "fold_name" => "$numero_parcelle"
        );

        $response =  $this->execut_docbox($datas, $url);


        $var1 = json_decode($response);

        $response = '<div class="alert alert-danger text-center" id="message">La parcelle n\'existe pas.</div>';

        if ($var1->status == "200") {
          $url = "https://" . $this->base_login . "/classeur/Test_Archivage/get_content_fold/" . $var->ticket;


          $datas = array(
            "token" => $var->token,
            "fold_token" => isset($var1->data->dossier->token) ? $var1->data->dossier->token : null
            // "fold_token" => isset($var1->data->dossier[0]->token) ? $var1->data->dossier[0]->token : null
            // "fold_token" => $var1->data->dossier[0]->token,
          );

          $response =  $this->execut_docbox($datas, $url);

          $var2 = json_decode($response);


          $response = 'Le dossier n\'existe pas';

          if ($var2->status == "200") {
            $response = 'Le dossier est vide';
            if ($var2->data->fichier != '') {
              // if ($var2->data->fichier[0] != '') {
              $response = '<div style="overflow:scroll;height:200px;width:100%"><table class="table table-sm table-bordered table-hover table-striped">
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
              foreach ($var2->data->fichier as $key) {
                if (!file_exists($key->path)) {
                  // Check if the file has a valid extension
                  $validExtensions = array('png', 'jpg', 'jpeg', 'gif');
                  $fileExtension = pathinfo($key->path, PATHINFO_EXTENSION);
                  if (in_array($fileExtension, $validExtensions)) {
                    $response .= '<tr><td>' . $key->nom_folder_fichier . '</td><td><a onclick="geturl(\'' . $key->path . '\')">Voir</a></td></tr>';
                  }
                } else {
                  $response .= "";
                }
              }

              $response .= '</tbody></table></div>';
            }
          }
        }
      }

      return $response;
    }

    //recuperer les info d'une parcelle et des sous-dossier
    public function get_info($num_parcelle)
    {
      $token_parcelle = '';
      $token_sous_dossier = '';

      $message = 'Le dossier est vide';

      $result = $this->get_folder_content($num_parcelle);

      if (json_decode($result)->status == 200) {
        $token_parcelle = json_decode($result)->detail_fold->fold_parrent_token;

        $message = 'La parcelle n\'a pas de sous-dossier';
      }
      return $result;
    }

    //partager infor requerant
    public function share_applicant(
      $fullname,
      $username,
      $email,
      $password,
      $mobile,
      $registeras,
      $country_code,
      $province_id,
      $commune_id,
      $date_naissance,
      $father_fullname,
      $mother_fullname,
      $lieu_delivrance,
      $date_delivrance,
      $num_parcelle,
      $superficie,
      $usage_id,
      $prix,
      $nif,
      $zone_id_naissance,
      $colline_id_naissance,
      $sexe,
      $boite_postale,
      $avenue,
      $profile_image_path,
      $signature_image,
      $cni_image,
      $colline_id,
      $DOC_TOKEN,
      $ALF_TOKEN,
      $DOC_REF_TOKEN,
      $ALF_REF_TOKEN,
      $cni,
      $volume,
      $folio
    ) {
      $data = array(
        'fullname' => $fullname,
        'username' => $username,
        'email' => $email,
        'email_confirmation' => $email,
        'password' => $password,
        'password_confirmation' => $password,
        'mobile' => $mobile,
        'registeras' => $registeras,
        'country_code' => $country_code,
        'province_id' => $province_id,
        'commune_id' => $commune_id,
        'date_naissance' => $date_naissance,
        'father_fullname' => $father_fullname,
        'mother_fullname' => $mother_fullname,
        'boite_postale' => $boite_postale,
        'nif' => $nif,
        'COLLINE_ID' => $colline_id_naissance,
        'type_document_id' => 3, // 1: Passeport; 2: CPGL; 3: CNI
        'document_num' => $cni,
        'LIEU_DELIVRANCE' => $lieu_delivrance,
        'DATE_DELIVRANCE' => $date_delivrance,
        "profile_pic" => new CURLFile(FCPATH . "uploads/doc_scanner/" . $profile_image_path),
        "document_path" => new CURLFile(FCPATH . "uploads/doc_scanner/" . $cni_image),
        "SIGNATURE" => new CURLFile(FCPATH . "uploads/doc_scanner/" . $signature_image),
        'sexe_id' => $sexe, // 1: Masculin; 2: Féminin
        'ZONE_ID' => $zone_id_naissance,
        'rc' => "",
        'reseau_social' => "",
        'siege' => "",
        'NUMERO_PARCELLE' => $num_parcelle,
        'SUPERFICIE' => $superficie,
        'STATUT_ID' => 3, // 
        'COLLINE_PARCELLE_ID' => $colline_id,
        'PRIX' => $prix,
        'USAGE_ID' => $usage_id,
        'AVENUE' => $avenue,
        'DOC_TOKEN' => $DOC_TOKEN,
        'ALF_TOKEN' => $ALF_TOKEN,
        'DOC_REF_TOKEN' => $DOC_REF_TOKEN,
        'ALF_REF_TOKEN' => $ALF_REF_TOKEN,
        'VOLUME'  => $volume,
        'FOLIO'  => $folio,
      );
      // print_r($data);
      // exit();

      $url = "https://" . $this->base_url . "/api/v1/create-applicant-attribution";
      // $reponse =  $this->executing($url, json_encode($data));
      $reponse =  $this->executing($url, $data);
      

      return $reponse;
    }

    // Created applicant and the plots
    public function storeGetEmailApplicant(
      $email,
      $numero_parcelle,
      $superficie,
      $prix,
      $statut_id,
      $colline_parcelle_id,
      $colline_id,
      $usage_id,
      $volume,
      $folio,
      $docoken,
      $docRefToken,
      $alfToken,
      $alfRefToken
    ) {
      $data = [
        'email'               => $email,
        'NUMERO_PARCELLE'     => $numero_parcelle,
        'SUPERFICIE'          => $superficie,
        'PRIX'                => $prix,
        'STATUT_ID'           => $statut_id,
        'COLLINE_PARCELLE_ID' => $colline_parcelle_id,
        'COLLINE_ID'          => $colline_id,
        'USAGE_ID'            => $usage_id,
        'VOLUME'              => $volume,
        'FOLIO'               => $folio,
        'DOC_TOKEN'           => $docoken,
        'DOC_REF_TOKEN'       => $docRefToken,
        'ALF_TOKEN'           => $alfToken,
        'ALF_REF_TOKEN'       => $alfRefToken
      ];

      $url = "http://" . $this->base_url . "/api/v1/create/applicant-email";
      $res =  $this->executing($url, $data);
      return $res;
    }

    // FORGOT password for applicant
    public function forgotPassword($email)
    {
      $data = ['email' => $email];
      $url = "http://" . $this->base_url . "/api/v1/applicants/password-forgot";
      $res =  $this->executing($url, $data);
      return $res;
    }

    //partager infor requerant
    public function share_applicant28062024(
      $fullname,
      $username,
      $email,
      $password,
      $mobile,
      $registeras,
      $country_code,
      $province_id,
      $commune_id,
      $date_naissance,
      $father_fullname,
      $mother_fullname,
      $lieu_delivrance,
      $date_delivrance,
      $num_parcelle,
      $superficie,
      $usage_id,
      $prix,
      $nif,
      $zone_id_naissance,
      $colline_id_naissance,
      $sexe,
      $boite_postale,
      $avenue,
      $profile_image_path,
      $signature_image,
      $cni_image,
      $colline_id,
      $DOC_TOKEN,
      $ALF_TOKEN,
      $DOC_REF_TOKEN,
      $ALF_REF_TOKEN,
      $cni
    ) {
      $data = array(
        'fullname' => $fullname,
        'username' => $username,
        'email' => $email,
        'email_confirmation' => $email,
        'password' => $password,
        'password_confirmation' => $password,
        'mobile' => $mobile,
        'registeras' => $registeras,
        'country_code' => $country_code,
        'province_id' => $province_id,
        'commune_id' => $commune_id,
        'date_naissance' => $date_naissance,
        'father_fullname' => $father_fullname,
        'mother_fullname' => $mother_fullname,
        'boite_postale' => $boite_postale,
        'nif' => $nif,
        'COLLINE_ID' => $colline_id_naissance,
        'type_document_id' => 3, // 1: Passeport; 2: CPGL; 3: CNI
        'document_num' => $cni,
        'LIEU_DELIVRANCE' => $lieu_delivrance,
        'DATE_DELIVRANCE' => $date_delivrance,
        "profile_pic" => new CURLFile(FCPATH . "uploads/doc_scanner/" . $profile_image_path),
        "document_path" => new CURLFile(FCPATH . "uploads/doc_scanner/" . $cni_image),
        "SIGNATURE" => new CURLFile(FCPATH . "uploads/doc_scanner/" . $signature_image),
        'sexe_id' => $sexe, // 1: Masculin; 2: Féminin
        'ZONE_ID' => $zone_id_naissance,
        'rc' => "",
        'reseau_social' => "",
        'siege' => "",
        'NUMERO_PARCELLE' => $num_parcelle,
        'SUPERFICIE' => $superficie,
        'STATUT_ID' => 3, // 
        'COLLINE_PARCELLE_ID' => $colline_id,
        'PRIX' => $prix,
        'USAGE_ID' => $usage_id,
        'AVENUE' => $avenue,
        'DOC_TOKEN' => $DOC_TOKEN,
        'ALF_TOKEN' => $ALF_TOKEN,
        'DOC_REF_TOKEN' => $DOC_REF_TOKEN,
        'ALF_REF_TOKEN' => $ALF_REF_TOKEN
      );

      $url = "https://" . $this->base_url . "/api/v1/create-applicant-attribution";
      $response =  $this->executing($data, $url);
      // echo $url;
      // $response = executing($data, $url);
      if (isset($response['error'])) {
        echo "Error: " . $response['error'];
      } else {
        echo "HTTP code: " . $response['http_code'];
        echo "Response: " . $response['response'];
      }

      //return $reponse;
    }

    public function createApplicant(
      $fullname,
      $username,
      $email,
      $password,
      $mobile,
      $registeras,
      $country_code,
      $province_id,
      $commune_id,
      $date_naissance,
      $father_fullname,
      $mother_fullname,
      $lieu_delivrance,
      $date_delivrance,
      $num_parcelle,
      $superficie,
      $usage_id,
      $prix,
      $nif,
      $zone_id_naissance,
      $colline_id_naissance,
      $sexe,
      $boite_postale,
      $avenue,
      $profile_image_path,
      $signature_image,
      $cni_image,
      $colline_id,
      $DOC_TOKEN,
      $ALF_TOKEN,
      $DOC_REF_TOKEN,
      $ALF_REF_TOKEN,
      $cni
    ) {
      $data = array(
        'fullname' => $fullname,
        'username' => $username,
        'email' => $email,
        'email_confirmation' => $email,
        'password' => $password,
        'password_confirmation' => $password,
        'mobile' => $mobile,
        'registeras' => $registeras,
        'country_code' => $country_code,
        'province_id' => $province_id,
        'commune_id' => $commune_id,
        'date_naissance' => $date_naissance,
        'father_fullname' => $father_fullname,
        'mother_fullname' => $mother_fullname,
        'boite_postale' => $boite_postale,
        'nif' => $nif,
        'COLLINE_ID' => $colline_id_naissance,
        'type_document_id' => 3, // 1: Passeport; 2: CPGL; 3: CNI
        'document_num' => $cni,
        'LIEU_DELIVRANCE' => $lieu_delivrance,
        'DATE_DELIVRANCE' => $date_delivrance,
        "profile_pic" => new CURLFile(FCPATH . "uploads/doc_scanner/" . $profile_image_path),
        "document_path" => new CURLFile(FCPATH . "uploads/doc_scanner/" . $cni_image),
        "SIGNATURE" => new CURLFile(FCPATH . "uploads/doc_scanner/" . $signature_image),
        'sexe_id' => $sexe, // 1: Masculin; 2: Féminin
        'ZONE_ID' => $zone_id_naissance,
        'rc' => "",
        'reseau_social' => "",
        'siege' => "",
        'NUMERO_PARCELLE' => $num_parcelle,
        'SUPERFICIE' => $superficie,
        'STATUT_ID' => 3, // 
        'COLLINE_PARCELLE_ID' => $colline_id,
        'PRIX' => $prix,
        'USAGE_ID' => $usage_id,
        'AVENUE' => $avenue,
        'DOC_TOKEN' => $DOC_TOKEN,
        'ALF_TOKEN' => $ALF_TOKEN,
        'DOC_REF_TOKEN' => $DOC_REF_TOKEN,
        'ALF_REF_TOKEN' => $ALF_REF_TOKEN
      );

      $url = "https://" . $this->base_url . "/api/v1/create-applicant";
      $reponse =  $this->executing($url, json_encode($data));
      //$res =  $this->executeFormData($url, $data, 'POST');
      return $reponse;
    }

    // Updated password for the applicant
    public function resetPasswordApplicant($time, $email, $new_password, $confirme_new_password)
    {
      $data = [
        'TIME'                 => $time,
        'EMAIL'                => $email,
        'NEW_PASSWORD'         => $new_password,
        'CONFIRM_NEW_PASSWORD' => $confirme_new_password,
      ];

      $url = "http://" . $this->base_url . "/api/v1/applicants/reset-password";
      $reponse =  $this->executing_modify($url,$data);
      return $reponse;
    }

    //creer un nouveau requerant vers bps
    public function create_applicant($fullname, $username, $email, $password, $mobile, $registeras, $country_code, $province_id, $commune_id, $date_naissance)
    {

      $data = array(
        'fullname'              => $fullname,
        'username'              => $username,
        'email'                 => $email,
        'email_confirmation'    => $email,
        'password'              => $password,
        'password_confirmation' => $password,
        'mobile'                => $mobile,
        'registeras'            => $registeras,
        'country_code'          => $country_code,
        'province_id'           => $province_id,
        'commune_id'            => $commune_id,
        'date_naissance'        => $date_naissance,

        // 'avatar'                => $avatar, ['email_verified_at' => date('Y-m-d H:i:s')
      );

      $url = "https://" . $this->base_url . "/api/v1/applicants";
      $reponse =  $this->executing($url, $data, 'POST');
      return $reponse;
    }


    public function updateInfosApplicant(
      $fullname,
      $username,
      $email,
      $mobile,
      $registeras,
      $country_code,
      $province_id,
      $commune_id,
      $zone_id,
      $type_document_id,
      $sexe_id,
      $cni,
      $nif,
      $lieu_delivrance,
      $date_delivrance,
      $date_naissance,
      $boite_postale,
      $id_applicant
    ) {
      $data = [
        'fullname'         => $fullname,
        'username'         => $username,
        'email'            => $email,
        'mobile'           => $mobile,
        'registeras'       => $registeras,
        'country_code'     => $country_code,
        'province_id'      => $province_id,
        'commune_id'       => $commune_id,
        'ZONE_ID'          => $zone_id,
        'type_document_id' => $type_document_id,
        'sexe_id'          => $sexe_id,
        'cni'              => $cni,
        'nif'              => $nif,
        'LIEU_DELIVRANCE'  => $lieu_delivrance,
        'DATE_DELIVRANCE'  => $date_delivrance,
        'date_naissance'   => $date_naissance,
        'boite_postale'    => $boite_postale,
        '_method'          => 'PUT',
      ];

      $url = "https://" . $this->base_url . "/api/v1/applicants/"  . $id_applicant;
      $res =  $this->executeFormData($url, $data, 'POST', $this->getToken());
      return $res;
    }

    // Created applicant type moral <franssen@mediabox.bi>
    public function shareApplicantMoral(
      $fullname,
      $username,
      $password,
      $mobile,
      $registeras,
      $country_code,
      $nom_entreprise,
      $boite_postale,
      $colline,
      $rc,
      $province_id,
      $commune_id,
      $email,
      $colline_parcelle_id,
      $zone_id,
      $signature_image,
      $num_parcelle,
      $superficie,
      $prix,
      $usage_id,
      $docoken,
      $alfToken,
      $docRefToken,
      $alfRefToken,
      $volume,
      $folio
    ) {
      $data = array(
        "fullname"              => $fullname,
        "username"              => $username,
        'password'              => $password,
        'password_confirmation' => $password,
        "mobile"                => $mobile,
        "registeras"            => $registeras,
        "country_code"          => $country_code,
        "reseau_social"         => $nom_entreprise,
        "boite_postale"         => $boite_postale,
        "COLLINE_ID"            => $colline,
        "rc"                    => $rc,
        "province_id"           => $province_id,
        "commune_id"            => $commune_id,
        'email'                 => $email,
        'email_confirmation'    => $email,
        "COLLINE_PARCELLE_ID"   => $colline_parcelle_id,
        "ZONE_ID"               => $zone_id,
        "SIGNATURE"             => new CURLFile(FCPATH . "uploads/doc_scanner/" . $signature_image),
        'NUMERO_PARCELLE'       => $num_parcelle,
        'NUMERO_CADASTRAL'      => $num_parcelle,
        'SUPERFICIE'            => $superficie,
        'STATUT_ID'             => 3, // 
        'PRIX'                  => $prix,
        'USAGE_ID'              => $usage_id,
        'DOC_TOKEN'             => $docoken,
        'ALF_TOKEN'             => $alfToken,
        'DOC_REF_TOKEN'         => $docRefToken,
        'ALF_REF_TOKEN'         => $alfRefToken,
        'VOLUME'                => $volume,
        'FOLIO'                 => $folio,
      );

      $url = "https://" . $this->base_url . "/api/v1/create/applicant-moral";
         
      // $res = $this->executeFormData($url, $data, 'POST');
      $res = $this->executingnew($url,$data);
      
      // $res = $this->executing($url, $data,'POST');
     //      echo "<pre>";
     //      print_r($res);
     // echo "</pre>";
     // die();

      return $res;
    }

    public function send_file25032024()
    {
      $resultat = $this->connexion();

      $var = json_decode($resultat);

      if ($var->status == "200") {
        $url = "https://" . $this->base_login . "/classeur/Test_Archivage/save_file_fold/" . $var->ticket;


        $baseURL = base_url(); // Replace with your API's base URL
        $filePath = "/uploads/avatar/avatar_female.png";

        $datas = array(
          "token" => "$var->token",
          "fold_token" => "847aad88f7a9ab0d484293da4be494a1",
          "file_nom" => "Fichier Test 10",
          "path_file" => base_url('uploads/notaires/20240308160557piece65eb3765bbfac.png'),
          "description" => "Province du nord de bujumbura-mairie",
          "metadata" => array(
            "classeur_name" => "Buja 11",
            "description" => "province du nord de bujumbura-mairie"
          )
        );
        $response =  $this->execut_docbox($datas, $url);
      }
      return $response;
    }


    // send_file_to_alfresco($tab_doc_id1[5]:$file_name,$tab_doc_id1[4]:$url_file,$token_repertoire['token_sous_repertoire']:$token_repertoire,
    // $desc_nom_doc:$description)

    public function send_file($file_name,$token, $classeur_name, $description_nom, $full_path)
    {

      $resultat = $this->connexion();


      $var = json_decode($resultat);

      $response='';
      $url='';
      $datas='';

      $files =  new CURLFile(FCPATH.$full_path, mime_content_type(FCPATH.$full_path), basename(FCPATH.$full_path));

      if ($var->status == "200") {
        $url = "https://" . $this->base_login . "/classeur/Test_file_save/upload_filedata_save/" . $var->ticket;

        $datas = array(
          "token" => "$var->token",
          "fold_token" => $token,
          "file_nom" => $description_nom,
          "description" => $description_nom,
          "metadata" => json_encode(array(
            "classeur_name" => $classeur_name,
            "description" => $description_nom
          )),
          "file" => $files,
        );
        $response =  $this->execut_docbox_new($datas, $url);
      }

      // print_r($response);
      // exit();

      return $response;
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
      $ticket = $this->connexion();

      $message = '';
      $message1 = '';
      $data_token = '';
      $token_repertoire = '';
      $id_parcelle = '';
      $code_de_parcelle = '';
      $all_token_file = '';

      $donnees_get = '';
      $index_donnees_get = '';
      $tab_doc_id = "";
      $tab_doc_id = "";
      $tab_doc_id1 = "";

      $code_de_parcelle = $this->CI->Model->getOne('pms_traitement_demande', array('CODE_DEMANDE' => $code_demande));

      if (!empty($donnees)) {
        if (!empty($code_de_parcelle)) {
          $id_processus_parcelle = $this->CI->Model->getRequeteOne("SELECT id,dossiers_processus_province_id,parcelle_id,numero_parcelle,nom_repertoire_parcelle,token_dossiers_parcelle_processus,menu_id,dossier_id FROM edrms_repertoire_processus_parcelle_new WHERE numero_parcelle='" . trim($code_de_parcelle['NUMERO_PARCELLE']) . "' ORDER BY id DESC");
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
              } else {
                $desc_nom_doc = $getnom_doc['DESC_DOCUMENT'];
              }

              $message1 = $this->send_file($tab_doc_id1[5], $tab_doc_id1[4], $token_repertoire['token_sous_repertoire'], $token_repertoire['nom_sous_repertoire'], $desc_nom_doc, $tab_doc_id[0]);
            }

            $message = '<div class="alert alert-success text-center" id="message">Archivage éffectué avec succés</div>';
          } else {
            $message = '<div class="alert alert-danger text-center" id="message">LE TOKEN EST INEXISTANT,archivage echoué</div>';
          }
        } else {
          $message = '<div class="alert alert-danger text-center" id="message">Les informations de la parcelle n\'existe pas dans la table des demandes,archivage echoué</div>';
        }
      } else {
        $message = '<div class="alert alert-danger text-center" id="message">Les documents à archiver n\'existe pas</div>';
      }
      return $message;
    }

    // fonction permet d'enregistrer les informations des catégories demandées vers DOCBOX (un système d'archivage) <franssen@mediabox.bi>
    public function send_category_demande_info_doc_box($code_demande, $token)
    {
      // Appelle une méthode pour se connecter à une base de données. 
      $this->connexion();
      $data = $this->envoyer_ficher($code_demande);
      $message = '';
      // Vérifie si la variable  $data  n'est pas vide
      if (!empty($data)) {
        //Remplace les caracteres '@' dans le $data par une chaine vide  et stocke le resultat dans $donnees_get
        $donnees_get = str_replace('@', '', $data);
        $get_index_datas = explode('<>', $donnees_get);
        // Boucle à travers les éléments du tableau  $get_index_datas
        for ($i = 0; $i < count($get_index_datas) - 1; $i++) {
          $tab_doc_id = explode('#', $get_index_datas[$i]);
          $tab_doc_id1 = explode('/', $tab_doc_id[0]);

          $getnom_doc = $this->CI->Model->getOne('pms_documents', ['ID_DOCUMENT' => $tab_doc_id[1]]);
          $desc_nom_doc = (!empty($getnom_doc['DESC_DOCUMENT'])) ? $getnom_doc['DESC_DOCUMENT'] : '';

          $data = $this->send_file($tab_doc_id1[5], $tab_doc_id1[4], $token, 'PMS', $desc_nom_doc, $tab_doc_id[0]);
        }
        $message = '<div class="alert alert-success text-center" id="message">Archivage effectué avec succès</div>';
      } else {
        $message = '<div class="alert alert-danger text-center" id="message">LES FICHIERS SONT INEXISTANT, archivage échoué</div>';
      }
      return $message;
    }


    /**
     * Cette fonction est chargée de retourner les informations nécessaires pour générer le volume et le folio en envoyant une requête vers BPS.
     * Elle crée un tableau de données contenant les informations nécessaires, puis envoie une requête à une URL spécifique en utilisant les données
     * JSON fournies. Enfin, elle affiche le résultat de la requête sous forme de JSON. <franssen@mediabox.bi>
     */
    public function createdFolioVolume($id_parcelle, $date_signature, $date_delivrance, $numero_ordre_general, $delivrance, $numero_special)
    {
      $data = array(
        'ID_PARCELLE'          => $id_parcelle,
        'DATE_SIGNATURE'       => $date_signature,
        'DATE_DELIVRANCE'      => $date_delivrance,
        'NUMERO_ORDRE_GENERAL' => $numero_ordre_general,
        'DELIVRANCE'           => $delivrance,
        'NUMERO_SPECIAL'       => $numero_special,
      );

      $url = "https://" . $this->base_url . "/api/v1/create-volume-folio";
      $res = $this->execute($url, json_encode($data), 'POST', $this->getToken());

      return $res;
    }

    /**
     * Cette fonction appelle la fonction  createdFolioVolume  en lui passant les mêmes paramètres, puis affiche le résultat de cette fonction
     * sous forme de JSON. Elle est utilisée pour enregistrer le volume et le folio en fonction des informations fournies. <franssen@mediabox.bi>
     */


    public function saveFolioVolume($id_parcelle, $date_signature, $date_delivrance, $numero_ordre_general, $delivrance, $numero_special)
    {
      $res = $this->createdFolioVolume(
        $id_parcelle,
        $date_signature,
        $date_delivrance,
        $numero_ordre_general,
        $delivrance,
        $numero_special
      );
      return $res;
    }

    // Une fonction permet de modifer les infos de la parcelle et parcelle attribution du requerant en passant en params numero de la parcelle <franssen@mediabox.bi>
    public function updateDataInfoApplicantAttribution($numParcelle, $idRequerant)
    {
      $datas = array(
        "ID_REQUERANT" => $idRequerant,
        "_method" => "PUT",
      );
      $url = "https://" . $this->base_url . "/api/v1/attributionUpdate/" . $numParcelle;
      $res =  $this->executeFormData($url, $datas, 'POST', $this->getToken());
      return $res;
    }

    // Creation de l'attribition de la parcelle <franssen@mediabox.bi>
    public function createdAttributionPlot(
      $ID_PARCELLE,
      $ID_REQUERANT,
      $USAGE_ID,
      $STATUT_ID,
      $PROVINCE_ID,
      $COMMUNE_ID,
      $ZONE_ID,
      $COLLINE_ID,
      $NUMERO_PARCELLE,
      $PRIX,
      $SUPERFICIE,
      $SUPERFICIE_HA,
      $SUPERFICIE_ARE,
      $SUPERFICIE_CA,
      $VOLUME,
      $FOLIO,
      $NUMERO_ORDRE_GENERAL,
      $NUMERO_ORDRE_SPECIAL
    ) {

      $datas = array(
        'ID_PARCELLE'           => $ID_PARCELLE,
        'ID_REQUERANT'          => $ID_REQUERANT,
        'USAGE_ID'              => $USAGE_ID,
        'STATUT_ID'             => $STATUT_ID,
        'PROVINCE_ID'           => $PROVINCE_ID,
        'COMMUNE_ID'            => $COMMUNE_ID,
        'ZONE_ID'               => $ZONE_ID,
        'COLLINE_ID'            => $COLLINE_ID,
        'NUMERO_PARCELLE'       => $NUMERO_PARCELLE,
        'PRIX'                  => $PRIX,
        'SUPERFICIE'            => $SUPERFICIE,
        'SUPERFICIE_HA'         => $SUPERFICIE_HA,
        'SUPERFICIE_ARE'        => $SUPERFICIE_ARE,
        'SUPERFICIE_CA'         => $SUPERFICIE_CA,
        'IS_DISPACH'            => 0,
        'VOLUME'                => $VOLUME,
        'FOLIO'                 => $FOLIO,
        'STATUT_LIVRE_ATTRIBUE' => 0,
        'STATUT_FICHE'          => 0,
        'NUMERO_ORDRE_GENERAL'  => $NUMERO_ORDRE_GENERAL,
        'NUMERO_ORDRE_SPECIAL'  => $NUMERO_ORDRE_SPECIAL,
        'STATUT_GENERER'        => 0,
        'STATUT_GENERER_PV'     => 0,
        'SIGN_PV_CHEF_CADASTRE' => 0,
        'SIGN_PV_CONSERVATEUR'  => 0,
        'STATUT_CROQUIS'        => 0,
        'SIGN_TITRE'            => 0,
        'FICHE_GENERER'         => 0,
      );

      $url = "https://" . $this->base_url . "/api/v1/attribution/create";
      $res =  $this->execute($url, json_encode($datas), 'POST', $this->getToken());
      return $res;
    }

    /**
     * Cette fonction est chargée de créer des dossiers et de stocker des fichiers pour le morcellement en fonction de la demande de code
     * et du jeton fournis. Elle se connecte à une base de données, récupère des données, les traite, puis envoie les fichiers pour le stockage.
     * Elle renvoie un message indiquant le succès ou l'échec du processus d'archivage des fichiers pour le morcellement. <franssen@mediabox.bi>
     */
    public function save_create_folders_stockes_files_morcellement($code_demande, $token)
    {
      // Appelle une méthode pour se connecter à une base de données. 
      $this->connexion();
      $message = '';

      if (!empty($this->envoyer_ficher($code_demande))) {
        $donnees_get = str_replace('@', '', $this->envoyer_ficher($code_demande));
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

    /**
     * C'est une méthode qui gère la mise à jour et l'archivage de fichiers. Voici un résumé de ce qu'elle fait : 
     * Elle se connecte à une base de données. 
     * Elle récupère des données à partir d'un fichier en fonction du code de demande fourni. 
     * Elle traite ces données pour extraire des informations spécifiques. 
     * Elle envoie ces informations à une méthode pour envoyer des fichiers. 
     * Elle génère un message de succès ou d'échec en fonction du résultat de l'archivage. <franssen@mediabox.bi>
     */
    public function createMiseAjourPerte($code_demande, $docRefToken)
    {
      // Appelle une méthode pour se connecter à une base de données. 
      $this->connexion();
      $message = '';

      if (!empty($this->envoyer_ficher($code_demande))) {
        $donnees_get = str_replace('@', '', $this->envoyer_ficher($code_demande));
        $get_index_datas = explode('<>', $donnees_get);

        for ($i = 0; $i < count($get_index_datas) - 1; $i++) {
          $tab_doc_id = explode('#', $get_index_datas[$i]);
          $tab_doc_id1 = explode('/', $tab_doc_id[0]);

          $getnom_doc = $this->CI->Model->getOne('pms_documents', ['ID_DOCUMENT' => $tab_doc_id[1]]);
          $desc_nom_doc = (!empty($getnom_doc['DESC_DOCUMENT'])) ? $getnom_doc['DESC_DOCUMENT'] : '';

          $this->send_file($tab_doc_id1[5], $tab_doc_id1[4], $docRefToken, 'PMS', $desc_nom_doc, $tab_doc_id[0]);
        }
        $message = '<div class="alert alert-success text-center" id="message">Archivage effectué avec succès</div>';
      } else {
        $message = `<div class="alert alert-danger text-center" id="message">LES FICHIERS SONT INEXISTANT, archivage échoué</div>`;
      }
      return $message;
    }

    // Fn pour l'archivage de transfert <franssen@mediabox.bi>
    public function send_file_transfert(
      $idDemande,
      $codeDemande,
      $numeroParcelle,
      $isDocBox_Alfr,
      $fullname,
      $username,
      $email,
      $password,
      $mobile,
      $registeras,
      $province_id,
      $commune_id,
      $date_naissance,
      $father_fullname,
      $mother_fullname,
      $lieu_delivrance,
      $date_delivrance,
      $num_parcelle,
      $superficie,
      $usage_id,
      $prix,
      $country_code,
      $nif,
      $zone_id_naissance,
      $colline_id_naissance,
      $sexe,
      $boite_postale,
      $avenue,
      $profile_image_path,
      $signature_image,
      $cni_image,
      $colline_id,
      $DOC_TOKEN,
      $ALF_TOKEN,
      $DOC_REF_TOKEN,
      $ALF_REF_TOKEN,
      $cni
    ) {

      $message = '';

      if ($isDocBox_Alfr == 1) {
        //utilisation de Docbox
        if ($numeroParcelle) {
          $getParcelleByNum = $this->parcelle($numeroParcelle);
          if ($getParcelleByNum->success) {
            $getParcelleByNum->data->ID_PARCELLE;
            $description = "D" . $idDemande;
            $convertJson = json_decode($this->recupererInfoDossier($getParcelleByNum->data->DOC_TOKEN), true);
            $urlFolder = $convertJson['detail_fold']['url_folder'];
            $parts = explode('/', $urlFolder);
            $valueNature = $parts[3];

            if ($valueNature == "D") {
              $createSubFolder = $this->creationSousDossier($getParcelleByNum->data->DOC_TOKEN, $description, $description);
              $objetJson = json_decode($createSubFolder, true);
              if ($objetJson['status'] == 200) {

                $foldToken = $objetJson['fold_token'];

                $this->deplacerDossier($getParcelleByNum->data->DOC_REF_TOKEN, $foldToken);

                $sendFile = $this->sendFileByDemand($codeDemande, $foldToken);

                if ($sendFile) {
                  $message = '<div class="alert alert-success text-center" id="message">Archivage effectué avec succès</div>';
                } else {
                  $message = '<div class="alert alert-danger text-center" id="message">archivage echoué</div>';
                }
              } else {
                $message = '<div class="alert alert-danger text-center" id="message">le dossier portant ce nom existe deja</div>';
              }
            } else {
              $province = $this->recupererInfoProvince($getParcelleByNum->data->COLLINE_ID);

              $tokenD = $this->CI->Model->getRequeteOne(
                'SELECT ID,ID_PROVINCE,ID_NATURE,TOKEN FROM edrms_docbox_province_nature WHERE ID_NATURE=9 and ID_PROVINCE=' . $province['PROVINCE_ID']
              );

              if ($tokenD) {

                $this->deplacerDossier($getParcelleByNum->data->DOC_TOKEN, $tokenD['TOKEN']);
                $objetJson = json_decode($this->creationSousDossier($getParcelleByNum->data->DOC_TOKEN, $description, $description), true);

                if ($objetJson['status'] == 200) {
                  $foldToken = $objetJson['fold_token'];

                  $this->deplacerDossier($getParcelleByNum->data->DOC_REF_TOKEN, $foldToken);

                  $sendFile = $this->sendFileByDemand($codeDemande, $foldToken);

                  if ($sendFile) {
                    $message = '<div class="alert alert-success text-center" id="message">Archivage effectué avec succès</div>';
                  } else {
                    $message = '<div class="alert alert-danger text-center" id="message">archivage echoué</div>';
                  }
                } else {
                  $message = '<div class="alert alert-danger text-center" id="message">le dossier portant ce nom existe deja</div>';
                }
              } else {
                $message = '<div class="alert alert-danger text-center" id="message">Le dossier D pour cette province n\'existe pas</div>';
              }
            }
          } else {
            $message = '<div class="alert alert-danger text-center" id="message">ce numéro de parcelle n\'existe pas</div>';
          }
        } else {
          $message = '<div class="alert alert-danger text-center" id="message">Veillez donner le numéro parcelle </div>';
        }

        $id_applicant = $this->createApplicant(
          $fullname,
          $username,
          $email,
          $password,
          $mobile,
          (int) $registeras,
          $country_code,
          (int) $province_id,
          (int) $commune_id,
          $date_naissance,
          $father_fullname,
          $mother_fullname,
          $lieu_delivrance,
          $date_delivrance,
          $num_parcelle,
          $superficie,
          (int) $usage_id,
          $prix,
          $nif,
          (int) $zone_id_naissance,
          (int) $colline_id_naissance,
          $sexe,
          $boite_postale,
          $avenue,
          $profile_image_path,
          $signature_image,
          $cni_image,
          (int) $colline_id,
          $DOC_TOKEN,
          $ALF_TOKEN,
          $DOC_REF_TOKEN,
          $ALF_REF_TOKEN,
          $cni
        );

        $this->updateDataInfoApplicantAttribution($numeroParcelle, $id_applicant->data->id);
      } elseif ($isDocBox_Alfr == 2) {
        #Archivage avec Alfresco
        if ($numeroParcelle) {
          $getParcelleByNum = $this->parcelle($numeroParcelle);
          if ($getParcelleByNum->success) {
            $description = "D" . $idDemande;
            $infoDossier = $this->get_data_of_folder($getParcelleByNum->data->ALF_TOKEN);

            $parts = explode('/',  $infoDossier->item->location->path);
            $valueNature = $parts[2];
            // Verifier SI c'est dossier D
            if ($valueNature == 'D') {

              $data = array(
                'name'        => $description,
                'title'       => "Folder belong to " . $fullname,
                'description' => $description
              );

              $createSubFolder = $this->create_folder_alfresco($this->login_alfresco(), $data, $getParcelleByNum->data->ALF_TOKEN);

              if ($createSubFolder) {
                $subFoldTokenDestin = $createSubFolder->nodeRef;
                $subFoldTokenDestin = str_replace('workspace://SpacesStore/', '', $subFoldTokenDestin);

                $this->move_file_alfresco($this->login_alfresco(), $getParcelleByNum->data->ALF_REF_TOKEN, $subFoldTokenDestin);

                if (!empty($this->envoyer_ficher_alfresco($codeDemande))) {

                  $donnees_get = str_replace('@', '', $this->envoyer_ficher_alfresco($codeDemande));
                  $get_index_datas = explode('<>', $donnees_get);

                  for ($i = 0; $i < count($get_index_datas) - 1; $i++) {
                    $tab_doc_id = explode('#', $get_index_datas[$i]);
                    $tab_doc_id1 = explode('/', $tab_doc_id[0]);
                    $getnom_doc = $this->CI->Model->getOne('pms_documents', ['ID_DOCUMENT' => $tab_doc_id[1]]);
                    $desc_nom_doc = (!empty($getnom_doc['DESC_DOCUMENT'])) ? $getnom_doc['DESC_DOCUMENT'] : '';

                    $this->send_file_to_alfresco($tab_doc_id1[3], $tab_doc_id1[6], $tab_doc_id1[4], $tab_doc_id1[5], $subFoldTokenDestin, $desc_nom_doc);
                  }

                  $message = '<div class="alert alert-success text-center" id="message">Archivage effectué avec succès</div>';
                } else {
                  $message = `<div class="alert alert-danger text-center" id="message">LES FICHIERS SONT INEXISTANT, archivage échoué</div>`;
                }
              } else {
                $message = '<div class="alert alert-danger text-center" id="message">le dossier portant ce nom existe déjà</div>';
              }
            } else {

              $province = $this->recupererInfoProvince($getParcelleByNum->data->COLLINE_ID);
              $tokenD = $this->CI->Model->getRequeteOne('SELECT `id`,`dossier_processus_id`,`province_id`,`token_dossiers_processus_province` FROM `edrms_dossiers_processus_province` WHERE 1 and province_id=' . $province['PROVINCE_ID'] . ' AND dossier_processus_id=9');

              if ($tokenD) {
                // Déplacer le sous dossier(envoyé via api parcelle)
                $this->move_file_alfresco($this->login_alfresco(), $getParcelleByNum->data->ALF_REF_TOKEN, $tokenD['token_dossiers_processus_province']);

                $data = array('name' => $description, 'title' => "Folder belong to " . $fullname, 'description' => $description);

                $createSubFolder = $this->create_folder_alfresco($this->login_alfresco(), $data, $getParcelleByNum->data->ALF_TOKEN);

                if ($createSubFolder) {
                  $subFoldTokenCreated = $createSubFolder->nodeRef;
                  $subFoldTokenCreated = str_replace('workspace://SpacesStore/', '', $subFoldTokenCreated);

                  $data_docs = $this->envoyer_ficher_alfresco($codeDemande);

                  if (!empty($data_docs)) {
                    $donnees_get = str_replace('@', '', $data_docs);
                    $get_index_datas = explode('<>', $donnees_get);

                    for ($i = 0; $i < count($get_index_datas) - 1; $i++) {

                      $tab_doc_id = explode('#', $get_index_datas[$i]);
                      $tab_doc_id1 = explode('/', $tab_doc_id[0]);

                      $getnom_doc = $this->CI->Model->getOne('pms_documents', ['ID_DOCUMENT' => $tab_doc_id[1]]);
                      $desc_nom_doc = (!empty($getnom_doc['DESC_DOCUMENT'])) ? $getnom_doc['DESC_DOCUMENT'] : '';
                      $this->send_file_to_alfresco($tab_doc_id1[3], $tab_doc_id1[6], $tab_doc_id1[4], $tab_doc_id1[5], $subFoldTokenCreated, $desc_nom_doc);
                    }

                    $this->move_file_alfresco($this->login_alfresco(), $getParcelleByNum->data->ALF_REF_TOKEN, $subFoldTokenCreated);

                    $message = '<div class="alert alert-success text-center" id="message">Archivage effectué avec succès</div>';
                  } else {
                    $message = `<div class="alert alert-danger text-center" id="message">LES FICHIERS SONT INEXISTANT, archivage échoué</div>`;
                  }
                }
              } else {
                $message = '<div class="alert alert-danger text-center" id="message">Le dossier D pour cette province n\'existe pas</div>';
              }
            }
          } else {
            $message = '<div class="alert alert-danger text-center" id="message">Ce numéro de parcelle n\'existe pas</div>';
          }
        } else {
          $message = '<div class="alert alert-danger text-center" id="message">Veillez donner le numéro parcelle valide</div>';
        }

        $id_applicant = $this->createApplicant(
          $fullname,
          $username,
          $email,
          $password,
          $mobile,
          (int) $registeras,
          $country_code,
          (int) $province_id,
          (int) $commune_id,
          $date_naissance,
          $father_fullname,
          $mother_fullname,
          $lieu_delivrance,
          $date_delivrance,
          $num_parcelle,
          $superficie,
          (int) $usage_id,
          $prix,
          $nif,
          (int) $zone_id_naissance,
          (int) $colline_id_naissance,
          $sexe,
          $boite_postale,
          $avenue,
          $profile_image_path,
          $signature_image,
          $cni_image,
          (int) $colline_id,
          $DOC_TOKEN,
          $ALF_TOKEN,
          $DOC_REF_TOKEN,
          $ALF_REF_TOKEN,
          $cni
        );

        $this->updateDataInfoApplicantAttribution($numeroParcelle, $id_applicant->data->id);
      }
      return $message;
    }

    //modifier les infos de la parcelle dans actualisation selon le process 
    public function updateActualisationByProcess($idProcess, $idParcelle, $numeroParcelle, $superficie = null, $usage = null, $volume = null, $folio = null)
    {
      $message = '';
      if ($idProcess) {
        switch ($idProcess) {
          case 8:
            $url = "https://" . $this->base_url . "/api/v1/plots/" . $idParcelle;
            $datas = array(
              "NUMERO_PARCELLE" => $superficie,
              "_method" => "PUT",
            );
            $response =  $this->executeFormData($url, $datas, 'POST', $this->getToken());
            $message = 'augmentation superf';
            break;
          case 9:
            $url = "https://" . $this->base_url . "/api/v1/plots/" . $idParcelle;
            $datas = array(
              "NUMERO_PARCELLE" => $superficie,
              "_method" => "PUT",
            );
            $response =  $this->executeFormData($url, $datas, 'POST', $this->getToken());
            $message = 'suppression superf';
            break;
          case 7:
            $datas = array(
              "USAGE_ID" => $usage,
              "VOLUME" => $volume,
              "FOLIO" => $folio,
              "_method" => "PUT",
            );
            $url = "https://" . $this->base_url . "/api/v1/attributionUpdate/" . $numeroParcelle;
            $res =  $this->executeFormData($url, $datas, 'POST', $this->getToken());
            $message = 'changement d usage';
            break;
          case 5:
            $datas = array(
              "VOLUME" => $volume,
              "FOLIO" => $folio,
              "_method" => "PUT",
            );
            $url = "https://" . $this->base_url . "/api/v1/attributionUpdate/" . $numeroParcelle;
            $res =  $this->executeFormData($url, $datas, 'POST', $this->getToken());
            $message = 'incorporation de construction';
            break;
          case 11:
            $datas = array(
              "VOLUME" => $volume,
              "FOLIO" => $folio,
              "_method" => "PUT",
            );
            $url = "https://" . $this->base_url . "/api/v1/attributionUpdate/" . $numeroParcelle;
            $res =  $this->executeFormData($url, $datas, 'POST', $this->getToken());
            $message = 'changement du plan de la propriete';
            break;
          case 6:
            $datas = array(
              "VOLUME" => $volume,
              "FOLIO" => $folio,
              "_method" => "PUT",
            );
            $url = "https://" . $this->base_url . "/api/v1/attributionUpdate/" . $numeroParcelle;
            $res =  $this->executeFormData($url, $datas, 'POST', $this->getToken());
            $message = 'suppression de construction';

            break;
            // default:
            //  $conditionNextStep = " PROCESS_ID=" . $dataEtape[0]['PROCESS_ID'] . "  AND DELETED=0 AND ORDER_NO=" . (intval($dataEtape[0]['ORDER_NO']) + 1);
        }
      }
      return $message;
    }

    /**
     * APIS POUR ALFRESCO
     */

    private $ip_port_serveur = "192.168.0.25";
    private $ip_port_serveur_alfresco = "192.168.0.25:1620";



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
      return json_decode($output);
    }
    //Authentication API
    function login_alfresco()
    {

      $username = "admin";
      $password = "7uO_&PAZa-V89:^";
      $data = array(
        'username' => $username,
        'password' => $password
      );

      $url = "http://" . $this->ip_port_serveur_alfresco . "/alfresco/s/api/login";

      $reponse =  $this->execute_alfresco($url, json_encode($data));

      return $reponse->data->ticket;
    }

    //GET DATA FORM A FOLDER
    public function get_data_of_folder($folder_id)
    {
      $ticket = $this->login_alfresco();
      $url = "http://" . $this->ip_port_serveur_alfresco . "/alfresco/s/slingshot/doclib2/node/workspace/SpacesStore/" . $folder_id . "?alf_ticket=" . $ticket;
      // return $this->execute($ticket);
      return $this->execute_alfresco($url, '', 'GET');
    }

    //API CREATE FOLDER
    public function create_folder_alfresco($ticket, $data = array(), $storage)
    {
      $url = "http://" . $this->ip_port_serveur_alfresco . "/alfresco/s/api/node/folder/workspace/SpacesStore/" . $storage . "?alf_ticket=" . $ticket;
      $return = $this->execute_alfresco($url, json_encode($data));
      return $return;
    }

    //COLLER UN DOSSIER DANS UN AUTRE DOSSIER
    public function move_file_alfresco($ticket, $folder_original, $folder_destination)
    {
      $data = '
      {
        "nodeRefs": [   
          "workspace://SpacesStore/' . $folder_original . '",
        ]
      }';

      $url = "http://" . $this->ip_port_serveur_alfresco . "/alfresco/s/slingshot/doclib/action/move-to/node/workspace/SpacesStore/$folder_destination?alf_ticket=$ticket";

      $return = $this->execute_alfresco($url, $data);

      return $return;
    }

    // Copy to folder
    public function copy_folder_to_alfresco($folder_origine, $folder_destination)
    {
      $ticket = $this->login_alfresco();
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
    public function send_file_to_alfresco($nom_projet, $file_name, $sous_dossier, $token_repertoire, $description)
    {
      $ticket = $this->login_alfresco();
      $ticket_basic = base64_encode($ticket);
      $project_path = $_SERVER['DOCUMENT_ROOT']; // Get the base path of the project

      $uploads_path = $project_path . '/' . $nom_projet .  '/' . $sous_dossier . '/' . $file_name;

      $cmd = 'curl -X POST -F "filedata=@' . $uploads_path . '" -F "name=' . $description . '" -F "nodeType=cm:content" -F "cm:description=' . $description . '" -F "autoRename=true" -H "Authorization: Basic ' . $ticket_basic . '" http://' . $this->ip_port_serveur_alfresco . '/alfresco/api/-default-/public/alfresco/versions/1/nodes/' . $token_repertoire . '/children';

      $output = shell_exec($cmd);

      if ($output === null) {
        // Handle the error when the shell command fails
        // For example, you can log the error or display an error message
        $out1 = '<div class="alert alert-warning text-center" id="message">Une erreur est apparu lors de l\'ececution de la command shell.</div>';
      } else {
        $out = json_decode($output, true);

        if ($out === null) {
          // Handle the error when JSON decoding fails
          // For example, you can log the error or display an error message
          $out1 = '<div class="alert alert-warning text-center" id="message">Une erreur à surgit,problème de decodage du fichier json.</div>';
        } else {
          if (is_array($out) && array_key_exists('entry', $out)) {
            $out1 = $out['entry'];

            // Check if the 'id' key exists in $out1
            if (array_key_exists('id', $out1)) {
              return $out1['id'];
            } else {
              // Handle the case when 'id' key is not present in $out1
              // For example, you can log the error or display an error message
              $out1 = '<div class="alert alert-warning text-center" id="message">La clé id n\'existe pas dans le tableau json.</div>';
            }
          } else {
            // Handle the case when 'entry' key is not present in the decoded array
            // For example, you can log the error or display an error message
            $out1 = '<div class="alert alert-warning text-center" id="message">La clé entry n\'existe pas dans le tableau json.</div>';
          }
        }
      }
      return $out1;
    }

    //fonction pour recuperer les fichiers generer,scanner et facturation    
    public function envoyer_ficher_alfresco($code_demande)
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
    public function start_process_alfresco($all_token_file, $province_id)
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

        $return = $this->execute_alfresco($url, $data);
      }
      return $return;
    }

    //
    public function send_metedata_file_bordereau_alfresco($ticket, $token_file, $author, $numerobordereau, $objectfile, $datedemande, $muneroparcelle, $form_entry_id, $application_id, $title_file, $description_file)
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
      $return = $this->execute_alfresco($url, json_encode($data));
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

      $return = $this->execute_alfresco($url, json_encode($data));

      return  $return;
    }

    // Find info TOKEN ALFRESCO
    public function find_doc_token_alfresco($subFoldToken)
    {
      $url = "http://" . $this->ip_port_serveur_alfresco . "/alfresco/s/slingshot/doclib2/doclist/documents/node/workspace/SpacesStore/$subFoldToken?alf_ticket=" . $this->login_alfresco();
      return $this->execute_alfresco($url, '', 'GET');
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
      $return = $this->execute_alfresco($url, json_encode($data));
      return  $return;
    }

    /**
     * Cette fonction est chargée de créer des dossiers et de stocker des fichiers pour le morcellement en fonction de la demande de code
     * et du jeton fournis. Elle se connecte à une base de données, récupère des données, les traite, puis envoie les fichiers pour le stockage.
     * Elle renvoie un message indiquant le succès ou l'échec du processus d'archivage des fichiers pour le morcellement. <franssen@mediabox.bi>
     */
    public function save_create_folders_stockes_files_morcellement_alfresco($code_demande, $token)
    {
      $message = '';
      // Appelle une méthode pour se connecter à une base de données. 
      $this->login_alfresco();

      if (!empty($this->envoyer_ficher_alfresco($code_demande))) {
        $donnees_get = str_replace('@', '', $this->envoyer_ficher_alfresco($code_demande));
        $get_index_datas = explode('<>', $donnees_get);

        for ($i = 0; $i < count($get_index_datas) - 1; $i++) {
          $tab_doc_id = explode('#', $get_index_datas[$i]);
          $tab_doc_id1 = explode('/', $tab_doc_id[0]);

          $getnom_doc = $this->CI->Model->getOne('pms_documents', ['ID_DOCUMENT' => $tab_doc_id[1]]);
          $desc_nom_doc = (!empty($getnom_doc['DESC_DOCUMENT'])) ? $getnom_doc['DESC_DOCUMENT'] : '';

          // $file_name, $url_file, $token_repertoire, $description
          $message = $this->send_file_to_alfresco($tab_doc_id1[3], $tab_doc_id1[6], $tab_doc_id1[4], $tab_doc_id1[5], $token, $desc_nom_doc);
        }
        $message = '<div class="alert alert-success text-center" id="message">Archivage effectué avec succès</div>';
      } else {
        $message = `<div class="alert alert-danger text-center" id="message">L\'archivage échoué</div>`;
      }
      return $message;
    }

    /**
     * Elle gère la création de dossiers, le stockage de fichiers, l'interaction avec la plateforme Alfresco 
     * et la manipulation de données liées aux parcelles. Elle effectue des vérifications, des traitements et
     * des opérations en fonction des données fournies en entrée. Elle retourne également un message en
     * fonction du résultat de ces opérations. <franssen@mediabox.bi>
     */

    public function saveFoldersCreatedsFilesMorcellementDocBoxAlfresco(
      $code_demande,
      array $num_parcelle,
      $id_demande,
      $ancienNumParcelle,
      $res_docbox_alfresco = null,
      $numero_ordre_general,
      $numero_ordre_special
    ) {

      $message = '';
      // Appelle une 
      $this->connexion();
      // Appelle une méthode pour se connecter à une base de données pour le système alfresco. 
      $parcelle = $this->parcelle($ancienNumParcelle);
      // Verifier la localite parcelle (localite qui est la province)
      $province = $this->recupererInfoProvince($parcelle->data->COLLINE_ID);

      if ($parcelle) {
        // Verification du TOKEN $DOC_TOKEN && $DOC_REF_TOKEN || $ALF_TOKEN && $ALF_REF_TOKEN
        if (
          $parcelle->data->DOC_TOKEN != null && $parcelle->data->DOC_REF_TOKEN != null ||
          $parcelle->data->ALF_TOKEN != null && $parcelle->data->ALF_REF_TOKEN != null
        ) {

          if ($res_docbox_alfresco) {
            // Verfication de la logique de DOCBOX
            if ($res_docbox_alfresco == 1) {
              // La logique de DOCBOX
              $foldNameSubDoc = "D" . $id_demande;
              // Cibler le dossier D de la localite : son TOKEN (ID_NATURE, ID_PROVINCE, TOKEN)
              $tokenDocD = $this->CI->Model->getRequeteOne(
                'SELECT ID,ID_PROVINCE,ID_NATURE,TOKEN
              FROM edrms_docbox_province_nature 
              WHERE ID_NATURE=9 and
              ID_PROVINCE=' . $province['PROVINCE_ID']
              );

              $this->setParcelleAnnuler($parcelle->data->ID_PARCELLE);
              $this->setParcelleAttributionAnnuler($ancienNumParcelle);

              // $countSuccess = 0; // Initialisation du compteur de succès
              foreach ($num_parcelle as $num) {
                //Appeller DOC BOX pour la creation des sous-dossiers
                $resultToken = $this->creationSousDossier($tokenDocD['TOKEN'], $num['NUMERO_PARCELLE'], $foldNameSubDoc);
                $objetJson = json_decode($resultToken, true);
                if ($objetJson['status'] == 200) {
                  $foldTokenParcelle = $objetJson['fold_token'];
                  //  Creation du sous-repertoire:pms_api D (id_demande)
                  $resultDocRefToke = $this->creationSousDossier($foldTokenParcelle, $foldNameSubDoc, $foldNameSubDoc);
                  $objetJson        = json_decode($resultDocRefToke, true);
                  $allDocRefToken   = $objetJson['fold_token'];
                  // Appel de la demande
                  $this->save_create_folders_stockes_files_morcellement($code_demande, $allDocRefToken);
                  $this->deplacerDossier($parcelle->data->DOC_REF_TOKEN, $allDocRefToken);

                  // sauvegader les infos ID_REQUERANT, ID_PARCELLE Dans le sous-repertoire et leurToken
                  $id = $this->saveParcelle(
                    $num['NUMERO_PARCELLE'],
                    $num['superficie'],
                    $province['PROVINCE_ID'],
                    $province['COMMUNE_ID'],
                    $province['ZONE_ID'],
                    $province['COLLINE_ID'],
                    $province['PROVINCE_NAME'],
                    $province['COMMUNE_NAME'],
                    $province['ZONE_NAME'],
                    $province['COLLINE_NAME'],
                    2,
                    $foldTokenParcelle,
                    $allDocRefToken,
                    null,
                    null
                  );

                  $this->createdAttributionPlot(
                    (int) $id->{'data'}->{'ID_PARCELLE'},
                    (int) $parcelle->data->id,
                    (int) $num['ID_USAGER_PROPRIETE'],
                    (int) $num['STATUT_ID'],
                    (int) $province['PROVINCE_ID'],
                    (int) $province['COMMUNE_ID'],
                    (int) $province['ZONE_ID'],
                    (int) $province['COLLINE_ID'],
                    $num['NUMERO_PARCELLE'],
                    0,
                    (int) $num['superficie'],
                    $num['SUPERFICIE_HA'],
                    $num['SUPERFICIE_ARE'],
                    $num['SUPERFICIE_CA'],
                    $num['VOLUME'],
                    $num['FOLIO'],
                    (int) $numero_ordre_general,
                    (int) $numero_ordre_special
                  );
                } else {
                  $message = '<div class="alert alert-danger text-center" id="message">Le dossier portant ce nom existe deja !</div>';
                }
              }
            } elseif ($res_docbox_alfresco == 2) {
              // La logique de DOCBOX
              $foldNameSubDoc = "D" . $id_demande;

              // Verifier la localite parcelle (localite qui est la province)
              $tokenDocD = $this->CI->Model->getRequeteOne(
                'SELECT id,dossier_processus_id,province_id,token_dossiers_processus_province FROM
               edrms_dossiers_processus_province WHERE dossier_processus_id=9 and province_id=' . $province['PROVINCE_ID']
              );

              $this->setParcelleAnnuler($parcelle->data->ID_PARCELLE);
              $this->setParcelleAttributionAnnuler($ancienNumParcelle);

              $countplots = count($num_parcelle);
              $count = 0;

              foreach ($num_parcelle as $num) {
                $count = $count + 1;

                //Appeller DOC BOX pour la creation des sous-dossiers                
                $create_folder  = array(
                  "name"        => $num['NUMERO_PARCELLE'],
                  "title"       => $num['NUMERO_PARCELLE'],
                  "description" => $num['NUMERO_PARCELLE'],
                );

                $resultToke = $this->create_folder_alfresco(
                  $this->login_alfresco(),
                  $create_folder,
                  $tokenDocD['token_dossiers_processus_province']
                );

                if (property_exists($resultToke, 'nodeRef')) {
                  $explodeResponse      = explode('/', $resultToke->nodeRef);
                  $fold_alt_token_plots = $explodeResponse[3];

                  $create_folder_sub  = array(
                    "name"        => $foldNameSubDoc,
                    "title"       => $foldNameSubDoc,
                    "description" => $foldNameSubDoc,
                  );

                  //  Creation du sous-repertoire:pms_api D (id_demande)
                  $resultDocRefToke  = $this->create_folder_alfresco($this->login_alfresco(), $create_folder_sub, $fold_alt_token_plots);

                  if (property_exists($resultDocRefToke, 'nodeRef')) {
                    $explodeRes = explode('/', $resultDocRefToke->nodeRef);
                    $fold_alf_ref_token = $explodeRes[3];

                    $this->save_create_folders_stockes_files_morcellement_alfresco($code_demande, $fold_alf_ref_token);

                    if ($countplots == $count) {
                      $this->move_file_alfresco($this->login_alfresco(), $parcelle->data->ALF_REF_TOKEN, $fold_alf_ref_token);
                    } else {
                      $this->copy_folder_to_alfresco($parcelle->data->ALF_REF_TOKEN, $fold_alf_ref_token);
                    }

                    $id = $this->saveParcelle(
                      $num['NUMERO_PARCELLE'],
                      $num['superficie'],
                      $province['PROVINCE_ID'],
                      $province['COMMUNE_ID'],
                      $province['ZONE_ID'],
                      $province['COLLINE_ID'],
                      $province['PROVINCE_NAME'],
                      $province['COMMUNE_NAME'],
                      $province['ZONE_NAME'],
                      $province['COLLINE_NAME'],
                      2,
                      null,
                      null,
                      $fold_alt_token_plots,
                      $fold_alf_ref_token
                    );

                    $this->createdAttributionPlot(
                      (int) $id->{'data'}->{'ID_PARCELLE'},
                      (int) $parcelle->data->id,
                      (int) $num['ID_USAGER_PROPRIETE'],
                      (int) $num['STATUT_ID'],
                      (int) $province['PROVINCE_ID'],
                      (int) $province['COMMUNE_ID'],
                      (int) $province['ZONE_ID'],
                      (int) $province['COLLINE_ID'],
                      $num['NUMERO_PARCELLE'],
                      0,
                      (int) $num['superficie'],
                      $num['SUPERFICIE_HA'],
                      $num['SUPERFICIE_ARE'],
                      $num['SUPERFICIE_CA'],
                      $num['VOLUME'],
                      $num['FOLIO'],
                      (int) $numero_ordre_general,
                      (int) $numero_ordre_special
                    );
                  } else {
                    $message = '<div class="alert alert-danger text-center" id="message">le sous dossier parcelle portant ce nom existe deja</div>';
                  }
                } else {
                  $message = '<div class="alert alert-danger text-center" id="message">le sous dossier parcelle portant ce nom existe deja</div>';
                }
              }
            }
          } else {
            $message = '<div class="alert alert-danger text-center" id="message">L\'archivage échoué</div>';
          }
        } else {
          $message = '<div class="alert alert-danger text-center" id="message">L\'archivage échoué</div>';
        }
      } else {
        $message = '<div class="alert alert-danger text-center" id="message">La parcelle n\'existe pas !</div>';
      }
      return $message;
    }

    //<franssen@mediabox.bi> 
    public function send_category_demande_info_alfresco($code_demande, $token)
    {
      // Appelle une méthode pour se connecter à une base de données. 
      $this->login_alfresco();
      $data = $this->envoyer_ficher_alfresco($code_demande);
      $message = '';
      // Vérifie si la variable  $data  n'est pas vide
      if (!empty($data)) {
        //Remplace les caracteres '@' dans le $data par une chaine vide  et stocke le resultat dans $donnees_get
        $donnees_get = str_replace('@', '', $data);
        $get_index_datas = explode('<>', $donnees_get);
        // Boucle à travers les éléments du tableau  $get_index_datas
        for ($i = 0; $i < count($get_index_datas) - 1; $i++) {
          $tab_doc_id = explode('#', $get_index_datas[$i]);
          $tab_doc_id1 = explode('/', $tab_doc_id[0]);

          $getnom_doc = $this->CI->Model->getOne('pms_documents', ['ID_DOCUMENT' => $tab_doc_id[1]]);
          $desc_nom_doc = (!empty($getnom_doc['DESC_DOCUMENT'])) ? $getnom_doc['DESC_DOCUMENT'] : '';
          $data = $this->send_file_to_alfresco($tab_doc_id1[3], $tab_doc_id1[5], $tab_doc_id1[4], $token, $desc_nom_doc);
        }
        $message = '<div class="alert alert-success text-center" id="message">Archivage effectué avec succès</div>';
      } else {
        $message = '<div class="alert alert-danger text-center" id="message">LES FICHIERS SONT INEXISTANT, archivage échoué</div>';
      }
      return $message;
    }

    ///function qui est appelé dans pms pour archivage selon le système sélectionné <franssen@mediabox.bi>
    function archivage_demande_info($code_demande, $num_parcelle, $statut_parcelle = null, $system_archiv, $process)
    {
      $message = '';
      $archiv = 0;
      // Appelle une méthode pour récupérer des informations sur une parcelle en fonction du numéro de parcelle.
      $parcelle    = $this->parcelle($num_parcelle);

      // Vérifie si des informations sur la parcelle ont été récupérées avec succès
      if ($parcelle) {
        if ($parcelle->data->DOC_TOKEN != null && $parcelle->data->DOC_REF_TOKEN != null || $parcelle->data->ALF_TOKEN != null && $parcelle->data->ALF_REF_TOKEN != null) {

          if ($system_archiv == 1) {
            if ($parcelle->data->DOC_TOKEN != null && $parcelle->data->DOC_REF_TOKEN != null) {
              $this->send_category_demande_info_doc_box($code_demande, $parcelle->data->DOC_REF_TOKEN);
              $archiv = 1;
            } else {
              $message = `<div class="alert alert-danger text-center" id="message">LE TOKEN EST INEXISTANT COTE BPS, archivage échoué</div>`;
              $archiv = 0;
            }
          } else {
            if ($parcelle->data->ALF_TOKEN != null && $parcelle->data->ALF_REF_TOKEN != null) {
              $this->send_category_demande_info_alfresco($code_demande, $parcelle->data->ALF_REF_TOKEN);
              $archiv = 1;
            } else {
              $message = '<div class="alert alert-danger text-center" id="message">LE TOKEN EST INEXISTANT COTE BPS, archivage échoué</div>';
              $archiv = 0;
            }
          }
        } else {
          $message = '<div class="alert alert-danger text-center" id="message">Archivage est impossible</div>';
        }
      }
      if ($archiv == 1) {
        $this->modifierInfoParcelleBPS($parcelle->data->ID_PARCELLE, $statut_parcelle, $process);
        $this->setStatutParcelleAttribution($parcelle->data->NUMERO_PARCELLE, $statut_parcelle, $process);
        $message = '<div class="alert alert-success text-center" id="message">ARCHIVAGE EFFECTUE AVEC SUCCES</div>';
      }
      return $message;
    }

    public function send_file_reunification($statut, $numero, $superficie, $idRequerant, $idDemande, $codeDemande, array $numeroParcelle, $foldParcelle_name, $usage_id, $statut_id, $superficie_ha, $superficie_are, $superficie_ca, $volume, $folio, $numero_ordre_general, $numero_ordre_special)
    {
      $message = '';
      $fold_name = "D" . $idDemande;
      $description = "D" . $idDemande;
      if ($statut) {
        if (count($numeroParcelle) != 0) {
          $tokenReunif = $this->parcelle($numeroParcelle[0]);
          $province = $this->recupererInfoProvince($tokenReunif->data->COLLINE_ID);
          if ($statut == 1) {
            $tokenD = $this->CI->Model->getRequeteOne('SELECT ID,ID_PROVINCE,ID_NATURE,TOKEN FROM edrms_docbox_province_nature WHERE ID_NATURE=9 and ID_PROVINCE=' . $province['PROVINCE_ID']);
            if ($tokenD) {
              $createFolder = $this->creationSousDossier($tokenD['TOKEN'], $foldParcelle_name, $foldParcelle_name);
              $objetJson = json_decode($createFolder, true);
              if ($objetJson['status'] == 200) {
                $foldTokenParcelle = $objetJson['fold_token'];
                $createSubFolder = $this->creationSousDossier($foldTokenParcelle, $fold_name, $description);
                $objetJson2 = json_decode($createSubFolder, true);
                if ($objetJson2['status'] == 200) {
                  $foldTokenSubFolder = $objetJson2['fold_token'];
                  $table = 'edrms_repertoire_processus_sous_repertoire_new';

                  for ($i = 0; $i < count($numeroParcelle); $i++) {
                    $tokenReunif = $this->parcelle($numeroParcelle[$i]);

                    $createSubFolder = '';
                    $objetJson = '';
                    $subFoldToken = '';
                    $idParcelle = '';
                    if ($tokenReunif->data->DOC_REF_TOKEN != null) {

                      $tokenReunif->data->COLLINE_ID;
                      $tokenReunif->data->DOC_TOKEN;
                      $subFoldToken = $tokenReunif->data->DOC_REF_TOKEN;
                      $idParcelle = $tokenReunif->data->ID_PARCELLE;

                      $this->deplacerDossier($subFoldToken, $foldTokenSubFolder);
                      $dataUpdate = array(
                        'statut_actualisation' => 0
                      );
                      $this->CI->Model->update($table, array('token_sous_repertoire' => $subFoldToken), $dataUpdate);

                      $this->setParcelleAnnuler($idParcelle);
                      $this->setParcelleAttributionAnnuler($numeroParcelle[$i]);
                      //}
                    }
                  }
                  $sendFile = $this->sendFileByDemand($codeDemande, $foldTokenSubFolder);
                  $addParcelleAttribuer = $this->saveParcelle($numero, $superficie, $province['PROVINCE_ID'], $province['COMMUNE_ID'], $province['ZONE_ID'], $province['COLLINE_ID'], $province['PROVINCE_NAME'], $province['COMMUNE_NAME'], $province['ZONE_NAME'], $province['COLLINE_NAME'], 2, $foldTokenParcelle, $foldTokenSubFolder, null, null);
                  $this->createdAttributionPlot(
                    $addParcelleAttribuer->data->ID_PARCELLE,
                    $idRequerant,
                    $usage_id,
                    $statut_id,
                    $province['PROVINCE_ID'],
                    $province['COMMUNE_ID'],
                    $province['ZONE_ID'],
                    $province['COLLINE_ID'],
                    $numero,
                    0,
                    $superficie,
                    $superficie_ha,
                    $superficie_are,
                    $superficie_ca,
                    $volume,
                    $folio,
                    $numero_ordre_general,
                    $numero_ordre_special
                  );
                  $dataCreate = array(
                    'nom_sous_repertoire' => $fold_name,
                    'token_sous_repertoire' => $foldTokenSubFolder,
                    'statut_actualisation' => 1
                  );
                  $this->CI->Model->create($table, $dataCreate);
                  if ($sendFile) {
                    //update parcelle statut
                    $message = '<div class="alert alert-success text-center" id="message">Archivage effectué avec succès</div>';
                  } else {
                    $message = '<div class="alert alert-danger text-center" id="message">Le dossier D pour cette province n\'existe pas</div>';
                  }
                } else {
                  $message = '<div class="alert alert-danger text-center" id="message">le sous dossier parcelle portant ce nom existe deja</div>';
                }
              } else {
                $message = '<div class="alert alert-danger text-center" id="message">le dossier parcelle portant ce nom existe deja</div>';
              }
            } else {
              $message = '<div class="alert alert-danger text-center" id="message">Le dossier D pour cette province n\'existe pas</div>';
            }
          }

          if ($statut == 2) {
            $tokenD = $this->CI->Model->getRequeteOne('SELECT id,dossier_processus_id,province_id,token_dossiers_processus_province FROM edrms_dossiers_processus_province WHERE dossier_processus_id=9 and province_id=' . $province['PROVINCE_ID']);
            if ($tokenD) {
              $ticket = $this->login_alfresco();
              $dataCreateFolder = array(
                "name" => $foldParcelle_name,
                "title" => $foldParcelle_name,
                "description" => $foldParcelle_name,
              );
              $createFolder = $this->create_folder_alfresco($ticket, $dataCreateFolder, $tokenD['token_dossiers_processus_province']);
              if (property_exists($createFolder, 'nodeRef')) {
                $explodeRes = explode('/', $createFolder->nodeRef);
                $foldTokenParcelle = $explodeRes[3];
                $dataCreateSubFolder = array(
                  "name" => $fold_name,
                  "title" => $fold_name,
                  "description" => $fold_name,
                );
                $createSubFolder = $this->create_folder_alfresco($ticket, $dataCreateSubFolder, $foldTokenParcelle);
                if (property_exists($createSubFolder, 'nodeRef')) {
                  $explodeRes2 = explode('/', $createSubFolder->nodeRef);
                  $foldTokenSubFolder = $explodeRes2[3];
                  $table = 'edrms_repertoire_processus_sous_repertoire_new';

                  for ($i = 0; $i < count($numeroParcelle); $i++) {
                    $tokenReunif = $this->parcelle($numeroParcelle[$i]);

                    $createSubFolder = '';
                    $objetJson = '';
                    $subFoldToken = '';
                    $idParcelle = '';
                    if ($tokenReunif->data->ALF_REF_TOKEN != null) {

                      $tokenReunif->data->COLLINE_ID;
                      $tokenReunif->data->ALF_TOKEN;
                      $subFoldToken = $tokenReunif->data->ALF_REF_TOKEN;
                      $idParcelle = $tokenReunif->data->ID_PARCELLE;

                      $this->move_file_alfresco($ticket, $subFoldToken, $foldTokenSubFolder);
                      $dataUpdate = array(
                        'statut_actualisation' => 0
                      );
                      $this->CI->Model->update($table, array('token_sous_repertoire' => $subFoldToken), $dataUpdate);

                      $this->setParcelleAnnuler($idParcelle);
                      $this->setParcelleAttributionAnnuler($numeroParcelle[$i]);
                      //}
                    }
                  }
                  $sendFile = $this->sendFileByDemandAlfresco($codeDemande, $foldTokenSubFolder);
                  $addParcelleAttribuer = $this->saveParcelle($numero, $superficie, $province['PROVINCE_ID'], $province['COMMUNE_ID'], $province['ZONE_ID'], $province['COLLINE_ID'], $province['PROVINCE_NAME'], $province['COMMUNE_NAME'], $province['ZONE_NAME'], $province['COLLINE_NAME'], 2, null, null, $foldTokenParcelle, $foldTokenSubFolder);
                  $this->createdAttributionPlot(
                    $addParcelleAttribuer->data->ID_PARCELLE,
                    $idRequerant,
                    $usage_id,
                    $statut_id,
                    $province['PROVINCE_ID'],
                    $province['COMMUNE_ID'],
                    $province['ZONE_ID'],
                    $province['COLLINE_ID'],
                    $numero,
                    0,
                    $superficie,
                    $superficie_ha,
                    $superficie_are,
                    $superficie_ca,
                    $volume,
                    $folio,
                    $numero_ordre_general,
                    $numero_ordre_special
                  );
                  $dataCreate = array(
                    'nom_sous_repertoire' => $fold_name,
                    'token_sous_repertoire' => $foldTokenSubFolder,
                    'statut_actualisation' => 1
                  );
                  $this->CI->Model->create($table, $dataCreate);
                  if ($sendFile) {
                    //update parcelle statut
                    $message = '<div class="alert alert-success text-center" id="message">Archivage effectué avec succès</div>';
                  } else {
                    $message = '<div class="alert alert-danger text-center" id="message">archivage echoué</div>';
                  }
                } else {
                  $message = '<div class="alert alert-danger text-center" id="message">le sous dossier parcelle portant ce nom existe deja</div>';
                }
              } else {
                $message = '<div class="alert alert-danger text-center" id="message">le dossier parcelle portant ce nom existe deja</div>';
              }
            } else {
              $message = '<div class="alert alert-danger text-center" id="message">Le dossier D pour cette province n\'existe pas</div>';
            }
          }
        } else {
          $message = '<div class="alert alert-danger text-center" id="message">Le requerant n\'a pas de parcelle</div>';
        }
      } else {
        $message = '<div class="alert alert-danger text-center" id="message">veuillez choisir un systeme d\'archivage</div>';
      }
      return $message;
    }

    //function pour envoyer les fichiers actualisation dans alfresco
    public function save_create_folders_stockes_files_actualisation_alfresco($code_demande, $token)
    {
      // Appelle une méthode pour se connecter à une base de données. 
      $this->login_alfresco();
      $data = $this->envoyer_ficher_alfresco($code_demande);
      $message = '';
      $tab_doc_id = '';
      $tab_doc_id1 = '';

      if (!empty($data)) {
        $donnees_get = str_replace('@', '', $data);
        $get_index_datas = explode('<>', $donnees_get);

        for ($i = 0; $i < count($get_index_datas) - 1; $i++) {
          $tab_doc_id = explode('#', $get_index_datas[$i]);
          $tab_doc_id1 = explode('/', $tab_doc_id[0]);

          $getnom_doc = $this->CI->Model->getOne('pms_documents', ['ID_DOCUMENT' => $tab_doc_id[1]]);
          $desc_nom_doc = (!empty($getnom_doc['DESC_DOCUMENT'])) ? $getnom_doc['DESC_DOCUMENT'] : '';
          // print_r($tab_doc_id1);die();
          // $file_name, $url_file, $token_repertoire, $description
          $data = $this->send_file_to_alfresco($tab_doc_id1[3], $tab_doc_id1[6], $tab_doc_id1[4], $tab_doc_id1[5], $token, $desc_nom_doc);
        }
        // return $tab_doc_id;
        $message = '<div class="alert alert-success text-center" id="message">Archivage effectué avec succès</div>';
      } else {
        $message = '<div class="alert alert-danger text-center" id="message">LES FICHIERS SONT INEXISTANT, archivage échoué</div>';
      }
      return $message;
    }

    //function pour archiver avec alfresco ou docbox dans les processus actualisation 
    public function send_file_actualisation_docbox_alfresco($idDemande, $codeDemande, $idProcess, $idRequerant, $numeroParcelle, $idParcelle, $statut)
    {
      $getTraitement = $this->CI->Model->getRequeteOne("SELECT VOLUME,FOLIO FROM pms_farde WHERE ID_TRAITEMENT_DEMANDE=" . $idDemande);
      $parcel = $this->parcelle($numeroParcelle);
      $superficie = $parcel->data->SUPERFICIE;
      $usage = $parcel->data->DESCRIPTION_USAGER_PROPRIETE;
      $volume = $getTraitement['VOLUME'];
      $folio = $getTraitement['FOLIO'];
      $message = '';
      //si l'utilisateur choisi docbox
      if ($statut == 1) {
        $requerant = $this->info_requerant($idRequerant);
        if ($requerant->data) {
          $getRequerant = $this->login($requerant->data[0]->email);

          if ($getRequerant) {
            $parcelle = $getRequerant->data->NUMERO_PARCELLE;

            //$var=$this->pms_api->info_requerant($t);

            if ($parcelle) {
              //if (in_array($numeroParcelle, array_column($parcelle, 'NUMERO_PARCELLE'))) {

              for ($i = 0; $i < count($parcelle); $i++) {
                if ($parcelle[$i]->NUMERO_PARCELLE == $numeroParcelle) {
                  // print("index ".$i);

                  //  exit();
                  $createSubFolder = '';
                  $objetJson = '';
                  $foldToken = '';
                  $subFoldToken = '';
                  $idParcelle = '';
                  if ($parcelle[$i]->DOC_TOKEN != null) {

                    $colline = $parcelle[$i]->COLLINE_ID;
                    $fold_token = $parcelle[$i]->DOC_TOKEN;
                    $subFoldToken = $parcelle[$i]->DOC_REF_TOKEN;
                    $idParcelle = $parcelle[$i]->ID_PARCELLE;
                    $fold_name = "D" . $idDemande;
                    $description = "D" . $idDemande;

                    $infoDossier = $this->recupererInfoDossier($fold_token);
                    $convertJson = json_decode($infoDossier, true);
                    $urlFolder = $convertJson['detail_fold']['url_folder'];
                    $parts = explode('/', $urlFolder);
                    $valueNature = $parts[3];
                    if ($valueNature == "D") {
                      //print("oui oui c D");

                      $createSubFolder = $this->creationSousDossier($fold_token, $fold_name, $description);
                      $objetJson = json_decode($createSubFolder, true);
                      if ($objetJson['status'] == 200) {
                        $foldToken = $objetJson['fold_token'];
                        // print($foldToken);
                        $table = 'edrms_repertoire_processus_sous_repertoire_new';
                        $dataUpdate = array(
                          'statut_actualisation' => 0
                        );
                        $UpdateOldFold = $this->Model->update($table, array('token_sous_repertoire' => $subFoldToken), $dataUpdate);
                        $dataCreate = array(
                          'nom_sous_repertoire' => $fold_name,
                          'token_sous_repertoire' => $foldToken,
                          'statut_actualisation' => 1
                        );
                        $creationNewFold = $this->CI->Model->create($table, $dataCreate);
                        $moveFolder = $this->deplacerDossier($subFoldToken, $foldToken);
                        $updateTokenSubFoldParcelle = $this->modifierParcelle($idParcelle, $foldToken);

                        $sendFile = $this->sendFileByDemand($codeDemande, $foldToken);
                        if ($sendFile) {
                          $this->updateActualisationByProcess($idProcess, $idParcelle, $numeroParcelle, $superficie, $usage, $volume, $folio);
                          $message = '<div class="alert alert-success text-center" id="message">Archivage effectué avec succès</div>';
                        } else {
                          $message = '<div class="alert alert-danger text-center" id="message">archivage echoué</div>';
                        }
                      } else {
                        $message = '<div class="alert alert-danger text-center" id="message">le dossier portant ce nom existe deja</div>';
                      }
                    } else {
                      $province = $this->recupererInfoProvince($colline);
                      $tokenD = $this->CI->Model->getRequeteOne('SELECT ID,ID_PROVINCE,ID_NATURE,TOKEN FROM edrms_docbox_province_nature WHERE ID_NATURE=9 and ID_PROVINCE=' . $province['PROVINCE_ID']);
                      if ($tokenD) {
                        $moveFolder = $this->deplacerDossier($fold_token, $tokenD['TOKEN']);
                        $createSubFolder = $this->creationSousDossier($fold_token, $fold_name, $description);

                        $objetJson = json_decode($createSubFolder, true);
                        if ($objetJson['status'] == 200) {
                          $foldToken = $objetJson['fold_token'];
                          // print($foldToken);
                          $table = 'edrms_repertoire_processus_sous_repertoire_new';
                          $dataUpdate = array(
                            'statut_actualisation' => 0
                          );
                          $UpdateOldFold = $this->Model->CI->update($table, array('token_sous_repertoire' => $subFoldToken), $dataUpdate);
                          $dataCreate = array(
                            'nom_sous_repertoire' => $fold_name,
                            'token_sous_repertoire' => $foldToken,
                            'statut_actualisation' => 1
                          );
                          $creationNewFold = $this->CI->Model->create($table, $dataCreate);

                          $moveFolder = $this->deplacerDossier($subFoldToken, $foldToken);
                          $updateTokenSubFoldParcelle = $this->modifierParcelle($idParcelle, $foldToken);

                          $sendFile = $this->sendFileByDemand($codeDemande, $foldToken);
                          if ($sendFile) {
                            $this->updateActualisationByProcess($idProcess, $idParcelle, $numeroParcelle, $superficie, $usage, $volume, $folio);
                            $message = '<div class="alert alert-success text-center" id="message">Archivage effectué avec succès</div>';
                          } else {
                            $message = '<div class="alert alert-danger text-center" id="message">archivage echoué</div>';
                          }
                        } else {
                          $message = '<div class="alert alert-danger text-center" id="message">le dossier portant ce nom existe deja</div>';
                        }
                      } else {
                        $message = '<div class="alert alert-danger text-center" id="message">le dossier D pour cette province n\'existe pas</div>';
                      }
                    }
                  } else {
                    $message = '<div class="alert alert-danger text-center" id="message">la parcelle n\'a pas de dossier</div>';
                  }
                }
              }
            } else {
              $message = '<div class="alert alert-danger text-center" id="message">Le requerant n\'a pas de parcelle</div>';
            }
          } else {
            $message = '<div class="alert alert-danger text-center" id="message">Le requerant n\'existe pas</div>';
          }
        } else {
          $message = '<div class="alert alert-danger text-center" id="message">Le requerant n\'existe pas</div>';
        }
      } else {
        $requerant = $this->info_requerant($idRequerant);
        if ($requerant->data) {
          $getTicket = $this->login_alfresco();
          if ($getTicket) {
            $getParcelleByNum = $this->parcelle($numeroParcelle);


            // print_r($getParcelleByNum);die();
            if ($getParcelleByNum->success) {
              $colline = $getParcelleByNum->data->COLLINE_ID;
              $fold_token = $getParcelleByNum->data->ALF_TOKEN;
              $subFoldToken = $getParcelleByNum->data->ALF_REF_TOKEN;
              $idParcelle = $getParcelleByNum->data->ID_PARCELLE;
              $fold_name = "D" . $idDemande;
              $description = "D" . $idDemande;
              if ($fold_token != null) {
                // $infoDossier = $this->recupererInfoDossier($fold_token);
                $infoDossier = $this->get_data_of_folder($fold_token);
                // print_r($infoDossier);die();
                $path = $infoDossier->item->location->path;
                $parts = explode('/', $path);
                $valueNature = $parts[2];
                if ($valueNature == "D") {
                  //print("oui oui c D");

                  // $createSubFolder = $this->creationSousDossier($fold_token, $fold_name, $description);
                  $donnees = array('name' => $fold_name, 'title' => $fold_name, 'description' => $description);
                  // print_r($donnees);die();
                  $createSubFolder = $this->create_folder_alfresco($getTicket, $donnees, $fold_token);
                  // print_r($createSubFolder);die();

                  $createSubFolder = $createSubFolder->nodeRef;

                  $createSubFolder = str_replace('workspace://SpacesStore/', '', $createSubFolder);


                  if (!empty($createSubFolder)) {
                    $foldToken = $createSubFolder;
                    // print($foldToken);
                    $table = 'edrms_repertoire_processus_sous_repertoire_new';
                    $dataUpdate = array(
                      'statut_actualisation' => 0
                    );
                    $UpdateOldFold = $this->CI->Model->update($table, array('token_sous_repertoire' => $subFoldToken), $dataUpdate);
                    $dataCreate = array(
                      'nom_sous_repertoire' => $fold_name,
                      'token_sous_repertoire' => $foldToken,
                      'statut_actualisation' => 1
                    );
                    $creationNewFold = $this->CI->Model->create($table, $dataCreate);
                    $moveFolder = $this->move_file_alfresco($getTicket, $subFoldToken, $foldToken);
                    $updateTokenSubFoldParcelle = $this->modifierParcelle($idParcelle, $foldToken);
                    $sendFile = $this->save_create_folders_stockes_files_actualisation_alfresco($codeDemande, $foldToken);
                    if ($sendFile) {
                      $this->updateActualisationByProcess($idProcess, $idParcelle, $numeroParcelle, $superficie, $usage, $volume, $folio);
                      $message = '<div class="alert alert-success text-center" id="message">Archivage effectué avec succès</div>';
                    } else {
                      $message = '<div class="alert alert-danger text-center" id="message">Archivage echoué</div>';
                    }
                  } else {
                    $message = '<div class="alert alert-danger text-center" id="message">le dossier portant ce nom existe deja</div>';
                  }
                } else {
                  $province = $this->recupererInfoProvince($colline);
                  $tokenD = $this->CI->Model->getRequeteOne('SELECT dossier_processus_id,province_id,token_dossiers_processus_province FROM edrms_dossiers_processus_province WHERE dossier_processus_id=9 and province_id=' . $province['PROVINCE_ID']);
                  if ($tokenD) {
                    //$moveFolder = $this->deplacerDossier($fold_token, $tokenD['TOKEN']);
                    //$createSubFolder = $this->creationSousDossier($fold_token, $fold_name, $description);
                    $moveFolder = $this->move_file_alfresco($getTicket, $fold_Token, $tokenD['token_dossiers_processus_province']);
                    $donnees = array('name' => $fold_name, 'title' => $fold_name, 'description' => $description);
                    $createSubFolder = $this->create_folder_alfresco($getTicket, $donnees, $fold_token);
                    $createSubFolder = $createSubFolder->nodeRef;
                    $createSubFolder = str_replace('workspace://SpacesStore/', '', $createSubFolder);

                    if (!empty($createSubFolder)) {
                      $foldToken = $createSubFolder;
                      $table = 'edrms_repertoire_processus_sous_repertoire_new';
                      $dataUpdate = array(
                        'statut_actualisation' => 0
                      );
                      $UpdateOldFold = $this->CI->Model->update($table, array('token_sous_repertoire' => $subFoldToken), $dataUpdate);
                      $dataCreate = array(
                        'nom_sous_repertoire' => $fold_name,
                        'token_sous_repertoire' => $foldToken,
                        'statut_actualisation' => 1
                      );
                      $creationNewFold = $this->CI->Model->create($table, $dataCreate);

                      $moveFolder = $this->move_file_alfresco($getTicket, $subFoldToken, $foldToken);
                      // $updateTokenSubFoldParcelle = $this->modifierParcelle($idParcelle, $foldToken);

                      $sendFile = $this->sendFileByDemand($codeDemande, $foldToken);
                      if ($sendFile) {
                        $this->updateActualisationByProcess($idProcess, $idParcelle, $numeroParcelle, $superficie, $usage, $volume, $folio);
                        $message = '<div class="alert alert-success text-center" id="message">Archivage effectué avec succès</div>';
                      } else {
                        $message = '<div class="alert alert-danger text-center" id="message">archivage echoué</div>';
                      }
                    } else {
                      $message = '<div class="alert alert-danger text-center" id="message">le dossier portant ce nom existe deja</div>';
                    }
                  } else {
                    $message = '<div class="alert alert-danger text-center" id="message">le dossier D pour cette province n\'existe pas</div>';
                  }
                }
              } else {
                $message = '<div class="alert alert-danger text-center" id="message">la parcelle n\'a pas de dossier</div>';
              }
            } else {
              $message = '<div class="alert alert-danger text-center" id="message">La parcelle n\'existe pas</div>';
            } //print(json_encode(['message' => 'Le requerant n\'existe pas ']));
          }
        } else {
          $message = '<div class="alert alert-danger text-center" id="message">Le requerant n\'existe pas</div>';
        }
        return $message;
      }
    }

    /**
     * cette fonction qui gère la création de sous-dossiers, la mise à jour de dossiers existants et l'archivage de fichiers pour des demandes spécifiques liées à des parcelles. Voici un résumé de ce qu'elle fait : 
     * Elle récupère des informations sur une parcelle spécifique. Elle vérifie la disponibilité de jetons (tokens) nécessaires pour l'archivage. 
     * Elle crée des sous-dossiers en fonction des informations de la parcelle. Elle met à jour des données dans la base de données. 
     * Elle déplace des dossiers d'un emplacement à un autre.  Elle appelle la première fonction pour effectuer l'archivage des fichiers. 
     * Elle génère des messages de succès ou d'échec en fonction des étapes de traitement. <franssen@mediabox.bi>
     */
    public function sendPerteDocBoxAlfresco($idRequerant, $idDemande, $codeDemande, $numeroParcelle, $res_docbox_alfresco = null)
    {
      $message = '';
      $requerant = $this->info_requerant($idRequerant);
      $parcelle  = $this->parcelle($numeroParcelle);

      if ($res_docbox_alfresco) {
        if ($res_docbox_alfresco == 1) {
          if ($parcelle) {
            for ($i = 0; $i < count($parcelle); $i++) {
              if ($parcelle[$i]->NUMERO_PARCELLE == $numeroParcelle) {
                $createSubFolder = '';
                $objetJson   = '';
                $docToken    = '';
                $docRefToken = '';
                $idParcelle  = '';

                if (!empty($parcelle[$i]->DOC_TOKEN != null && $parcelle[$i]->DOC_REF_TOKEN)) {
                  $docoken     = $parcelle[$i]->DOC_TOKEN;
                  $docRefToken = $parcelle[$i]->DOC_REF_TOKEN;
                  $idParcelle  = $parcelle[$i]->ID_PARCELLE;

                  // $nameSubToken = $this->find_doc_token_alfresco($docRefToken);
                  $fold_name_and_description = "D" . 'DP' . $idDemande . '/' . date('Y');

                  $infoDossier = $this->recupererInfoDossier($docoken);
                  $convertJson = json_decode($infoDossier, true);
                  $urlFolder   = $convertJson['detail_fold']['url_folder'];
                  $parts       = explode('/', $urlFolder);
                  $valueNature = $parts[3];

                  if ($valueNature == "D") {
                    //Creation du sous-repertoire
                    $createSubFolder = $this->creationSousDossier(
                      $docoken,
                      $fold_name_and_description,
                      $fold_name_and_description
                    );

                    $objetJson = json_decode($createSubFolder, true);

                    if ($objetJson['status'] == 200) {

                      $docToken  = $objetJson['fold_token'];

                      $this->deplacerDossier($docRefToken, $docToken);
                      $this->modifierParcelle($idParcelle, $docToken);
                      $this->createMiseAjourPerte($codeDemande, $docToken);
                    }
                  } else {

                    $province  = $this->recupererInfoProvince($parcelle[$i]->COLLINE_ID);

                    $docDToken = $this->CI->Model->getRequeteOne(
                      'SELECT ID,ID_PROVINCE,ID_NATURE,TOKEN FROM edrms_docbox_province_nature
                    WHERE ID_NATURE=9 and ID_PROVINCE=' . $province['PROVINCE_ID']
                    );

                    $this->deplacerDossier($docToken, $docDToken['TOKEN']);

                    $createSubFolder = $this->creationSousDossier(
                      $docToken,
                      $fold_name_and_description,
                      $fold_name_and_description
                    );

                    $objetJson = json_decode($createSubFolder, true);

                    if ($objetJson['status'] == 200) {

                      $docToken = $objetJson['fold_token'];
                      $this->deplacerDossier($docRefToken, $docToken);
                      $this->modifierParcelle($idParcelle, $docToken);
                      $message = $this->createMiseAjourPerte($codeDemande, $docToken);
                    } else {
                      $message = '<div class="alert alert-danger text-center" id="message">le dossier portant ce nom existe deja</div>';
                    }
                  }
                } else {
                  $message = '<div class="alert alert-danger text-center" id="message">la parcelle n\'a pas de dossier</div>';
                }
              } else {
                $message = '<div class="alert alert-danger text-center" id="message">LE TOKEN EST INEXISTANT COTE BPS, archivage échoué</div>';
              }
            }
          } else {
            $message = '<div class="alert alert-danger text-center" id="message">la parcelle n\'a pas de dossier</div>';
          }
          return $message;
        } elseif ($res_docbox_alfresco == 2) {
          if ($requerant->data) {
            if ($this->login_alfresco()) {
              for ($i = 0; $i < count($parcelle); $i++) {
                if ($parcelle[$i]->NUMERO_PARCELLE == $numeroParcelle) {
                  if ($parcelle[$i]->ALF_TOKEN != null && $parcelle[$i]->ALF_REF_TOKEN != null) {
                    if ($parcelle->success) {

                      $fold_token   = $parcelle->data->ALF_TOKEN;
                      $subFoldToken = $parcelle->data->ALF_REF_TOKEN;
                      $fold_name   = "D" . $idDemande;
                      $description = "D" . date('Y');

                      if ($fold_token != null) {
                        $infoDossier = $this->get_data_of_folder($fold_token);
                        $path = $infoDossier->item->location->path;
                        $parts = explode('/', $path);
                        $valueNature = $parts[2];

                        if ($valueNature == "D") {
                          $donnees = array('name' => $fold_name, 'title' => $fold_name, 'description' => $description);
                          $createSubFolder = $this->create_folder_alfresco($this->login_alfresco(), $donnees, $fold_token);
                          $createSubFolder = $createSubFolder->nodeRef;
                          $createSubFolder = str_replace('workspace://SpacesStore/', '', $createSubFolder);
                          if (!empty($createSubFolder)) {
                            $foldToken = $createSubFolder;

                            $this->move_file_alfresco($this->login_alfresco(), $subFoldToken, $foldToken);
                            $sendFile = $this->save_perte_alfresco($codeDemande, $foldToken);

                            if ($sendFile) {
                              $message = '<div class="alert alert-success text-center" id="message">Archivage effectué avec succès</div>';
                            } else {
                              $message = '<div class="alert alert-danger text-center" id="message">archivage echoué</div>';
                            }
                          } else {
                            $message = '<div class="alert alert-danger text-center" id="message">le dossier portant ce nom existe deja</div>';
                          }
                        } else {

                          $province = $this->recupererInfoProvince($parcelle->data->COLLINE_ID);
                          $tokenD = $this->CI->Model->getRequeteOne(
                            'SELECT dossier_processus_id,province_id,token_dossiers_processus_province 
                        FROM edrms_dossiers_processus_province WHERE dossier_processus_id=9 and province_id=' . $province['PROVINCE_ID']
                          );

                          if ($tokenD) {

                            $this->move_file_alfresco($this->login_alfresco(), $fold_token, $tokenD['token_dossiers_processus_province']);
                            $donnees = array('name' => $fold_name, 'title' => $fold_name, 'description' => $description);
                            $createSubFolder = $this->create_folder_alfresco($this->login_alfresco(), $donnees, $fold_token);
                            $createSubFolder = $createSubFolder->nodeRef;
                            $createSubFolder = str_replace('workspace://SpacesStore/', '', $createSubFolder);

                            if (!empty($createSubFolder)) {

                              $foldToken = $createSubFolder;
                              $this->move_file_alfresco($this->login_alfresco(), $subFoldToken, $foldToken);
                              $sendFile = $this->save_perte_alfresco($codeDemande, $foldToken);

                              if ($sendFile) {
                                $message = '<div class="alert alert-success text-center" id="message">Archivage effectué avec succès</div>';
                              } else {
                                $message = '<div class="alert alert-danger text-center" id="message">archivage echoué</div>';
                              }
                            } else {
                              $message = '<div class="alert alert-danger text-center" id="message">le dossier portant ce nom existe deja</div>';
                            }
                          } else {
                            $message = '<div class="alert alert-danger text-center" id="message">le dossier D pour cette province n\'existe pas</div>';
                          }
                        }
                      } else {
                        $message = '<div class="alert alert-danger text-center" id="message">la parcelle n\'a pas de dossier</div>';
                      }
                    } else {
                      $message = '<div class="alert alert-danger text-center" id="message">La parcelle n\'existe pas</div>';
                    }
                  }
                }
              }
            }
          } else {
            $message = '<div class="alert alert-danger text-center" id="message">Le requerant n\'existe pas</div>';
          }
          return $message;
        }
      }
    }

    // <franssen@mediabox.bi>
    public function save_perte_alfresco($code_demande, $alfToken)
    {
      // Appelle une méthode pour se connecter à une base de données. 
      $this->login_alfresco();
      $message = '';

      if (!empty($this->envoyer_ficher_alfresco($code_demande))) {
        $donnees_get = str_replace('@', '', $this->envoyer_ficher_alfresco($code_demande));
        $get_index_datas = explode('<>', $donnees_get);

        for ($i = 0; $i < count($get_index_datas) - 1; $i++) {
          $tab_doc_id = explode('#', $get_index_datas[$i]);
          $tab_doc_id1 = explode('/', $tab_doc_id[0]);

          $getnom_doc = $this->CI->Model->getOne('pms_documents', ['ID_DOCUMENT' => $tab_doc_id[1]]);
          $desc_nom_doc = (!empty($getnom_doc['DESC_DOCUMENT'])) ? $getnom_doc['DESC_DOCUMENT'] : '';
          $data = $this->send_file_to_alfresco($tab_doc_id1[3], $tab_doc_id1[6], $tab_doc_id1[4], $tab_doc_id1[5], $alfToken, $desc_nom_doc);
        }
        $message = '<div class="alert alert-success text-center" id="message">Archivage effectué avec succès</div>';
      } else {
        $message = '<div class="alert alert-danger text-center" id="message">LES FICHIERS SONT INEXISTANT, archivage échoué</div>';
      }
      return $message;
    }

// public function share_copropriete_succession(
//     $id_attribution,
//     $email,
//     $fullname,
//     $password,
//     $nom_entreprise = "",
//     $mobile,
//     $rc = "",
//     $cni = "",
//     $lieu_delivrance_cni = "",
//     $num_doc_notaire = "",
//     $provence_id = "",
//     $zone_id,
//     $commune_id,
//     $colline_id,
//     $date_naissance = "",
//     $sexe_id,
//     $father_fullname = "",
//     $mother_fullname = "",
//     $country_code = "",
//     $NUMERO_PARCELLE,
//     $IS_COPROPRIETE,
//     $USAGE_ID,
//     $NUMERO_CADASTRAL = "",
//     $NUMERO_ORDRE_GENERAL = "",
//     $NUMERO_ORDRE_SPECIAL = "",
//     $SUPERFICIE = "",
//     $SUPERFICIE_HA = "",
//     $SUPERFICIE_ARE = "",
//     $SUPERFICIE_CA = "",
//     $PRIX = "",
//     $VOLUME = "",
//     $FOLIO = "",
//     $SIGN_PV_CHEF_CADASTRE = "",
//     $SIGN_PV_CONSERVATEUR = "",
//     $STATUT_PROPRIETAIRE_PARCELLE = "",
//     $DOC_TOKEN = "",
//     $ALF_TOKEN = "",
//     $DOC_REF_TOKEN = "",
//     $ALF_REF_TOKEN = "",
//     $profile_pic = "",
//     $path_signature = "",
//     $path_cni = "",
//     $COLLINE_PARCELLE_ID = ""
// ) {
    // Transformer $fullname en une chaîne formatée

//   $result = [];
// foreach ($fullname as $item) {
//     if (isset($item['fullname'])) {
//         $result[] = $item['fullname'];
//     }
// }

//  $fullnameFormatted = [];
//     foreach ($fullname as $index => $item) {
//         if (isset($item['fullname'])) {
//             $fullnameFormatted["fullname[$index]"] = $item['fullname'];
//         }
//     }




//     $data = [
//         'ID_ATTRIBUTION'               => $id_attribution,
//         'email'                        => $email,
//         'fullname'                     => $fullnameFormatted,
//         'password'                     => $password,
//         'nom_entreprise'               => $nom_entreprise,
//         'mobile'                       => $mobile,
//         'rc'                           => $rc,
//         'cni'                          => $cni,
//         'lieu_delivrance_cni'          => $lieu_delivrance_cni,
//         'num_doc_notaire'              => $num_doc_notaire,
//         'provence_id'                  => $provence_id,
//         'zone_id'                      => $zone_id,
//         'commune_id'                   => $commune_id,
//         'colline_id'                   => $colline_id,
//         'date_naissance'               => $date_naissance,
//         'sexe_id'                      => $sexe_id,
//         'father_fullname'              => $father_fullname,
//         'mother_fullname'              => $mother_fullname,
//         'country_code'                 => $country_code,
//         'NUMERO_PARCELLE'              => $NUMERO_PARCELLE,
//         'IS_COPROPRIETE'               => $IS_COPROPRIETE,
//         'USAGE_ID'                     => $USAGE_ID,
//         'NUMERO_CADASTRAL'             => $NUMERO_CADASTRAL,
//         'NUMERO_ORDRE_GENERAL'         => $NUMERO_ORDRE_GENERAL,
//         'NUMERO_ORDRE_SPECIAL'         => $NUMERO_ORDRE_SPECIAL,
//         'SUPERFICIE'                   => $SUPERFICIE,
//         'SUPERFICIE_HA'                => $SUPERFICIE_HA,
//         'SUPERFICIE_ARE'               => $SUPERFICIE_ARE,
//         'SUPERFICIE_CA'                => $SUPERFICIE_CA,
//         'PRIX'                         => $PRIX,
//         'VOLUME'                       => $VOLUME,
//         'FOLIO'                        => $FOLIO,
//         'STATUT_PROPRIETAIRE_PARCELLE' => $STATUT_PROPRIETAIRE_PARCELLE,
//         'DOC_TOKEN'                    => $DOC_TOKEN,
//         'ALF_TOKEN'                    => $ALF_TOKEN,
//         'DOC_REF_TOKEN'                => $DOC_REF_TOKEN,
//         'ALF_REF_TOKEN'                => $ALF_REF_TOKEN,
//         'COLLINE_PARCELLE_ID'          => $COLLINE_PARCELLE_ID
//     ];

//     // Gestion des fichiers
//     $files = [
//         'SIGN_PV_CHEF_CADASTRE' => $SIGN_PV_CHEF_CADASTRE,
//         'SIGN_PV_CONSERVATEUR'  => $SIGN_PV_CONSERVATEUR,
//         'profile_pic'           => $profile_pic,
//         'path_signature'        => $path_signature,
//         'path_cni'             => $path_cni
//     ];

//     foreach ($files as $key => $file) {
//         if (!empty($file)) {
//             $filePath = FCPATH . "uploads/doc_scanner/" . $file;
//             if (file_exists($filePath)) {
//                 $data[$key] = new CURLFile($filePath);
//             } else {
//                 error_log("⚠️ Fichier manquant : " . $filePath);
//             }
//         }
//     }

   
   
 

  
//     $data = json_encode($data, JSON_PRETTY_PRINT);
// echo "<pre>";
// print_r($data);
// echo "</pre>";
// die();



//     // URL de l'API
//     $url = "http://" . $this->base_url . "/api/v1/create/coproprietaire";

//     // Exécuter la requête API
  
//     $rescopro = $this->execute($url, $data, 'POST',$this->getToken());
//     print_r($rescopro);die();
//     return $rescopro;
// }

  function share_copropriete_succession(
    $id_attribution,
    $email,
    $fullname,
    $password,
    $nom_entreprise = "",
    $mobile,
    $rc = "",
    $cni = "",
    $lieu_delivrance_cni = "",
    $num_doc_notaire = "",
    $provence_id = "",
    $zone_id,
    $commune_id,
    $colline_id,
    $date_naissance = "",
    $sexe_id,
    $father_fullname = "",
    $mother_fullname = "",
    $country_code = "",
    $NUMERO_PARCELLE,
    $IS_COPROPRIETE,
    $USAGE_ID,
    $NUMERO_CADASTRAL = "",
    $NUMERO_ORDRE_GENERAL = "",
    $NUMERO_ORDRE_SPECIAL = "",
    $SUPERFICIE = "",
    $SUPERFICIE_HA = "",
    $SUPERFICIE_ARE = "",
    $SUPERFICIE_CA = "",
    $PRIX = "",
    $VOLUME = "",
    $FOLIO = "",
    $SIGN_PV_CHEF_CADASTRE = "",
    $SIGN_PV_CONSERVATEUR = "",
    $STATUT_PROPRIETAIRE_PARCELLE = "",
    $DOC_TOKEN = "",
    $ALF_TOKEN = "",
    $DOC_REF_TOKEN = "",
    $ALF_REF_TOKEN = "",
    $profile_pic = "",
    $path_signature = "",
    $path_cni = "",
    $COLLINE_PARCELLE_ID = "",
    $DATE_ATTRIBUTION = "",
    $registeras = ""
) {
    // Transformer $fullname en une chaîne formatée



$result1 = [];
foreach ($fullname as $item) {
    if (isset($item['fullname'])) {
        $result1[] = $item['fullname'];
    }
}

      $result = [];

// Parcourir chaque élément du tableau
foreach ($fullname as $item) {
       $result[] = [
        'fullname' => $item['fullname'],
        'country_code' => $item['country_code'],
        'provence_id' => $item['provence_id'],
        'commune_id' => $item['commune_id'],
        'zone_id' => $item['zone_id'],
        'colline_id' =>$item['colline_id'],
        'father_fullname' => $item['father_fullname'],
        'mother_fullname' => $item['mother_fullname'],
        'date_naissance' => $item['date_naissance'],
        'sexe_id' =>$item['sexe_id'],
        'email' =>$item['email']
    ];


   
}

$jsonResult = json_encode($result);


    $data = [
        'ID_ATTRIBUTION'               => $id_attribution,
        'email'                        => $email,
        'username'                     => $email,
        'fullname'                     => $nom_entreprise,
        'password'                     => $password,
        'NOM_PRENOM'                   => $nom_entreprise,
        'mobile'                       => $mobile,
        'rc'                           => $rc,
        'cni'                          => $cni,
        'lieu_delivrance_cni'          => $lieu_delivrance_cni,
        'num_doc_notaire'              => $num_doc_notaire,
        'provence_id'                  => $provence_id,
        'zone_id'                      => $zone_id,
        'commune_id'                   => $commune_id,
        'colline_id'                   => $colline_id,
        'date_naissance'               => $date_naissance,
        'sexe_id'                      => $sexe_id,
        'father_fullname'              => $father_fullname,
        'mother_fullname'              => $mother_fullname,
        'country_code'                 => $country_code,
        'NUMERO_PARCELLE'              => $NUMERO_PARCELLE,
        'IS_COPROPRIETE'               => $IS_COPROPRIETE,
        'USAGE_ID'                     => $USAGE_ID,
        'NUMERO_CADASTRAL'             => $NUMERO_CADASTRAL,
        'NUMERO_ORDRE_GENERAL'         => $NUMERO_ORDRE_GENERAL,
        'NUMERO_ORDRE_SPECIAL'         => $NUMERO_ORDRE_SPECIAL,
        'SUPERFICIE'                   => $SUPERFICIE,
        'SUPERFICIE_HA'                => $SUPERFICIE_HA,
        'SUPERFICIE_ARE'               => $SUPERFICIE_ARE,
        'SUPERFICIE_CA'                => $SUPERFICIE_CA,
        'PRIX'                         => $PRIX,
        'VOLUME'                       => $VOLUME,
        'FOLIO'                        => $FOLIO,
        'STATUT_PROPRIETAIRE_PARCELLE' => $STATUT_PROPRIETAIRE_PARCELLE,
        'DOC_TOKEN'                    => $DOC_TOKEN,
        'ALF_TOKEN'                    => $ALF_TOKEN,
        'DOC_REF_TOKEN'                => $DOC_REF_TOKEN,
        'ALF_REF_TOKEN'                => $ALF_REF_TOKEN,
        'COLLINE_PARCELLE_ID'          => $COLLINE_PARCELLE_ID,
        'allApplicants'                => $jsonResult,
        'COLLINE_COPR_REPR_ID'         => $colline_id,
        'SIGN_PV_CHEF_CADASTRE'        => 0,
          'SIGN_PV_CONSERVATEUR'       => 0,
        'registeras'                   => $registeras,
        
       
    ];



   // $jsonPayload = json_encode($data); 
//     $fileData = [];
//     $files = [
//     'profile_pic'           => $profile_pic,
//     'path_signature'        => $path_signature,
//     'SIGNATURE'             => $path_signature,
//     'path_cni'              => $path_cni
// ];
// foreach ($files as $key => $file) {
//     if (!empty($file)) {
//         $filePath = FCPATH . "uploads/doc_scanner/" . $file;
//         if (file_exists($filePath)) {
//             // $data[$key] = $filePath; // Assigner directement le chemin du fichier
//             $data[$key] = new CURLFile($filePath);
//         } else {
//             error_log("⚠️ Fichier manquant : " . $filePath);
//         }
//     }
// }

 // $postData = array_merge(['json_data' => $jsonPayload], $fileData);
   
         // $data = json_encode($data, JSON_PRETTY_PRINT);

    // Gestion des fichiers
    $files = [
        'profile_pic'           => $profile_pic,
        'path_signature'        => $path_signature,
        'path_cni'             => $path_cni,
        'SIGNATURE'             => $path_signature
    ];

    foreach ($files as $key => $file) {
        if (!empty($file)) {
            $filePath = FCPATH . "uploads/doc_scanner/" . $file;
            if (file_exists($filePath)) {
                $data[$key] = new CURLFile($filePath);
            } else {
                error_log("⚠️ Fichier manquant : " . $filePath);
            }
        }
    }




    
           // echo "<pre>";
         // print_r($data);
         // echo "</pre>";
         // die();   


    // URL de l'API
    $url = "https://" . $this->base_url . "/api/v1/create/coproprietaire";

    // Exécuter la requête API

  
    // $rescopro = $this->executing($url,$data, 'POST',$this->getToken());
     $rescopro =  $this->executing($url, $data, 'POST');

     //     echo "<pre>";
     //      print_r($rescopro);
     // echo "</pre>";
     // die();
   return $rescopro;
}

//reenvoyer le nouveau proprietaire si la parcelle a changé du propriétaire
// Eric ndayizeye
function SendNewRequerant(
  $USER_ID = "",        
  $TYPE_PARCELLE  = "" ,
  $RAISON_MODIF_ID,
  $NUMERO_PARCELLE = "",
  $STATUT_ENVOI_BPS= "",
  $statut_bps = "",     
  $IS_CHEF ,       
  $IS_MANDATAIRE = "" , 
  $NOM_CEDANT  = "" ,   
  $POURCENTAGE ,   
  $IS_COPROPRIETE = "",
  $USAGE_ID= "",       
  $EMAIL = "",  
  $USERNAME= "",
  $PASSWORD= "",
  $FULLNAME= "",
  $MOBILE= "" , 
  $PROVINCE_NAISSANCE_ID= "",
  $COMMUNE_NAISSANCA_ID= "" ,
  $ZONE_NAISSANCA_ID= "" ,
  $COLLINE_NAISSANCE_ID = "", 
  $systeme_id = "",           
  $country_code = "" ,            
  $registeras = "" ,  
  $reseau_social = "",
  $siege = "" ,       
  $rc = "" ,          
  $cni = "" ,            
  $num_doc_notaire = "", 
  $date_naissance = "",  
  $nif = "" ,            
  $type_demandeur = "" , 
  $type_document_id = "",
  $sexe_id = "" ,        
  $new_buyer = "" ,      
  $father_fullname = "", 
  $mother_fullname = "" ,
  $boite_postale = "",   
  $LIEU_DELIVRANCE = "" ,
  $DATE_DELIVRANCE = "" ,
  $DOC_TOKEN = "",         
  $ALF_TOKEN = "" ,        
  $DOC_REF_TOKEN = "",     
  $ALF_REF_TOKEN = "",         
  $AUTRE_RAISON_MODIF = "",
  $nom_entreprise = "",    
  $lieu_delivrance_cni = "",
  $path_doc_notaire = "",
  $profile_pic = "",
  $path_signature = "",
  $path_cni = "",
  $volume = "",
  $folio = "",
  $dataToSend
) {
    // Transformer $fullname en une chaîne formatée
  $result1 = [];
  foreach ($dataToSend as $item) {
    if (isset($item['fullname'])) {
      $result1[] = $item['fullname'];
    }
  }

  $result = [];

// Parcourir chaque élément du tableau
  foreach ($dataToSend as $item) {
   $result[] = [
    'fullname' => $item['fullname'],
    'country_code' => $item['country_code'],
    'provence_id' => $item['provence_id'],
    'commune_id' => $item['commune_id'],
    'zone_id' => $item['zone_id'],
    'colline_id' =>$item['colline_id'],
    'father_fullname' => $item['father_fullname'],
    'mother_fullname' => $item['mother_fullname'],
    'date_naissance' => $item['date_naissance'],
    'sexe_id' =>$item['sexe_id'],
    'email' =>$item['email'],
    'registeras' =>$item['email'],
    'cni' =>$item['cni'],
    'mobile' =>$item['mobile'],
  ]; 
}

$jsonResult = json_encode($result);

$data = [
  'USER_ID'                 => $USER_ID,
  'TYPE_PARCELLE'           => $TYPE_PARCELLE,
  'RAISON_MODIF_ID'         => $RAISON_MODIF_ID,
  'NUMERO_PARCELLE'         => $NUMERO_PARCELLE,
  'STATUT_ENVOI_BPS'        => $STATUT_ENVOI_BPS,
  'statut_bps'              => $statut_bps,
  'IS_CHEF'                 => $IS_CHEF,
  'IS_MANDATAIRE'           => $IS_MANDATAIRE,
  'NOM_CEDANT'              => $NOM_CEDANT,
  'POURCENTAGE'             => $POURCENTAGE,
  'IS_COPROPRIETE'          => $IS_COPROPRIETE,
  'USAGE_ID'                => $USAGE_ID,
  'EMAIL'                   => $EMAIL,
  'USERNAME'                => $USERNAME,
  'PASSWORD'                => $PASSWORD,
  'FULLNAME'                => $FULLNAME,
  'MOBILE'                  => $MOBILE,
  'PROVINCE_NAISSANCE_ID'   => $PROVINCE_NAISSANCE_ID,
  'COMMUNE_NAISSANCA_ID'    => $COMMUNE_NAISSANCA_ID,
  'ZONE_NAISSANCA_ID'       => $ZONE_NAISSANCA_ID,
  'COLLINE_NAISSANCE_ID'    => $COLLINE_NAISSANCE_ID,
  'systeme_id'              => $systeme_id,
  'country_code'            => $country_code,
 
  'registeras'              => $registeras,
  'reseau_social'           => $reseau_social,
  'siege'                   => $siege,
  'rc'                      => $rc,
  'cni'                     => $cni,
  'num_doc_notaire'         => $num_doc_notaire,
  'date_naissance'          => $date_naissance,
  'nif'                     => $nif,
  'type_demandeur'          => $type_demandeur,
  'type_document_id'        => $type_document_id,
  'sexe_id'                 => $sexe_id,
  'new_buyer'               => $new_buyer,
  'father_fullname'         => $father_fullname,
  'mother_fullname'         => $mother_fullname,
  'boite_postale'           => $boite_postale,
  'LIEU_DELIVRANCE'         => $LIEU_DELIVRANCE,
  'DATE_DELIVRANCE'         => $DATE_DELIVRANCE,
  'DOC_TOKEN'               => $DOC_TOKEN,
  'ALF_TOKEN'               => $ALF_TOKEN,
  'DOC_REF_TOKEN'           => $DOC_REF_TOKEN,
  'ALF_REF_TOKEN'           => $ALF_REF_TOKEN,
  'AUTRE_RAISON_MODIF'      => $AUTRE_RAISON_MODIF,
  'nom_entreprise'          => $nom_entreprise,
  'lieu_delivrance_cni'     => $lieu_delivrance_cni,
  'VOLUME'                  => $volume,
  'FOLIO'                   => $folio,
  "ALLAPPLICANTS"           => $jsonResult,
];

    // Gestion des fichiers
$files = [
  'path_doc_notaire'  => $path_doc_notaire ,
  'profile_pic'   => $profile_pic,
  'path_signature'  => $path_signature ,
  'path_cni'  => $path_cni 
];

foreach ($files as $key => $file) {
  if (!empty($file)) {
    $filePath = FCPATH . "uploads/doc_scanner/" . $file;
    if (file_exists($filePath)) {
      $data[$key] = new CURLFile($filePath);
    } else {
      error_log("⚠️ Fichier manquant : " . $filePath);
    }
  }
}
        
    // URL de l'API
$url = "https://" . $this->base_url . "/api/v1/attribution-new/update-applicate";


    // $rescopro = $this->executing($url,$data, 'POST',$this->getToken());
$rescopro =  $this->executing($url, $data, 'GET');
          echo "<pre>";
         print_r($rescopro);
         echo "</pre>";
         die();
return $rescopro;
}

}
