<?php

/*Alphonse 
24/02/2022*/

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Payement
{
	protected $CI;

	public function __construct()
	{
	    $this->CI = & get_instance();
      $this->CI->load->library('email');
      $this->CI->load->model('Model');
	}


	function ecocsh($data = array()){

    $json = json_encode($data); // Encode data to JSON

    $url = 'http://app.mediabox.bi/api_ussd_php/Api_client_ecocash';

    $options = stream_context_create(['http' => [
        'method'  => 'POST',
        'header'  => 'Content-type: application/json',
        'content' => $json
        ]
     ]);
    $result = file_get_contents($url, false, $options);
     
    return $result;
     

	}


}