<!DOCTYPE html>
<html lang="en">
<head>
   <?php include VIEWPATH.'includes/header.php'; ?>

   <style type="text/css">
      .my-card
      {
        position:absolute;
        left:40%;
        top:-20px;
        border-radius:50%;
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

        <!-- Sidebar  -->
        <?php include VIEWPATH.'includes/navybar.php'; ?> 
        <!-- end sidebar -->


        <!-- right content -->
        <div id="content">
           <!-- topbar -->
           <?php include VIEWPATH.'includes/topbar.php'; ?> 
           <!-- end topbar -->
           <!-- dashboard inner -->
           <div class="midde_cont" >
              <div class="container-fluid" style="padding: 5px;">
                  <br>
                  <br>
                 <!-- row -->

                 <?php

                 $menu1="nav-link active";
                 $menu2="nav-link";
                 $menu3="nav-link";
                 $menu4="nav-link";
                 $menu5="nav-link";
                 $menu6="nav-link";



                 ?>


                   <!-- </div> -->

                   <div class="row column1">
                     <div class="col-md-12">
                        <div class="white_shd full margin_bottom_30">
                          <div class="full graph_head">
                              <div class="heading1 margin_0">
                    <h2><?= $title?></h2>
                </div>
                <div class="" ></div>
            </div>
                      <div class="full price_table padding_infor_info">
                       <div class="row">
                       <div class="col-lg-12">
                   <!-- <div class="table-responsive-sm"> -->
                     <table id='mytable' class="table table-sm table-bordered table-hover table-striped" data-toggle="table" data-search="true" data-show-columns="true" data-pagination="true">
                                      <thead  class="font-weight-bold text-nowrap">
                                          <tr>
                                             <th  class="th-sm  text-center">#</th>
                                             <th  class="th-sm  text-center">NOM</th>
                                             <th  class="th-sm  text-center">CONTACT</th>
                                             <th  class="th-sm  text-center">QUALITE</th>
                                             <th  class="th-sm  text-center">SHIFT</th>
                                             <th class="th-sm  text-center">ACTIVITE</th> 
                                             <th class="th-sm  text-center">DATE</th> 

                                            </tr>
                                   </thead>

                                   <tbody> </tbody>

                                </table> 
            <!--   </div> -->
          </div>
          </div>
      </div>
  </div>
              </div>
              <!-- end row -->
           </div>
         
        </div>
        <!-- end dashboard inner -->
     </div>
  </div></div></div>

  <?php include VIEWPATH.'includes/scripts_js.php'; ?>


</body>
</html>


<script>
   $(document).ready(function(){

      get_liste();

   }); 

   
</script>
<script type="text/javascript">

 function get_liste() { 

  
    var row_count ="1000000"; 
    $("#mytable").DataTable({      
      "destroy" : true,
      "processing":true,
      "serverSide":true,
      "order":[[0, 'desc' ]],
      "ajax":{
       url:'<?=base_url()?>PresenceNumerisation/liste/',
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

    dom: 'Bfrtlip',
    buttons: [ 'copy', 'csv', 'excel', 'pdf', 'print'  ],
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
        "sNext":       "<?=lang('datatable_suivant') ?>",
        "sLast":       "<?=lang('datatable_dernier') ?>"
     },
     "oAria": {
        "sSortAscending":  ": <?=lang('datatable_ordre_croissant') ?>",
        "sSortDescending": ": <?=lang('datatable_ordre_decroissant') ?>"
     }
  }
});
 }
</script>