	<?php
ini_set('memory_limit', '8192M');
/**
 * 
 NDAYIZEYE Eric
 eric@mediabox.bi
 TEL: 6924525O
 */
class Mandataire extends Ci_Controller
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
		if(empty($this->get_utilisateur()))
		{
			redirect(base_url('Login'));
		}
	}

    //RECUPERATION DU LOGIN DE LA PERSONNE CONNECTEE
	public function get_utilisateur()
	{
		return $this->session->userdata('PMS_USER_ID');
	}
	public function index($id="")
		{
			// print_r($id);
			$data['message'] = $this->session->flashdata('message');
			$this->load->view('Mandataire_Liste_view',$data);      
		}

 	// recupere les informations dans la base
		public function listing()
		{
			$var_search= !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
			$var_search=str_replace("'","\'",$var_search);
			$query_principal="SELECT
			sf_guard_user_profile.id,
			sf_guard_user_profile.fullname,
			sf_guard_user_profile.email,
			sf_guard_user_profile.mobile,
			sf_guard_user_profile.statut_api,
			sf_guard_user_profile.registeras,
			sf_guard_user_profile.nom_entreprise
			FROM
			`sf_guard_user_profile`
			WHERE
			
			sf_guard_user_profile.registeras=9";



			$limit = '';
			if (isset($_POST['length']) && $_POST['length'] != -1)
			{
				$limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
			}


			$order_by='';
			$order_column=array(1,'sf_guard_user_profile.fullname',
				'sf_guard_user_profile.email',
				1,
				1);

			if ($order_by)
			{
				$order_by = isset($_POST['order']) ? ' ORDER BY '.$order_column[$_POST['order']['0']['column']] .'  '.$_POST['order']['0']['dir'] : ' ORDER BY sf_guard_user_profile.id ASC';
			}

			$search = !empty($_POST['search']['value']) ? (" AND (sf_guard_user_profile.fullname LIKE '%$var_search%' OR sf_guard_user_profile.email LIKE '%$var_search%' OR `EMAIL` LIKE '%$var_search%') ") : '';

			$critaire = '';

			$query_secondaire=$query_principal.' '.$critaire.' '.$search.' '.$order_by.' '.$limit;
			$query_filter = $query_principal.' '.$critaire.' '.$search;

			$fetch_users = $this->Model->datatable($query_secondaire);
			$data = array();
			$u=0;


			foreach ($fetch_users as $row)
			{
				$nbr=$this->Model->getRequeteOne("SELECT COUNT(`NUMERO_PARCELLE`) nbr FROM `relation_mandataire_proprietaire` WHERE `ID_MANDATAIRE`=".$row->id);

				$nbr1=$this->Model->getRequeteOne("SELECT NUMERO_PARCELLE,STATUT_MANDATAIRE	 FROM `relation_mandataire_proprietaire` WHERE `ID_MANDATAIRE`=".$row->id);
				// print_r($nbr['NUMERO_PARCELLE']);die();
				$nom_proprio=$row->fullname;
				
				$u++; 
				$sub_array=array(); 
				$sub_array[]='<center><font color="#000000" size=2><label>'.$u.'</label></font> </center>';
				$sub_array[]='<center><font color="#000000" size=2><label>'.$nom_proprio.'</label></font> </center>';
				$sub_array[]='<center><font color="#000000" size=2><label>'.$row->email.'</label></font> </center>';

				// $num = ($nbr1["NUMERO_PARCELLE"]) ? $nbr1["NUMERO_PARCELLE"] : "";
		  	$sub_array[] = "<center>
                    <a href='#' 
                        onclick='show_list(" . intval($row->id) . ")' 
                        class='btn btn-success text-dark small' 
                        title='Voir les détails'>
                        " . $nbr["nbr"] . "
                    </a>
                </center>";

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

				public function listing1($id="")
		{
      // print_r($id);
			$var_search= !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
			$var_search=str_replace("'","\'",$var_search);
			$query_principal="SELECT
			syst_provinces.PROVINCE_NAME,
			communes.COMMUNE_NAME,
			pms_zones.ZONE_NAME,
			collines.COLLINE_NAME,
			usager_propriete.DESCRIPTION_USAGER_PROPRIETE,
			parcelle_attribution.NUMERO_PARCELLE,
			parcelle_attribution.ID_ATTRIBUTION,
			parcelle_attribution.ID_REQUERANT,
			parcelle_attribution.statut_bps,
			relation_mandataire_proprietaire.STATUT_MANDATAIRE
			FROM
			parcelle_attribution
			LEFT JOIN syst_provinces ON syst_provinces.PROVINCE_ID = parcelle_attribution.PROVINCE_ID
			LEFT JOIN communes ON communes.COMMUNE_ID = parcelle_attribution.COMMUNE_ID
			LEFT JOIN pms_zones ON pms_zones.ZONE_ID = parcelle_attribution.ZONE_ID
			LEFT JOIN collines ON collines.COLLINE_ID = parcelle_attribution.COLLINE_ID
			LEFT JOIN usager_propriete ON usager_propriete.ID_USAGER_PROPRIETE = parcelle_attribution.USAGE_ID
			left JOIN relation_mandataire_proprietaire on relation_mandataire_proprietaire.NUMERO_PARCELLE = parcelle_attribution.NUMERO_PARCELLE
			
			WHERE
			parcelle_attribution.STATUT_ID=3  and
			relation_mandataire_proprietaire.ID_MANDATAIRE =".$id;
 
			$limit='LIMIT 0,10';
			if(isset($_POST['length']) AND $_POST['length'] != -1)
			{
				$limit='LIMIT '.$_POST["start"].','.$_POST["length"];
			}
			{
				$limit='LIMIT '.$_POST["start"].','.$_POST["length"];
			}
			$order_by='';
			$order_column=array(1,1,1);

			if ($order_by)
			{
				$order_by = isset($_POST['order']) ? ' ORDER BY '.$order_column[$_POST['order']['0']['column']] .'  '.$_POST['order']['0']['dir'] : ' ORDER BY parcelle_attribution.ID_ATTRIBUTION ASC';
			}

			$search = !empty($_POST['search']['value']) ? (" AND (parcelle_attribution.NUMERO_PARCELLE LIKE '%$var_search%') ") : '';

			$critaire = '';

			$query_secondaire=$query_principal.' '.$critaire.' '.$search.' '.$order_by.' '.$limit;
			$query_filter = $query_principal.' '.$critaire.' '.$search;

			$fetch_users = $this->Model->datatable($query_secondaire);
			$data = array();
			$u=0;

			foreach ($fetch_users as $row)
			{   
				$get_req=$this->Model->getRequeteOne('SELECT email,statut_api from sf_guard_user_profile where id='.$row->ID_REQUERANT.'');

				$stat=1;
				$u++; 
				$sub_array=array(); 
				$sub_array[]='<center><font color="#000000" size=2><label>'.$u.'</label></font> </center>'; 
				$sub_array[]='<center><font color="#000000" size=2><label>'.$row->NUMERO_PARCELLE.'</label></font> </center>';
				$sub_array[]='<center><font color="#000000" size=2><label>'.$row->DESCRIPTION_USAGER_PROPRIETE.'</label></font> </center>';
				$sub_array[]='<center><font color="#000000" size=2><label>'.$row->PROVINCE_NAME.'-'.$row->COMMUNE_NAME.'-'.$row->ZONE_NAME.'-'.$row->COLLINE_NAME.'</label></font> </center>';

				$num = $row->NUMERO_PARCELLE;
				$statut =($row->STATUT_MANDATAIRE==1) ? '<i class="fa fa-check-square-o" style="color:blue;font-size:26px" title="Actif"></i>' : '<i class="fa fa-window-close text-danger" aria-hidden="true" style="font-size:26px" title="Inanctif"></i>';
        $sub_array[] = $statut;

                			$sub_array[] = "<center>
                    <a href='#' 
                        onclick='show_activer(" . intval($id) . ", \"" . md5($num) . "\")' 
                         
                        title='Activer/Désactiver'><i class='fa fa-gear' style='font-size:36px;color:green'></i>
                    </a>
                </center>";

				$data[] = $sub_array;

				// $data[] = $sub_array;
			}
			$output = array(
				"draw" => intval($_POST['draw']),
				"recordsTotal" =>$this->Model->all_data($query_principal),
				"recordsFiltered" => $this->Model->filtrer($query_filter),
				"data" => $data
			);
			echo json_encode($output);
		}

		public function update_statut($value='')
		{
			$data = true;
			$statut = $this->input->post("STATUT"); 
			// print_r($statut);die();
			$statut = ($statut ==1) ? $statut : 0;
			$id = $this->input->post("id2");
			$numero = $this->input->post("num_parcel2");
			$get_num =$this->Model->getRequeteOne("SELECT NUMERO_PARCELLE FROM relation_mandataire_proprietaire WHERE md5(NUMERO_PARCELLE)='".$numero. "' ");
			$data1 = array('STATUT_MANDATAIRE' =>$statut , );
			$data2 = array('ID_MANDATAIRE	' =>$id ,'NUMERO_PARCELLE' =>$get_num['NUMERO_PARCELLE'] , );

			

			$this->Model->update('relation_mandataire_proprietaire',$data2,$data1);
			$this->index();

		}



	 public function test($email="")
		{
/*
// verifier un mot de passe hash
			$hash = '$2y$10$54lOyHY1yJmO0m6t/GySoO6Tlu6Lkga8kmjaALLi31BQGtkpszrFq';
$password = '12345';

if (password_verify($password, $hash)) {
    echo "Le mot de passe est correct.";
} else {
    echo "Le mot de passe est incorrect.";
} die();
*/
			$email =str_replace("__", "@",$email);
			// print_r($email);die();
			$mot_de_passe=12345;
      $hashedPassword=password_hash($mot_de_passe,PASSWORD_DEFAULT);

			$this->Model->update("sf_guard_user_profile",array('email' =>$email , ),array('password' =>$hashedPassword ));
		}

		public function test2($num='')
		{

		$parcelle =str_replace("__", "-",$num);
		$this->load->library('pms_api'); // Charger la bibliothèque pms_api
		$infos_parcelle = $this->pms_api->parcelle($parcelle);
		$info_requerant = $this->pms_api->info_requerant($infos_parcelle->data->id);
		echo "<pre>";
		print_r($infos_parcelle);
		echo "____________________________________________";
		print_r($info_requerant);
		die();
		}
	}
