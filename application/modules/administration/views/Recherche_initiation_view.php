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
                <center><h2>Interface initiation des Recherche dans Docbox</h2></center>
              </div>
            </div>

            <hr>

            <div class="dropdown col-md-3">

              <button class="btn btn-dark" onclick="history.go(-1)"><i class="fa fa-reply-all" aria-hidden="true"></i>&nbsp;<?= lang('button_retour')?> </button>
            </div>
            <?=$this->session->flashdata('message')?>
            <br>

            <div class="row">

              <div class="col-md-6 mb-3">
                <a href="<?=base_url('/administration/Recherche/affiche_doc')?>" class="btn btn-primary w-100" style="font-size: 1.5rem; padding: 1rem 2rem;">
                  <i class="bi bi-search" style="margin-right: 0.5rem;"></i>
                  Recherche parcelle dans Docbox
                </a>
              </div>

              <div class="col-md-6 mb-3">
                <a href="<?=base_url('/administration/Recherche/redirect_create_folder')?>" class="btn btn-primary w-100" style="font-size: 1.5rem; padding: 1rem 2rem;">
                  <i class="bi bi-search" style="margin-right: 0.5rem;"></i>
                  Creation d'un dossier dans la nature X d'une province Y
                </a> 
              </div>

              <div class="col-md-6 mb-3">
                <a href="<?=base_url('/administration/Recherche/redirect_upload_file')?>" class="btn btn-primary w-100" style="font-size: 1.5rem; padding: 1rem 2rem;">
                  <i class="bi bi-search" style="margin-right: 0.5rem;"></i>
                  Envoie d'un fichier
                </a> 
              </div>

            </div>



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





