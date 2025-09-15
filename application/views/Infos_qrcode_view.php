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
                     
                      <h4 class="text-center">Property Management System - Infos du QRCODE</h4><br>
                
                      <br>
                        <div id="message_login"></div>
                <form action="<?= base_url('Login/relais') ?>" method="POST" id="Myform">

                        <fieldset>
                         <center> <?php echo $info_qrcode;?> </center> 
                        </fieldset>
                </form>  


                  </div>

                    <br>
                  
                    

                   <!--   <center>Vous n'avez pas de compte ? <a href="<?= base_url().'Compte'?>">Cliquez ici</a> pour créer un compte</center>
                     <br> -->
                    
                   

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