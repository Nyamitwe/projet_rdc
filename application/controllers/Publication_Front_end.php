<?php 

	/**
	 Jean Prosper
	 prosper@mediabox.bi
	 79659162
	 du vendredi le 11 au lund le 14 novembre 2022
	 */
	 class Publication_Front_end extends CI_Controller
	 {

	 	function __construct()
	 	{
			# code...
	 		parent::__construct();
	 	}

	 	function index()
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

	 			
	 			    
               // if ($this->load->library('pagination')) {
               // 	print_r('ok');die();
               // }else{
               // 	print_r('Desole');die();
               // }
                //bootstrap pagination 
	 			$config['full_tag_open'] = '<ul class="pagination">';

	 			//print_r($config);die();
	 			
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


               // print_r($config);die();

	 			$this->pagination->initialize($config);


	 			$params['links'] = $this->pagination->create_links();





	 		}


	 		// $params['article_plus_lus']=$this->Model->getRequete("SELECT COUNT(pms_publication_article_lecture.`PUBLICATION_ID`) as nbre_fois,pms_publication.PUBLICATION_ID,SUBSTR(DESCRIPTION_PUBLICATION,1,300) as publication,OBJET_PUBLICATION,DATE_PUBLICATION FROM `pms_publication_article_lecture` left JOIN pms_publication ON pms_publication_article_lecture.PUBLICATION_ID=pms_publication.PUBLICATION_ID WHERE 1 GROUP BY pms_publication.PUBLICATION_ID,OBJET_PUBLICATION ORDER BY nbre_fois DESC LIMIT 3");	

	 		$params['article_plus_lus']=$this->Model->getRequete("SELECT pms_publication.PUBLICATION_ID,SUBSTR(DESCRIPTION_PUBLICATION,1,300) as publication,OBJET_PUBLICATION,DATE_PUBLICATION,IMAGE_PUBLICATION FROM pms_publication WHERE 1 GROUP BY pms_publication.PUBLICATION_ID,OBJET_PUBLICATION ORDER BY PUBLICATION_ID DESC LIMIT 3");	


	 		//print_r($params['article_plus_lus']);die();

	 		$this->load->view('includes_ep/publication',$params);
	 	}

	 	public function article($id)
	 	{

	 		$data['article_pub']=$this->Model->getRequeteOne("SELECT PUBLICATION_ID, OBJET_PUBLICATION, DESCRIPTION_PUBLICATION AS PUBLICATION, IMAGE_PUBLICATION, DATE_PUBLICATION FROM `pms_publication` WHERE 1 AND PUBLICATION_ID=".$id);

	 		$data['article_plus_lus']=$this->Model->getRequete("SELECT COUNT(pms_publication_article_lecture.`PUBLICATION_ID`) as nbre_fois,pms_publication.PUBLICATION_ID,SUBSTR(DESCRIPTION_PUBLICATION,1,300) as publication,OBJET_PUBLICATION,DATE_PUBLICATION FROM `pms_publication_article_lecture` JOIN pms_publication ON pms_publication_article_lecture.PUBLICATION_ID=pms_publication.PUBLICATION_ID WHERE 1 GROUP BY pms_publication.PUBLICATION_ID,OBJET_PUBLICATION ORDER BY nbre_fois DESC LIMIT 3");	

	 		$article_lu=array(

	 			'PUBLICATION_ID'=>$id,
	 		);
	 		$this->Model->create('pms_publication_article_lecture',$article_lu);


	 		$this->load->view('includes_ep/article',$data);
	 	}

	 }
	 ?>