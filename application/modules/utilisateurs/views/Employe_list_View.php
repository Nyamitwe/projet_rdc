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
                        <i class="fa fa-bars" aria-hidden="true"></i> Liste des employés
                      </h2>
                    </div>
                    <div class="col-md-4">
                    </div>
                    <div class="col-md-2">
                     <button 
                     type="button" 
                     onclick="window.location.href='<?= base_url('utilisateurs/Employe/nouveau') ?>'" 
                     class="btn" 
                     style="background-color:#1b5c6e; color:white; border:1px solid #020f12;"
                     >
                     <i class="fa fa-plus"></i> Nouvel employé
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

                   <div class="col-12">
            <div class="row">
                <div class="col-3">
                  <label>Type de contrat</label>
                  <select class="form-control" name="contrat" id="contrat" onchange="get_liste()">
                    <option value="">Sélectionner</option>
                    <option value="1">CDD</option>
                    <option value="2">CDI</option>
                  </select>
                </div>

                <div class="col-3">
                  <label>Genre</label>
                  <select class="form-control" name="SEXE_ID" id="SEXE_ID" onchange="get_liste()">
                    <option value="">Sélectionner</option>
                    <option value="1">Masculaire</option>
                    <option value="0">Féminin</option>
                  </select>
                </div>

                <div class="col-3">
                  <label>Poste</label>
                  <select class="form-control" name="POSTE_ID"  id="POSTE_ID" onchange="get_liste();">
                        <option value="">Sélectionner</option>
                        <?php foreach($poste_occupe as $poste_occupe) { 
                          if ($poste_occupe['POSTE_ID']==set_value('POSTE_ID')) { 

                            echo "<option value='".$poste_occupe['POSTE_ID']."' > ".$poste_occupe['DESCRIPTION']."</option>"; 
                            
                          }  else{
                            echo "<option value='".$poste_occupe['POSTE_ID']."' > ".$poste_occupe['DESCRIPTION']."</option>"; 
                            
                          } }?>                     

                        </select> 
                </div>

                <div class="col-3">
                  <label>Pays</label>
                  <select class="form-control info_perso_nationalite"  onchange="get_liste();"  name="nationalite_id"  id="nationalite_id">
                        <option value="">Sélectionner</option>
                        <?php foreach($nationalites as $nationalite) { 
                          if ($nationalite['id']==set_value('nationalite_id')) { 

                            echo "<option value='".$nationalite['id']."' selected> ".$nationalite['name']."</option>";
                            
                          }  else{
                            echo "<option value='".$nationalite['id']."' >".$nationalite['name']."</option>"; 

                            
                          } }?>                     

                        </select> 
                </div>


              </div>
              </div>

           <br>
                  <div class="full price_table padding_infor_info">                      
                    <?php if (!empty($message)) : ?>
                    <div class="alert alert-success text-center" id="message"><?php echo $message; ?></div>
                    <?php endif; ?>
                    <div class="table-responsive" style="overflow: auto;">
                      <table id='mytable' class="table table-bordered table-striped table-hover table-responsive" cellspacing="0" width="100%">
                        <thead>
                          <tr>
        <th width="5%">#</th>
        <th width="20%">Nom</th>
        <th width="20%">Contact</th>
        <th width="20%">Poste</th>
        <th width="20%">Contrat</th>
        <!-- <th width="15%">Date recrutement</th> -->
        <!-- <th width="4%">Etat</th> -->
        <th width="15%">Action</th>
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

 <div class="modal fade" id="docmodal" tabindex="-1"
                aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
                <div class='modal-dialog' style ="max-width: 50%;">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title text-white" id="exampleModalLabel">Activer/Désactiver l'employé &nbsp;<a id="user_info"></a>
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
          </div> 

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
          <table id='mytable' class="table table-bordered table-striped table-hover table-responsive" cellspacing="0" width="100%">
            <table id="mytable" class="table table-sm table-bordered table-hover table-striped responsive"
         data-toggle="table"
         data-search="true"
         data-show-columns="true"
         data-pagination="true"
         data-mobile-responsive="true"
         data-min-width="768">
    <thead>
      <tr>
        <th width="2%">#</th>
        <th width="20%">Nom</th>
        <th width="30%">Contact</th>
        <th width="25%">Poste</th>
        <th width="19%">Contrat</th>
        <!-- <th width="15%">Date recrutement</th> -->
        <!-- <th width="4%">Etat</th> -->
        <th width="4%">Action</th>
      </tr>
    </thead>
    <tbody>
      <!-- Tes données ici -->
    </tbody>
  </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<?php include VIEWPATH.'includes/scripts_js.php'; ?>


</body>
</html>


<script>
  $(document).ready(function() {
    $('#message').delay('slow').fadeOut(3000);
    get_liste();
  });


    function get_traiter(id, info) {
      $('#is_active').val(id);
      $('#user_info').html(info);
      // $('#docmodal').modal('show');
      $('#staticBackdrop').modal('show');

    }
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



function get_traiter_(id, info) {
    // Affiche les données dans le modal
    $('#is_active').val(id);        // Champ caché ou input pour l'ID
    $('#user_info').html(info);     // Texte affiché dans le modal

    // Ouvre le modal
    // $('#docmodal').modal('show');
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


      var  contrat = $("#contrat").val();
      var  SEXE_ID = $("#SEXE_ID").val();
      var  POSTE_ID = $("#POSTE_ID").val();
      var  PAYS = $("#nationalite").val();
      // var USER_BACKEND_ID=$('#USER_BACKEND_ID').val();
      var row_count ="1000000"; 
      $("#mytable").DataTable({      
        "destroy" : true,
        "processing":true,
        "serverSide":true,
        "responsive": true,

        "order":[[0, 'asc' ]],
        "ajax":{
          url:'<?=base_url()?>utilisateurs/Employe/listing',
          data:{
            contrat:contrat,
            SEXE_ID:SEXE_ID,
            PAYS:PAYS,
            POSTE_ID:POSTE_ID
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
        "language": {
      "sProcessing": "Traitement en cours...",
      "sSearch": "Rechercher :",
      "sLengthMenu": "Afficher _MENU_ éléments",
      "sInfo": "Affichage de l'élément _START_ à _END_ sur _TOTAL_ éléments",
      "sInfoEmpty": "Affichage de l'élément 0 à 0 sur 0 élément",
      "sInfoFiltered": "(filtré de _MAX_ éléments au total)",
      "sInfoPostFix": "",
      "sLoadingRecords": "Chargement en cours...",
      "sZeroRecords": "Aucun élément à afficher",
      "sEmptyTable": "Aucune donnée disponible dans le tableau",
      "oPaginate": {
        "sFirst": "Premier",
        "sPrevious": "Précédent",
        "sNext": "Suivant",
        "sLast": "Dernier"
      },
      "oAria": {
        "sSortAscending": ": activer pour trier la colonne par ordre croissant",
        "sSortDescending": ": activer pour trier la colonne par ordre décroissant"
      }
        }
      });
    }

  </script>

