<!DOCTYPE html>
<html lang="en">
<head>
  <?php include VIEWPATH.'includes/header.php'; ?>


  <style>
  fieldset.scheduler-border {
    border: 1px groove #ddd !important;
    padding: 0 1.4em 1.4em 1.4em !important;
    margin: 0 0 1.5em 0 !important;
    -webkit-box-shadow:  0px 0px 0px 0px #000;
    box-shadow:  0px 0px 0px 0px #000;
  }

  legend.scheduler-border {
    font-size: 1.2em !important;
    font-weight: bold !important;
    text-align: left !important;
  }
  .table td {
    vertical-align: middle;
    border: 1px solid #DFE0E0;
    text-align: center;
    padding: 10px;
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
        <div class="midde_cont">
          <div class="container-fluid">
           <br>
                <div class="row column1" style="padding:10px;">
                  <div class="col-md-12">
                     <div class="white_shd full margin_bottom_30">
                        <div class="row full graph_head">
                           <div class="dropdown col-md-3">
                              <button class="btn btn-dark" onclick="history.go(-1)" type="button">
                                 <span class="fa fa-reply-all" aria-hidden="true" style="color: white;text-decoration: none;"><?=lang('retour_a_la_correction')?></span>
                              </button>
                           </div>
                        

                        <div class="full price_table padding_infor_info">
                        <div class="col-md-12">

                         <h1><?=lang('titre_num_parcelle')?> : <b><?=$info_parcel['NUMERO_PARCELLE']?></b></h1>
                         <?php if($info_proprio['registeras']==1){?>

                         <h2><?=lang('label_nom_users')?> : <b><?=$info_proprio['fullname']?></b></h2>
                         
                         <?php }else{?>

                         <h2><?=lang('label_nom_representant')?> : <b><?=$info_proprio['fullname']?></b></h2>

                         <?php }?>

                         <input type="text" class="form-control" value="<?=$info?>" readonly hidden> 
                        </div>

                        <br>
                        
                        <div class="row">
                            <div class="col-md-6">
                            <ul class="list-group">
                            <li class="list-group-item"><strong>Volume: </strong> <?=$info_parcel['VOLUME']?></li>
                            <li class="list-group-item"><strong>Folio: </strong><?=$info_parcel['FOLIO']?></li>
                            <li class="list-group-item"><strong><?=lang('superficie')?>: </strong><?=$localite?></li>
                            <li class="list-group-item"><strong>Usage: </strong>  <?=!empty($info_parcel) ? $info_parcel['DESCRIPTION_USAGER_PROPRIETE'] : "N/A"?></li>                               
                            <li class="list-group-item"><strong><?=lang('numero_cadastral')?>:</strong> <?=$info_parcel['NUMERO_CADASTRAL']?></li>                          
                            

                            <?php if($info_proprio['registeras']==1){?>
                            <li class="list-group-item"><strong><?=lang('nom_prenom_pere')?>: </strong><?= !empty($info_proprio) ? $info_proprio['father_fullname'] : "N/A"?></li>
                            <li class="list-group-item"><strong><?=lang('nom_prenom_mere')?>: </strong><?= !empty($info_proprio) ? $info_proprio['mother_fullname'] : "N/A"?></li>
                            <?php }?>
                            </ul>
                            </div>

                            <div class="col-md-6">
                             <ul class="list-group">
                             <li class="list-group-item"><strong><?=lang('nature_dossier')?>: </strong> <b><?=$nature_dossier?></b></li>
                             <li class="list-group-item"><strong><?=lang('num_ordre_special')?>: </strong><b><?=$numero_dossier?></b></li>
                             <li class="list-group-item"><strong><?=lang('date_insertion')?>: </strong><b><?=$date_insertion?></b></li>
                             </ul>
                            </div>

                        </div>




                 </div>
              </div>
           </div>
           <!-- end row -->
        </div>
</div></div></div>

<?php include VIEWPATH.'includes/scripts_oposition_js.php'; ?>

  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
  <script src="<?php echo base_url() ?>template/js/bootstrap.min.js"></script>



</body>
</html>

















