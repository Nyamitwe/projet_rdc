<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Description of LanguagesLoader
 *
 * @author Fubini
 */
class LanguagesLoader {
    function initialize() {
	$ci =& get_instance();
	$ci->load->helper('language');
	$siteLang = $ci->session->userdata('site_lang');
	if ($siteLang) {
	$ci->lang->load('messages',$siteLang);
	} else { 
	$ci->lang->load('messages','english');
	}
	}
}
