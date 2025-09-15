<?php 

/**
* @author Nadvaxe2024
* created on the 25th april 2024
* DEMANDE DES AUDIENCES
* advaxe@mediabox.bi
*/
class Audiences extends CI_Controller
{
  function __construct()
  {
    # code...
    parent::__construct();
  }
  
  //Fonction principale
  
  function index()
  {
    $data['types_demandeur']=$this->Model->getRequete('SELECT `ID_TYPE_DEMANDE_AUDIENCE`, `DESC_TYPE_DEMANDE_AUDIENCE` FROM `pms_type_demande_audience` WHERE TYPE_INITIATION_DEMANDE !=2');

    $data['types_visiteur']=$this->Model->getRequete('SELECT `ID_TYPE_VISITE`, `DESC_TYPE_VISITE` FROM `pms_type_demandeur_visite` WHERE TYPE_INITIATION_DEMANDE !=2');
    $data['professions']=$this->Model->getRequete('SELECT `ID_PROFESSION`, `DESCR_PROFESSION` FROM `profession` WHERE 1');
      $data['info_titre']="style='display:none;'";
       $data['urgences']="style='display:none;'";
      $data['choix'] = 0;

    $this->load->view('Audiences_view',$data);
  }
  //Enregistrement des donnees dans la base
  function save_data()
  {

    $titre=$this->input->post('STATUS_TITRE');
    $urgence=$this->input->post('OBJET');
    
    $this->form_validation->set_rules('NOM', '', 'required',array("required"=>"<font color='red'>Ce champs est requis</font>"));
    $this->form_validation->set_rules('ID_PROFESSION', '', 'required',array("required"=>"<font color='red'>Ce champs est requise</font>"));
    $this->form_validation->set_rules('TEL2', '', 'required',array("required"=>"<font color='red'>Ce champs est requis</font>"));
    $this->form_validation->set_rules('AD_PHYSIQUE', '', 'required',array("required"=>"<font color='red'>Ce champs est obligatoire</font>"));
    $this->form_validation->set_rules('CNI', '', 'required',array("required"=>"<font color='red'>Ce champs est obligatoire</font>"));
    $this->form_validation->set_rules('TYPE_DEMANDEUR', '', 'required',array("required"=>"<font color='red'>Ce champs est obligatoire</font>"));
    $this->form_validation->set_rules('OBJET', '', 'required',array("required"=>"<font color='red'>Ce champs est obligatoire</font>"));
    if ($urgence==2) {
      $this->form_validation->set_rules('MOTIF_URGENCE', '', 'required',array("required"=>"<font color='red'>Ce champs est obligatoire</font>"));
    }
    $this->form_validation->set_rules('EMAIL','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
     $this->form_validation->set_rules('STATUS_TITRE','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
    if ($titre==1) {
      $this->form_validation->set_rules('VOLUME','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
      $this->form_validation->set_rules('FOLIO','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
      $this->form_validation->set_rules('PARCELLE','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
            if (!isset($_FILES['PDF']) || empty($_FILES['PDF']['name'])) {
          $this->form_validation->set_rules('PDF', 'Fichier PDF', 'required', array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));

      }

    }
    if ($this->form_validation->run() == FALSE)
    {      
      $data['types_demandeur']=$this->Model->getRequete('SELECT `ID_TYPE_DEMANDE_AUDIENCE`, `DESC_TYPE_DEMANDE_AUDIENCE` FROM `pms_type_demande_audience` WHERE TYPE_INITIATION_DEMANDE !=2');

    $data['types_visiteur']=$this->Model->getRequete('SELECT `ID_TYPE_VISITE`, `DESC_TYPE_VISITE` FROM `pms_type_demandeur_visite` WHERE TYPE_INITIATION_DEMANDE !=2');
    $data['professions']=$this->Model->getRequete('SELECT `ID_PROFESSION`, `DESCR_PROFESSION` FROM `profession` WHERE 1');
       if ($titre==1) {
          $data['info_titre']="style='display:block;'";
        }else{
          $data['info_titre']="style='display:none;'";
        }
      if ($urgence==2) 
     {
      $data['urgences']="style='display:block;'";
     }else{
      $data['urgences']="style='display:block;'";
     }
     $data['choix'] = $titre;
      $this->load->view('Audiences_view',$data);
    }
    
    else
    {
      $datas=array(
        'ID_FONCTION'=>$this->input->post('ID_PROFESSION'),
        'ADRESSE_PHYSIQUE'=>$this->input->post('AD_PHYSIQUE'),                           
        'NOM_PRENOM'=>$this->input->post('NOM'),
        'TELEPHONE'=>$this->input->post('TEL2'),
        'EMAIL'=>$this->input->post('EMAIL'),
        'NUM_CNI'=>$this->input->post('CNI'),
        'ID_TYPE_DEMANDEUR_AUDIENCE'=>$this->input->post('TYPE_DEMANDEUR'),
        'ID_OBJET_VISITE'=>$this->input->post('OBJET'),
        'MOTIF_URGENCE'=>$this->input->post('MOTIF_URGENCE'),
        'DISPOSITION_TITRE'=>$this->input->post('STATUS_TITRE'),
        'VOLUME'=>$this->input->post('VOLUME'),
        'FOLIO'=>$this->input->post('FOLIO'),
        'NUMERO_PARCELLE'=>$this->input->post('PARCELLE'),
         'TYPE_INITIATION_DEMANDE'=>1,
        'DOC_PDF_TITRE'=>$this->upload_file_titre('PDF')
      );

      $insertion=$this->Model->insert_last_id('pms_demandeur_audience',$datas);
      
      $message = "<div class='alert alert-success text-center'>Votre demande a été envoyée avec succes. Vous aurez un message de confirmation dans votre boite mail</div>";
      $this->session->set_flashdata(array('message'=>$message));
       redirect(base_url('Audiences/messaging'));
      
    }
    
  }

    public function messaging()
    {
    $this->load->view('Audiences_redirect_view');
  }
  //PERMET L'UPLOAD DE L'IMAGE CNI / PASSEPORT
  public function upload_file_titre($input_name)
  {
    $nom_file = $_FILES[$input_name]['tmp_name'];
    $nom_champ = $_FILES[$input_name]['name'];
    $ext=pathinfo($nom_champ, PATHINFO_EXTENSION);
    $repertoire_fichier = FCPATH .'uploads/doc_scanner/';
    $code=uniqid();
    $name=$code . 'TITRE.' .$ext;
    $file_link = $repertoire_fichier . $name;
    
    
    // $fichier = basename($nom_champ);
    if (!is_dir($repertoire_fichier)) {
      mkdir($repertoire_fichier, 0777, TRUE);
    }
    move_uploaded_file($nom_file, $file_link);
    return $name;
  }
   
}
?>