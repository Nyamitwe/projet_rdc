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

      <h4 class="text-center">Property Management System - Connexion</h4><br>

      <h5 class="text-center">Modification du mot de passe</h5><br>
      <?= $this->session->flashdata('message') ?>

      <br>
      <div id="message_login"></div>
      <form action="<?= base_url(''.$url.'') ?>" method="POST" id="Myform">

        <fieldset>

          <div class="row">
            <input type="hidden" name="stattut" id="statut" value="<?=$statut;?>">
            
            
            <div class="form-group col-lg-12" id="hide_div" style="display: block;">
              <label style="font-weight: 900; color:#454545">Veuillez indiquer le compte souhaité pour la recuperation de vos identifiant :</label>
              <select class="form-control"  name="type_user" id="type_user">
               <option value="" selected>Sélectionner</option>
               <?php foreach($types_users as $types_user) { 
                if ($types_user['id']==set_value('type_user')) { 
                  echo "<option value='".$types_user['id']."' selected>".$types_user['name']."</option>";
                }  else{
                  echo "<option value='".$types_user['id']."' >".$types_user['name']."</option>"; 
                } }?>                                                              
              </select>
              <?php echo form_error('type_user', '<div class="text-danger">', '</div>'); ?>
            </div>

            <div class="form-group col-lg-12">
              <label style="font-weight: 900; color:#454545">Email de récupération</label>
              <input value="<?= set_value('inputUsername') ?>" type="text" name="inputUsername" id="inputUsername"  class="form-control" placeholder="Adresse e-mail / Nom d'utilisateur">
              <?php echo form_error('inputUsername', '<div class="text-danger">', '</div>'); ?>  
            </div>
          </div>



         <center>
          <button class="main_bt" type="submit" id="sign">Vérifier</button>
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

    var statut=$("#statut").val();

    

  });
</script>



</html>