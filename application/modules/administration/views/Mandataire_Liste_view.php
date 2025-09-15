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

    <style type="text/css">

  input[type=checkbox] {
    transform: scale(1.5);
  }

  input[type=checkbox] {
    width: 30px;
    height: 30px;
    margin-right: 8px;
    cursor: pointer;
    font-size: 17px;
    visibility: hidden;
  }

  input[type=checkbox]:after {
    content: " ";
    background-color: #fff;
    display: inline-block;
    margin-left: 10px;
    padding-bottom: 5px;
    color: #00BFF0;
    width: 22px;
    height: 25px;
    visibility: visible;
    border: 1px solid #00BFF0;
    padding-left: 3px;
    border-radius: 5px;
  }

  input[type=checkbox]:checked:after {
    content: "\2714";
    padding: -5px;
    font-weight: bold;
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
                        <!-- <i class="fa fa-bars" aria-hidden="true"></i> <?= lang('requerant_parcel') ?> -->
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

                          <!--<a href="<?=base_url('administration/Numerisation')?>" class="btn btn-success">
                            <?=lang('titre_btn_nouvelle')?>
                          </a>  -->


                        </div>
                      </div>



                    <div class="full price_table padding_infor_info ">                 
                      <?php if (!empty($message)) : ?>
                        <div class="alert alert-success text-center" id="message"><?php echo $message; ?></div>
                      <?php endif; ?>
                      <div class="table-responsive" style="overflow: auto;">

                        <input type="hidden" name="num_parcel" id="num_parcel">
                        <table id='mytable' class="table table-bordered table-striped table-hover table-responsive" cellspacing="0" width="100%">
                          <thead>
                            <tr>
                              <th scope="col"><center>#</center></th>
                              <th scope='col'><center><?=lang('label_nom_users')?></center></th>
                              <th scope='col'><center><?=lang('label_users')?></center></th>
                              <!-- <th scope='col'><center>Statut</center></th> -->
                              <th scope='col'><center><?=lang('nombre_parcelle')?></center></th>
                              <!-- <th scope='col'><center><?=lang('titre_table_action')?></center></th> -->
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


<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?=lang('liste_parcelle')?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="col-lg-12 table-responsive" style="padding: 5px">
          <!-- <div><?=$this->session->flashdata('message')?></div> -->
          <table id="mytable1" class="display" style="width:100%">
            <thead>
              <tr>
                <th  class="th-sm  text-black">#</th>
                <th scope='col'><?=lang('label_parcelle_number')?></th>
                <th scope='col'><?=lang('label_usage')?></th>
                <th scope='col'><center>Localité</center></th>
                <th scope='col'>Statut</th>
                <!-- <th  class="th-sm  text-black"><?=lang('detail')?></th> -->
                <th  scope='col'><?=lang('titre_table_action')?></th> 
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


<!-- Modal -->
<div class="modal fade" id="staticBackdrop2" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header " style="background-color: #00004d;color: white">
        <h5 class="modal-title text-white" id="staticBackdropLabel"><center>Statut</center></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="background-color: #ddd5d5;">
        <div class="col-lg-12 table-responsive" style="padding: 5px">
          <!-- <div><?=$this->session->flashdata('message')?></div> -->
          <form name="myform" method="post" class="form-horizontal" action="<?= base_url('administration/Mandataire/update_statut'); ?>"  enctype="multipart/form-data">
            <input type="hidden" name="num_parcel2" id="num_parcel2">
            <input type="hidden" name="id2" id="id2">
           <div class="form-group col-lg-12">
             <div class="row">
              <div class="col-md-12"><br>
                <label style="font-size: 10px;color: red"><b>Décocher pour désactiver</b></label><br>
            <input type="checkbox" value="1"  name="STATUT" checked >
            
          </div>
          <div class="col-md-12">
           <button type="submit" style="float: right;margin: 10px;font-size: 10px;" class="btn btn-primary" id="btn_save" onclick="savedata()"> <i class="fa fa-save" aria-hidden="true"></i>&nbsp;Valider</button> 
        </div>

        </form>
    <br><br>

  </div>
        </div>
      </div>

    </div>
  </div>
</div>

<?php include VIEWPATH.'includes/scripts_autre_js.php'; ?>


</body>
</html>

<script type="text/javascript">
  function savedata(argument) {
    
  }
</script>


<script>

  $('#message').delay('slow').fadeOut(300000);
  $(document).ready(function()
  {
    liste();
    
  });
</script> 

<script>
  function liste()
  {
    var row_count ="1000000";

    $("#mytable").DataTable({
      "processing":true,
      "destroy" : true,
      "serverSide":true,
      "oreder":[[ 0, 'desc' ]],
      "ajax":{
        url:"<?php echo base_url('administration/Mandataire/listing/');?>",
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

<script>
  function show_list(id,NUMERO_PARCELLE)
  {
    // alert();
        // var parcel = NUMERO_PARCELLE
        $("#num_parcel").val(NUMERO_PARCELLE);
// alert(parcel)
    liste_parcel(id);
    $('#staticBackdrop').modal('show');
  }

  function show_activer(id,NUMERO_PARCELLE)
  {
    // alert();
    // var parcel = NUMERO_PARCELLE;
     $("#num_parcel").val(NUMERO_PARCELLE);
     $("#num_parcel2").val(NUMERO_PARCELLE);
     $("#id2").val(id);

// alert(parcel)
    // liste_parcel(id);
    $('#staticBackdrop2').modal('show');
  }
</script>
<!-- affichage info parcelle -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/blueimp-md5/2.19.0/js/md5.min.js"></script>
<script>
  function liste_parcel(id,NUMERO_PARCELLE,)
  {
    var parcel = md5($("#num_parcel").val());
     // var parc = $("#num_parcel").val();
     //  var parcel = parc.replace(/-/g, "__");
//     var parcel = NUMERO_PARCELLE2
// alert(parcel)
    var row_count ="1000000";
    $("#mytable1").DataTable({
      "processing":true,
      "destroy" : true,
      "serverSide":true,
      "oreder":[[ 0, 'desc' ]],
      "ajax":{
        url:"<?php echo base_url('administration/Mandataire/listing1/');?>"+id +'/'+parcel,
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
