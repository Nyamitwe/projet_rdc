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

                  </div>
                  <?=$this->session->flashdata('message')?> 
                  <div class="card-body" style="padding: 5px;">
                    <div class="row">
                      <div class="col-sm-5">
                        <div class="btn-group mr5 pull-left">
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

                      </div>
                    </div>


                    <div class="row">
 
                     <div class="col-md-12">
                        <input type="hidden" name="id_detail" class="form-control" value="<?=$id?>" id="id_detail">
                      </div>

                    </div>

                    <div class="row">

                      <div class="col-md-12">


                          <table id="mytable" class="table table-hover table-striped table-bordered table-responsive" data-toggle="table" data-search="true" data-show-columns="true" data-pagination="true" style="max-width: 5000px;">
                           <thead  class="font-weight-bold text-nowrap">

                            <tr class="col-lg-12">

                             <th  class="th-sm  text-black text-center">#</th>
                             <th  class="th-sm  text-black text-center">NOM & PRENOM</th>
                             <th  class="th-sm  text-black text-center">GENRE</th>
                             <th  class="th-sm  text-black text-center">Numero d'identification</th>
                             <th  class="th-sm  text-black text-center">Telephone</th>                        
                             <th  class="th-sm  text-black text-center">TYPE DE DEMANDEUR</th>                        
                           </tr>
                         </thead>

                         <tbody>

                         </tbody>

                       </table>
                       
                     </div>
                    </div>

                 </div>





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



<script>
    
   $('#message').delay('slow').fadeOut(3000);
  $(document).ready(function()
  {
    var row_count ="1000000000000";

    var id=$('#id_detail').val();


    $("#mytable").DataTable({
      "processing":true,
      "destroy" : true,
      "serverSide":true,
      "oreder":[[ 0, 'desc' ]],
      "ajax":{
        url:"<?php echo base_url('administration/Notaire_acheteur/listing_detail/');?>"+id,
        type:"POST", 
      },
      lengthMenu: [[5,10,50, 100, row_count], [5,10,50, 100, "All"]],
      pageLength: 5,
      "columnDefs":[{
        "targets":[],
        "orderable":false
      }],

      dom: 'Bfrtlip',
      buttons: [
      'copy', 'csv', 'excel', 'pdf', 'print'
      ],
       language: {
        "sProcessing":     "<?=lang('datatable_traitement') ?>",
        "sSearch":         " <?=lang('datatable_rechercher') ?>",
        "sLengthMenu":     "<?=lang('datatable_afficher') ?> _MENU_ <?=lang('datatable_elements') ?>",
        "sInfo":           "<?=lang('datatable_affichage_elements') ?> _START_ <?=lang('datatable_a') ?> _END_ <?=lang('datatable_sur') ?> _TOTAL_ <?=lang('datatable_elements') ?>",
        "sInfoEmpty":      "<?=lang('datatable_affichage_elements') ?> 0 <?=lang('datatable_a') ?> 0 <?=lang('datatable_sur') ?> 0 <?=lang('datatable_elements') ?>",
        "sInfoFiltered":   "(<?=lang('datatable_filtre') ?> _MAX_ <?=lang('datatable_elements_total') ?>)",
        "sInfoPostFix":    "",
        "sLoadingRecords": "<?=lang('datatable_loading') ?>",
        "sZeroRecords":    "<?=lang('datatable_elements_afficher') ?>",
        "sEmptyTable":     "<?=lang('datatable_donne_disponible') ?>",
        "oPaginate": {
          "sFirst":      "<?=lang('datatable_premier') ?>",
          "sPrevious":   "<?=lang('datatable_precedent') ?>",
          "sNext":       "<?=lang('datatable_suivants') ?>",
          "sLast":       "<?=lang('datatable_dernier') ?>"
       },
       "oAria": {
          "sSortAscending":  ": <?=lang('datatable_ordre_croissant') ?>",
          "sSortDescending": ": <?=lang('datatable_ordre_decroissant') ?>"
       }
    }

    });



  });
    </script>