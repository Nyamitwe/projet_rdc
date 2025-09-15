<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Property Management System</title>
  <!-- site icon -->
  <link rel="icon" href="<?php echo base_url() ?>template/images/favicon-16x16.png" type="image/png" />
  <!-- bootstrap css -->
  <link rel="stylesheet" href="<?php echo base_url() ?>template/css/bootstrap.min.css" />

  <!-- site css -->
  <link rel="stylesheet" href="<?php echo base_url() ?>template/style.css" />
  <!-- responsive css --> 

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
  <!-- font awesome --> 
  <link rel="stylesheet" href="<?php echo base_url() ?>template/css/responsive.css" />
  <!-- color css -->
  <link rel="stylesheet" href="<?php echo base_url() ?>template/css/colors.css" />
  <!-- select bootstrap -->
  <link rel="stylesheet" href="<?php echo base_url() ?>template/css/bootstrap-select.css" />
  <!-- scrollbar css -->
  <link rel="stylesheet" href="<?php echo base_url() ?>template/css/perfect-scrollbar.css" />
  <!-- custom css -->
  <link rel="stylesheet" href="<?php echo base_url() ?>template/css/custom.css" />
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->





    <script type="text/javascript" src="js/bootstrap.js"></script>
    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>


    <link rel="stylesheet" href="<?= base_url() ?>template/vendor/select2/css/select2.min.css">

    <link href="<?= base_url() ?>template/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">

    <link rel="stylesheet" href="<?php echo base_url() ?>template/css/buttons.dataTables.min.css" />

    <script src="<?php echo base_url() ?>Design/vendor/bootstrap/js/bootstrap.min.js"></script>


    <link rel="stylesheet" href="<?php echo base_url() ?>template/onlinescripts/dataTables.bootstrap4.min.css" />
    <link href="http://code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css" rel="stylesheet">


    <script src="<?php echo base_url() ?>template/onlinescripts/jquery.min.js" type="text/javascript"></script>

    <script src="http://code.jquery.com/ui/1.11.3/jquery-ui.min.js"></script>


    <script src="<?php echo base_url() ?>template/onlinescripts/jquery-3.3.1.min.js"
      integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

      <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
<!--   <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script> -->
  <script>
    $( function() {
      $( "#datepicker" ).datepicker();
    } );
  </script>
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
     <div class="midde_cont">
      <div class="container-fluid" style="padding: 0px;">

       <br>
       <br>

       <?php

       $menu1="nav-link active";
       $menu2="nav-link";
       $menu3="nav-link";
       $menu4="nav-link";
       $menu5="nav-link";
       $menu6="nav-link";



       ?>


       <div class="row column1">
         <div class="col-md-12">
          <div class="white_shd full margin_bottom_30" style="padding: 0px;">

           <div class="full price_table padding_infor_info">

            <div class="row">
              <div class="col-md-12">
                <br>
                <h4><font class="fa fa-book"></font>&nbsp;Report du Rendez-vous!</h4>
              </div>
            </div>

            <hr>

            <div class="dropdown col-md-3">

              <button class="btn btn-dark" onclick="history.go(-1)"><i class="fa fa-reply-all" aria-hidden="true"></i>&nbsp;<?= lang('button_retour')?> </button>
            </div>
            <?=$this->session->flashdata('message')?>
            <br>

            <form  action="<?php echo base_url('administration/Rdv/reporter_rdv')?>"  method="post" name="myform" id="myform" >


              <div class="row">


               <input type="hidden" name="ID_TRAITEMENT_AUDIENCE" value="<?=$rdv_donne['ID_TRAITEMENT_AUDIENCE']?>">


               <div class="form-group col-lg-4">
                <label>Motif de report<font class="text-danger">*</font></label>
                <textarea name="MOTIF" class="form-control" id="MOTIF" rows="6"><?=set_value('MOTIF')?></textarea>
                <span class="help-block" style="color: red" id="erMOTIF"></span>
              </div>
           <div class="form-group col-lg-4">  
             <label>Date de rendez-vous<font class="text-danger">*</font></label>
             <input type="text" value="<?=set_value('RDV_DATE')?>" name="RDV_DATE" class="form-control"  id="RDV_DATE">
             <span class="help-block" style="color: red" id="erRDV_DATE"></span>
           </div>
            <!--  <div class="form-group col-lg-4">  
             <label>Heure de rendez-vous<font class="text-danger">*</font></label>
             <input type="time" value="<?=set_value('HEURE')?>" name="HEURE" class="form-control"  id="HEURE">
             <span class="help-block" style="color: red" id="erHEURE"></span>
           </div> -->
           <div class="form-group col-lg-4">
            <label>Heure de rendez-vous<font class="text-danger">*</font></label>
            <select name="HEURE" class="form-control" id="HEURE">
              <option value="">Sélectionnez une heure</option>
            </select>
            <span class="help-block" style="color: red" id="erHEURE"></span>
          </div>
           <div class="form-group col-lg-12">   

            <input type="button" onclick="save_data()" class="btn btn-info form-control"  value="Reporter le rendez-vous!">
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- end row -->
</div>


</div>
<!-- end dashboard inner -->
</div>
</div></div></div>


<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
<script src="<?php echo base_url() ?>template/js/bootstrap.min.js"></script>


</body>
</html>


<!-- MODAL  POUR AUTRE-->


<script type="text/javascript">

 function get_poste() 
 {
  var SERVICE_ID=$('#SERVICE_ID').val();

  $.post('<?php echo base_url('administration/Liste_Demande_Rdv/get_poste')?>',
  {
    SERVICE_ID:SERVICE_ID,
  },
  function(data)
  {
   $('#ID_POSTE').html(data);
 });

  

} 

</script> 
<script>

 $(function() {

  $( "#RDV_DATE" ).datepicker();
} );

 

</script>


<script>

$(function() {
  $("#RDV_DATE").datepicker();
      var mindate="<?=$DATE_DEMANDE?>";
      var today = new Date();
       var today2 = new Date();

     var day = ("0" + today.getDate()).slice(-2);
     var month = ("0" + (today.getMonth() + 1)).slice(-2);
  
     var year = today.getFullYear().toString()

    var mindate2 = day + "-" + month + "-" + year;


     if(mindate2===mindate){
      today.setDate(today.getDate() + 1);
     $("#RDV_DATE").datepicker("option", "minDate", today);
   
     }else{
      $("#RDV_DATE").datepicker("option", "minDate", today2);
       
     }

  
});
 function DisableFriday(date) {
  var day = date.getDay();
  if (day==0 || day==6) {
   return [false,"","Unavailable"] ; 
 } else { 
   return [true] ;
 } 
}
jQuery(function($){
  $('input[name="RDV_DATE"]').datepicker('option', 'beforeShowDay', DisableFriday).datepicker('refresh');
});
</script>


<script>
  function save_data(){
    $('#erMOTIF').html('');
   $('#erHEURE').html('');
   $('#erRDV_DATE').html('');
  
   var statut=1;

   if ($('#MOTIF').val()=="") {
    statut=2;

    $('#erMOTIF').html('Champ obligatoire');

  }

  if ($('#HEURE').val()=="") {

    statut=2;

    $('#erHEURE').html('Champ obligatoire');

  }


  if ($('#RDV_DATE').val()=="") {
    statut=2;

    $('#erRDV_DATE').html('Champ obligatoire');

  }

// Set the minimum date for the input field
var formm=document.getElementById('myform');

if (statut==1) {

  formm.submit();
}

};
</script>
<script>
  // Récupérer le champ de saisie de l'heure
  const hourSelect = document.getElementById('HEURE');

  // Définir les heures min et max
  const minHour = 8;
  const maxHour = 16;

  // Remplir les options du champ de saisie de l'heure
  for (let hour = minHour; hour <= maxHour; hour++) {
    for (let minute = 0; minute < 60; minute += 15) {
      if (hour === maxHour && minute >= 45) {
        break;
      }
      const time = `${hour.toString().padStart(2, '0')}:${minute.toString().padStart(2, '0')}`;
      const option = document.createElement('option');
      option.value = time;
      option.text = time;
      hourSelect.add(option);
    }
  }
</script>