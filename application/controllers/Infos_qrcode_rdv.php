<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Infos_qrcode_rdv extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index($id='') {

		
		$datas['initial']='';
		$info_qrcode='';

		$req_infos=$this->Model->getRequeteOne('SELECT pms_demandeur_audience.ID_DEMANDEUR_AUDIENCE,pms_process.DESCRIPTION_PROCESS, pms_traitement_audience.ID_TRAITEMENT_AUDIENCE,pms_demandeur_audience.CATHEGORIE_DEMANDEUR,pms_demandeur_audience.RAISON_SOCIALE,genre.GENRE, pms_demandeur_audience.NOM_PRENOM,pms_demandeur_audience.TELEPHONE,pms_demandeur_audience.EMAIL,pms_traitement_audience.JOUR_AUDIENCE ,pms_traitement_audience.HEURE_AUDIENCE,pms_demandeur_audience.TYPE_INITIATION_DEMANDE,pms_traitement_audience.STATUT_SCANNER FROM `pms_demandeur_audience`LEFT JOIN pms_traitement_audience on pms_traitement_audience.ID_DEMANDEUR_AUDEINCE=pms_demandeur_audience.ID_DEMANDEUR_AUDIENCE LEFT JOIN pms_process ON pms_process.PROCESS_ID=pms_demandeur_audience.ID_OBJET_VISITE left JOIN genre ON genre.GENRE_ID=pms_demandeur_audience.SEXE_ID WHERE md5(pms_traitement_audience.ID_TRAITEMENT_AUDIENCE)="'.$id.'" ');

		///print_r($req_infos);die();



		if ($req_infos['CATHEGORIE_DEMANDEUR']==5) 
		{
			$nom=$req_infos['RAISON_SOCIALE'];
		} 
		else 
		{
			$nom=$req_infos['NOM_PRENOM'];
		}

		if (!empty($req_infos)) {
			$info_qrcode='<b>NOM ET PRENOM : </b>'.$nom.",<br>".'<b>E-MAIL :</b> '.$req_infos['EMAIL'].",<br>".'<b>CODE DEMANDE :</b>  '.$req_infos['ID_DEMANDEUR_AUDIENCE'].",<br>".'<b>OBJET : </b> '.$req_infos['DESCRIPTION_PROCESS'].",<br>".' '.'<b>DATE RENDEZ VOUS : </b> '.$req_infos['JOUR_AUDIENCE'].' '.'<b>HEURE:</b>'.$req_infos['HEURE_AUDIENCE'].'';
		}


		$datas['info_qrcode']=$info_qrcode;


		$this->load->view('Infos_qrcode_rdv_view',$datas);




	}





}
