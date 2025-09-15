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
                        <i class="fa fa-bars" aria-hidden="true"></i><?=lang('requerant_parcel')?>
                      </h2>
                    </div>
                    <div class="col-md-3">
                    </div>
                    <div class="col-md-3">

                      <!-- Split button -->
                      <div class="btn-group">

                      </div>




                    </div>
                  </div>

                </div>
              </div>
            </div>

            <?php

              $menu1="nav-link active";
              $menu2="nav-link";
              $menu3="nav-link";
              $menu4="nav-link";
              $menu5="nav-link";
              $menu6="nav-link";




            ?>


            <div class="row">
              <div class="col-md-12">
                <div class="white_shd full margin_bottom_30">
                  <div class="full graph_head">
                    <div class="heading1 margin_0">
                      <div class="row">
                        <div class="col-md-12 text-right"> <!-- Add 'text-right' class here -->

                        </div>
                      </div>

                    <div class="full price_table padding_infor_info">
<!--                       <div><?=$this->session->flashdata('message')?></div> -->                      
                      <?php if (!empty($message)) : ?>
                        <div class="alert alert-success text-center" id="message"><?php echo $message; ?></div>
                      <?php endif; ?>
                      <div class="table-responsive" style="overflow: auto;">
                        <table id='mytable' class="table table-bordered table-striped table-hover table-responsive-sm" cellspacing="0" width="100%">
                          <thead>
                            <tr>
                              <th scope="col"><center>#</center></th>
                              <th scope='col'><center><?=lang('titre_num_parcelle')?></center></th>
                              <th scope='col'><center><?=lang('requerant')?></center></th>
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



<?php include VIEWPATH.'includes/scripts_autre_js.php'; ?>


</body>
</html>




<script>

  $('#message').delay('slow').fadeOut(300000);
  $(document).ready(function()
  {
    list_info_requerant();
    
  });
</script>

<script>
  function list_info_requerant()
  {
    var row_count ="1000000";

    $("#mytable").DataTable({
      "processing":true,
      "destroy" : true,
      "serverSide":true,
      "oreder":[[ 0, 'desc' ]],
      "ajax":{
        url:"<?php echo base_url('administration/Parcelle/list/');?>",
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

