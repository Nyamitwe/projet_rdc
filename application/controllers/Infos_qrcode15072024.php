<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Infos_qrcode extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index($STAGE_ID='',$ID_TRAITEMENT_DEMANDE = NULL,$CODE_TRAITEMENT='') {

		
		$datas['initial']='';
		$info_qrcode='';

		if ($STAGE_ID==1 || $STAGE_ID==107 || $STAGE_ID==2) {
			


			$getinfo=$this->Model->getRequeteOne("SELECT pdr.ID_TRAITEMENT_DEMANDE,pdr.PROCESS_ID,pdr.CODE_DEMANDE,ptr.NUMERO_PARCELLE,DATE_DECLARATION,sf.fullname,sf.email,sf.mobile,p.PROVINCE_NAME,com.COMMUNE_NAME,z.ZONE_NAME,CONCAT(z.ZONE_NAME,'«',co.COLLINE_NAME,'»') LOCALISATION,pp.DESCRIPTION_PROCESS,ptr.VOLUME,ptr.FOLIO,ptr.NUMERO_CADASTRAL,ptr.SUPERFICIE_HA,ptr.SUPERFICIE_ARE,ptr.SUPERFICIE_CA,ptr.NUMERO_CADASTRAL,co.COLLINE_NAME FROM pms_traitement_demande pdr 

				LEFT JOIN parcelle_attribution ptr ON ptr.NUMERO_PARCELLE=pdr.NUMERO_PARCELLE 
				LEFT JOIN sf_guard_user_profile sf ON sf.user_id=pdr.ID_REQUERANT 
				LEFT JOIN provinces p ON p.PROVINCE_ID=ptr.PROVINCE_ID 
				LEFT JOIN communes com ON com.COMMUNE_ID=ptr.COMMUNE_ID 
				LEFT JOIN pms_zones z ON z.ZONE_ID=ptr.ZONE_ID 
				LEFT JOIN collines co ON co.COLLINE_ID=ptr.COLLINE_ID 
				LEFT JOIN pms_process pp ON pp.PROCESS_ID=pdr.PROCESS_ID 
				WHERE md5(pdr.ID_TRAITEMENT_DEMANDE)='".$ID_TRAITEMENT_DEMANDE."'");

			$doc_scanner=$this->Model->getRequete("SELECT ID_DOCUMENT_DEMANDE,pms_type_documents.ID_TYPE_DOCUMENT,pms_documents_demande.PROCESS_ID,pms_documents.ID_DOCUMENT,pms_documents.DESC_DOCUMENT,DESCRIPTION,DESC_DOCUMENT,STOCKAGE,PATH_DOC FROM pms_documents_demande JOIN pms_documents ON pms_documents.ID_DOCUMENT = pms_documents_demande.ID_DOCUMENT JOIN pms_type_documents ON pms_type_documents.ID_TYPE_DOCUMENT = pms_documents.ID_TYPE_DOCUMENT JOIN pms_process ON pms_process.PROCESS_ID = pms_documents_demande.PROCESS_ID WHERE md5(CODE_TRAITEMENT)='".$CODE_TRAITEMENT."' AND pms_type_documents.ID_TYPE_DOCUMENT=1");

			$get_bon=$this->Model->getOne('pms_documents_demande',array('ID_DOCUMENT'=>23,'CODE_TRAITEMENT'=>$getinfo['CODE_DEMANDE']));

			$u=0;
			$doc_scan='';
			foreach ($doc_scanner as $key){
				$u++;
				$doc_scan.=$u.':'.$key['DESC_DOCUMENT']."\n";
			}
			if (!empty($getinfo)) {
            	// code...

				$info_qrcode='NOM DU DEPOSANT : '.$getinfo['fullname']."\n".'CODE DE LA DEMANDE : '.$getinfo['CODE_DEMANDE']."\n".'MOTIF : '.$getinfo['DESCRIPTION_PROCESS']."\n".'DATE DE DECLARATION : '.$getinfo['DATE_DECLARATION']."\n"."\n".' '.' Listes  des documents déposés : '."\n"."\n".$doc_scan;
			}

		}

		if ($STAGE_ID==15) {
			$getinfo=$this->Model->getRequeteOne("SELECT pdr.ID_TRAITEMENT_DEMANDE,pdr.ID_REQUERANT, pdr.PROCESS_ID,pdr.CODE_DEMANDE,ptr.NUMERO_PARCELLE,DATE_DECLARATION,sf.fullname,sf.email,sf.mobile,p.PROVINCE_NAME,com.COMMUNE_NAME,z.ZONE_NAME,CONCAT(z.ZONE_NAME,'«',co.COLLINE_NAME,'»') LOCALISATION,pp.DESCRIPTION_PROCESS,ptr.VOLUME,ptr.FOLIO,ptr.NUMERO_CADASTRAL,ptr.SUPERFICIE_HA,ptr.SUPERFICIE_ARE,ptr.SUPERFICIE_CA,ptr.NUMERO_CADASTRAL,pdr.STAGE_ID,co.COLLINE_NAME FROM pms_traitement_demande pdr 

				LEFT JOIN parcelle_attribution ptr ON ptr.NUMERO_PARCELLE=pdr.NUMERO_PARCELLE 
				LEFT JOIN sf_guard_user_profile sf ON sf.user_id=pdr.ID_REQUERANT 
				LEFT JOIN provinces p ON p.PROVINCE_ID=ptr.PROVINCE_ID 
				LEFT JOIN communes com ON com.COMMUNE_ID=ptr.COMMUNE_ID 
				LEFT JOIN pms_zones z ON z.ZONE_ID=ptr.ZONE_ID 
				LEFT JOIN collines co ON co.COLLINE_ID=ptr.COLLINE_ID 
				LEFT JOIN pms_process pp ON pp.PROCESS_ID=pdr.PROCESS_ID 
				WHERE md5(pdr.ID_TRAITEMENT_DEMANDE)='".$ID_TRAITEMENT_DEMANDE."'");

			$facture=$this->Model->getOne('pms_facturation',array('CODE_TRAITEMENT'=>md5($getinfo['CODE_DEMANDE'])));

			$info_qrcode='';
			if ($getinfo['PROCESS_ID']==21 ) {
				if (!empty($getinfo)) {
					$info_qrcode='NOM DU PROPRIETAIRE : '.$getinfo['fullname']."\n".'MOTIF : '.$getinfo['DESCRIPTION_PROCESS']."\n".'LOCALITE :  '.$getinfo['LOCALISATION']."\n".' '.'MONTANT A PAYER  :  4000  '.'FBU';
				}
   # code...
			}else{ 

				if (!empty($getinfo)) {
					$info_qrcode='NUMERO DE PARCELLE : '.$getinfo['NUMERO_PARCELLE']."\n".'NOM DU PROPRIETAIRE : '.$getinfo['fullname']."\n".'MOTIF : '.$getinfo['DESCRIPTION_PROCESS']."\n".'LOCALITE :  '.$getinfo['LOCALISATION']."\n".' '.'MONTANT A PAYER  :  4000  '.'FBU';
				}
			}
		}


		if ($STAGE_ID==12 || $STAGE_ID==66) {

			$getinfo=$this->Model->getRequeteOne("SELECT pdr.ID_TRAITEMENT_DEMANDE,pdr.PROCESS_ID,pdr.CODE_DEMANDE,ptr.NUMERO_PARCELLE,DATE_DECLARATION,sf.fullname,sf.email,sf.mobile,p.PROVINCE_NAME,com.COMMUNE_NAME,z.ZONE_NAME,CONCAT(z.ZONE_NAME,'«',co.COLLINE_NAME,'»') LOCALISATION,pp.DESCRIPTION_PROCESS,ptr.VOLUME,ptr.FOLIO,ptr.NUMERO_CADASTRAL,ptr.SUPERFICIE_HA,ptr.SUPERFICIE_ARE,ptr.SUPERFICIE_CA,ptr.NUMERO_CADASTRAL,co.COLLINE_NAME FROM pms_traitement_demande pdr 

				LEFT JOIN parcelle_attribution ptr ON ptr.NUMERO_PARCELLE=pdr.NUMERO_PARCELLE 
				LEFT JOIN sf_guard_user_profile sf ON sf.user_id=pdr.ID_REQUERANT 
				LEFT JOIN provinces p ON p.PROVINCE_ID=ptr.PROVINCE_ID 
				LEFT JOIN communes com ON com.COMMUNE_ID=ptr.COMMUNE_ID 
				LEFT JOIN pms_zones z ON z.ZONE_ID=ptr.ZONE_ID 
				LEFT JOIN collines co ON co.COLLINE_ID=ptr.COLLINE_ID 
				LEFT JOIN pms_process pp ON pp.PROCESS_ID=pdr.PROCESS_ID 
				WHERE md5(pdr.ID_TRAITEMENT_DEMANDE)='".$ID_TRAITEMENT_DEMANDE."'");

			if (!empty($getinfo)) {
				$info_qrcode='NUMERO DE PARCELLE : '.$getinfo['NUMERO_PARCELLE']."\n".'NOM & PRENOM  DU PROPRIETAIRE : '.$getinfo['fullname']."\n".'VOLUME : '.$getinfo['VOLUME']."\n".'FOLIO : '.$getinfo['FOLIO']."\n".'NUMERO DU CADASTRE NATIONAL:'.$getinfo['NUMERO_CADASTRAL']."\n".'LOCALITE : '.$getinfo['LOCALISATION']."\n".' '.'DATE DE DECLARATION : '.$getinfo['DATE_DECLARATION'];
			}
		}

		$datas['info_qrcode']=$info_qrcode;


		$this->load->view('Infos_qrcode_view',$datas);




	}





}
