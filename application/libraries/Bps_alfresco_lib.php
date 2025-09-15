<?php 
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Bps_alfresco_lib
{
	protected $CI;
	private $ip_port_serveur="192.168.0.25:1620";
	public function __construct()
	{
		$this->CI = & get_instance();
		$this->CI->load->library('email');
		$this->CI->load->model('Model');
	}

	// Function pour se connecter
	public function login()
	{
		$username = "admin";
		$password = "brisk";
		$data = array('username' => $username, 'password' => $password);
		$url = "http://".$this->ip_port_serveur."/alfresco/s/api/login";
		$reponse =  $this->execute($url, json_encode($data));
		$ticket = $reponse->data->ticket;
		return $ticket;
	}

  // Function pour faire le request
	function request_login($url,$data)
	{
		if(is_array($data))
		{
			$data = json_encode($data);
		}
		$options = stream_context_create(['http' => [
			'method'  => 'POST',
			'header'  => 'Content-type: application/json',
			'content' => json_encode($data)
		]]);
		$response = file_get_contents($url,false,$options);
		return $response;
	}

  // Function pour exécuter le request
	function execute($url, $data = '', $method = 'POST')
	{
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
		return json_decode($output);
	}

  // List Company Home Folder Content
	public function list_Company($ticket)
	{
		$url="http://".$this->ip_port_serveur."/alfresco/s/slingshot/doclib2/doclist/folders/node/alfresco/company/home/Bubanza?alf_ticket=".$ticket;
		return  $this->execute($url, '', 'GET');
	}

  // List Folder Content by NodeRef
	public function list_folder($ticket,$token_province)
	{
		$url="http://".$this->ip_port_serveur."/alfresco/s/slingshot/doclib2/doclist/documents/node/workspace/SpacesStore/".$token_province."?alf_ticket=".$ticket;
		return  $this->execute($url, '', 'GET');
	}

  // List Shared Folder Content
	public function list_shared_folder($ticket)
	{
		$url="http://".$this->ip_port_serveur."/alfresco/s/slingshot/doclib2/doclist/documents/node/alfresco/company/home/Shared?sortField=cm:name&sortAsc=true&alf_ticket=".$ticket;
		return  $this->execute($url, '', 'GET');
	}

	public function start_workflow($ticket)
	{
		$document = "d57827a2-2789-4099-b6e5-492804e22f9e";
		$data='
		{
			"processDefinitionKey": "activitiAdhoc",
			"variables":
			{
				"bpm_assignee":"admin",        
				"nodeRef" : "workspace://SpacesStore/'.$document.'",        
				"message": "Please review it"
				},
				"items":
				[          
				"workspace://SpacesStore/d57827a2-2789-4099-b6e5-492804e22f9e"
				]
			}';
			$url = "http://".$this->ip_port_serveur."/alfresco/api/-default-/public/workflow/versions/1/processes";
			$return = $this->execute($url, $data);
			return $return;
		}
	}
?>