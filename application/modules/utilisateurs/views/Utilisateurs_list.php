<!DOCTYPE html>
<html lang="en">
<head>
 <?php include VIEWPATH.'includes/header.php'; ?>

 <style type="text/css">

   .nav-pills .nav-link.active, .nav-pills .show>.nav-link {
    color: #fff;
    background-color: #17a2b8;
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
     <!-- jQuery FIRST -->
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

     <!-- Select2 AFTER -->
     <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
     <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

     <!-- Pour les traductions -->
     <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/i18n/fr.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>



     <div class="midde_cont" >
      <div class="container-fluid">
        <div class="row column_title">
          <div class="col-md-12">
           <div class="page_title">

            <div class="row">
              <div class="col-md-6">
                <h2>
                  <i class="fa fa-bars" aria-hidden="true"></i> Utilisateurs
                </h2>
              </div>
              <div class="col-md-3">
              </div>
              <div class="col-md-3">

                <!-- Split button -->
                <div class="btn-group">
                  <a href="<?= base_url('utilisateurs/Utilisateurs/nouveau') ?>" class="btn btn-success">
                      <i style="color: white" class="fa fa-plus" aria-hidden="true"></i>
                      <label id="tasks_number"></label> Nouvel utilisateur
                    </a>

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
              <div class="col-md-12">

                <?=$this->session->flashdata('message')?>
                
              </div> 




              <div class="col-md-2"></div>

            </div>




            <div class="row">
             <div class="col-lg-12">


              <div class="tab-content" id="nav-tabContent">

                <!-- Modal  pour validation des données -->
                <div class="modal fade" id="docmodal" tabindex="-1"
                aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
                <div class='modal-dialog' style ="max-width: 50%;">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title text-white" id="exampleModalLabel">Activer/Désactiver l'utilisateur &nbsp;<a id="user_info"></a>
                      </h5>
                    </div>
                    <form id="Forminfo" enctype="multipart/form-data" method="post"
                    style="margin-left:12px" action="<?= base_url('/Utilisateurs/activer_desactiver') ?>" name="Forminfo">
                    <div class="modal-body">
                      <input type="hidden" name="user_id" id="user_id">
                      <div class="row">

                        <div class='col-md-6'>     
                          <label for='STATUT_DES'>Status<font color='red'>*</font></label>
                          <select name='STATUT_DES' id='STATUT_DES'
                          class='form-control'>
                          <option value="">_</option>
                          <option value="1">Activer</option>
                          <option value="0">Désactiver</option>
                        </select>
                        <div class='text-danger' id='errorSTATUT_DES'></div>
                      </div>

                      <div class='col-md-6'>     
                        <label for='MOTIF'>Motif<font color='red'>*</font></label>
                        <textarea name='MOTIF' id='MOTIF' class='form-control'></textarea>
                        <div class='text-danger' id='errorMOTIF'></div>
                      </div>
                    </div>
                  </div>

                </form>
                <div class="modal-footer">
                  <input class="btn btn-secondary" type="button" id="btn_add"
                  value="Enregistrer" onclick="save_traiter();" />
                  <input type="button" class="btn btn-default" data-dismiss="modal"
                  onclick="hide_modal()"  value="Fermer" />
                </div>
              </div>
            </div>
          </div>   <!-- end --> 


          <div class="full price_table padding_infor_info">


           <br>
           <table id='mytable' class="table table-sm table-bordered table-hover table-striped" 
           data-toggle="table" data-search="true" data-show-columns="true" data-pagination="true">
           <thead> 
            <tr>
              <th width="10" scope='col'>#</th>
              <th width="40" scope='col'>Nom</th>
              <!-- <th width="25" scope='col'>E-mail</th> -->
              <!-- <th width="20" scope='col'>Téléphone</th> -->
              <th width="40" scope='col'>Profile</th>
              <!-- <th width="10" scope='col'>Etat</th> -->
              <th width="20" scope='col'>Action</th>
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
</div>
</div>



</div>
<!-- end dashboard inner -->
</div>
</div></div></div>

<?php include VIEWPATH.'includes/scripts_js.php'; ?>


</body>
</html>

<script type="text/javascript">

  function get_traiter(id, info) {
    // Affiche les données dans le modal
    $('#is_active').val(id);        // Champ caché ou input pour l'ID
    $('#user_info').html(info);     // Texte affiché dans le modal

    // Ouvre le modal
    $('#docmodal').modal('show');
  }

</script>
<script>
 $(document).ready(function(){
   $('#message').delay('slow').fadeOut(3000);
   get_liste();

 </script>

 <script type="text/javascript">
  function save_traiter(){
   var status = 1;
   if ($("#STATUT_DES").val() == "") {
    $("#errorSTATUT_DES").html("Ce champ est obligatoire");
    status= 0;
  } else {
    $("#errorSTATUT_DES").html("");
  }

  if ($("#MOTIF").val() == "") {
    $("#errorMOTIF").html("Ce champ est obligatoire");
    status= 0;
  } else {
    $("#errorMOTIF").html("");
  }

  if(status == 1){
    document.getElementById("Forminfo").submit();
    $('#btn_add').prop('disabled', true);
  }
}



function get_traiter(id, info) {
    // Affiche les données dans le modal
    $('#is_active').val(id);        // Champ caché ou input pour l'ID
    $('#user_info').html(info);     // Texte affiché dans le modal

    // Ouvre le modal
    $('#docmodal').modal('show');
  }

</script>
<script>
 $(document).ready(function(){
   $('#message').delay('slow').fadeOut(3000);


    // $('#tasks_number').html(tasks_number);

    get_liste();


  }); 

</script>
<script type="text/javascript">
  $(document).ready(function() {
      // Initialize tab functionality
      $('.nav-link').on('click', function() {
        $('.nav-link').removeClass('active');
        $(this).addClass('active');
        var target = $(this).data('target');
        $('.tab-pane').removeClass('show active');
        $(target).addClass('show active');
      });
    });
  </script>
  <script type="text/javascript">

    function get_liste() { 



      var USER_BACKEND_ID=$('#USER_BACKEND_ID').val();
      var row_count ="1000000"; 
      $("#mytable").DataTable({      
        "destroy" : true,
        "processing":true,
        "serverSide":true,
        "responsive": true,

        "order":[[0, 'asc' ]],
        "ajax":{
          url:'<?=base_url()?>utilisateurs/Utilisateurs/listing',
          data:{
          },
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
        'csv', 'excel', 'pdf', 'print'
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
