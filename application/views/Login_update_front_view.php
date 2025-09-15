<!DOCTYPE html>
<html lang="en">
<head>
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
                     
                      <h4 class="text-center">Property Management System</h4><br>
                      <h1 class="text-center">Recuperer mot de passe</h1><br>
                <?= $this->session->flashdata('message') ?>

                <?= $message;  ?>
                      <br>
                        <div id="message_login"></div>
                <form action="<?= base_url('Login/get_password_front') ?>" method="POST" id="Myform">

                  <fieldset>
                    <div class="form-group col-lg-12">
                      <label style="font-weight: 900; color:#454545">Nom d'utilisateur</label>
                      <input type="text" name="inputUsername" id="inputUsername"  class="form-control" placeholder="Adresse e-mail">
                      <?php echo form_error('inputUsername', '<div class="text-danger">', '</div>'); ?>
                    </div>



                  <center>
                    <button class="main_bt" type="submit" id="sign">Envoyer</button>
                  </center>
                </fieldset>
                    </form>  


                  </div>

                    <br>
                  
                                       
                   

                    <center><a style="color: #17a2b8" href="<?= base_url() ?>" ><b> << Retour à la page d'accueil</b></a></center>
                     
                    
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






</html>