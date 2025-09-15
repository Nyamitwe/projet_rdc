<!DOCTYPE html>
<html lang="en"> 
<head>
  <?php include VIEWPATH.'includes_ep/Autre_header2.php'; ?>
  <?php include VIEWPATH.'includes/header.php'; ?>

  <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>template/datepicker/css/daterangepicker.css">
  <link href="<?php echo base_url() ?>template/datepicker/css/master.css" rel="stylesheet">
  <link href="<?php echo base_url() ?>template/datepicker/css/datepicker.css" rel="stylesheet">

  <link href="<?php echo base_url() ?>template/datepicker/css/jquery.datetimepicker.min.css" rel="stylesheet">

</head>
<body class="inner_page login"> 
  <div class="full_container">
    <div class="container">
      <div class="center verticle_center">
        <div class="login_section">
          <div class="logo_login">
            <div class="center">
              <img width="100" src="<?php echo base_url() ?>template/images/DTF_light_logo.png" alt="#" />
            </div>
          </div>
          <div class="login_form">

            <h4 class="text-center">APPLICATION</h4><br>
            <?= $this->session->flashdata('message') ?>
            <form method="POST" id="myformcompt"  enctype="multipart/form-data" action="<?=base_url().'New_Requerant/save'?>">
              <fieldset style="display: block;" id="div_comp">
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
                        <option value=""><?=lang('selectionner')?></option>
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
                    <label style="font-weight: 900; color:#454545">Téléphone<span style="color:red;">*</span></label>
                      <input type="number" maxlength="8" minlength="8" class="form-control" placeholder="Tél" name="TEL1" id="TEL1">
                      <font color="red" id="erTEL1"  class="help"><?php echo form_error('TEL1'); ?></font>
                    </div>

                    <div class="form-group col-lg-6">
                      <label style="font-weight: 900; color:#454545">E-mail<span class="text-danger">*</span></label>
                      <input type="email" id="EMAIL" id="EMAIL2"  name="EMAIL" class="form-control" placeholder="E-mail">
                      <div  id="erEMAIL" class="help text-danger"></div>
                      <div  id="erEMAIL2" class="help text-danger"></div>
                      <?php echo form_error('EMAIL', '<div class="text-danger">', '</div>'); ?>
                    </div>

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
                      <button type="button" style="margin-top: 20px;float: right;border:1px solid #020f12;" class="main_bt" onclick="verify2()">Enregistrer&nbsp;<span id="loading_spinner2" style="display: none; text-align:center;font-size: 12px">
                        <i class="fa fa-spinner fa-spin fa-2x text-primary"></i>
                      </span> 
                    </button>
                  </div>

                </fieldset>


              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
<!-- jQuery -->
<script src="js/jquery.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<!-- wow animation -->
<script src="js/animate.js"></script>
<!-- select country -->
<script src="js/bootstrap-select.js"></script>
<!-- nice scrollbar -->
<script src="js/perfect-scrollbar.min.js"></script>
<script>
 var ps = new PerfectScrollbar('#sidebar');
</script>
<!-- custom js -->
<script src="js/custom.js"></script>
</body>
<script type="text/javascript">
  function get_form_moral(argument) {
   document.getElementById("hide").style.display="none";
   document.getElementById("hide2").style.display="none";
     var PROFIL1=$("#PROFIL1").val();
       // $('#hide_coproprietaires').hide();
     if(PROFIL1==10){
       // $('#hide_coproprietaires').show();
     }
  // alert(nationalit);
  if(PROFIL1==3){
   document.getElementById("physique_nom").style.display="block";
   document.getElementById("hide").style.display="block";
   document.getElementById("physique_prenom").style.display="block";
   document.getElementById("physique_sexe").style.display="block";
   document.getElementById("physique_date_naissance").style.display="block";
   document.getElementById("physique_nom_prenom_mere").style.display="block";
   document.getElementById("physique_nom_prenom_pere").style.display="block";
   document.getElementById("moral_PRENOM").style.display="none";
   document.getElementById("moral_NOM").style.display="none";

  }else{
   document.getElementById("hide2").style.display="block";
   document.getElementById("physique_nom").style.display="none";
   document.getElementById("physique_prenom").style.display="none";
   document.getElementById("physique_sexe").style.display="none";
   document.getElementById("physique_date_naissance").style.display="none";
   document.getElementById("physique_nom_prenom_mere").style.display="none";
   document.getElementById("physique_nom_prenom_pere").style.display="none";
   document.getElementById("moral_PRENOM").style.display="block";
   document.getElementById("moral_NOM").style.display="block";
  }
   
  }
</script>

<script>
 function affiche_loca(){
  var nationalit=$("#nationalite_id").val();
  // alert(nationalit);
 
 }
</script>      
<script type="text/javascript">
 $(document).ready(function() {

  $(function() {
    $('input[name="DATE_NAISSANCE"]').daterangepicker({
      singleDatePicker: true,
      "autoApply":true,
      autoUpdateInput: false,
      showDropdowns: true,
      maxYear: 2022,
      minYear: 1901,

    });
  });
});

</script>

<script type="text/javascript">
 // $('#inscr').on('click', function(ev) {
 //         document.getElementById('div_comp').style.display="block";
 //       });
     </script>


    <script type="text/javascript">
     function verify1()
     {

       var input_tel=document.getElementById('TEL1');
       var input_EMAIL=document.getElementById('EMAIL');

       var numberReg =  /^[+0-9 ]+$/;
       var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
       var Email = $('#EMAIL').val();

       var tell1 = $('#TEL1').val();
       var tell2 = $('#EMAIL').val();

       var pwd1 = $('#PASSWORD1').val();
       var pwd2 = $('#PASSWORD2').val();
       $("#EMAIL").css("border", "1px solid green");
       $("#TEL1").css("border", "1px solid green");
       $("#EMAIL").css("border", "1px solid green");
       $("#PASSWORD1").css("border", "1px solid green");
       $("#PASSWORD2").css("border", "1px solid green");

        $('#erEMAIL').html("");
       var statut = true;
       if (Email=="") {
        statut = false;
        $("#EMAIL").css("border", "1px solid red");
        $('#erEMAIL').html("Ce champ est obligatoire");
       }

        $('#erPROFIL').html("");
       $("#PROFIL1").css("border", "1px solid green");
       if(($("#PROFIL1").val())=='')
       {  
        $('#erPROFIL').html('Nom obligatoire');
       $("#PROFIL1").css("border", "1px solid red");
        $("#PROFIL1").focus();
        statut = false;
        console.log(statut)
      }

      if(($("#PROFIL1").val())!='' && $("#PROFIL1").val()==3)
       { 
        $('#erNOM').text('');
       $("#NOM").css("border", "1px solid green"); 
      if(($("#NOM").val())=='')
      {
        $('#erNOM').text('Nom obligatoire');
        $("#NOM").focus();
       $("#NOM").css("border", "1px solid red");
        statut = false;
        console.log(statut)
      }
       $("#PRENOM").css("border", "1px solid green");
        $('#erPRENOM').text('');
      if(($("#PRENOM").val())=='')
      {
       $("#PRENOM").css("border", "1px solid red");
        $('#erPRENOM').text('Prénom obligatoire');
        $("#PRENOM").focus();
        statut = false;
        console.log(statut)
      }
       $("#SEXE_ID").css("border", "1px solid green");
        $('#erSEXE_ID').text('');
        if ($('#SEXE_ID').val() == "") {

       $("#SEXE_ID").css("border", "1px solid red");
    $('#erSEXE_ID').text('Le genre est obligatoire');
    $("#SEXE_ID").focus();
    statut = false;
    console.log(statut)
  } 

        $('#erNOM_PRENOM_PERE').text('');
       $("#NOM_PRENOM_PERE").css("border", "1px solid green");
  if ($('#NOM_PRENOM_PERE').val() == "") {
       $("#NOM_PRENOM_PERE").css("border", "1px solid red");
    $('#erNOM_PRENOM_PERE').text('Le champ est obligatoire');

    $("#NOM_PRENOM_PERE").focus();
    statut = false;
    console.log(statut)
  } 
        $('#erNOM_PRENOM_MERE').text('');
       $("#NOM_PRENOM_MERE").css("border", "1px solid green");
  if ($('#NOM_PRENOM_MERE').val() == "") {

       $("#NOM_PRENOM_MERE").css("border", "1px solid red");
    $('#erNOM_PRENOM_MERE').text('Le champ est obligatoire');

    $("#NOM_PRENOM_MERE").focus();
    statut = false;
    console.log(statut)
  } 
}

     if(($("#PROFIL1").val())!='' && $("#PROFIL1").val()==2)
       { 
        $('#erPRENOM').text('');
       $("#PRENOM").css("border", "1px solid green");
       if ($('#PRENOM').val() == "") {

       $("#PRENOM").css("border", "1px solid red");
    $('#erPRENOM').text('Le champ est obligatoire');

    $("#PRENOM").focus();
    statut = false;
    console.log(statut)
  } 

       $("#NOM").css("border", "1px solid green");
        $('#erNOM').text('');
   if ($('#NOM').val() == "") {

       $("#NOM").css("border", "1px solid red");
    $('#erNOM').text('Le champ est obligatoire');

    $("#NOM").focus();
    statut = false;
    console.log(statut)
  } 

 }

        $("#NIF").css("border", "1px solid green");
        $('#errNIF').text('');
   if ($('#NIF').val() == "") {

       $("#NIF").css("border", "1px solid red");
    $('#errNIF').text('Le champ est obligatoire');
    statut = false;

  } 

       $("#RC").css("border", "1px solid green");
        $('#errRC').text('');
   if ($('#RC').val() == "") {
    $('#errRC').text('Le champ est obligatoire');
       $("#RC").css("border", "1px solid red");
    statut = false;
  } 


       $("#TEL1").css("border", "1px solid green");
        $('#erTEL1').text('');
      if(($("#TEL1").val())=='')
      {
        $('#erTEL1').text('Téléphone obligatoire');
       $("#TEL1").css("border", "1px solid red");
        $("#TEL1").focus();
        statut = false;
        console.log(statut)
      }


      var input = document.getElementById('TEL1');
  var value = input.value.toString(); // Convert the input value to a string

  if (value.length === 8) {
       $("#TEL1").css("border", "1px solid green");
        $('#erTEL1').text('');
  } else {
    $('#erTEL1').text('Téléphone Invalide');
    $("#TEL1").focus();
       $("#TEL1").css("border", "1px solid red");
    statut = false;
    console.log(statut)
  }

  var input = document.getElementById('EMAIL');
  var value2 = input.value.toString(); // Convert the input value to a string
  if(($("#EMAIL").val())!='')
  {
    if (value2.length === 8) {
        $('#erEMAIL').text('');
       $("#EMAIL").css("border", "1px solid green");
    // alert('Input has a length of 8.');
  } else {
    $('#erEMAIL').text('Téléphone Invalide');
    $("#EMAIL").focus();
       $("#EMAIL").css("border", "1px solid red");
    statut = false;
    console.log(statut)
  }
}


  
       $("#CNI").css("border", "1px solid green");
        $('#erCNI').text('');
  if(($("#CNI").val())=='')
  {
    $('#erCNI').text('CNI obligatoire');
    $("#CNI").focus();
       $("#CNI").css("border", "1px solid red");
    statut = false;
    console.log(statut)
  }

        $('#errDATE_DELIVRANCE').text('');
       $("#DATE_DELIVRANCE").css("border", "1px solid green");
  if ($('#DATE_DELIVRANCE').val() == "") {

       $("#DATE_DELIVRANCE").css("border", "1px solid red");
    $('#errDATE_DELIVRANCE').text('Le champ est obligatoire');

    $("#DATE_DELIVRANCE").focus();
    statut = false;
    console.log(statut)
  } 

        $('#errLIEU_DELIVRANCE').text('');
       $("#LIEU_DELIVRANCE").css("border", "1px solid green");
  if ($('#LIEU_DELIVRANCE').val() == "") {

       $("#LIEU_DELIVRANCE").css("border", "1px solid red");
    $('#errLIEU_DELIVRANCE').text('Le champ est obligatoire');

    $("#LIEU_DELIVRANCE").focus();
    statut = false;
    console.log(statut)
  } 


  var input = document.getElementById('CNI_IMAGE_PROP');
  
        $('#errCNI_IMAGE_PROP').text('');
       $("#CNI_IMAGE_PROP").css("border", "1px solid green");
  if (input.value === '') {
   $('#errCNI_IMAGE_PROP').text('Le champ est obligatoire');
       $("#CNI_IMAGE_PROP").css("border", "1px solid red");
   $("#CNI_IMAGE_PROP").focus();
   statut = false;
   console.log(statut)
 } 

 if (Email != '') {
        $('#erEMAIL').text('');
       $("#EMAIL").css("border", "1px solid green");
  if(!emailReg.test(Email))
  {
       $("#EMAIL").css("border", "1px solid red");
    $('#erEMAIL').text('Email invalide');

    $("#EMAIL").focus();
    statut = false;
    console.log(statut)
  }
}


document.getElementById('hide_oui_non').style.display="block";
// document.getElementById('hide_coproprietaires').style.display="block";
// alert(statut)
if (statut==true)
{
  exist_mail()
}
}

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

$('#loading_spinner2').hide();
if (statut==true)
{
  exist_mail()
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
  url : "<?=base_url()?>/New_Requerant/verify_email/", 
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
 $('#loading_spinner2').show();
 myformcompt.submit();
 }else if(data==1){

    $("#erEMAIL").html("E-mail existe déjà.");
    $("#EMAIL").css("border", "1px solid red");
$('#loading_spinner2').hide();
 }
 
   },
    complete: function() {
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
