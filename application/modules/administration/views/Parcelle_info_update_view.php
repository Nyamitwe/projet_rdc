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
             <br>
             <br>


             <div class="full price_table padding_infor_info">

              <!-- <hr> -->
                  
                 <form name="myform" method="post" class="form-horizontal" action="<?= base_url('administration/Numerisation/update'); ?>"  enctype="multipart/form-data">
                 
                 <div class="row">
                    <div class="col-md-3">
                     <input type="hidden"  class="col-md-4 form-control" value="<?=$user_id?>" id="user_id" name="user_id">
                     <input type="hidden"  class="col-md-4 form-control" value="<?=$num_parcelle1?>" id="num_parcelle" name="num_parcelle">
                    </div>                   
                 </div>
                 <div class="row">
  
                      <div class="col-md-4">
                        <label><?=lang('label_parcelle_number')?><font class="text-danger">*</font></label>
                        <input type="text" oninput="validateValue(this)" value="<?=!empty($info['NUMERO_PARCELLE']) ? $info['NUMERO_PARCELLE'] : ''?>" class="form-control" name="NUM_PARCEL">
                        <?php echo form_error('NUM_PARCEL', '<div class="text-danger">', '</div>'); ?>                                
                      </div>

                      <div class="col-md-4">
                        <label><?=lang('nature_dossier')?><font class="text-danger">*</font></label>
                        <select class="form-control"  name="NATURE_DOC" id="NATURE_DOC">
                          <option value=""><?=lang('selectionner')?></option>
                          <?php foreach($type_nature_docs as $type_nature_doc) { 
                            if ($type_nature_doc['ID_DOSSIER']==$info['dossier_id']) { 
                              echo "<option value='".$type_nature_doc['ID_DOSSIER']."' selected>".$type_nature_doc['DOSSIER']."</option>";
                            }  else{
                              echo "<option value='".$type_nature_doc['ID_DOSSIER']."' >".$type_nature_doc['DOSSIER']."</option>"; 
                            } }?>                                                              
                          </select>
                          <?php echo form_error('NATURE_DOC', '<div class="text-danger">', '</div>'); ?>                             
                        </div>

                        <div class="col-md-4">
                          <label><?=lang('num_ordre_special')?><font class="text-danger">*</font></label>
                          <input type="text" class="form-control"  value="<?=$info['NUMERO_ORDRE_SPECIAL']?>" name="NUMERO_SPECIAL">
                          <?php echo form_error('NUMERO_SPECIAL', '<div class="text-danger">', '</div>'); ?>                                
                        </div>

                        <div class="col-md-12"></div>

                        <div class="col-md-6">
                          <label>Volume<font class="text-danger">*</font></label>
                          <input type="text" value="<?=$info['VOLUME']?>" oninput="validateInfoVolume(this)" class="form-control" name="VOLUME">
                          <?php echo form_error('VOLUME', '<div class="text-danger">', '</div>'); ?>                                
                        </div>


                        <div class="col-md-6">
                          <label>Folio<font class="text-danger">*</font></label>
                          <input type="text" oninput="validateInfoFolio(this)" class="form-control" value="<?=$info['FOLIO']?>" name="FOLIO">
                          <?php echo form_error('FOLIO', '<div class="text-danger">', '</div>'); ?>                                
                        </div>


                        <div class="col-md-12"></div><br>

                        <div class="col-md-4">
                          <label><?=lang('superficie_ha')?><font class="text-danger">*</font></label>
                          <input type="text" oninput="validateInfoFolio(this)" class="form-control" value="<?=$info['SUPERFICIE_HA']?>" name="SUPER_HA" id="SUPER_HA">
                          <?php echo form_error('SUPER_HA', '<div class="text-danger">', '</div>'); ?>                                
                        </div>                         


                        <div class="col-md-4">
                          <label><?=lang('superficie_a')?><font class="text-danger">*</font></label>
                          <input type="text" oninput="validateInfoFolio(this)" class="form-control" value="<?=$info['SUPERFICIE_ARE']?>" name="SUPER_ARE" id="SUPER_ARE">
                          <?php echo form_error('SUPER_ARE', '<div class="text-danger">', '</div>'); ?>                                
                        </div> 

                        <div class="col-md-4">
                          <label><?=lang('superficie_ca')?><font class="text-danger">*</font></label>
                          <input type="text" oninput="validateInfoFolio(this)" class="form-control" value="<?=$info['SUPERFICIE_CA']?>" name="SUPER_CA" id="SUPER_CA">
                          <?php echo form_error('SUPER_CA', '<div class="text-danger">', '</div>'); ?>                                
                        </div> 

                               
                        <div class="col-md-12"></div><br>

                        <div class="col-md-3">
                          <label><?=lang('label_province')?><font class="text-danger">*</font></label>
                          <select class="form-control" onchange="get_communes(this.value)"  name="PROVINCE_ID" id="PROVINCE_ID">
                            <option value=""><?=lang('selectionner')?></option>
                            <?php foreach($provinces as $province) { 
                              if ($province['PROVINCE_ID']==$info['PROVINCE_ID']) { 
                                echo "<option value='".$province['PROVINCE_ID']."' selected>".$province['PROVINCE_NAME']."</option>";
                              }  else{
                                echo "<option value='".$province['PROVINCE_ID']."' >".$province['PROVINCE_NAME']."</option>"; 
                              } }?>                                                              
                            </select>
                            <?php echo form_error('PROVINCE_ID', '<div class="text-danger">', '</div>'); ?>                                
                          </div>


                          <div class="col-md-3">
                            <label><?=lang('label_commune')?><font class="text-danger">*</font></label>
                            <select class="form-control" onchange="get_zones(this.value)"  name="COMMUNE_ID" id="COMMUNE_ID">
                             <option value=""><?=lang('selectionner')?></option>
                             <?php foreach($communes as $commune) { 
                              if ($commune['COMMUNE_ID']==$info['COMMUNE_ID']) { 
                                echo "<option value='".$commune['COMMUNE_ID']."' selected>".$commune['COMMUNE_NAME']."</option>";
                              }  else{
                               echo "<option value='".$commune['COMMUNE_ID']."' >".$commune['COMMUNE_NAME']."</option>"; 
                             } }?>                                                              
                           </select>
                              <?php echo form_error('COMMUNE_ID', '<div class="text-danger">', '</div>'); ?>                                
                            </div>

                            <div class="col-md-3">
                              <label><?=lang('label_zone')?><font class="text-danger">*</font></label>
                              <select class="form-control" onchange="get_collines(this.value)"  name="ZONE_ID" id="ZONE_ID">
                               <option value=""><?=lang('selectionner')?></option>
                               <?php foreach($zones as $zone) { 
                                if ($zone['ZONE_ID']==$info['ZONE_ID']) { 
                                  echo "<option value='".$zone['ZONE_ID']."' selected>".$zone['ZONE_NAME']."</option>";
                                }  else{
                                 echo "<option value='".$zone['ZONE_ID']."' >".$zone['ZONE_NAME']."</option>"; 
                               } }?>                                                              
                             </select>
                                <?php echo form_error('ZONE_ID', '<div class="text-danger">', '</div>'); ?>                                
                              </div>

                              <div class="col-md-3">
                                <label><?=lang('label_colline')?><font class="text-danger">*</font></label>
                                <select class="form-control" name="COLLINE_ID" id="COLLINE_ID">
                                 <option value=""><?=lang('selectionner')?></option>
                                 <?php foreach($collines as $colline) { 
                                  if ($colline['COLLINE_ID']==$info['COLLINE_ID']) { 
                                    echo "<option value='".$colline['COLLINE_ID']."' selected>".$colline['COLLINE_NAME']."</option>";
                                  }  else{
                                   echo "<option value='".$colline['COLLINE_ID']."' >".$colline['COLLINE_NAME']."</option>"; 
                                 } }?>                                                              
                               </select>
                                  <?php echo form_error('COLLINE_ID', '<div class="text-danger">', '</div>'); ?>                                
                                </div>

                                <div class="col-md-12"></div><br>

                                <div class="col-md-6">
                                  <label>Usage<font class="text-danger">*</font></label>
                                  <select class="form-control"  name="USAGE" id="USAGE">
                                    <option value="">Sélectionner</option>
                                    <?php foreach($usagers_proprietes as $usager_propriete) { 
                                      if ($usager_propriete['ID_USAGER_PROPRIETE']==$info['USAGE_ID']) { 
                                        echo "<option value='".$usager_propriete['ID_USAGER_PROPRIETE']."' selected>".$usager_propriete['DESCRIPTION_USAGER_PROPRIETE']."</option>";
                                      }  else{
                                        echo "<option value='".$usager_propriete['ID_USAGER_PROPRIETE']."' >".$usager_propriete['DESCRIPTION_USAGER_PROPRIETE']."</option>"; 
                                      } }?>                                                              
                                    </select>
                                    <?php echo form_error('USAGE', '<div class="text-danger">', '</div>'); ?>                                
                                  </div>


                                  <div class="col-md-6">
                                    <label><?=lang('numero_cadastral')?><font class="text-danger">*</font></label>
                                    <input type="text" value="<?=$info['NUMERO_CADASTRAL']?>" oninput="validateValue(this)" class="form-control" name="NUM_CADASTRE" id="NUM_CADASTRE">
                                    <?php echo form_error('NUM_CADASTRE', '<div class="text-danger">', '</div>'); ?>                                
                                  </div>
                        
                 </div>
                



                    <div class="row">                    
                     <div class="col-md-6" style="margin-top: 10px">
                       <button class="btn btn-info right"  type="submit"><?=lang('btn_modification')?></button>
                     </div> 
                   </div> 
                  </form>


               
                


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
   <!-- approuver les alphabets ,les chiffres,tiret and anti slash -->
   <script>
function validateAlphbatesNumbersandDashSlashes(input) {
  var regex = /^[A-Za-z0-9\-\/\s]+$/;
  return regex.test(input);
}

function validateValue(input) {
  var isValid = validateAlphbatesNumbersandDashSlashes(input.value);
  if (!isValid) {
    input.value = input.value.replace(/[^A-Za-z0-9\-\/\s]/g, '');
  }
}
</script>

<!-- fin du script d'approbation -->


<!-- approuver que les chiffres et points ou anti-slash -->
<script>
  function validateAlphabtesNumbersandDots(input) {
    var regex = /^[A-Za-z0-9.\s]+$/;
    return regex.test(input);
}

function validateInfo(input) {
    var isValid = validateAlphabtesNumbersandDots(input.value);
    if (!isValid) {
        input.value = input.value.replace(/[^A-Za-z0-9.\s]/g, '');
    }
}
</script>
<!-- fin approbation que les chiffres et  point ou slash -->


<!-- approuver que les Alphabets en majuscule -->
<script>
  function validateAlphabtesUppercase(input) {
    var regex = /^[A-Z]+$/;
    return regex.test(input);
}

function validateInfoVolume(input) {
    var isValid = validateAlphabtesUppercase(input.value);
    if (!isValid) {
        input.value = input.value.replace(/[^A-Z]/g, '');
    }
}
</script>
<!-- fin approbation que les alphabets en majuscule -->


<!-- approuver que les chiffres -->
<script>
  function validateNumbers(input) {
    var regex = /^[0-9.]+$/;
    return regex.test(input);
}

function validateInfoFolio(input) {
    var isValid = validateNumbers(input.value);
    if (!isValid) {
        input.value = input.value.replace(/[^0-9.]/g, '');
    }
}

</script>
<!-- fin approbation que les chiffres -->





 <script>
  
  function get_communes($id)
  {
    var PROVINCE_ID=$('#PROVINCE_ID').val();
    $('#COMMUNE_ID').html('');
    $('#ZONE_ID').html('<option value="">Sélectionner</option>');
    $('#COLLINE_ID').html('<option value="">Sélectionner</option>');

    $.ajax({
      url: "<?= base_url() ?>administration/Numerisation/get_commune_parcelle/"+PROVINCE_ID,
      type: "GET",
      dataType: "JSON",
      success: function(data) {
        $('#COMMUNE_ID').html(data);
      }
    });
  }

  function get_zones($id)
  {
    var COMMUNE_ID=$('#COMMUNE_ID').val();
    $('#ZONE_ID').html('<option value="">Sélectionner</option>');
    $('#COLLINE_ID').html('<option value="">Sélectionner</option>');

    $.ajax({
      url: "<?= base_url() ?>administration/Numerisation/get_zone_parcelle/"+COMMUNE_ID,
      type: "GET",
      dataType: "JSON",
      success: function(data) {
        $('#ZONE_ID').html(data);
      }
    });
  }

  function get_collines($id)
  {
    var ZONE_ID=$('#ZONE_ID').val();
    $('#COLLINE_ID').html('<option value="">Sélectionner</option>');

    $.ajax({
      url: "<?= base_url() ?>administration/Numerisation/get_colline_parcelle/"+ZONE_ID,
      type: "GET",
      dataType: "JSON",
      success: function(data) {
        $('#COLLINE_ID').html(data);
      }
    });
  }
</script>
















