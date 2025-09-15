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

                <div class="row">
                  <ul class="nav nav-tabs" style="margin-left:20px">
                    <li class="nav-item">
                      <a class="nav-link active" aria-current="page" href="#"><?=lang('title_infos_prop')?></a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#"><?=lang('title_infos_parcel')?></a>
                    </li>
                  </ul>
                </div>
                 <?php //echo $message; ?>
                 <form name="myform" method="post" class="form-horizontal" action="<?= base_url('administration/Numerisation/add_info_requerant'); ?>"  enctype="multipart/form-data">
                 <div class="row">
                  <?php //echo validation_errors()?>
                    <div class="col-md-12">
                    <input type="text"  class="col-md-4 form-control" value="<?=$info['id']?>" name="user_id">
                      
                    </div>
                   <div class="col-md-4" style="margin-top:10px">
                    <label><?=lang('type_requerant')?><font class="text-danger">*</font></label>
                    <select class="form-control"  name="type_requerant_id"  id="type_requerant_id">
                      <option value="">Sélectionner</option>
                      <?php foreach($types_requerants as $types_requerant) { 
                        if ($types_requerant['id']==$info['type_requerant_id']) { 
                          echo "<option value='".$types_requerant['id']."' selected>".$types_requerant['name']."</option>";
                        }  else{
                          echo "<option value='".$types_requerant['id']."' >".$types_requerant['name']."</option>"; 
                        } }?>                                                              
                      </select> 
                      <?php echo form_error('type_requerant_id', '<div class="text-danger">', '</div>'); ?>                                
                    </div>



                    <div class="col-md-4" style="margin-top:10px">
                    <label><?=lang('nationalite')?><font class="text-danger">*</font></label>
                    <select class="form-control info_perso_nationalite"  name="nationalite_id"  id="nationalite_id" <?=$info_nationalite?>>
                      <option value=""><?=lang('selectionner')?></option>
                      <?php foreach($nationalites as $nationalite) { 
                        if ($nationalite['id']==$info['nationalite_id']) { 
                          echo "<option value='".$nationalite['id']."' selected>".$nationalite['name']."</option>";
                        }  else{
                          echo "<option value='".$nationalite['id']."' >".$nationalite['name']."</option>"; 
                        } }?>                                                              
                      </select> 
                      <?php echo form_error('nationalite_id', '<div class="text-danger">', '</div>'); ?>                                
                    </div>

                    <div class="col-md-4" style="margin-top:10px">
                    <label>Genre<font class="text-danger">*</font></label>
                    <select class="form-control info_perso_sexe"  name="sexe_id"  id="sexe_id" <?=$info_sexe?>>
                      <option value=""><?=lang('selectionner')?></option>
                      <?php foreach($sexes as $sexe) { 
                        if ($sexe['SEXE_ID']==$info['sexe_id']) { 
                          echo "<option value='".$sexe['SEXE_ID']."' selected>".$sexe['DESCRIPTION_SEXE']."</option>";
                        }  else{
                          echo "<option value='".$sexe['SEXE_ID']."' >".$sexe['DESCRIPTION_SEXE']."</option>"; 
                        } }?>                                                              
                      </select> 
                      <?php echo form_error('sexe_id', '<div class="text-danger">', '</div>'); ?>                                
                    </div>
                 </div>
                
                 <div class="col-md-12"></div><br>

                 <div class="row col-md-12 info_perso_physique" <?=$info_physique?>>
                  <div class="row">
                  
                    <div class="col-md-3">
                      <label><?=lang('label_nom_users')?><font class="text-danger">*</font></label>
                      <input type="text" class="form-control" oninput="validateInput(this)" name="NOM_PRENOM_PROP" value="<?=$info['NOM_PRENOM_PROP']?>">
                      <?php echo form_error('DATE_NAISSANCE', '<div class="text-danger">', '</div>'); ?>                                
                    </div>

                    <div class="col-md-3">
                      <label><?=lang('date_naissance')?><font class="text-danger">*</font></label>
                      <input type="date" class="form-control" name="DATE_NAISSANCE" id="DATE_NAISSANCE" max="<?=date('Y-m-d')?>" value="<?=$info['DATE_NAISSANCE']?>" onchange="validateAge(this)">
                      <?php echo form_error('DATE_NAISSANCE', '<div class="text-danger">', '</div>'); ?>   
                      <div id="error_alert" style="color: red;"></div>
                    </div>
                    
                    <div class="col-md-3">
                      <label><?=lang('labelle_photo_num')?><font class="text-danger"></font></label>
                      <input type="file" class="form-control" name="PHOTO_PASSEPORT_PROP" id="PHOTO_PASSEPORT_PROP" accept=".png, .jpg, .jpeg">
                      <input type="hidden" class="form-control" name="PHOTO_PASSEPORT_PROP_NEW" value="<?=$info['PHOTO_PASSEPORT_PROP']?>">
                      <?php echo form_error('PHOTO_PASSEPORT_PROP', '<div class="text-danger">', '</div>'); ?>
                      <div><font color="red" id="error_profile"></font></div> 
                    </div>

                    <div class="col-md-3">
                      <label><?=lang('signature_requerant')?><font class="text-danger">*</font></label>
                      <input type="file" class="form-control" name="SIGNATURE_PROP" id="SIGNATURE_PROP" accept=".png, .jpg, .jpeg">
                      <input type="hidden" class="form-control" name="SIGNATURE_PROP_NEW" value="<?=$info['SIGNATURE_PROP']?>">
                      <?php echo form_error('SIGNATURE_PROP', '<div class="text-danger">', '</div>'); ?> 
                      <div><font color="red" id="error_signature"></font></div> 
                    </div>

                  </div>

                  <div class="col-md-12"></div><br>

                  <div class="row">
                    <div class="col-md-3">
                      <label><?=lang('num_cni_passport')?><font class="text-danger">*</font></label>
                      <input type="text" class="form-control" oninput="validateValues(this)" name="NUM_CNI_PROP" value="<?=$info['NUM_CNI_PROP']?>">
                      
                      <?php echo form_error('NUM_CNI_PROP', '<div class="text-danger">', '</div>'); ?>                                
                    </div>


                    <div class="col-md-3">
                      <label><?=lang('image_cni_passport')?><font class="text-danger">*</font></label>
                      <input type="file" class="form-control" name="CNI_IMAGE_PROP" accept=".pdf">
                      <input type="hidden" class="form-control" name="CNI_IMAGE_PROP_NEW" value="<?=$info['CNI_IMAGE_PROP']?>">
                      <?php echo form_error('CNI_IMAGE_PROP', '<div class="text-danger">', '</div>'); ?>                                
                    </div>

                  <div class="col-md-3">
                      <label><?=lang('date_delivrance')?><font class="text-danger">*</font></label>
                      <input type="date" class="form-control" name="DATE_DELIVRANCE" max="<?=date('Y-m-d')?>" value="<?=$info['DATE_DELIVRANCE']?>">
                      <?php echo form_error('DATE_DELIVRANCE', '<div class="text-danger">', '</div>'); ?>                                
                    </div>



                    <div class="col-md-3">
                      <label><?=lang('lieu_delivrance')?><font class="text-danger">*</font></label>
                      <input type="text" class="form-control" oninput="validateInput(this)" name="LIEU_DELIVRANCE" maxlength="100" value="<?=$info['LIEU_DELIVRANCE']?>">
                      <?php echo form_error('LIEU_DELIVRANCE', '<div class="text-danger">', '</div>'); ?>                                
                    </div>

                  </div>

                  <div class="col-md-12"></div><br>
                  <div  class="row info_localite_naissance">

                    <div class="col-md-3" <?=$info_prov_naissance?>>
                      <label><?=lang('label_province_naissance')?><font class="text-danger">*</font></label>
                      <select class="form-control" onchange="get_communes_naissance(this.value)"  name="PROVINCE_ID" id="PROVINCE_ID">
                        <option value=""><?=lang('selectionner')?></option>
                        <?php foreach($provinces_naissance as $province) { 
                          if ($province['PROVINCE_ID']==$info['PROVINCE_ID']) { 
                            echo "<option value='".$province['PROVINCE_ID']."' selected>".$province['PROVINCE_NAME']."</option>";
                          }  else{
                            echo "<option value='".$province['PROVINCE_ID']."' >".$province['PROVINCE_NAME']."</option>"; 
                          } }?>                                                              
                        </select>
                        <?php echo form_error('PROVINCE_ID', '<div class="text-danger">', '</div>'); ?>                                
                      </div>


                      <div class="col-md-3" <?=$info_com_naissance?>>
                        <label><?=lang('label_commune_naissance')?><font class="text-danger">*</font></label>
                        <select class="form-control" onchange="get_zones(this.value)" name="COMMUNE_ID" id="COMMUNE_ID">
                          <option value=""><?=lang('selectionner')?></option>
                          <?php if(!empty($communes)){
                            foreach($communes as $commune){?>
                              
                              <option value="<?=$commune['COMMUNE_ID']?>" <?php if ($commune['COMMUNE_ID']==$info['COMMUNE_ID']) echo "selected";?> ><?=$commune['COMMUNE_NAME']?></option>
                            <?php } }?>
                          </select>
                          <?php echo form_error('COMMUNE_ID', '<div class="text-danger">', '</div>'); ?>                                
                        </div>

                        <div class="col-md-3" <?=$info_prov_naissance?>>
                          <label><?=lang('label_zone')?><font class="text-danger">*</font></label>
                          <select class="form-control" onchange="get_collines(this.value)"  name="ZONE_ID" id="ZONE_ID">
                            <option value=""><?=lang('selectionner')?></option>
                            <?php if(!empty($zones)){

                              foreach($zones as $zone){?>

                                <option value="<?=$zone['ZONE_ID']?>" <?php if ($zone['ZONE_ID']==$info['ZONE_ID']) echo "selected";?> ><?=$zone['ZONE_NAME']?></option>
                              <?php } }?>
                            </select>
                            <?php echo form_error('ZONE_ID', '<div class="text-danger">', '</div>'); ?>                                
                          </div>

                          <div class="col-md-3"  <?=$info_prov_naissance?>>
                            <label><?=lang('label_colline')?><font class="text-danger">*</font></label>
                            <select class="form-control" name="COLLINE_ID" id="COLLINE_ID">
                              <option value=""><?=lang('selectionner')?></option>
                              <?php if(!empty($collines)){

                                foreach($collines as $colline){?>

                                  <option value="<?=$colline['COLLINE_ID']?>" <?php if ($colline['COLLINE_ID']==$info['COLLINE_ID']) echo "selected";?> ><?=$colline['COLLINE_NAME']?></option>
                                <?php } }?>
                              </select>
                              <?php echo form_error('COLLINE_ID', '<div class="text-danger">', '</div>'); ?>                                
                            </div>

                      </div>
                  <div class="col-md-12"></div><br>

                  <div class="row">

                    <div class="col-md-6">
                      <label><?=lang('email')?><font class="text-danger">*</font></label>
                      <input type="email" autocomplete="off" class="form-control" name="EMAIL_PROP" id="EMAIL_PROP" value="<?=$info['EMAIL_PROP']?>">
                      <?php echo form_error('EMAIL_PROP', '<div class="text-danger">', '</div>'); ?>                                
                    </div>

                    <div class="col-md-6">
                      <label><?=lang('numero_telephone')?><font class="text-danger">*</font></label>
                      <input type="text" class="form-control" oninput="validatePhoneNumber(this)" minlength="8" maxlength="12" name="NUM_TEL_PROP"  value="<?=$info['NUM_TEL_PROP']?>" autocomplete="off">
                      <?php echo form_error('NUM_TEL_PROP', '<div class="text-danger">', '</div>'); ?> 
                      <div id="error-message" style="color: red;"></div>
                    </div>

                </div>
                  <div class="col-md-12"></div><br>

                    <div class="row">

                      <div class="col-md-6">
                        <label><?=lang('nom_prenom_pere')?><font class="text-danger">*</font></label>
                        <input type="text" class="form-control" oninput="validateInput(this)" id="NOM_PRENOM_PERE" name="NOM_PRENOM_PERE" value="<?=$info['NOM_PRENOM_PERE']?>">
                        <?php echo form_error('NOM_PRENOM_PERE', '<div class="text-danger">', '</div>'); ?>                                
                      </div>
                      
                      <div class="col-md-6">
                        <label><?=lang('nom_prenom_mere')?><font class="text-danger">*</font></label>
                        <input type="text" class="form-control" oninput="validateInput(this)" name="NOM_PRENOM_MERE" value="<?=$info['NOM_PRENOM_MERE']?>">
                        <?php echo form_error('NOM_PRENOM_MERE', '<div class="text-danger">', '</div>'); ?>                                
                      </div>

                  </div>


                </div>

                <div class="row col-md-12 info_perso_morale" <?=$info_morale?>>
                  
                  <div class="col-md-6">
                    <label>Nom de l'Entreprise<font class="text-danger">*</font></label>
                    <input type="text" class="form-control" oninput="validateInput(this)" id="NOM_ENTREPRISE" name="NOM_ENTREPRISE">
                    <?php echo form_error('NOM_ENTREPRISE', '<div class="text-danger">', '</div>'); ?>   
                    <span id="errNOM_ENTREPRISE" class="text-danger"></span>                                                                  
                  </div>

                  <div class="col-md-6">
                    <label><?=lang('label_nom_representant')?><font class="text-danger">*</font></label>
                    <input type="text" class="form-control" oninput="validateInput(this)" id="NOM_REPRESENTANT" name="NOM_REPRESENTANT">
                    <?php echo form_error('NOM_REPRESENTANT', '<div class="text-danger">', '</div>'); ?>   
                    <span id="errNOM_REPRESENTANT" class="text-danger"></span>                                                              
                  </div>

                  <div class="col-md-12"></div>

                  <div class="col-md-6">
                    <label>Mail du Representant<font class="text-danger">*</font></label>
                    <input type="email" class="form-control" id="EMAIL_REPRESENTANT" name="EMAIL_REPRESENTANT">
                    <?php echo form_error('EMAIL_REPRESENTANT', '<div class="text-danger">', '</div>'); ?> 
                    <span id="errEMAIL_REPRESENTANT" class="text-danger"></span>                           
                  </div>

                  <div class="col-md-6">
                    <label>Numero de Téléphone du Representant<font class="text-danger">*</font></label>
                    <input type="text" class="form-control" oninput="validatePhoneNumber(this)" id="TELEPHONE_REPRESENTANT" name="TELEPHONE_REPRESENTANT" minlength="8" maxlength="12"0>
                    <?php echo form_error('TELEPHONE_REPRESENTANT', '<div class="text-danger">', '</div>'); ?>   
                    <span id="errTELEPHONE_REPRESENTANT" class="text-danger"></span>                       
                  </div>

                  <div class="col-md-12"></div>

                  <div class="col-md-6">
                    <label><?=lang('nif_rc')?><font class="text-danger">*</font></label>
                    <input type="text" class="form-control" name="NIF_RC">
                    <?php echo form_error('NIF_RC', '<div class="text-danger">', '</div>'); ?>
                    <span id="errNIF_RC" class="text-danger"></span>                                           
                  </div>

                  <div class="col-md-6">
                    <label>Signature du Representant<font class="text-danger">*</font></label>
                    <input type="file" class="form-control" name="SIGNATURE_REPRESENTANT" id="SIGNATURE_REPRESENTANT" accept=".png, .jpg, .jpeg">
                    <?php echo form_error('SIGNATURE_REPRESENTANT', '<div class="text-danger">', '</div>'); 
                    ?> 
                    <div><font color="red" id="error_signatureRepresentant"></font></div> 
                    <span id="errSIGNATURE_REPRESENTANT" class="text-danger"></span>
                    <div id="errorMessage" style="color: red;"></div>                            
                  </div>

                </div>

                    <div class="row">
                     <div class="col-md-12" style="margin-top: 10px">
                       <button class="btn btn-info" id="submitButton" type="submit"><?=lang('suivant')?></button>
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

<script>
    $('#message').delay('slow').fadeOut(300000);
</script>
  <!-- controle age >= à 18 -->
<script>
function validateAge(input) {
  const submitButton = document.getElementById('submitButton');
  var selectedDate = new Date(input.value);
  var currentDate = new Date();
  var minDate = new Date(currentDate.getFullYear() - 18, currentDate.getMonth(), currentDate.getDate());
  submitButton.disabled = false;
  $('#error_alert').html('');

  if(selectedDate > minDate)
  {
    $('#error_alert').html('Le requerant doit avoir au minimum 18 ans');
      // Disable the submit button
      submitButton.disabled = true;
    input.value = ""; // Clear the selected date
  }
}
</script>

<!-- verification de la signature -->
<script>
  // Function to handle file input change
  function handleFileInput(fileInput, errorMessage) {
    // Get the file input element and submit button
    const file = fileInput.files[0];
    const submitButton = document.getElementById('submitButton');

    // Check if the file is an image
    if (file && file.type.includes('image')) {
      // Enable the submit button
      submitButton.disabled = false;
      errorMessage.textContent = '';
    } else {
      // Disable the submit button
      submitButton.disabled = true;
      errorMessage.textContent = 'Veuillez uploader un fichier de type image';
    }
  }

  // Get the file input elements and error messages
  const fileSignature = document.getElementById('SIGNATURE_PROP');
  const filePhoto = document.getElementById('PHOTO_PASSEPORT_PROP');
  const errorSignature = document.getElementById('error_signature');
  const errorPhoto = document.getElementById('error_photo');

  // Add event listeners to the file input elements
  fileSignature.addEventListener('change', function () {
    handleFileInput(fileSignature, errorSignature);
  });

  filePhoto.addEventListener('change', function () {
    handleFileInput(filePhoto, errorPhoto);
  });
</script>








<!-- verification de l UPLOAD DE LA CNI
<script>
// Get the file input element and submit button
const filePDF = document.getElementById('CNI_IMAGE_PROP');
const submitButton = document.getElementById('submitButton');

// Add an event listener to the file input element
filePDF.addEventListener('change', function() {
  // Get the selected file
  const file = filePDF.files[0];

  // Check if the file is a PDF
  if (file && file.type === 'application/pdf') {
    // Enable the submit button
    submitButton.disabled = false;
  } else {
    // Disable the submit button
    submitButton.disabled = true;
  }
});
</script> -->

  <script>
$(document).ready(function() {
  //gestion info à saisir par rapport au type de requerant
  $('#type_requerant_id').on('change', function() {
    let val_sel2 = $('#type_requerant_id').val();
    // alert(val_sel2);

    if (val_sel2 == 5) {
      $('.info_perso_morale').show();
      $('.info_perso_physique').hide();
       $('.info_perso_nationalite').hide();
       $('.info_perso_sexe').hide();
    } else if (val_sel2 == 1) {
      $('.info_perso_physique').show();
      $('.info_perso_nationalite').show();
      $('.info_perso_sexe').show();
      $('.info_perso_morale').hide();
    }
  });
});
 </script>   


<script>
    // gestion d'affichage de la localite de naissance
  $('#nationalite_id').on('change', function() {
    let val_sel1 = $('#nationalite_id').val();
    // alert(val_sel2);
    if (val_sel1 == 28) {
      $('.info_localite_naissance').show();
    } else {
      $('.info_localite_naissance').hide();
    }
  })
</script>


 <script>
  
  function get_communes_naissance($id)
  {
    var PROVINCE_ID=$('#PROVINCE_ID').val();
    $.ajax({
      url: "<?= base_url() ?>administration/Numerisation/get_commune_naissance/"+PROVINCE_ID,
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
    $('#ZONE_ID').html('<option value=""><?=lang('selectionner')?></option>');
    $('#COLLINE_ID').html('<option value=""><?=lang('selectionner')?></option>');

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
    $('#COLLINE_ID').html('<option value=""><?=lang('selectionner')?></option>');

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

<!-- approuver que les alphabets -->
<script>
  function validateAlphabets(input) {
    var regex = /^[a-zA-Z\s]+$/;
    return regex.test(input);
}

function validateInput(input) {
    var isValid = validateAlphabets(input.value);
    if (!isValid) {
        input.value = input.value.replace(/[^a-zA-Z\s]/g, '');
    }
}
</script>
<!-- fin approbation que les alphabets -->

<!-- approuver que les chiffres et points ou anti-slash -->
<script>
  function validateNumbersandDotsSlashes(input) {
    var regex = /^[0-9./]+$/;
    return regex.test(input);
}

function validateValue(input) {
    var isValid = validateNumbersandDotsSlashes(input.value);
    if (!isValid) {
        input.value = input.value.replace(/[^0-9./]/g, '');
    }
}

</script>
<!-- fin approbation que les chiffres et  point ou slash -->

  <!-- approuver les alphabets ,les chiffres,tiret and anti slash -->
  <script>
function validateAlphbatesNumbersandDashSlashes(input) {
  var regex = /^[A-Z0-9\-\/\s]+$/;
  return regex.test(input);
}

function validateValues(input) {
  var isValid = validateAlphbatesNumbersandDashSlashes(input.value);
  if (!isValid) {
    input.value = input.value.replace(/[^A-Z0-9\-\/\s]/g, '');
  }
}
</script>

<!-- fin du script d'approbation -->



<!-- approuver que les chiffres -->
<script>
  function validateNumbers(input) {
    var regex = /^[0-9+]+$/;
    return regex.test(input);
}

function validatePhoneNumber(input) {
    var isValid = validateNumbers(input.value);
    if (!isValid) {
        input.value = input.value.replace(/[^0-9+]/g, '');
    }
}

</script>
<!-- fin approbation que les chiffres -->
