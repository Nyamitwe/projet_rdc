<!-- 
@eriel@mediabox.bi
69218581
Debuter:26/02/2024

Fichier utiliser pour la consommation et partaGE D'API avec le systeme BPS
-->
<?php
if (!defined('BASEPATH'))
exit('No direct script access allowed');
class Bps_api
{
    protected $CI;
    private $base_url="devapi.mediabox.bi:27805";
    
    //charger d'executer les requetes 
    public function execute($url, $data = '', $method = 'POST')
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
        //    curl_setopt($ch, CURLOPT_USERPWD, "admin:al2023fr&SC0");
        if(!empty($data))
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        
        return json_decode($output);
    }
    
    //charger de retourner les infos pour authentification Authentication API
    public function login($username)
    { 
        $data = array(
            'login' => $username,
        );
        
        $url = "https://".$this->base_url."/api/v1/applicant-verify";
        
        $reponse =  $this->execute($url,json_encode($data));
        
        return $reponse;        
    }

    //charger de retourner les infos de la parcelle
    public function parcelle($parcelle)
    { 
        $url = "https://".$this->base_url."/api/v1/parcelle-detail?num=".$parcelle;
        
        $reponse =  $this->execute($url, '', 'GET');
        
        return $reponse;        
    }
    


 
}
?>