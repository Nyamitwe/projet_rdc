  <!DOCTYPE html>
  <html lang="en">
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
              <br>
              <br>
              <!-- row -->
              <div class="row column1">
                <div class="col-md-12">
                  <div class="white_shd full margin_bottom_30">
                    <div class="full graph_head">
                      <a href="<?=base_url('/Utilisateurs/')?>" class="btn btn-dark" style="float: lefet;">Liste</a>
                      <br><br>
                          <a href="<?=base_url('/New_Requerant/Modifier')?>" class="btn btn-primary" style="float: right;">Modifier</a>
                              <br><br>
                     <?=$this->session->flashdata('message')?> 
                    </div> 

                    <div class="full price_table padding_infor_info">
                      <form method="POST" id="myformcompt"  enctype="multipart/form-data" action="<?=base_url().'New_Requerant/save'?>">

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



