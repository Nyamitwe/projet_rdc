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
                      <h2><b><i class="fa fa-server">&nbsp;&nbsp;<?=$title; ?></i></b></h2>
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
                        <div class="col-md-12 text-right">
                        </div>
                      </div>

              <div class="full price_table padding_infor_info" style="padding:2px">

                 <!-- <div class="col-lg-12"> -->
                  <!-- <div class="row">  -->
                    <div class="col-md-5">
                      <label>Processus</label>
                      <select name="PROCESS_ID" id="PROCESS_ID" class="form-control" onchange="get_liste()">
                        <option value="">Sélectionner</option>
                        <?php
                        foreach ($proces as $value) { ?>
                          <option value="<?=$value['PROCESS_ID']?>"><?=$value['DESCRIPTION_PROCESS']?></option>
                          <?php }
                          ?>
                        </select>
                      </div><br>
                      <!-- <div class="col-md-8"></div> -->
                      <style>
                        #mytable th, #mytable td {
                          text-align: left !important;
                          word-wrap: break-word;
                          word-break: break-word;
                          white-space: normal; /* Permet le retour à la ligne */
                          max-width: 200px; /* Limite la largeur des cellules */
                        }
                      </style>

                      <table id="mytable" class="table table-sm table-bordered table-hover table-striped" 
                             data-toggle="table" data-search="true" data-show-columns="true" data-pagination="true">
                        <thead class="font-weight-bold">
                          <tr>
                            <th>Code demande</th>
                            <th>Process</th>
                            <th>Nom</th>
                            <th>Poste</th>
                            <th>Date de Visite</th>


                          </tr>
                        </thead>
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
  <!-- end content table -->

  <?php include VIEWPATH.'includes/scripts_js.php'; ?>

</div>
<!-- end dashboard inner -->



<!-- script pour le modal-->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>


<script>
  $('#message').delay('slow').fadeOut(3000);
  $(document).ready(function(){

    get_liste();   
  });

</script>


<script type="text/javascript">

  function get_liste() { 

    var row_count ="1000000";
    const PROCESS_ID = $('#PROCESS_ID').val(); 
    $("#mytable").DataTable({      
      "destroy" : true,
      "processing":true,
      "serverSide":true,
      "order":[[0, 'desc' ]],
      "ajax":{
        url:'<?=base_url()?>/administration/Affectation/liste/',
        data:{
          PROCESS_ID:PROCESS_ID
        },
        type:"POST",
      },
      lengthMenu: [[10,50, 100, row_count], [10,50, 100, "All"]],
      pageLength: 10,
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

<?php include VIEWPATH.'includes_ep/scripts.php'; ?>

</body>

</html>

