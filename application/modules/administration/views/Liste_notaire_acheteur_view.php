<!DOCTYPE html>
<html lang="en">
   <head>
   <?php include VIEWPATH.'includes/header.php'; ?>

   <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
   
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
               <div class="midde_cont">
                  <div class="container-fluid" style="padding: 0px;">
                     <br>
                     <br>
                     <!-- row -->
                     <div class="row column1">
                        <div class="col-md-12">
                           <div class="white_shd full margin_bottom_30">
                             <!--  <div class="full graph_head">
                                 <div class="heading1 margin_0">
                                    <h2>Titre de la table</h2>
                                 </div>
                              </div> -->
                        <div class="full price_table padding_infor_info">
                                 
                                 <br><br>  <br>  <br>      
                           <div class="row table-responsive">
                           <div class="col-md-12">
                         <?php echo $this->session->flashdata('message'); ?>
                         <table id="mytable" class="table table-hover table-striped table-bordered table-responsive" data-toggle="table" data-search="true" data-show-columns="true" data-pagination="true" style="max-width:5000px">
                            <thead  class="font-weight-bold text-nowrap">

                             <tr class="col-lg-12">

                              <th  class="th-sm  text-black text-center">#</th>
                              <th  class="th-sm  text-black text-center">Numero Parcelle</th>
                              <th  class="th-sm  text-black text-center">Prix de vente</th>
                              <th  class="th-sm  text-black text-center">Type de Transfert</th>
                              <th  class="th-sm  text-black text-center">Categorie de Transfert</th>
                              <th  class="th-sm  text-black text-center">Type d'Acheteur</th>
                              <th  class="th-sm  text-black text-center">Projet de Vente</th>
                              <th th style="width:30px;"class="th-sm text-black text-center">ACTIONS</th>
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
                        <!-- end row -->
                     </div>
                     <!-- footer -->
                    
                  </div>
                  <!-- end dashboard inner -->
            </div>
             </div></div></div>

 <?php include VIEWPATH.'includes/scripts_js.php'; ?>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

<!--- modal pour inserer un Type de Publicite---->


       
       <script>
    
   $('#message').delay('slow').fadeOut(3000);
  $(document).ready(function()
  {
    var row_count ="1000000000000";

$("#mytable").DataTable({
      "processing":true,
      "destroy" : true,
      "serverSide":true,
      "oreder":[[ 0, 'desc' ]],
      "ajax":{
        url:"<?php echo base_url('administration/Notaire_acheteur/listing/');?>",
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


       
   </body>

 </html>