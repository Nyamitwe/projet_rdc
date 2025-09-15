<?php

/**
 *@author eriel@mediabox.bi
 *eriel@mediabox.bi
 *Commencé le 09 juillet 2024
 * Gestion de la modification des pwds
 */
defined('BASEPATH') or exit('No direct script access allowed');
class Modification_pwd extends CI_Controller
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
		$datas['statut'] = 1;
		$datas['url'] = "Modification_pwd/update";
		$datas['error_msg'] = '';

		$datas['types_users'] = $this->Model->getList('sf_guard_user_categories');
		$this->load->view('Modification_pwd_view', $datas);
	}

	public function _check_email_exists($email)
	{
		$user_exists = $this->Model->getOne('sf_guard_user_profile',array('email'=>$email));

		if (empty($user_exists))
		{
			$this->form_validation->set_message('_check_email_exists', '<font style="color:red;size:2px;">L\'adresse mail n\'existe pas.</font>');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}


    //fonction qui genere le mot de passe
	public function password_generer()
	{
		$characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_=+';
		$length = 10;
		$password = '';

		$charCount = strlen($characters);
		for ($i = 0; $i < $length; $i++) {
			$password .= $characters[rand(0, $charCount - 1)];
		}
		return $password;
	}


	function update()
	{

		$mail=$this->input->post('inputUsername');
		$type_user_id=$this->input->post('type_user');

		if($type_user_id!=1 || $type_user_id!=4)
		{
			$this->form_validation->set_rules('inputUsername', 'inputUsername', 'trim|required|callback__check_email_exists',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
		}
		else
		{
			$this->form_validation->set_rules('inputUsername', 'inputUsername', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
		}

		$this->form_validation->set_rules('type_user','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));


		if($this->form_validation->run()==FALSE)
		{
			$datas['statut'] = 2;
			$datas['url'] = "Modification_pwd/update";
			$datas['error_msg'] = '';
			$datas['types_users'] = $this->Model->getList('sf_guard_user_categories');			

			$this->load->view('Modification_pwd_view', $datas);
		}
		else
		{
			$sms='Errreur';

			if($type_user_id==1  || $type_user_id==4)
			{

			}
			else 
			{
				//generation pwd
				$mot_de_passe=$this->password_generer();
				$hashedPassword=password_hash($mot_de_passe,PASSWORD_DEFAULT);

				// $this->Model->update('sf_guard_user_profile',array('email'=>$this->input->post('inputUsername')),array('password'=>12345));
				$this->Model->update('sf_guard_user_profile',array('email'=>$this->input->post('inputUsername')),array('password'=>$hashedPassword));

				$message = "Bonjour Mr/Mme " . $this->input->post('inputUsername') . ",<br>  Votre nouveau mot de passe est : <b> " . $mot_de_passe . "</b> .<br> Cliquez <a href='".base_url()."' target='_blank' >Ici </a> pour vous connectez.<br> Merci cordiallement.</b>";
				$mailTo=$this->input->post('inputUsername');
				$subject='Identifiants sur la plateforme PMS';


				$this->notifications->send_mail($mailTo, $subject, $cc_emails = array(), $message, $attach = array());

				$sms = '<div class="alert alert-success alert-dismissible fade show" role="alert">
				<center><strong>Changement de mot de passe faite avec succès</strong></center>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div>';

				$this->session->set_flashdata('message',$sms);				
			}

			$this->session->set_flashdata('message',$sms);				

			redirect(base_url('Login'));
	    }
	}
}









