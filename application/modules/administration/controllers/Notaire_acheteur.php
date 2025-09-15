<?php

/**
 * 
 */
class Notaire_acheteur extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->isAuth();
		require('fpdf184/fpdf.php');
	}


	//CHECK AUTHENTIFICATION
	public function isAuth()
	{
		if (empty($this->get_utilisateur())) {
			redirect(base_url('Login'));
		}
	}


	//RECUPERATION DU LOGIN DE LA PERSONNE CONNECTEE
	public function get_utilisateur()
	{
		return $this->session->userdata('PMS_USER_ID');
	}

	public function index()
	{
	    $data['title']='LISTE DES UTILISATEURS';
	    $this->load->view('Liste_notaire_acheteur_view',$data);
	}

	public function listing()
	{
		$var_search= !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
		$var_search=str_replace("'","\'",$var_search);
		$query_principal="SELECT `ID_PV_VENTE`,`NUMERO_PARCELLE`,pms_type_transfert.DESCRIPTION_TRANSFERT,categorie_transfert.DESC_CATEGORIE_TRANSF,pms_categorie_acheteur_vendeur.DESC_ACHETEUR_VENDEUR,`PRIX_VENTE`,`PATH_PV_VENTE`,`DATE_INSERTION` FROM `pms_pv_vente` JOIN pms_type_transfert on pms_type_transfert.ID_TYPE_TRANSFERT=pms_pv_vente.ID_TYPE_TRANSFERT JOIN categorie_transfert on categorie_transfert.ID_CATEGORIE_TRANSFERT=pms_pv_vente.ID_CATEGORIE_TRANSFERT JOIN pms_categorie_acheteur_vendeur on pms_categorie_acheteur_vendeur.ID_CATEGORIE_ACHETEUR_VENDEUR=pms_pv_vente.ID_CATEGORIE_ACHETEUR_VENDEUR WHERE 1";

		$limit='LIMIT 0,10';
		if(isset($_POST['length']) AND $_POST['length'] != -1)
		{
			$limit='LIMIT '.$_POST["start"].','.$_POST["length"];
		}
		{
			$limit='LIMIT '.$_POST["start"].','.$_POST["length"];
		}

		$order_by='';

		$order_column=array('','NUMERO_PARCELLE','PRIX_VENTE','','','','','','');

		$order_by =' ORDER BY ID_PV_VENTE DESC';


		$search = !empty($_POST['search']['value']) ? (" AND (NUMERO_PARCELLE LIKE '%$var_search%' OR PRIX_VENTE LIKE '%$var_search%') ") : '';

		$critaire = '';

		$query_secondaire=$query_principal.' '.$critaire.' '.$search.' '.$order_by.' '.$limit;
		$query_filter = $query_principal.' '.$critaire.' '.$search;

		$fetch_notaire_acheteur = $this->Model->datatable($query_secondaire);
		$data = array();
		$u=0;


		foreach ($fetch_notaire_acheteur as $row)
		{

			$u++;
			$sub_array=array();
			$sub_array[]=$u;
			$sub_array[]=$row->NUMERO_PARCELLE;
			$sub_array[]=number_format($row->PRIX_VENTE, 2, '.', '.').' BIF';
			$sub_array[]=$row->DESCRIPTION_TRANSFERT;
			$sub_array[]=$row->DESC_CATEGORIE_TRANSF;
			$sub_array[]=$row->DESC_ACHETEUR_VENDEUR;
			$sub_array[]='<a title="Afficher" data-toggle="modal" data-target="#documents' . $row->ID_PV_VENTE. '" <i style="font-size:25px;color: red;" class="fa fa-file-pdf-o"></a>

			<div class="modal fade" id="documents' . $row->ID_PV_VENTE. '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
			<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
			<div class="modal-header">
			<div class="modal-title" id="exampleModalLabel"><b style="font-size:25px;">Projet de Vente</b></div>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
			<div id="message_chekup"></div>
			</div>
			<div class="modal-body">
			<embed src="'.base_url('/uploads/doc_generer/'.$row->PATH_PV_VENTE).'#toolbar=0" type="application/pdf" scrolling="auto" height="500px" width="100%">

			</div>

			</div>
			</div>
			</div>   
			';

        $sub_array[]='<a href="' . base_url('administration/Notaire_acheteur/detail/' . md5($row->ID_PV_VENTE)) . '" class="btn btn-info btn-sm"><span class="fa fa-eye"></span></a>';


    	$data[] = $sub_array;
		}
		$output = array(
			"draw" => intval($_POST['draw']),
			"recordsTotal" =>$this->Model->all_data($query_principal),
			"recordsFiltered" => $this->Model->filtrer($query_filter),
			"data" => $data
		);
		echo json_encode($output);           
	}

	public function detail($id)
	{
		$data['id']=$id;
		$this->load->view('Detail_notaire_acheteur_view',$data);
	}

	public function listing_detail($id)
	{
		$var_search= !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
		$var_search=str_replace("'","\'",$var_search);

		$query_principal="
			SELECT 
			`ID_PV_ACHETEUR_VENDEUR`,
			`NOM`,
			`PRENOM`,
			`NOM_SOCIETE`,
			pms_sexe.DESCRIPTION_SEXE,
			`TEL`,
			`CNI`,
			`DATE_DELIVRANCE`,
			`DELIVRE_A_VENDEUR`,
			`NOM_PERE`,
			`PRENOM_PERE`,
			`NOM_MERE`,
			`PRENOM_MERE`,
			syst_provinces.PROVINCE_NAME,
			communes.COMMUNE_NAME,
			pms_zones.ZONE_NAME,
			collines.COLLINE_NAME,IF(IS_WHO = 1, 'Vendeur', 'Acheteur') AS status 
			FROM 
			`pms_pv_vente_acheteur_vendeur` 
			LEFT JOIN pms_sexe on pms_sexe.SEXE_ID=pms_pv_vente_acheteur_vendeur.SEXE_ID 
			LEFT JOIN syst_provinces on syst_provinces.PROVINCE_ID=pms_pv_vente_acheteur_vendeur.PROVINCE_ID 
			LEFT JOIN communes on communes.COMMUNE_ID=pms_pv_vente_acheteur_vendeur.COMMUNE_ID 
			LEFT JOIN pms_zones on pms_zones.ZONE_ID=pms_pv_vente_acheteur_vendeur.ZONE_ID 
			LEFT JOIN collines on collines.COLLINE_ID=pms_pv_vente_acheteur_vendeur.COLLINE_ID 
			WHERE md5(pms_pv_vente_acheteur_vendeur.ID_PV_VENTE)='".$id."' ";

		$limit='LIMIT 0,10';
		if(isset($_POST['length']) AND $_POST['length'] != -1)
		{
			$limit='LIMIT '.$_POST["start"].','.$_POST["length"];
		}
		{
			$limit='LIMIT '.$_POST["start"].','.$_POST["length"];
		}

		$order_by='';

		$order_column=array('','','','','','','','','');

		$order_by =' ORDER BY ID_PV_ACHETEUR_VENDEUR DESC';


		$search = !empty($_POST['search']['value']) ? (" AND (NOM LIKE '%$var_search%' ) ") : '';

		$critaire = '';

		$query_secondaire=$query_principal.' '.$critaire.' '.$search.' '.$order_by.' '.$limit;

		$query_filter = $query_principal.' '.$critaire.' '.$search;

		$fetch_notaire_acheteur = $this->Model->datatable($query_secondaire);
		$data = array();
		$u=0;


		foreach ($fetch_notaire_acheteur as $row)
		{
			$nom_prenom_societe='';
			if(!empty($row->NOM) || !empty($row->PRENOM))
			{
			  $nom_prenom_societe=$row->NOM.' '.$row->PRENOM;
			}
			else
			{
			  $nom_prenom_societe=$row->NOM_SOCIETE;
			}

			$u++;
			$sub_array=array();
			$sub_array[]=$u;
			$sub_array[]=$nom_prenom_societe;
			$sub_array[]=!empty($row->DESCRIPTION_SEXE) ? $row->DESCRIPTION_SEXE : 'N/A';
			$sub_array[]=!empty($row->CNI) ? $row->CNI : 'N/A';
			$sub_array[]=!empty($row->TEL) ? $row->TEL : 'N/A';
			$sub_array[]= $row->status;

  
        	$data[] = $sub_array;
		}
		$output = array(
			"draw" => intval($_POST['draw']),
			"recordsTotal" =>$this->Model->all_data($query_principal),
			"recordsFiltered" => $this->Model->filtrer($query_filter),
			"data" => $data
		);
		echo json_encode($output);           
	}

}