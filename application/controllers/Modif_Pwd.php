<?php

/**
 *@author Ir Raoul
 *raoul@mediabox.bi /71246149
 *Commencé le 02 juillet 2024
 * Gestion de la modification des pwds
 */
defined('BASEPATH') or exit('No direct script access allowed');
class Modif_Pwd extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index($params = NULL, $login = '', $pass = '')
	{
		// $datas['message'] = $params;
		$datas['login'] = $login;
		$datas['pass'] = $pass;
		$datas['provinces'] = array();
		$datas['PROVINCE_ID'] = '';
		$datas['statut'] = 1;
		$datas['url'] = "Modif_Pwd/verify";
		$datas['error_msg'] = '';

		$datas['types_users'] = $this->Model->getList('sf_guard_user_categories');
		$this->load->view('Modif_Pwd_View', $datas);
	}

	public function verify()
	{
		$mail=$this->input->post('inputUsername');
		$type_user_id=$this->input->post('type_user');

		$user_infos=$this->Model->getOne('sf_guard_user_profile',array('email'=>$mail));

		$datas['provinces'] = array();
		$datas['PROVINCE_ID'] = '';
		$datas['statut'] = 2;
		$datas['url'] = "Modif_Pwd/save";
		$datas['error_msg'] = '';
		if($type_user_id==1  || $type_user_id==4)
		{

			$this->load->library('pms_api');

			$result=$this->pms_api->forgotPassword($mail);

			// print_r($result);die();
			

			if ($result) {

				$datas['statut'] = 1;
				$datas['url'] = "Modif_Pwd/verify";

				$sms = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
				<center><strong>Votre email n\'est pas connu dans le système</strong></center>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div>';

				$this->session->set_flashdata('message',$sms);

			}else{ 

				$sms = '';

				$this->session->set_flashdata('message',$sms);
			}






		}
		else 
		{

			if (empty($user_infos)) {
				$datas['statut'] = 1;
				$datas['url'] = "Modif_Pwd/verify";

				$sms = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
				<center><strong>Votre email n\'est pas connu dans le système</strong></center>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div>';

				$this->session->set_flashdata('message',$sms);

			}else{ 

				$sms = '';

				$this->session->set_flashdata('message',$sms);
			}
		}


		$datas['types_users'] = $this->Model->getList('sf_guard_user_categories');
		$this->load->view('Modif_Pwd_View', $datas);


	}


	function save()
	{


		$mail=$this->input->post('inputUsername');
		$pwd=$this->input->post('inputPassword');
		$pwd2=$this->input->post('inputPassword2');

		$this->form_validation->set_rules('inputUsername','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
		$this->form_validation->set_rules('inputPassword','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
		$this->form_validation->set_rules('inputPassword2','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));

		if($this->form_validation->run()==FALSE)
		{

			$datas['statut'] = 2;
			$datas['url'] = "Modif_Pwd/save";
			$datas['error_msg'] = '';

			$this->load->view('Modif_Pwd_View', $datas);

		}else if($pwd != $pwd2)
		{

			$datas['statut'] = 2;
			$datas['url'] = "Modif_Pwd/save";
			$datas['error_msg'] = 'Les deux mots de passe ne sont pas identique.';

			$this->load->view('Modif_Pwd_View', $datas);

		}else
		{

			$pwd=password_hash($pwd, PASSWORD_DEFAULT);


			$this->Model->update('sf_guard_user_profile',array('email'=>$email),array('password'=>$pwd));
			$user=$this->Model->getOne('sf_guard_user_profile',array('email'=>$email));

			$message = "Bonjour Mr/Mme" . $user['fullname'] . ",<br>  Votre nouveau mot de passe est : <b> " . $pwd . "</b> .<br> Cliquez <a href='".base_url()."' target='_blank' >Ici </a> pour vous connectez.<br> Merci cordiallement.</b>";
			$mailTo=$email;
			$subject='Identifiants sur la plateforme PMS';

			
			$this->notifications->send_mail($mailTo, $subject, $cc_emails = array(), $message, $attach = array());

			$sms = '<div class="alert alert-success alert-dismissible fade show" role="alert">
			<center><strong>Changement de mot de passe faite avec succès</strong></center>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
			</div>';

			$this->session->set_flashdata('message',$sms);


			redirect(base_url('Login'));





		}

	}


	public function valide_compte($email='',$type='')
	{

		$datas['email'] = $email;
		$datas['type'] = $type;
		$datas['provinces'] = array();
		$datas['PROVINCE_ID'] = '';
		$datas['statut'] = 2;
		$datas['url'] = "Modif_Pwd/save"; 
		$datas['error_msg'] = '';

		$datas['types_users'] = $this->Model->getList('sf_guard_user_categories');
		$this->load->view('Modif_Pwd_View', $datas);
		
	}



}
