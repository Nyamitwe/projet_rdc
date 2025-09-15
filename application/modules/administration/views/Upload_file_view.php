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
  <link rel="stylesheet" href="<?php echo base_url() ?>template/css/color_2.css" />
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
                <center><h2>Envoie d'un fichier dans EDRMS</h2></center>
              </div>
            </div>

            <hr>

            <div class="dropdown col-md-3">

              <button class="btn btn-dark" onclick="history.go(-1)"><i class="fa fa-reply-all" aria-hidden="true"></i>&nbsp;<?= lang('button_retour')?> </button>
            </div>
            <?=$this->session->flashdata('message')?>
            <br>

            <form  action="<?php echo base_url('administration/Recherche/save_file')?>"  method="post" name="myform" id="myform" enctype="multipart/form-data">


              <div class="row">

                  <div class="form-group col-lg-6"> 
                    <label>Description du fichier<font class="text-danger">*</font></label> 
                    <input name="FICHIER_DESCRIPTION" id="FICHIER_DESCRIPTION" type="text" class="form-control">
                    <small id="erFICHIER_DESCRIPTION" class="text-danger"></small>

                    <font color="red" id="erFichier" class="help"></font>
                  </div>


                  <div class="form-group col-lg-6"> 
                    <label>Televersement du fichier<font class="text-danger">*</font></label> 
                    <input name="file" id="FICHIER" type="file" accept="image/png,application/pdf,image/gif,image/jpeg" class="form-control">
                    <small id="erFICHIER" class="text-danger"></small>

                    <font color="red" id="erFichier" class="help"></font>
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
    var file=document.getElementById("FICHIER").files[0];
    var FICHIER_DESCRIPTION = $("#FICHIER_DESCRIPTION").val();


    
    let statut = 1;

    var form = new FormData();
    form.append("file",file); 
    form.append("FICHIER_DESCRIPTION",FICHIER_DESCRIPTION); 


    if(FICHIER_DESCRIPTION == "")
    {
      statut = 2;      
      $('#erFICHIER_DESCRIPTION').text('Veuillez saisir la description du fichier');
      $("#FICHIER_DESCRIPTION").focus();
      console.log(statut)
    }
    else
    {
     $('#erFICHIER_DESCRIPTION').attr('hidden',true);
    }



    // File validation
    if (!file)
    {
      statut = 2;
      $('#erFICHIER').text("Veuillez sélectionner un fichier.");
      $("#FICHIER").focus();
    } 
    else
    {
      const allowedTypes = ["image/png", "application/pdf",  "image/jpeg"];

      if (!allowedTypes.includes(file.type)) 
      {
        statut = 2;
        $('#erFICHIER').text("Format de fichier non supporté. Formats acceptés : PNG, PDF, GIF, JPEG.");
        $("#FICHIER").focus();
      } 
      else
      {
        $('#erFICHIER').attr('hidden', true);
      }
    }

    if(statut==1)
    {

     $.ajax({
        url : "<?=base_url()?>administration/Recherche/save_file",
        type: "POST",
        data: form,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(data) {
          // alert("Type of status:", typeof data.status);
          //   console.log("AJAX raw response:", data);
          //   console.log("Type of data:", typeof data);

            $('#myform')[0].reset(); 
            $('#message1').attr('hidden', false);

            if (data.status == "1" || data.status == 1) {
                $('#message1').html(data.message || "Succès !");
            } else if (data.status == "2" || data.status == 2) {
                $('#message1').html(data.message || "Erreur type 2");
            } else if (data.status == "3" || data.status == 3) {
                $('#message1').html(data.message || "Erreur type 3");
            } else if (data.status == "4" || data.status == 4) {
                $('#message1').html(data.message || "Erreur type 4");
            } else {
                $('#message1').html(data.message || "Aucun retour du serveur.");
            }
        },
                error:function (jsXHR,textStatus,errorThrwon){
                               

          console.log('Connexion failed : '+textStatus);
          // location.reload();

        }
    });
   }
  }


</script>



