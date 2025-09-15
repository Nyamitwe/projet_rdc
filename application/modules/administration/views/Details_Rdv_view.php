<!DOCTYPE html>
<html lang="en">
<head>
  <?php include VIEWPATH.'includes/header.php'; ?>


  <style>
    fieldset.scheduler-border 
    {
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

      <!-- Sidebar session FLASH -->
      <?php include VIEWPATH.'includes/navybar.php'; ?> 
      <!-- right content -->
      <div id="content">
        <!-- topbar -->
        <?php include VIEWPATH.'includes/topbar.php'; ?> 
        <!-- end topbar -->
        <!-- dashboard inner -->
        <div class="midde_cont">
          <div class="container-fluid" style="padding:5px;">

           <!--  ID_ACTION -->
           <?php

           $menu1="nav-link active";
           $menu2="nav-link";
           $menu3="nav-link";
           $menu4="nav-link";
           $menu5="nav-link";
           $menu6="nav-link";
           $menu7="nav-link";
           ?>
           <br>

           <div class="row column1" >
            <!-- <div class="row"> -->
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">

                  </div>
                  <?=$this->session->flashdata('message')?> 
                  <div class="card-body" style="padding: 5px;">
                    <div class="row">
                      <div class="col-sm-5">
                        <div class="btn-group mr5 pull-left">
                          <button class="btn btn-dark" onclick="history.go(-1)">
                            <?php 
                            if($this->uri->segment(5)>0){
                              ?>
                              <i class="fa fa-times" aria-hidden="true"></i>&nbsp;<?=lang('btn_ferme')?> 
                              <?php

                            }else{
                              ?>
                              <i class="fa fa-reply-all" aria-hidden="true"></i>&nbsp;<?=lang('button_retour')?>
                              <?php
                            }
                            ?>

                          </button>
                        </div>

                      </div>

                      <div class="col-sm-7">

                        <table class="">
                         <tr>
                            <td><h6><?=lang('code_demande')?>:</h6></td>
                            <td><h6><b>rdv-0<?= !empty($infos['ID_DEMANDEUR_AUDIENCE']) ? $infos['ID_DEMANDEUR_AUDIENCE'] :0 ; ?></b></h6></td>
                            <!-- <td><h6><?=lang('titre_num_parcelle')?>:</h6></td>
                            <td><h6><b></b></h6></td> -->
                          </tr>
                        </table>

                      </div>

                    </div>



                    <div class="row">
                      <div class="col-sm-12">

                        <div class="card" style="width:100%;">
                          <div class="card-header">

                            <?= lang('info_requerant')?>


                          </div>


                          <table class="table">
                          
                           <tr  style="background-color: #DFE0E0;color: black;font-size: 13px;">
                            <td><b><font class="fa fa-user"></font> <?= lang('nom_complet')?></b></td>
                            <td><b><i class="fa fa-envelope-open-o" aria-hidden="true"></i> <?= lang('email')?></b></td>
                            <td><b><font class="fa fa-phone"></font> <?= lang('telephone')?></b></td>
                            <td><b><i class="fa fa-address-book-o" aria-hidden="true"></i> <?= lang('profil')?></b></td>                                
                          </tr>
                       <tr style="font-family: 'Poppins', sans-serif;text-align: center;font-size: 13px;">
                           <td><font style="font-family: 'Poppins', sans-serif;font-size: 13px;"><?=!empty($infos['NOM_PRENOM']) ? $infos['NOM_PRENOM'] :''?></font></td>
                           <td scope="row"><?=!empty($infos['EMAIL']) ? $infos['EMAIL'] :'' ?></td>
                           <td scope="row"><?=!empty($infos['TELEPHONE']) ? $infos['TELEPHONE'] : ''?></td>
                           <td scope="row"><?=!empty($infos['PROFILESS']) ? $infos['PROFILESS'] : '' ?></td>

                         </tr>

                       </table>

                     </div>
                   </div>
                 </div>


                 <br>


                 <br>

                 <!-- Affichage du dossier initial -->



                 <div class="row">

                        <div class="col-md-12">
                              <div class="alert alert-success alert-dismissible fade show">

                                 <h5>Autres infos</h5>

                                  <hr>

                                 <div class="col-md-12">
                                    <ul class="list-group">
                                        <li class="list-group-item"><strong>CNI: </strong>&nbsp;<?=$infos['NUM_CNI']?></li>
                                        <li class="list-group-item"><strong>Objectif: </strong>&nbsp;<?=$infos['DESCRIPTION_PROCESS']?></li>
                                         <li class="list-group-item"><strong>Date audience: </strong>&nbsp;<?= date('d/m/Y', strtotime($infos['JOUR_AUDIENCE'])); ?></li>

                                        <?php if ($infos['DISPOSITION_TITRE']==1) {
                                         ?>

                                        
                                      <li class="list-group-item"><strong>Numero Parcelle: </strong>&nbsp;<?=$infos['NUMERO_PARCELLE']?></li>
                                      <li class="list-group-item"><strong>Folio: </strong>&nbsp;<?=$infos['FOLIO']?></li>
                                      <li class="list-group-item"><strong>Volume: </strong>&nbsp;<?=$infos['VOLUME']?></li>
                                                            
                                      
                                         <?php  
                                     }

                                     ?>
                                      <?php if ($infos['STATUT_SCANNER']==2) {
                                         ?>
                                      <li class="list-group-item" style="color:black"><strong>Motif de report: </strong>&nbsp;<?=$infos['MOTIF']?></li>
                                      <li class="list-group-item" style="color:black">
                                        <a href="<?= base_url('administration/Rdv/Motifs/'.md5($infos['ID_DEMANDEUR_AUDIENCE']).'')?>" class="btn btn-primary float-end">
                                          AUTRES MOTIFS
                                        </a>
                                         
                                      </li> 
                                          <?php  
                                     }

                                     ?>
                                                             
                                 </ul>



                                 <!-- <h5><?=lang('label_nom_representant')?> : <b>bdfff</b></h5> -->
                             </div>


                             <!--  <input type="text" class="form-control" value="213" readonly hidden>  -->
                   
                 
                  <?php if($infos['DOC_PDF_TITRE'] !=''){?>
                    <br><br>
                    <div class="row">
                      

                        <div class="col-md-6">

                   <a target="_blank" href="<?= base_url('uploads/doc_scanner/'.$infos['DOC_PDF_TITRE'].'')?>" class='main_bt'><i class="fa fa-file-pdf-o" style="font-size:25px;color: red;"></i>&nbsp;&nbsp;&nbsp;Titre de Propriété</a>
                        </div>
        

                </div>
                 <?php } ?>

                </div>
                 </div>
              
              
                 </div>
                 <br>

                 <?php
                 $today = date('Y-m-d');
                 if ($infos['STATUT_SCANNER'] == 0 || $infos['STATUT_SCANNER'] == 2) 
                 {
                  if ($infos['JOUR_AUDIENCE'] == $today) 
                  {
                    ?>
                    <div class="row">
                      <div class="col-md-6">
                        <a style="background-color: orangered;" href="<?= base_url('administration/Rdv/report/'.md5($infos['ID_TRAITEMENT_AUDIENCE']).'')?>" class='form-control main_bt'>Report</a>
                      </div>
                      <div class="col-md-6">
                        <a href="<?= base_url('administration/Rdv/statut/'.$infos['ID_TRAITEMENT_AUDIENCE'].'')?>/1" class='form-control main_bt'>Présence</a>
                      </div>
                    </div>
                    <?php
                  } 
                  else 
                  {
                    ?>
                    <div class="row">
                      <div class="col-md-12">
                        <a style="background-color: orangered;" href="<?= base_url('administration/Rdv/report/'.md5($infos['ID_TRAITEMENT_AUDIENCE']).'')?>" class='form-control main_bt'>Report</a>
                      </div>
                    </div>
                    <?php
                  }
                }
                ?>



</div>
</div>
</div>
<!-- </div> -->


 


</div>


</div>
</div>





<div class="modal fade" id="opens" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nom du fichier ouvert</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <div id="message_chekup"></div>
      </div>
      <div class="modal-body">
       <iframe
       src="https://drive.google.com/viewerng/viewer?embedded=true&url=https://app.mediabox.bi/wasili_service/upload/mbx.pdf#toolbar=0&scrollbar=0"
       frameBorder="0"
       scrolling="auto"
       height="320px"
       width="100%"
       ></iframe>
     </div>

   </div>
 </div>
</div>





</body>
</html>

<?php include VIEWPATH.'includes/scripts_js.php'; ?>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>


<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>





  <!-- BLOC AJOUTER POUR AUTRE ONGLET POUR DOSSIER INITIALE  -->


  <script>
    function geturl(url)
    {
      var ticket=$('#TICKET').val();


      const w = 600;
      const h = 700;

      const dualScreenLeft = window.screenLeft !==  undefined ? window.screenLeft : window.screenX;
      const dualScreenTop = window.screenTop !==  undefined   ? window.screenTop  : window.screenY;

      const width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
      const height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

    // var url = 'http://141.95.148.19:1620/alfresco/s/api/node/content/workspace/SpacesStore/'+url+'?a=false&alf_ticket='+ticket+'#toolbar=0';
      var url = 'http://154.117.208.115:1620/alfresco/s/api/node/content/workspace/SpacesStore/'+url+'?a=false&alf_ticket='+ticket+'#toolbar=0';

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










