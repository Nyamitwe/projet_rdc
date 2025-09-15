<?php 
	
	/**
	 * 
	 */
	class Search extends CI_Controller
	{
		
		function __construct()
		{
			# code...
			parent::__construct();
		}


		function index(){

			$this->load->view('Search_view');
		}


		function index2(){

			$this->load->view('Search_2');
		}
	}
 ?>