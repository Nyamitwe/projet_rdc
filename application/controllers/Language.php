<?php


class Language extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
      
      $this->uri->segment(3);

      $array_session_language = array('site_lang' => $this->uri->segment(3));
      $this->session->set_userdata($array_session_language);
      redirect($_SERVER['HTTP_REFERER']);

    }

  }

?>