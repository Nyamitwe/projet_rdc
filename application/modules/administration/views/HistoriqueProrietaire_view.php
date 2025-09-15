<!DOCTYPE html>
<html lang="en">
<head>
  <?php include VIEWPATH.'includes/header.php'; ?>

  <style type="text/css">

    .nav-pills .nav-link.active, .nav-pills .show>.nav-link {
      color: #fff;
      background-color: #17a2b8;
    }


    .table-responsive {
      overflow-x: auto;
      max-width: 100%;
    }
  </style>
  <style>
  #mytable1 td {
    text-align: left !important;
  }
</style>

</head>
<body class="dashboard dashboard_1">
  <div class="full_container">
    <div class="inner_container">
      <!-- Sidebar  -->
      <?php include VIEWPATH.'includes/navybar.php'; ?> 
      <div id="content">
        <!-- topbar -->
        <?php include VIEWPATH.'includes/topbar.php'; ?> 
        <div class="midde_cont" >
          <div class="container-fluid">
            <div class="row column_title">
              <div class="col-md-12">
                <div class="page_title">

                  <div class="row">
                    <div class="col-md-6">
                      <h2>
                        <i class="fa fa-bars" aria-hidden="true"></i> 
                        Historique des propriétés
                      </h2>
                    </div>
                    <div class="col-md-4">
                    </div>
                    <div class="col-md-2">
                     <button 
                     type="button" 
                     onclick="window.location.href='<?= base_url('administration/Numeriser_New/list') ?>'" 
                     class="btn" 
                     style="background-color:#1b5c6e; color:white; border:1px solid #020f12;"
                     >
                     <i class="fa fa-list"></i> Retour à la liste
                   </button>
                   <div class="btn-group">
                   </div>
                 </div>
               </div>
             </div>
           </div>
         </div>


         <div class="row">
           <div class="col-md-12">
             <div class="white_shd full margin_bottom_30">
               <div class="full graph_head">
                 <div class="heading1 margin_0">
                   <div class="row">
                     <div class="col-md-12 text-right"> 

                     </div>
                   </div>
                   <input type="hidden" value="<?=$ID_REQUERANT ?>" name="ID_REQUERANT" id="ID_REQUERANT" >
                   <input type="hidden" value="<?=$ID_ATTRIBUTION ?>" name="ID_ATTRIBUTION" id="ID_ATTRIBUTION" >
                   <div class="full price_table padding_infor_info">
                     <div class="table-responsive" style="overflow: auto;">
                      <table id="mytable" class="table table-bordered table-striped table-hover table-responsive" cellspacing="0" width="100%">
                        <thead class="">
                          <tr>
                            <th scope="col" class="text-left">#</th>
                            <th scope="col" class="text-left">Numéro de parcelle</th>
                            <th scope="col" class="text-left">Nom et prénom</th>
                            <th scope="col" class="text-left">Type de parcelle</th>
                            <th scope="col" class="text-left">Usage</th>
                            <th scope="col" class="text-left">Volume</th>
                            <th scope="col" class="text-left">Folio</th>
                            <th scope="col" class="text-left">Nbre des anciens propriétaires</th>
                          </tr>
                        </thead>
                        <tbody class="text-left"></tbody>
                      </table>

                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>

        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header" style="background: #1b7a6c;">
                <h5 class="modal-title text-white" id="staticBackdropLabel">Liste des anciens propriétaires</h5>
                <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="full price_table padding_infor_info modal-body">
                <div class="table-responsive" style="overflow: auto;">
                  <table id='mytable1' class="table table-bordered table-striped table-hover table-responsive" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th  class="th-sm  text-black">#</th>
                        <th  class="th-sm  text-black text-center">Nom&nbsp;et&nbsp;prénom&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                        <th  class="th-sm  text-black">CNI/RC&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                        <th  class="th-sm  text-black">Volume</th>
                        <th  class="th-sm  text-black">Folio</th>
                        <th  class="th-sm  text-black">Motif&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- end dashboard inner -->
</div>
</body>

<?php include VIEWPATH.'includes/scripts_autre_js.php'; ?>

</body>
</html>




<script>

  $('#message').delay('slow').fadeOut(300000);
  $(document).ready(function()
  {
    liste()
    
  });
</script>

<script>
  function liste()
  {
    var row_count ="1000000";
    var ID_REQUERANT = $('#ID_REQUERANT').val();
    var ID_ATTRIBUTION = $('#ID_ATTRIBUTION').val();
    $("#mytable").DataTable({
      "processing":true,
      "destroy" : true,
      "serverSide":true,
      "oreder":[[ 0, 'desc' ]],
      "ajax":{
        url:"<?php echo base_url('administration/Numeriser_New/listing_historique/');?>",
        type:"POST",
        data:{
         ID_REQUERANT:ID_REQUERANT,
         ID_ATTRIBUTION:ID_ATTRIBUTION
       } 
     },
     lengthMenu: [[5,10,50, 100, -1], [5,10,50, 100, "All"]],
     pageLength: 5,
     "columnDefs":[{
      "targets":[],
      "orderable":false
    }],
    dom: 'Bfrtlip',
    buttons: ['csv', 'excel', 'pdf' ],
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

  }
</script>

<script>
  function show_list(id)
  {
    list_info_parcelle(id);
    $('#staticBackdrop').modal('show');
  }
</script>
<script>
  function show_list(id)
  {
    list_info_parcelle(id);
    $('#staticBackdrop').modal('show');
  }
</script>
<!-- affichage info parcelle -->
<script>
  function list_info_parcelle(id)
  {
    var row_count ="1000000";
    $("#mytable1").DataTable({
      "processing":true,
      "destroy" : true,
      "serverSide":true,
      "oreder":[[ 0, 'desc' ]],
      "ajax":{
        url:"<?php echo base_url('administration/Numeriser_New/listing_historique_ancien/');?>"+id,
        type:"POST", 
      },
      lengthMenu: [[5,10,50, 100, -1], [5,10,50, 100, "All"]],
      pageLength: 5,
      "columnDefs":[{
        "targets":[],
        "orderable":false
      }],
      dom: 'Bfrtlip',
      buttons: ['csv', 'excel', 'pdf' ],
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
  }    
</script>
