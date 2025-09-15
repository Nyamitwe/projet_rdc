  <?php
  /**
   *Raoul
   *projet: pms
   *Le 05/05/2022
   *Enregistrement des droits selon les stages/process et stages
   */
     
     if (!defined('BASEPATH')) exit('No direct script access allowed');

     class Droits  extends CI_Controller 
     {

      function __construct()
      {
        parent::__construct();   
      } 

      function test_mail_et_sms(){

         $this->notifications->send_mail('martinkabezya@gmail.com', 'Test info',NULL, 'Test send mail', null);

        $info = $this->notifications->send_sms_smpp('79588624','Bonjour chef');

        echo "Data : ".$info;

      }

      
      public function index()
      {                                                                                                
      $data['process']=$this->Model->getRequete('SELECT * from pms_process order by DESCRIPTION_PROCESS');

      $data['service']=$this->Model->getRequete('SELECT * from pms_service order by DESCRIPTION');


      $stages=$this->Model->getRequete('SELECT * from pms_stage join pms_process_stage on pms_stage.STAGE_ID=pms_process_stage.STAGE_ID join pms_process on pms_process_stage.PROCESS_ID=pms_process.PROCESS_ID order by DESCRIPTION_STAGE');

      $html='';
      $i=0;

   

     
      foreach ($stages as $key => $value) {
      $i++;

      $test_active=$this->Model->getOne('pms_process_service',array('ID_PROCESS_STAGE'=>$value['ID_PROCESS_STAGE']));


      if (!empty($test_active)) 
      { if ($test_active['ID_POSTE']==1) 
        {
         $html.='  <div class="form-group col-lg-12"><input type="checkbox" value="1" name="stage'.$i.'" >&nbsp;<label>'.$value['DESCRIPTION_STAGE'].' (<b style="font-weight: 900; color:#454545"> '.$value['DESCRIPTION_PROCESS'].'</b>)</label>
        <input type="hidden" value="'.$value['ID_PROCESS_STAGE'].'" name="stg'.$i.'" >
      </div>';
        }
        else
        {

        $html.='  <div class="form-group col-lg-12"><span style=""><font color=red>X</font></span>&nbsp;<label>'.$value['DESCRIPTION_STAGE'].' (<b style="font-weight: 900; color:#454545"> '.$value['DESCRIPTION_PROCESS'].'</b>)</label>
        <input type="hidden" value="'.$value['ID_PROCESS_STAGE'].'" name="stg'.$i.'" >
      </div>';

        }

      }
      else
      {

     $html.='  <div class="form-group col-lg-12"><input type="checkbox" value="1" name="stage'.$i.'" >&nbsp;<label>'.$value['DESCRIPTION_STAGE'].' (<b style="font-weight: 900; color:#454545"> '.$value['DESCRIPTION_PROCESS'].'</b>)</label>
        <input type="hidden" value="'.$value['ID_PROCESS_STAGE'].'" name="stg'.$i.'" >
      </div>';

      }


    
      }
      $data['html']=$html;                                                                             
      $data['titre']="".lang('enregistrement_droit')."";


      $this->load->view('Droits_Views',$data);
      } 


      function get_input()
      {
      $PROCESS_ID=$this->input->post('PROCESS_ID');
      $ID_POSTE=$this->input->post('ID_POSTE');


      if (empty($PROCESS_ID)) 
      {

         $stages=$this->Model->getRequete('SELECT * from pms_stage join pms_process_stage on pms_stage.STAGE_ID=pms_process_stage.STAGE_ID join pms_process on pms_process_stage.PROCESS_ID=pms_process.PROCESS_ID order by DESCRIPTION_STAGE');

      }
      else
      {

       $stages=$this->Model->getRequete('SELECT * from pms_stage join pms_process_stage on pms_stage.STAGE_ID=pms_process_stage.STAGE_ID join pms_process on pms_process_stage.PROCESS_ID=pms_process.PROCESS_ID where 1 and pms_process_stage.PROCESS_ID='.$PROCESS_ID.'  order by DESCRIPTION_STAGE');
      }

     

      $html='';
      $i=0;
      foreach ($stages as $key => $value) {
      $i++;
     
      $test_active=$this->Model->getOne('pms_process_service',array('ID_PROCESS_STAGE'=>$value['ID_PROCESS_STAGE']));


      if (!empty($test_active)) 
      { 

        if ($test_active['ID_POSTE']==1 || $ID_POSTE==1) 
        {
         $html.='  <div class="form-group col-lg-12"><input type="checkbox" value="1" name="stage'.$i.'" >&nbsp;<label>'.$value['DESCRIPTION_STAGE'].' (<b style="font-weight: 900; color:#454545"> '.$value['DESCRIPTION_PROCESS'].'</b>)</label>
        <input type="hidden" value="'.$value['ID_PROCESS_STAGE'].'" name="stg'.$i.'" >
      </div>';
        }
        else
        {

        $html.='  <div class="form-group col-lg-12"><span style=""><font color=red>X</font></span>&nbsp;<label>'.$value['DESCRIPTION_STAGE'].' (<b style="font-weight: 900; color:#454545"> '.$value['DESCRIPTION_PROCESS'].'</b>)</label>
        <input type="hidden" value="'.$value['ID_PROCESS_STAGE'].'" name="stg'.$i.'" >
      </div>';

        }


        
      }
      else
      {

     $html.='  <div class="form-group col-lg-12"><input type="checkbox" value="1" name="stage'.$i.'" >&nbsp;<label>'.$value['DESCRIPTION_STAGE'].' (<b style="font-weight: 900; color:#454545"> '.$value['DESCRIPTION_PROCESS'].'</b>)</label>
        <input type="hidden" value="'.$value['ID_PROCESS_STAGE'].'" name="stg'.$i.'" >
      </div>';

      }
      }

      
      echo $html;    

      }



      public function get_poste($value='')
      {
      $ID_SERVICE=$this->input->post('SERVICE_ID');
      
      $poste=$this->Model->getRequete('SELECT * from pms_poste_service where ID_SERVICE='.$ID_SERVICE.' order by POSTE_DESCR');

      $html='<option value="">Séléctionner</option>';

      foreach ($poste as $key => $value) 
      {

      $html.='<option value="'.$value['ID_POSTE'].'">'.$value['POSTE_DESCR'].'</option>';
      }
      echo $html;
      }


      public function traite_($PROCESS_ID)
      {
     

       
     $stages=$this->Model->getRequete('SELECT * from pms_stage join pms_process_stage on pms_stage.STAGE_ID=pms_process_stage.STAGE_ID join pms_process on pms_process_stage.PROCESS_ID=pms_process.PROCESS_ID join pms_process_service on pms_process_service.STAGE_ID=pms_process_stage.STAGE_ID  where 1 and pms_process_service.ID_POSTE=1  order by DESCRIPTION_STAGE');


     

      $html='';
      $i=0;
     
      foreach ($stages as $key => $value) {
      $i++;
      $service=$this->Model->getRequete('SELECT * from pms_service where 1  order by DESCRIPTION');
      $check='';
      foreach ($service as $key => $val) 
      {
      $test_active=$this->Model->getRequeteOne('SELECT '.$val['CODE_SERVICE'].' from pms_process_service where 1  and STAGE_ID='.$value['STAGE_ID'].'');
      
     
      

      $html.='  <div class="form-group col-lg-12"><input type="checkbox" '.$check.' value="1" name="stage'.$i.'" >&nbsp;<label>'.$value['DESCRIPTION_STAGE'].' (<b style="font-weight: 900; color:#454545"> '.$value['DESCRIPTION_PROCESS'].'</b>)</label>
        <input type="hidden" value="'.$value['STAGE_ID'].'" name="stg'.$i.'" >
      </div>';

     
      }
      }
      $data['html']=$html;
      $data['PROCESS_ID']=$PROCESS_ID;
      $data['SERVICE_ID']=$SERVICE_ID;                                                                             
      $data['titre']="Enregistrement des droits";


      $this->load->view('Droits_Update_View',$data);
      }


      public function save()
      {

        $sub_array = array();

        $PROCESS_ID=$this->input->post('PROCESS_ID');
        $SERVICE_ID=$this->input->post('SERVICE_ID');
        $POSTE_ID=$this->input->post('ID_POSTE');
       // $STAGE_ID=$this->input->post('STAGE_ID');


        $don=$this->Model->getOne('pms_service',array('SERVICE_ID'=>$SERVICE_ID));





        $crit='';
        if (!empty($PROCESS_ID)) 
        {
        $crit=' and pms_process_stage.PROCESS_ID='.$PROCESS_ID.'';
        
        }


        $stages=$this->Model->getRequete('SELECT * from pms_stage join pms_process_stage on pms_stage.STAGE_ID=pms_process_stage.STAGE_ID join pms_process on pms_process_stage.PROCESS_ID=pms_process.PROCESS_ID where 1 '.$crit.'  order by DESCRIPTION_STAGE');




        //print_r($test);die();

        $i=0;


        foreach ($stages as $key => $value) 
        {
        $i++;

        if ($this->input->post('stage'.$i.'')!=null) 
        {

        $pro=$this->Model->getOne('pms_process_service',array('ID_PROCESS_STAGE'=>$this->input->post('stg'.$i.''),'ID_POSTE'=>$POSTE_ID));
       

        if (empty($pro)) 
        {
       
        $data_arr=array('ID_PROCESS_STAGE'=>$this->input->post('stg'.$i.''),
                        'ID_POSTE'=>$POSTE_ID);
        //  print_r($this->input->post('stg'.$i.''));die();


         $this->Model->create('pms_process_service',$data_arr);
       
        }

        }
        // else
        // {

        //  $pro=$this->Model->getOne('pms_process_service',array('ID_PROCESS_STAGE'=>$this->input->post('stg'.$i.''),'ID_POSTE'=>$POSTE_ID));

        // $this->Model->delete('pms_process_service',array('ID_PROCESS_STAGE'=>$this->input->post('stg'.$i.''),'ID_POSTE'=>$POSTE_ID));

        // }

        



        // $sub_array['stage'.$i.'']=$donne;
        }


        $data['message']='<div class="alert alert-success text-center" id="message">L\'enregistrement des droits faite avec succés</div>';
        $this->session->set_flashdata($data);





        redirect(base_url('administration/Droits/liste'));
      }


     function liste()
     {
     $data['process']=$this->Model->getRequete('SELECT * from pms_process order by DESCRIPTION_PROCESS');

     $data['service']=$this->Model->getRequete('SELECT * from pms_service order by DESCRIPTION');


     $this->load->view('Droits_List_View',$data);

     }


    function get_liste()
    {
     $SERVICE_ID=$this->input->post('SERVICE_ID');

     $PROCESS_ID=$this->input->post('PROCESS_ID');
      
     $ID_POSTE=$this->input->post('ID_POSTE');
      

      $crit='';


      if (!empty($SERVICE_ID))
      {
      $crit.=' and pms_poste_service.ID_SERVICE='.$SERVICE_ID.'';
      }

       if (!empty($PROCESS_ID))
      {
      $crit.=' and pms_process_stage.PROCESS_ID='.$PROCESS_ID.'';
      }

       if (!empty($ID_POSTE))
      {
      $crit.=' and pms_poste_service.ID_POSTE='.$ID_POSTE.'';
      }

    

      $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
          $var_search=str_replace("'", "\'", $var_search);
      $limit='LIMIT 0,10';

      if($_POST['length'] != -1) 
      {
        $limit='LIMIT '.$_POST["start"].','.$_POST["length"];
      }

        
      $query_principal="SELECT pms_process_service.PROCESS_SERVICE_ID,pms_process.DESCRIPTION_PROCESS,pms_service.DESCRIPTION,CONCAT( '<b>',pms_stage.DESCRIPTION_STAGE, '</b>', '<b> (', UPPER(pms_poste_service.POSTE_DESCR),')</b>') stage FROM pms_process join pms_process_stage on pms_process.PROCESS_ID=pms_process_stage.PROCESS_ID JOIN pms_stage on pms_stage.STAGE_ID=pms_process_stage.STAGE_ID join pms_process_service on pms_process_service.ID_PROCESS_STAGE=pms_process_stage.ID_PROCESS_STAGE join pms_poste_service on pms_poste_service.ID_POSTE=pms_process_service.ID_POSTE join pms_service on pms_poste_service.ID_SERVICE=pms_service.SERVICE_ID WHERE 1 ".$crit."";


      //print_r($query_principal);die();
   
   
      
         
       $order_by='';

       $order_column=array('pms_poste_service.POSTE_DESCR','pms_process.DESCRIPTION_PROCESS','pms_service.DESCRIPTION','pms_stage.DESCRIPTION_STAGE');
   
       $order_by = isset($_POST['order']) ? ' ORDER BY '.$order_column[$_POST['order']['0']['column']] .'  '.$_POST['order']['0']['dir'] : ' ORDER  BY pms_stage.DESCRIPTION_STAGE  ASC';
     

     $search = !empty($_POST['search']['value']) ? (" AND (pms_poste_service.POSTE_DESCR LIKE '%$var_search%' or pms_process.DESCRIPTION_PROCESS LIKE '%$var_search%' or pms_service.DESCRIPTION LIKE '%$var_search%' or pms_stage.DESCRIPTION_STAGE LIKE '%$var_search%' )") : '';


      $critaire="";

      $query_secondaire=$query_principal.' '.$critaire.' '.$search.' '.$order_by.' '.$limit;
      
      $query_filter = $query_principal.' '.$critaire.' '.$search;

      $fetch_data= $this->Model->datatable($query_secondaire);

      $data = array();
      $u=0;

     

      foreach ($fetch_data as $row) 
       {
             

             $interval = 5;



        $u++;


       

        $sub_array = array();

       // $proces=$this->Model->getOne('pms_process',array('PROCESS_ID'=>$row->PROCESS_ID));


        // $sub_array[]=$u; ('.$proces['DESCRIPTION_PROCESS'].')
        $sub_array[]='<center><font color="#000000" size=2><label>'.$row->DESCRIPTION_PROCESS.'</label></font> </center>';
        $sub_array[]='<center><font color="#000000" size=2><label>'.$row->DESCRIPTION.'</label></font> </center>';

         $sub_array[]='<center><font color="#000000" size=2>'.$row->stage.'</font><center>';
       
     

        $option = '<a  href="#"  data-toggle="modal" data-target="#mystatut'.$row->PROCESS_SERVICE_ID.'" title="Supprimer"  class="btn btn-danger"> <span class="fa fa-trash"></span></a>


          <div class="modal fade" id="mystatut' . $row->PROCESS_SERVICE_ID . '" >
                            <div class="modal-dialog modal-lg">
                              <div class="modal-content">
                                <div class="modal-body">
                                  <h5>Supprimer le droit '.$row->stage.' ?</h5> 
                                </div>

                                
                                <div class="modal-footer">
                                  <a class="" href="' . base_url('administration/Droits/delete/'.$row->PROCESS_SERVICE_ID) . '"><span class="mode mode_on">SUPPRIMER</span></a>
                                  <a class="" href="#" class="close" data-dismiss="modal"><span class="mode mode_process">QUITTER</span></a>
                              </div>

                              </div>
                            </div>
                          </div>';
       
        
        
        $sub_array[]=$option;

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


      public function delete($id='')
      {
       $this->Model->delete('pms_process_service',array('PROCESS_SERVICE_ID'=>$id));

       $data['message']='<div class="alert alert-success text-center" id="message">La suppression du droit faite avec succés</div>';
        $this->session->set_flashdata($data);

       redirect(base_url('administration/Droits/liste'));
      }

    
    }

    ?>