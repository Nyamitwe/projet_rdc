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
</head>
<body class="inner_page login">
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
<!-- <div class='alert alert-danger text-center'>Une erreur s'est produite, votre certificat est expiré. Veuillez revoir votre boite mail et cliquer sur le lien actualisé</div> -->

<div class='alert alert-danger text-center'>  Une erreur s'est produite, votre certificat est expiré. Veuillez revoir votre boite mail et cliquer sur le lien actualisé </div>

<center><a href="<?= base_url() ?>" class="btn btn-primary">Retour à la page d'accueil</a></center>
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

	function verify2() 
	{
			// myformcompt.submit();
			var form_data = new FormData($("#myformcompt")[0]);
       
            url = "<?= base_url('Audiences/save_data/') ?>";
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'JSON',
                data: form_data,
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    console.log(data)
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Ajout avec succès !',
                        timer: 2000,
                    }).then(() => {
                        // window.location.reload();
                        window.location.href = '<?= base_url()?>';
                    })
                    $("#myformcompt")[0].reset();
                }
            })
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


</html>