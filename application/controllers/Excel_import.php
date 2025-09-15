<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Excel_import extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
  }

  function index()
  {
    $data['msg']="";
    $this->load->view('Excel_import_view',$data);
  }

  function import()
  {
    $PROVINCE_ID=1;
    $COMMUNE_ID=2;
    $ZONE_ID=3;
    $COLLINE_ID=4;
    if(isset($_FILES["file"]["name"]))
    {
      print_r($_FILES["file"]["tmp_name"]);
      exit();
      $highestRow=0;
      $path = $_FILES["file"]["tmp_name"];
      $object = PHPExcel_IOFactory::load($path);
      foreach($object->getWorksheetIterator() as $worksheet)
      {
        $highestRow=$worksheet->getHighestRow();
        $highestColumn=$worksheet->getHighestColumn();
        for($row=2; $row<=$highestRow; $row++)
        {
          // print_r($worksheet->getCellByColumnAndRow(1, $row)->getValue());
          // exit();
          $numero=$worksheet->getCellByColumnAndRow(0, $row)->getValue();
          $nom_prenom=$worksheet->getCellByColumnAndRow(1, $row)->getValue();
          $numero_parcelle=$worksheet->getCellByColumnAndRow(2, $row)->getValue();
          $superficie=$worksheet->getCellByColumnAndRow(3, $row)->getValue();
          $prix_metre_care=$worksheet->getCellByColumnAndRow(4, $row)->getValue();

          $array_parcelle=array('NUMERO_PARCELLE'=>$numero_parcelle,'SUPERFICIE'=>$superficie,'PRIX'=>$prix_metre_care,'STATUT_ID'=>3,'PROVINCE_ID'=>$PROVINCE_ID,'COMMUNE_ID'=>$COMMUNE_ID,'ZONE_ID'=>$ZONE_ID,'COLLINE_ID'=>$COLLINE_ID);
          $ID_PARCELLE=$this->Model->insert_last_id('parcelle', $array_parcelle);
          $ID_REQUERANT=1;
          $array_attribution=array('ID_PARCELLE'=>$ID_PARCELLE,'ID_REQUERANT'=>$ID_REQUERANT,'NUMERO_PARCELLE'=>$numero_parcelle,'SUPERFICIE'=>$superficie,'PRIX'=>$prix_metre_care,'STATUT_ID'=>3,'PROVINCE_ID'=>$PROVINCE_ID,'COMMUNE_ID'=>$COMMUNE_ID,'ZONE_ID'=>$ZONE_ID,'COLLINE_ID'=>$COLLINE_ID);
          $ID_ATTRIBUTION =$this->Model->insert_last_id('parcelle_attribution', $array_attribution);
        }
      }
      // print_r('ok');
      // exit();
      redirect(base_url('Excel_import'));
    }
  }

  function import_old()
  {
    if(isset($_FILES["file"]["name"]))
    {
      $highestRow=0;
      $path = $_FILES["file"]["tmp_name"];
      $object = PHPExcel_IOFactory::load($path);
      foreach($object->getWorksheetIterator() as $worksheet)
      {
        $highestRow=$worksheet->getHighestRow();
        $highestColumn=$worksheet->getHighestColumn();
        for($row=2; $row<=$highestRow; $row++)
        {
          // print_r($worksheet->getCellByColumnAndRow(1, $row)->getValue());
          // exit();
          $numero=$worksheet->getCellByColumnAndRow(0, $row)->getValue();
          $nom_prenom=$worksheet->getCellByColumnAndRow(1, $row)->getValue();
          $numero_parcelle=$worksheet->getCellByColumnAndRow(2, $row)->getValue();
          $superficie=$worksheet->getCellByColumnAndRow(3, $row)->getValue();
          $prix_metre_care=$worksheet->getCellByColumnAndRow(4, $row)->getValue();

          $array_parcelle=array('NUMERO_PARCELLE'=>$numero_parcelle,'SUPERFICIE'=>$superficie,'PRIX'=>$prix_metre_care,'STATUT_ID'=>3);
          $ID_PARCELLE=$this->Model->insert_last_id('parcelle', $array_parcelle);
          $ID_REQUERANT=1;
          $array_attribution=array('ID_PARCELLE'=>$ID_PARCELLE,'ID_REQUERANT'=>$ID_REQUERANT,'NUMERO_PARCELLE'=>$numero_parcelle,'SUPERFICIE'=>$superficie,'PRIX'=>$prix_metre_care,'STATUT_ID'=>3);
          $ID_ATTRIBUTION =$this->Model->insert_last_id('parcelle_attribution', $array_attribution);
        }
      }
      $url='http://localhost:8089/backend.php/dashboard';
      redirect($url);
    }
  }
}
?>