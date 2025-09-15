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

     <div class="midde_cont" >
      <div class="container-fluid">
        <div class="row column_title">
            <div class="col-md-12">
             <div class="page_title">
              
                <div class="row">
                  <div class="col-md-6">
                    <h2>
                        <i class="fa fa-bars" aria-hidden="true"></i> Liste des demandes des audiences
                    </h2>
                </div>
                <div class="col-md-3">
                </div>
                <div class="col-md-3">

                    <!-- Split button -->
                    <div class="btn-group">
                        <button type="button" class="btn btn-default"> <i style="color: #DF3309" class="fa fa-bell-o" aria-hidden="true"></i> <?= lang('vous_avez') ?> <label id="tasks_number"></label> <?= lang('tache_faire') ?>..</button>
                        
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
                <center>
                    <?=$this->session->flashdata('message')?>
                </center>
            </div> 
            <div class="col-md-6">
              <nav class="nav nav-pills nav-justified">



                
              </nav>
              
          </div>

          

          <div class="col-md-2"></div>
          
      </div>

      
 

      <div class="row">
         <div class="col-lg-12">

<!--                 <nav>
                  <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-home-tab" data-toggle="tab" data-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Rendez-vous En cours</button>
                    <button class="nav-link" id="nav-profile-tab" data-toggle="tab" data-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Rendez-vous effectuées</button>
                    <button class="nav-link" id="nav-contact-tab" data-toggle="tab" data-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Rendez-vous ajournées</button>
                    <button class="nav-link" id="nav-non-repondu-tab" data-toggle="tab" data-target="#nav-non-repondu" type="button" role="tab" aria-controls="nav-non-repondu" aria-selected="false">Rendez-vous non repondu</button>
                </div>
            </nav> -->

  <nav>
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <button class="nav-link active" id="nav-tab-1" data-toggle="tab" data-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true" onclick="showTab(0)">Audience En cours</button>
    <button class="nav-link" id="nav-tab-2" data-toggle="tab" data-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false" onclick="showTab(1)">Audience effectuées</button>
    <button class="nav-link" id="nav-tab-3" data-toggle="tab" data-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false" onclick="showTab(2)">Audience ajournées</button>
    <button class="nav-link" id="nav-tab-4" data-toggle="tab" data-target="#nav-non-repondu" type="button" role="tab" aria-controls="nav-non-repondu" aria-selected="false" onclick="showTab(3)">Audience non repondu</button>
  </div>
</nav>
            <br>
            <br>

            <div class="tab-content" id="nav-tabContent">
            
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <div class="full price_table padding_infor_info">
                            
                             <table id='mytable' class="table table-sm table-bordered table-hover table-striped" data-toggle="table" data-search="true" data-show-columns="true" data-pagination="true">



                               <thead> 
                                <tr>

                         <th  width="50" class="th-sm  text-black"><center>#</center></th>
                        <th scope='col'><center>Code demande</center></th>
                        <th scope='col'><center>Nom & Prénom</center></th>
                        <th scope='col'><center>Motif de l'audience</center></th>
                         <th scope='col'><center>Télephone</center></th> 
                        <th scope='col'><center>Date Audience</center></th>
                        <th scope='col'><center>Options</center></th>



                                </tr>
                            </thead>

                            <tbody> </tbody>

                        </table> 


                        
                    </div>
                </div>

                
        <div/>

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


<script>
 $(document).ready(function(){
     //$('#message').delay('slow').fadeOut(3000);
     get_liste(0)

}); 
</script>
 <script type="text/javascript">
function showTab(tabId) {
    get_liste(tabId)
    // alert (tabId)
  // Masquer tous les onglets
  document.querySelectorAll('.tab-pane').forEach(tab => tab.classList.remove('active', 'show'));

  // Afficher l'onglet sélectionné
  document.querySelector(`#nav-home`).classList.add('active', 'show');
  document.querySelector(`#nav-profile`).classList.add('active', 'show');
  document.querySelector(`#nav-contact`).classList.add('active', 'show');
  document.querySelector(`#nav-non-repondu`).classList.add('active', 'show');

  // Mettre à jour l'onglet actif dans la barre de navigation
  document.querySelectorAll('#nav-tab .nav-link').forEach(link => link.classList.remove('active'));
  document.querySelector(`#nav-tab-${tabId}`).classList.add('active');
}
</script>
<script type="text/javascript">
function get_liste(tabId) { 
     // alert (tabId)
  var row_count = "1000000"; 
  $("#mytable").DataTable({      
    "destroy" : true,
    "processing":true,
    "serverSide":true,
    "responsive": true,
    "order":[[0, 'asc' ]],
    "ajax":{
      url:'<?=base_url()?>administration/Liste_Audiences/liste/' + tabId,
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
    "order":[5,'asc'],
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
<script type="text/javascript">

  function get_absence() { 
    var row_count ="1000000"; 
    $("#myabsence").DataTable({      
      "destroy" : true,
      "processing":true,
      "serverSide":true,
      "responsive": true,
  //      "columns": [
  //   { responsivePriority: 2, responsive: { breakpoints: ['sm', 'md'] } }, // Hide on small and medium screens
  //   { responsivePriority: 2 }, // Display on all screen sizes
  //   // ...
  // ],
      "order":[[0, 'asc' ]],
      "ajax":{
        url:'<?=base_url()?>administration/Rdv/liste_absence/',
        data:{
            //STAGE_ID:STAGE_ID,PROCESS_ID:PROCESS_ID
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
<script type="text/javascript">

  function get_presence() { 
    var row_count ="1000000"; 
    $("#mypresence").DataTable({      
      "destroy" : true,
      "processing":true,
      "serverSide":true,
      "responsive": true,
  //      "columns": [
  //   { responsivePriority: 2, responsive: { breakpoints: ['sm', 'md'] } }, // Hide on small and medium screens
  //   { responsivePriority: 2 }, // Display on all screen sizes
  //   // ...
  // ],
      "order":[[0, 'asc' ]],
      "ajax":{
        url:'<?=base_url()?>administration/Rdv/liste_presence/',
        data:{
            //STAGE_ID:STAGE_ID,PROCESS_ID:PROCESS_ID
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
<script type="text/javascript">

  function get_ajournee() { 
    var row_count ="1000000"; 
    $("#myajournee").DataTable({      
      "destroy" : true,
      "processing":true,
      "serverSide":true,
      "responsive": true,
  //      "columns": [
  //   { responsivePriority: 2, responsive: { breakpoints: ['sm', 'md'] } }, // Hide on small and medium screens
  //   { responsivePriority: 2 }, // Display on all screen sizes
  //   // ...
  // ],
      "order":[[0, 'asc' ]],
      "ajax":{
        url:'<?=base_url()?>administration/Rdv/liste_ajourne/',
        data:{
            //STAGE_ID:STAGE_ID,PROCESS_ID:PROCESS_ID
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