<!DOCTYPE html>
<html lang="en">
<head>
  <?php include VIEWPATH.'includes/header.php'; ?>


  <style>
    fieldset.scheduler-border 
    {
      border: 1px groove #ddd !important;
      padding: 0 1.4em 1.4em 1.4em !important;
      margin: 0 0 1.5em 0 !important;
      -webkit-box-shadow:  0px 0px 0px 0px #000;
      box-shadow:  0px 0px 0px 0px #000;
    }

    legend.scheduler-border {
     font-size: 1.2em !important;
     font-weight: bold !important;
     text-align: left !important;
   }
   .table td { 
    vertical-align: middle;
    border: 1px solid #DFE0E0; 
    text-align: center;
    padding: 10px;
  }

</style>
</head>



<body class="dashboard dashboard_1">
  <div class="full_container">
    <div class="inner_container">

      <!-- Sidebar session FLASH -->
      <?php include VIEWPATH.'includes/navybar.php'; ?> 
      <!-- right content -->
      <div id="content">
        <!-- topbar -->
        <?php include VIEWPATH.'includes/topbar.php'; ?> 
        <!-- end topbar -->
        <!-- dashboard inner -->
        <div class="midde_cont">
          <div class="container-fluid" style="padding:5px;">

           <!--  ID_ACTION -->
           <?php

           $menu1="nav-link active";
           $menu2="nav-link";
           $menu3="nav-link";
           $menu4="nav-link";
           $menu5="nav-link";
           $menu6="nav-link";
           $menu7="nav-link";
           ?>
           <br>

           <div class="row column1" >
            <!-- <div class="row"> -->
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="col-md-6 pull-left">
                          <button class="btn btn-dark" onclick="history.go(-1)">
                            <?php 
                            if($this->uri->segment(5)>0){
                              ?>
                              <i class="fa fa-times" aria-hidden="true"></i>&nbsp;<?=lang('btn_ferme')?> 
                              <?php

                            }else{
                              ?>
                              <i class="fa fa-reply-all" aria-hidden="true"></i>&nbsp;<?=lang('button_retour')?>
                              <?php
                            }
                            ?>

                          </button>
                        </div>

                        <div class="col-md-3">

                        </div>

                        <div class="col-md-3 d-flex justify-content-end">
                
                          <a href="<?=base_url('administration/Tarif/')?>" class="btn btn-info">Liste
                          </a>
                         
                        </div>
                      </div>



                    </div>
                  </div>
                  <?=$this->session->flashdata('message')?> 
                  <div class="card-body" style="padding: 5px;">





                        <form class="form-horizontal" method="post" id="myform" action="<?php echo base_url('administration/Tarif/save')?>">
                    
                    <div class="row">
                          
                          <div class="form-group col-md-6">
                            <label for="exampleInputEmail1"><b>Description du processus</b></label>
                            <input type="text" name="DESCRIPTION_TARIF" value="<?=set_value('DESCRIPTION_TARIF')?>" class="form-control">  
                            <?php echo form_error('DESCRIPTION_TARIF', '<div class="text-danger">', '</div>'); ?>                                           
                          </div>




                          <div class="form-group col-md-6">
                            <label for="exampleInputEmail1"><b>Montant tarif</b></label>
                            <input type="number" name="MONTANT_TARIF" value="<?=set_value('MONTANT_TARIF')?>" class="form-control">  
                            <?php echo form_error('MONTANT_TARIF', '<div class="text-danger">', '</div>'); ?>                                           
                          </div>

                          <button type="submit" class="btn btn-primary">Submit</button>

                    </div>

                        </form>




</div>
</div>
</div>
<!-- </div> -->


 


</div>


</div>
</div>











</body>
</html>

<?php include VIEWPATH.'includes/scripts_js.php'; ?>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>


<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
















