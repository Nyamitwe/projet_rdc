<?php
ini_set('memory_limit', '8192M');
/**
 * 
 */
class Test_api extends Ci_controller
{
	public function index()
	{
		// $t='D2000';
		$this->load->library('pms_api');
		// $t = "nandou95habimana@gmail.com";
		 // $t = "erielmbonihankuye01@gmail.com";
		// $t = "alfredntakiyica8@gmail.com";

		$t = "jessninziza@gmail.com";
		$var = $this->pms_api->login($t);

		// if(json_decode($var)->status==200)
		// {
		// 	$msg='existe';
		// }
		// else
		// {
		// 	$msg='existe pas';
		// }

		echo "<pre>";
		print_r($var);
		echo "</pre>";
		exit();
	}

	public function alfresco()
	{
	   $result=$this->pms_alfresco_lib->dossier_initial('01/15660');
	   print_r($result);
	   exit();
	}

	public function notification()
	{
		$mailTo = "romeodushime0@gmail.com";
		$hashedPassword = "abcdefghijklmnopqrstuvwxyz";

		$subject = 'Information';

		$messages = "Bonjour Mr/Mme Test.Bienvenue sur le système électronique de transfert de titres de propriété (PMS).<br>
		La Direction des Titres Fonciers et Cadastre National (DTFCN) reconnait votre enregistrement en tant que
		propriétaire de la parcelle numéro 0000029339 sise à Bujumbura-Mairie dans la commune Ntahangwa.<br>Vous aurez, ainsi, la possibilité d’effectuer des demandes de transfert, des mises à jour ou tout autre service en cas de besoin.
		<br>Vous-trouverez ci-dessous vos identifiants de connexion vous permettant d’avoir accès à votre espace personnel et aux informations relatives à vos parcelles.
		<br>Lien :<a href=" . base_url('/Login') . " target='_blank'>Cliquez-ici</a>
		<br>Nom d'utilisateur : " . $mailTo . "
		<br>Mot de passe : " . $hashedPassword . " ";

		$this->notifications->send_mail($mailTo, $subject, $cc_emails = array(), $messages, $attach = array());
	}

	public function notifications()
	{
		$mailTo = "erielmbonihankuye01@gmail.com";
		$hashedPassword = "abcdefghijklmnopqrstuvwxyz";

		$subject = 'Information';

		$messages = "Bonjour Mr/Mme Test.Bienvenue sur le système électronique de transfert de titres de propriété (PMS).<br>
		La Direction des Titres Fonciers et Cadastre National (DTFCN) reconnait votre enregistrement en tant que
		propriétaire de la parcelle numéro 0000029339 sise à Bujumbura-Mairie dans la commune Ntahangwa.<br>Vous aurez, ainsi, la possibilité d’effectuer des demandes de transfert, des mises à jour ou tout autre service en cas de besoin.
		<br>Vous-trouverez ci-dessous vos identifiants de connexion vous permettant d’avoir accès à votre espace personnel et aux informations relatives à vos parcelles.
		<br>Lien :<a href=" . base_url('/Login') . " target='_blank'>Cliquez-ici</a>
		<br>Nom d'utilisateur : " . $mailTo . "
		<br>Mot de passe : " . $hashedPassword . " ";

		$var = $this->notifications->send_mail($mailTo, $subject, $cc_emails = array(), $messages, $attach = array());
		print_r($var);
		exit();
	}

	public function test()
	{
		$t = '88K-Bub';
		$var = $this->pms_api->parcelle($t);

		// if(json_decode($var)->status==200)
		// {
		// 	$msg='existe';
		// }
		// else
		// {
		// 	$msg='existe pas';
		// }
    //adonismelence@gmail.com
		echo "<pre>";
		print_r($var);
		// print_r(json_decode($var));
		echo "</pre>";
		exit();
	}

	public function attributionUpdate()
	{
		$res = $this->pms_api->setParcelleAttributionAnnuler("8521e-Ca");
		var_dump($res);
		die();
	}

	public function updatePlot()
	{
		$res = $this->pms_api->setParcelleAnnuler(6539);
		var_dump($res);
		die();
	}

	public function getToken()
	{
		$data = array(
			'EMAIL' => 'agentobuha@dtfobuha.bi',
			'PASSWORD' => '12345678',
		);

		$url = "https://apps.mediabox.bi:27805/api/v1/auth/login";
		// $reponse =  $this->execute($url, json_encode($data));
		$reponse =  $this->pms_api->executeFormData($url, $data, 'POST');

		echo $reponse->{'data'}->{'token'};
	}

	public function attribution()
	{
		$var = $this->pms_api->createdAttributionPlot(
			6546,
			321,
			3,
			3,
			3,
			17,
			17,
			13,
			"021-M",
			0,
			132,
			73,
			6,
			1,
			"I",
			40,
			12,
			7
		);

		var_dump($var);
		die();
	}

	public function value()
	{
		$this->Model->getOne('sf_guard_user_profile', array('id' => 6));
		$result = $this->Model->getRequeteOne('SELECT `id`, `email`, `username`, `password`, `fullname`, `validate`, `created_at`, `updated_at`, `mobile`, `registeras`, `siege`, `rc`, `profile_pic`, `path_signature`, `path_cni`, `path_doc_notaire`, `cni`, `lieu_delivrance_cni`, `num_doc_notaire`, `provence_id`, `commune_id`, `date_naissance`, `systeme_id`, `nif`, `country_code`, `type_demandeur`, `type_document_id`, `sexe_id`, `new_buyer`, `father_fullname`, `mother_fullname`, `numerise`, `date_delivrance`,zone_id,colline_id,boite_postale,avenue FROM `sf_guard_user_profile` WHERE id=6');

		$num_parcelle = $this->Model->getOne('parcelle_attribution', array('ID_REQUERANT' => $result['id']));

		// $file =base_url('/uploads/doc_scanner/'.$result['profile_pic']);

		$file = FCPATH . 'uploads/doc_scanner/' . $result['profile_pic'];

		$cfile = new CURLFile($file, mime_content_type($file), $result['profile_pic']);


		$destinationUrl = 'https://api.example.com/upload'; // Replace with the destination API URL

		$fileContent = file_get_contents($file);


		$var = $this->pms_api->share_applicant($result['fullname'], $result['username'], $result['email'], $result['password'], $result['mobile'], $result['registeras'], $result['provence_id'], $result['commune_id'], $result['date_naissance'], $result['father_fullname'], $result['mother_fullname'], $result['lieu_delivrance_cni'], $result['date_delivrance'], $num_parcelle['NUMERO_PARCELLE'], $num_parcelle['SUPERFICIE'], $num_parcelle['USAGE_ID'], $result['cni'], $num_parcelle['PRIX'], $result['country_code'], $result['nif'], $result['zone_id'], $result['colline_id'], $result['sexe_id'], $result['boite_postale'], $result['avenue'], $result['profile_pic'], $result['path_signature'], $result['path_cni'], $num_parcelle['COLLINE_ID']);

		echo "<pre>";
		print_r($var);
		echo "</pre>";
		exit();
	}

	public function parcelle()
	{

		// $t = '2536';
		// $t = '896-K';
		 // $t = '01/566 Mitakataka';
		 // $t = '01-10080';
		 $t = '01-10055c';
		$var = $this->pms_api->parcelle($t);
		// $var = $this->pms_api->get_data_of_folder('833f2772-2831-46b1-912a-05d4d84828d2');
		// $idrequerant='31';
		// $iddemande='110';
		// $codedemande='TRANSF-00110';
		// $numeroParcelle='001-N';
		// $isDocBox_Alfr='2';
		// $transfert = $this->pms_api->send_file_transfert($idrequerant,$iddemande,$codedemande,$numeroParcelle,$isDocBox_Alfr);
		// print_r($transfert);die();


		print_r($var);
		exit();
	}


	public function info_requerant()
	{
		$t =2384;
		// $t = 539;
		//$t = 100007777;
		$var = $this->pms_api->info_requerant($t);

		print_r($var);
		exit();
	}


	public function login()
	{
		$var = $this->pms_api->connexion();
		print_r($var);
		exit();
	}
	public function login_alf()
	{
		$var = $this->pms_api->login_alfresco();
		print_r($var);
		exit();
	}

	//GET FOLDER LISTE
	public function find_data_of_folder()
	{
		$token = '48c33f81-42b5-477f-b02c-e1e6f538d22a';
		// $token = 'e3fbe651-4a7b-4eb9-9a2c-8d50c697bf74';

		$list = $this->pms_api->find_doc_token_alfresco($token);
		echo '<pre>';
		// print_r($list->metadata->parent->properties);
		print_r($list->metadata->parent->properties->{"cm:title"});
		echo '</pre>';
		
		die();
	}

	public function send_file_actualisation()
	{
		// $update=$this->pms_api->updateActualisationByProcess($idProcess);
		// print($update);
		// exit();
		$message = '';
		$json = file_get_contents('php://input'); // Récupère le contenu brut du corps de la requête JSON
		$data = json_decode($json, true); // Décode le JSON en un tableau associatif
		$idRequerant = $data['idRequerant'];
		$idDemande = $data['idDemande'];
		$codeDemande = $data['codeDemande'];
		$numeroParcelle = $data['numeroParcelle'];
		$idProcess = $data['idProcess'];
		$requerant = $this->pms_api->info_requerant($idRequerant);
		if ($requerant->data) {
			$getRequerant = $this->pms_api->login($requerant->data[0]->email);

			if ($getRequerant) {
				$parcelle = $getRequerant->data->NUMERO_PARCELLE;

				//$var=$this->pms_api->info_requerant($t);

				if ($parcelle) {
					//if (in_array($numeroParcelle, array_column($parcelle, 'NUMERO_PARCELLE'))) {

					for ($i = 0; $i < count($parcelle); $i++) {
						if ($parcelle[$i]->NUMERO_PARCELLE == $numeroParcelle) {
							//print("index ".$i);

							// 	exit();
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

								$infoDossier = $this->pms_api->recupererInfoDossier($fold_token);
								$convertJson = json_decode($infoDossier, true);
								$urlFolder = $convertJson['detail_fold']['url_folder'];
								$parts = explode('/', $urlFolder);
								$valueNature = $parts[3];
								if ($valueNature == "D") {
									//print("oui oui c D");

									$createSubFolder = $this->pms_api->creationSousDossier($fold_token, $fold_name, $description);
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
										$creationNewFold = $this->Model->create($table, $dataCreate);
										$moveFolder = $this->pms_api->deplacerDossier($subFoldToken, $foldToken);
										$updateTokenSubFoldParcelle = $this->pms_api->modifierParcelle($idParcelle, $foldToken);

										$sendFile = $this->pms_api->sendFileByDemand($codeDemande, $foldToken);
										if ($sendFile) {
											$message = '<div class="alert alert-success text-center" id="message">Archivage effectué avec succès</div>';
										} else {
											$message = '<div class="alert alert-danger text-center" id="message">archivage echoué</div>';
										}
									} else {
										$message = '<div class="alert alert-danger text-center" id="message">le dossier portant ce nom existe deja</div>';
									}
								} else {
									$province = $this->pms_api->recupererInfoProvince($colline);
									$tokenD = $this->Model->getRequeteOne('SELECT ID,ID_PROVINCE,ID_NATURE,TOKEN FROM edrms_docbox_province_nature WHERE ID_NATURE=9 and ID_PROVINCE=' . $province['PROVINCE_ID']);
									if ($tokenD) {
										$moveFolder = $this->pms_api->deplacerDossier($fold_token, $tokenD['TOKEN']);
										$createSubFolder = $this->pms_api->creationSousDossier($fold_token, $fold_name, $description);

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
											$creationNewFold = $this->Model->create($table, $dataCreate);

											$moveFolder = $this->pms_api->deplacerDossier($subFoldToken, $foldToken);
											$updateTokenSubFoldParcelle = $this->pms_api->modifierParcelle($idParcelle, $foldToken);

											$sendFile = $this->pms_api->sendFileByDemand($codeDemande, $foldToken);
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
				} //print(json_encode(['message' => 'Le requerant n\'a pas de parcelle ']));
			} else {
				$message = '<div class="alert alert-danger text-center" id="message">Le requerant n\'existe pas</div>';
			} //print(json_encode(['message' => 'Le requerant n\'existe pas ']));
		} else {
			$message = '<div class="alert alert-danger text-center" id="message">Le requerant n\'existe pas</div>';
		}
		print_r($message);
		exit();
		//return $message;
	}

	public function send_file_reunification()
	{


		$message = '';
		$json = file_get_contents('php://input'); // Récupère le contenu brut du corps de la requête JSON
		$data = json_decode($json, true); // Décode le JSON en un tableau associatif
		$statut = $data['statut'];
		$numero = $data['numero'];
		$superficie = $data['superficie'];
		$idRequerant = $data['idRequerant'];
		$idDemande = $data['idDemande'];
		$codeDemande = $data['codeDemande'];
		$numeroParcelle = $data['numeroParcelle'];
		$foldParcelle_name = $data['nomParcelle'];
		$usage_id = $data['usage_id'];

		$statut_id = $data['statut_id'];
		$superficie_ha = $data['superficie_ha'];
		$superficie_are = $data['superficie_are'];
		$superficie_ca = $data['superficie_ca'];
		$volume = $data['volume'];
		$folio = $data['folio'];
		$numero_ordre_general = $data['numero_ordre_general'];
		$numero_ordre_special = $data['numero_ordre_special'];
		$fold_name = "D" . $idDemande;
		$description = "D" . $idDemande;
		if ($statut) {
			if (count($numeroParcelle) != 0) {
				$tokenReunif = $this->pms_api->parcelle($numeroParcelle[0]);
				$province = $this->pms_api->recupererInfoProvince($tokenReunif->data->COLLINE_ID);
				if ($statut == 1) {
					$tokenD = $this->Model->getRequeteOne('SELECT ID,ID_PROVINCE,ID_NATURE,TOKEN FROM edrms_docbox_province_nature WHERE ID_NATURE=9 and ID_PROVINCE=' . $province['PROVINCE_ID']);
					if ($tokenD) {
						$createFolder = $this->pms_api->creationSousDossier($tokenD['TOKEN'], $foldParcelle_name, $foldParcelle_name);
						$objetJson = json_decode($createFolder, true);
						if ($objetJson['status'] == 200) {
							$foldTokenParcelle = $objetJson['fold_token'];
							$createSubFolder = $this->pms_api->creationSousDossier($foldTokenParcelle, $fold_name, $description);
							$objetJson2 = json_decode($createSubFolder, true);
							if ($objetJson2['status'] == 200) {
								$foldTokenSubFolder = $objetJson2['fold_token'];
								$table = 'edrms_repertoire_processus_sous_repertoire_new';

								for ($i = 0; $i < count($numeroParcelle); $i++) {
									$tokenReunif = $this->pms_api->parcelle($numeroParcelle[$i]);

									$createSubFolder = '';
									$objetJson = '';
									$foldToken = '';
									$subFoldToken = '';
									$idParcelle = '';
									if ($tokenReunif->data->DOC_REF_TOKEN != null) {

										$colline = $tokenReunif->data->COLLINE_ID;
										$fold_token = $tokenReunif->data->DOC_TOKEN;
										$subFoldToken = $tokenReunif->data->DOC_REF_TOKEN;
										$idParcelle = $tokenReunif->data->ID_PARCELLE;

										$moveFolder = $this->pms_api->deplacerDossier($subFoldToken, $foldTokenSubFolder);
										$dataUpdate = array(
											'statut_actualisation' => 0
										);
										$UpdateOldFold = $this->Model->update($table, array('token_sous_repertoire' => $subFoldToken), $dataUpdate);

										$setParcelleAnnuler = $this->pms_api->setParcelleAnnuler($idParcelle);
										$setParcelleAttributionAnnuler = $this->pms_api->setParcelleAttributionAnnuler($numeroParcelle[$i]);
										//}
									}
								}
								$sendFile = $this->pms_api->sendFileByDemand($codeDemande, $foldTokenSubFolder);
								$addParcelleAttribuer = $this->pms_api->saveParcelle($numero, $superficie, $province['PROVINCE_ID'], $province['COMMUNE_ID'], $province['ZONE_ID'], $province['COLLINE_ID'], $province['PROVINCE_NAME'], $province['COMMUNE_NAME'], $province['ZONE_NAME'], $province['COLLINE_NAME'], 2, $foldTokenParcelle, $foldTokenSubFolder, null, null);
								$addParcelleAttribution = $this->pms_api->createdAttributionPlot(
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
								$creationNewFold = $this->Model->create($table, $dataCreate);
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
					$tokenD = $this->Model->getRequeteOne('SELECT id,dossier_processus_id,province_id,token_dossiers_processus_province FROM edrms_dossiers_processus_province WHERE dossier_processus_id=9 and province_id=' . $province['PROVINCE_ID']);
					if ($tokenD) {
						$ticket = $this->pms_api->login_alfresco();
						$dataCreateFolder = array(
							"name" => $foldParcelle_name,
							"title" => $foldParcelle_name,
							"description" => $foldParcelle_name,
						);
						$createFolder = $this->pms_api->create_folder_alfresco($ticket, $dataCreateFolder, $tokenD['token_dossiers_processus_province']);
						if (property_exists($createFolder, 'nodeRef')) {
							$explodeRes = explode('/', $createFolder->nodeRef);
							$foldTokenParcelle = $explodeRes[3];
							$dataCreateSubFolder = array(
								"name" => $fold_name,
								"title" => $fold_name,
								"description" => $fold_name,
							);
							$createSubFolder = $this->pms_api->create_folder_alfresco($ticket, $dataCreateSubFolder, $foldTokenParcelle);
							if (property_exists($createSubFolder, 'nodeRef')) {
								$explodeRes2 = explode('/', $createSubFolder->nodeRef);
								$foldTokenSubFolder = $explodeRes2[3];
								$table = 'edrms_repertoire_processus_sous_repertoire_new';
								for ($i = 0; $i < count($numeroParcelle); $i++) {
									$tokenReunif = $this->pms_api->parcelle($numeroParcelle[$i]);

									$createSubFolder = '';
									$objetJson = '';
									$foldToken = '';
									$subFoldToken = '';
									$idParcelle = '';
									if ($tokenReunif->data->ALF_REF_TOKEN != null) {

										$colline = $tokenReunif->data->COLLINE_ID;
										$fold_token = $tokenReunif->data->ALF_TOKEN;
										$subFoldToken = $tokenReunif->data->ALF_REF_TOKEN;
										$idParcelle = $tokenReunif->data->ID_PARCELLE;

										$moveFolder = $this->pms_api->move_file_alfresco($ticket, $subFoldToken, $foldTokenSubFolder);
										$dataUpdate = array(
											'statut_actualisation' => 0
										);
										$UpdateOldFold = $this->Model->update($table, array('token_sous_repertoire' => $subFoldToken), $dataUpdate);

										$setParcelleAnnuler = $this->pms_api->setParcelleAnnuler($idParcelle);
										$setParcelleAttributionAnnuler = $this->pms_api->setParcelleAttributionAnnuler($numeroParcelle[$i]);
										//}
									}
								}
								$sendFile = $this->pms_api->sendFileByDemandAlfresco($codeDemande, $foldTokenSubFolder);
								$addParcelleAttribuer = $this->pms_api->saveParcelle($numero, $superficie, $province['PROVINCE_ID'], $province['COMMUNE_ID'], $province['ZONE_ID'], $province['COLLINE_ID'], $province['PROVINCE_NAME'], $province['COMMUNE_NAME'], $province['ZONE_NAME'], $province['COLLINE_NAME'], 2, null, null, $foldTokenParcelle, $foldTokenSubFolder);
								$addParcelleAttribution = $this->pms_api->createdAttributionPlot(
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
								$creationNewFold = $this->Model->create($table, $dataCreate);
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
		print_r($message);
		exit();
		//return $message;
	}

	//  //fonction pour tester send_file_transfert
	// 	public Test_send_file_transfert($idRequerant=0,$idDemande=0,$codeDemande='',$numeroParcelle='',$isDocBox_Alfr=0){


	// $this->pms_api->send_file_transfert($idRequerant,$idDemande,$codeDemande,$numeroParcelle,$isDocBox_Alfr)

	// 	}

	public function send_file_transfert()
	{
		$message = '';
		$json = file_get_contents('php://input'); // Récupère le contenu brut du corps de la requête JSON
		$data = json_decode($json, true); // Décode le JSON en un tableau associatif6
		$idRequerant = $data['idRequerant'];
		$idDemande = $data['idDemande'];
		$codeDemande = $data['codeDemande'];
		$numeroParcelle = $data['numeroParcelle'];
		if ($numeroParcelle) {
			$getParcelleByNum = $this->pms_api->parcelle($numeroParcelle);
			if ($getParcelleByNum->success) {
				$colline = $getParcelleByNum->data->COLLINE_ID;
				$fold_token = $getParcelleByNum->data->DOC_TOKEN;
				$subFoldToken = $getParcelleByNum->data->DOC_REF_TOKEN;
				$idParcelle = $getParcelleByNum->data->ID_PARCELLE;
				$fold_name = "D" . $idDemande;
				$description = "D" . $idDemande;

				$infoDossier = $this->pms_api->recupererInfoDossier($fold_token);
				$convertJson = json_decode($infoDossier, true);
				$urlFolder = $convertJson['detail_fold']['url_folder'];
				$parts = explode('/', $urlFolder);
				$valueNature = $parts[3];
				if ($valueNature == "D") {
					//print("oui oui c D");

					$createSubFolder = $this->pms_api->creationSousDossier($fold_token, $fold_name, $description);
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
						$creationNewFold = $this->Model->create($table, $dataCreate);
						$moveFolder = $this->pms_api->deplacerDossier($subFoldToken, $foldToken);
						$updateParcelleAttributionReq = $this->pms_api->updateDataInfoApplicantAttribution($numeroParcelle, $idRequerant);

						$sendFile = $this->pms_api->sendFileByDemand($codeDemande, $foldToken);
						if ($sendFile) {
							$message = '<div class="alert alert-success text-center" id="message">Archivage effectué avec succès</div>';
						} else {
							$message = '<div class="alert alert-danger text-center" id="message">archivage echoué</div>';
						}
					} else {
						$message = '<div class="alert alert-danger text-center" id="message">le dossier portant ce nom existe deja</div>';
					}
				} else {
					$province = $this->pms_api->recupererInfoProvince($colline);
					$tokenD = $this->Model->getRequeteOne('SELECT ID,ID_PROVINCE,ID_NATURE,TOKEN FROM edrms_docbox_province_nature WHERE ID_NATURE=9 and ID_PROVINCE=' . $province['PROVINCE_ID']);
					if ($tokenD) {
						$moveFolder = $this->pms_api->deplacerDossier($fold_token, $tokenD['TOKEN']);
						$createSubFolder = $this->pms_api->creationSousDossier($fold_token, $fold_name, $description);

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
							$creationNewFold = $this->Model->create($table, $dataCreate);

							$moveFolder = $this->pms_api->deplacerDossier($subFoldToken, $foldToken);
							$updateParcelleAttributionReq = $this->pms_api->updateDataInfoApplicantAttribution($numeroParcelle, $idRequerant);

							$sendFile = $this->pms_api->sendFileByDemand($codeDemande, $foldToken);
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
				$message = '<div class="alert alert-danger text-center" id="message">ce numero de parcelle n\'existe pas</div>';
			}
		} else {
			$message = '<div class="alert alert-danger text-center" id="message">Veillez donner le numero parcelle </div>';
		}
		print_r($message);
		exit();
		//return $message;

	}
	public function moveFolder()
	{
		$json = file_get_contents('php://input'); // Récupère le contenu brut du corps de la requête JSON
		$data = json_decode($json, true); // Décode le JSON en un tableau associatif

		$fold_token = $data['fold_token'];
		$fold_token_dest = $data['fold_token_dest'];
		$var = $this->pms_api->deplacerDossier($fold_token, $fold_token_dest);

		print_r($var);
		exit();
	}

	public function fold()
	{
		$var = $this->pms_api->get_folder_cont();
		echo "<pre>";
		print_r(json_decode($var));
		echo "</pre>";
		exit();
	}

	public function hash()
	{
		$var = password_hash('12345', PASSWORD_DEFAULT);

		print_r($var);
		exit();

		$characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_=+';
		$length = 10;
		$password = '';

		$charCount = strlen($characters);
		for ($i = 0; $i < $length; $i++) {
			$password .= $characters[rand(0, $charCount - 1)];
		}
		// return $password;

		$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

		echo "Generated Password: " . $password . "\n<br>";
		echo "Hashed Password: " . $hashedPassword . "\n";

		// $var=password_hash($password, PASSWORD_DEFAULT);


	}


	public function retour_parcelle()
	{
		$parcelle = 'R/70099';
		$var = $this->pms_api->parcelle($parcelle);

		print_r($var);
		exit();
	}

	public function envoi_fichier()
	{
		$fileContent = new CURLFile('uploads/avatar/avatar_female.png');

		$resultat = $this->pms_api->send_file();

		print_r($resultat);
		exit();
	}

	public function initial()
	{
		$t = '1490a/N';
		$var = $this->pms_api->dossier_initial($t);
		// $var = $this->pms_api->data_requerant($t);


		echo "<pre>";
		print_r($var);
		// print_r(json_decode($var));
		echo "</pre>";
		exit();
	}

	public function show_content()
	{
		$tab_doc_id = '';
		$tab_doc_id = '';
		$tab_doc_id1 = '';

		$code_demande = "RACHYP-033";
		$donnees = $this->pms_api->envoyer_ficher($code_demande);


		$donnees_get = str_replace('@', '', $donnees);
		$index_donnees_get = explode('<>', $donnees_get);

		for ($j = 0; $j < count($index_donnees_get) - 1; $j++) {
			$tab_doc_id = $index_donnees_get[$j];
			$tab_doc_id = explode('#', $tab_doc_id); // [0] => http://localhost/pmsv3/uploads/doc_scanner/65f2bc2cebb0c.pdf [1] => 65 
			$tab_doc_id1 = explode('/', $tab_doc_id[0]); // [0] => http: [1] => [2] => localhost [3] => pmsv3 [4] => uploads [5] => doc_scanner [6] => 65f2bc2cebb0c.pdf 

		}
		$token = "bb16044dbebbb0f2b189cf735bb30e11";
		$desc_nom_doc = "Test 001";
		$donnees_ = $this->pms_api->send_file($tab_doc_id1[5], $tab_doc_id1[4], $token, 'PMS', $desc_nom_doc, $tab_doc_id[0]);
		var_dump($donnees_);
		die();
	}


	//
	public function saveFilesApplicantInfoDoc($code_demande, $num_parcelle)
	{
		$message = '';
		$parcelle  = $this->pms_api->parcelle($num_parcelle);

		if ($parcelle) {
			$subFoldToken = '';
			if ($parcelle->data->DOC_TOKEN != null && $parcelle->data->DOC_REF_TOKEN != null) {
				$subFoldToken = $parcelle->data->DOC_REF_TOKEN;
				$message = $this->pms_api->send_category_demande_info_doc_box($code_demande, $subFoldToken);
			} else {
				$message = '<div class="alert alert-danger text-center" id="message">LE TOKEN EST INEXISTANT, archivage échoué</div>';
			}
		}


		// if($message=='Archivage effectué avec succès')
		if (strpos($message, 'Archivage effectué avec succès') !== false) {
			$result = 'good';
		} else {
			$result = 'not gooooood';
		}

		print_r($result);
		exit();
	}
	//
	public function updateTransfertTitre($ID_REQUERANT, $ID_ATTRIBUTION)
	{
		$json = file_get_contents('php://input');
		$data = json_decode($json, true);

		$ID_REQUERANT 	= $data['ID_REQUERANT'];
		$ID_ATTRIBUTION	= $data['ID_ATTRIBUTION'];

		$res = $this->pms_api->updateInfoApplicantCategoryTransfertTitre(
			$ID_REQUERANT,
			$ID_ATTRIBUTION
		);
		echo json_decode($res);
	}
	//
	public function saveFolioVolume($id_parcelle, $date_signature, $date_delivrance, $numero_ordre_general, $delivrance, $numero_special)
	{
		$res = $this->pms_api->createdFolioVolume(
			$id_parcelle,
			$date_signature,
			$date_delivrance,
			$numero_ordre_general,
			$delivrance,
			$numero_special
		);
		return $res;
	}
	//
	public function saveFoldersCreatedsFilesMorcellement($code_demande, $num_parcelle = [], $id_demande)
	{
		$message 	= '';
		$parcelle   = $this->pms_api->parcelle(array_merge($num_parcelle));
		// $parcelle   =  

		if ($parcelle) {
			// Verification du TOKEN $doc_token & $docRefToken != message: "Archivage impossible" 
			if ($parcelle->data->DOC_TOKEN != null && $parcelle->data->DOC_REF_TOKEN != null) {
				$foldNameSubDoc	 = "D" . $id_demande;
				$id_colline  	 = $parcelle->data->COLLINE_ID;

				// Verifier la localite parcelle (localite qui est la province)
				$province 	= $this->pms_api->recupererInfoProvince($id_colline);

				// Cibler le dossier D de la localite : son TOKEN (ID_NATURE, ID_PROVINCE, TOKEN)
				$tokenDocD 	= $this->Model->getRequeteOne(
					'SELECT ID,ID_PROVINCE,ID_NATURE,TOKEN
					FROM edrms_docbox_province_nature 
					WHERE ID_NATURE=9 and
					ID_PROVINCE=' . $province['PROVINCE_ID']
				);

				$infoDossier = $this->pms_api->recupererInfoDossier($tokenDocD['TOKEN']);
				$convertJson = json_decode($infoDossier, true);
				$urlFolder 	 = $convertJson['detail_fold']['url_folder'];
				$parts 		 = explode('/', $urlFolder);
				$valueNature = $parts[3];
				$parcelle_id = $parcelle->data->ID_PARCELLE;

				if ($valueNature == "D") {
					if (is_array($num_parcelle)) {
						$this->pms_api->setParcelleAnnuler($parcelle_id);
						// Creation du nouveau dossier de la parcelle en Q
						foreach ($num_parcelle as $parcelle) {
							//Appeller DOC BOX pour la creation des sous-dossiers
							$resultToke 	  = $this->pms_api->creationSousDossier($tokenDocD['TOKEN'], $parcelle, $foldNameSubDoc);
							$objetJson = json_decode($resultToke, true);
							$foldTokenParcelle = $objetJson['fold_token'];
							//  Creation du sous-repertoire: D (id_demande)
							$resultDocRefToke = $this->pms_api->creationSousDossier($foldTokenParcelle['TOKEN'], $foldNameSubDoc, $foldNameSubDoc);
							//Appeller de la demande
							$objetJson = json_decode($resultDocRefToke, true);
							$allFiles  = $objetJson['fold_token'];
							$this->pms_api->save_create_folders_stockes_files_morcellement($code_demande, $allFiles);
							// sauvegader les infos ID_REQUERANT, ID_PARCELLE Dans le sous-repertoire et leurToken
							$this->pms_api->saveParcelle(
								$province['PROVINCE_ID'],
								$province['COMMUNE_ID'],
								$province['ZONE_ID'],
								$province['COLLINE_ID'],
								2,
								$foldTokenParcelle,
								$allFiles,
								$parcelle->NUMERO_PARCELLE,
								$parcelle->SUPERFICIE
							);
						}
					} else {
						$message = '<div class="alert alert-danger text-center" id="message">Le requerant n\'a pas de parcelle</div>';
					}
				} else {
					$message = '<div class="alert alert-danger text-center" id="message">LA NATURE DU DOSSIER EST INEXISTANT COTE DOCBOX</div>';
				}
			} else {
				$message = '<div class="alert alert-danger text-center" id="message">LE TOKEN EST INEXISTANT COTE BPS, archivage échoué</div>';
			}
		} else {
			$message = '<div class="alert alert-danger text-center" id="message">Le requerant n\'a pas de parcelle</div>';
		}
		return $message;
	}

	//
	public function sendMiseAJourPerte($id_demande, $code_demande, $num_parcelle)
	{
		$message  = '';
		$parcelle = $this->pms_api->parcelle($num_parcelle);

		if ($parcelle) {
			for ($i = 0; $i < count($parcelle); $i++) {
				if ($parcelle[$i]->NUMERO_PARCELLE == $num_parcelle) {
					$createSubFolder = '';
					$objetJson   = '';
					$docToken    = '';
					$docRefToken = '';
					$idParcelle  = '';

					if ($parcelle[$i]->DOC_TOKEN != null && $parcelle[$i]->DOC_REF_TOKEN != null) {
						$colline_id  = $parcelle[$i]->COLLINE_ID;
						$docoken     = $parcelle[$i]->DOC_TOKEN;
						$docRefToken = $parcelle[$i]->DOC_REF_TOKEN;
						$idParcelle  = $parcelle[$i]->ID_PARCELLE;
						$fold_name_and_description = "D" . $id_demande . '+D' . date('Y');

						$infoDossier = $this->pms_api->recupererInfoDossier($docoken);
						$convertJson = json_decode($infoDossier, true);
						$urlFolder   = $convertJson['detail_fold']['url_folder'];
						$parts       = explode('/', $urlFolder);
						$valueNature = $parts[3];

						if ($valueNature == "D") {
							//Creation du sous-repertoire
							$createSubFolder = $this->pms_api->creationSousDossier(
								$docoken,
								$fold_name_and_description,
								$fold_name_and_description
							);

							$objetJson = json_decode($createSubFolder, true);
							if ($objetJson['status'] == 200) {

								$docToken  = $objetJson['fold_token'];
								$table     = 'edrms_repertoire_processus_sous_repertoire_new';

								$modifyData = array(
									'statut_actualisation' => 0
								);
								$this->Model->update($table, array('token_sous_repertoire' => $docRefToken), $modifyData);

								$dataCreate = array(
									'nom_sous_repertoire'   => $fold_name_and_description,
									'token_sous_repertoire' => $docToken,
									'statut_actualisation'  => 1
								);

								$this->Model->create($table, $dataCreate);
								$this->pms_api->deplacerDossier($docRefToken, $docToken);
								$this->pms_api->modifierParcelle($idParcelle, $docToken);
								$this->pms_api->createMiseAjourPerte($code_demande, $docToken);
							}
						} else {
							$province  = $this->pms_api->recupererInfoProvince($colline_id);
							$docDToken = $this->Model->getRequeteOne(
								'SELECT ID,ID_PROVINCE,ID_NATURE,TOKEN FROM edrms_docbox_province_nature
								WHERE ID_NATURE=9 and ID_PROVINCE=' . $province['PROVINCE_ID']
							);

							$this->pms_api->deplacerDossier($docToken, $docDToken['TOKEN']);
							$createSubFolder = $this->pms_api->creationSousDossier(
								$docToken,
								$fold_name_and_description,
								$fold_name_and_description
							);

							$objetJson = json_decode($createSubFolder, true);
							if ($objetJson['status'] == 200) {

								$docToken  = $objetJson['fold_token'];

								$table = 'edrms_repertoire_processus_sous_repertoire_new';
								$modifyData = array(
									'statut_actualisation' => 0
								);

								$this->Model->update($table, array('token_sous_repertoire' => $docRefToken), $modifyData);
								$dataCreate = array(
									'nom_sous_repertoire'   => $fold_name_and_description,
									'token_sous_repertoire' => $docToken,
									'statut_actualisation'  => 1
								);

								$this->Model->create($table, $dataCreate);
								$this->pms_api->deplacerDossier($docRefToken, $docToken);
								$this->pms_api->modifierParcelle($idParcelle, $docToken);
								$message = $this->pms_api->createMiseAjourPerte($code_demande, $docToken);
							} else {
								$message = '<div class="alert alert-danger text-center" id="message">le dossier portant ce nom existe deja</div>';
							}
						}
					} else {
						$message = '<div class="alert alert-danger text-center" id="message">la parcelle n\'a pas de dossier</div>';
					}
				}
			}
		} else {
			$message = '<div class="alert alert-danger text-center" id="message">la parcelle n\'a pas de dossier</div>';
		}
		return $message;
	}

	// Created applicant 
	public function create_applicant()
	{
		$json = file_get_contents('php://input'); // Récupère le contenu brut du corps de la requête JSON
		$data = json_decode($json, true); // Décode le JSON en un tableau associatif
		$fullname = $this->input->post('fullname');
		$username = $this->input->post('username');
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$mobile = $this->input->post('mobile');
		$registeras = $this->input->post('registeras');
		$country_code = $this->input->post('country_code');
		$province_id = $this->input->post('province_id');
		$commune_id = $this->input->post('commune_id');
		$date_naissance = $this->input->post('date_naissance');
		// print_r($mobile);
		// exit();

		$res = $this->pms_api->create_applicant(
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
			// $avatar
		);
		//print_r($res);
		// exit();
		echo json_encode($res);
		//$res;
	}



	//archivage dans alfresco pour demande d'information
	public function send_category_demande_info_alfresco($code_demande, $token, $statut_parcelle, $id_parcelle)
	{
		// Appelle une méthode pour se connecter à une base de données. 
		$this->login();
		$data = $this->envoyer_ficher_alfresco($code_demande);
		$this->modifierInfoParcelleBPS($id_parcelle, $statut_parcelle);
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


	public function saveFilesApplicantInfoAlfresco($code_demande = 'MRCLM-022', $num_parcelle = '001-N', $statut_parcelle = null)
	{
		$message = '';
		// Appelle une méthode pour récupérer des informations sur une parcelle en fonction du numéro de parcelle.
		$parcelle    = $this->parcelle($num_parcelle);
		$id_parcelle = $parcelle->data->ID_PARCELLE;
		// Vérifie si des informations sur la parcelle ont été récupérées avec succès
		if ($parcelle) {
			if ($parcelle->data->ALF_TOKEN != null && $parcelle->data->ALF_REF_TOKEN != null) {
				$this->send_category_demande_info_alfresco($code_demande, $parcelle->data->ALF_REF_TOKEN, $statut_parcelle, $id_parcelle);
			} else {
				$message = `<div class="alert alert-danger text-center" id="message">LE TOKEN EST INEXISTANT cote BPS, archivage échoué</div>`;
			}
		}
		return $message;
	}

	public function get_doc_alfresco()
	{
		$folder_token = 'c996fc37-75ac-44da-8c6f-9b5afcaf6181';
		$parcelle = $this->pms_api->get_data_of_folder($folder_token);
		// echo json_decode($parcelle);
		echo json_encode($parcelle);
	}

	public function get_Token()
	{
		$var=$this->pms_api->getToken();


		print_r($var);
		exit();
	}

	public function check_requerant()
	{
		$username='erielmbonihankuye01@gmail.com';
		// $result = $this->pms_api->login($username); 
		// stdClass Object ( [success] => 1 [message] => La réponse a été réussie [data] => stdClass Object ( [id] => 455 [fullname] => Mbonihankuye Eriel [avatar] => http://192.168.0.25/uploads/REQUERANTS/1719583873_39a281f6f6c39fb698cd.jpg [email] => erielmbonihankuye01@gmail.com [username] => erielmbonihankuye01@gmail.com [password] => $2y$10$mmLzAu7bA6bVzJbwxv0f2.vHRL2xJLfb0R8ULbI2dlGlzXC4lOhZG [SIGNATURE] => http://192.168.0.25/uploads/REQUERANTS/1719583873_eb5b8c2e088ffc825149.jpg [mobile] => 71852258 [mother_fullname] => Mama [father_fullname] => Papa [cni] => 789444 [registeras] => 1 [date_naissance] => 1997-01-04 [LIEU_DELIVRANCE] => Buja [DATE_DELIVRANCE] => 2020-01-01 00:00:00 [path_cni] => http://192.168.0.25/uploads/REQUERANTS/1719583873_b38d325c97698633fd21.pdf [DOC_TOKEN] => [ALF_TOKEN] => 24091861-9ce5-42d8-9383-99cb46ab3908 [DOC_REF_TOKEN] => [ALF_REF_TOKEN] => ba28e307-419d-44f8-b477-bc696d56f1e1 [NUMERO_PARCELLE] => Array ( [0] => stdClass Object ( [NUMERO_PARCELLE] => 1813a-B [ID_PARCELLE] => 6538 [COLLINE_ID] => 2469 [DOC_TOKEN] => [ALF_TOKEN] => 24091861-9ce5-42d8-9383-99cb46ab3908 [DOC_REF_TOKEN] => [ALF_REF_TOKEN] => ba28e307-419d-44f8-b477-bc696d56f1e1 ) ) ) )

		$result=$this->pms_api->get_requerant(455);
		print_r($result);
		exit();

	}
	public function valueparcelle()
	{
		$num_parcelle=$this->Model->getOne('parcelle_attribution',array('md5(NUMERO_PARCELLE)'=>"8fd01cafb7181f5b13d746dfcd949214"));

    	$result=$this->Model->getRequeteOne('SELECT `id`, `email`, `username`, `password`,`nom_entreprise`,`fullname`, `validate`, `created_at`, `updated_at`, `mobile`, `registeras`, `siege`, `rc`, `profile_pic`, `path_signature`, `path_cni`, `path_doc_notaire`, `cni`, `lieu_delivrance_cni`, `num_doc_notaire`, `provence_id`, `commune_id`, `date_naissance`, `systeme_id`, `nif`, `country_code`, `type_demandeur`, `type_document_id`, `sexe_id`, `new_buyer`, `father_fullname`, `mother_fullname`, `numerise`, `date_delivrance`,zone_id,colline_id,boite_postale,avenue FROM `sf_guard_user_profile` WHERE id=163');


    	$check_existence_token_repertoire=$this->Model->getOne('edrms_repertoire_processus_parcelle_new',array('numero_parcelle'=>$num_parcelle['NUMERO_PARCELLE']));

    	$token_repertoire_alfresco=!empty($check_existence_token_repertoire) ? $check_existence_token_repertoire['token_dossiers_parcelle_processus'] : "";

    	$token_repertoire_docbox=!empty($check_existence_token_repertoire) ? $check_existence_token_repertoire['DOC_TOKEN'] : "";

    	$token_sous_repertoire_alfresco="";
    	$token_sous_repertoire_doc_box="";

    	if(!empty($check_existence_token_repertoire))
    	{
    		$check_existence_token_repertoire=$this->Model->getOne('edrms_repertoire_processus_sous_repertoire_new',array('dossier_processus_parcelle_id'=>$check_existence_token_repertoire['id']));
    		if(!empty($check_existence_token_repertoire))
    		{
    			$token_sous_repertoire_alfresco=$check_existence_token_repertoire['token_sous_repertoire'];
    			$token_sous_repertoire_doc_box=$check_existence_token_repertoire['DOC_REF_TOKEN'];
    		}
    	}


    	$var='';

    	$var=$this->pms_api->storeGetEmailApplicant($result['email'],$num_parcelle['NUMERO_PARCELLE'],$num_parcelle['SUPERFICIE'],$num_parcelle['PRIX'],$num_parcelle['STATUT_ID'],$num_parcelle['COLLINE_ID'],$num_parcelle['COLLINE_ID'],$num_parcelle['USAGE_ID'],$num_parcelle['VOLUME'],$num_parcelle['FOLIO'],$token_repertoire_docbox,$token_sous_repertoire_doc_box,$token_repertoire_alfresco,$token_sous_repertoire_alfresco);

		echo "<pre>";
		print_r($var);
		echo "</pre>";
		exit();
	}
}
