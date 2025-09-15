<?php
	/**
	@author Nadvaxe2024
	advaxe@mediabox.bi /61128298
	Commencé le 26 février 2024
	 * Gestion des Authentification depuis pms_api library
	 */
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Login extends CI_Controller 
	{
		public function __construct()
		{
			parent::__construct();
		}

		public function index($params = NULL,$login='',$pass='') 
		{
			$datas['message'] = $params;
			$datas['login'] = $login;
			$datas['pass'] = $pass;
			$datas['provinces']=array();
			$datas['PROVINCE_ID']='';
			$datas['types_users']=$this->Model->getList('sf_guard_user_categories');			
			$this->load->view('Login_view', $datas);
		}
  
		public function relais()
		{
			$username = $this->input->post('inputUsername');
			$type = $this->input->post('type_user');

			if (!empty($type)) {
				if ($type == 1) {
					$this->do_login($username);
				} else if ($type == 2 || $type == 4)  {
					$this->do_log_not();	
				}
				else if ($type == 4)  {
					$this->do_log_justice();	
				}
				else{
					$this->do_log_Backend();	
				}
			} else {
				$sms = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
				<center><strong>Mot de passe incorrect</strong></center>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div>';
				$this->session->set_flashdata($sms);
				$this->index($sms, $username = '', $password = '');
			}
		}

		public function do_login($username)
		{   
			$this->load->library('pms_api'); // Charger  pms_api
			$result = $this->pms_api->login($username); 

			$username=$this->input->post('inputUsername');
			$password=$this->input->post('inputPassword');
			$type_user=$this->input->post('type_user');

			if (!empty($result)) 
			{

			if ($result->message=='Identifiants incorrects') 
			{

				$sms='<div class="alert alert-warning alert-dismissible fade show" role="alert">
				<center><strong>L\'utilisateur n\'est pas connu dans le système</strong></center>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div>' ;
				
				$this->session->set_flashdata($sms) ;
				$this->index($sms,$username,$password);
			}
			
            else if ($result->message!='incorrect credentials') 
            {
            	$numeroParcelle = $result->data->NUMERO_PARCELLE;
				if (password_verify($password,$result->data->password))
				{
			  	// Stocker les données dans la session
					$this->session->set_userdata('PMS_USER_ID', $result->data->id);
					$this->session->set_userdata('PMS_NOM', $result->data->fullname);
					$this->session->set_userdata('PMS_PROFIL_ID', $result->data->registeras);
					$this->session->set_userdata('PMS_TELEPHONE', $result->data->mobile);
					$this->session->set_userdata('PMS_EMAIL', $result->data->email);
					$this->session->set_userdata('PMS_USERNAME', $result->data->username);
					$this->session->set_userdata('PMS_PASSWORD', $result->data->password);
					$this->session->set_userdata('MOTHER', $result->data->mother_fullname);
					$this->session->set_userdata('FATHER', $result->data->father_fullname);
					$this->session->set_userdata('CNI', $result->data->cni);
					$this->session->set_userdata('LIEU_DELIV', $result->data->LIEU_DELIVRANCE);
					$this->session->set_userdata('DATE_DELIV', $result->data->DATE_DELIVRANCE);
					$this->session->set_userdata('photo_profile', $result->data->avatar);
			
					$this->session->set_userdata('photo_signature', $result->data->SIGNATURE);
					$this->session->set_userdata('photo_cni', $result->data->path_cni);
					$this->session->set_userdata('TYPE_USER', $type_user);
					if ($this->session->userdata('PMS_PROFIL_ID') ==1 || $this->session->userdata('PMS_PROFIL_ID') ==2 || $this->session->userdata('PMS_PROFIL_ID') ==3)
					{
					redirect(base_url('personal_request/Demande_User'));
					}elseif($this->session->userdata('PMS_PROFIL_ID') ==4)
					{
						redirect(base_url('personal_request/Demande_Information'));
					}else
					{
						echo $query;
					} 
					
				} else 
				{
					$sms='<div class="alert alert-warning alert-dismissible fade show" role="alert">
					<center><strong>Mot de passe incorrect</strong></center>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
					</div>' ;
					$this->session->set_flashdata($sms) ;
					$this->index($sms,$username,$password);
				}	
			}
			else 
			{
				$sms='<div class="alert alert-warning alert-dismissible fade show" role="alert">
				<center><strong>L\'utilisateur n\'est pas connu dans le système</strong></center>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div>' ;
				
				$this->session->set_flashdata($sms) ;
				$this->index($sms,$username,$password);
			}
			}	
			 else
			{
				$sms='<div class="alert alert-warning alert-dismissible fade show" role="alert">
					<center><strong>Vérifiez votre connexion</strong></center>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
					</div>' ;
					redirect(base_url('Login'));
			}

		
		}

		public function do_logout()
		{
			session_destroy();
			redirect(base_url());
		}

		public function Backend($params = NULL,$login='',$pass='')
		{
			$datas['message'] = $params;
			$datas['login'] = $login;
			$datas['pass'] = $pass;
			//$datas['provinces']=$this->Model->getRequete('SELECT * FROM `pms_provinces`');
			$datas['provinces']=array();
			$datas['PROVINCE_ID']='';

			$this->load->view('Login_backend_view', $datas);		
		}
 


		public function do_log_Backend()
		{
			$username=$this->input->post('inputUsername');
			$password=$this->input->post('inputPassword');
			$type_user=$this->input->post('type_user');
			$sms = '';
			$get_user = $this->Model->getRequeteOne("SELECT PROFIL_ID,NOM,PRENOM,EMAIL,TELEPHONE,NOM_UTILISATEUR,MOT_DE_PASSE,USER_BACKEND_ID,SERVICE_ID,PATH_CACHE,PATH_SIGN,PATH_PHOTO FROM pms_user_backend WHERE (EMAIL = '".$username."' OR NOM_UTILISATEUR = '".$username."') AND IS_ACTIF = 1");
				if (!empty($get_user))
				{
					if ($get_user['MOT_DE_PASSE']==md5($password))
					{
						$service=$this->Model->getOne('pms_service',array('SERVICE_ID'=>$get_user['SERVICE_ID']));
						$poste=$this->Model->getRequeteOne('SELECT pms_poste_service.`ID_POSTE`,pms_poste_service.`ID_SERVICE` FROM `pms_poste_service` join pms_user_poste on pms_poste_service.`ID_POSTE`=pms_user_poste.ID_POSTE WHERE 1 and pms_user_poste.ID_USER='.$get_user['USER_BACKEND_ID'].'');
						$mes_poste=array();
						$session=array(
							'PMS_USER_ID'=>$get_user['USER_BACKEND_ID'],
							'PMS_NOM'=>$get_user['NOM'],
							'PMS_PRENOM'=>$get_user['PRENOM'],
							'PMS_PROFIL_ID'=>$get_user['PROFIL_ID'],
						'PMS_POSTE_ID'=>$poste['ID_POSTE'],//POUR LA MATRICE BACKEND
						'PMS_TELEPHONE'=>$get_user['TELEPHONE'],
						'PMS_EMAIL'=>$get_user['EMAIL'],
						'PMS_USERNAME'=>$get_user['NOM_UTILISATEUR'],
						'PMS_SERVICE_ID'=>$get_user['SERVICE_ID'],
						'PMS_CODE_SERVICE'=>$service['CODE_SERVICE'],
						'PMS_PATH_CACHE'=>$get_user['PATH_CACHE'],
						'PMS_PATH_SIGN'=>$get_user['PATH_SIGN'],
						'PMS_PATH_PHOTO'=>$get_user['PATH_PHOTO'],
						'PMS_POSTE'=>$mes_poste,
						'TYPE_USER'=>$type_user
					);

						$this->session->set_userdata($session);
						if ($this->session->userdata('PMS_PROFIL_ID') =='1')
						{
							redirect(base_url('applications/Applications/applications'));
						}
						else
						{
							redirect(base_url('applications/Applications/applications'));
						}
					} 
					else
					{
						$sms='<div class="alert alert-warning alert-dismissible fade show" role="alert">
						<center><strong>Mot de passe incorrect</strong></center>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
						</div>' ;
						$this->session->set_flashdata($sms) ;
						$this->session->sess_destroy();
						$this->index($sms,$username,$password);
					}
				} 
				else
				{
					$sms='<div class="alert alert-warning alert-dismissible fade show" role="alert">
					<center><strong>L\'utilisateur n\'est pas connu dans le système</strong></center>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
					</div>' ;

					$this->session->set_flashdata($sms) ;
					$this->session->sess_destroy();
					$this->index($sms,$username,$password);
				}
		}

		public function do_log_justice()
		{

			$username=$this->input->post('inputUsername');
			$password=$this->input->post('inputPassword');
			$type_user=$this->input->post('type_user');
           
			$pass_hash = password_hash($password, PASSWORD_DEFAULT);
			$sms = '';

			$query = "SELECT sf_guard_user_profile.id,sf_guard_user_profile.profile_pic,sf_guard_user_profile.email,sf_guard_user_profile.fullname,sf_guard_user_profile.mobile,sf_guard_user_profile.username,sf_guard_user_profile.password,sf_guard_user_profile.is_active,sf_guard_user_categories.name,sf_guard_user_categories.description,sf_guard_user_profile.registeras FROM sf_guard_user_profile  JOIN sf_guard_user_categories ON sf_guard_user_categories.id=sf_guard_user_profile.registeras  WHERE (sf_guard_user_profile.email = '".$username."' OR sf_guard_user_profile.username = '".$username."') AND sf_guard_user_profile.is_active = 1";
			$get_user = $this->Model->getRequeteOne($query); 
			   // print_r($get_user);die();          
			if (!empty($get_user)) {
				if (password_verify($password, $get_user['password'])){
					$session=array(
						'PMS_USER_ID'=>$get_user['id'],
						'PMS_NOM'=>$get_user['fullname'],
						'PMS_PROFIL_ID'=>$get_user['registeras'],
						'PMS_TELEPHONE'=>$get_user['mobile'],
						'PMS_EMAIL'=>$get_user['email'],
						'PMS_USERNAME'=>$get_user['username'],
						'PMS_USERNAME'=>$get_user['username'],
						'profile_pic'=>$get_user['profile_pic'],
						'TYPE_USER'=>$type_user
					);
						// redirect(base_url('personal_request/Demande_Information'));
							$this->session->set_userdata($session);
					if($this->session->userdata('PMS_PROFIL_ID') ==3){

						redirect(base_url('personal_request/Demande_Information'));
					}else{
						echo $query;
					}
				} else {
					$sms='<div class="alert alert-warning alert-dismissible fade show" role="alert">
					<center><strong>Mot de passe incorrect</strong></center>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
					</div>' ;
					$this->session->set_flashdata($sms) ;
					$this->index($sms,$username,$password);
				}

			} else {
				$sms='<div class="alert alert-warning alert-dismissible fade show" role="alert">
				<center><strong>L\'utilisateur n\'est pas connu dans le système</strong></center>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div>' ;

				$this->session->set_flashdata($sms) ;
				$this->index($sms,$username,$password);
			}
		   }

		public function do_log_not()
		{

			$username=$this->input->post('inputUsername');
			$password=$this->input->post('inputPassword');
			$type_user=$this->input->post('type_user');

			$pass_hash = password_hash($password, PASSWORD_DEFAULT);

			$sms = '';
           if ($type_user==4) {
           $query = "SELECT sf_guard_user_profile.id,sf_guard_user_profile.email,sf_guard_user_profile.fullname,sf_guard_user_profile.mobile,sf_guard_user_profile.username,sf_guard_user_profile.password,sf_guard_user_profile.is_active,sf_guard_user_profile.registeras FROM sf_guard_user_profile  WHERE (sf_guard_user_profile.email = '".$username."' OR sf_guard_user_profile.username = '".$username."') AND sf_guard_user_profile.is_active = 1";
           }else
           {


           $query = "SELECT sf_guard_user_profile.id,sf_guard_user_profile.email,sf_guard_user_profile.fullname,sf_guard_user_profile.mobile,sf_guard_user_profile.username,sf_guard_user_profile.password,sf_guard_user_profile.is_active,sf_guard_user_categories.name,sf_guard_user_categories.description,sf_guard_user_profile.registeras FROM sf_guard_user_profile  JOIN sf_guard_user_categories ON sf_guard_user_categories.id=sf_guard_user_profile.registeras WHERE (sf_guard_user_profile.email = '".$username."' OR sf_guard_user_profile.username = '".$username."') AND sf_guard_user_profile.is_active = 1";

                 }
			

			$get_user = $this->Model->getRequeteOne($query);



			if (!empty($get_user)) {

				if (password_verify($password, $get_user['password'])){
					$session=array(
						'PMS_USER_ID'=>$get_user['id'],
						'PMS_NOM'=>$get_user['fullname'],
						'PMS_PROFIL_ID'=>$get_user['registeras'],
						'PMS_TELEPHONE'=>$get_user['mobile'],
						'PMS_EMAIL'=>$get_user['email'],
						'PMS_USERNAME'=>$get_user['username'],
						'TYPE_USER'=>$type_user
					);

					$this->session->set_userdata($session);
					if($this->session->userdata('PMS_PROFIL_ID') == 4 && $this->session->userdata('TYPE_USER') != 4)
					{

						redirect(base_url('personal_request/Demande_Information'));
					}else if($this->session->userdata('TYPE_USER') == 4)
					{

						redirect(base_url('personal_request/Demande_User'));
					}
					else {
						echo $query;
					}


				} else {
					$sms='<div class="alert alert-warning alert-dismissible fade show" role="alert">
					<center><strong>Mot de passe incorrect</strong></center>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
					</div>' ;
					$this->session->set_flashdata($sms) ;
					$this->index($sms,$username,$password);
				}

			} else {
				$sms='<div class="alert alert-warning alert-dismissible fade show" role="alert">
				<center><strong>L\'utilisateur n\'est pas connu dans le système</strong></center>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div>' ;

				$this->session->set_flashdata($sms) ;
				$this->index($sms,$username,$password);
			}



		   }
	    }
 
		?>