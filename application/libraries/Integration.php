<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Integration extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }
    public function index()
	{
		$flux = file_get_contents('php://input');
		
		$array_dist = array('data'=>$flux);
		
		$this->Model->insert_last_id('json_data',$array_dist);
	}
}