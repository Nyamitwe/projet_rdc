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

<style>
.stepper-wrapper {
  display: flex;
  justify-content: space-between;
  margin-bottom: 30px;
  margin-top: 10px;
}

.stepper-item {
  position: relative;
  display: flex;
  flex-direction: column;
  align-items: center;
  flex: 1;
  text-align: center;
  color: #999;
}

.stepper-item::before,
.stepper-item::after {
  content: '';
  position: absolute;
  top: 15px;
  border-top: 2px solid #ccc;
  width: 100%;
  z-index: 0;
}

.stepper-item::before {
  left: -50%;
}
.stepper-item::after {
  left: 50%;
}

.stepper-item:first-child::before,
.stepper-item:last-child::after {
  content: none;
}

.step-counter {
  position: relative;
  z-index: 1;
  width: 30px;
  height: 30px;
  background-color: #ccc;
  border-radius: 50%;
  line-height: 30px;
  color: white;
  font-weight: bold;
  margin-bottom: 8px;
}

.stepper-item.completed .step-counter,
.stepper-item.active .step-counter {
  background-color: #1b5c6e; /* Couleur active */
}

.stepper-item.completed .step-name,
.stepper-item.active .step-name {
  color: #1b5c6e;
  font-weight: bold;
}

.stepper-item.completed::after {
  border-top: 2px solid #1b5c6e;
}
</style>

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
<style>
  .btn-modern {
    position: relative;
    padding-left: 2.5rem;
    transition: all 0.3s ease;
  }

  .btn-modern.disabled {
    pointer-events: none;
    opacity: 0.6;
  }

  .btn-modern .spinner {
    position: absolute;
    left: 10px;
    top: 50%;
    transform: translateY(-50%);
    display: none;
    width: 1rem;
    height: 1rem;
    border: 3px solid rgba(255, 255, 255, 0.3);
    border-top: 3px solid #fff;
    border-radius: 50%;
    animation: spin 0.8s linear infinite;
  }

  @keyframes spin {
    0%   { transform: translateY(-50%) rotate(0deg); }
    100% { transform: translateY(-50%) rotate(360deg); }
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
      <div id="content">
        <?php include VIEWPATH.'includes/topbar.php'; ?> 
        <div class="midde_cont">
          <div class="container-fluid" style="padding: 0px;">
            <div class="midde_cont">
              <div class="container-fluid">
                <br>
                <div class="row column1" style="padding:10px;">
                  <div class="col-md-12">
                    <div class="white_shd full margin_bottom_30">
                      <div class="row full graph_head">
                        <div class="dropdown col-md-10">
                        </div>
                        <button 
                        type="button" 
                        onclick="window.location.href='<?= base_url('administration/Numeriser_New/list') ?>'" 
                        class="btn" 
                        style="background-color:#1b5c6e; color:white; border:1px solid #020f12;"
                        >
                        <i class="fa fa-list"></i> Retour à la liste
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
                        <h2 style="padding-left:20px" class="text-center">Changement du propriétaire</h2>
                        <br><br>

                        <div class="row">
                          <div class="col-md-12">
                            <div class="panel panel-default" style="display: block !important;">
                              <div class='row'>
                                <div class="col-md-12 py-2">
                                  <div class="stepper-wrapper">
                                    <div id="info_div1" class="stepper-item completed active">
                                      <div class="step-counter">1</div>
                                      <div class="step-name text-center">Motif du changement</div>
                                    </div>
                                    <div id="info_div2" class="stepper-item">
                                      <div class="step-counter">2</div>
                                      <div class="step-name text-center">Informations du nouveau requérant</div>
                                    </div>
                                    <div id="info_div3" class="stepper-item">
                                      <div class="step-counter">3</div>
                                      <div class="step-name text-center">Informations de la parcelle</div>
                                    </div>
                                  </div>
                                </div>
                                <br>
                                <div class="col-md-6"></div>
                                <div class="col-md-1">
                                  <span id="loading_spinner" style="display: none; text-align:center;font-size: 50px">
                                    <i class="fa fa-spinner fa-spin fa-2x text-primary"></i>
                                  </span>
                                </div> </div>      

                                <form name="myform" method="post" class="form-horizontal" action="<?= base_url('administration/Numeriser_New/modifier_info_requerant'); ?>"  enctype="multipart/form-data">
                                  <!-- motifs -->
                                  <div class="tab" id="mandataire_tabs" style="display: block;">
                                    <div class="row">
                                      <input type="hidden" id="email_is_uniq">
                                    </div>
                                    <div class="col-md-12"></div><br>
                                    <div class="row col-md-12" id="info_mandataire" style="display: block;">
                                      <div class="row">
                                        <div class="col-md-12 col1">
                                          <label>Motif<span class="text-danger">*</span></label>
                                          <select name="RAISON" id="RAISON" class="form-control" onchange="get_autre_motif()" >
                                            <option value="">Sélectionner</option>
                                            <?php foreach($raison_modification as $value) {
                                            echo "<option value='".$value['RAISON_MODIF_ID']."' $selected>".$value['DESCRIPTION']."</option>";
                                          } ?>
                                        </select>
                                        <div class="text-danger" id="errRAISON"></div>
                                      </div> 

                                      <div class="col-md-6" id="hide_autre_raison" style="display: none">
                                        <label>Précisez autre motif<font class="text-danger">*</font></label>
                                        <input type="text" class="form-control" autofocus="" name="AUTRE_RAISON" id="AUTRE_RAISON"  value="<?= isset($table_attrib['AUTRE_RAISON_MODIF']) ? htmlspecialchars($table_attrib['AUTRE_RAISON_MODIF']) : '' ?>">
                                        <span id="errAUTRE_RAISON" class="text-danger"></span>
                                      </div>

                                      <div class="row col-md-12" id="div_tabs1" style="display: block">
                                        <div class="col-md-12">
                                          <div style="margin-top: 20px; overflow: auto;">
                                            <div style="float: right;">
                                              <button style="margin-left: 10px;background-color:#1b5c6e; color:white; border:1px solid #020f12;" id="btn_enregistrer" type="button" class="btn" onclick="suivant_infos_requerant();">
                                                Suivant >>
                                              </button>
                                            </div>
                                          </div> 
                                        </div>
                                        <div class="col-md-12" "></div><br>
                                      </div></div></div></div></div> 

                                      <!-- infos requerant -->
                                      <div class="tab" id="requerant_info" style="display: none;">
                                        <input type="hidden" value="<?= ($table_attrib['ID_REQUERANT']) ?? '' ?>" name="ancien_requerant">
                                        <div class="row">

                                          <div class="col-md-4" style="margin-top:10px">
                                            <label>Type de parcelle<font class="text-danger">*</font></label>
                                            <select class="form-control" name="type_parcelle" id="type_parcelle" onchange="afficher_btn_cart(this.value)">
                                              <option value=""><?= lang('selectionner') ?></option>
                                              <option value="1" <?= (isset($table_attrib['TYPE_PARCELLE']) && $table_attrib['TYPE_PARCELLE'] == "1") ? 'selected' : '' ?>>Propriété personnelle</option>
                                              <option value="2" <?= (isset($table_attrib['TYPE_PARCELLE']) && $table_attrib['TYPE_PARCELLE'] == "2") ? 'selected' : '' ?>>Copropriété</option>
                                              <option value="3" <?= (isset($table_attrib['TYPE_PARCELLE']) && $table_attrib['TYPE_PARCELLE'] == "3") ? 'selected' : '' ?>>Succession</option>
                                            </select>

                                            <?php echo form_error('type_parcelle', '<div class="text-danger">', '</div>'); ?>
                                            <span id="errtype_parcelle" class="text-danger"></span>
                                          </div>

                                          <div class="col-md-4" style="margin-top:10px">
                                            <input type="hidden" name="" id="type_requerant_id1" value="">

                                            <label><?=lang('type_requerant')?><font class="text-danger">*</font></label>
                                            <select class="form-control" name="type_requerant_id" id="type_requerant_id" onchange="get_requerant()">
                                              <option value=""><?= lang('selectionner') ?></option>
                                              <?php foreach($types_requerants as $types_requerant) {
                                              $selected = (isset($info_req['registeras']) && $info_req['registeras'] == $types_requerant['id']) ? 'selected' : '';
                                              echo "<option value='".$types_requerant['id']."' $selected>".$types_requerant['name']."</option>";
                                            } ?>
                                          </select>

                                          <?php echo form_error('type_requerant_id', '<div class="text-danger">', '</div>'); ?>
                                          <span id="errtype_requerant_id" class="text-danger"></span>
                                        </div>

                                        <div class="col-md-4" id="hide_succedent" style="display: none; margin-top: 10px;">
                                          <label for="SUCCENDANT">Testateur / Défunt <span class="text-danger">*</span></label>
                                          <input 
                                          type="text" 
                                          class="form-control" 
                                          id="SUCCENDANT" 
                                          name="SUCCENDANT" 
                                          value="" 
                                          oninput="validateInput(this)" 
                                          required
                                          >
                                          <span id="errSUCCENDANT" class="text-danger"></span> 
                                        </div>

                                        <div class="col-md-4" style="margin-top:10px">
                                          <label><?=lang('nationalite')?><font class="text-danger">*</font></label>
                                          <select class="form-control dynamic-select2 info_perso_nationalite" name="nationalite_id" id="nationalite_id" onchange="get_nationalite()"> data-placeholder="<?=lang('selectionner')?>">
                                            <option value=""><?=lang('selectionner')?></option> 
                                            <?php foreach($nationalites as $nationalite) {
                                            $selected = (isset($info_req['country_code']) && $info_req['country_code'] == $nationalite['id']) ? 'selected' : '';
                                            echo "<option value='".$nationalite['id']."' $selected>".$nationalite['name']."</option>";
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
                                          <input type="text" class="form-control" oninput="validateInput(this)" id="NOM_PRENOM_PROP2" name="NOM_PRENOM_PROP2" value="">
                                          <?php echo form_error('NOM_PRENOM_PROP2', '<div class="text-danger">', '</div>'); ?>
                                          <span id="errNOM_PRENOM_PROP2" class="text-danger"></span> 
                                        </div>

                                        <div class="col-md-4">
                                          <label>Genre<font class="text-danger">*</font></label>
                                          <select class="form-control"  name="SEXE_ID2"  id="SEXE_ID2">
                                            <option value="">Sélectionner</option>
                                            <?php foreach($sexes as $sexe) { 
                                            if ($sexe['SEXE_ID']==$info_req['sexe_id']) { 
                                            echo "<option value='".$sexe['SEXE_ID']."' selected>".$sexe['DESCRIPTION_SEXE']."</option>";
                                          }  else{
                                          echo "<option value='".$sexe['SEXE_ID']."' >".$sexe['DESCRIPTION_SEXE']."</option>"; 
                                        } }?>                                                              
                                      </select> 
                                      <span id="errsexe_id2" class="text-danger"></span> 
                                    </div>

                                    <div class="col-md-4">
                                      <label><?=lang('date_naissance')?><font class="text-danger">*</font></label>
                                      <input type="date" 
                                      class="form-control" 
                                      name="DATE_NAISSANCE" 
                                      id="DATE_NAISSANCE" 
                                      max="<?= date('Y-m-d') ?>" 
                                      value="" 
                                      onchange="validateAge2(this)"> 
                                      <span id="errDATE_NAISSANCE" class="text-danger"></span>  
                                      <div id="error_alertDATE_NAISSANCE" style="color: red;"></div>
                                    </div>


                                    <div class="col-md-4">
                                      <label><?=lang('labelle_photo_num')?><font class="text-danger"></font></label>
                                      <input type="file" class="form-control" name="PHOTO_PASSEPORT_PROP2" id="PHOTO_PASSEPORT_PROP2" accept=".png, .jpg, .jpeg">
                                      <div><font color="red" id="error_profile2"></font></div> 
                                      <span id="errPHOTO_PASSEPORT_PROP2" class="text-danger"></span>  
                                      <div id="error_alert2" style="color: red;"></div>
                                      <div id="errorMessage2" style="color: red;"></div>
                                    </div>

                                    <div class="col-md-4">
                                      <label><?=lang('signature_requerant')?><font class="text-danger">*</font></label>
                                      <input type="file" class="form-control" name="SIGNATURE_PROP2" id="SIGNATURE_PROP2" accept=".png, .jpg, .jpeg" > 
                                      <div><font color="red" id="error_signature2"></font></div> 
                                      <span id="errSIGNATURE_PROP2" class="text-danger"></span> 
                                      <div id="errorMessage2" style="color: red;"></div>
                                    </div>

                                    <div class="col-md-4">
                                      <label><?=lang('image_cni_passport')?><font class="text-danger">*</font></label>
                                      <input type="file" class="form-control" name="CNI_IMAGE_PROP3" id="CNI_IMAGE_PROP3" accept=".pdf">
                                      <input type="hidden" class="form-control" name="CNI_IMAGE_PROP3">
                                      <span id="errCNI_IMAGE_PROP3" class="text-danger"></span>  
                                    </div>

                                    <div class="col-md-4">
                                      <label><?=lang('num_cni_passport')?><font class="text-danger">*</font></label>
                                      <input type="text" class="form-control" oninput="validateValues(this)" id="NUM_CNI_PROP3" name="NUM_CNI_PROP3" value="">
                                      <span id="errNUM_CNI_PROP3" class="text-danger"></span>
                                    </div>

                                    <div class="col-md-4">
                                      <label><?=lang('date_delivrance')?><font class="text-danger">*</font></label>
                                      <input type="date" class="form-control" id="DATE_DELIVRANCE" name="DATE_DELIVRANCE" max="<?=date('Y-m-d')?>"  value="<?= isset($info_req['date_delivrance']) ? htmlspecialchars($info_req['date_delivrance']) : '' ?>">

                                      <span id="errDATE_DELIVRANCE" class="text-danger"></span>                                  
                                    </div>

                                    <div class="col-md-4">
                                      <label><?=lang('lieu_delivrance')?><font class="text-danger">*</font></label>
                                      <input type="text" class="form-control" oninput="validateInput(this)" id="LIEU_DELIVRANCE"  name="LIEU_DELIVRANCE" maxlength="100"  value="">
                                      <span id="errLIEU_DELIVRANCE" class="text-danger"></span> 
                                    </div>

                                    <div class="col-md-4">
                                      <label><?=lang('email')?><font class="text-danger">*</font></label>
                                      <input type="email" autocomplete="off" required class="form-control" name="EMAIL_PROP2" id="EMAIL_PROP2" onblur="verifie_mail3()" value="">
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
                                      autocomplete="">
                                      <div id="error-message2" style="color: red;"></div>
                                      <span id="errNUM_TEL_PROP2" class="text-danger"></span>
                                    </div>

                                    <input type="hidden" id="valide_email2">
                                    <input type="hidden" id="valide_phone2">
                                    <input type="hidden" id="valide_phone3">

                                    <div class="col-md-4">
                                      <label><?=lang('nom_prenom_pere')?><font class="text-danger">*</font></label>
                                      <input type="text" class="form-control" oninput="validateInput(this)" id="NOM_PRENOM_PERE" name="NOM_PRENOM_PERE" value="">
                                      <span id="errNOM_PRENOM_PERE" class="text-danger"></span>                                 
                                    </div>

                                    <div class="col-md-4">
                                      <label><?=lang('nom_prenom_mere')?><font class="text-danger">*</font></label>
                                      <input type="text" class="form-control" oninput="validateInput(this)" id="NOM_PRENOM_MERE" name="NOM_PRENOM_MERE" value="">
                                      <span id="errNOM_PRENOM_MERE" class="text-danger"></span>                                   
                                    </div>
                                  </div>
                                </div>

                                <div  class="row info_localite_naissance">
                                  <div class="col-md-4" <?=$info_prov_naissance?>>
                                    <label><?=lang('label_province_naissance')?><font class="text-danger">*</font></label>
                                    <select class="form-control" onchange="get_communes_naissance(this.value)"  name="PROVINCE_ID" id="PROVINCE_ID">
                                      <option value=""><?=lang('selectionner')?></option>
                                      <?php foreach($provinces_naissance as $province) { 
                                      if ($province['PROVINCE_ID']==$info_req['provence_id']) { 
                                      echo "<option value='".$province['PROVINCE_ID']."' selected>".$province['PROVINCE_NAME']."</option>";
                                    }  else{
                                    echo "<option value='".$province['PROVINCE_ID']."' >".$province['PROVINCE_NAME']."</option>"; 
                                  } }?>                                                              
                                </select>
                                <span id="errPROVINCE_ID" class="text-danger"></span>
                              </div>

                              <div class="col-md-4" <?=$info_com_naissance?>>
                                <label><?=lang('label_commune_naissance')?><font class="text-danger">*</font></label>
                                <select class="form-control" onchange="get_zones_naissance(this.value)" name="COMMUNE_ID" id="COMMUNE_ID">
                                  <option value=""><?=lang('selectionner')?></option>
                                  <?php if(!empty($communes)){
                                  foreach($communes as $commune){?>
                                  <option value="<?=$commune['COMMUNE_ID']?>" <?php if ($commune['COMMUNE_ID']==$info_req['commune_id']) echo "selected";?> ><?=$commune['COMMUNE_NAME']?></option>
                                  <?php } }?>
                                </select>
                                <span id="errCOMMUNE_ID" class="text-danger"></span>
                              </div>

                              <div class="col-md-4" <?=$info_zon_naissance?>>
                                <label><?=lang('label_zone')?><font class="text-danger">*</font></label>
                                <select class="form-control" onchange="get_collines_naissance(this.value)"  name="ZONE_ID" id="ZONE_ID">
                                  <option value=""><?=lang('selectionner')?></option>
                                  <?php if(!empty($zones)){
                                  foreach($zones as $zone){?>

                                  <option value="<?=$zone['ZONE_ID']?>" <?php if ($zone['ZONE_ID']==$info_req['zone_id']) echo "selected";?> ><?=$zone['ZONE_NAME']?></option>
                                  <?php } }?>
                                </select>
                                <span id="errZONE_ID" class="text-danger"></span>
                              </div>

                              <div class="col-md-4" <?=$info_col_naissance?>>
                                <label><?=lang('label_colline')?><font class="text-danger">*</font></label>
                                <select class="form-control" name="COLLINE_ID" id="COLLINE_ID">
                                  <option value=""><?=lang('selectionner')?></option>
                                  <?php if(!empty($collines_parcelles)){
                                  foreach($collines_parcelles as $colline){?>
                                  <option value="<?=$colline['COLLINE_ID']?>" <?php if ($colline['COLLINE_ID']==$info_req['colline_id']) echo "selected";?> ><?=$colline['COLLINE_NAME']?></option>
                                  <?php } }?>
                                </select> 
                                <span id="errCOLLINE_ID" class="text-danger"></span>
                              </div>
                            </div>

                            <div class="row info_perso_morale" <?=$info_morale?>>
                              <div class="col-md-12">
                                <div class="row">
                                  <div class="col-md-4">
                                    <label>Nom Entreprise<font class="text-danger">*</font></label>
                                    <input type="text" class="form-control" oninput="validateInput(this)" id="NOM_ENTREPRISE" name="NOM_ENTREPRISE" value="">
                                    <span id="errNOM_ENTREPRISE" class="text-danger"></span>                           
                                  </div>

                                  <div class="col-md-4">
                                    <label><?=lang('label_nom_representant')?><font class="text-danger">*</font></label>
                                    <input type="text" class="form-control" oninput="validateInput(this)" id="NOM_REPRESENTANT" name="NOM_REPRESENTANT" value="">
                                    <span id="errNOM_REPRESENTANT" class="text-danger"></span>
                                  </div>

                                  <div class="col-md-4">
                                    <label>Mail du Representant<font class="text-danger">*</font></label>
                                    <input type="email" autocomplete="off" required class="form-control" name="EMAIL_REPRESENTANT" id="EMAIL_REPRESENTANT" onblur="verifie_mail2()"  value="">
                                    <span id="errEMAIL_REPRESENTANT" class="text-danger"></span>                           
                                  </div>

                                  <div class="col-md-4">
                                    <label>Numero de Téléphone du Representant<font class="text-danger">*</font></label>
                                    <input type="text" class="form-control" oninput="validatePhoneNumber4(this)" minlength="8" maxlength="12" id="TELEPHONE_REPRESENTANT" name="TELEPHONE_REPRESENTANT" autocomplete="off">  
                                    <span id="errTELEPHONE_REPRESENTANT" class="text-danger"></span>                       
                                  </div>


                                  <div class="col-md-4">
                                    <label>NIF/RC<font class="text-danger">*</font></label>
                                    <input type="text" class="form-control" id="NIF_RC" name="NIF_RC" value="">
                                    <span id="errNIF_RC" class="text-danger"></span>
                                  </div>

                                  <div class="col-md-4">
                                    <label><?=lang('signature_representant')?><font class="text-danger">*</font></label>
                                    <input type="file" class="form-control" name="SIGNATURE_REPRESENTANT" id="SIGNATURE_REPRESENTANT" accept=".png, .jpg, .jpeg">
                                    <div><font color="red" id="error_signatureRepresentant"></font></div> 
                                    <span id="errSIGNATURE_REPRESENTANT" class="text-danger"></span>
                                    <div id="errorMessage" style="color: red;"></div>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="row copropriete">
                              <div class="col-md-12">
                                <div class="row">
                                  <div class="col-md-12" id="button_cart" style="display: none">
                                    <div style="float: right;font-size: 12px;">
                                      <button 
                                      id="btn_cart" 
                                      type="button" 
                                      class="btn" 
                                      onclick="cart_save()" 
                                      style="margin-left: 10px; background-color: #1b5c6e; color: white; border: 1px solid #020f12;"
                                      >
                                      <i class="fa fa-shopping-cart" style="font-size:18px"></i>&nbsp;Ajouter
                                      <span 
                                      id="btn_cart_spine" 
                                      style="display: none; text-align: center; font-size: 12px;"
                                      >
                                      <i class="fa fa-spinner fa-spin fa-2x text-white"></i>
                                    </span>
                                  </button>
                                </div>
                              </div> 

                              <input type="hidden" name="nombre" id="nombre">
                            </div>

                            <!-- affichage des elements de la cart de copropriete -->
                            <div class="col-md-12" id="mycart">
                              <?=$infos_cart ;?>
                            </div>
                            <div class="col-md-12" "></div><br><br>
                            <div class="col-md-6">
                              <div style="float: left;">
                                <button style="margin-left: 10px;background-color:#1b5c6e; color:white; border:1px solid #020f12;" id="btn_enregistrer" type="button" class="btn" onclick="precedent_info_mandantaire()">
                                  << Précédant
                                </button> 
                              </div>
                            </div>

                            <input type="hidden" name="nombre" id="nombre">
                            <div class="col-md-12" id="hide_suivant" id="button_prec" style="display: none">
                              <div style="float: right;">
                                <button style="margin-left: 10px;border: 2px solid #155724;background-color:#1b5c6e; color:white; border:1px"  id="btn_enregistrer" type="button" class="btn" onclick="suivant_info_parcelle()">
                                  Suivant >><span 
                                  id="loading_btnsuiva" 
                                  style="display: none; text-align: center; font-size: 12px;"
                                  >
                                  <i class="fa fa-spinner fa-spin fa-2x text-white"></i>
                                </span>
                              </button>
                            </div>
                          </div>
                          <div class="col-md-12" "></div><br>
                        </div>
                      </div>
                    </div>
                  </div> 
                  <div class="col-md-12" "></div><br>
                  <div class="tab" id="parcelle_info" style="display: none;">
                    <div class="row">

                      <div class="col-md-4">
                        <label><?=lang('label_parcelle_number')?><font class="text-danger">*</font></label>
                        <input readonly value="<?= isset($table_attrib['NUMERO_PARCELLE']) ? htmlspecialchars($table_attrib['NUMERO_PARCELLE']) : '' ?>" type="text" oninput="validateValueParcelle(this)"  class="form-control" name="NUM_PARCEL" id="NUM_PARCEL">    
                        <span id="errNUM_PARCEL" class="text-danger"></span></div>
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
                      <input type="text" class="form-control" oninput="validateInfo(this)" name="NUMERO_SPECIAL" id="NUMERO_SPECIAL" value="<?= isset($table_attrib['NUMERO_ORDRE_SPECIAL']) ? htmlspecialchars($table_attrib['NUMERO_ORDRE_SPECIAL']) : '' ?>">
                      <?php echo form_error('NUMERO_SPECIAL', '<div class="text-danger">', '</div>'); ?>   
                      <span id="errNUMERO_SPECIAL" class="text-danger"></span>                                   
                    </div>
                    <div class="col-md-12">

                    </div>
                    <div class="col-md-6">
                      <label>Volume<font class="text-danger">*</font></label>
                      <input type="text" oninput="validateInfoVolume(this)" class="form-control" name="VOLUME" id="VOLUME"  value="<?= isset($table_attrib['VOLUME']) ? htmlspecialchars($table_attrib['VOLUME']) : '' ?>">

                      <span id="errVOLUME" class="text-danger"></span>
                    </div>

                    <div class="col-md-6">
                      <label>Folio<font class="text-danger">*</font></label>
                      <input type="number" oninput="validateFolio(this)" class="form-control" name="FOLIO" min="0"
                      max="200"
                      step="0.01" id="FOLIO" value="<?= isset($table_attrib['FOLIO']) ? htmlspecialchars($table_attrib['FOLIO']) : '' ?>">
                      <span id="errFOLIO" class="text-danger"></span>
                    </div>

                    <div class="col-md-12"></div><br>
                    <div class="col-md-3">
                      <label><?=lang('superficie_ha')?><font class="text-danger">*</font></label>
                      <input readonly type="text"  oninput="validateInfoFolio(this)" class="form-control" name="SUPER_HA" id="SUPER_HA" value="<?= isset($table_attrib['SUPERFICIE_HA']) ? htmlspecialchars($table_attrib['SUPERFICIE_HA']) : '' ?>">
                      <span id="errSUPER_HA" class="text-danger"></span>   </div>                         

                      <div class="col-md-3">
                        <label><?=lang('superficie_a')?><font class="text-danger">*</font></label>
                        <input readonly type="text"  oninput="validateInfoFolio(this)" class="form-control" name="SUPER_ARE" id="SUPER_ARE"  value="<?= isset($table_attrib['SUPERFICIE_ARE']) ? htmlspecialchars($table_attrib['SUPERFICIE_ARE']) : '' ?>">
                        <span id="errSUPER_ARE" class="text-danger"></span>  </div> 

                        <div class="col-md-3">
                          <label><?=lang('superficie_ca')?><font class="text-danger">*</font></label>
                          <input type="text"   oninput="validateInfoFolio(this)"  class="form-control" name="SUPER_CA" id="SUPER_CA"   value="<?= isset($table_attrib['SUPERFICIE_CA']) ? htmlspecialchars($table_attrib['SUPERFICIE_CA']) : '' ?>" readonly > 
                          <span id="errSUPER_CA" class="text-danger"></span>   </div> 
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
                            required readonly value="<?= isset($table_attrib['POURCENTAGE']) ? htmlspecialchars($table_attrib['POURCENTAGE']) : '' ?>">
                            <div class="invalid-feedback" id="error_POUR100"></div>
                            <?php echo form_error('POUR100', '<div class="text-danger">', '</div>'); ?> 
                          </div>
                          <div class="col-md-12"></div><br>
                          <div class="col-md-3">
                            <label for="PROVINCE_ID1"><?= lang('label_province') ?><span class="text-danger">*</span></label>
                            <select class="form-control" name="PROVINCE_ID1" id="PROVINCE_ID1" disabled>
                              <option value=""><?= lang('selectionner') ?></option>
                              <?php foreach ($provinces as $province) : ?>
                              <option value="<?= htmlspecialchars($province['PROVINCE_ID']) ?>" 
                                <?= ($province['PROVINCE_ID'] == ($table_attrib['PROVINCE_ID'] ?? '')) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($province['PROVINCE_NAME']) ?>
                              </option>
                              <?php endforeach; ?>                               </select>
                              <?= form_error('PROVINCE_ID1', '<div class="text-danger">', '</div>') ?>
                              <span id="errPROVINCE_ID1" class="text-danger"></span>
                            </div>

                            <div class="col-md-3">
                              <label for="COMMUNE_ID1"><?= lang('label_commune') ?><span class="text-danger">*</span></label>
                              <select class="form-control" name="COMMUNE_ID1" id="COMMUNE_ID1_" disabled>
                                <option value=""><?= ($table_attrib['COMMUNE_NAME'] ?? '') ?></option>
                              </select>
                              <span id="errCOMMUNE_ID1" class="text-danger"></span>
                            </div>

                            <div class="col-md-3">
                              <label for="ZONE_ID1"><?= lang('label_zone') ?><span class="text-danger">*</span></label>
                              <select class="form-control" name="ZONE_ID1" id="ZONE_ID1_" disabled>
                                <option value=""><?= ($table_attrib['ZONE_NAME'] ?? '') ?></option>
                              </select>

                              <span id="errZONE_ID1" class="text-danger"></span>
                            </div>

                            <div class="col-md-3">
                              <label for="COLLINE_ID1"><?= lang('label_colline') ?><span class="text-danger">*</span></label>
                              <select class="form-control" name="COLLINE_ID1" id="COLLINE_ID1_" disabled>
                                <option value=""><?= ($table_attrib['COLLINE_NAME'] ?? '') ?></option>
                              </select>
                              <span id="errCOLLINE_ID1" class="text-danger"></span>
                            </div>

                            <div class="col-md-12"></div><br>

                            <div class="col-md-6">
                              <label>Usage<font class="text-danger">*</font></label>
                              <select class="form-control"  name="USAGE" id="USAGE">
                                <option value=""><?=lang('selectionner')?></option>
                                <?php foreach($usagers_proprietes as $usager_propriete) { 
                                if ($usager_propriete['ID_USAGER_PROPRIETE']==$table_attrib['USAGE_ID']) { 
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
                          <input type="text" class="form-control" name="NUM_CADASTRE" id="NUM_CADASTRE" value="<?= isset($table_attrib['NUMERO_PARCELLE']) ? htmlspecialchars($table_attrib['NUMERO_PARCELLE']) : '' ?>" readonly >  
                          <span id="errNUM_CADASTRE" class="text-danger"></span>
                        </div>  
                      </div>

                      <div class="col-md-12" id="hide_pieces_justificatives" style="display: none">
                        <div class="row">
                          <div class="col-md-6">
                            <label>Pièces justificatives<span class="text-danger">*</span></label>
                            <select name="TYPE_PIECE" id="TYPE_PIECE" class="form-control">
                              <option value="">Sélectionner</option>
                              <?php
                              foreach ($type_pieces as $key => $value) { ?>
                              <option value="<?= $value['PIECE_ID']?>"><?= $value['DESCRIPTION']?></option> 
                              <?php }
                              ?>
                              <div class="text-danger" id="errorTYPE_PIECE"></div>
                            </select>
                          </div>
                          <div class="col-md-4">
                            <label>Téléverser<span class="text-danger">*</span></label>
                            <input name="PIECE" id="PIECE" type="file" class="form-control" accept="application/pdf">
                            <div class="text-danger" id="errorPIECE"></div>
                          </div>
                          <div class="col-md-2">
                            <button type="button" id="btn_cart2" style="margin-top: 10px;float: right;border-radius: 15%;border: 2px solid #155724;" class="btn btn-primary"><i class="fa fa-shopping-cart" style="font-size:18px"></i>&nbsp;Ajouter&nbsp;&nbsp;<span id="loading_addcartpiece"></span></button>
                          </div>
                        </div>
                      </div>
                      <br><br>
                      <div class="col-md-12 py-2" style="padding-right: 50px;padding: 15px;" id="DATA_CART_FOR_PIECE">
                      </div>
                      <input type="hidden" id="nyamitwe" >
                      <div class="row">
                        <div class="col-md-6"style="margin-top: 20px; overflow: auto;">
                          <div style="float: left;">
                            <button id="btn_retour" type="button" style="margin-right: 10px;border: 2px solid #155724;background-color:#1b5c6e; color:white; border:1px" class="btn" onclick="toggleTabs()">
                              << Précédant
                            </button>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div style="float: right;">
                            <button id="btn_save" type="button"
                            style="margin-left: 10px; display: none; background-color:#1b5c6e; color:white; border: 2px solid #155724;"
                            class="btn btn-modern"
                            onclick="buttonSave()">
                            <span class="spinner" id="loading_btnsave"></span>
                            <i class="fa fa-save"></i>&nbsp;Enregistrer
                          </button>
                        </div>
                      </div>
                      <div class="col-md-12" "></div><br>
                    </div>
                  </div> 
                </form>
              </div>
            </div>
          </div>
          <!-- end row -->
        </div>
      </div>
    </div>
  </div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>


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
  function suivant_infos_requerant() {
  var statut = 1;
  var RAISON = $("#RAISON").val().trim();

  // Vider l'erreur précédente
  $("#errRAISON").html("");

  // Vérification du champ
  if (RAISON === "") {
    statut = 0;
    $("#errRAISON").html("Ce champ est obligatoire");
  }

 $("#errAUTRE_RAISON").html("");
  if(RAISON === 0){
    if (AUTRE_RAISON ==="") {
      $("#errAUTRE_RAISON").html("Ce champ est obligatoire");
      statut = 0;
    }
  }

  if (statut === 1) {
  // Marquer l'étape 1 comme complétée
  $("#info_div1").removeClass("active").addClass("completed");

  // Activer l'étape 2
  $("#info_div2").removeClass("completed").addClass("active");

  // Afficher le formulaire du requerant
  $("#requerant_info").show();
  $("#mandataire_tabs").hide();

  // Mettre à jour les sous-étapes internes si nécessaire
  $("#etape1").removeClass("active");
  $("#etape2").addClass("active");

} else {
  // Retour arrière en cas de validation échouée
  $("#requerant_info").hide();
  $("#mandataire_tabs").show();

  // Revenir à l'étape 1 visuellement
  $("#info_div1").addClass("active").removeClass("completed");

  // Réinitialiser l'étape 2
  $("#info_div2").removeClass("active completed");

  // Mettre à jour les sous-étapes internes
  $("#etape2").removeClass("active");
  $("#etape1").addClass("active");
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
            $("#errEMAIL_PROP2").html("E-mail existe déjà.");
              $("#errEMAIL_REPRESENTANT").html("E-mail existe déjà.");

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
// alert("Une erreur est survenue.");
}


});

}   
}

//function pour charger automatiques les donnees des inputs dès le chargement de la page
window.onload = function () {
  const type_parcelle = $("#type_parcelle").val();
  const requerant = $("#type_requerant_id").val();
afficher_btn_cart(type_parcelle);
get_requerant(requerant);
get_nationalite();
get_communes();
get_zones();
get_collines();

}; 

function suivant_info_parcelle(argument) {
var statut = 1;
var type_parcelle =$("#type_parcelle").val()

if (type_parcelle !=2){
 $("#hide_suivant").show();

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


// alert(statut)
$('#loading_btnsuiva').hide();
if(statut ==1 && type_parcelle==2){
$('#loading_btnsuiva').show();
$('#requerant_info').hide();
  $('#parcelle_info').show();

  // Marquer les étapes comme complétées ou actives
  $('#info_div1').removeClass('active').addClass('completed');
  $('#info_div2').removeClass('active').addClass('completed');
  $('#info_div3').addClass('active'); // Étape actuelle
  $('#info_div3').removeClass('completed'); // Active ≠ completed

  // Afficher le bouton de sauvegarde final
  $('#btn_save').show();

}else if (statut ==1 && type_parcelle !=2 ) {
$('#loading_btnsuiva').show();
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
function get_requerant(argument) {
let val_sel2 = $('#type_requerant_id').val();

if (val_sel2 == 5) {
$('.info_perso_morale').show();
$('.info_localite_naissance').show();        
$('.info_perso_physique').hide();

} else if (val_sel2 == 1) {
$('.info_perso_physique').show();
$('.info_localite_naissance').show();      
$('.info_perso_morale').hide();
}
}
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
function get_nationalite(argument) {
let val_sel1 = $('#nationalite_id').val();
if (val_sel1 == 28) {
$('.info_localite_naissance').show();
} else {
$('.info_localite_naissance').hide();
}
}
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
  $('#loading_btnsuiva').hide();
let statut = 1;
var requerantTab = document.getElementById("requerant_info");
var parcelleTab = document.getElementById("parcelle_info");
var nextButton = document.getElementById("btn_step1");
var backButton = document.getElementById("btn_retour");

// parcelle_info
document.getElementById('requerant_info').style.display="block"; 
document.getElementById('parcelle_info').style.display="none"; 

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

    if($("#USAGE").val() == "")
    {
      statut = 2;
      $("#errUSAGE").html("La séléction est obligatoire");  
    }
    else
    {
      $("#errUSAGE").html("");
    }

$('#loading_btnsave').hide();
if(statut==1)
{
  document.getElementById('loading_btnsave').style.display = 'inline-block';
  $('#btn_save').prop('disabled',true);
  myform.submit();
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

<script type="text/javascript">
  $(document).ready(function(){

    $('#btn_cart2').click(function(){

     var PIECE = $('#PIECE').val();
     var TYPE_PIECE = $('#TYPE_PIECE').val();
     var statut = 1;

     var file= document.getElementById("PIECE").files[0];
     var form= new FormData();
     form.append("TYPE_PIECE", TYPE_PIECE);
     form.append("PIECE",file);

     if (PIECE=="")
     {
       $('#errorPIECE').html('<?= lang('messages_lang.champ_obligatoire1') ?>');
       statut = 0;
     }
     else
     {
       $('#errorPIECE').html('');
     }

     if(TYPE_PIECE != "")
     { 

      $('#errorTYPE_PIECE').html('');

    }

    else if(TYPE_PIECE == ""){
      $('#errorTYPE_PIECE').html('<?= lang('messages_lang.champ_obligatoire1') ?>');
      statut = 0;

    }

    if(statut == 1)
    { 

     $('#btn_cart2').attr('disabled',true);
     $('#loading_addcartpiece').html("<i class='fa fa-spinner fa-pulse fa-1x fa-fw'></i>");

     $.ajax({
       url: "<?php echo base_url('administration/Numeriser_New/add_in_cart_piece');?>",
       type: "POST",
       data: form,
       processData: false,  
       contentType: false, 
       success: function(data){
        if (data !== "") {
          $('#DATA_CART_FOR_PIECE').html(data);
          $('#btn_cart2').attr('disabled',false);
          $('#loading_addcartpiece').html("");
          $('#btn_save').show();
          $('#nyamitwe').val(1);
          $('#TYPE_PIECE').val("");
          $('#PIECE').val("");
        }else{

          $('#btn_save').hide();
          $('#btn_cart2').attr('disabled',false);

        }
      }  
    });
   }

 });
  });
</script>

<script type="text/javascript">
 function remove_documentpiece(id) {
    // const rowid = $('#rowid' + id).val();
    const rowid = id;

    const url = "<?= base_url('administration/Numeriser_New/remove_documentpiece') ?>";

    $.post(url, { rowid: rowid }, function(response) {
        if (response.status) {
            $('#DATA_CART_FOR_PIECE').html(response.cart);
        } else {
            $('#DATA_CART_FOR_PIECE').html('<div class="text-danger">Erreur lors de la suppression.</div>');
        }
    }, 'json') // <<< Important pour dire à jQuery d’interpréter la réponse comme JSON
    .fail(function(xhr, status, error) {
        console.error("Erreur AJAX :", status, error);
        $('#DATA_CART_FOR_PIECE').html('<div class="text-danger">Erreur réseau.</div>');
    });
}


</script>

<script type="text/javascript">
function exist_mail(){
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
success:function(data) {
// alert(data)
if(data.statut==0){
$('#loading_btnsuiva').hide();
document.getElementById('requerant_info').style.display="none"; 
document.getElementById('parcelle_info').style.display="block";
$('#btn_save').show();

// tabs
$('#requerant_info').hide();
  $('#parcelle_info').show();

  // Marquer les étapes comme complétées ou actives
  $('#info_div1').removeClass('active').addClass('completed');
  $('#info_div2').removeClass('active').addClass('completed');
  $('#info_div3').addClass('active'); // Étape actuelle
  $('#info_div3').removeClass('completed'); // Active ≠ completed

  // Afficher le bouton de sauvegarde final
  $('#btn_save').show();

} else if(data.statut==1){
  $('#loading_btnsuiva').hide();
$("#check_email_mandataire").html('<div class="alert alert-danger text-center">L\'adresse e-mail existe déjà!</div>');
$('#btn_save').hide();


$("#check_mail").html('');
$("#check_mail3").html('');
// bbbbbbbbbbb
$("#EMAIL_PROP2").css("border", "1px solid red");
$("#EMAIL_REPRESENTANT").css("border", "1px solid red");
$("#errEMAIL_REPRESENTANT").html("E-mail existe déjà");
$("#errEMAIL_PROP2").html("E-mail existe déjà");
document.getElementById('requerant_info').style.display="block"; 
document.getElementById('parcelle_info').style.display="none";

} else{
$("#check_email_mandataire").html('');
$("#check_mail").html('');
$("#check_mail3").html('');

$("#EMAIL_PROP2").css("border", "");
$("#EMAIL_REPRESENTANT").css("border", "");
$("#errEMAIL_REPRESENTANT").html("");
$("#errEMAIL_PROP2").html("");
$('#loading_btnsuiva').hide();

// bbbbbbbbbbbbb
document.getElementById('requerant_info').style.display="none"; 
document.getElementById('parcelle_info').style.display="block";
}
},

});

}


</script>

<script type="text/javascript">
          function get_autre_motif(argument) {
            var raisonDiv = document.querySelector('.col1');
              raisonDiv.classList.remove('col-md-6');
              raisonDiv.classList.add('col-md-12');
            $('#hide_autre_raison').hide();
            if ($('#RAISON').val()==0) {
                  raisonDiv.classList.remove('col-md-12');
                  raisonDiv.classList.add('col-md-6');
              $('#hide_autre_raison').show();
            }

          }
        </script>

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

<script>
document.getElementById("PIECE").addEventListener("change", function() {
    const file = this.files[0];
    if (file && file.size > 5 * 1024 * 1024) { // 5 Mo
        alert("Le fichier ne doit pas dépasser 5 Mo.");
        this.value = "";
    }
});
</script>





