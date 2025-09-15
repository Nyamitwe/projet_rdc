<?php

/** 
 *@author Nadvaxe2024
 *advaxe@mediabox.bi /61128298
 *Commencé le 26 février 2024
 * Gestion des Authentification depuis pms_api library
 */
defined('BASEPATH') or exit('No direct script access allowed');
class Login extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index($params = NULL, $login = '', $pass = '')
	{
		$datas['login'] = $login;
		$datas['pass'] = $pass;
		$datas['provinces'] = array();
		$datas['PROVINCE_ID'] = '';

		$datas['types_users'] = $this->Model->getList('sf_guard_user_categories');

		$this->load->view('Login_view', $datas);
	}

	public function relais()
	{

		$username = $this->input->post('inputUsername');
		if (!empty($username)) {
			if ($username) {
				$this->do_login($username);
			} 
			 else {
				$sms = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
					<center><strong>Veuillez revoir le profil selectionner</strong></center>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
					</div>';
				$this->session->set_flashdata('message',$sms);

				$this->index($sms, $username = '', $password = '');
			}
		} else {
			$sms = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
				<center><strong>Mot de passe incorrect</strong></center>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div>';
			$this->session->set_flashdata('message',$sms);

			$this->index($sms, $username = '', $password = '');
		}
	}

	public function do_logout()
	{
		session_destroy();
		redirect(base_url());
	}

	
		public function do_login()
	{

		$username = $this->input->post('inputUsername');
		$password = $this->input->post('inputPassword');

		$pass_hash = password_hash($password, PASSWORD_DEFAULT);

		$sms = '';
		$query = "SELECT `id`, `email`, `username`, `password`, `NOM`, `PRENOM`, `mobile`, `PROFIL_ID`, `country_code`, `sexe_id`, `is_active`, `DATE_INSERTION` FROM sf_guard_user_profile WHERE (sf_guard_user_profile.email = '" . $username . "' OR sf_guard_user_profile.username = '" . $username . "') AND sf_guard_user_profile.is_active = 1";
		$get_user = $this->Model->getRequeteOne($query);


		if (!empty($get_user)) {

			if (password_verify($password, $get_user['password'])) {

 
				$session = array(
					'PMS_USER_ID' => $get_user['id'],
					
					'PMS_PROFIL_ID' => $get_user['registeras'],
					// 'PMS_PROFIL_ID' =>1,
					'PMS_TELEPHONE' => $get_user['mobile'],
					'PMS_EMAIL' => $get_user['email'],
					'PMS_USERNAME' => $get_user['username'],
					
					'PMS_PASSWORD' => $password,
          'PROFIL_ID' => $get_user['PROFIL_ID'],
          'country_code' => $get_user['country_code'],
          'is_active' => $get_user['is_active'],
          'mobile' => $get_user['mobile'],
          'id' => $get_user['id'],
          'NOM' => $get_user['NOM'],
          'PRENOM' => $get_user['PRENOM'],
				);

				$this->session->set_userdata($session);
					redirect(base_url('Utilisateurs'));
				
			} else {
				$sms = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
					<center><strong>Mot de passe incorrect</strong></center>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
					</div>';
				$this->session->set_flashdata('message',$sms);

				$this->index($sms, $username, $password);
			}
		} else { 
			$sms = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
				<center><strong>L\'utilisateur n\'est pas connu dans le système</strong></center>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div>';

			$this->session->set_flashdata('message',$sms);

			$this->index($sms, $username, $password);
		}
	}
}
