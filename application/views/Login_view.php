<!DOCTYPE html>
<html lang="en">
<head>
  <?php //include VIEWPATH.'includes_ep/Autre_header.php'; ?>
  <style type="text/css">
  .main_bt2 {
    background-color: transparent;
    color: #51878e;
    border: 2px solid #51878e;
    padding: 10px 20px;
    border-radius: 5px;
    font-weight: bold;
    transition: all 0.3s ease;
    cursor: pointer;
}

.main_bt2:hover {
    background-color: #51878e;
    color: #fff;
}
</style>

      <?php include VIEWPATH.'includes/header.php'; ?>
</head>
<body class="inner_page login"> 
  <div class="full_container">
    <div class="container">
      <div class="center verticle_center full_height">
        <div class="login_section">
          <br>
          <div class="logo_login_">
            <div class="center">
              <!-- <img width="100" src="<?php echo base_url() ?>template/images/DTF_light_logo.png" alt="#" /> -->
              <button class="main_bt" style="background: #51878e">StarAfrica-Group</button></span>
            </div>
          </div>
          <div class="login_form">

            <!-- <h4 class="text-center">Se connecter</h4><br> -->
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

                    <div class="col-md-12">
                      <input type="checkbox" onclick="myFunction()"> Afficher le mot de passe
                    </div><br>
                    <div class="col-md-12">,</div>

                    <div class="col-md-12">
                      <a class="#" href="<?= base_url('Modif_Pwd') ?>">Mot de passe oublié ?</a>
                    </div>

                  </div>
                </div>
                <center>
                  <button class="main_bt2" type="submit" id="sign">Se connecter</button>
                </center>
              </fieldset> 
            </form>  


          </div>

          <br>

          <!-- <center><a style="color: #17a2b8" href="<?= base_url('New_requerant') ?>" ><b>Vous n'avez pas de compte?<br> Inscrivez-vous ici!</b></a></center> -->


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