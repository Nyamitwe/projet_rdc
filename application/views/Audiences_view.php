<!DOCTYPE html>
<html lang="en">
<head>
<?php include VIEWPATH.'includes/header.php'; ?>
 <style>
        .inline-row {
            display: flex;
        }
    </style>

<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>template/datepicker/css/daterangepicker.css">
<link href="<?php echo base_url() ?>template/datepicker/css/master.css" rel="stylesheet">
<link href="<?php echo base_url() ?>template/datepicker/css/datepicker.css" rel="stylesheet">

<link href="<?php echo base_url() ?>template/datepicker/css/jquery.datetimepicker.min.css" rel="stylesheet">
   <link rel="icon" type="image/x-icon" href="<?php echo base_url() ?>template/assets_new/img/favicon-16x16.png">


<link rel="shortcut icon" href="<?php echo base_url() ?>template/assets_new/img/favicon-16x16.png" type="image/x-icon">

    <link rel="icon" href="<?php echo base_url() ?>template/assets_new/img/favicon-16x16.png" type="image/x-icon">

    <link rel="stylesheet" href="<?php echo base_url() ?>template/assets_new/css/maicons.css">

    <link rel="stylesheet" href="<?php echo base_url() ?>template/assets_new/css/bootstrap.css">

    <link rel="stylesheet" href="<?php echo base_url() ?>template/assets_new/vendor/animate/animate.css">

    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>template/assets_new/css/icofont.css" />

    <link href='https://fonts.googleapis.com/css?family=Barlow Condensed' rel='stylesheet'>

    <link href='https://fonts.googleapis.com/css?family=Rubik' rel='stylesheet'>

    <link rel="stylesheet" href="<?php echo base_url() ?>template/assets_new/css/pmstheme.css">
</head>
<body class="inner_page login">

	 <header >
        <!-- ======= Top Bar start ======= -->
        <section style="background-image: url(<?php echo base_url() ?>template/assets_new/img/bg_pms_header.png)" id="topbar" class="d-flex align-items-center">
            <div class="container d-flex justify-content-center justify-content-md-between">
                <div class="contact-info d-none d-sm-flex align-items-center">
                    <i class="fa fa-envelope d-flex align-items-center"><a class="topbar_icon" href="mailto:contact@pms.gov.bi">contact@pms.gov.bi</a></i>
                    <i class="fa fa-phone"><a class="topbar_icon" href="tel:+25722248153">+257 22 24 81 53 - Bujumbura,</a><a class="topbar_icon" href="tel:+25722402308">+257 22 40 23 08 - Gitega,</a><a class="topbar_icon" href="tel:+25722302385">+257 22 30 23 85 - Ngozi</a></i>
                </div>
                <div class="social-links d-flex align-items-center">
                    <a href=""><i class="fa fa-facebook d-flex align-items-center"></i></a>
                    <a href=""><i class="fa fa-twitter d-flex align-items-center"></i></a>
                </div>
            </div>
        </section>
        <!-- ======= Top Bar end ======= -->


        <!-- Navbar start -->
        <nav class="navbar navbar-expand-lg navbar-light shadow sticky" data-offset="0">
            <div class="container">
                <a href="#" class="navbar-brand"><img alt="" width='200' src='<?php echo base_url() ?>template/assets_new/img/pms_logo_2.svg'></a>

                <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="navbar-collapse collapse" id="navbarContent">

                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item">
                            <a class="nav-link active" href="<?=base_url('Home')?>">Accueil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?=base_url('Home/FAQs')?>">FAQs</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="<?=base_url('Publication_Front_end/')?>">Publications</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="<?=base_url('Contact/')?>">Contacts</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="<?=base_url('New_Requerant/')?>">Compte Acheteur</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="<?=base_url('Audiences/')?>">Demande Audience</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="<?=base_url('Rendez_vous/')?>">Demande Rendez-vous</a>
                        </li>
                    </ul>




                    <ul class="nav navbar-nav navbar-right">

                        <li class="nav-item">
                            <a class="mr-4" style="text-decoration: none" href="<?= base_url('Login') ?>"><button class="btn mybtn btn-split">Se connecter<div class="fab"><i class="fa fa-sign-in"></i></div></button></a>
                        </li>

                        <li class="nav-item">
                            <div class="row d-inline-flex p-5">
                                <div class="col-4">
                                    <a class="font-weight-bold" href="">FR</a>
                                </div>
                                <div class="col-4">
                                    <a href="">EN</a>
                                </div>
                            </div>
                        </li>


                    </ul>

                </div>

            </div>
        </nav>
        <!-- Navbar end -->


    </header> <!-- Header end-->

<br><br><br><br>
<div class="full_container">
<div class="container">
<div class="center verticle_center full_height">
<div class="login_section">
<div class="logo_login">
<div class="center">
<img width="300" src="<?php echo base_url() ?>template/images/DTF_light_logo.png" alt="#" />
</div>
</div>
<div class="login_form">

<h4 class="text-center">Property Management System</h4><br>
<?= $this->session->flashdata('message') ?>


<form method="POST" id="myformcompt"  enctype="multipart/form-data" action="<?=base_url().'Audiences/save_data'?>">
	<?php //echo validation_errors()?>

	<fieldset style="display: block;" id="div_comp0">
		<div class="row">
			<div class="col-md-12">
				<div class="form-row">

					<div class="form-group col-lg-6">
						<label style="font-weight: 900; color:#454545">Nom et Prénom<span style="color:red;">*</span></label>
						<input type="text" class="form-control" placeholder="Nom et prénom" name="NOM" oninput="validateInput(this)" id="NOM" value="<?=set_value('NOM')?>">

						<font color="red" id="erNOM"><?php echo form_error('NOM'); ?></font>
					</div>
					
					<div class="form-group col-lg-6">
						<label style="font-weight: 900; color:#454545">Fonction<span style="color:red;">*</span></label>
							<select required class="form-control" name="ID_PROFESSION" id="ID_PROFESSION">
							<option value="">Sélectionner</option>
							<?php foreach ($professions as $value) 
		                    {
		                     if ($value['ID_PROFESSION']==set_value('ID_PROFESSION')) 
		                      {?>
		                       <option value="<?=$value['ID_PROFESSION']?>" selected=''><?=$value['DESCR_PROFESSION']?></option>
		                       <?php 
		                     }else{?>
		                      <option value="<?=$value['ID_PROFESSION']?>"><?=$value['DESCR_PROFESSION']?></option>
		                      <?php
		                    }
		                  }
		                  ?> 
						</select>
						<font color="red" id="erFONCTION_ID" class="help"><?php echo form_error('FONCTION_ID'); ?></font>
					</div>
					<div class="form-group col-lg-6">
						<label style="font-weight: 900; color:#454545">Adresse Physique<span style="color:red;">*</span></label>
						<input type="text"class="form-control" placeholder="Adresse Physique" name="AD_PHYSIQUE" id="AD_PHYSIQUE" value="<?=set_value('AD_PHYSIQUE')?>">
						<font color="red" id="erAD_PHYSIQUE"  class="help"><?php echo form_error('AD_PHYSIQUE'); ?></font>
					</div>
					<div class="form-group col-lg-6">
						<label style="font-weight: 900; color:#454545">Télephone <span style="color:red;">*</span></label>
						<input type="text" class="form-control" placeholder="Tél" name="TEL2" id="TEL2" value="<?=set_value('TEL2')?>" maxlength="11">

						<font color="red" id="erTELe"  class="help"></font><?php echo form_error('TEL2'); ?></font>
					</div>
					<div class="form-group col-lg-6">
						<label style="font-weight: 900; color:#454545">CNI <span style="color:red;">*</span></label>
						<input type="text" class="form-control" oninput="validateValues(this)" placeholder="CNI" name="CNI" id="CNI" value="<?=set_value('CNI')?>">

						<font color="red" id="erCENI"  class="help"></font><?php echo form_error('CNI'); ?></font>
					</div>
					<div class="form-group col-lg-6">
						<label style="font-weight: 900; color:#454545">E-mail <span style="color:red;">*</span></label>
						<input type="email" id="EMAIL" name="EMAIL" class="form-control" placeholder="E-mail" value="<?=set_value('EMAIL')?>">
						<font color="red" id="erEMAIL" class="help"></font><?php echo form_error('EMAIL'); ?></font>
					</div>
					<div class="form-group col-lg-6">
						<label style="font-weight: 900; color:#454545">Type demandeur<span style="color:red;">*</span></label>
							<select required class="form-control" name="TYPE_DEMANDEUR" id="TYPE_DEMANDEUR">
							<option value="">Sélectionner</option>
							<?php foreach ($types_visiteur as $value) 
		                    {
		                     if ($value['ID_TYPE_VISITE']==set_value('TYPE_DEMANDEUR')) 
		                      {?>
		                       <option value="<?=$value['ID_TYPE_VISITE']?>" selected=''><?=$value['DESC_TYPE_VISITE']?></option>
		                       <?php 
		                     }else{?>
		                      <option value="<?=$value['ID_TYPE_VISITE']?>"><?=$value['DESC_TYPE_VISITE']?></option>
		                      <?php
		                    }
		                  }
		                  ?> 
						</select>

						<font color="red" id="erTYPE_DEMANDEUR" class="help"><?php echo form_error('TYPE_DEMANDEUR'); ?></font>
					</div>

				<div class="form-group col-lg-6">
				    <label style="font-weight: 900; color:#454545">Objet de la visite <span style="color:red;">*</span></label>
				    <select required class="form-control" name="OBJET" id="OBJET">
							<option value="">Sélectionner</option>							
							<?php foreach ($types_demandeur as $value) 
		                    {
		                     if ($value['ID_TYPE_DEMANDE_AUDIENCE']==set_value('OBJET')) 
		                      {?>
		                       <option value="<?=$value['ID_TYPE_DEMANDE_AUDIENCE']?>" selected=''><?=$value['DESC_TYPE_DEMANDE_AUDIENCE']?></option>
		                       <?php 
		                     }else{?>
		                      <option value="<?=$value['ID_TYPE_DEMANDE_AUDIENCE']?>"><?=$value['DESC_TYPE_DEMANDE_AUDIENCE']?></option>
		                      <?php
		                    }
		                  }
		                  ?> 
						</select>
				    <font color="red" id="erOBJET" class="help"><?php echo form_error('OBJET'); ?></font>
				</div>
			

				<div class="form-group col-lg-6" id="motifUrgenceDiv" <?=$urgences?>>
					<label style="font-weight: 900; color:#454545">Motif d'urgence</label>
					<textarea class="form-control" placeholder="Motif d'urgence" name="MOTIF_URGENCE" id="MOTIF_URGENCE"><?= set_value('MOTIF_URGENCE') ?></textarea>
					<font color="red" id="erMOTIF_URGENCE" class="help"><?php echo form_error('MOTIF_URGENCE'); ?></font>
				</div>


			<!-- 	<div class="form-group col-lg-6">
					<label style="font-weight: 900; color:#454545">Avez-vous un titre de propriété ? <span style="color:red;"> *</span></label>
					<select class="form-control" id="STATUS_TITRE" name="STATUS_TITRE">
						<option value="">Sélectionner</option>
						<option value="1">Oui</option>
						<option value="2">Non</option>
					</select>
					<font color="red" id="erSTATUS_TITRE" class="help"><?php echo form_error('STATUS_TITRE'); ?></font>
				</div> -->
				<div class="form-group col-lg-6">
					<label style="font-weight: 900; color:#454545">Avez-vous un titre de propriété ? <span style="color:red;"> *</span></label>
					<select class="form-control" id="STATUS_TITRE" name="STATUS_TITRE">
						<option value="">Sélectionner</option>
						<option value="1" <?php echo set_select('STATUS_TITRE', '1', $choix == '1'); ?>>Oui</option>
						<option value="2" <?php echo set_select('STATUS_TITRE', '2', $choix == '2'); ?>>Non</option>
					</select>
					<font color="red" id="erSTATUS_TITRE" class="help"><?php echo form_error('STATUS_TITRE'); ?></font>
				</div>
				<div id="champs_titre" <?=$info_titre?> >
					<div class="row">
						<div class="form-group col-md-6">
							<label style="font-weight: 900; color:#454545">Volume</label>
							<input type="text" minlength="8" maxlength="8" class="form-control" placeholder="Volume" name="VOLUME" id="VOLUME" oninput="validateInfoFolio(this)" value="<?=set_value('VOLUME')?>">
							<font color="red" id="erVOLUME" class="help"><?php echo form_error('VOLUME'); ?></font>
						</div>
						<div class="form-group col-md-6">
							<label style="font-weight: 900; color:#454545">Folio</label>
							<input type="text" minlength="8" maxlength="8" class="form-control" placeholder="Folio" name="FOLIO" id="FOLIO" oninput="validateInfoFolio(this)" value="<?=set_value('FOLIO')?>">
							<font color="red" id="erFOLIO" class="help"><?php echo form_error('FOLIO'); ?></font>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-6">
							<label style="font-weight: 900; color:#454545">Numéro de la parcelle</label>
							<input type="text" minlength="8" maxlength="8" class="form-control" placeholder="Numéro parcelle" name="PARCELLE" id="PARCELLE" value="<?=set_value('PARCELLE')?>">
							<font color="red" id="erPARCELLE" class="help"></font><?php echo form_error('PARCELLE'); ?></font>
						</div>
						<!-- <div class="form-group col-md-6">
							<label style="font-weight: 900; color:#454545">PDF du titre de propriété</label>
							<input type="file" class="form-control" placeholder="PDF" name="PDF" id="PDF" value="<?=set_value('PDF')?>" accept=".pdf">
							<font color="red" id="erpdf" class="help"></font>
							<?php echo form_error('pdf'); ?>
						</div> -->
							<div class="form-group col-md-6">
							<label style="font-weight: 900; color:#454545">PDF du titre de propriété</label>
							<input type="file" class="form-control" placeholder="PDF" name="PDF" id="PDF" value="<?= set_value('PDF') ?>" accept=".pdf" onblur="checkFileFormat(this)" required>
							<font color="red" id="erpdf" class="help"></font>
							<?php echo form_error('PDF'); ?>
						</div>
					</div>
				</div>
					<div class="form-group col-lg-6">
						<button type="button" style="margin-top: 20px;float: right;" class="main_bt" onclick="verify2()">Enregistrer</button>
					</div>
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
<script>
    document.getElementById("OBJET").addEventListener("change", function() {
        var selectedValue = this.value;
        var motifUrgenceDiv = document.getElementById("motifUrgenceDiv");

        if (selectedValue === "2") {
            motifUrgenceDiv.style.display = "block";
        } else {
            motifUrgenceDiv.style.display = "none";
        }
    });
</script>
					
<script type="text/javascript">

	function verify2() {

		var statut = true;
		if (statut==true)
		{

			myformcompt.submit();
		}	

	}


</script>
<script>
	document.getElementById('STATUS_TITRE').addEventListener('change', function() {
		var champsTitre = document.getElementById('champs_titre');
		if (this.value === '1') {
			champsTitre.style.display = 'block';
		} else {
			champsTitre.style.display = 'none';
		}
	});
</script>
<script>
// Fonction de validation de l'adresse e-mail
function validateEmail() {
  // Récupérer les valeurs des champs d'e-mail
  var email = document.getElementById("EMAIL").value;

  // Expression régulière pour la validation de l'adresse e-mail
  var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

  // Vérifier si l'adresse e-mail est valide
  if (emailRegex.test(email)) {
    // Pas d'erreur, effacer le message d'erreur
    document.getElementById("erEMAIL").textContent = "";
  } else {
    // Afficher un message d'erreur
    document.getElementById("erEMAIL").textContent = "Adresse e-mail invalide";
  }

}

// Écouter l'événement blur pour les champs d'e-mail
document.getElementById("EMAIL").addEventListener("blur", validateEmail);
</script>

<!-- approuver que les alphabets -->
<script>
  function validateAlphabets(input) {
    var regex = /^[a-zA-Z\s]+$/;
    return regex.test(input);
}

function validateInput(input) {
    var isValid = validateAlphabets(input.value);
    if (!isValid) {
        input.value = input.value.replace(/[^a-zA-Z\s]/g, '');
    }
}
</script>

<script type="text/javascript">

  $('#TEL2').on('input change',function()
{                                                             //gestion des input telephone
  $(this).val($(this).val().replace(/[^0-9]*$/gi, ''));
  $(this).val($(this).val().replace(' ', ''));
  if ($(this).val().length == 11 || $(this).val().length == 8)
  {
    $('#error_tel').text('')
    $('[name = "TEL2"]').removeClass('is-invalid').addClass('is-valid');
  }
  else
  {
    $('#error_tel').text('Numéro incorrect');
    $('[name = "TEL2"]').removeClass('is-valid').addClass('is-invalid');
  }
});
</script>
<script>
  function validateNumbersandDotsSlashes(input) {
    var regex = /^[0-9./]+$/;
    return regex.test(input);
}

function validateValues(input) {
    var isValid = validateNumbersandDotsSlashes(input.value);
    if (!isValid) {
        input.value = input.value.replace(/[^0-9./]/g, '');
    }
}
 function validateNumbers(input) {
    var regex = /^[0-9.]+$/;
    return regex.test(input);
}

function validateInfoFolio(input) {
    var isValid = validateNumbers(input.value);
    if (!isValid) {
        input.value = input.value.replace(/[^0-9.]/g, '');
    }
}

</script>
<script>
	function checkFileFormat(fileInput) {
		var filePath = fileInput.value;
		var allowedExtensions = /(\.pdf)$/i;

		if (!allowedExtensions.exec(filePath)) {
			// Réinitialise la valeur du fichier
			fileInput.value = '';
			// Affiche un message d'erreur
			document.getElementById('erpdf').textContent = 'Le format de fichier doit être PDF.';
		} else {
			// Efface le message d'erreur
			document.getElementById('erpdf').textContent = '';
		}
	}
</script>
</html>