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
          <div class="container-fluid">
            <div class="row column_title">
              <div class="col-md-12">
                <div class="page_title">
                  <div class="row">
                    <div class="col-md-6">
                      <h2>
                        <i class="fa fa-bars" aria-hidden="true"></i> <?= lang('requerant_parcel') ?>
                      </h2>
                    </div>
                    <div class="col-md-4">
                    </div>
                    <div class="col-md-2">
                     <button 
                     type="button" 
                     onclick="window.location.href='<?= base_url('administration/Numeriser_New/') ?>'" 
                     class="btn" 
                     style="background-color:#1b5c6e; color:white; border:1px solid #020f12;"
                     >
                     <i class="fa fa-plus"></i> <?=lang('titre_btn_nouvelle')?>
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
                  <div class="full price_table padding_infor_info">                      
                    <?php if (!empty($message)) : ?>
                    <div class="alert alert-success text-center" id="message"><?php echo $message; ?></div>
                    <?php endif; ?>
                    <div class="table-responsive" style="overflow: auto;">
                      <table id='mytable' class="table table-bordered table-striped table-hover table-responsive" cellspacing="0" width="100%">
                        <thead>
                          <tr>
                            <th scope="col"><center>#</center></th>
                            <th ><center><?=lang('label_nom_users')?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</center></th>
                            <th scope='col'><center><?=lang('label_users')?></center></th>
                            <th scope='col'><center><?=lang('profil')?></center></th>
                            <th scope='col'><center><?=lang('nombre_parcelle')?></center></th>
                            <th scope='col'><center><?=lang('titre_table_action')?>
                              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            </center></th>
                          </tr>
                        </thead>
                        <tbody></tbody>
                      </table>
                    </div>
                  </div>
                </div>
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

<!-- Modal : envoyer le requerant dans bps -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="background: #1b7a6c;">
        <h5 class="modal-title text-white" id="staticBackdropLabel"><?=lang('liste_parcelle')?></h5>
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
                <th  class="th-sm  text-black"><?=lang('label_parcelle_number')?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th  class="th-sm  text-black">Type</th> 
                <th  class="th-sm  text-black"><?=lang('label_usage')?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th  class="th-sm  text-black"><?=lang('localite_labelle')?></th>
                <th  class="th-sm  text-black"><?=lang('detail')?></th>
                <th  class="th-sm  text-black"><?=lang('titre_table_action')?></th>
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

<?php include VIEWPATH.'includes/scripts_autre_js.php'; ?>
</body>
</html>

<script>
  $('#message').delay('slow').fadeOut(300000);
  $(document).ready(function()
  {
    list_info_requerant();  
  });

  function list_info_requerant()
  {
    var row_count ="1000000";
    $("#mytable").DataTable({
      "processing":true,
      "destroy" : true,
      "serverSide":true,
      "oreder":[[ 0, 'desc' ]],
      "ajax":{
        url:"<?php echo base_url('administration/Numeriser_New/listing/');?>",
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

  function show_list(id)
  {
    list_info_parcelle(id);
    $('#staticBackdrop').modal('show');
  }

  function list_info_parcelle(id)
  {
    var row_count ="1000000";
    $("#mytable1").DataTable({
      "processing":true,
      "destroy" : true,
      "serverSide":true,
      "oreder":[[ 0, 'desc' ]],
      "ajax":{

        url:"<?php echo base_url('administration/Numeriser_New/listing1/');?>"+id,
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

