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
                  <i class="fa fa-user" aria-hidden="true"></i> Nouvel utilisateur
                </h2>
              </div>
              <div class="col-md-3">
              </div>
              <div class="col-md-3">

                <!-- Split button -->
                <div class="btn-group">
                  <a href="<?= base_url('utilisateurs/Utilisateurs') ?>" class="btn btn-success">
                      <i style="color: white" class="fa fa-bars" aria-hidden="true"></i>
                      <label id="tasks_number"></label> Utilisateurs
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
                      <form method="POST" id="myformcompt"  enctype="multipart/form-data" action="<?=base_url().'utilisateurs/Utilisateurs/save'?>">

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
                      <label style="font-weight: 900; color:#454545">pays<span style="color:red;">*</span></label>
                      <select class="form-control info_perso_nationalite" onchange="affiche_loca()"  name="nationalite_id"  id="nationalite_id">
                        <option value="">Sélectionner</option>
                        <?php foreach($nationalites as $nationalite) { 
                          if ($nationalite['id']==set_value('nationalite_id')) { 

                            echo "<option value='".$nationalite['id']."' selected>".$nationalite['CODE_TEL']." ".$nationalite['name']."</option>";
                            
                          }  else{
                            echo "<option value='".$nationalite['id']."' >".$nationalite['CODE_TEL']." ".$nationalite['name']."</option>"; 

                            
                          } }?>                     

                        </select> 
                        <?php echo form_error('nationalite_id', '<div class="text-danger">', '</div>'); ?>
                        <span id="errnationalite_id" class="text-danger"></span>                                
                      </div>

                      <div class="form-group col-lg-6">
                      <label style="font-weight: 900; color:#454545">Profile<span style="color:red;">*</span></label>
                      <select class="form-control" name="PROFIL_ID"  id="PROFIL_ID">
                        <option value="">Sélectionner</option>
                        <?php foreach($profiles as $profiles) { 
                          if ($profiles['PROFIL_ID']==set_value('PROFIL_ID')) { 

                            echo "<option value='".$profiles['id']."' selected>".$profiles['PROFIL_ID']." ".$nationalite['DESCRIPTION']."</option>";
                            
                          }  else{
                            echo "<option value='".$profiles['PROFIL_ID']."' > ".$profiles['DESCRIPTION']."</option>"; 

                            
                          } }?>                     

                        </select> 
                        <?php echo form_error('PROFIL_ID', '<div class="text-danger">', '</div>'); ?>
                        <span id="erPROFIL_ID" class="text-danger"></span>                                
                      </div>


        <div class="form-group col-lg-6">
          <label style="font-weight: 900; color:#454545">Téléphone<span style="color:red;">*</span></label>
          <input type="number" maxlength="8" minlength="8" class="form-control" placeholder="Tél" name="TEL1" id="TEL1" oninput="validatePhoneNumber2(this)">
          <font color="red" id="erTEL1"  class="help"><?php echo form_error('TEL1'); ?></font>

          <font color="red" id="erTEL1"  class="help"></font>

          </div>
              <input type="hidden" id="valide_phone1">

    <div class="form-group col-lg-6">
      <label style="font-weight: 900; color:#454545">E-mail<span class="text-danger">*</span></label>
      <input type="email" id="EMAIL" id="EMAIL2"  name="EMAIL" class="form-control" placeholder="E-mail" onblur="verifie_mail1()">

      <div  id="erEMAIL" class="help text-danger"></div>
      <div  id="erEMAIL2" class="help text-danger"></div>
    </div>

           <input type="hidden" id="valide_email1" > 

                    <div class="col-md-6">     
                      <label for="PASSWORD1" style="font-weight: 900; color:#454545">Mot de passe<font color="red">*</font></label>
                      <input type="text" name="PASSWORD1" id="PASSWORD1"
                      class="form-control"  >
                      <div class="text-danger" id="erPWD"></div>
                    </div>

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

$('#erPROFIL_ID').text('');
var PROFIL_ID = $('#PROFIL_ID').val();
if (PROFIL_ID == "") {

  $('#erPROFIL_ID').text('Ce champs est obligatoire');
$("#PROFIL_ID").css("border", "1px solid red");

  $("#PROFIL_ID").focus();
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
  url : "<?=base_url('/utilisateurs/Utilisateurs/verify_email/')?>", 
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


   <script type="text/javascript">
function verifie_mail1() {
    const emailField = document.getElementById("EMAIL");
    const email = emailField.value.trim();
    const err = document.getElementById("erEMAIL");

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



function validatePhoneNumber2(input) {
              const value = input.value.replace(/\D/g, ''); // Supprime tous les caractères non numériques
              // alert(value)
              input.value = value; // Met à jour l'input sans les lettres ou symboles

              const errorSpan = document.getElementById("erTEL1");
              $('#valide_phone1').val(1);

              if (value.length < 8 || value.length > 12) {
                  $('#valide_phone1').val(0); // Valide
                  errorSpan.textContent = "Numéro de téléphone invalide.";
              } else {
                  errorSpan.textContent = "";
                  $('#valide_phone1').val(1); // Valide
                  // NUM_TEL_PROP2
              }
          }





