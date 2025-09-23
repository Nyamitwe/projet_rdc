<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion à StarAfrica-Group</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/fontawesome.min.css') ?>">
    <style>
   body {
    /*background-color: #007bff;  Bleu vif */
    background-color: blue; 

    font-family: 'Segoe UI', sans-serif;
    margin: 0;
    padding: 0;
}

.login-container {
    max-width: 400px;
    margin: 80px auto;
    padding: 30px;
    background-color: #fff; /* Fond blanc du formulaire */
    border-radius: 8px;
    box-shadow: 0 0 15px rgba(0,0,0,0.2);
}

.login-logo {
    text-align: center;
    margin-bottom: 20px;
}

.login-logo h1 {
    font-size: 32px;
    margin: 0;
    color: #fff;
}

.login-logo span {
    font-size: 14px;
    color: #fff;
}

.form-check-label {
    font-size: 14px;
}

.forgot-link {
    display: block;
    text-align: right;
    font-size: 13px;
    margin-top: 5px;
}

.btn-login {
    background-color: #28a745;
    color: white;
    width: 100%;
    padding: 10px;
    border: none;
    border-radius: 4px;
}

    </style>
      <?php include VIEWPATH.'includes/header.php'; ?>

</head>
<body>

<div class="login-container" style="">
    <div class="login-logo ">
        <!-- <h1>ST</h1> -->
        <!-- <div class="center">
              <img width="100" src="<?php echo base_url() ?>template/images/DTF_light_logo.png" alt="#" />
            </div> -->
        <span><button class="main_bt" style="background: black">StarAfrica-Group</button></span><br><br><br>
    </div>

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

<script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
<script>
    $('#showPassword').on('change', function() {
        const type = $(this).is(':checked') ? 'text' : 'password';
        $('#password').attr('type', type);
    });
</script>

</body>
</html>
