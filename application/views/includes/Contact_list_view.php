<!DOCTYPE html>
<html lang="en">
<head>
 <?php include VIEWPATH.'includes/header.php'; ?>
 <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
 <script src="https://code.highcharts.com/highcharts.js"></script>
 <script src="https://code.highcharts.com/highcharts-more.js"></script>
 <script src="https://code.highcharts.com/highcharts-3d.js"></script>
 <script src="https://code.highcharts.com/modules/exporting.js"></script>
 <script src="https://code.highcharts.com/modules/export-data.js"></script>
 <script src="https://code.highcharts.com/modules/accessibility.js"></script>
 <script src="https://code.highcharts.com/highcharts-more.js"></script>
 <script src="https://code.highcharts.com/modules/dumbbell.js"></script>
 <script src="https://code.highcharts.com/modules/lollipop.js"></script>
</head>
<body class="dashboard dashboard_1">
  <div class="full_container" style="padding: 0px">
   <div class="inner_container" style="padding: 0px">

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
      <div class="container-fluid" style="padding: 0px">
        <br>
        <br>
        <!-- row -->
        <div class="row column1">
          <div class="col-md-12">
           <div class="white_shd full margin_bottom_30">
            <div class="full graph_head">
             <div class="header-title"> 
              <!--  <?=$this->session->flashdata('message');?> -->
            </div>
            <div class="card-header-toolbar d-flex align-items-center">
              <h4 style="font-family: Verdana;" class="card-title"><font class="fa fa-chain-broken"></font> Liste des contacts</h4>     
              <a><!-- <font class="fa fa-plus"></font>  Ajout du noveau document --></a>



            </div>
          </div>
          <div class="full price_table padding_infor_info" id="id_message">

           <div class="row">
             <div class="col-lg-12">

                <table id="mytable" class=" table-striped table-responsive" data-toggle="table" data-search="true" data-show-columns="true" data-pagination="true">
                 <thead>
                  <tr> 
                   <th  style="width: 4%"># </th>
                   <th>Nom complet </th>
                   <th>Adresse email</th>
                   <th>Téléphone </th>
                   <th>Message </th>
                 </tr>
               </thead>
               <tbody class="text-nowrap">
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

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> -->


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
      url:"<?php echo base_url('Contact/get_info/');?>",
      type:"POST", 
    },
    lengthMenu: [[5,10,50,100, 1000, row_count], [5,10,50,100, 1000, "All"]],
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
      "sProcessing":     "Traitement en cours...",
      "sSearch":         "Rechercher&nbsp;:",
      "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
      "sInfo":           "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
      "sInfoEmpty":      "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
      "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
      "sInfoPostFix":    "",
      "sLoadingRecords": "Chargement en cours...",
      "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
      "sEmptyTable":     "Aucune donn&eacute;e disponible dans le tableau",
      "oPaginate": {
        "sFirst":      "Premier",
        "sPrevious":   "Pr&eacute;c&eacute;dent",
        "sNext":       "Suivant",
        "sLast":       "Dernier"
      },
      "oAria": {
        "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
        "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
      }
    }

  });



});
</script>