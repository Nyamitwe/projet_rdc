<?php

class Parcelle extends CI_Controller
{
    public function __construct()
    {
      parent::__construct();
      $this->isAuth();
      require('fpdf184/fpdf.php');
    }

    //CHECK AUTHENTIFICATION
    public function isAuth()
    {
      if(empty($this->get_utilisateur()))
      {
        redirect(base_url('Login'));
      }
    }

    //RECUPERATION DU LOGIN DE LA PERSONNE CONNECTEE
    public function get_utilisateur()
    {
      return $this->session->userdata('PMS_USER_ID');
    }

    public function index()
    {
     $this->load->view('Parcelle_Liste_view'); 
    }
 
    // recupere les informations dans la base
    public function list()
    {
      $var_search= !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
      $var_search=str_replace("'","\'",$var_search);
      $query_principal="SELECT 
      parcelle_attribution.ID_ATTRIBUTION,
      parcelle_attribution.NUMERO_PARCELLE,
      sf_guard_user_profile.fullname,
      parcelle_attribution.TYPE_PARCELLE,
      parcelle_attribution.IS_MANDATAIRE,
      parcelle_attribution.IS_COPROPRIETE,
      parcelle_attribution.ID_REQUERANT  
      FROM `parcelle_attribution` 
      JOIN sf_guard_user_profile on sf_guard_user_profile.id=parcelle_attribution.ID_REQUERANT 
      where 1 and parcelle_attribution.STATUT_ID=3";


      $limit = '';
      if (isset($_POST['length']) && $_POST['length'] != -1)
      {
          $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
      }


      $order_by='';
      $order_column=array(1,'sf_guard_user_profile.fullname',
      'parcelle_attribution.NUMERO_PARCELLE');
      
      if ($order_by)
      {
        $order_by = isset($_POST['order']) ? ' ORDER BY '.$order_column[$_POST['order']['0']['column']] .'  '.$_POST['order']['0']['dir'] : ' ORDER BY parcelle_attribution.ID_ATTRIBUTION ASC';
      }
      
      $search = !empty($_POST['search']['value']) ? (" AND (sf_guard_user_profile.fullname LIKE '%$var_search%' OR parcelle_attribution.NUMERO_PARCELLE LIKE '%$var_search%') ") : '';
      
      $critaire = '';
      
      $query_secondaire=$query_principal.' '.$critaire.' '.$search.' '.$order_by.' '.$limit;
      $query_filter = $query_principal.' '.$critaire.' '.$search;
      
      $fetch_parcelle = $this->Model->datatable($query_secondaire);
      $data = array();
      $u=0;
    
      
      foreach ($fetch_parcelle as $row)
      {
        $u++; 
        $sub_array=array(); 
        
        $nbr=0;

        $html=' <div class="table-responsive">
        <table id="myTable" class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Nom <i class="fa fa-user"></i></th>
                    <th>Email <i class="fa fa-envelope"></i></th>
                    <th>Tél <i class="fa fa-phone"></i></th>
                </tr>
            </thead>
            <tbody>';

        if ($row->TYPE_PARCELLE==0) {
        $nbr=1;
        if ($row->IS_MANDATAIRE==1) {
        $prop=$this->Model->getRequete('SELECT * from pms_copropriete_succession where id_attribution='.$row->ID_ATTRIBUTION.'');
        $i=0;
       foreach ($prop as $key1) {
        $i++;
         // <td><span class="badge badge-success">Actif</span></td>
      $html.=' <tr>
                    <td>'.$i.'</td>
                    <td>'.$key1['fullname'].'</td>
                    <td>'.$key1['email'].'</td>
                    <td>'.$key1['mobile'].'</td>
                 </tr>';
        } 
        

        }else{
           $prop=$this->Model->getRequete('SELECT * from sf_guard_user_profile where id='.$row->ID_REQUERANT.'');
              $i=0;
       foreach ($prop as $key1) {
        $i++;
         // <td><span class="badge badge-success">Actif</span></td>
      $html.=' <tr>
                    <td>'.$i.'</td>
                    <td>'.$key1['fullname'].'</td>
                    <td>'.$key1['email'].'</td>
                    <td>'.$key1['mobile'].'</td>
                 </tr>';
        } 
        }
        }else{
        $val=$this->Model->getRequeteOne('SELECT COUNT(*) as nb from pms_copropriete_succession where id_attribution='.$row->ID_ATTRIBUTION.'');
        $nbr=$val['nb'];

         $prop=$this->Model->getRequete('SELECT * from pms_copropriete_succession where id_attribution='.$row->ID_ATTRIBUTION.'');
        $i=0;
       foreach ($prop as $key1) {
        $i++;
         // <td><span class="badge badge-success">Actif</span></td>
      $html.=' <tr>
                    <td>'.$i.'</td>
                    <td>'.$key1['fullname'].'</td>
                    <td>'.$key1['email'].'</td>
                    <td>'.$key1['mobile'].'</td>
                 </tr>';
        } 
        

        }

         $html.=' </tbody>
        </table>
    </div>';




        $sub_array[]='<center><font color="#000000" size=2><label>'.$u.'</label></font> </center>';
        $sub_array[]='<center><font color="#000000" size=2><label>'.$row->NUMERO_PARCELLE.'</label></font> </center>';                     
        
        $sub_array[]='<center><a  href="#"  data-toggle="modal" data-target="#tbl'.$row->ID_ATTRIBUTION.'" title="Detail"><span class="badge badge-primary">'.$nbr.'</a></span></center><div class="modal fade" id="tbl' . $row->ID_ATTRIBUTION . '" ><div class="modal-dialog modal-lg"><div class="modal-content"><div class="modal-body"><h5>Le(s) proprietaire(s) de la parcelle <b>'.$row->NUMERO_PARCELLE.'</b>.</h5><br>'.$html.'</div><div class="modal-footer"><a class="" href="#" class="close" data-dismiss="modal"><span class="mode mode_process">QUITTER</span></a></div></div></div></div>';                     
        
        $data[] = $sub_array;
      }
      $output = array(
        "draw" => intval($_POST['draw']),
        "recordsTotal" =>$this->Model->all_data($query_principal),
        "recordsFiltered" => $this->Model->filtrer($query_filter),
        "data" => $data
      );
      echo json_encode($output);
    }


}































?>