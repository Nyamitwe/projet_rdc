<?php

/**
 *@author Jules
 *
 */
defined('BASEPATH') or exit('No direct script access allowed');
class TestResolve extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

//charger d'executer l'envoi des informations d'un requerant vers bps
  public function executing($url, $data)
  {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_ENCODING, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTREDIR, 3);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type' => 'multipart/form-data'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $output = curl_exec($ch);

    var_dump($output);

var_dump(curl_getinfo($ch));
var_dump(curl_error($ch)); 

    curl_close($ch);
    return json_decode($output);
  }
	
public function executi($data='')
{
  // code...
  //http://bps.gov.bi/api/v1/
  $commande="curl --insecure -X POST 'http://192.168.0.25/api/v1/create-applicant-attribution' -H 'Content-Type: application/json'   -d ".json_encode($data)." --connect-timeout 10";
  $output=null;
  $retval=null;
 echo $commande;
  exec($commande, $output, $retval);
  echo "Returned with status $retval and output:\n";
  print_r($output);

}

public function sendMydata($url='192.168.0.25')
{
    # code...
    $data=json_encode(array(
    "fullname"=> "Mbonihankuye Eriel Test",
    "username"=> "erielmbonihankuye01@gmail.com",
    "email"=> "erielmbonihankuye01@gmail.com",
    "email_confirmation"=> "erielmbonihankuye01@gmail.com",
    "password"=> "",
    "password_confirmation"=> "",
    "mobile"=> "71852258",
    "registeras"=> 1,
    "country_code"=> 28,
    "province_id"=> 3,
    "commune_id"=> 131,
    "date_naissance"=> "1997-01-04",
    "father_fullname"=> "Papa",
    "mother_fullname"=> "Mama",
    "boite_postale"=> "inexistant",
    "nif"=> 0,
    "COLLINE_ID"=> 2469,
    "type_document_id"=> 3,
    "document_num"=> 789444,
    "LIEU_DELIVRANCE"=> "Buja",
    "DATE_DELIVRANCE"=> "2020-01-01",
    "profile_pic"=> "",
    "sexe_id"=> 1,
    "ZONE_ID"=> 105,
    "rc"=>"" ,
    "reseau_social"=> "",
    "siege"=> "",
    "NUMERO_PARCELLE"=> "1813a-B",
    "SUPERFICIE"=> "24500.4",
    "COLLINE_PARCELLE_ID"=> 2469,
    "PRIX"=> 1000000,
    "USAGE_ID"=> 2,
    "AVENUE"=> "a",
    "DOC_TOKEN"=> "",
    "ALF_TOKEN"=> "24091861-9ce5-42d8-9383-99cb46ab3908",
    "DOC_REF_TOKEN"=> "",
    "ALF_REF_TOKEN"=> "ba28e307-419d-44f8-b477-bc696d56f1e1"
    ));
        $data = array(

            'EMAIL' => 'agentobuha@dtfobuha.bi',
            'PASSWORD' => '12345678',
        );
  // $this->executi($data);
   $url1 = "http://" . $url . "/api/v1/create-applicant-attribution";
   $reponse =  $this->executing($url1,$data);
   print_r($reponse)  ;          
}
}
