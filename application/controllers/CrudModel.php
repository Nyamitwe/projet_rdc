<?php

/**
 * 
 */
class CrudModel extends CI_Controller
{
	
	function index()
	{
		$data['title']="Crud";

		$this->load->view('CrudModel_view',$data);
	}
}
?>