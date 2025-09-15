<?php 
	
	/**
	 * Dev par HAT Christa
	 * 03-08-2022
	 * Page d'accueil
	 */
	class Home extends CI_Controller
	{
		
		function __construct()
		{
			# code...
			parent::__construct();
		}


		function index(){

			$this->load->view('Home_view');
		}

		public function FAQs()
		{
			$this->load->view('FAQs_View');
		}

		public function Publication()
		{
			//set params
	 		$params = array();
  			
  			//set records per page
	 		$limit_page = 3;
            

	 		$page = ($this->uri->segment(3)) ? ($this->uri->segment(3) - 1) : 0;
	 		$table='pms_publication';
	 		$total = $this->Model->get_total($table);


	 		if ($total > 0) 
	 		{
                // get current page records
	 			$table='pms_publication';
	 			$params['results'] = $this->Model->get_current_page($table,$limit_page, $page * $limit_page);

	 			$config['base_url'] = base_url() .'Publication_Front_end/index/';
	 			$config['total_rows'] = $total;
	 			$config['per_page'] = $limit_page;
	 			$config['uri_segment'] =3;

                //paging configuration
	 			$config['num_links'] = 2;
	 			$config['use_page_numbers'] = TRUE;
	 			$config['reuse_query_string'] = TRUE;
	 			$this->load->library('pagination');    
               
                //bootstrap pagination 
	 			$config['full_tag_open'] = '<ul class="pagination">';
	 			
	 			$config['first_link'] = '&laquo; First';
	 			$config['first_tag_open'] = '<li>';
	 			$config['first_tag_close'] = '</li>';
	 			$config['last_link'] = 'Last &raquo';
	 			$config['last_tag_open'] = '<li>';
	 			$config['last_tag_close'] = '</li>';
	 			$config['next_link'] = 'Next';
	 			$config['next_tag_open'] = '<li class="page-item; page-link"> <a style="margin: 5px; class="page-link"
	 			href="#">';
	 			$config['next_tag_close'] = '</a></li>';
	 			$config['prev_link'] = 'Prev';
	 			$config['prev_tag_open'] = '<li class="page-item; page-link"><a style="margin: 5px; class="page-link" href="#">';
	 			$config['prev_tag_close'] = '</a></li>';
	 			$config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" style="margin: 5px; 
	 			href="#">';
	 			$config['cur_tag_close'] = '</a></li>';
	 			$config['num_tag_open'] = '<li class="page-item; page-link"><a style="margin: 5px; class="page-link" href="#">';
	 			$config['num_tag_close'] = '</li>';
	 			$config['full_tag_close'] = '</ul>'; 

	 			$this->pagination->initialize($config);


	 			$params['links'] = $this->pagination->create_links();
	 		}


	 		$params['article_plus_lus']=$this->Model->getRequete("SELECT COUNT(pms_publication_article_lecture.`PUBLICATION_ID`) as nbre_fois,pms_publication.PUBLICATION_ID,SUBSTR(DESCRIPTION_PUBLICATION,1,300) as publication,OBJET_PUBLICATION,DATE_PUBLICATION FROM `pms_publication_article_lecture` JOIN pms_publication ON pms_publication_article_lecture.PUBLICATION_ID=pms_publication.PUBLICATION_ID WHERE 1 GROUP BY pms_publication.PUBLICATION_ID,OBJET_PUBLICATION ORDER BY nbre_fois DESC LIMIT 3");	

	 		$this->load->view('includes_ep/publication',$params);
		}
		 
		 
		function Call_library(){

			$NOM = 'Martin KING Christa';
			$NUM = '12345';

			$this->generatepdf->Autolisation_morcellement($NOM,$NUM);
		}
	}
 ?>