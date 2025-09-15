<!DOCTYPE html>
<html lang="en">

<head>
 <?php include VIEWPATH.'includes/header.php'; ?>
</head>
<style type="text/css">
  .stepper-wrapper {
    margin-top: auto;
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
  }
  .stepper-item {
    position: relative;
    display: flex;
    flex-direction: column;
    align-items: center;
    flex: 1;

    @media (max-width: 768px) {
      font-size: 12px;
    }
  }

  .stepper-item::before {
    position: absolute;
    content: "";
    border-bottom: 2px solid #ccc;
    width: 100%;
    top: 20px;
    left: -50%;
    z-index: 2;
  }

  /* Styles pour agrandir le bouton radio */
  .custom-radio {
    transform: scale(1.5);
    /* Ajustez la valeur pour modifier la taille du bouton radio */
    margin-right: 10px;
    /* Ajoutez un espace à droite du bouton radio */
  }

  label {
    font-weight: bold;
    color: #333333;
  }

  .stepper-item::after {
    position: absolute;
    content: "";
    border-bottom: 2px solid #ccc;
    width: 100%;
    top: 20px;
    left: 50%;
    z-index: 2;
  }

  .stepper-item .step-counter {
    position: relative;
    z-index: 5;
    display: flex;
    justify-content: center;
    align-items: center;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #ccc;
    margin-bottom: 6px;
  }

  .stepper-item.active1 {
    font-weight: bold;
    color: #1d2653;
  }

  .stepper-item.completed .step-counter {
    background-color: #fd7e14;
  }

  .stepper-item.completed::after {
    position: absolute;
    content: "";
    border-bottom: 2px solid #fd7e14;
    width: 100%;
    top: 20px;
    left: 50%;
    z-index: 3;
  }

  .stepper-item:first-child::before {
    content: none;
  }

  .stepper-item:last-child::after {
    content: none;
  }

  .header-title888 {
    border: 2px solid;
    padding: 10px;
  }
  /*iiiiiiiiiii*/
  .custom-select {
    border: 1px solid #ccc;
    border-radius: 4px;
    padding: 8px;
    overflow-y: auto;
    max-height: 120px;
  }

  .option {
    cursor: pointer;
    padding: 6px 10px;
  }

  .option:hover {
    background-color: #f0f0f0;
  }

  .option.selected {
    background-color: #d3d3d3;
  }
</style>

<body>
  <style>
    ul li .nav-link.active {
      background-color: #06349b !important;
    }
  </style>
  <style type="text/css">
    /* Set height of body and the document to 100% to enable "full page tabs" */
    body,
    html {
      height: 100%;
      margin: 0;
      font-family: Arial;
    }

    /* Style tab links */
    .tablink {
      background-color: orange;
      color: white;
      float: left;
      border: none;
      outline: none;
      cursor: pointer;
      padding: 14px 16px;
      font-size: 17px;
      width: 25%;
    }

    .tablink:hover {
      background-color: #777;
    }

    /* Style the tab content (and add height:100% for full page content) */
    .tabcontent {
      color: white;
      display: none;
      padding: 100px 20px;
      height: 100%;
    }

/* .border {
border: 1px solid #673BB7 !important;
} */
.card-body {
  padding: 0.35rem;
}

[data-header-position="fixed"] .content-body {
  padding-top: 4rem;
}
</style>
      <head>
       <?php include VIEWPATH.'includes/header.php'; ?>  

<!-- jQuery FIRST -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Select2 AFTER -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- Pour les traductions -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/i18n/fr.js"></script>

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


       /*spin loading*/
           .loading {
        display: none;
        margin: 10px;
        font-weight: bold;
    }

    .spinner {
        display: inline-block;
        width: 50px;
        height: 50px;
        border: 3px solid rgba(0, 0, 0, 0.1);
        border-radius: 50%;
        border-top-color: #3498db;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
     </style>




   </head>
<head>
 <?php include VIEWPATH.'includes/header.php'; ?>
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
       <!-- topbar -->
       <?php include VIEWPATH.'includes/topbar.php'; ?> 
       <!-- end topbar -->
       <!-- end topbar -->
       <!-- dashboard inner -->
       <div class="midde_cont">
        <div class="container-fluid" style="padding: 0px;">




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
            <div class="col-lg-12 table-responsive">
             <?php if($this->session->flashdata('message')): ?>
  <div id="flash-message" class="alert alert-success text-center">
    <?= $this->session->flashdata('message') ?>
  </div>
<?php endif; ?>
            
             </div>           

          <div style="padding-top: 5px;" class="col-md-12">
                    <h2 style="padding-left:20px" class="text-center">Numérisation</h2>
                    <br><br>

                            <div class="row">
                              <div class="col-md-12">
                                <div class="panel panel-default" style="display: block !important;">
                                  <div class='row'>

                                    <div class="col-md-12 py-2">
                                      <!-- progressbar -->
                                      <div class="stepper-wrapper">
                                        <div id="info_div1" class="stepper-item completed active1">
                                          <div class="step-counter">1</div>
                                          <div class="step-name text-center">INFORMATIONS DU MANDATAIRE </div>
                                        </div>
                                        <div id="info_div2" class="stepper-item">
                                          <div class="step-counter">2</div>
                                          <div class="step-name text-center">INFORMATIONS PERSONNELLES </div>
                                        </div>

                                        <div id="info_div3" class="stepper-item">
                                          <div class="step-counter">3</div>
                                          <div class="step-name text-center">INFORMATIONS DE LA PARCELLE</div>
                                        </div>
                                      </div>
                                    </div>
                                    <br>
<div class="col-md-6"></div>
<div class="col-md-1">
<span id="loading_spinner" style="display: none; text-align:center;font-size: 50px">
              <i class="fa fa-spinner fa-spin fa-2x text-primary"></i>
            </span>
          </div>

<!--           <div class="loading" id="loading" style="float: right; margin: 30px;display: none">
  <span class="spinner"></span> -->
<div class="col-md-5"></div>

          <form name="myform" method="post" class="form-horizontal" action="<?= base_url('administration/Numeriser_New/add_info_requerant'); ?>"  enctype="multipart/form-data">

            <div class="tab" id="mandataire_tabs" style="display: block;">
              <div class="row">
                <input type="hidden" id="email_is_uniq">
               <div class="col-md-12" style="margin-top:20px">

                <label style="font-weight: 900; color:#454545" id="">Etes vous un mandataire ?<span style="color:red;">*</span></label><br>
                <div class="row">
                  <div class="col-md-6">
                    <label>
                     <input type="radio" name="mandataire" id="mandataire" onchange="affiche_input(event)" value="1"> OUI 
                   </label> 
                 </div>
                 <div class="col-md-6">
                   <label>
                     <input type="radio" name="mandataire" id="mandataire" onchange="affiche_input(event)" value="2"> Non
                   </label>

                 </div>

                 <input type="hidden" name="myvalue" id="myvalue" value="">
               </div>

             </div>
           </div>


           <div class="col-md-12"></div><br>
           
           <div class="row col-md-12" id="info_mandataire" style="display: none;">
             <div class="row">

              <div class="col-md-4">
               <label><?=lang('label_nom_users')?><font class="text-danger">*</font></label>
               <input type="text" class="form-control" oninput="validateInput(this)" id="NOM_PRENOM_PROP" name="NOM_PRENOM_PROP">
               <span id="errNOM_PRENOM_PROP" class="text-danger"></span> 
             </div>

             <div class="col-md-4">
               <label>Genre<font class="text-danger">*</font></label>
               <select class="form-control"  name="SEXE_ID"  id="SEXE_ID">
                <option value="">Sélectionner</option>
                <?php foreach($sexes as $sexe) { 
                 if ($sexe['SEXE_ID']==set_value('SEXE_ID')) { 
                  echo "<option value='".$sexe['SEXE_ID']."' selected>".$sexe['DESCRIPTION_SEXE']."</option>";
                }  else{
                  echo "<option value='".$sexe['SEXE_ID']."' >".$sexe['DESCRIPTION_SEXE']."</option>"; 
                } }?>                                                              
              </select> 

              <span id="errSEXE_ID" class="text-danger"></span> 
            </div>
            <div class="col-md-4">
              <label><?=lang('num_cni_passport')?><font class="text-danger">*</font></label>
              <input type="text" class="form-control" oninput="validateValues(this)" id="NUM_CNI_PROP" name="NUM_CNI_PROP">
              <span id="errNUM_CNI_PROP" class="text-danger"></span>  

            </div>

<div class="col-md-4">
  <label><?=lang('email')?><font class="text-danger">*</font></label>
  <input type="email" autocomplete="off" required class="form-control" name="EMAIL_PROP" id="EMAIL_PROP" onblur="verifie_mail1()">
  <span id="errEMAIL_PROP" class="text-danger"></span>                                   
</div>
<input type="hidden" id="valide_email1">
<input type="hidden" id="valide_email2">




  <div class="col-md-4">
  <label><?=lang('numero_telephone')?><font class="text-danger">*</font></label>
  <input type="text" class="form-control" oninput="validatePhoneNumber2(this)" minlength="8" maxlength="12" id="NUM_TEL_PROP" name="NUM_TEL_PROP" autocomplete="off">
  
  <div id="error-message" style="color: red;"></div>
  <span id="errNUM_TEL_PROP" class="text-danger"></span> 
</div>
<input type="hidden" id="valide_phone1">

            <div class="col-md-4">
              <label><?=lang('labelle_photo_num')?><font class="text-danger"></font></label>
              <input type="file" class="form-control" name="PHOTO_PASSEPORT_PROP" id="PHOTO_PASSEPORT_PROP" accept=".png, .jpg, .jpeg">
              
              <div><font color="red" id="error_profile"></font></div> 
              <span id="errPHOTO_PASSEPORT_PROP" class="text-danger"></span>  
              <div id="error_alert" style="color: red;"></div>
              <div id="errorMessage" style="color: red;"></div>
            </div>

            <div class="col-md-4">
              <label><?=lang('signature_requerant')?><font class="text-danger">*</font></label>
              <input type="file" class="form-control" name="SIGNATURE_PROP" id="SIGNATURE_PROP" accept=".png, .jpg, .jpeg">
              
              <div><font color="red" id="error_signature"></font></div> 
              <span id="errSIGNATURE_PROP" class="text-danger"></span> 
              <div id="errorMessage" style="color: red;"></div>
            </div>

            <div class="col-md-4">
              <label><?=lang('image_cni_passport')?><font class="text-danger">*</font></label>
              <input type="file" class="form-control" name="CNI_IMAGE_PROP" id="CNI_IMAGE_PROP" accept=".pdf">
              <input type="hidden" class="form-control" name="CNI_IMAGE_PROP_NEW" >
              <span id="errCNI_IMAGE_PROP" class="text-danger"></span>  
            </div>

            <div class="col-md-4">
              <label>Procuration<font class="text-danger">*</font></label>
              <input type="file" class="form-control" name="CNI_IMAGE_PROP2" id="CNI_IMAGE_PROP2" accept=".pdf">
              <input type="hidden" class="form-control" name="CNI_IMAGE_PROP2" value="<?=set_value('CNI_IMAGE_PROP2')?>">
              <?php echo form_error('CNI_IMAGE_PROP2', '<div class="text-danger">', '</div>'); ?>
              <span id="errCNI_IMAGE_PROP2" class="text-danger"></span>  
            </div>

          </div>

        </div>

        <div class="row col-md-12" id="div_tabs1" style="display: none">
          <div class="col-md-12">
           <div style="margin-top: 20px; overflow: auto;">
            <div style="float: right;">
             <button style="margin-left: 10px;" id="btn_enregistrer" type="button" class="my-4 btn btn-primary" onclick="suivant_infos_requerant();">
               Suivant >>
             </button>
           </div>
         </div> 
       </div>
     </div>
   </div>

   <script type="text/javascript">

    function exist_mail1(){
    var email = $('#EMAIL_PROP').val().trim();
    $.ajax({
  url : "<?=base_url()?>administration/Numeriser_New/exist_mail2/", 
  type : "POST",
  dataType : "Json",
  data:{
    email:email
  },
  cache : false,

    beforeSend: function() {
        $('#loading_spinner').show();
    },
success:function(data) {
        // alert(data)
    $("#EMAIL_PROP").css("border", "");
    $("#EMAIL_PROP2").css("border", "");
    $("#EMAIL_REPRESENTANT").css("border", "");
   if(data.statut==0){
    $('#info_div1').removeClass('active1');
    $('#info_div2').removeClass('active1');
    $('#info_div2').addClass('completed');
    $('#info_div1').addClass('completed');

   document.getElementById('requerant_info').style.display="block"; 
    $('#etape1').addClass('active1');
    $("#check_email_mandataire").html('');
 }else if(data.statut==1){
   document.getElementById('requerant_info').style.display="none"; 
   document.getElementById('mandataire_tabs').style.display="block";

    $('#info_div1').removeClass('active1');
    $('#info_div1').addClass('completed');

    $("#check_email_mandataire").html('<div class="alert alert-danger text-center">L\'adresse e-mail existe déjà!</div>');
    $("#check_mail").html("");
    $("#check_mail3").html();
    $("#check_parcelle").html();
    $("#errEMAIL_PROP").html("E-mail existe déjà.");
    $("#EMAIL_PROP").css("border", "1px solid red");

 }
 else if(data.statut==3){
   document.getElementById('requerant_info').style.display="none"; 
   document.getElementById('mandataire_tabs').style.display="block";

    $('#info_div1').removeClass('active1');
    $('#info_div1').addClass('completed');

    $("#check_email_mandataire").html('<div class="alert alert-danger text-center">L\'adresse e-mail existe déjà dans BPS!</div>');
    $("#errEMAIL_PROP").html("E-mail existe déjà.");

 }
 else{
  document.getElementById('requerant_info').style.display="block"; 
   document.getElementById('mandataire_tabs').style.display="none";

    $('#info_div1').removeClass('active1');
    $('#info_div1').addClass('completed');
$("#check_email_mandataire").html('');
$("#errEMAIL_PROP").html("");
 }



   },
    complete: function() {
        // 👇 Cacher le loader une fois terminé
        $('#loading_spinner').hide();
    },

    error: function() {
        // 👇 En cas d’erreur serveur
        $('#loading_spinner').hide();
        alert("Une erreur est survenue. Veuillez réessayer.");
    }

});
   }
     
   </script>


   <div class="tab" id="requerant_info" style="display: none">
    <div class="row">

      <div class="col-md-4" style="margin-top:10px">
       <label>Type de parcelle<font class="text-danger">*</font></label>
       <select class="form-control"  name="type_parcelle"  id="type_parcelle" onchange="afficher_btn_cart(this.value)">
         <option value=""><?=lang('selectionner')?></option>
         <option value="1">Propriété personnelle</option>
         <option value="2">Copropriété</option>
         <option value="3">Succession</option>
       </select> 
       <?php echo form_error('type_parcelle', '<div class="text-danger">', '</div>'); ?>
       <span id="errtype_parcelle" class="text-danger"></span>
     </div>

     <div class="col-md-4" style="margin-top:10px">
      <input type="hidden" name="" id="type_requerant_id1" value="">

      <label><?=lang('type_requerant')?><font class="text-danger">*</font></label>
      <select class="form-control"  name="type_requerant_id"  id="type_requerant_id">
       <option value=""><?=lang('selectionner')?></option>
       <?php foreach($types_requerants as $types_requerant) { 
        if ($types_requerant['id']==set_value('type_requerant_id')) { 
         echo "<option value='".$types_requerant['id']."' selected>".$types_requerant['name']."</option>";
       }  else{
         echo "<option value='".$types_requerant['id']."' >".$types_requerant['name']."</option>"; 
       } }



       ?> 
     </select> 
     <?php echo form_error('type_requerant_id', '<div class="text-danger">', '</div>'); ?>
     <span id="errtype_requerant_id" class="text-danger"></span>
   </div>

  <div class="col-md-4" id="hide_succedent" style="display: none;margin-top:10px">
   <label>Testateur/Défunt<font class="text-danger">*</font></label>
   <input type="text" class="form-control" oninput="validateInput(this)" id="SUCCENDANT" name="SUCCENDANT" value="<?=set_value('SUCCENDANT')?>">
   <?php echo form_error('SUCCENDANT', '<div class="text-danger">', '</div>'); ?>
   <span id="errSUCCENDANT" class="text-danger"></span> 
 </div>



   <!-- ggfhgjhj -->
   <div class="col-md-4" style="margin-top:10px">
    <label><?=lang('nationalite')?><font class="text-danger">*</font></label>
    <select class="form-control dynamic-select2 info_perso_nationalite" name="nationalite_id" id="nationalite_id" data-placeholder="<?=lang('selectionner')?>">
        <option value=""><?=lang('selectionner')?></option> <!-- Option vide nécessaire pour le placeholder -->
        <?php foreach($nationalites as $nationalite) { 
            $selected = ($nationalite['id'] == set_value('nationalite_id')) ? 'selected' : '';
            echo "<option value='{$nationalite['id']}' {$selected}>{$nationalite['name']}</option>";
        } ?>
    </select>
    <?php echo form_error('nationalite_id', '<div class="text-danger">', '</div>'); ?>
    <span id="errnationalite_id" class="text-danger"></span>
</div>

</div>

<div class="col-md-12"></div><br>

<div class="row col-md-12 info_perso_physique" <?=$info_physique?>>
 <div class="row">

  <div class="col-md-4">
   <label><?=lang('label_nom_users')?><font class="text-danger">*</font></label>
   <input type="text" class="form-control" oninput="validateInput(this)" id="NOM_PRENOM_PROP2" name="NOM_PRENOM_PROP2" value="<?=set_value('NOM_PRENOM_PROP2')?>">
   <?php echo form_error('NOM_PRENOM_PROP2', '<div class="text-danger">', '</div>'); ?>
   <span id="errNOM_PRENOM_PROP2" class="text-danger"></span> 
 </div>

 <div class="col-md-4">
   <label>Genre<font class="text-danger">*</font></label>
   <select class="form-control"  name="SEXE_ID2"  id="SEXE_ID2">
    <option value="">Sélectionner</option>
    <?php foreach($sexes as $sexe) { 
     if ($sexe['SEXE_ID']==set_value('SEXE_ID')) { 
      echo "<option value='".$sexe['SEXE_ID']."' selected>".$sexe['DESCRIPTION_SEXE']."</option>";
    }  else{
      echo "<option value='".$sexe['SEXE_ID']."' >".$sexe['DESCRIPTION_SEXE']."</option>"; 
    } }?>                                                              
  </select> 
  <?php echo form_error('SEXE_ID', '<div class="text-danger">', '</div>'); ?>
  <span id="errsexe_id2" class="text-danger"></span> 
</div>

<div class="col-md-4">
  <label><?=lang('date_naissance')?><font class="text-danger">*</font></label>
  <input type="date" 
       class="form-control" 
       name="DATE_NAISSANCE" 
       id="DATE_NAISSANCE" 
       max="<?= date('Y-m-d') ?>" 
       value="<?= set_value('DATE_NAISSANCE', date('Y-m-d', strtotime('-18 years'))) ?>" 
       onchange="validateAge2(this)">
  <?php echo form_error('DATE_NAISSANCE', '<div class="text-danger">', '</div>'); ?> 
  <span id="errDATE_NAISSANCE" class="text-danger"></span>  
  <div id="error_alertDATE_NAISSANCE" style="color: red;"></div>
</div>

<script>
function validateAge2(input) {
    const selectedDate = new Date(input.value);
    const today = new Date();
    const minAgeDate = new Date();
    minAgeDate.setFullYear(today.getFullYear() - 18);
    
    if (selectedDate > minAgeDate) {
        $('#errDATE_NAISSANCE').html('Vous devez avoir au moins 18 ans');
        input.value = '<?= date("Y-m-d", strtotime("-18 years")) ?>'; // Réinitialise à 18 ans
    }
}
</script>


<div class="col-md-4">
  <label><?=lang('labelle_photo_num')?><font class="text-danger"></font></label>
  <input type="file" class="form-control" name="PHOTO_PASSEPORT_PROP2" id="PHOTO_PASSEPORT_PROP2" accept=".png, .jpg, .jpeg">
  <?php echo form_error('PHOTO_PASSEPORT_PROP2', '<div class="text-danger">', '</div>'); ?>
  <div><font color="red" id="error_profile2"></font></div> 
  <span id="errPHOTO_PASSEPORT_PROP2" class="text-danger"></span>  
  <div id="error_alert2" style="color: red;"></div>
  <div id="errorMessage2" style="color: red;"></div>
</div>

<div class="col-md-4">
  <label><?=lang('signature_requerant')?><font class="text-danger">*</font></label>
  <input type="file" class="form-control" name="SIGNATURE_PROP2" id="SIGNATURE_PROP2" accept=".png, .jpg, .jpeg">
  <?php echo form_error('SIGNATURE_PROP2', '<div class="text-danger">', '</div>'); ?> 
  <div><font color="red" id="error_signature2"></font></div> 
  <span id="errSIGNATURE_PROP2" class="text-danger"></span> 
  <div id="errorMessage2" style="color: red;"></div>
</div>

<div class="col-md-4">
  <label><?=lang('image_cni_passport')?><font class="text-danger">*</font></label>
  <input type="file" class="form-control" name="CNI_IMAGE_PROP3" id="CNI_IMAGE_PROP3" accept=".pdf">
  <input type="hidden" class="form-control" name="CNI_IMAGE_PROP3" value="<?=set_value('CNI_IMAGE_PROP3')?>">
  <?php echo form_error('CNI_IMAGE_PROP3', '<div class="text-danger">', '</div>'); ?>
  <span id="errCNI_IMAGE_PROP3" class="text-danger"></span>  
</div>

<div class="col-md-4">
  <label><?=lang('num_cni_passport')?><font class="text-danger">*</font></label>
  <input type="text" class="form-control" oninput="validateValues(this)" id="NUM_CNI_PROP3" name="NUM_CNI_PROP3" value="<?=set_value('NUM_CNI_PROP3')?>">

  <?php echo form_error('NUM_CNI_PROP3', '<div class="text-danger">', '</div>'); ?>
  <span id="errNUM_CNI_PROP3" class="text-danger"></span>  

</div>


<div class="col-md-4">
  <label><?=lang('date_delivrance')?><font class="text-danger">*</font></label>
  <input type="date" class="form-control" id="DATE_DELIVRANCE" name="DATE_DELIVRANCE" max="<?=date('Y-m-d')?>"  value="<?=set_value('DATE_DELIVRANCE')?>">
  <?php echo form_error('DATE_DELIVRANCE', '<div class="text-danger">', '</div>'); ?>
  <span id="errDATE_DELIVRANCE" class="text-danger"></span>                                  
</div>

<div class="col-md-4">
  <label><?=lang('lieu_delivrance')?><font class="text-danger">*</font></label>
  <input type="text" class="form-control" oninput="validateInput(this)" id="LIEU_DELIVRANCE"  name="LIEU_DELIVRANCE" maxlength="100"  value="<?=set_value('LIEU_DELIVRANCE')?>">
  <?php echo form_error('LIEU_DELIVRANCE', '<div class="text-danger">', '</div>'); ?>
  <span id="errLIEU_DELIVRANCE" class="text-danger"></span> 
</div>

<div class="col-md-4">
  <label><?=lang('email')?><font class="text-danger">*</font></label>
  <input type="email" autocomplete="off" required class="form-control" name="EMAIL_PROP2" id="EMAIL_PROP2" onblur="verifie_mail3()">
  <?php echo form_error('EMAIL_PROP2', '<div class="text-danger">', '</div>'); ?>
  <span id="errEMAIL_PROP2" class="text-danger"></span>                                  
</div>
<input type="hidden" id="valide_email3">

<div class="col-md-4">
  <label><?= lang('numero_telephone') ?><font class="text-danger">*</font></label>
  <input type="text" 
         class="form-control" 
         oninput="validatePhoneNumber3(this)" 
         minlength="8" 
         maxlength="12" 
         id="NUM_TEL_PROP2" 
         name="NUM_TEL_PROP2"  
         value="<?= set_value('NUM_TEL_PROP2') ?>" 
         autocomplete="off">
  
  <?= form_error('NUM_TEL_PROP2', '<div class="text-danger">', '</div>'); ?> 
  <div id="error-message2" style="color: red;"></div>
  <span id="errNUM_TEL_PROP2" class="text-danger"></span> 
</div>

<input type="hidden" id="valide_phone2">
<input type="hidden" id="valide_phone3">


<div class="col-md-4">
  <label><?=lang('nom_prenom_pere')?><font class="text-danger">*</font></label>
  <input type="text" class="form-control" oninput="validateInput(this)" id="NOM_PRENOM_PERE" name="NOM_PRENOM_PERE" value="<?=set_value('NOM_PRENOM_PERE')?>">
  <?php echo form_error('NOM_PRENOM_PERE', '<div class="text-danger">', '</div>'); ?>
  <span id="errNOM_PRENOM_PERE" class="text-danger"></span>                                 
</div>

<div class="col-md-4">
  <label><?=lang('nom_prenom_mere')?><font class="text-danger">*</font></label>
  <input type="text" class="form-control" oninput="validateInput(this)" id="NOM_PRENOM_MERE" name="NOM_PRENOM_MERE" value="<?=set_value('NOM_PRENOM_MERE')?>">
  <?php echo form_error('NOM_PRENOM_MERE', '<div class="text-danger">', '</div>'); ?>
  <span id="errNOM_PRENOM_MERE" class="text-danger"></span>                                   
</div>

</div>
</div>

<!--  <div class="col-md-12"></div> -->

<div  class="row info_localite_naissance">

  <div class="col-md-4" <?=$info_prov_naissance?>>
   <label><?=lang('label_province_naissance')?><font class="text-danger">*</font></label>
   <select class="form-control" onchange="get_communes_naissance(this.value)"  name="PROVINCE_ID" id="PROVINCE_ID">
    <option value=""><?=lang('selectionner')?></option>
    <?php foreach($provinces_naissance as $province) { 
     if ($province['PROVINCE_ID']==set_value('PROVINCE_ID')) { 
      echo "<option value='".$province['PROVINCE_ID']."' selected>".$province['PROVINCE_NAME']."</option>";
    }  else{
      echo "<option value='".$province['PROVINCE_ID']."' >".$province['PROVINCE_NAME']."</option>"; 
    } }?>                                                              
  </select>
  <?php echo form_error('PROVINCE_ID', '<div class="text-danger">', '</div>'); ?>
  <span id="errPROVINCE_ID" class="text-danger"></span>                                  
</div>


<div class="col-md-4" <?=$info_com_naissance?>>
  <label><?=lang('label_commune_naissance')?><font class="text-danger">*</font></label>
  <select class="form-control" onchange="get_zones_naissance(this.value)" name="COMMUNE_ID" id="COMMUNE_ID">
   <option value=""><?=lang('selectionner')?></option>
   <?php if(!empty($communes)){
    foreach($communes as $commune){?>

     <option value="<?=$commune['COMMUNE_ID']?>" <?php if ($commune['COMMUNE_ID']==set_value('COMMUNE_ID')) echo "selected";?> ><?=$commune['COMMUNE_NAME']?></option>
     <?php } }?>
   </select>
   <?php echo form_error('COMMUNE_ID', '<div class="text-danger">', '</div>'); ?>
   <span id="errCOMMUNE_ID" class="text-danger"></span>                                
 </div>


 <div class="col-md-4" <?=$info_zon_naissance?>>
   <label><?=lang('label_zone')?><font class="text-danger">*</font></label>
   <select class="form-control" onchange="get_collines_naissance(this.value)"  name="ZONE_ID" id="ZONE_ID">
    <option value=""><?=lang('selectionner')?></option>
    <?php if(!empty($zones)){

     foreach($zones as $zone){?>

      <option value="<?=$zone['ZONE_ID']?>" <?php if ($zone['ZONE_ID']==set_value('ZONE_ID')) echo "selected";?> ><?=$zone['ZONE_NAME']?></option>
      <?php } }?>
    </select>
    <?php echo form_error('ZONE_ID', '<div class="text-danger">', '</div>'); ?> 
    <span id="errZONE_ID" class="text-danger"></span>                                                                               
  </div>

  <div class="col-md-4" <?=$info_col_naissance?>>
    <label><?=lang('label_colline')?><font class="text-danger">*</font></label>
    <select class="form-control" name="COLLINE_ID" id="COLLINE_ID">
     <option value=""><?=lang('selectionner')?></option>
     <?php if(!empty($collines_parcelles)){

      foreach($collines_parcelles as $colline){?>

       <option value="<?=$colline['COLLINE_ID']?>" <?php if ($colline['COLLINE_ID']==set_value('COLLINE_ID')) echo "selected";?> ><?=$colline['COLLINE_NAME']?></option>
       <?php } }?>
     </select>
     <?php echo form_error('COLLINE_ID', '<div class="text-danger">', '</div>'); ?>  
     <span id="errCOLLINE_ID" class="text-danger"></span>                                                                               
   </div>

 </div>

 <div class="row info_perso_morale" <?=$info_morale?>>
  <div class="col-md-12">
   <div class="row">

    <div class="col-md-4">
     <label>Nom Entreprise<font class="text-danger">*</font></label>
     <input type="text" class="form-control" oninput="validateInput(this)" id="NOM_ENTREPRISE" name="NOM_ENTREPRISE">
     <?php echo form_error('NOM_ENTREPRISE', '<div class="text-danger">', '</div>'); ?>   

     <span id="errNOM_ENTREPRISE" class="text-danger"></span>                           
   </div>

   <div class="col-md-4">
     <label><?=lang('label_nom_representant')?><font class="text-danger">*</font></label>
     <input type="text" class="form-control" oninput="validateInput(this)" id="NOM_REPRESENTANT" name="NOM_REPRESENTANT">
     <?php echo form_error('NOM_REPRESENTANT', '<div class="text-danger">', '</div>'); ?>   

     <span id="errNOM_REPRESENTANT" class="text-danger"></span>                           

   </div>

   <div class="col-md-4">
     <label>Mail du Representant<font class="text-danger">*</font></label>
     <input type="email" autocomplete="off" required class="form-control" name="EMAIL_REPRESENTANT" id="EMAIL_REPRESENTANT" onblur="verifie_mail2()">
     <?php echo form_error('EMAIL_REPRESENTANT', '<div class="text-danger">', '</div>'); ?> 
     <span id="errEMAIL_REPRESENTANT" class="text-danger"></span>                           
   </div>

   <!--  <div class="col-md-12"></div> -->

   <div class="col-md-4">
     <label>Numero de Téléphone du Representant<font class="text-danger">*</font></label>
      <input type="text" class="form-control" oninput="validatePhoneNumber4(this)" minlength="8" maxlength="12" id="TELEPHONE_REPRESENTANT" name="TELEPHONE_REPRESENTANT" autocomplete="off">
     <?php echo form_error('TELEPHONE_REPRESENTANT', '<div class="text-danger">', '</div>'); ?>   
     <span id="errTELEPHONE_REPRESENTANT" class="text-danger"></span>                       
   </div>


   <div class="col-md-4">
     <label><?=lang('nif_rc')?><font class="text-danger">*</font></label>
     <input type="text" class="form-control" id="NIF_RC" name="NIF_RC">
     <?php echo form_error('NIF_RC', '<div class="text-danger">', '</div>'); ?>   

     <span id="errNIF_RC" class="text-danger"></span>                       

   </div>


   <!--  <div class="col-md-12"></div> -->

   <div class="col-md-4">
     <label><?=lang('signature_representant')?><font class="text-danger">*</font></label>
     <input type="file" class="form-control" name="SIGNATURE_REPRESENTANT" id="SIGNATURE_REPRESENTANT" accept=".png, .jpg, .jpeg">
     <?php echo form_error('SIGNATURE_REPRESENTANT', '<div class="text-danger">', '</div>'); 
     ?> 
     <div><font color="red" id="error_signatureRepresentant"></font></div> 
     <span id="errSIGNATURE_REPRESENTANT" class="text-danger"></span>
     <div id="errorMessage" style="color: red;"></div>                            
   </div>
 </div>
</div>
</div>


<!--  <div class="col-md-12"></div> -->
<div class="row copropriete">
  <div class="col-md-12">
    <div class="row">
     <div class="col-md-12" id="button_cart" style="display: none">


                  <div style="float: right;font-size: 20px;">
         <button style="margin-left: 10px;" id="btn_cart" id="btn_enregistrer" type="button" class="my-4 btn btn-success" onclick="cart_save()" style="display: none">Ajouter
          <i class="fa fa-shopping-cart" style="font-size: 20px" aria-hidden="true"></i><span class="spinner" id="btn_cart_spine" style="font-size: 20px; display: none;"></span>
        </button>
      </div>
    </div>
<!--     <input type="hidden" name="nombre" id="nombre"> -->
   </div>
    <div class="col-md-12" id="mycart">

  <?=$infos_cart;?>

</div>
    <div class="col-md-6">
      <div style="float: left;">
       <button style="margin-left: 10px;" id="btn_enregistrer" type="button" class="my-4 btn btn-primary" onclick="precedent_info_mandantaire()">
        << Précédant
      </button> 
    </div>

  </div>

<input type="hidden" name="nombre" id="nombre">
<!-- <div class="col-md-3"></div> -->
  <div class="col-md-12" id="hide_suivant" id="button_prec" style="display: block">
    <div style="float: right;">
     <button style="margin-left: 10px;"  id="btn_enregistrer" type="button" class="my-4 btn btn-primary" onclick="suivant_info_parcelle()">
       Suivant >>
     </button>
   </div>

 </div>

 <script type="text/javascript">
  function exist_mail(){
    var email = $('#EMAIL_REPRESENTANT').val().trim();
    var email2 = $('#EMAIL_PROP2').val().trim();
    // if ($('#type_parcelle').val()==1 || $('#type_parcelle').val()=="") {
    if (email=="") {
      email = email2;
    }
    $.ajax({
  url : "<?=base_url()?>administration/Numeriser_New/exist_mail2/", 
  type : "POST",
  dataType : "Json",
  data:{
    email:email
  },
  cache : false,
success:function(data) {
        // alert(data)
        if(data.statut==0){
          // alert("eric") ;
    document.getElementById('requerant_info').style.display="none"; 
    document.getElementById('parcelle_info').style.display="block";
    $('#info_div1').addClass('completed'); 
    $('#info_div2').addClass('completed'); 
    $('#info_div1').removeClass('active1');
    $('#info_div2').addClass('active1');
    $('#info_div3').addClass('active1'); 
    $('#info_div3').addClass('completed'); 
    $("#check_email_mandataire").html('');
       } else if(data.statut==1){
        $("#check_email_mandataire").html('<div class="alert alert-danger text-center">L\'adresse e-mail existe déjà!</div>');

          $("#check_mail").html('');
        $("#check_mail3").html('');
       } else{
        $("#check_email_mandataire").html('');
        $("#check_mail").html('');
        $("#check_mail3").html('');

$("#EMAIL_PROP2").css("border", "");
$("#EMAIL_REPRESENTANT").css("border", "");
$("#errEMAIL_REPRESENTANT").html("");
$("#errEMAIL_PROP2").html("");
       }
   },

});
  // }
  
  }


 </script>


</div>
</div>

</div>



</div> 
<div class="tab" id="parcelle_info" style="display: none;">
 <div class="row">
  <div class="col-md-12 py-2"> 
   <!-- <h5 style="color: #1d2653" class="text-left ml-0"><b>INFORMATIONS DU REPRESANTANT</b></h5> -->
 </div>
 <div class="col-md-4">
   <label><?=lang('label_parcelle_number')?><font class="text-danger">*</font></label>
   <input type="text" oninput="validateValueParcelle(this)"  class="form-control" name="NUM_PARCEL" id="NUM_PARCEL">
   <?php echo form_error('NUM_PARCEL', '<div class="text-danger">', '</div>'); ?>    
   <span id="errNUM_PARCEL" class="text-danger"></span>                              
 </div>
 <div class="col-md-4"> 
   <label><?=lang('nature_dossier')?><font class="text-danger">*</font></label>
   <select class="form-control"  name="NATURE_DOC" id="NATURE_DOC">
    <option value=""><?=lang('selectionner')?></option>
    <?php foreach($type_nature_docs as $type_nature_doc) { 
     if ($type_nature_doc['ID_DOSSIER']==set_value('ID_DOSSIER')) { 
      echo "<option value='".$type_nature_doc['ID_DOSSIER']."' selected>".$type_nature_doc['DOSSIER']."</option>";
    }  else{
      echo "<option value='".$type_nature_doc['ID_DOSSIER']."' >".$type_nature_doc['DOSSIER']."</option>"; 
    } }?>                                                              
  </select>
  <?php echo form_error('NATURE_DOC', '<div class="text-danger">', '</div>'); ?>  
  <span id="errNATURE_DOC" class="text-danger"></span>                                   
</div>

<div class="col-md-4">
  <label><?=lang('num_ordre_special')?><font class="text-danger">*</font></label>
  <input type="text" class="form-control" oninput="validateInfo(this)" name="NUMERO_SPECIAL" id="NUMERO_SPECIAL" value="<?=set_Value('NUMERO_SPECIAL')?>">
  <?php echo form_error('NUMERO_SPECIAL', '<div class="text-danger">', '</div>'); ?>   
  <span id="errNUMERO_SPECIAL" class="text-danger"></span>                                   
</div>

<div class="col-md-12"></div>

<div class="col-md-6">
  <label>Volume<font class="text-danger">*</font></label>
  <input type="text" oninput="validateInfoVolume(this)" class="form-control" name="VOLUME" id="VOLUME" value="<?=set_Value('VOLUME')?>">
  <?php echo form_error('VOLUME', '<div class="text-danger">', '</div>'); ?>  
  <span id="errVOLUME" class="text-danger"></span>                                                                                  
</div>


<div class="col-md-6">
  <label>Folio<font class="text-danger">*</font></label>
  <input type="number" oninput="validateFolio(this)" class="form-control" name="FOLIO" min="0"
         max="200"
         step="0.01" id="FOLIO" value="<?=set_Value('FOLIO')?>">
  <?php echo form_error('FOLIO', '<div class="text-danger">', '</div>'); ?>  
  <span id="errFOLIO" class="text-danger"></span>                                                                                 
</div>

<script>
function validateFolio(input) {
  const errorElement = document.getElementById('errFOLIO'); // ID corrigé
  let value = parseFloat(input.value);

  // Réinitialiser les états d'erreur
  input.classList.remove('is-invalid');
  errorElement.textContent = '';

  // Validation
  if (isNaN(value)) {
    showError2(input, errorElement, 'Veuillez saisir un nombre valide');
    return;
  }

  if (value < 0) {
    input.value = 0;
    return;
  }

  if (value > 200) {
    input.value = 200;
    showError(input, errorElement, 'Le folio ne peut pas dépasser 200');
    return;
  }

  // Formatage à deux décimales
  if (input.value.includes('.') && input.value.split('.')[1].length > 2) {
    input.value = value.toFixed(2);
  }
}

function showError2(input, errorElement, message) {
  input.classList.add('is-invalid');
  errorElement.textContent = message;
}

// Validation initiale si valeur existante
document.addEventListener('DOMContentLoaded', () => {
  const input = document.getElementById('FOLIO');
  if (input.value) validateFolio(input); // fonction corrigée ici aussi
});
</script>



<div class="col-md-12"></div><br>

<div class="col-md-3">
  <label><?=lang('superficie_ha')?><font class="text-danger">*</font></label>
  <input type="text"  oninput="validateInfoFolio(this)" class="form-control" name="SUPER_HA" id="SUPER_HA" value="<?=set_Value('SUPER_HA')?>">
  <?php echo form_error('SUPER_HA', '<div class="text-danger">', '</div>'); ?>   
  <span id="errSUPER_HA" class="text-danger"></span>                                                                                
</div>                         


<div class="col-md-3">
  <label><?=lang('superficie_a')?><font class="text-danger">*</font></label>
  <input type="text"  oninput="validateInfoFolio(this)" class="form-control" name="SUPER_ARE" id="SUPER_ARE" value="<?=set_Value('SUPER_ARE')?>">
  <?php echo form_error('SUPER_ARE', '<div class="text-danger">', '</div>'); ?>  
  <span id="errSUPER_ARE" class="text-danger"></span>                                                                                
</div> 

<div class="col-md-3">
  <label><?=lang('superficie_ca')?><font class="text-danger">*</font></label>
  <input type="text"   oninput="validateInfoFolio(this)"  class="form-control" name="SUPER_CA" id="SUPER_CA"  value="<?=set_Value('SUPER_CA')?>">
  <?php echo form_error('SUPER_CA', '<div class="text-danger">', '</div>'); ?> 
  <span id="errSUPER_CA" class="text-danger"></span>                                                                                
</div> 


<div class="col-md-3">
  <label>Pourcentage <span class="text-danger"></span></label>
  <input type="number" 
         class="form-control"
         name="POUR100" 
         id="POUR100"  
         min="0"
         max="100"
         step="0.01"
         oninput="validatePercentage(this)"
         value="<?= set_Value('POUR100') ?>"
         required>
  
  <div class="invalid-feedback" id="error_POUR100"></div>
  <?php echo form_error('POUR100', '<div class="text-danger">', '</div>'); ?> 
</div>

<script>
function validatePercentage(input) {
  const errorElement = document.getElementById('error_POUR100');
  let value = parseFloat(input.value);
  
  // Réinitialiser les états d'erreur
  input.classList.remove('is-invalid');
  errorElement.textContent = '';
  
  // Validation
  if (isNaN(value)) {
    showError(input, errorElement, 'Veuillez saisir un nombre valide');
    return;
  }
  
  if (value < 0) {
    input.value = 0;
    return;
  }
  
  if (value > 100) {
    input.value = 100;
    showError(input, errorElement, 'Le pourcentage ne peut pas dépasser 100%');
    return;
  }
  
  // Formatage à deux décimales
  if (input.value.split('.')[1]?.length > 2) {
    input.value = value.toFixed(2);
  }
}

function showError(input, errorElement, message) {
  input.classList.add('is-invalid');
  errorElement.textContent = message;
}

// Validation initiale si valeur existante
document.addEventListener('DOMContentLoaded', () => {
  const input = document.getElementById('POUR100');
  if (input.value) validatePercentage(input);
});
</script>

<style>
/* Style pour les champs invalides */
.is-invalid {
  border-color: #dc3545;
  background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
  background-repeat: no-repeat;
  background-position: right calc(0.375em + 0.1875rem) center;
  background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
}
</style>


<div class="col-md-12"></div><br>

<div class="col-md-3">
  <label><?=lang('label_province')?><font class="text-danger">*</font></label>
  <select class="form-control" onchange="get_communes(this.value)"  name="PROVINCE_ID1" id="PROVINCE_ID1">
   <option value=""><?=lang('selectionner')?></option>
   <?php foreach($provinces as $province) { 
    if ($province['PROVINCE_ID']==set_value('PROVINCE_ID1')) { 
     echo "<option value='".$province['PROVINCE_ID']."' selected>".$province['PROVINCE_NAME']."</option>";
   }  else{
     echo "<option value='".$province['PROVINCE_ID']."' >".$province['PROVINCE_NAME']."</option>"; 
   } }?>                                                              
 </select>
 <?php echo form_error('PROVINCE_ID1', '<div class="text-danger">', '</div>'); ?>
 <span id="errPROVINCE_ID1" class="text-danger"></span>                                                                                
</div>


<div class="col-md-3">
 <label><?=lang('label_commune')?><font class="text-danger">*</font></label>
 <select class="form-control" onchange="get_zones(this.value)"  name="COMMUNE_ID1" id="COMMUNE_ID1">
  <option value=""><?=lang('selectionner')?></option>
  <?php if(!empty($communes_parcelles)){

   foreach($communes_parcelles as $commune){?>

    <option value="<?=$commune['COMMUNE_ID']?>" <?php if ($commune['COMMUNE_ID']==set_value('COMMUNE_ID1')) echo "selected";?> ><?=$commune['COMMUNE_NAME']?></option>
    <?php } }?>
  </select>
  <?php echo form_error('COMMUNE_ID1', '<div class="text-danger">', '</div>'); ?> 
  <span id="errCOMMUNE_ID1" class="text-danger"></span>                                                                               
</div>

<div class="col-md-3">
  <label><?=lang('label_zone')?><font class="text-danger">*</font></label>
  <select class="form-control" onchange="get_collines(this.value)"  name="ZONE_ID1" id="ZONE_ID1">
   <option value=""><?=lang('selectionner')?></option>
   <?php if(!empty($zones_parcelles)){

    foreach($zones_parcelles as $zone){?>

     <option value="<?=$zone['ZONE_ID']?>" <?php if ($zone['ZONE_ID']==set_value('ZONE_ID1')) echo "selected";?> ><?=$zone['ZONE_NAME']?></option>
     <?php } }?>
   </select>
   <?php echo form_error('ZONE_ID1', '<div class="text-danger">', '</div>'); ?> 
   <span id="errZONE_ID1" class="text-danger"></span>                                                                               
 </div>

 <div class="col-md-3">
   <label><?=lang('label_colline')?><font class="text-danger">*</font></label>
   <select class="form-control" name="COLLINE_ID1" id="COLLINE_ID1">
    <option value=""><?=lang('selectionner')?></option>
    <?php if(!empty($collines_parcelles)){

     foreach($collines_parcelles as $colline){?>

      <option value="<?=$colline['COLLINE_ID']?>" <?php if ($colline['COLLINE_ID']==set_value('COLLINE_ID1')) echo "selected";?> ><?=$colline['COLLINE_NAME']?></option>
      <?php } }?>
    </select>
    <?php echo form_error('COLLINE_ID1', '<div class="text-danger">', '</div>'); ?>  
    <span id="errCOLLINE_ID1" class="text-danger"></span>                                                                               
  </div>

  <div class="col-md-12"></div><br>

  <div class="col-md-6">
    <label>Usage<font class="text-danger">*</font></label>
    <select class="form-control"  name="USAGE" id="USAGE">
     <option value=""><?=lang('selectionner')?></option>
     <?php foreach($usagers_proprietes as $usager_propriete) { 
      if ($usager_propriete['ID_USAGER_PROPRIETE']==set_value('USAGE')) { 
       echo "<option value='".$usager_propriete['ID_USAGER_PROPRIETE']."' selected>".$usager_propriete['DESCRIPTION_USAGER_PROPRIETE']."</option>";
     }  else{
       echo "<option value='".$usager_propriete['ID_USAGER_PROPRIETE']."' >".$usager_propriete['DESCRIPTION_USAGER_PROPRIETE']."</option>"; 
     } }?>                                                              
   </select>
   <?php echo form_error('USAGE', '<div class="text-danger">', '</div>'); ?>   
   <span id="errUSAGE" class="text-danger"></span>                                                                               
 </div>


 <div class="col-md-6">
   <label><?=lang('numero_cadastral')?><font class="text-danger">*</font></label>
   <input type="text" class="form-control" name="NUM_CADASTRE" id="NUM_CADASTRE" value="" readonly >
   <?php echo form_error('NUM_CADASTRE', '<div class="text-danger">', '</div>'); ?>  
   <span id="errNUM_CADASTRE" class="text-danger"></span>                                                                               
 </div>  
</div>



<div class="row">

  <div class="col-md-6"style="margin-top: 20px; overflow: auto;">
   <div style="float: left;">
    <button id="btn_retour" type="button" style="margin-right: 10px;" class="my-4 btn btn-primary" onclick="toggleTabs()">
     << Précédant
   </button>
 </div>
</div>

<div class="col-md-6">
 <div style="float: right;">
  <button id="btn_save" type="button" style="margin-left: 10px;display: block;" class="my-4 btn btn-success" onclick="buttonSave()">
   Enregistrer
 </button>
 
 <div class="loading" id="loading" style="float: right; margin: 30px;display: none">
  <span class="spinner"></span>
  <span>Enregistrement en cours...</span>
</div>

</div>
</div>

</div>


</div> 

</form>


</div>
</div>
</div>
<!-- end row -->
</div>
</div></div></div>
</div></div></div></div></div></div></div></div></div>
<?php include VIEWPATH.'includes/scripts_oposition_js.php'; ?>

<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
<script src="<?php echo base_url() ?>template/js/bootstrap.min.js"></script>



</body>
</html> 
<script type="text/javascript">

 function affiche_input(event) {

   var val_oui_non = event.target.value;

   $('#myvalue').val(val_oui_non);

   if (val_oui_non==1) {
     document.getElementById('info_mandataire').style.display="block"; 
     document.getElementById('div_tabs1').style.display="block"; 

   }else if(val_oui_non==2){
     document.getElementById('info_mandataire').style.display="none";
     document.getElementById('div_tabs1').style.display="none";  
     document.getElementById('div_tabs1').style.display="block"; 
   }else{
    document.getElementById('info_mandataire').style.display="none"; 
    document.getElementById('div_tabs1').style.display="none";  
  }


}
</script>

<script type="text/javascript">
  function suivant_infos_requerant(argument) {
    var radioo=$('#myvalue').val();
    document.getElementById('mandataire_tabs').style.display="none"; 
    var statut = true; 
    if(radioo==1){
     var NOM_PRENOM_PROP = $('#NOM_PRENOM_PROP').val();
     if(NOM_PRENOM_PROP == "")
     {
      statut = false;
      $("#errNOM_PRENOM_PROP").html("Champ obligatoire");  
    }
    else
    {
      $("#errNOM_PRENOM_PROP").html("");
      statut = true;
    }
    var SEXE_ID = $('#SEXE_ID').val();
    if(SEXE_ID == "")
    {
      statut = false;
      $("#errSEXE_ID").html("Champ obligatoire");  
    }
    else
    {
      $("#errSEXE_ID").html("");
      statut = true;
    }
    var NUM_CNI_PROP = $('#NUM_CNI_PROP').val();
    if(NUM_CNI_PROP == "")
    {
      statut = false;
      $("#errNUM_CNI_PROP").html("Champ obligatoire");  
    }
    else
    {
      $("#errNUM_CNI_PROP").html("");
      statut = true;
    }

    var valide_email1 = $('#valide_email1').val();
    var EMAIL_PROP = $('#EMAIL_PROP').val();
    // if(EMAIL_PROP == "")
    // {
    //   statut = false;
    //   $("#errEMAIL_PROP").html("Champ obligatoire");  
    // }else 
    if(valide_email1 != 1) {
      $("#errEMAIL_PROP").html("Entrer l'e-mail valide.");
      $("#EMAIL_PROP").css("border", "1px solid red");
      statut = false;
    }
    else {
      $("#errEMAIL_PROP").html("");
      $("#EMAIL_PROP").css("border", "");
      statut = true;
    }

    var NUM_TEL_PROP = $('#NUM_TEL_PROP').val();

    var valide_phone1 = $('#valide_phone1').val();
    if (valide_phone1 == 0) {
      $("#errNUM_TEL_PROP").html("Entrer numéro de téléphone valide.");
      $("#NUM_TEL_PROP").css("border", "1px solid red");
      statut = false;
    }    
    else
    {
      $("#errNUM_TEL_PROP").html("");
      $("#NUM_TEL_PROP").css("border", "");
      statut = true;
    }

    // alert(valide_phone1)
    var PHOTO_PASSEPORT_PROP = $('#PHOTO_PASSEPORT_PROP').val();
    if(PHOTO_PASSEPORT_PROP == "")
    {
      statut = false;
      $("#errPHOTO_PASSEPORT_PROP").html("Champ obligatoire");  
    }
    else
    {
      $("#errPHOTO_PASSEPORT_PROP").html("");
      statut = true;
    }
    var SIGNATURE_PROP = $('#SIGNATURE_PROP').val();
    if(SIGNATURE_PROP == "")
    {
      statut = false;
      $("#errSIGNATURE_PROP").html("Champ obligatoire");  
    }
    else
    {
      $("#errSIGNATURE_PROP").html("");
      statut = true;
    }
    var CNI_IMAGE_PROP = $('#CNI_IMAGE_PROP').val();
    if(CNI_IMAGE_PROP == "")
    {
      statut = false;
      $("#errCNI_IMAGE_PROP").html("Champ obligatoire");  
    }
    else
    {
      $("#errCNI_IMAGE_PROP").html("");
      statut = true;
    }
    var CNI_IMAGE_PROP2 = $('#CNI_IMAGE_PROP2').val();
    if(CNI_IMAGE_PROP2 == "")
    {
      statut = false;
      $("#errCNI_IMAGE_PROP2").html("Champ obligatoire");  
    }
    else
    {
      $("#errCNI_IMAGE_PROP2").html("");
      statut = true;
    }
  }else {
    statut = true;
  }
if (radioo == 1) {
    var cond = (statut === true && valide_email1 == 1 && valide_phone1 == 1);
} else {
    var cond = (statut === true);
}

if (cond) {
    if (radioo == 1) {
        exist_mail1();
    } else {
        $('#info_div1').removeClass('active1');
        $('#info_div2').removeClass('active1');
        $('#info_div2').addClass('completed');
        $('#info_div1').addClass('completed');

        document.getElementById('requerant_info').style.display = "block"; 
        $('#etape1').addClass('active1');
        $("#check_email_mandataire").html('');
    }
}

 else{
     document.getElementById('requerant_info').style.display="none"; 
   document.getElementById('mandataire_tabs').style.display="block";

    $('#info_div1').removeClass('active1');
    $('#info_div1').addClass('completed');
 }

}
</script>
<script type="text/javascript">
  function precedent_info_mandantaire(argument) {
    document.getElementById('mandataire_tabs').style.display="block"; 
    document.getElementById('requerant_info').style.display="none"; 
  }
</script>




<script type="text/javascript">
  function cart_save(argument) {

   var form=new FormData();
   let statut = 1;

   if ($("#type_parcelle").val() == "") 
   {
    statut = 2;
    $("#errtype_parcelle").html("Champ obligatoire");
  }
  else
  {
    $("#errtype_parcelle").html("");
  }

  if ($("#type_requerant_id").val() == "") 
  {
    statut = 2;
    $("#errtype_requerant_id").html("Champ obligatoire");
  }
  else
  {
    $("#errtype_requerant_id").html("");
  }


  if ($("#nationalite_id").val() == "")
  {
    statut = 2;
    $("#errnationalite_id").html("Champ obligatoire");
  }
  else
  {
    $("#errnationalite_id").html("");
  }

  if ($("#type_requerant_id").val() == 1) 
  { 

    if ($("#NOM_PRENOM_PROP2").val() == "")
    {
     statut = 2;
     $("#errNOM_PRENOM_PROP2").html("Champ obligatoire");
   }
   else
   {
     $("#errNOM_PRENOM_PROP2").html("");
   }

   if($("#SEXE_ID2").val() == "")
   {
     statut = 2;

     $("#errsexe_id2").html("Champ obligatoire");
   }
   else
   {
     $("#errsexe_id2").html("");
   }


   if ($("#nationalite_id").val()!= "" && $("#nationalite_id").val()==28)
   {
     if ($("#PROVINCE_ID").val() == "")
     {
      statut = 2;
      $("#errPROVINCE_ID").html("Champ obligatoire");
    }
    else
    {
      $("#errPROVINCE_ID").html("");
    }

    if ($("#COMMUNE_ID").val() == "")
    {
      statut = 2;
      $("#errCOMMUNE_ID").html("Champ obligatoire");
    }
    else
    {
      $("#errCOMMUNE_ID").html("");
    }

    if ($("#ZONE_ID").val() == "")
    {
      statut = 2;
      $("#errZONE_ID").html("Champ obligatoire");
    }
    else
    {
      $("#errZONE_ID").html("");
    }

    if ($("#COLLINE_ID").val() == "")
    {
      statut = 2;
      $("#errCOLLINE_ID").html("Champ obligatoire");
    }
    else
    {
      $("#errCOLLINE_ID").html("");
    }
  }


  if ($("#NUM_CNI_PROP3").val() == "")
  {
   statut = 2;
   $("#errNUM_CNI_PROP3").html("Champ obligatoire");
 }
 else
 {
   $("#errNUM_CNI_PROP3").html("");
 }

 if ($("#LIEU_DELIVRANCE").val() == "")
 {
   statut = 2;
   $("#errLIEU_DELIVRANCE").html("Champ obligatoire");
 }
 else
 {
   $("#errNUM_CNI_PROP3").html("");
 }

 if ($("#EMAIL_PROP2").val() == "")
 {
   statut = 2;
   $("#errEMAIL_PROP2").html("Champ obligatoire");
 }
  { 
   $("#errEMAIL_PROP2").html("");
 }

  if ($("#valide_email3").val() == 0)
 {
   statut = 2;
   $("#errEMAIL_PROP2").html("E-mail invalide");
 }
  { 
   $("#errEMAIL_PROP2").html("");
 }

 if ($("#NUM_TEL_PROP2").val() == "")
 {
   statut = 2;
   $("#errNUM_TEL_PROP2").html("Champ obligatoire");
 }
 else
 {
   $("#errNUM_TEL_PROP2").html("");
 }

 if ($('#valide_phone2').val() != 1) {
  $("#errNUM_TEL_PROP2").html("Numéro de téléphone invalide.");
  $("#NUM_TEL_PROP2").css("border", "1px solid red");
  statut = 2;
 } else
 {
   $("#errNUM_TEL_PROP2").html("");
 }

   if ($("#valide_phone2").val() == 0)
  {
    statut = 2;
    $("#errNUM_TEL_PROP2").html("Numéro invalide");
  }
  else
  {
    $("#errNUM_TEL_PROP2").html("");
  }

 if ($("#NOM_PRENOM_PERE").val() == "")
 {
   statut = 2;
   $("#errNOM_PRENOM_PERE").html("Champ obligatoire");
 }
 else
 {
   $("#errNOM_PRENOM_PERE").html("");
 }

 if ($("#NOM_PRENOM_MERE").val() == "")
 {
   statut = 2;
   $("#errNOM_PRENOM_MERE").html("Champ obligatoire");
 }
 else
 {
   $("#errNOM_PRENOM_MERE").html("");
 }

 if ($("#DATE_NAISSANCE").val() == "")
 {
   statut = 2;
   $("#errDATE_NAISSANCE").html("Champ obligatoire");
 }
 else
 {
   $("#errDATE_NAISSANCE").html("");
 }

 if ($("#DATE_DELIVRANCE").val() == "")
 {
   statut = 2;
   $("#errDATE_DELIVRANCE").html("Champ obligatoire");
 }
 else
 {
   $("#errDATE_DELIVRANCE").html("");
 }
 
 var file = document.getElementById("CNI_IMAGE_PROP3");
 var file2 = document.getElementById("SIGNATURE_PROP2");
 var file3 = document.getElementById("PHOTO_PASSEPORT_PROP2");

 if (file.files.length == 0) 
   {  statut = 2;

    $("#errCNI_IMAGE_PROP3").html("Champ obligatoire");
  }else{


    $('#CNI_IMAGE_PROP3').css('border-color','white');
    $("#errCNI_IMAGE_PROP3").html(" ");
  }


  if (file2.files.length == 0) 
    {  statut = 2;

        $("#errSIGNATURE_PROP2").html("Champ obligatoire");
      }else{


        $('#SIGNATURE_PROP2').css('border-color','white');
        $("#errSIGNATURE_PROP2").html(" ");
      }



      if (file3.files.length == 0) 
        {  statut = 2;
;
        $("#errPHOTO_PASSEPORT_PROP2").html("Champ obligatoire");
      }else{


        $('#PHOTO_PASSEPORT_PROP2').css('border-color','white');
        $("#errPHOTO_PASSEPORT_PROP2").html(" ");
      } 

    }


    if ($("#type_requerant_id").val()==5) {

     if ($("#nationalite_id").val()!= "" && $("#nationalite_id").val()==28)
     {
      if ($("#PROVINCE_ID").val() == "")
      {
       statut = 2;
       $("#errPROVINCE_ID").html("Champ obligatoire");
     }
     else
     {
       $("#errPROVINCE_ID").html("");
     }

     if ($("#COMMUNE_ID").val() == "")
     {
       statut = 2;
       $("#errCOMMUNE_ID").html("Champ obligatoire");
     }
     else
     {
       $("#errCOMMUNE_ID").html("");
     }

     if ($("#ZONE_ID").val() == "")
     {
       statut = 2;
       $("#errZONE_ID").html("Champ obligatoire");
     }
     else
     {
       $("#errZONE_ID").html("");
     }

     if ($("#COLLINE_ID").val() == "")
     {
       statut = 2;
       $("#errCOLLINE_ID").html("Champ obligatoire");
     }
     else
     {
       $("#errCOLLINE_ID").html("");
     }
   }


   if ($("#NOM_REPRESENTANT").val() == "")
   {
    statut = 2;
    $("#errNOM_REPRESENTANT").html("Champ obligatoire");
  }
  else
  {
    $("#errNOM_REPRESENTANT").html("");
  }

  if ($("#NOM_ENTREPRISE").val() == "")
  {
    statut = 2;
    $("#errNOM_ENTREPRISE").html("Champ obligatoire");
  }
  else
  {
    $("#errNOM_ENTREPRISE").html("");
  }

   if ($("#valide_email2").val() == 0)
  {
    statut = 2;
    $("#errEMAIL_REPRESENTANT").html("E-mail invalide");
    $("#EMAIL_REPRESENTANT").css("border", "1px solid red");
  } else
  {
    $("#errEMAIL_REPRESENTANT").html("");
    $("#EMAIL_REPRESENTANT").css("border", "");
  }

  if ($("#TELEPHONE_REPRESENTANT").val() == "")
  {
    statut = 2;
    $("#errTELEPHONE_REPRESENTANT").html("Champ obligatoire");
  }
  else
  {
    $("#errTELEPHONE_REPRESENTANT").html("");
  }

  if ($("#valide_phone3").val() == 0)
  {
    statut = 2;
    $("#errTELEPHONE_REPRESENTANT").html("Numéro invalide");
  }
  else
  {
    $("#errTELEPHONE_REPRESENTANT").html("");
  }


  if ($("#NIF_RC").val() == "")
  {
    statut = 2;
    $("#errNIF_RC").html("Champ obligatoire");
  }
  else
  {
    $("#errNIF_RC").html("");
  }


  var file1 = document.getElementById("SIGNATURE_REPRESENTANT");

  if (file1.files.length == 0) 
    {  statut = 2;


        //$('#errCNI_IMAGE_PROP').css('border-color','red');
        $("#errSIGNATURE_REPRESENTANT").html("Champ obligatoire");
      }else{


        $('#SIGNATURE_REPRESENTANT').css('border-color','white');
        $("#errSIGNATURE_REPRESENTANT").html(" ");
      }


    }

    
    if ($("#type_parcelle").val()==3) {
         if ($("#SUCCENDANT").val() == "")
      {
        statut = 2;
        $("#errSUCCENDANT").html("Champ obligatoire");
      }
      else
      {
        $("#errSUCCENDANT").html("");
      }
    }

    var CNI_IMAGE_PROP=$('#CNI_IMAGE_PROP3')[0].files[0];
    var PHOTO_PASSEPORT_PROP=$('#PHOTO_PASSEPORT_PROP2')[0].files[0];
    var SIGNATURE_PROP=$('#SIGNATURE_PROP2')[0].files[0];

    var type_requerant_id=$('#type_requerant_id').val();

    form.append("TYPE_PARCELLE",$("#type_parcelle").val());
   // alert()
form.append("SUCCENDANT",$("#SUCCENDANT").val());
   if ($("#type_requerant_id").val()==1) {
  // form.append("type_requerant_id",$("#type_requerant_id").val());   
  form.append("NOM_PRENOM_PROP",$("#NOM_PRENOM_PROP2").val());
  
  form.append("SEXE_ID",$("#SEXE_ID2").val());
  form.append("nationalite_id",$("#nationalite_id").val());
  form.append("PROVINCE_ID",$("#PROVINCE_ID").val());
  form.append("COMMUNE_ID",$("#COMMUNE_ID").val());
  form.append("ZONE_ID",$("#ZONE_ID").val());
  form.append("COLLINE_ID",$("#COLLINE_ID").val());
  form.append("NUM_CNI_PROP",$("#NUM_CNI_PROP3").val());
  form.append("DATE_NAISSANCE",$("#DATE_NAISSANCE").val());
  form.append("DATE_DELIVRANCE",$("#DATE_DELIVRANCE").val());
  form.append("LIEU_DELIVRANCE",$("#LIEU_DELIVRANCE").val());
  form.append("EMAIL_PROP",$("#EMAIL_PROP2").val());
  form.append("NUM_TEL_PROP",$("#NUM_TEL_PROP2").val());
  form.append("NOM_PRENOM_PERE",$("#NOM_PRENOM_PERE").val());
  form.append("NOM_PRENOM_MERE",$("#NOM_PRENOM_MERE").val());
  form.append("CNI_IMAGE_PROP",CNI_IMAGE_PROP);
  form.append("PHOTO_PASSEPORT_PROP",PHOTO_PASSEPORT_PROP);
  form.append("SIGNATURE_PROP",SIGNATURE_PROP);

}

if ($("#type_requerant_id").val()==5) {

  var SIGNATURE_REPRESENTANT=$('#SIGNATURE_REPRESENTANT')[0].files[0];

   // form.append("type_requerant_id",$("#type_requerant_id").val());  
   form.append("NOM_ENTREPRISE",$("#NOM_ENTREPRISE").val());
   form.append("NOM_REPRESENTANT",$("#NOM_REPRESENTANT").val());
   form.append("EMAIL_REPRESENTANT",$("#EMAIL_REPRESENTANT").val());
   form.append("TELEPHONE_REPRESENTANT",$("#TELEPHONE_REPRESENTANT").val());
   form.append("NIF_RC",$("#NIF_RC").val());
   form.append("SIGNATURE_REPRESENTANT",SIGNATURE_REPRESENTANT);
   form.append("nationalite_id",$("#nationalite_id").val());
   form.append("PROVINCE_ID",$("#PROVINCE_ID").val());
   form.append("COMMUNE_ID",$("#COMMUNE_ID").val());
   form.append("ZONE_ID",$("#ZONE_ID").val());
   form.append("COLLINE_ID",$("#COLLINE_ID").val());
 }

 var NOM_PRENOM_PROP = $('#NOM_PRENOM_PROP').val();
 var SEXE_ID = $('#SEXE_ID').val();
 var NUM_CNI_PROP = $('#NUM_CNI_PROP').val();
 var EMAIL_PROP = $('#EMAIL_PROP').val();
 var NUM_TEL_PROP = $('#NUM_TEL_PROP').val();
 var PHOTO_PASSEPORT_PROP = $('#PHOTO_PASSEPORT_PROP').val();
 var SIGNATURE_PROP = $('#SIGNATURE_PROP').val();
 var CNI_IMAGE_PROP = $('#CNI_IMAGE_PROP').val();
 var CNI_IMAGE_PROP2 = $('#CNI_IMAGE_PROP2').val();
var SUCCENDANT = $("#SUCCENDANT").val()

var validemail2 = $('#valide_email2').val();
var valideemail3 = $('#valide_email3').val();

var type_requerant_id2 = $('#type_requerant_id').val();
var validephone2 = $('#valide_phone2').val();
var validephone3 = $('#valide_phone3').val();

if (type_requerant_id2 ==5) {
  var cond =(statut==1 && validemail2 ==1 && validephone2 ==1);
}else{
  cond = (statut==1);
}


 const btn = document.getElementById("btn_cart");
  const spinner = document.getElementById("btn_cart_spine");


if (statut==1) 
{

 btn.disabled = true;
 spinner.style.display = ".disinline-block";
  var email = $('#EMAIL_REPRESENTANT').val().trim();
  var email2 = $('#EMAIL_PROP2').val().trim();

  if (email=="") {
    email = email2;
  }
  $.ajax({
    url : "<?=base_url()?>administration/Numeriser_New/exist_mail2/", 
    type : "POST",
    dataType : "Json",
    data:{
      email:email
    },
    cache : false,
        beforeSend: function() {
        $('#btn_cart_spine').show();
        $('#btn_cart').prop('disabled', true);

    },

    success:function(data) {
      $('#btn_cart_spine').hide();
      $('#btn_cart').prop('disabled', true);
      if(data.statut==0){
      $('#btn_cart_spine').show();
        $('#type_requerant_id1').val($("#type_requerant_id").val());
        form.append("type_requerant_id",$("#type_requerant_id1").val());
        var type_parcelle = $("#type_parcelle").val();
        $('#type_parcelle').prop('disabled', true);
        $("#SUCCENDANT").prop('disabled', true);
        $('#btn_cart').prop('disabled', true);

        $('#btn_save').show(); 

        $('#btn_cart_spine').show();

        $.ajax({
          url:"<?=base_url('administration/Numeriser_New/insert_in_cart')?>",
          data:form,
          type:'POST',
          contentType:false,
          dataType:'JSON',
          processData:false,
          success:function(response)
          {
            $("#check_mail").html("");
            $("#EMAIL_PROP2").css("border", "");
            $("#EMAIL_REPRESENTANT").css("border", "");
            if (response.nombre>0) 
            {
             $('#mycart').html(response.file_html);
             $("#check_mail").html("");
             var nombre = response.nombre;
             if(nombre == 0){
              $("#check_email_mandataire").html("");
              $("#check_mail3").html();
              $("#check_parcelle").html();


              if ($("#EMAIL_PROP2").val()!="") {
                $("#EMAIL_PROP2").css("border", "1px solid red");
                $("#errEMAIL_PROP2").html("E-mail existe déjà.");
              }else if ($("#EMAIL_REPRESENTANT").val()!=""){
                $("#EMAIL_REPRESENTANT").css("border", "1px solid red");
                $("#errEMAIL_REPRESENTANT").html("E-mail existe déjà.");
              }
            }
            if(nombre>=2){
              $("#hide_suivant").show();
            }else {
              $("#hide_suivant").hide();
            }

            $('#nationalite_id').val("");
            $('#NOM_PRENOM_PROP2').val("");
            $('#SEXE_ID2').val("");
            $('#DATE_NAISSANCE').val("");
            $('#PHOTO_PASSEPORT_PROP2').val("");
            $('#SIGNATURE_PROP2').val("");
            $('#CNI_IMAGE_PROP3').val("");
            $('#NUM_CNI_PROP3').val("");
            $('#DATE_DELIVRANCE').val("");
            $('#LIEU_DELIVRANCE').val("");
            $('#EMAIL_PROP2').val("");
            $('#NUM_TEL_PROP2').val("");
            $('#NOM_PRENOM_PERE').val("");
            $('#NOM_PRENOM_MERE').val("");
            $('#PROVINCE_ID').val("");
            $('#COMMUNE_ID').val("");
            $('#ZONE_ID').val("");
            $('#COLLINE_ID').val("");
            $('#NOM_ENTREPRISE').val("");
            $('#NOM_REPRESENTANT').val("");
            $('#EMAIL_REPRESENTANT').val("");
            $('#TELEPHONE_REPRESENTANT').val("");
            $('#NIF_RC').val("");
            $('#SIGNATURE_REPRESENTANT').val("");

            $('#type_requerant_id').val(type_requerant_id);
            $('#type_parcelle').val(type_parcelle);
            $("#SUCCENDANT").val(SUCCENDANT);
            $('#btn_cart').prop('disabled', false);
            $('#btn_cart_spine').hide();
            $('#check_mail3').html('');
          }else{

            $('#btn_cart').prop('disabled', false);
            $('#btn_cart_spine').hide();
            $('#check_mail3').html('<div class="alert alert-danger text-center">L\'adresse e-mail existe déjà!</div>');
            $("#check_mail").html("");
            $("#check_email_mandataire").html();
            $("#check_parcelle").html();

            if ($("#EMAIL_PROP2").val()!="") {
              $("#EMAIL_PROP2").css("border", "1px solid red");
              $("#errEMAIL_PROP2").html("E-mail existe déjà.");
            }else if ($("#EMAIL_REPRESENTANT").val()!=""){
              $("#EMAIL_REPRESENTANT").css("border", "1px solid red");
              $("#errEMAIL_REPRESENTANT").html("E-mail existe déjà.");
            }    
          }

        }

      });
      }else{
        $('#btn_cart').prop('disabled', false);
      $('#btn_cart_spine').hide();

        if ($("#EMAIL_PROP2").val()!="") {
          $("#EMAIL_PROP2").css("border", "1px solid red");
          $("#errEMAIL_PROP2").html("E-mail existe déjà.");
        }else if ($("#EMAIL_REPRESENTANT").val()!=""){
          $("#EMAIL_REPRESENTANT").css("border", "1px solid red");
          $("#errEMAIL_REPRESENTANT").html("E-mail existe déjà.");
        }
      }
    },

 complete: function () {
  $('#btn_cart_spine').hide();
},
error: function () {
  $('#btn_cart_spine').hide();
  $('#btn_cart').prop('disabled', false); // Permettre de réessayer
  alert("Une erreur est survenue.");
}


  });

}   
}


function suivant_info_parcelle(argument) {

 var statut = 1;
 var type_parcelle =$("#type_parcelle").val()

 if (type_parcelle !=2){
  // alert(type_parcelle);
  
  if ($("#type_parcelle").val() == "") 
  {
    statut = 2;
    $("#errtype_parcelle").html("Champ obligatoire");
  }
  else
  {
    $("#errtype_parcelle").html("");
  }

    if ($("#type_parcelle").val() == 3) 
  {    
    if ($("#SUCCENDANT").val() == "") 
  {
    
    statut = 2;
    $("#errSUCCENDANT").html("Champ obligatoire");
  }
  else
  {
    $("#errSUCCENDANT").html("");
  }}


  if ($("#type_requerant_id").val() == "") 
  {
    statut = 2;
    $("#errtype_requerant_id").html("Champ obligatoire");
  }
  else
  {
    $("#errtype_requerant_id").html("");
  }


  if ($("#nationalite_id").val() == "")
  {
    statut = 2;
    $("#errnationalite_id").html("Champ obligatoire");
  }
  else
  {
    $("#errnationalite_id").html("");
  }



  if ($("#type_requerant_id").val() == 1) 
  { 

    if ($("#NOM_PRENOM_PROP2").val() == "")
    {
     statut = 2;
     $("#errNOM_PRENOM_PROP2").html("Champ obligatoire");
   }
   else
   {
     $("#errNOM_PRENOM_PROP2").html("");
   }

   if($("#SEXE_ID2").val() == "")
   {
     statut = 2;

     $("#errsexe_id2").html("Champ obligatoire");
   }
   else
   {
     $("#errsexe_id2").html("");
   }


   if ($("#nationalite_id").val()!= "" && $("#nationalite_id").val()==28)
   {
     if ($("#PROVINCE_ID").val() == "")
     {
      statut = 2;
      $("#errPROVINCE_ID").html("Champ obligatoire");
    }
    else
    {
      $("#errPROVINCE_ID").html("");
    }

    if ($("#COMMUNE_ID").val() == "")
    {
      statut = 2;
      $("#errCOMMUNE_ID").html("Champ obligatoire");
    }
    else
    {
      $("#errCOMMUNE_ID").html("");
    }

    if ($("#ZONE_ID").val() == "")
    {
      statut = 2;
      $("#errZONE_ID").html("Champ obligatoire");
    }
    else
    {
      $("#errZONE_ID").html("");
    }

    if ($("#COLLINE_ID").val() == "")
    {
      statut = 2;
      $("#errCOLLINE_ID").html("Champ obligatoire");
    }
    else
    {
      $("#errCOLLINE_ID").html("");
    }
  }


  if ($("#NUM_CNI_PROP3").val() == "")
  {
   statut = 2;
   $("#errNUM_CNI_PROP3").html("Champ obligatoire");
 }
 else
 {
   $("#errNUM_CNI_PROP3").html("");
 }

 if ($("#LIEU_DELIVRANCE").val() == "")
 {
   statut = 2;
   $("#errLIEU_DELIVRANCE").html("Champ obligatoire");
 }
 else
 {
   $("#errNUM_CNI_PROP3").html("");
 }

 if ($("#EMAIL_PROP2").val() == "")
 {
   statut = 2;
   $("#errEMAIL_PROP2").html("Champ obligatoire");
 }


 if ($("#NUM_TEL_PROP2").val() == "")
 {
   statut = 2;
   $("#errNUM_TEL_PROP2").html("Champ obligatoire");
 }
 else
 {
   $("#errNUM_TEL_PROP2").html("");
 }

   if ($("#valide_phone2").val() == 0)
  {
    statut = 2;
    $("#errNUM_TEL_PROP2").html("Numéro invalide");
  }
  else
  {
    $("#errNUM_TEL_PROP2").html("");
  }

 if ($("#NOM_PRENOM_PERE").val() == "")
 {
   statut = 2;
   $("#errNOM_PRENOM_PERE").html("Champ obligatoire");
 }
 else
 {
   $("#errNOM_PRENOM_PERE").html("");
 }

 if ($("#NOM_PRENOM_MERE").val() == "")
 {
   statut = 2;
   $("#errNOM_PRENOM_MERE").html("Champ obligatoire");
 }
 else
 {
   $("#errNOM_PRENOM_MERE").html("");
 }

 if ($("#DATE_NAISSANCE").val() == "")
 {
   statut = 2;
   $("#errDATE_NAISSANCE").html("Champ obligatoire");
 }
 else
 {
   $("#errDATE_NAISSANCE").html("");
 }

 if ($("#DATE_DELIVRANCE").val() == "")
 {
   statut = 2;
   $("#errDATE_DELIVRANCE").html("Champ obligatoire");
 }
 else
 {
   $("#errDATE_DELIVRANCE").html("");
 }
 
 var file = document.getElementById("CNI_IMAGE_PROP3");
 var file2 = document.getElementById("SIGNATURE_PROP2");
 var file3 = document.getElementById("PHOTO_PASSEPORT_PROP2");

 if (file.files.length == 0) 
   {  statut = 2;

    $("#errCNI_IMAGE_PROP3").html("Champ obligatoire");
  }else{


    $('#CNI_IMAGE_PROP3').css('border-color','white');
    $("#errCNI_IMAGE_PROP3").html(" ");
  }


  if (file2.files.length == 0) 
    {  statut = 2;
        //$('#errCNI_IMAGE_PROP').css('border-color','red');
        $("#errSIGNATURE_PROP2").html("Champ obligatoire");
      }else{
        $('#SIGNATURE_PROP2').css('border-color','white');
        $("#errSIGNATURE_PROP2").html(" ");
      }
      if (file3.files.length == 0) 
        {  statut = 2;

        //$('#errCNI_IMAGE_PROP').css('border-color','red');
        $("#errPHOTO_PASSEPORT_PROP2").html("Champ obligatoire");
      }else{


        $('#PHOTO_PASSEPORT_PROP2').css('border-color','white');
        $("#errPHOTO_PASSEPORT_PROP2").html(" ");
      } 

    }

    if ($("#type_requerant_id").val()==5) {

     if ($("#nationalite_id").val()!= "" && $("#nationalite_id").val()==28)
     {
      if ($("#PROVINCE_ID").val() == "")
      {
       statut = 2;
       $("#errPROVINCE_ID").html("Champ obligatoire");
     }
     else
     {
       $("#errPROVINCE_ID").html("");
     }

     if ($("#COMMUNE_ID").val() == "")
     {
       statut = 2;
       $("#errCOMMUNE_ID").html("Champ obligatoire");
     }
     else
     {
       $("#errCOMMUNE_ID").html("");
     }

     if ($("#ZONE_ID").val() == "")
     {
       statut = 2;
       $("#errZONE_ID").html("Champ obligatoire");
     }
     else
     {
       $("#errZONE_ID").html("");
     }

     if ($("#COLLINE_ID").val() == "")
     {
       statut = 2;
       $("#errCOLLINE_ID").html("Champ obligatoire");
     }
     else
     {
       $("#errCOLLINE_ID").html("");
     }
   }


   if ($("#NOM_REPRESENTANT").val() == "")
   {
    statut = 2;
    $("#errNOM_REPRESENTANT").html("Champ obligatoire");
  }
  else
  {
    $("#errNOM_REPRESENTANT").html("");
  }

  if ($("#NOM_ENTREPRISE").val() == "")
  {
    statut = 2;
    $("#errNOM_ENTREPRISE").html("Champ obligatoire");
  }
  else
  {
    $("#errNOM_ENTREPRISE").html("");
  }

  if ($("#EMAIL_REPRESENTANT").val() == "")
  {
    statut = 2;
    $("#errEMAIL_REPRESENTANT").html("Champ obligatoire");
  } else
  {
    $("#errEMAIL_REPRESENTANT").html("");
  }

   if ($("#valide_email2").val() == 0)
  {
    statut = 2;
    $("#errEMAIL_REPRESENTANT").html("E-mail invalide");
    $("#EMAIL_REPRESENTANT").css("border", "1px solid red");
  } else
  {
    $("#errEMAIL_REPRESENTANT").html("");
    $("#EMAIL_REPRESENTANT").css("border", "");
  }


  if ($("#TELEPHONE_REPRESENTANT").val() == "")
  {
    statut = 2;
    $("#errTELEPHONE_REPRESENTANT").html("Champ obligatoire");
  }
  else
  {
    $("#errTELEPHONE_REPRESENTANT").html("");
  }

  if ($("#valide_phone3").val() == 0)
  {
    statut = 2;
    $("#errTELEPHONE_REPRESENTANT").html("Numéro invalide");
  }
  else
  {
    $("#errTELEPHONE_REPRESENTANT").html("");
  }


  if ($("#NIF_RC").val() == "")
  {
    statut = 2;
    $("#errNIF_RC").html("Champ obligatoire");
  }
  else
  {
    $("#errNIF_RC").html("");
  }


  var file1 = document.getElementById("SIGNATURE_REPRESENTANT");

  if (file1.files.length == 0) 
    {  statut = 2;
        //$('#errCNI_IMAGE_PROP').css('border-color','red');
        $("#errSIGNATURE_REPRESENTANT").html("Champ obligatoire");
      }else{

        $('#SIGNATURE_REPRESENTANT').css('border-color','white');
        $("#errSIGNATURE_REPRESENTANT").html(" ");
      }
    }
  }




  if(statut ==1 && type_parcelle==2){
    document.getElementById('requerant_info').style.display="none"; 
    document.getElementById('parcelle_info').style.display="block";
    $('#info_div1').addClass('completed'); 
    $('#info_div2').addClass('completed'); 
    $('#info_div1').removeClass('active1');
    $('#info_div2').addClass('active1');
    $('#info_div3').addClass('active1'); 
    $('#info_div3').addClass('completed'); 

  }else if (statut ==1 && type_parcelle !=2 ) {
    exist_mail();
  }

}

function remove_ct(id)
{

  var rowid=$('#rowid'+id).val();
  var typereq=$('#typereq'+id).val();
  $.post('<?=base_url('administration/Numeriser_New/remove_ct')?>',
  {
   rowid:rowid,
   typereq:typereq

 },function(data)
 {
   if (data) 
   {

    mycart.innerHTML=data;
    $('#mycart').html(data);

  }



})
}
</script>


<!-- controle age >= à 18 -->
<script>
 function validateAgeold(input) {
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
<!-- controle age >= à 18 -->
<script>
  function validateAge(input) {
   // const btn_step1 = document.getElementById('btn_step1');
   const btn_step1 = document.getElementById('DATE_NAISSANCE');
   DATE_NAISSANCE
   var selectedDate = new Date(input.value);
   var currentDate = new Date();
   var minDate = new Date(currentDate.getFullYear() - 18, currentDate.getMonth(), currentDate.getDate());
   btn_step1.disabled = false;
   $('#error_alert').html('');
   $('#error_alertDATE_NAISSANCE').html('');


   if(selectedDate > minDate)
   {
    $('#error_alert').html('Le requerant doit avoir au minimum 18 ans');
    $('#error_alertDATE_NAISSANCE').html('Le requerant doit avoir au minimum 18 ans');

      // Disable the submit button
      // btn_step1.disabled = true;
    input.value = ""; // Clear the selected date
  }
}
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const flash = document.getElementById('flash-message');
  if (flash) {
    // Délai avant de masquer (ex: 5 secondes)
    setTimeout(() => {
      flash.style.transition = "opacity 0.5s ease-out";
      flash.style.opacity = 0;
      setTimeout(() => flash.remove(), 500); // Supprimer du DOM après disparition
    }, 5000); // ← temps d'affichage en millisecondes
  }
});
</script>

<!-- verification de la signature -->
<script>
  // Function to handle file input change
  function handleFileInput(fileInput, errorMessage) {
    // Get the file input element and submit button
    const file = fileInput.files[0];
    const btn_step1 = document.getElementById('btn_step1');
    $('#errorMessage').html('');

    // Check if the file is an image
    if (file && file.type.includes('image')) {
      // Enable the submit button
      btn_step1.disabled = false;
      errorMessage.textContent = '';
    } else {
      // Disable the submit button
      btn_step1.disabled = true;
      errorMessage.textContent = 'Veuillez uploader un fichier de type image';
      $('#errorMessage').html('Veuillez uploader un fichier de type image');
    }
  }

  // Get the file input elements and error messages
  const fileSignature = document.getElementById('SIGNATURE_PROP');
  const fileSignatureRepresentant = document.getElementById('SIGNATURE_REPRESENTANT');
  const filePhoto = document.getElementById('PHOTO_PASSEPORT_PROP');
  const errorSignature = document.getElementById('error_signature');
  const errorSignatureRepresentant = document.getElementById('error_signatureRepresentant');
  const errorPhoto = document.getElementById('error_photo');

  // Add event listeners to the file input elements
  fileSignature.addEventListener('change', function () {
   handleFileInput(fileSignature, errorSignature);
 });


    // Add event listeners to the file input elements
    fileSignatureRepresentant.addEventListener('change', function () {
     handleFileInput(fileSignatureRepresentant, errorSignatureRepresentant);
   });


    filePhoto.addEventListener('change', function () {
     handleFileInput(filePhoto, errorPhoto);
   });
 </script>



 <script>
  $(document).ready(function() {
  //gestion info à saisir par rapport au type de requerant



  $('#type_requerant_id').on('change', function() {
   let val_sel2 = $('#type_requerant_id').val();
   // alert(val_sel2);

   if (val_sel2 == 5) {
    $('.info_perso_morale').show();
    $('.info_localite_naissance').show();        
    $('.info_perso_physique').hide();

  } else if (val_sel2 == 1) {
    $('.info_perso_physique').show();
    $('.info_localite_naissance').show();      
    $('.info_perso_morale').hide();
  }

});
});
</script>

<script type="text/javascript">
 $('#type_requerant_id').on('change', function() {
  let val_sel2 = $('#type_requerant_id').val();
  // alert(val_sel2);

  if (val_sel2 == 5) {
   $('.info_perso_morale').show();
   $('.info_localite_naissance').show();        
   $('.info_perso_physique').hide();

 } else if (val_sel2 == 1) {
   $('.info_perso_physique').show();
   $('.info_localite_naissance').show();      
   $('.info_perso_morale').hide();

 }

});
</script>


<script>
    // gestion d'affichage de la localite de naissance
    $('#nationalite_id').on('change', function() {
     let val_sel1 = $('#nationalite_id').val();
     // alert(val_sel1);
     if (val_sel1 == 28) {
      $('.info_localite_naissance').show();
    } else {
      $('.info_localite_naissance').hide();
    }
  })
</script>


<script>//info localite naissance

function get_communes_naissance($id)
{
 var PROVINCE_ID=$('#PROVINCE_ID').val();

 $.ajax({
  url: "<?= base_url() ?>administration/Numeriser_New/get_commune_naissance/"+PROVINCE_ID,
  type: "GET",
  dataType: "JSON",
  success: function(data) {
   $('#COMMUNE_ID').html(data);
 }
});
}

function get_zones_naissance($id)
{
 var COMMUNE_ID=$('#COMMUNE_ID').val();
 $('#ZONE_ID').html('<option value=""><?=lang('selectionner')?></option>');
 $('#COLLINE_ID').html('<option value=""><?=lang('selectionner')?></option>');

 $.ajax({
  url: "<?= base_url() ?>administration/Numeriser_New/get_zone_parcelle/"+COMMUNE_ID,
  type: "GET",
  dataType: "JSON",
  success: function(data) {
   $('#ZONE_ID').html(data);
 }
});
}

function get_collines_naissance($id)
{
 var ZONE_ID=$('#ZONE_ID').val();
 $('#COLLINE_ID').html('<option value=""><?=lang('selectionner')?></option>');

 $.ajax({
  url: "<?= base_url() ?>administration/Numeriser_New/get_colline_parcelle/"+ZONE_ID,
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

<!-- approuver les alphabets ,les chiffres,tiret and anti slash pour parcelle et num cadastre-->
<script>
 function vatidationData(input) {
  var regex = /^[A-Za-z0-9\-\/\s]+$/;
  return regex.test(input);
}

function validateValueParcelle(input) {
  var isValid = vatidationData(input.value);
  const value = input.value;
  document.getElementById('NUM_CADASTRE').value = value;
  
  if (!isValid) {
    // Autorise lettres, chiffres, tirets, slashs, espaces et apostrophes
    input.value = input.value.replace(/[^A-Za-z0-9\-\/'\s]/g, '');
  }
}

</script>

<!-- fin du script d'approbation -->


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
   input.value = input.value.replace(/[^A-Z0-9\-\/\s\.]/g, '');
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

function validateInfoFolio(input) {
  var isValid = validateNumbers(input.value);
  if (!isValid) {
   input.value = input.value.replace(/[^0-9.]/g, '');
 }
}
</script>

<script>//info localite parcelle

function get_communes($id)
{
 var PROVINCE_ID=$('#PROVINCE_ID1').val();

 $('#COMMUNE_ID1').html('<option value=""><?=lang('selectionner')?></option>');
 $('#ZONE_ID1').html('<option value=""><?=lang('selectionner')?></option>');
 $('#COLLINE_ID1').html('<option value=""><?=lang('selectionner')?></option>');
 $.ajax({
  url: "<?= base_url() ?>administration/Numeriser_New/get_commune_parcelle/"+PROVINCE_ID,
  type: "GET",
  dataType: "JSON",
  success: function(data) {
   $('#COMMUNE_ID1').html(data);
 }
});
}

function get_zones($id)
{
 var COMMUNE_ID=$('#COMMUNE_ID1').val();
 $('#ZONE_ID1').html('<option value=""><?=lang('selectionner')?></option>');
 $('#COLLINE_ID1').html('<option value=""><?=lang('selectionner')?></option>');

 $.ajax({
  url: "<?= base_url() ?>administration/Numeriser_New/get_zone_parcelle/"+COMMUNE_ID,
  type: "GET",
  dataType: "JSON",
  success: function(data) {
   $('#ZONE_ID1').html(data);
 }
});
}

function get_collines($id)
{
 var ZONE_ID=$('#ZONE_ID1').val();
 $('#COLLINE_ID1').html('<option value=""><?=lang('selectionner')?></option>');

 $.ajax({
  url: "<?= base_url() ?>administration/Numeriser_New/get_colline_parcelle/"+ZONE_ID,
  type: "GET",
  dataType: "JSON",
  success: function(data) {
   $('#COLLINE_ID1').html(data);
 }
});
}
</script>

<script type="text/javascript">
  function test_val(email) {
    return new Promise(function(resolve, reject) {
      $.ajax({
        url: "<?=base_url('administration/Numeriser_New/verify_email')?>",
        data: { EMAIL: email },
        type: 'POST',
        contentType: false,
        processData: false,
        success: function(response) {
          var test = response == 1 ? 1 : 2;
          resolve(test);
        },
        error: function(xhr, status, error) {
          reject(error);
        }
      });
    });
  }
</script>

<script>

 var isFirstClick = true;

 function validateEmail(email) {
  const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;


  if (re.test(email)==true) {

  test_val(email).then(function(test) {
    // alert(test);
    if (test === 1) {
      return true;
    } else {
     return false;
   }
 }).catch(function(error) {
  console.error("An error occurred:", error);
});


}else{

 return re.test(email);
}

}

function toggleTabs() {
  let statut = 1;


  var requerantTab = document.getElementById("requerant_info");
  var parcelleTab = document.getElementById("parcelle_info");
  var nextButton = document.getElementById("btn_step1");
  var backButton = document.getElementById("btn_retour");

// parcelle_info
document.getElementById('requerant_info').style.display="block"; 
document.getElementById('parcelle_info').style.display="none"; 

   /*  if (parcelleTab.style.display === "none") {
      requerantTab.style.display = "none";
      parcelleTab.style.display = "block";
      nextButton.textContent = "Précédant   \u2190";
      backButton.style.display = "inline-block";
    } else {
      requerantTab.style.display = "block";
      parcelleTab.style.display = "none";
      nextButton.textContent = "Suivant   \u2192";
      backButton.style.display = "none";
    }*/

  }

</script>


<script type="text/javascript">
  function afficher_btn_cart(argument){

  var type_parcelle = $('#type_parcelle').val();   
$('#hide_succedent').hide();
 if(type_parcelle==3){
  
  $('#hide_succedent').show();
 }
  
   if(type_parcelle==2){
    
    document.getElementById('button_cart').style.display="block"; 
    document.getElementById('hide_suivant').style.display="none"; 
  } else {
   document.getElementById('button_cart').style.display="none"; 
document.getElementById('hide_suivant').style.display="block"; 
 }

}
</script>

<script>
  function buttonSave()
  {
   let statut = 1;
   if($("#NUM_PARCEL").val() == "")
   {
    statut = 2;
    $("#errNUM_PARCEL").html("Champ obligatoire");  
  }
  else
  {
    $("#errNUM_PARCEL").html("");
  }

  if($("#NATURE_DOC").val() == "")
  {
    statut = 2;
    $("#errNATURE_DOC").html("La séléction est obligatoire");  
  }
  else
  {
    $("#errNATURE_DOC").html("");
  }

  if($("#NUMERO_SPECIAL").val() == "")
  {
    statut = 2;
    $("#errNUMERO_SPECIAL").html("Champ obligatoire");  
  }
  else
  {
    $("#errNUMERO_SPECIAL").html("");
  }

  if($("#VOLUME").val() == "")
  {
    statut = 2;
    $("#errVOLUME").html("Champ obligatoire");  
  }
  else
  {
    $("#errVOLUME").html(""); 
  }

  if($("#FOLIO").val() == "")
  {
    statut = 2;
    $("#errFOLIO").html("Champ obligatoire");  
  }
  else
  {
    $("#errFOLIO").html("");
  }

  if($("#SUPER_HA").val() == "")
  {
    statut = 2;
    $("#errSUPER_HA").html("Champ obligatoire");  
  }
  else
  {
    $("#errSUPER_HA").html("");
  }

  if($("#SUPER_ARE").val() == "")
  {
    statut = 2;
    $("#errSUPER_ARE").html("Champ obligatoire");  
  }
  else
  {
    $("#errSUPER_ARE").html("");
  }

  if($("#SUPER_CA").val() == "")
  {
    statut = 2;
    $("#errSUPER_CA").html("Champ obligatoire");  
  }
  else
  {
    $("#errSUPER_CA").html("");
  }

  if($("#PROVINCE_ID1").val() == "")
  {
    statut = 2;
    $("#errPROVINCE_ID1").html("La séléction est obligatoire");  
  }
  else
  {
    $("#errPROVINCE_ID1").html("");
  }

  if($("#COMMUNE_ID1").val() == "")
  {
    statut = 2;
    $("#errCOMMUNE_ID1").html("La séléction est obligatoire");  
  }
  else
  {
    $("#errCOMMUNE_ID1").html("");
  }

  if($("#ZONE_ID1").val() == "")
  {
    statut = 2;
    $("#errZONE_ID1").html("La séléction est obligatoire");  
  }
  else
  {
    $("#errZONE_ID1").html("");
  }

  if($("#COLLINE_ID1").val() == "")
  {
    statut = 2;
    $("#errCOLLINE_ID1").html("La séléction est obligatoire");  
  }
  else
  {
    $("#errCOLLINE_ID1").html("");
  }

  if($("#USAGE").val() == "")
  {
    statut = 2;
    $("#errUSAGE").html("La séléction est obligatoire");  
  }
  else
  {
    $("#errUSAGE").html("");
  }

  if($("#NUM_CADASTRE").val() == "")
  {
    statut = 2;
    $("#errNUM_CADASTRE").html("champ est obligatoire");  
  }
  else
  {
    $("#errNUM_CADASTRE").html("");
  }

// alert(statut)
$('#loading_spinner').hide();
document.getElementById('loading').style.display = 'none';
if(statut==1)
{
  exist_parcelle();
}
}

function exist_parcelle(){
    var NUM_PARCEL = $('#NUM_PARCEL').val().trim();
    $.ajax({
  url : "<?=base_url()?>administration/Numeriser_New/exist_mail2/", 
  type : "POST",
  dataType : "Json",
  data:{
    NUM_PARCEL:NUM_PARCEL
  },
  cache : false,
success:function(data) {
        // alert(data)
        if(data.parcelle==0){
 $('#btn_save').prop('disabled',true);
  myform.submit();
  $('#loading_spinner').show();
  // document.getElementById('loading').style.display = 'block';
    $("#check_parcelle").html('');
 }else if(data.parcelle==1){

    $("#check_parcelle").html('<div class="alert alert-danger text-center">La parcelle existe déjà!</div>');
    $('#errNUM_PARCEL').html("La parcelle existe déjà!");
        $("#check_mail").html("");
    $("#check_email_mandataire").html();
    $("#check_mail3").html();
$("#NUM_PARCEL").css("border", "1px solid red");

 }else{

$("#check_parcelle").html('');
    $("#check_mail").html("");
    $("#check_email_mandataire").html();
    $("#check_mail3").html();
    $("#NUM_PARCEL").css("border", "1px solid black");
    $('#errNUM_PARCEL').html("");
 }

   },

});
   }
     
   </script>
</script>

    <script>
    var displayTime = 3000; // Temps d'affichage en millisecondes
    var message = "<?= $this->session->flashdata('message') ?>"; // Récupérer le message

    // Redirection basée sur le contenu du message
    setTimeout(function() {
      if (message === "<?= lang('enregistrement_succes') ?>") {
            window.location.href = '<?= base_url("administration/Numeriser_New/list") ?>'; // Remplacez par l'URL pour le message "ego"
          }
        }, displayTime);
      </script>

<!-- ajouter option recherche dans le select -->
<script>
$(document).ready(function() {
    // Initialisation pour tous les éléments avec la classe .dynamic-select2
    $('.dynamic-select2').select2({
        width: '100%',
        language: {
            noResults: function() {
                return "Aucun résultat";
            }
        }
    });

    // Ré-initialisation après ajout dynamique d'inputs
    $(document).on('focus', '.dynamic-select2:not([data-select2-id])', function() {
        $(this).select2();
    });
});
</script>

<script>
    function verifie_mail(){
      if($('#myvalue').val() ==1)
      {   
  
      var EMAIL_PROP = $("#EMAIL_PROP").val();
    }else if($("#type_requerant_id").val() == 1)

  {  
    var EMAIL_PROP = $("#EMAIL_PROP2").val();
    }else{
      var EMAIL_PROP = $("#EMAIL_REPRESENTANT").val();
    }
      $.ajax({
          url: "<?= base_url() ?>administration/Numeriser_New/verifie_mail",
,
         
          type: "POST",
          dataType: "JSON",
          data: {EMAIL_PROP:EMAIL_PROP},
          beforeSend: function() {
          },
          success: function(data)
          {
            if (data.statut==1) {

            $('#email_is_uniq').val(0);
            $('#errEMAIL_PROP').text("E-mail Existe déjà dans BPS!");
            $('#errEMAIL_REPRESENTANT').text("E-mail Existe déjà dans BPS!");
            $('#errEMAIL_PROP2').text("E-mail Existe déjà dans BPS!");

          }else if (data.statut==2) 
          {
            $('#email_is_uniq').val(1);
            $('#errEMAIL_PROP').text('');              
            $('#errEMAIL_REPRESENTANT').text('');
          }else if (data.statut==3) 
          {
             $('#email_is_uniq').val(0);
              $('#errEMAIL_PROP').text("E-mail Existe déjà dans PMS!");    
              $('#errEMAIL_REPRESENTANT').text("E-mail Existe déjà dans PMS!");
              $('#errEMAIL_PROP2').text("E-mail Existe déjà dans PMS!");
          }
      }
  });
  } 

</script>

<script type="text/javascript">
function verifie_mail1() {
    const emailField = document.getElementById("EMAIL_PROP");
    const email = emailField.value.trim();
    const err = document.getElementById("errEMAIL_PROP");

    // Regex plus rigoureuse : accepte nom@domaine.ext, avec quelques cas valides
    const regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    $("#valide_email1").val(1);
    err.textContent = "";

    if (email === "") {
        err.textContent = "L'adresse e-mail est obligatoire.";
        $("#valide_email1").val(0);
        return false;
    }

    else if (!regex.test(email)) {
        err.textContent = "Format de l'adresse e-mail invalide.";
        // emailField.value = '';
        $("#valide_email1").val(0);
        return false;
    } 
}

function verifie_mail2() {
    const emailField = document.getElementById("EMAIL_REPRESENTANT");
    const email = emailField.value.trim();
    const err = document.getElementById("errEMAIL_REPRESENTANT");

    // Regex plus rigoureuse : accepte nom@domaine.ext, avec quelques cas valides
    const regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    $("#valide_email2").val(1);
    err.textContent = "";

    if (email === "") {
        err.textContent = "L'adresse e-mail est obligatoire.";
        $("#valide_email2").val(0);
        return false;
    }

    else if (!regex.test(email)) {
        err.textContent = "Format de l'adresse e-mail invalide.";
        // emailField.value = '';
        $("#valide_email2").val(0);
        return false;
    } 
}

function verifie_mail3() {
    const emailField = document.getElementById("EMAIL_PROP2");
    const email = emailField.value.trim();
    const err = document.getElementById("errEMAIL_PROP2");

    // Regex plus rigoureuse : accepte nom@domaine.ext, avec quelques cas valides
    const regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    $("#valide_email3").val(1);
    err.textContent = "";

    if (email === "") {
        err.textContent = "L'adresse e-mail est obligatoire.";
        $("#valide_email3").val(0);
        return false;
    }

    else if (!regex.test(email)) {
        err.textContent = "Format de l'adresse e-mail invalide.";
        // emailField.value = '';
        $("#valide_email3").val(0);
        return false;
    } 
}



</script>


          <script>
          function validatePhoneNumber2(input) {
              const value = input.value.replace(/\D/g, ''); // Supprime tous les caractères non numériques
              // alert(value)
              input.value = value; // Met à jour l'input sans les lettres ou symboles

              const errorSpan = document.getElementById("errNUM_TEL_PROP");
              $('#valide_phone1').val(0);

              if (value.length < 8 || value.length > 12) {
                  errorSpan.textContent = "Numéro de téléphone invalide.";
              } else {
                  errorSpan.textContent = "";
                  $('#valide_phone1').val(1); // Valide
                  // NUM_TEL_PROP2
              }
          }


 function validatePhoneNumber3(input) {
    const value = input.value.replace(/\D/g, ''); // Supprimer les non-chiffres
    input.value = value;

    const errorSpan = document.getElementById("errNUM_TEL_PROP2");
    const hiddenInput = document.getElementById("valide_phone2");

    if (value.length < 8 || value.length > 12) {
      errorSpan.textContent = "Le numéro doit contenir entre 8 et 12 chiffres.";
      input.style.border = "1px solid red";
      hiddenInput.value = 0;
    } else {
      errorSpan.textContent = "";
      input.style.border = ""; // Retire la bordure rouge si tout est bon
      hiddenInput.value = 1;
    }
  }

  function validatePhoneNumber4(input) {
    const value = input.value.replace(/\D/g, ''); // Supprimer les non-chiffres
    input.value = value;

    const errorSpan = document.getElementById("errTELEPHONE_REPRESENTANT");
    const hiddenInput = document.getElementById("valide_phone3");

    if (value.length < 8 || value.length > 12) {
      errorSpan.textContent = "Le numéro doit contenir entre 8 et 12 chiffres.";
      input.style.border = "1px solid red";
      hiddenInput.value = 0;
    } else {
      errorSpan.textContent = "";
      input.style.border = ""; // Retire la bordure rouge si tout est bon
      hiddenInput.value = 1;
    }
  }
          </script>
