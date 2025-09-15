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
                <center><h2>Creation d'un dossier dans Docbox</h2></center>
              </div>
            </div>

            <hr>

            <div class="dropdown col-md-3">

              <button class="btn btn-dark" onclick="history.go(-1)"><i class="fa fa-reply-all" aria-hidden="true"></i>&nbsp;<?= lang('button_retour')?> </button>
            </div>
            <?=$this->session->flashdata('message')?>
            <br>

            <form  action="<?php echo base_url('administration/Recherche/save')?>"  method="post" name="myform" id="myform" >


              <div class="row">

                  <div class="form-group col-lg-12"> 
                    <label>Nom du dossier<font class="text-danger">*</font></label> 
                    <input name="NOM_DOSSIER" autocomplete="off" id="NOM_DOSSIER" type="text" class="form-control" value=""> 
                    <font color="red" id="erNOM_DOSSIER" class="help"></font>
                  </div>


                  <div class="form-group col-lg-12"> 
                    <label>Description<font class="text-danger">*</font></label> 
                    <input name="DESCRIPTION" autocomplete="off" id="DESCRIPTION"  type="text" class="form-control" value=""> 
                    <font color="red" id="erDESCRIPTION" class="help"></font>
                  </div>


                  <div class="form-group col-lg-12">   
                    <input type="button" onclick="save_data()" class="btn btn-info form-control"  value="Enregistrer">
                  </div>

              </div>

              <div class="col-lg-12">
                <p><font color="red" id="message1" class="help"></font></p>
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

<script>
  function save_data()
  {

    var NOM_DOSSIER = $("#NOM_DOSSIER").val();
    var DESCRIPTION = $("#DESCRIPTION").val();
    
    // alert(PROVINCE);
    let statut = 1;


    if(NOM_DOSSIER == "")
    {
      statut = 2;      
      $('#erNOM_DOSSIER').text('Veuillez saisir le nom du dossier');
      $("#NOM_DOSSIER").focus();
      console.log(statut)
    }
    else
    {
     $('#erNOM_DOSSIER').attr('hidden',true);
    }

    if(DESCRIPTION == "")
    {
      statut = 2;      
      $('#erDESCRIPTION').text('Veuillez séléctionner la province de cette parcelle');
      $("#DESCRIPTION").focus();
    }
    else
    {
     $('#erDESCRIPTION').attr('hidden',true);
    }


    if(statut==1)
    {

     $.ajax({
        url : "<?=base_url()?>administration/Recherche/create_folder",
        type: "POST",
        dataType: "JSON",
        data: {NOM_DOSSIER:NOM_DOSSIER,
               DESCRIPTION:DESCRIPTION
      },
        success: function(data)
        {
          if (data.status==1)
          {

             $('#message1').attr('hidden',false);
             $('#message1').html(data.message);
            
          }
          else if (data.status==2) 
          {
            $('#message1').attr('hidden',false);
            $('#message1').html(data.message);          
          }
          else
          {
            $('#message1').attr('hidden',false);
            $('#message1').html(data.message);
          }
        }
    });
   }
  }


</script>



