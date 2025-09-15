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
                        <i class="fa fa-bars" aria-hidden="true"></i> Liste des demandes desactivées
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
          

          

          <div class="col-md-2"></div>
          
      </div>

      
 

      <div class="row">
         <div class="col-lg-12">

    
            <div class="tab-content" id="nav-tabContent">
            
             
                
             <!-- <div class="full price_table padding_infor_info">

                           <table id='mytable' class="table table-sm table-bordered table-hover table-striped" data-toggle="table" data-search="true" data-show-columns="true" data-pagination="true">
                               


                             <thead> 
                                <tr>
                                    <th  width="50" class="th-sm  text-black"><center>#</center></th>
                                    <th scope='col'><center>Code&nbsp;&nbspdemande</center></th>
                                    <th scope='col'><center>Nom&nbsp;&nbspPrénom</center></th>
                                    <th scope='col'><center>Poste</center></th>
                                    <th scope='col'><center>Contact</center></th>
                                    <th scope='col'><center>Processus</center></th>
                                    <th scope='col'><center>Date</center></th>


                                </tr>
                            </thead>

                            <tbody> </tbody>

                        </table> 
                        
                    </div> -->   


                   <!--  <?php if ($userdef == 2): ?> -->
                     <div class="full price_table padding_infor_info">
    	              
                          
        <table id='mytable' class="table table-sm table-bordered table-hover table-striped" 
               data-toggle="table" data-search="true" data-show-columns="true" data-pagination="true">
            <thead> 
              <tr>
            <th  width="50" class="th-sm  text-black"><center>#</center></th>
            <th scope='col'><center><?=strtoupper(lang('service'))?></center></th>
            <th scope='col'><center><?=strtoupper(lang('titre_statut'))?></center></th>
            <th scope='col'><center><?=strtoupper(lang('date_soumission'))?></center></th>
           <th scope='col'><center><?=strtoupper('User')?></center></th> 
           <th scope='col'><center><?=strtoupper('Motif')?></center></th>
           <th scope='col'><center><?=strtoupper(lang('notaire_action'))?></center></th> 
            </tr>
            </thead>
            <tbody></tbody>
        </table> 
    </div>
<!-- <?php else: ?>
    <div class="alert alert-warning" role="alert">
        <strong>Accès refusé :</strong> Vous n'avez pas les droits nécessaires pour accéder à cette information.
    </div>
<?php endif; ?>  -->
                
       

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
  //      "columns": [
  //   { responsivePriority: 2, responsive: { breakpoints: ['sm', 'md'] } }, // Hide on small and medium screens
  //   { responsivePriority: 2 }, // Display on all screen sizes
  //   // ...
  // ],
      "order":[[0, 'asc' ]],
      "ajax":{
        url:'<?=base_url()?>administration/Liste_dmd_desactive/liste/',
        data:{
            USER_BACKEND_ID:USER_BACKEND_ID
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

<script>
function showCommentModal(id) {
    const modal = document.getElementById("commentModal"+id);
    modal.style.display = "flex";
    document.getElementById("commentInput"+id).focus();
}

function closeCommentModal(id) {
    const modal = document.getElementById("commentModal"+id);
    modal.style.display = "none";
    document.getElementById("error"+id).textContent = "";
    document.getElementById("commentInput"+id).classList.remove("error");
}

function validateComment(id) {
    const comment = document.getElementById("commentInput"+id).value.trim();
    const errorElement = document.getElementById("error"+id);
    const textarea = document.getElementById("commentInput"+id);
    
    if(comment === "") {
        errorElement.textContent = "Le commentaire est obligatoire";
        textarea.classList.add("error");
        return false;
    }
    
    errorElement.textContent = "";
    textarea.classList.remove("error");
    saveComment(id, comment);
    return false;
}

function saveComment(id, comment) {

    fetch("<?=base_url()?>administration/Liste_dmd_desactive/save_comment", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
        body: "id="+id+"&comment="+encodeURIComponent(comment)
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            closeCommentModal(id);
            window.location.href = "<?= site_url('administration/Liste_dmd_desactive') ?>";
        } else {
            document.getElementById("error"+id).textContent = data.message || "Erreur lors de l\'enregistrement";
        }
    })
    .catch(error => {
        document.getElementById("error"+id).textContent = "Erreur réseau";
    });
}
</script>
