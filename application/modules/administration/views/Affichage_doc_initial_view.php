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
                <center><h2>Affichage contenu d'une parcelle</h2></center>
              </div>
            </div>

            <hr>

            <div class="dropdown col-md-3">

              <button class="btn btn-dark" onclick="history.go(-1)"><i class="fa fa-reply-all" aria-hidden="true"></i>&nbsp;<?= lang('button_retour')?> </button>
            </div>
            <?=$this->session->flashdata('message')?>
            <br>

            <!-- <form  action="<?php echo base_url('administration/Recherche/save')?>"  method="post" name="myform" id="myform" > -->


              <div class="row">
              
              <input type="hidden" name="TICKET" id="TICKET" value="">                        


              <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= $error ?></div>
              <?php else: ?>

                <h3>Dossier principal: <?= $detail_fold['nom_folder'] ?></h3>
                <p>Description: <?= $detail_fold['description'] ?></p>

                <h4>📁 Sous-dossiers</h4>
                <table border="1" cellpadding="5" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Nom</th>
                      <th>Description</th>
                      <th>Date de création</th>
                      <th>Niveau</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($folders as $folder): ?>
                      <tr>
                        <td><?= $folder['nom_folder'] ?></td>
                        <td><?= $folder['description'] ?></td>
                        <td><?= $folder['date_creation'] ?></td>
                        <td><?= $folder['niveau'] ?></td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>

                <h4>📄 Fichiers</h4>
                <table border="1" cellpadding="5" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Nom</th>
                      <th>Description</th>
                      <th>Date de création</th>
                      <th>Taille</th>
                      <th>Fichier</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($files as $file): ?>
                      <tr>
                        <td><?= $file['nom_folder_fichier'] ?></td>
                        <td><?= $file['description'] ?></td>
                        <td><?= $file['date_creation'] ?></td>
                        <td><?= $file['file_size'] ?> Ko</td>
                        <td><a href="<?= $file['path'] ?>" target="_blank">Télécharger</a></td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>

              <?php endif; ?>





        </div>

      <!-- </form> -->
    </div>
  </div>
</div>
<!-- end row -->
</div>


</div>
<!-- end dashboard inner -->
</div>
</div></div></div>

<!--- modal pour Afficher les fichiers de type Tiff d'Alfresco---->
<div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Fichier</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="status-input" value="">
      <div id="canvas"></div>          
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal"><?=lang('btn_ferme')?></button>
    </div>
  </div>
</div>
</div>

<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
<script src="<?php echo base_url() ?>template/js/bootstrap.min.js"></script>


</body>
</html>

<script>
  function geturl(url,filename)
  {
    var ticket=$('#TICKET').val();

    const w = 600;
    const h = 700;

    const dualScreenLeft = window.screenLeft !==  undefined ? window.screenLeft : window.screenX;
    const dualScreenTop = window.screenTop !==  undefined   ? window.screenTop  : window.screenY;

    const width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
    const height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

    var url = 'http://devapi.mediabox.bi/c/s/api/node/content/workspace/SpacesStore/'+url+'?a=false&alf_ticket='+ticket+'#toolbar=0';

    var title = 'Document EDRMS';

    const systemZoom = width / window.screen.availWidth;
    const left = (width - w) / 2 / systemZoom + dualScreenLeft;
    const top = (height - h) / 2 / systemZoom + dualScreenTop;

    const newWindow = window.open(url, title, 
      `
      scrollbars=yes,
      width=${w / systemZoom}, 
      height=${h / systemZoom}, 
      top=${top}, 
      left=${left}
      
      `
      )

    if (window.focus) newWindow.focus();
  }
</script>
      <script type="text/javascript" src="<?php echo base_url() ?>js/tiff.min.js"></script>







