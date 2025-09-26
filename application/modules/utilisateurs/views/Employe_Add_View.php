  <!DOCTYPE html>
<html lang="en">
<head>
 <?php include VIEWPATH.'includes/header.php'; ?>

 <style type="text/css">

   .nav-pills .nav-link.active, .nav-pills .show>.nav-link {
    color: #fff;
    background-color: #17a2b8;
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
     <!-- jQuery FIRST -->
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

     <!-- Select2 AFTER -->
     <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
     <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

     <!-- Pour les traductions -->
     <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/i18n/fr.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>



     <div class="midde_cont" >
      <div class="container-fluid">
        <div class="row column_title">
          <div class="col-md-12">
           <div class="page_title">

            <div class="row">
              <div class="col-md-6">
                <h2>
                  <i class="fa fa-user" aria-hidden="true"></i> Enregistrement d'employé
                </h2>
              </div>
              <div class="col-md-3">
              </div>
              <div class="col-md-3">

                
                <div class="btn-group">
                  <a href="<?= base_url('utilisateurs/Employe')?>" class="btn btn-success">
                      <i style="color: white" class="fa fa-bars" aria-hidden="true"></i>
                      <label idC"tasks_number"></label> Employés
                    </a>

                </div>   
              </div>
            </div>
            
          </div>
        </div>
      </div>



      <div class="row">
        <div class="col-md-12">
         <div class="white_shd full margin_bottom_30">


          <div class="full graph_head">
           <div class="heading1 margin_0">

            <div class="row">
              <div class="col-md-12">

                <?=$this->session->flashdata('message')?>
                
              </div> 




              <div class="col-md-2"></div>

            </div>

                    <div class="full price_table padding_infor_info">
                      <form method="POST" id="myformcompt"  enctype="multipart/form-data" action="<?=base_url().'utilisateurs/Employe/save'?>">

                <div class="row mb-4">
                
                    <div class="form-group col-lg-6" id="physique_nom">
                      <label style="font-weight: 900; color:#454545">Nom<span style="color:red;">*</span></label>
                      <input type="text" class="form-control" placeholder="Nom" name="NOM" id="NOM">

                      <font color="red" id="erNOM"><?php echo form_error('NOM'); ?></font>
                    </div>
                    <div class="form-group col-lg-6" id="physique_prenom">
                      <label style="font-weight: 900; color:#454545">Prénom</label>
                      <input type="text" class="form-control" placeholder="Prénom" name="PRENOM" id="PRENOM">
                      <font color="red" id="erPRENOM" class="help"><?php echo form_error('PRENOM'); ?></font>
                    </div>

                    <div class="form-group col-lg-6" id="physique_prenom">
                      <label style="font-weight: 900; color:#454545">Genre</label>
                        
                      <select class="form-control" name="SEXE_ID"  id="SEXE_ID" >
                        <option value="">Séléctionner</option>
                        <option value="1">Masculin</option>
                        <option value="0">Féminin</option>
                      </select>
                      <font color="red" id="erSEXE_ID" class="help"></font>
                    </div>

                    <div class="form-group col-lg-6">
                      <label style="font-weight: 900; color:#454545">Nationalité<span style="color:red;">*</span></label>
                      <select class="form-control info_perso_nationalite" onchange="affiche_loca()"  name="nationalite_id"  id="nationalite_id">
                        <option value="">Sélectionner</option>
                        <?php foreach($nationalites as $nationalite) { 
                          if ($nationalite['id']==set_value('nationalite_id')) { 

                            echo "<option value='".$nationalite['id']."' selected> ".$nationalite['name']."</option>";
                            
                          }  else{
                            echo "<option value='".$nationalite['id']."' >".$nationalite['name']."</option>"; 

                            
                          } }?>                     

                        </select> 
                        <?php echo form_error('nationalite_id', '<div class="text-danger">', '</div>'); ?>
                        <span id="errnationalite_id" class="text-danger"></span>                                
                      </div>

                      <div class="form-group col-lg-6">
                      <label style="font-weight: 900; color:#454545">Diplôme<span style="color:red;">*</span></label>
                      <select class="form-control" name="DIPLOME_ID"  id="DIPLOME_ID" onchange="get_type_diplome(this.value);">
                        <option value="">Sélectionner</option>
                        <?php foreach($type_diplome as $type_diplome) { 
                          if ($type_diplome['DIPLOME_ID']==set_value('DIPLOME_ID')) { 

                            echo "<option value='".$type_diplome['DIPLOME_ID']."' > ".$type_diplome['DESCRIPTION']."</option>"; 
                            
                          }  else{
                            echo "<option value='".$type_diplome['DIPLOME_ID']."' > ".$type_diplome['DESCRIPTION']."</option>"; 

                            
                          } }?>                     

                        </select> 
                        <?php echo form_error('DIPLOME_ID', '<div class="text-danger">', '</div>'); ?>
                        <span id="erDIPLOME_ID" class="text-danger"></span>                                
                      </div>

                      <div class="form-group col-lg-6" id="hide_autre_diplome" style="display: none">
                      <label style="font-weight: 900; color:#454545">Précisez autre type de diplôme</label>
                      <input type="text" class="form-control" placeholder="Autre diplôme" name="AUTRE_DIPLOME" id="AUTRE_DIPLOME">
                      <font color="red" id="erAUTRE_DIPLOME" class="help"><?php echo form_error('AUTRE_DIPLOME'); ?></font>
                    </div>

                    <script type="text/javascript">
                      function get_type_diplome(DIPLOME_ID) {
                        // alert(DIPLOME_ID);
                        if (DIPLOME_ID==0) {
                          $("#hide_autre_diplome").show();
                        } else{
                          $("#hide_autre_diplome").hide();

                        }
                        
                      }
                    </script>

                    <div class="form-group col-lg-6">
                      <label style="font-weight: 900; color:#454545">Type de contrat<span style="color:red;">*</span></label>
                      <select class="form-control" name="TYPE_CONTRAT_ID"  id="TYPE_CONTRAT_ID" onchange="get_date_expiration(this.value)" >
                        <option value="">Sélectionner</option>
                        <?php foreach($type_contrat as $type_contrat) { 
                          if ($type_contrat['TYPE_CONTRAT_ID']==set_value('TYPE_CONTRAT_ID')) { 

                            echo "<option value='".$type_contrat['TYPE_CONTRAT_ID']."' > ".$type_contrat['DESCRIPTION']."</option>"; 
                            
                          }  else{
                            echo "<option value='".$type_contrat['TYPE_CONTRAT_ID']."' > ".$type_contrat['DESCRIPTION']."</option>"; 

                            
                          } }?>                     

                        </select> 
                        <?php echo form_error('TYPE_CONTRAT_ID', '<div class="text-danger">', '</div>'); ?>
                        <span id="erTYPE_CONTRAT_ID" class="text-danger"></span>                                
                      </div>

 <div class="form-group col-lg-6" style="display: none" id="hide_date_expiration">
  <label style="font-weight: 900; color:#454545">Date d'expiration du contrat<span style="color:red;">*</span></label>
  <input type="date" class="form-control" name="DATE_EXPIRATION" id="DATE_EXPIRATION">
  <div id="erDATE_EXPIRATION" class="text-danger mt-1"></div>
</div>

<script type="text/javascript">
  function get_date_expiration(id) {
    if (id ==1) {
      $('#hide_date_expiration').show();
    } else {
    $('#hide_date_expiration').hide();
    }
    
  }
</script>

                      <div class="form-group col-lg-6">
                      <label style="font-weight: 900; color:#454545">Poste occupé<span style="color:red;">*</span></label>
                      <select class="form-control" name="POSTE_ID"  id="POSTE_ID" onchange="get_type_poste(this.value);">
                        <option value="">Sélectionner</option>
                        <?php foreach($poste_occupe as $poste_occupe) { 
                          if ($poste_occupe['POSTE_ID']==set_value('POSTE_ID')) { 

                            echo "<option value='".$poste_occupe['POSTE_ID']."' > ".$poste_occupe['DESCRIPTION']."</option>"; 
                            
                          }  else{
                            echo "<option value='".$poste_occupe['POSTE_ID']."' > ".$poste_occupe['DESCRIPTION']."</option>"; 
                            
                          } }?>                     

                        </select> 
                        <?php echo form_error('POSTE_ID', '<div class="text-danger">', '</div>'); ?>
                        <span id="erPOSTE_ID" class="text-danger"></span>                                
                      </div>

                      <div class="form-group col-lg-6" id="hide_autre_poste" style="display: none">
                      <label style="font-weight: 900; color:#454545">Précisez l'autre de poste</label>
                      <input type="text" class="form-control" placeholder="Autre poste" name="AUTRE_POSTE" id="AUTRE_POSTE">
                      <font color="red" id="erAUTRE_POSTE" class="help"><?php echo form_error('AUTRE_POSTE'); ?></font>
                    </div>

                    <script type="text/javascript">
                      function get_type_poste(POSTE) {
                        // alert(DIPLOME_ID);
                        if (POSTE==0) {
                          $("#hide_autre_poste").show();
                        } else{
                          $("#hide_autre_poste").hide();

                        }
                        
                      }
                    </script>

  <div class="form-group col-lg-6">
  <label style="font-weight: 900; color:#454545">Date de recrutement<span style="color:red;">*</span></label>
  <input type="date" class="form-control" name="DATE_RECRUTEMENT" id="DATE_RECRUTEMENT">
  <div id="erDATE_RECRUTEMENT" class="text-danger mt-1"></div>
  <input type="hidden" id="valide_date_recrutement" value="0">
</div>

<script>
document.getElementById("DATE_RECRUTEMENT").addEventListener("input", function() {
  const input = this;
  const errorDiv = document.getElementById("erDATE_RECRUTEMENT");
  const selectedDate = new Date(input.value);
  const today = new Date();
  today.setHours(0, 0, 0, 0); // Pour ignorer l'heure

  if (selectedDate > today) {
    errorDiv.textContent = "La date ne peut pas être supérieure à aujourd’hui.";
    input.style.borderColor = "#dc3545";
  } else {
    errorDiv.textContent = "";
    input.style.borderColor = "#28a745";
    $("#valide_date_recrutement").val(1);
  }
});

document.getElementById("DATE_EXPIRATION").addEventListener("input", function() {
  const input = this;
  const errorDiv = document.getElementById("erDATE_EXPIRATION");
  const selectedDate = new Date(input.value);
  const today = new Date();
  today.setHours(0, 0, 0, 0); // Pour ignorer l'heure

  if (selectedDate < today) {
    errorDiv.textContent = "La date doit être supérieure ou égale à aujourd’hui.";
    input.style.borderColor = "#dc3545";
  } else {
    errorDiv.textContent = "";
    input.style.borderColor = "#28a745";
    $("#valide_date_recrutement").val(1);
  }
});
</script>



       <div class="form-group col-lg-6">
  <label style="font-weight: 900; color:#454545">Téléphone<span style="color:red;">*</span></label>
  <input type="text" maxlength="10" class="form-control" placeholder="Tél" name="TEL1" id="TEL1" oninput="validatePhoneNumber2()">
  <div id="erTEL1" class="help text-danger mt-1"></div>
  <input type="hidden" id="valide_phone1" value="0">
</div>

<div class="form-group col-lg-6" id="physique_prenom">
    <label style="font-weight: 900; color:#454545">Etat civil</label>
      
    <select class="form-control" name="ETAT_CIVIL"  id="ETAT_CIVIL" >
      <option value="">Séléctionner</option>
      <option value="1">Marié</option>
      <option value="0">Celibataire</option>
    </select>
    <font color="red" id="erETAT_CIVIL" class="help"></font>
  </div>

  <div class="form-group col-lg-6" id="physique_prenom">
  <label style="font-weight: 900; color:#454545">Téléverser un CV</label>   
  <input type="file" class="form-control" name="CV" id="CV" onchange="validateFileSize()">
  <div id="erCV" class="help text-danger mt-1"></div>
  <input type="hidden" id="valide_cv" value="0">
</div>

<script>
function validateFileSize() {
  const input = document.getElementById("CV");
  const errorDiv = document.getElementById("erCV");
  const maxSize = 2 * 1024 * 1024; // 2 Mo

  if (input.files.length > 0) {
    const file = input.files[0];

    if (file.size > maxSize) {
      errorDiv.textContent = "Le fichier dépasse la taille maximale autorisée (2 Mo).";
      input.style.borderColor = "#dc3545";
      document.getElementById("valide_cv").value = 0;
    } else {
      errorDiv.textContent = "";
      input.style.borderColor = "#28a745";
      document.getElementById("valide_cv").value = 1;
    }
  } else {
    errorDiv.textContent = "Veuillez sélectionner un fichier.";
    input.style.borderColor = "#dc3545";
    document.getElementById("valide_cv").value = 0;
  }
}
</script>


  <div class="form-group col-lg-6" id="physique_prenom">
    <label style="font-weight: 900; color:#454545">Téléverser un diplôme</label>   
    <input type="file" class="form-control" name="DIPLOME"  id="DIPLOME" onchange="validateFileSize2()" >
    <font color="red" id="erDIPLOME" class="help"></font>
  </div>

  <script>
function validateFileSize2() {
  const input = document.getElementById("CV");
  const errorDiv = document.getElementById("erCV");
  const maxSize = 2 * 1024 * 1024; // 2 Mo

  if (input.files.length > 0) {
    const file = input.files[0];

    if (file.size > maxSize) {
      errorDiv.textContent = "Le fichier dépasse la taille maximale autorisée (2 Mo).";
      input.style.borderColor = "#dc3545";
      document.getElementById("valide_cv").value = 0;
    } else {
      errorDiv.textContent = "";
      input.style.borderColor = "#28a745";
      document.getElementById("valide_cv").value = 1;
    }
  } else {
    errorDiv.textContent = "Veuillez sélectionner un fichier.";
    input.style.borderColor = "#dc3545";
    document.getElementById("valide_cv").value = 0;
  }
}
</script>



<script>
function validatePhoneNumber2() {
  const input = document.getElementById("TEL1");
  const value = input.value.replace(/\D/g, ''); // Supprime tout sauf les chiffres
  const errorSpan = document.getElementById("erTEL1");

  input.value = value; // Met à jour le champ avec uniquement les chiffres

  if (value.length > 10 || value.length < 8) {
    // errorSpan.textContent = "Le numéro doit contenir de 8 à 10 chiffres.";
    errorSpan.textContent = "";
    input.style.borderColor = "#dc3545"; // rouge
    document.getElementById("valide_phone1").value = 0;
  } else {
    errorSpan.textContent = "";
    input.style.borderColor = "#28a745"; // vert
    document.getElementById("valide_phone1").value = 1;
  }
}
</script>


  <!-- <input type="hidden" id="valide_phone1"> -->

   <div class="form-group col-lg-6">
  <label style="font-weight: 900; color:#454545">E-mail<span class="text-danger">*</span></label>
  <input type="text" id="EMAIL" name="EMAIL" class="form-control" placeholder="E-mail"
         oninput="verifie_mail1()">
  <div id="erEMAIL" class="help text-danger mt-1"></div>
  <input type="hidden" id="valide_email1" value="0">
</div>

<script>
function verifie_mail1() {
  const emailField = document.getElementById("EMAIL");
  const email = emailField.value.trim();
  const errorDiv = document.getElementById("erEMAIL");
  const regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

  if (email === "") {
    errorDiv.textContent = "L'adresse e-mail est obligatoire.";
    emailField.style.borderColor = "#dc3545";
    document.getElementById("valide_email1").value = 0;
    return;
  }

  if (!regex.test(email)) {
    // errorDiv.textContent = "Format de l'adresse e-mail invalide.";
    errorDiv.textContent = "";
    emailField.style.borderColor = "#dc3545";
    document.getElementById("valide_email1").value = 0;
    return;
  }

  errorDiv.textContent = "";
  emailField.style.borderColor = "#28a745";
  document.getElementById("valide_email1").value = 1;
}
</script>







           <input type="hidden" id="valide_email1" > 

  <div class="col-md-6">     
  <label for="PASSWORD1" style="font-weight: 900; color:#454545">Mot de passe<font color="red">*</font></label>
  <input type="text" name="PASSWORD1" id="PASSWORD1" class="form-control" oninput="validatePassword()">
  <div class="text-danger mt-1" id="erPWD"></div>
  <input type="hidden" id="valide_pwd1" value="0">
</div>

<script>
function validatePassword() {
  const input = document.getElementById("PASSWORD1");
  const value = input.value;
  const errorDiv = document.getElementById("erPWD");

  const hasUppercase = /[A-Z]/.test(value);
  const hasSpecialChar = /[!@#$%^&*(),.?":{}|<>]/.test(value);
  const isLongEnough = value.length >= 6;

  if (!isLongEnough || !hasUppercase || !hasSpecialChar) {
    errorDiv.textContent = "Le mot de passe doit contenir au moins 6 caractères, une majuscule et un caractère spécial.";
    input.style.borderColor = "#dc3545"; // rouge
    document.getElementById("valide_pwd1").value = 0;
  } else {
    errorDiv.textContent = "";
    input.style.borderColor = "#28a745"; // vert
    document.getElementById("valide_pwd1").value = 1;
  }
}
</script>


                    <div class="col-md-6">     
                      <label for="PASSWORD2" style="font-weight: 900; color:#454545">Confirmer mot de passe<font color="red">*</font></label>
                      <input type="text" name="PASSWORD2" id="PASSWORD2"
                      class="form-control"  >
                      <div class="text-danger" id="erPWD2"></div>
                    </div>
                    <div class="form-group col-lg-9"></div>
                    <br><br>
                    <div class="form-group col-lg-3">
                      <button type="button" style="margin-top: 20px;float: right;border:1px solid #020f12;" id="btsave" class="main_bt" onclick="verify2()">Enregistrer&nbsp;<span id="loading_spinner2" style="display: none; text-align:center;font-size: 12px">
                        <i class="fa fa-spinner fa-spin fa-2x text-primary"></i>
                      </span> 
                    </button>
                    <div class="text-danger" id="erenregistrement"></div>
                  </div>
              </form>
                    </div>

                  </div>       

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- footer -->

  </div>
  <!-- end dashboard inner -->
</div>
</div>
</div>
</div>

<script type="text/javascript">
function verify2() {

  var input_tel=document.getElementById('TEL1');
  var input_EMAIL=document.getElementById('EMAIL');

  var numberReg =  /^[+0-9 ]+$/;
  var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
  var Email = $('#EMAIL').val();
  var tell1 = $('#TEL1').val();
  var tell2 = $('#EMAIL').val();

  var pwd1 = $('#PASSWORD1').val();
  var pwd2 = $('#PASSWORD2').val();
  var nation = $('#nationalite_id').val();

  var statut = true;

$("#SEXE_ID").css("border", "1px solid green");
$("#NOM").css("border", "1px solid green");
$("#PRENOM").css("border", "1px solid green");
$("#nationalite_id").css("border", "1px solid green");
$("#TEL1").css("border", "1px solid green");
$("#EMAIL").css("border", "1px solid green");
$("#PASSWORD1").css("border", "1px solid green");
$("#PASSWORD2").css("border", "1px solid green");

$("#DIPLOME_ID").css("border", "1px solid green");
 $('#erDIPLOME_ID').text('');

  if ($('#DIPLOME_ID').val() == "") {

    $('#erDIPLOME_ID').text('Ce champs est obligatoire');
    $("#DIPLOME_ID").css("border", "1px solid red");
    $("#DIPLOME_ID").focus();
    statut = false;
    console.log(statut)
  } 

  $("#AUTRE_DIPLOME").css("border", "1px solid green");
  $('#erAUTRE_DIPLOME').text('');
  if ($('#DIPLOME_ID').val() == 0) {
    $('#erAUTRE_DIPLOME').text('');

    if ($('#AUTRE_DIPLOME').val() == "") {

      $('#erAUTRE_DIPLOME').text('Ce champs est obligatoire');
      $("#AUTRE_DIPLOME").css("border", "1px solid red");
      $("#AUTRE_DIPLOME").focus();
      statut = false;
      console.log(statut)
    } 
  }

  $("#AUTRE_POSTE").css("border", "1px solid green");
$('#erAUTRE_POSTE').text('');
if ($('#POSTE_ID').val() == 0) {
  $('#erAUTRE_POSTE').text('');

  if ($('#AUTRE_POSTE').val() == "") {

    $('#erAUTRE_POSTE').text('Ce champs est obligatoire');
    $("#AUTRE_POSTE").css("border", "1px solid red");
    $("#AUTRE_POSTE").focus();
    statut = false;
    console.log(statut)
  } 
  }

   $("#POSTE_ID").css("border", "1px solid green");
$('#erPOSTE_ID').text('');
  if ($('#POSTE_ID').val() == "") {

    $('#erPOSTE_ID').text('Ce champs est obligatoire');
    $("#POSTE_ID").css("border", "1px solid red");
    $("#POSTE_ID").focus();
    statut = false;
    console.log(statut)
  }

   $("#TYPE_CONTRAT_ID").css("border", "1px solid green");
$('#erTYPE_CONTRAT_ID').text('');
  if ($('#TYPE_CONTRAT_ID').val() == "") {

    $('#erTYPE_CONTRAT_ID').text('Ce champs est obligatoire');
    $("#TYPE_CONTRAT_ID").css("border", "1px solid red");
    $("#TYPE_CONTRAT_ID").focus();
    statut = false;
    console.log(statut)
  }

  if ($('#TYPE_CONTRAT_ID').val() ==1) {

   $("#DATE_EXPIRATION").css("border", "1px solid green");
$('#erDATE_EXPIRATION').text('');
  if ($('#DATE_EXPIRATION').val() == "") {

    $('#erDATE_EXPIRATION').text('Ce champs est obligatoire');
    $("#DATE_EXPIRATION").css("border", "1px solid red");
    $("#DATE_EXPIRATION").focus();
    statut = false;
    console.log(statut)
  }
  }


  if (new Date($('#DATE_EXPIRATION').val()) <= new Date($('#DATE_RECRUTEMENT').val())) {
  $('#erDATE_EXPIRATION').text("La date d'expiration du contrat doit être supérieure à la date de recrutement !");
  $("#DATE_EXPIRATION").css("border", "1px solid red");
  $("#DATE_EXPIRATION").focus();
  statut = false;
}



  $("#DATE_RECRUTEMENT").css("border", "1px solid green");
$('#erDATE_RECRUTEMENT').text('');
  if ($('#valide_date_recrutement').val() == 0) {

    $('#erDATE_RECRUTEMENT').text('Date invalide');
    $("#DATE_RECRUTEMENT").css("border", "1px solid red");
    $("#DATE_RECRUTEMENT").focus();
    statut = false;
    console.log(statut)
  }

    $("#ETAT_CIVIL").css("border", "1px solid green");
$('#erETAT_CIVIL').text('');
  if ($('#ETAT_CIVIL').val() == "") {

    $('#erETAT_CIVIL').text('Ce champs est obligatoire');
    $("#ETAT_CIVIL").css("border", "1px solid red");
    $("#ETAT_CIVIL").focus();
    statut = false;
    console.log(statut)
  }

  $("#CV").css("border", "1px solid green");
$('#erCV').text('');
  if ($('#CV').val() == "") {

    $('#erCV').text('Ce champs est obligatoire');
    $("#CV").css("border", "1px solid red");
    $("#CV").focus();
    statut = false;
    console.log(statut)
  }

  $("#DIPLOME").css("border", "1px solid green");
$('#erDIPLOME').text('');
  if ($('#DIPLOME').val() == "") {

    $('#erDIPLOME').text('Ce champs est obligatoire');
    $("#DIPLOME").css("border", "1px solid red");
    $("#DIPLOME").focus();
    statut = false;
    console.log(statut)
  }

  
  
  $('#erNOM').text('');

  if ($('#NOM').val() == "") {

    $('#erNOM').text('Ce champs est obligatoire');
    $("#NOM").css("border", "1px solid red");
    $("#NOM").focus();
    statut = false;
    console.log(statut)
  } 

  $('#erSEXE_ID').text('');

    if ($('#SEXE_ID').val() == "") {
$("#SEXE_ID").css("border", "1px solid red");
    $('#erSEXE_ID').text('Ce champs est obligatoire');
    $("#SEXE_ID").focus();
    statut = false;
    console.log(statut)
  } 

  
  if ($('#valide_pwd1').val() == 0) {
$("#PASSWORD1").css("border", "1px solid red");

    $('#erPWD').text('Mot de passe invalide');
    $("#PASSWORD1").focus();
    statut = false;
    console.log(statut)
  }

  if ($('#PASSWORD1').val() == "") {
$("#PASSWORD1").css("border", "1px solid red");

    $('#erPWD').text('Mot de passe obligatoire');


    $("#PASSWORD1").focus();
    statut = false;
    console.log(statut)
  }

  if ($('#nationalite_id').val() == "") {
$("#nationalite_id").css("border", "1px solid red");

    $('#errnationalite_id').text('Le champ est obligatoire');

    $("#nationalite_id").focus();
    statut = false;
    console.log(statut)
  }

   if ($('#PASSWORD1').val() == "") {
$("#PASSWORD1").css("border", "1px solid red");

      document.getElementById("erPWD").innerHTML = "Veuillez entrer votre mot de passe";
      statut = false;
      // return;
    } else {
      document.getElementById("erPWD").innerHTML = "";

      $('#erPWD').html('');

      if ($('#PASSWORD1').val().length < 6 || !/^(?=.*[A-Za-z])(?=.*\d).{6,}$/.test($('#PASSWORD1').val())) {
$("#PASSWORD1").css("border", "1px solid red");

        statut = false;
        $('#erPWD').html('Le mot de passe doit comporter au moins 6 caractères et inclure des lettres et des chiffres.');
      }
    }


    $('#erPWD2').html('');

    if ($('#PASSWORD1').val() !== $('#PASSWORD2').val()) {
$("#PASSWORD1").css("border", "1px solid red");
$("#PASSWORD2").css("border", "1px solid red");

      statut = false;
      $('#erPWD2').html('La confirmation du mot de passe ne correspond pas.');
    }

  $('#erPRENOM').text('');
var datt = $('#PRENOM').val();
if (datt == "") {

  $('#erPRENOM').text('Ce champs est obligatoire');
$("#PRENOM").css("border", "1px solid red");

  $("#PRENOM").focus();
  statut = false;
  console.log(statut)
} 

  $('#erTEL1').text('');
var datt = $('#TEL1').val();
if (datt == "") {

  $('#erTEL1').text('Ce champs est obligatoire');
$("#TEL1").css("border", "1px solid red");

  $("#TEL1").focus();
  statut = false;
  console.log(statut)
} 

  $('#erEMAIL').text('');
var datt = $('#EMAIL').val();
if (datt == "") {

  $('#erEMAIL').text('Ce champs est obligatoire');
$("#EMAIL").css("border", "1px solid red");

  $("#EMAIL").focus();
  statut = false;
  console.log(statut)
} 


if ($('#valide_phone1')<1) {
  statut = false;
}

if ($('#valide_email1')<1) {
  statut = false;
}

$('#loading_spinner2').hide();
  // alert("eric")

if (statut==true)
{
  exist_mail()
  $('#btsave').attr("disabled", true);
  // exist_username();
$('#loading_spinner2').show();
//  myformcompt.submit();
}



}

</script>


</html>

<script type="text/javascript">

    function exist_mail(){
    var email = $('#EMAIL').val().trim();
    $.ajax({
  url : "<?=base_url('/utilisateurs/Employe/verify_email/')?>", 
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
  
   if(data==0){
 $('#loading_spinner2').show();
 myformcompt.submit();
 }else if(data==1){

    $("#erEMAIL").html("E-mail existe déjà.");
    $("#EMAIL").css("border", "1px solid red");
$('#loading_spinner2').hide();
$('#btsave').attr("disabled", false);

 }
 
   },
    complete: function() {
        $('#loading_spinner').hide();
    },

    error: function() {
        // 👇 En cas d’erreur serveur
        $('#loading_spinner').hide();
        $('#erenregistrement').text("Une erreur est survenue. Veuillez réessayer.");
 $('#loading_spinner2').hide();
 $('#btsave').attr("disabled", false);


    }

});
   }
   
   </script>








