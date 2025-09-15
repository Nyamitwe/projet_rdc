<?php 
	
	if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Alfresco
{
	protected $CI;

	public function __construct()
	{
	  $this->CI = & get_instance();
      $this->CI->load->library('email');
      $this->CI->load->model('Model');
	}


	function login(){ 

    	$username = "admin";
    	$password = "brisk";

	    $data = array('username' => $username, 'password' => $password);

	    $url = "http://194.233.171.95:8080/alfresco/s/api/login";

	    $reponse =  json_decode($this->request_login($url, $data));

        $ticket = $reponse->data->ticket;
	    return $ticket;


    }


	function getData_my_fold($docs_id = ""){

      $ticket = $this->login();

      $docs_token = !empty($docs_id) ? $docs_id : "82fab70b-d4b4-4204-8e79-ea93dfbda0df";

      $url = "http://194.233.171.95:8080/alfresco/s/slingshot/doclib2/doclist/documents/node/workspace/SpacesStore/".$docs_token."?alf_ticket=".$ticket;

        $result = file_get_contents($url);
        $data = json_decode($result, 1); 

        print_r($data);
   }

   function sendFile_request($donne = array()){

       
       // $flux = file_get_contents('php://input');
       // $donne = json_decode($flux, 1);

        // if (!empty($donne)) {

           $ticket = $this->login();


           $fileName = '20220412103617piece62553a01435a4.pdf';
           $fileSrc =  '/var/www/html/pmsv2/uploads/demande/20220412103617piece62553a01435a4.pdf';
           
           $deScription =  'Updating content';
           $containerid = 'alphonse test';
     $fold_token = "workspace://SpacesStore/384dca6b-bfaa-4981-946c-7dd34c14bed8";

           $cmd = 'curl --location --request POST \'http://194.233.171.95:8080/alfresco/s/api/upload?alf_ticket='.$ticket.'\' \
        --form \'filedata=@"'.$fileSrc.'"\' \
        --form \'filename="'.$fileName.'"\' \
        --form \'destination="'.$fold_token.'"\' \
        --form \'description="'.$deScription.'"\' \
        --form \'containerid="'.$containerid.'"\' \
        --form \'majorversion="true"\' \
        --form \'overwrite="false"\' \ ';

           $output = shell_exec($cmd);

           return json_decode($output);

        // }else{
          
        //    print_r('Erreurs: donnees vide');

        //  }

        /*
         url : https://app.mediabox.bi/auto_rapport/Api_Edrms/sendFile_request
         POST
        {
        "fileName": "logoclub2.png",
        "fileSrc": "/var/www/html/auto_rapport/uploads/logoclub2.png",
        "deScription": "contrant du parcelle numero 20",
        "numero": "72222075",
        "folders": "workspace://SpacesStore/f298f00e-f839-412b-846a-ef25dba57e8a"
        }*/


    }

 
    function create_fold($dossier_token = "",$donne = array()){

        $fold_token = !empty($dossier_token) ? "SpacesStore/".$dossier_token : "SpacesStore/c0d997c8-73b0-44e8-b4f3-ace8a6e368a6";

       // http://194.233.171.95:8080/share/page/folder-details?nodeRef=workspace://SpacesStore/c0d997c8-73b0-44e8-b4f3-ace8a6e368a6

        $reponse = array();
         
      
        if (!empty($donne)) {

           $data = array('name' => $donne['name'],'title' => $donne['title'], 'description' => $donne['description']);

           $ticket = $this->login();

           $url = "http://194.233.171.95:8080/alfresco/s/api/node/folder/workspace/".$fold_token."?alf_ticket=".$ticket;
           
           $reponse =  json_decode($this->request_login($url, $data));

        }else{
          
           print_r('Erreurs: donnees vide');

        }

        /* Request 
        url : https://app.mediabox.bi/auto_rapport/Api_Edrms/getCompte_home_fold/$donne/$id_fold
        body:
        $data = '{
        "name": "72222993",
        "title": "100",
        "description": "72222075",
        }';*/


        return $reponse;

    }


    

    function request_login($url,$data){

          if(is_array($data)){ $data = json_encode($data);}
          $options = stream_context_create(['http' => [
          'method'  => 'POST',
          'header'  => 'Content-type: application/json',
          'content' => $data
          ]]);

          $response = file_get_contents($url,false,$options);

          return $response;

    }



}


?>