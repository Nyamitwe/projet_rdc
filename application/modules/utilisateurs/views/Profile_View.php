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
                  <i class="fa fa-user" aria-hidden="true"></i> Modier le mot de passe
                </h2>
              </div>
              <div class="col-md-3">
              </div>
              <div class="col-md-3">

                
                <div class="btn-group">
                 <!--  <a href="<?= base_url('utilisateurs/Employe')?>" class="btn btn-success">
                      <i style="color: white" class="fa fa-bars" aria-hidden="true"></i>
                      <label idC"tasks_number"></label> Employés
                    </a> -->

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




              <!-- <div class="col-md-2"></div> -->

            </div>
            <div class="full price_table padding_infor_info">
              <form method="POST" id="myformcompt"  enctype="multipart/form-data" action="<?=base_url().'utilisateurs/Profile/save'?>">
                <!-- <div class="row mb-4"> -->
                  <div class="row mb-12">
                    <div class="row">

                      <div class="col-md-6">     
                        <label for="PASSWORD1" style="font-weight: 900; color:#454545">Mot de passe<font color="red">*</font></label>
                        <input type="text" name="PASSWORD1" id="PASSWORD1" class="form-control" oninput="validatePassword()">
                        <div class="text-danger mt-1" id="erPWD"></div>
                        <input type="hidden" id="valide_pwd1" value="0">
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
                      <div class="text-danger" id="enregistrement"></div>
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

<script type="text/javascript">
function verify2() {

  var pwd1 = $('#PASSWORD1').val();
  var pwd2 = $('#PASSWORD2').val();
  var statut = true;

$("#PASSWORD1").css("border", "1px solid green");
$("#PASSWORD2").css("border", "1px solid green");
  
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

$('#loading_spinner2').hide();
if (statut==true)
{
  myformcompt.submit();
  $('#btsave').attr("disabled", true);
$('#loading_spinner2').show();
}
}

</script>






