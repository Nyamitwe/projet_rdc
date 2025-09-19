<!DOCTYPE html>
<html lang="en">
<head>
  <?php //include VIEWPATH.'includes_ep/Autre_header.php'; ?>
      <?php include VIEWPATH.'includes/header.php'; ?>
</head>
<body class="inner_page login"> 
  <div class="full_container">
    <div class="container">
      <div class="center verticle_center full_height">
        <div class="login_section">
          <div class="logo_login">
            <div class="center">
              <img width="100" src="<?php echo base_url() ?>template/images/DTF_light_logo.png" alt="#" />
            </div>
          </div>
          <div class="login_form">

            <h4 class="text-center">Se connecter</h4><br>
            <?= $this->session->flashdata('message') ?>


            <br>
            <div id="message_login"></div>
            <form action="<?= base_url('Login/relais') ?>" method="POST" id="Myform">

              <fieldset>

                <div class="form-group col-lg-12">
                  <label style="font-weight: 900; color:#454545">Nom d'utilisateur</label>
                  <input value="<?= $login; ?>" type="text" name="inputUsername" id="inputUsername"  class="form-control" placeholder="Adresse e-mail / Nom d'utilisateur">
                </div>

                <div class="form-group col-lg-12">
                  <label style="font-weight: 900; color:#454545">Mot de passe</label>
                  <input value="<?= $pass; ?>" type="password" name="inputPassword" placeholder="Mot de passe " class="form-control" required id="inputPassword">

                </div>

                <div class="form-group col-lg-12">
                  <div class="row">

                    <div class="col-md-6">
                      <input type="checkbox" onclick="myFunction()"> Afficher le mot de passe
                    </div>

                    <div class="col-md-6">
                      <a class="#" href="<?= base_url('Modif_Pwd') ?>">Mot de passe oublié ?</a>
                    </div>

                  </div>
                </div>
                <center>
                  <button class="main_bt" type="submit" id="sign">Se connecter</button>
                </center>
              </fieldset>
            </form>  


          </div>

          <br>

          <center><a style="color: #17a2b8" href="<?= base_url('New_requerant') ?>" ><b>Vous n'avez pas de compte?<br> Inscrivez-vous ici!</b></a></center>


          <br>
        </div>
      </div>
    </div>
  </div>

  <?php include VIEWPATH.'includes/scripts_js.php'; ?>
</body>


<script type="text/javascript">

  $(document).ready(function(){ 
    $('#message').delay(5000).hide('slow');
  });
</script>
<script>
  function myFunction() {
    var x = document.getElementById("inputPassword");
    if (x.type === "password") {
      x.type = "text";
    } else {
      x.type = "password";
    }
  }
</script>
<script type="text/javascript">

  $(document).ready(function(){


    $("#Myform i").click(function(event) {
      /* Act on the event */
      const target = $(this).attr('class');
//alert(target);
if(target=='fa fa-eye'){
  $(this).removeClass('fa fa-eye');
  $(this).addClass('fa fa-eye-slash');
  $('#inputPassword').attr('type','text');

}else{
  $(this).removeClass('fa fa-eye-slash');
  $(this).addClass('fa fa-eye');
  $('#inputPassword').attr('type','password');

}

});

  });
</script>

<script>
  function login()
  {
    $('#sign').text('Connexion'); 
    $('#sign').attr('disabled',true);
    $('#message_login').html('')

    var formData = $('#Myform').serialize();

    alert(formData);

    $.ajax({
      url : "<?=base_url()?>index.php/Login/do_login",
      type: "POST",
      data: formData,
      dataType: "JSON",
      success: function(data)
      {
        if (data.status) {
          $('#message_login').html("<center><span class='text text-success'>"+data.message+"</span></center>");
          $('#sign').attr('disabled',true);
          setTimeout(function(){ 
            $('#Myform').submit();

          }, 2000);

        }else{
          $('#message_login').html("<span class='text text-danger'>"+data.message+"</span>");
        }
        $('#sign').text('Connexion'); 
        $('#sign').attr('disabled',false); 
      }

    });
  }


</script>


</html>