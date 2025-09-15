<?php 
	
if (!defined('BASEPATH'))
exit('No direct script access allowed');

class Alfresco_lib
{
	protected $CI;

	public function __construct()
	{
	  $this->CI = & get_instance();
      $this->CI->load->library('email');
      $this->CI->load->model('Model');
	}




    //Execute request 
    function execute_Martin($url, $data = '', $method = 'POST'){
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_ENCODING , 1); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        if($method == 'POST')
          curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8','Accept: application/json','Accept-Encoding: deflate'));
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_USERPWD, "admin:brisk");
        if(!empty($data))
          curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);

        $donne_cn = str_replace("cm:", "cm_", $output);
        $donne_op = str_replace("sys:", "sys_", $donne_cn);
  
  
        return json_decode($donne_op);
      }


    //Execute request 
    function execute($url, $data = '', $method = 'POST'){
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_ENCODING , 1); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        if($method == 'POST')
          curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8','Accept: application/json','Accept-Encoding: deflate'));
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_USERPWD, "admin:brisk");
        if(!empty($data))
          curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);

        // $donne_cn = str_replace("cm:", "cm_", $output);
        // $donne_op = str_replace("sys:", "sys_", $donne_cn);
  
        return json_decode($output);
      }

    //Authentication API
    function login(){ 

    	$username = "admin";
    	$password = "brisk";
	    $data = array(
            'username' => $username,
            'password' => $password
        );

	    $url = "http://141.95.148.19:1620/alfresco/s/api/login";
 
	    $reponse =  $this->execute($url, json_encode($data));
	    return $reponse->data->ticket;
    }

    //API CREATE FOLDER
    public function create_folder28092022($ticket,$data=array(),$storage){
      // $data = array('name' => "Alfresco Folder",'title' => "Folder belong to Mr Nandou", 'description' => "Folder for testing API");
      
      $url = "http://141.95.148.19:1620/alfresco/s/api/node/folder/workspace/SpacesStore/".$storage."?alf_ticket=".$ticket;
      
      $return = $this->execute($url, json_encode($data));
      // $this->save_data('json_bps_pms_return', array('json_data'=>json_encode($return), 'application'=>'BPS|PMS','action'=>'CREATE_FOLDER'));
      
      return $return;
    }
   
    //Creation  d'un dossier a edrms avec un ticket deja cree
    public function create_folder_with_ticket($dossier_token,$donne,$ticket)
    {
      $fold_token=!empty($dossier_token) ? "".$dossier_token : "627cc058-86a9-4fdc-b848-764271ec7713";
      $arrayreponse = array();
      $reponse="";
      if(!empty($donne))
      {
        $data=array('name' => $donne['name'],'title' => $donne['title'], 'description' => $donne['description']);
        $url="http://141.95.148.19:1620/alfresco/s/api/node/folder/workspace/SpacesStore/".$fold_token."?alf_ticket=".$ticket;
        $arrayreponse=$this->execute($url, json_encode($data));
        $reponse=$arrayreponse->nodeRef;
        $reponse=str_replace('workspace://SpacesStore/','',$reponse);
      }
      else
      {
        print_r('Erreurs: donnees vide');
      }
      return $reponse;
    }

        //API CREATE FOLDER
    public function create_folder28092022_v2($ticket,$data=array())
    {
      
      $url = "http://141.95.148.19:1620/alfresco/s/api/node/folder/workspace/SpacesStore/627cc058-86a9-4fdc-b848-764271ec7713?alf_ticket=".$ticket;
      
      $return = $this->execute($url, json_encode($data));
      
      return $return;
    }


           //API CREATE FOLDER
    public function create_folder($ticket,$data=array(),$token_dossier_destination)
    {
      
      $url = "http://141.95.148.19:1620/alfresco/s/api/node/folder/workspace/SpacesStore/".$token_dossier_destination."?alf_ticket=".$ticket;
      
      $return = $this->execute($url, json_encode($data));
      
      return $return;
    }

   // creation des province
    public function create_folder_province()
    {
      $ticket=$this->login();
      $dossier_token="627cc058-86a9-4fdc-b848-764271ec7713";

      $sql_province="SELECT id,province_id,nom_repertoire_province FROM edrms_repertoire_province_processus WHERE IS_INSCRIPTION=1 ORDER BY nom_repertoire_province ASC";


      $all_province=$this->CI->Model->getRequete($sql_province);

      foreach ($all_province as $key)
      {
        $title="Province ".$key['nom_repertoire_province'];

        $descr="Répertoire principal des archives de la province de ".$key['nom_repertoire_province'];

        $donne=array('name'=>$key['nom_repertoire_province'],'title'=>$title,'description'=>$descr);

        $token_repertoire=$this->create_folder($ticket,$donne);

        $token=$token_repertoire->nodeRef;

        $data_token = explode("workspace://SpacesStore/", $token);

        $this->CI->Model->update('edrms_repertoire_province_processus',array('id'=>$key['id']),array('token_province'=>$data_token[1]));
      }
    }

    // creation des province pour inscription
    public function create_folder_province_inscription()
    {
      $ticket=$this->login();

      $dossier_token="2a48e0fc-6c57-4575-bd35-5c578deaec53";

      $sql_province="SELECT id,province_id,nom_repertoire_province FROM edrms_repertoire_province_processus WHERE 1 ORDER BY nom_repertoire_province ASC";

      $all_province=$this->CI->Model->getRequete($sql_province);

      foreach ($all_province as $key)
      {
        $title="province ".$key['nom_repertoire_province'];

        $descr="Le répertoire principal qui va stock les documents que les requérants on fournit au moment de l enregistrement pour la province  ".$key['nom_repertoire_province'];

        $donne=array('name'=>$key['nom_repertoire_province'],'title'=>$title,'description'=>$descr);

        $token_repertoire=$this->create_folder($ticket,$donne,$dossier_token);

        $token=$token_repertoire->nodeRef;

        $data_token = explode("workspace://SpacesStore/", $token);

        $this->CI->Model->update('edrms_repertoire_province_processus',array('id'=>$key['id']),array('token_province_inscription'=>$data_token[1]));
      }
    }

    public function create_folder_dossier_processus_par_province()
    {
      $ticket=$this->login();
      $table="edrms_dossiers_processus_province";
      $sqlprovince="SELECT province_id,token_province,nom_repertoire_province FROM edrms_repertoire_province_processus WHERE 1 ORDER BY nom_repertoire_province ASC";
      $provinces=$this->CI->Model->getRequete($sqlprovince);

      foreach($provinces as $province)
      {
        $tokenprovince=$province['token_province'];
        $sqlrepertoireprocessus="SELECT ID_DOSSIER,DOSSIER,DESC_DOSSIER FROM edrms_dossiers_processus WHERE TRAITE=0 ORDER BY DOSSIER ASC";
        $repertoireprocessus=$this->CI->Model->getRequete($sqlrepertoireprocessus);
        foreach($repertoireprocessus as $repertoire)
        {
          $name=$repertoire['DOSSIER'];
          $title=$repertoire['DESC_DOSSIER'];
          $descr="Le repertoire ".$name." de la province ".$province['nom_repertoire_province'];
          $donnees=array('name'=>$name,'title'=>$title,'description'=>$descr);
          $token=$this->create_folder($ticket,$donnees,$province['token_province']);

          // print_r($token->nodeRef);
          // exit();

          $token_result=$token->nodeRef;

          $data_token = explode("workspace://SpacesStore/",$token_result);

          $this->CI->Model->create('edrms_dossiers_processus_province',array('dossier_processus_id'=>$repertoire['ID_DOSSIER'],'province_id'=>$province['province_id'],'token_dossiers_processus_province'=>$data_token[1]));
        }
      }
      $this->CI->Model->update('edrms_dossiers_processus',array(),array('TRAITE'=>1));
    }

    //SEND METADATA TO FILE
    public function send_metedata($ticket,$data,$document){
        // $data = array(
        //     "properties"=>[
        //     "cm:name" => "File for Test",
        //     "cm:title" => "Title of file of test",
        //     "cm:description"=> "This is a file of test",
        //     "edms:name2"=> "Admin",
        //     "edms:name1"=> "Mediabox",
        //     "edms:confectionne_par"=> "Admin Mediabox",
        //     "edms:source_app"=> "BPS",
        //     ]
        // );
        //  $document = "040a4179-a67f-43bf-890d-2c7ae19b7e42";
        $url = "http://141.95.148.19:1620/alfresco/s/api/metadata/node/workspace/SpacesStore/$document?alf_ticket=".$ticket;
        $return = $this->execute($url, json_encode($data));
        $this->save_data('json_bps_pms_return',['json_data'=>json_encode($return), 'application'=>'BPS|PMS','action'=>'SEND_METHADATA', 'document'=>$document]);
        
        return  $return;
    }

    //GET NOD
    public function get_node($ticket){
        $url = "http://141.95.148.19:1620/alfresco/api/-default-/public/alfresco/versions/1/nodes/040a4179-a67f-43bf-890d-2c7ae19b7e42?alf_ticket=".$ticket;
        return  $this->execute($url, '', 'GET');
    } 

    //GET DATA FORM A FOLDER
	function get_data_of_folder($ticket, $folder_id){      
      
      $url = "http://141.95.148.19:1620/alfresco/s/slingshot/doclib2/doclist/documents/node/workspace/SpacesStore/".$folder_id."?alf_ticket=".$ticket;

      return $this->execute($url, '', 'GET');
   }

   //POST A FILE IN SPECIFIC FOLDER
   public function create_file($data_file)
     {
    # code...
        // $file_name =  "TITRE20220606091111629e514fb8b2713.pdf";
        // $file_source =  "https://pms.mediabox.bi/uploads/doc_generer/TITRE20220606091111629e514fb8b2713.pdf";
        // $deScription =  "Test create file";
        // $numero =  "72222075";
       
        // $folder = "workspace://SpacesStore/9353b275-8d56-4be9-96e2-a537ec4cfaf0";
        
        // $data_file = array(
        //     'fileName' => $file_name,
        //     'fileSrc' => $file_source,
        //     'deScription' => $deScription,
        //     'folders' => $folder,
        //     'numero'=>$numero
        // );

        $url = "https://app.mediabox.bi/auto_rapport/Api_Edrms/sendFile_request";
   
        if(is_array($data_file)){ $data_file = json_encode($data_file);}
            $options = stream_context_create(['http' => [
            'method'  => 'POST',
            'header'  => 'Content-type: application/json',
            'content' => $data_file
        ]]);
   
        $return = file_get_contents($url,false,$options);
        $this->save_data('json_bps_pms_return',['json_data'=>json_encode($return), 'application'=>'BPS|PMS', 'action'=>'CREATE_FILE']);
        return $return;
    }


    //MOVE COPY OF FILE
    public function move_file($ticket,$folder_original,$folder_destination)
    {
      // $document = '040a4179-a67f-43bf-890d-2c7ae19b7e42';
      $data = '
      {
        "nodeRefs": [   
                "workspace://SpacesStore/'.$folder_original.'",
        ]
      }'
      ;
      
     // $folder_destination = "9353b275-8d56-4be9-96e2-a537ec4cfaf0";
	    $url = "http://141.95.148.19:1620/alfresco/s/slingshot/doclib/action/move-to/node/workspace/SpacesStore/$folder_destination?alf_ticket=$ticket";
      
      $return = $this->execute($url, $data);
      $this->save_data('json_bps_pms_return',['json_data'=>json_encode($return), 'application'=>'BPS|PMS', 'action'=>'MOVE_FILE', 'document'=>$folder_original]);
      return $return;
    }

    //Get List Available Workflow (process)

    public function list_process($ticket){
      
        $url = "http://141.95.148.19:1620/alfresco/api/-default-/public/workflow/versions/1/processes?alf_ticket=".$ticket;
        return  $this->execute($url, '', 'GET');
    }

    //Get List Available Workflow (process definition)
    public function list_process_definition($ticket)
    {
      $url = "http://141.95.148.19:1620/alfresco/api/-default-/public/workflow/versions/1/process-definitions?skipCount=0&maxItems=10&alf_ticket=".$ticket;
      return  $this->execute($url, '', 'GET');
    }


    //Get process definition BY ID
    public function get_process_definition_id()
    {
      $processDefinitionId = "activitiAdhoc:1:4";
      $url = "http://141.95.148.19:1620/alfresco/api/-default-/public/workflow/versions/1/process-definitions/$processDefinitionId";
      return  $this->execute($url, '', 'GET');
    }

     //Get Users 
     public function users()
     {
       $ticket = $this->login();
       $url = "http://141.95.148.19:1620/alfresco/s/slingshot/doclib2/doclist/documents/node/alfresco/company/home/User%20Homes/?alf_ticket=".$ticket;
       return  $this->execute($url, '', 'GET');
     }
   
    //Get list process ID --------- OK
    public function get_process_id($processId = 7277, $ticket)
    {
      $url = "http://141.95.148.19:1620/alfresco/api/-default-/public/workflow/versions/1/processes/$processId?alf_ticket=".$ticket;
      return  $this->execute($url, '', 'GET');
    }

    //Get start process 
    public function start_process()
    {
      // "workspace://SpacesStore/6dfa2135-b149-43c2-831e-5c3d1c1e19ea",
      //"workspace://SpacesStore/96101853-c322-4920-b51c-3dd557184fbd"

      $document = "SpacesStore/6dfa2135-b149-43c2-831e-5c3d1c1e19ea";
       $data = '{
        "processDefinitionKey": "activitiAdhoc",
        "variables": {
        "bpm_assignee":"admin",        
        "nodeRef" : "workspace://SpacesStore/'.$document.'",        
        "message": "Please review it"
        },
        "items": [          
          "workspace://SpacesStore/6dfa2135-b149-43c2-831e-5c3d1c1e19ea",
          "workspace://SpacesStore/96101853-c322-4920-b51c-3dd557184fbd"
          ]
            
        }';

      $url = "http://141.95.148.19:1620/alfresco/api/-default-/public/workflow/versions/1/processes";
      $return = $this->execute($url, $data);
      $this->save_data('json_bps_pms_return',['json_data'=>json_encode($return), 'application'=>'BPS|PMS', 'action'=>'START_PROCESS', 'document'=>$document]);
      return $return;
    }

    //Get start process GROUP
    public function start_process_group()
    {
      // "workspace://SpacesStore/6dfa2135-b149-43c2-831e-5c3d1c1e19ea",
      //"workspace://SpacesStore/96101853-c322-4920-b51c-3dd557184fbd"
      $document = "6dfa2135-b149-43c2-831e-5c3d1c1e19ea";
       $data = '{
        "processDefinitionKey": "activitiParallelGroupReview",
        "variables": {
          "bpm_groupAssignee":"GROUP_ALFRESCO_ADMINISTRATORS",        
          "nodeRef" : "workspace://SpacesStore/'.$document.'",        
          "message": "Please review it"
        },

        "items": [
          "workspace://SpacesStore/6dfa2135-b149-43c2-831e-5c3d1c1e19ea"
        ]            
        }';

      $url = "http://141.95.148.19:1620/alfresco/api/-default-/public/workflow/versions/1/processes";
      $return = $this->execute($url, $data);
      $this->save_data('json_bps_pms_return',['json_data'=>json_encode($return), 'application'=>'BPS|PMS', 'action'=>'START_PROCESS_GROUP', 'document'=>$document]);
      return $return;
    }

    //Get list process start by user 
    public function get_process_by_user()
    {
      $url = "http://141.95.148.19:1620/alfresco/api/-default-/public/workflow/versions/1/processes?where=(startUserId%20=%20'admin'%20)";
      return  $this->execute($url, '', 'GET');
    }

    public function save_data($table, $data){
       $return = $this->CI->Model->insert_last_id($table, $data);
       echo "Insert_id: ".$return;
    }

    //GET Completed TASK that i have start as ADMIN (user)
    public function task_have_start()
    {
      # code...
      $url = "http://141.95.148.19:1620/alfresco/api/-default-/public/workflow/versions/1/processes?where=(startUserId%20=%20'admin'%20AND%20status%20=%20'completed')";
      return  $this->execute($url, '', 'GET');
    }

    //GET TASK that i have start as ADMIN (user)
    public function task_start()
    {
      # code...
      $url = "http://141.95.148.19:1620/alfresco/api/-default-/public/workflow/versions/1/tasks?skipCount=0&m";
      return  $this->execute($url, '', 'GET');
    }


    function get_file_data(){
       
      $ticket = $this->login();
      $docs_id = 'f6dbe741-cb16-49ba-936c-49e787561d0d';

     // $url = "http://194.233.171.95:8080/alfresco/s/slingshot/node/content/workspace/SpacesStore/".$docs_id."?a=true&alf_ticket=".$ticket;

        $url = "http://141.95.148.19:1620/alfresco/s/api/node/content/workspace/SpacesStore/".$docs_id."?a=false&alf_ticket=".$ticket;
      
      return $url;
 
   }
}
// http://141.95.148.19:1620/share/page/document-details?nodeRef=workspace://SpacesStore/f6dbe741-cb16-49ba-936c-49e787561d0d

?>