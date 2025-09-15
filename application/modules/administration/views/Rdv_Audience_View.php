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
                <h4><font class="fa fa-book"></font>&nbsp;Attribution du RDV</h4>
              </div>
            </div>

            <hr>

            <div class="dropdown col-md-3">

              <button class="btn btn-dark" onclick="history.go(-1)"><i class="fa fa-reply-all" aria-hidden="true"></i>&nbsp;<?= lang('button_retour')?> </button>
            </div>
             <?=$this->session->flashdata('message')?>
            <br>

            <form  action="<?php echo base_url('administration/Liste_Demande_Audience/traiter_rdv')?>"  method="post" name="myform" id="myform" >


              <div class="row">

                
  <input type="hidden" name="ID_DEMANDEUR_AUDIENCE" value="<?=$demand['ID_DEMANDEUR_AUDIENCE']?>">

                <div class="form-group col-lg-6">    
                 <label style="font-weight: 900; color:#454545" id="lettre_demande">Service<font color="red">*</font></label>
                  <select class="form-control" id="SERVICE_ID"  name="SERVICE_ID" onchange="get_poste()">
                   <option value="">Sélectionner</option>
                   <?php 

                   foreach ($service as $key => $val) {


                     if ($val['SERVICE_ID']==set_value('SERVICE_ID')) 
                     {
                       echo '<option value="'.$val['SERVICE_ID'].'" selected>'.$val['DESCRIPTION'].'</option>';
                     }
                     else{


                      echo '<option value="'.$val['SERVICE_ID'].'">'.$val['DESCRIPTION'].'</option>';

                    }

                  }
                  ?>
                </select>
                <span class="help-block" style="color: red" id="erSERVICE_ID"></span>

              </div>



              <div class="form-group col-lg-6">    
               <label style="font-weight: 900; color:#454545" id="lettre_demande">Poste<font color="red">*</font></label>
               <select class="form-control" id="ID_POSTE"  name="ID_POSTE" onchange="get_stage()">
                 <option value="">Sélectionner</option>

               </select>
               <span class="help-block" style="color: red" id="erID_POSTE"></span>

             </div>




             <div class="form-group col-lg-12">  

             <label>Date d'audience<font class="text-danger">*</font></label>
             
             <input type="text" value="<?=set_value('RDV_DATE')?>" name="RDV_DATE" class="form-control" id="RDV_DATE">
                                  
               <span class="help-block" style="color: red" id="erRDV_DATE"></span>

             </div>



             <div class="form-group col-lg-12">   

              <input type="button" onclick="save_data()" class="btn btn-info form-control" value="Attribuer le rdv">
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

  $.post('<?php echo base_url('administration/Liste_Demande_Audience/get_poste')?>',
  {
    SERVICE_ID:SERVICE_ID,


  },
  function(data)
  {
   $('#ID_POSTE').html(data);
 });

  

} 

</script> <script>
  $( function() {
    $( "#RDV_DATE" ).datepicker();
  } );
  </script>






<script>
     $( "#RDV_DATE").datepicker({
       minDate: new Date()
    });
  function DisableFriday(date) {
      var day = date.getDay();
     if (day == 5 || day==4 || day==3 || day==1 || day==0 || day==6) {
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

var statut=1;

if ($('#SERVICE_ID').val()=="") {
  statut=2;

  $('#erSERVICE_ID').html('Champ obligatoire');

}



if ($('#ID_POSTE').val()=="") {
  statut=2;

  $('#erID_POSTE').html('Champ obligatoire');
  
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